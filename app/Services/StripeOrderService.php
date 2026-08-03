<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\AbandonedCheckout;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Confirms a Stripe-paid order exactly once, regardless of whether the trigger
 * is the webhook (checkout.session.completed / payment_intent.succeeded) or the
 * browser landing on the success page. The pending→paid flip is atomic, so
 * concurrent triggers can't double-dispatch OrderPlaced or double-decrement stock.
 */
class StripeOrderService
{
    /**
     * @param  array<string,mixed>  $stripeObject  Stripe session or payment_intent object.
     * @return bool  true if THIS call performed the confirmation, false if it was already confirmed.
     */
    public function confirm(Order $order, array $stripeObject): bool
    {
        $paymentIntentId = $this->paymentIntentId($stripeObject);
        $currency = strtoupper($stripeObject['currency'] ?? 'GBP');

        $flipped = DB::transaction(function () use ($order, $stripeObject, $paymentIntentId, $currency) {
            // Idempotency gate: only the first caller flips pending/failed → paid.
            $rows = Order::where('id', $order->id)
                ->where('payment_status', '!=', 'paid')
                ->update([
                    'payment_status' => 'paid',
                    'status'         => 'confirmed',
                    'paid_amount'    => $order->total,
                    'confirmed_at'   => now(),
                ]);

            if ($rows === 0) {
                return false;
            }

            $order->refresh();
            $order->loadMissing('items');

            $meta = $order->metadata ?? [];
            $meta['stripe_payment_intent_id'] = $paymentIntentId;
            $order->update(['metadata' => $meta, 'currency' => $currency]);

            // Generic payment record.
            Payment::updateOrCreate(
                ['order_id' => $order->id, 'gateway' => 'stripe'],
                [
                    'gateway_transaction_id' => $paymentIntentId,
                    'method'                 => 'card',
                    'amount'                 => $order->total,
                    'currency'               => $currency,
                    'status'                 => 'captured',
                    'gateway_response'       => $stripeObject,
                    'captured_at'            => now(),
                ]
            );

            $this->decrementStock($order);
            $this->applyCoupon($order);
            $this->redeemLoyalty($order, $meta);
            $this->clearCart($order, $meta);

            return true;
        });

        if ($flipped) {
            OrderPlaced::dispatch($order->refresh(), 'web');
            Log::info('Stripe: order confirmed', ['order_id' => $order->id, 'payment_intent' => $paymentIntentId]);
        }

        return $flipped;
    }

    /**
     * Stripe session objects expose `payment_intent` as an id string; payment_intent
     * objects expose their own `id`. Handle both, plus the (expanded) object form.
     */
    private function paymentIntentId(array $stripeObject): ?string
    {
        $pi = $stripeObject['payment_intent'] ?? ($stripeObject['id'] ?? null);

        if (is_array($pi)) {
            return $pi['id'] ?? null;
        }

        return $pi;
    }

    private function decrementStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $qty = (int) $item->quantity;

            if ($item->variant_id) {
                $ok = DB::table('product_variants')
                    ->where('id', $item->variant_id)
                    ->where('stock_quantity', '>=', $qty)
                    ->update(['stock_quantity' => DB::raw("stock_quantity - {$qty}")]);
            } else {
                $ok = DB::table('products')
                    ->where('id', $item->product_id)
                    ->where('stock_quantity', '>=', $qty)
                    ->update(['stock_quantity' => DB::raw("stock_quantity - {$qty}")]);
            }

            if ($ok) {
                DB::table('products')->where('id', $item->product_id)->increment('sales_count', $qty);
            } else {
                // Rare: sold out during the payment window. Payment already succeeded, so
                // flag for manual review rather than blocking fulfilment.
                Log::warning('Stripe confirm: stock shortfall', [
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity'   => $qty,
                ]);
            }
        }
    }

    private function applyCoupon(Order $order): void
    {
        if (!$order->coupon_id) {
            return;
        }

        $coupon = Coupon::find($order->coupon_id);
        if ($coupon
            && $coupon->is_active
            && (!$coupon->expires_at || $coupon->expires_at >= now())
            && (!$coupon->usage_limit || $coupon->times_used < $coupon->usage_limit)) {
            $coupon->increment('times_used');
        }
    }

    /**
     * Redeem loyalty points the customer chose to spend at checkout. Deferred to
     * confirmation so points are only burned on a paid order. Runs at most once
     * thanks to the pending→paid idempotency gate.
     *
     * @param  array<string,mixed>  $meta
     */
    private function redeemLoyalty(Order $order, array $meta): void
    {
        $points = (int) ($meta['loyalty_points_used'] ?? 0);
        if ($points <= 0 || !$order->user_id) {
            return;
        }

        try {
            $user = $order->user;
            if ($user) {
                app(\App\Services\LoyaltyService::class)->redeem($user, $points, $order);
            }
        } catch (\Throwable $e) {
            Log::error('Stripe confirm: loyalty redemption failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param  array<string,mixed>  $meta
     */
    private function clearCart(Order $order, array $meta): void
    {
        $cartId = $meta['cart_id'] ?? null;
        if (!$cartId) {
            return;
        }

        $cart = Cart::find($cartId);
        if ($cart) {
            $cart->items()->delete();
            $cart->update(['coupon_id' => null, 'discount' => 0]);
        }

        AbandonedCheckout::where('cart_id', $cartId)->update([
            'recovered'    => true,
            'order_id'     => $order->id,
            'recovered_at' => now(),
        ]);
    }
}
