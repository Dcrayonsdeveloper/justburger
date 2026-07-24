<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::where('is_active', true);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('postal_code', 'like', "%{$search}%");
            });
        }

        $stores = $query->orderBy('city')->orderBy('name')->get();
        $grouped = $stores->groupBy(fn ($store) => $store->city ?: 'Other');

        return view('restaurants.index', compact('stores', 'grouped', 'search'));
    }

    public function show(Store $store)
    {
        abort_unless($store->is_active, 404);

        $settings = $store->settings ?? [];
        $hours = $settings['hours'] ?? null;
        $facilities = $settings['facilities'] ?? [];

        return view('restaurants.show', compact('store', 'hours', 'facilities'));
    }
}
