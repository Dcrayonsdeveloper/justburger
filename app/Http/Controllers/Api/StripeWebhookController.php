<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\StripeOrderService;
use App\Services\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * POST /api/webhook/stripe — the reliable, server-to-server source of truth for
 * Stripe payment state. Signature is verified against the RAW request body.
 *
 * Configure the endpoint URL + signing secret in the Stripe Dashboard:
 *   Developers → Webhooks → Add endpoint → https://justburgers.com/api/webhook/stripe
 * Events: checkout.session.completed, payment_intent.succeeded,
 *         payment_intent.payment_failed, charge.refunded
 */
class StripeWebhookController extends Controller
{
    public function __construct(
        private StripeService $stripe,
        private StripeOrderService $orders,
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();

        if (!$this->stripe->verifyWebhookSignature($payload, $request->header('Stripe-Signature'))) {
            Log::warning('Stripe webhook: signature verification failed');
            return response()->json(['error' => 'invalid signature'], 400);
        }

        $event = json_decode($payload, true);
        $type = $event['type'] ?? 'unknown';
        $object = $event['data']['object'] ?? [];

        Log::info('Stripe webhook received', ['type' => $type, 'id' => $event['id'] ?? null]);

        match ($type) {
            'checkout.session.completed'     => $this->handleCheckoutCompleted($object),
            'payment_intent.succeeded'       => $this->handlePaymentIntentSucceeded($object),
            'payment_intent.payment_failed'  => $this->handlePaymentFailed($object),
            'charge.refunded'                => $this->handleRefund($object),
            default                          => Log::info('Stripe webhook: unhandled event', ['type' => $type]),
        };

        // Always 200 quickly so Stripe doesn't retry a handled event.
        return response()->json(['received' => true]);
    }

    /** @param array<string,mixed> $session */
    private function handleCheckoutCompleted(array $session): void
    {
        if (($session['payment_status'] ?? null) !== 'paid') {
            return; // async method still processing; payment_intent.succeeded will follow
        }

        if ($order = $this->resolveOrder($session)) {
            $this->orders->confirm($order, $session);
        }
    }

    /** @param array<string,mixed> $paymentIntent */
    private function handlePaymentIntentSucceeded(array $paymentIntent): void
    {
        // Redundant with checkout.session.completed but idempotent — belt and suspenders.
        if ($order = $this->resolveOrder($paymentIntent)) {
            $this->orders->confirm($order, $paymentIntent);
        }
    }

    /** @param array<string,mixed> $paymentIntent */
    private function handlePaymentFailed(array $paymentIntent): void
    {
        $order = $this->resolveOrder($paymentIntent);
        if (!$order || $order->payment_status === 'paid') {
            return;
        }

        $order->update(['payment_status' => 'failed']);
        Log::info('Stripe: payment failed', [
            'order_id' => $order->id,
            'reason'   => $paymentIntent['last_payment_error']['message'] ?? 'unknown',
        ]);
    }

    /** @param array<string,mixed> $charge */
    private function handleRefund(array $charge): void
    {
        $paymentIntentId = $charge['payment_intent'] ?? null;
        if (!$paymentIntentId) {
            return;
        }

        $payment = Payment::where('gateway', 'stripe')
            ->where('gateway_transaction_id', $paymentIntentId)
            ->first();

        if (!$payment) {
            Log::warning('Stripe: refund for unknown payment', ['payment_intent' => $paymentIntentId]);
            return;
        }

        // amount_refunded is cumulative on the charge; record only the newly refunded delta.
        $refundedTotal = ($charge['amount_refunded'] ?? 0) / 100;
        $alreadyRecorded = (float) $payment->order->refunds()->where('status', 'completed')->sum('amount');
        $newAmount = round($refundedTotal - $alreadyRecorded, 2);

        if ($newAmount <= 0) {
            return;
        }

        $isFull = $refundedTotal >= (float) $payment->amount;

        $payment->refunds()->create([
            'order_id'          => $payment->order_id,
            'amount'            => $newAmount,
            'type'              => $isFull ? 'full' : 'partial',
            'status'            => 'completed',
            'reason'            => 'Refunded via Stripe',
            'gateway_refund_id' => $charge['id'] ?? null,
            'gateway_response'  => $charge,
            'processed_at'      => now(),
        ]);

        $payment->order->update([
            'payment_status' => $isFull ? 'refunded' : 'partial_refund',
        ]);

        Log::info('Stripe: refund recorded', [
            'order_id' => $payment->order_id,
            'amount'   => $newAmount,
            'full'     => $isFull,
        ]);
    }

    /**
     * We stamp our local order id into Stripe metadata at session creation, so the
     * webhook correlates directly by primary key — no JSON scanning required.
     *
     * @param array<string,mixed> $object
     */
    private function resolveOrder(array $object): ?Order
    {
        $orderId = $object['metadata']['order_id'] ?? ($object['client_reference_id'] ?? null);

        if (!$orderId) {
            Log::warning('Stripe webhook: no order_id in metadata', ['object' => $object['object'] ?? null]);
            return null;
        }

        $order = Order::find($orderId);
        if (!$order) {
            Log::warning('Stripe webhook: order not found', ['order_id' => $orderId]);
        }

        return $order;
    }
}
