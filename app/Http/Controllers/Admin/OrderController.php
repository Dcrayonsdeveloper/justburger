<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderDelivered;
use App\Events\OrderShipped;
use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        // No cron on this host, so the collection window is applied whenever
        // someone looks at the orders. Cheap, indexed, and idempotent.
        Order::releaseOrdersDueForCollection();

        // Paid orders only. An order row is created the moment checkout starts, so
        // an abandoned card payment leaves a 'pending' order behind that was never
        // bought — those must never reach the shop. The Stripe webhook
        // (StripeOrderService::confirm) flips an order to paid, and that is what
        // admits it here.
        $query = Order::paid()->with(['user', 'items']);

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

        $perPage = min((int) $request->input('per_page', 10), 100);
        $orders = $query->latest()->paginate($perPage)->withQueryString();

        // Counted on the same basis as the list above, so the tiles can never
        // total to more orders than the page actually shows.
        $stats = [
            'total' => Order::paid()->count(),
            'confirmed' => Order::paid()->where('status', 'confirmed')->count(),
            'processing' => Order::paid()->whereIn('status', ['processing', 'packed'])->count(),
            'shipped' => Order::paid()->whereIn('status', ['shipped', 'out_for_delivery'])->count(),
            'completed' => Order::paid()->where('status', 'delivered')->count(),
            'cancelled' => Order::paid()->where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order): View
    {
        // Hidden from the list means unreachable by URL too, otherwise the rule is
        // only cosmetic and a stale bookmark still opens an unpaid order.
        abort_unless($order->payment_status === 'paid', 404);

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
}
