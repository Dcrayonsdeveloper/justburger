<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            $items = $this->ownedBy(Wishlist::query())
                ->select('id', 'product_id')
                ->get();

            return response()->json(['items' => $items]);
        }

        $wishlistItems = $this->ownedBy(Wishlist::query())
            ->with(['product.category', 'product.primaryImage'])
            ->latest()
            ->paginate(24);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $exists = $this->ownedBy(Wishlist::query())
            ->where('product_id', $product->id)
            ->exists();

        if (!$exists) {
            Wishlist::create($this->ownerAttributes() + [
                'product_id' => $product->id,
            ]);

            // Facebook CAPI: AddToWishlist
            $eventId = AnalyticsService::generateEventId('awl');
            app(AnalyticsService::class)->trackAddToWishlist($product, $request, $eventId);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist',
                'count' => $this->ownedBy(Wishlist::query())->count(),
                'fb_event' => !$exists ? [
                    'event_id' => $eventId ?? null,
                    'content_ids' => [(string) $product->id],
                    'content_name' => $product->name,
                    'content_type' => 'product',
                    'value' => (float) $product->price,
                    'currency' => 'INR',
                ] : null,
            ]);
        }

        return back()->with('success', 'Product added to wishlist.');
    }

    public function destroy(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->ownedBy(Wishlist::query())
            ->where('product_id', $product->id)
            ->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'count' => $this->ownedBy(Wishlist::query())->count(),
            ]);
        }

        return back()->with('success', 'Product removed from wishlist.');
    }

    /**
     * A wishlist belongs to a signed-in user, or to a guest's session - the
     * same split `carts` has always used. Both reads and writes go through
     * here so the two cannot drift apart.
     */
    private function ownedBy($query)
    {
        return auth()->check()
            ? $query->where('user_id', auth()->id())
            : $query->whereNull('user_id')->where('session_id', session()->getId());
    }

    /** The owner columns to stamp on a new row. */
    private function ownerAttributes(): array
    {
        return auth()->check()
            ? ['user_id' => auth()->id(), 'session_id' => null]
            : ['user_id' => null, 'session_id' => session()->getId()];
    }
}
