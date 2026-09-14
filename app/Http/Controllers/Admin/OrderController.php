<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderDelivered;
use App\Events\OrderShipped;
use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request): View|StreamedResponse
    {
        // No cron on this host, so the collection window is applied whenever
        // someone looks at the orders. Cheap, indexed, and idempotent.
        Order::releaseOrdersDueForCollection();

        // Confirmed orders only — paid by card, or placed for payment at the
        // counter. An order row is created the moment checkout starts, so an
        // abandoned card payment leaves a 'pending' row behind that was never
        // bought; that is what this keeps out. A cash order is a real order from
        // the moment the customer is told we are cooking it. See Order::scopeConfirmed().
        $query = Order::confirmed()->with(['user', 'items']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('email', 'like', "%{$request->search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Export sits here rather than on its own route so it inherits every
        // filter applied above: what downloads is exactly the list on screen,
        // not the whole table. The button has always linked to ?export=csv —
        // there was simply nothing answering it, so it re-rendered the page.
        if ($request->get('export') === 'csv') {
            return $this->exportCsv($query);
        }

        $perPage = min((int) $request->input('per_page', 10), 100);
        $orders = $query->latest()->paginate($perPage)->withQueryString();

        // Counted on the same basis as the list above, so the tiles can never
        // total to more orders than the page actually shows.
        $stats = [
            'total' => Order::confirmed()->count(),
            'confirmed' => Order::confirmed()->where('status', 'confirmed')->count(),
            'processing' => Order::confirmed()->whereIn('status', ['processing', 'packed'])->count(),
            'shipped' => Order::confirmed()->whereIn('status', ['shipped', 'out_for_delivery'])->count(),
            'completed' => Order::confirmed()->where('status', 'delivered')->count(),
            'cancelled' => Order::confirmed()->where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Stream the filtered orders as a CSV.
     *
     * Streamed rather than built in memory: a year of orders is far more rows
     * than the page ever shows, and the shop should not have to think about
     * that before clicking Export.
     */
    private function exportCsv(Builder $query): StreamedResponse
    {
        $orders = $query->with(['items', 'user'])->latest()->get();

        $filename = 'orders-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'order_number', 'placed_at', 'customer', 'phone', 'status',
                'payment_status', 'payment_method', 'items', 'item_count',
                'subtotal', 'discount', 'total', 'currency', 'receipt_printed_at', 'notes',
            ]);

            foreach ($orders as $order) {
                // Each line as the kitchen saw it, customisations included — an
                // export that drops them cannot be reconciled against a receipt.
                $items = $order->items->map(function ($item) {
                    $line = $item->quantity . ' x ' . $item->product_name;
                    $opts = $item->toppings_list;

                    $extras = collect($opts['added'] ?? [])->pluck('name')->filter();
                    $without = collect($opts['removed'] ?? [])->pluck('name')->filter();

                    $notes = [];
                    if ($extras->isNotEmpty()) {
                        $notes[] = '+' . $extras->implode(', ');
                    }
                    if ($without->isNotEmpty()) {
                        $notes[] = 'no ' . $without->implode(', ');
                    }

                    return $line . ($notes ? ' (' . implode('; ', $notes) . ')' : '');
                })->implode(' | ');

                fputcsv($handle, [
                    $order->order_number,
                    $order->created_at?->format('Y-m-d H:i'),
                    $order->shipping_address_snapshot['name'] ?? $order->guest_name ?? ($order->user->full_name ?? 'Guest'),
                    $order->shipping_address_snapshot['phone'] ?? $order->guest_phone ?? ($order->user->phone ?? ''),
                    $order->status,
                    $order->payment_status,
                    $order->metadata['payment_method'] ?? '',
                    $items,
                    $order->items->sum('quantity'),
                    $order->subtotal,
                    $order->discount,
                    $order->total,
                    $order->currency,
                    $order->receipt_printed_at?->format('Y-m-d H:i'),
                    $order->notes,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function show(Order $order): View
    {
        // Hidden from the list means unreachable by URL too, otherwise the rule is
        // only cosmetic and a stale bookmark still opens an unpaid order.
        abort_unless($order->hasReachedShop(), 404);

        Order::releaseOrdersDueForCollection();
        $order->refresh();

        $order->load([
            'user',
            'items.product',
            'items.variant',
            'statusHistory',
            'shipments',
            'coupon',
        ]);

        $trackingSteps = $order->getTrackingSteps();
        $latestShipment = $order->shipments->first();

        return view('admin.orders.show', compact('order', 'trackingSteps', 'latestShipment'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::SETTABLE_STATUSES))],
            'comment' => ['nullable', 'string', 'max:500'],
            'carrier' => ['nullable', 'string', 'max:100'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $oldStatus = $order->status;

        // Any valid status can be set directly. The strict step-by-step fulfilment
        // workflow (confirmed -> processing -> ... -> delivered) doesn't fit a
        // collection-based burger shop, so there's no transition gate — the admin
        // picks a status and it's applied.

        // If shipping, create shipment record
        if ($validated['status'] === 'shipped' && !empty($validated['tracking_number'])) {
            $order->shipments()->create([
                'carrier' => $validated['carrier'],
                'tracking_number' => $validated['tracking_number'],
                'status' => 'in_transit',
                'shipped_at' => now(),
            ]);
        }

        // Update shipment status for out_for_delivery and delivered
        if (in_array($validated['status'], ['out_for_delivery', 'delivered'])) {
            $shipment = $order->shipments()->latest()->first();
            if ($shipment) {
                $shipmentStatus = $validated['status'] === 'out_for_delivery' ? 'out_for_delivery' : 'delivered';
                $shipment->update(['status' => $shipmentStatus]);
                if ($validated['status'] === 'delivered') {
                    $shipment->update(['delivered_at' => now()]);
                }
            }
        }

        $order->updateStatus($validated['status'], auth('admin')->id(), $validated['comment'] ?? null);

        OrderStatusChanged::dispatch($order, $oldStatus, $validated['status']);

        if ($validated['status'] === 'shipped') {
            OrderShipped::dispatch($order, $validated['tracking_number'] ?? null);
        } elseif ($validated['status'] === 'delivered') {
            OrderDelivered::dispatch($order);
        }

        return back()->with('success', "Order status updated from {$oldStatus} to {$validated['status']}");
    }

    public function ship(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'carrier' => ['required', 'string', 'max:100'],
            'tracking_number' => ['required', 'string', 'max:100'],
        ]);

        $order->shipments()->create([
            'carrier' => $validated['carrier'],
            'tracking_number' => $validated['tracking_number'],
            'status' => 'in_transit',
            'shipped_at' => now(),
        ]);

        $order->updateStatus('shipped', auth('admin')->id(), "Shipped via {$validated['carrier']} - Tracking: {$validated['tracking_number']}");

        OrderShipped::dispatch($order, $validated['tracking_number']);

        return back()->with('success', 'Order marked as shipped');
    }

    public function invoice(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.invoice', compact('order'));
    }

    public function packingSlip(Order $order): View
    {
        $order->load(['items.product']);

        return view('admin.orders.packing-slip', compact('order'));
    }

    public function receipt(Order $order): View
    {
        $order->load(['items.product', 'payments']);

        return view('orders.receipt', [
            'order' => $order,
            'backUrl' => route('admin.orders.show', $order),
        ]);
    }

    /**
     * Delete the orders ticked in the list.
     *
     * Orders are not soft-deleted, so this is permanent — every child row
     * (items, payments, status history, commissions) goes with it via the
     * cascading foreign keys. The list warns before submitting.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:orders,id'],
        ]);

        $count = 0;

        DB::transaction(function () use ($validated, &$count) {
            // Deleted one at a time rather than in a single mass delete so the
            // model's own delete path still runs for each order.
            foreach (Order::whereIn('id', $validated['ids'])->get() as $order) {
                $order->delete();
                $count++;
            }
        });

        return back()->with('success', $count . ' ' . Str::plural('order', $count) . ' deleted.');
    }
}
