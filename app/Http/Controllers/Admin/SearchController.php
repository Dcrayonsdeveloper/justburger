<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /** Shortest term worth running a LIKE over. */
    private const MIN_LENGTH = 2;

    /** Most rows to hand back; the UI shows eight. */
    private const LIMIT = 15;

    public function products(Request $request): JsonResponse
    {
        if (($term = $this->term($request)) === null) {
            return response()->json([]);
        }

        // The payload has to carry everything the result row renders - the
        // dropdown shows a price and a thumbnail - and the slug, because
        // Product::getRouteKeyName() is 'slug' and a link built from the id
        // would 404.
        $products = Product::with('primaryImage')
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%");
            })
            ->orderBy('name')
            ->limit(self::LIMIT)
            ->get();

        return response()->json($products->map(fn (Product $p) => [
            'id' => $p->id,
            'slug' => $p->slug,
            'name' => $p->name,
            'price' => (float) $p->price,
            'primary_image_url' => $p->primary_image_url,
        ])->all());
    }

    public function orders(Request $request): JsonResponse
    {
        if (($term = $this->term($request)) === null) {
            return response()->json([]);
        }

        // confirmed() only: an abandoned card checkout leaves an order row
        // behind whose page deliberately 404s, so offering it here would hand
        // someone a dead link.
        $orders = Order::confirmed()
            ->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhere('guest_name', 'like', "%{$term}%")
                  ->orWhere('guest_phone', 'like', "%{$term}%");
            })
            ->latest('id')
            ->limit(self::LIMIT)
            ->get();

        return response()->json($orders->map(fn (Order $o) => [
            'id' => $o->id,
            'order_number' => $o->order_number,
            'total' => (float) $o->total,
            'name' => $o->guest_name ?: ($o->shipping_address_snapshot['name'] ?? ''),
        ])->all());
    }

    public function customers(Request $request): JsonResponse
    {
        if (($term = $this->term($request)) === null) {
            return response()->json([]);
        }

        $customers = User::where('role', 'customer')
            ->where(function ($q) use ($term) {
                $q->where('first_name', 'like', "%{$term}%")
                  ->orWhere('last_name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%");
            })
            ->orderBy('first_name')
            ->limit(self::LIMIT)
            ->get();

        return response()->json($customers->map(fn (User $u) => [
            'id' => $u->id,
            'first_name' => $u->first_name,
            'last_name' => $u->last_name,
            'email' => $u->email,
            'phone' => $u->phone,
        ])->all());
    }

    /**
     * The term, or null when there is nothing worth searching for.
     *
     * The header sends `search`; this used to read `q` alone, so the value was
     * always empty, every query fell under the minimum length, and the box
     * answered "No results" for things that plainly existed. Both names are
     * accepted now so neither side can break the other again.
     */
    private function term(Request $request): ?string
    {
        $term = trim((string) ($request->input('search') ?? $request->input('q') ?? ''));

        return mb_strlen($term) >= self::MIN_LENGTH ? $term : null;
    }
}
