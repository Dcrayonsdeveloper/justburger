<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        // Paid only. A receipt coming off the till is the kitchen's instruction to
        // cook, so an unpaid or abandoned checkout must never produce one.
        $orders = Order::paid()
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
}
