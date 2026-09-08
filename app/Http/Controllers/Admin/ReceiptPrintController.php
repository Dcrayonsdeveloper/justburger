<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Backs the auto-print till.
 *
 * A browser cannot be handed a print job by the server — the shop's printer is
 * behind their router and the site is in a data centre. So an admin page left
 * open does the printing, and these two endpoints are the conversation: "what
 * still needs printing?" and "that one is done".
 */
class ReceiptPrintController extends Controller
{
    /** Never look further back than this, whatever the client asks for. */
    private const MAX_LOOKBACK_MINUTES = 120;

    /** Most receipts to hand back at once, so a quiet till cannot flood the printer. */
    private const MAX_BATCH = 5;

    public function pending(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'since' => ['nullable', 'date'],
        ]);

        // The till sends the moment auto-print was switched on. Anything older is
        // history someone already dealt with — printing it would be noise.
        $floor = now()->subMinutes(self::MAX_LOOKBACK_MINUTES);
        $since = isset($validated['since'])
            ? max($floor->timestamp, strtotime($validated['since']))
            : $floor->timestamp;

        // Confirmed only. A receipt coming off the till is the kitchen's instruction
        // to cook, so an abandoned checkout must never produce one — but a cash
        // order must, or the shop never learns it was placed.
        $orders = Order::confirmed()
            ->whereNull('receipt_printed_at')
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->where('created_at', '>=', date('Y-m-d H:i:s', $since))
            ->orderBy('created_at')
            ->limit(self::MAX_BATCH)
            ->get(['id', 'order_number', 'created_at']);

        return response()->json([
            'orders' => $orders->map(fn (Order $order) => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'receipt_url' => route('admin.orders.receipt', $order),
            ])->all(),
        ]);
    }

    public function markPrinted(Request $request, Order $order): JsonResponse
    {
        // Idempotent: two tills racing on the same order must not double-count,
        // and a retry after a dropped response must not error.
        if ($order->receipt_printed_at === null) {
            $order->forceFill(['receipt_printed_at' => now()])->save();
        }

        return response()->json([
            'printed_at' => $order->receipt_printed_at?->toIso8601String(),
        ]);
    }

    /**
     * A receipt that prints without waiting for a real order.
     *
     * Before a customer's dinner depends on it, the shop needs to prove the whole
     * chain works — Chrome, the driver, the roll width, the cut. This renders the
     * genuine receipt template with stand-in figures and fires print() on load,
     * so what comes off the roll is exactly what a real order will look like.
     * Nothing is saved: the order exists only for the length of this response.
     */
    public function test(): View
    {
        $order = new Order([
            'order_number' => 'TEST-' . now()->format('Hi'),
            'status' => Order::STATUS_PREPARING,
            'payment_status' => 'paid',
            'subtotal' => 14.50,
            'discount' => 0,
            'tax' => 0,
            'shipping_cost' => 0,
            'total' => 14.50,
            'paid_amount' => 14.50,
            'metadata' => ['delivery_method' => 'collection', 'payment_method' => 'card'],
            'shipping_address_snapshot' => ['name' => 'Printer test — not a real order'],
        ]);
        $order->created_at = now();

        // Relations set by hand: an unsaved order has no id to query them with.
        $order->setRelation('items', collect([
            new OrderItem([
                'product_name' => 'Classic Cheeseburger',
                'variant_name' => 'Large · No onions',
                'quantity' => 1,
                'price' => 7.50,
                'total' => 7.50,
            ]),
            new OrderItem([
                'product_name' => 'Loaded Fries',
                'quantity' => 2,
                'price' => 3.50,
                'total' => 7.00,
            ]),
        ]));
        $order->setRelation('payments', collect());

        return view('orders.receipt', [
            'order' => $order,
            'backUrl' => route('admin.orders.index'),
            'isTest' => true,
        ]);
    }
}
