<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\CreditNote;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Recent orders
        $recentOrders = Order::query()
            ->where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Order statistics. This is a collection shop: an order is being
        // prepared, is ready to collect, or was cancelled. The counts used to
        // look for 'confirmed', 'processing' and 'completed' - none of which
        // this app ever sets - so all three showed zero however many orders
        // someone had placed.
        $mine = fn () => Order::where('user_id', $user->id);
        $orderStats = [
            'total' => $mine()->count(),
            'preparing' => $mine()->where('status', Order::STATUS_PREPARING)->count(),
            'ready' => $mine()->where('status', Order::STATUS_READY)->count(),
            'cancelled' => $mine()->where('status', Order::STATUS_CANCELLED)->count(),
        ];

        // Wishlist count
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();

        // Credit/wallet balance from refunds
        $creditBalance = CreditNote::where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->sum('remaining_amount');

        return view('account.dashboard', compact('user', 'recentOrders', 'orderStats', 'wishlistCount', 'creditBalance'));
    }
}
