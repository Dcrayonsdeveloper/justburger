<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $perPage = $request->input('per_page', 10);
        $customers = $query->latest()->paginate($perPage)->withQueryString();

        // Stats
        $stats = [
            'total' => User::where('role', 'customer')->count(),
            'active' => User::where('role', 'customer')->where('is_active', true)->count(),
            'new_this_month' => User::where('role', 'customer')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show(User $customer): View
    {
        abort_if(!in_array($customer->role, ['customer']), 404);

        $customer->load(['orders.items', 'addresses', 'reviews']);

        $stats = [
            'total_orders' => $customer->orders->count(),
            'total_spent' => $customer->orders->sum('total'),
            'avg_order_value' => $customer->orders->count() > 0
                ? $customer->orders->sum('total') / $customer->orders->count()
                : 0,
        ];

        $recentOrders = $customer->orders()->with('items')->latest()->take(10)->get();

        return view('admin.customers.show', compact('customer', 'stats', 'recentOrders'));
    }

    public function edit(User $customer): View
    {
        abort_if(!in_array($customer->role, ['customer']), 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        abort_if(!in_array($customer->role, ['customer']), 404);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function toggleStatus(User $customer): RedirectResponse
    {
        abort_if(!in_array($customer->role, ['customer']), 404);

        $customer->update(['is_active' => !$customer->is_active]);

        $status = $customer->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Customer account {$status}.");
    }


    /**
     * Deactivate the customers ticked in the list.
     *
     * A deactivated account stays in the system with its orders intact; the
     * customer simply cannot sign in, and any session they already have is
     * dropped so they are signed out wherever they are logged in right now.
     */
    public function bulkDeactivate(Request $request): RedirectResponse
    {
        $ids = $this->validatedCustomerIds($request);

        $count = User::whereIn('id', $ids)
            ->where('role', 'customer')
            ->update(['is_active' => false]);

        $this->forceLogout($ids);

        return back()->with('success', $count . ' ' . Str::plural('customer', $count) . ' deactivated and signed out.');
    }

    /**
     * Reactivate the customers ticked in the list, so a deactivation can be
     * undone without going into each account.
     */
    public function bulkActivate(Request $request): RedirectResponse
    {
        $ids = $this->validatedCustomerIds($request);

        $count = User::whereIn('id', $ids)
            ->where('role', 'customer')
            ->update(['is_active' => true]);

        return back()->with('success', $count . ' ' . Str::plural('customer', $count) . ' reactivated.');
    }

    /**
     * Delete the customers ticked in the list.
     *
     * Deleted for real, not soft-deleted: the email and phone are unique, so a
     * row left behind would block the same person signing up again. Their past
     * orders are kept — the customer's details are copied onto each order's
     * guest fields first, so the order history stays readable afterwards
     * instead of every one of them turning into an anonymous "Guest".
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $this->validatedCustomerIds($request);

        $count = 0;

        DB::transaction(function () use ($ids, &$count) {
            $customers = User::whereIn('id', $ids)->where('role', 'customer')->get();

            foreach ($customers as $customer) {
                Order::where('user_id', $customer->id)
                    ->whereNull('guest_email')
                    ->update([
                        'guest_email' => $customer->email,
                        'guest_name' => trim($customer->first_name . ' ' . $customer->last_name) ?: $customer->username,
                        'guest_phone' => $customer->phone,
                    ]);

                // orders.user_id is nullOnDelete, so the orders survive.
                $customer->forceDelete();
                $count++;
            }
        });

        $this->forceLogout($ids);

        return back()->with('success', $count . ' ' . Str::plural('customer', $count)
            . ' deleted. Their orders are kept, and they can sign up again with the same details.');
    }

    private function validatedCustomerIds(Request $request): array
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        return array_map('intval', $validated['ids']);
    }

    /**
     * Drop these users' sessions so they are signed out immediately rather than
     * at the end of their session lifetime, and cycle the remember-me token so
     * a saved cookie cannot quietly sign them back in.
     */
    private function forceLogout(array $ids): void
    {
        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))->whereIn('user_id', $ids)->delete();
        }

        User::whereIn('id', $ids)->update(['remember_token' => null]);
    }

    public function orders(User $customer): View
    {
        abort_if(!in_array($customer->role, ['customer']), 404);

        $perPage = request()->input('per_page', 10);
        $orders = $customer->orders()
            ->with('items')
            ->latest()
            ->paginate($perPage)->withQueryString();

        return view('admin.customers.orders', compact('customer', 'orders'));
    }
}
