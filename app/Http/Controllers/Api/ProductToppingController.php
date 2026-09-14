<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductToppingController extends Controller
{
    public function __invoke(Product $product): JsonResponse
    {
        // The Customize toggle on the product is the master switch. With it off
        // the storefront skips the dialog and adds straight to the basket, even
        // if stale topping links are still on the row.
        if (! $product->customize_enabled) {
            return $this->empty($product);
        }

        // Sections this product shows: active globally, and not switched off
        // for this product. A section with no row on the pivot has never been
        // saved against the product, so it stays hidden until someone picks it.
        $disabledGroupIds = $product->toppingGroups()
            ->wherePivot('is_enabled', false)
            ->pluck('topping_groups.id')
            ->all();

        // Only the toppings the admin picked for THIS product are offered (the
        // product_topping pivot). Whether each starts ticked is the per-product
        // is_default flag on that same pivot.
        $toppings = $product->toppings()
            ->where('toppings.is_active', true)
            ->whereNotNull('toppings.topping_group_id')
            ->whereNotIn('toppings.topping_group_id', $disabledGroupIds)
            ->with('toppingGroup')
            ->orderBy('toppings.position')
            ->orderBy('toppings.name')
            ->get()
            ->filter(fn ($t) => $t->toppingGroup?->is_active);

        $sections = $toppings
            ->groupBy('topping_group_id')
            ->map(fn ($items) => [
                'id' => $items->first()->toppingGroup->id,
                'name' => $items->first()->toppingGroup->name,
                'position' => $items->first()->toppingGroup->position,
                'options' => $items->map(fn ($t) => [
                    'id' => $t->id,
                    'name' => $t->name,
                    'price' => (float) $t->price,
                    // Pre-select only decides what starts ticked; the customer
                    // is charged for whatever they leave ticked either way.
                    'preselected' => (bool) $t->pivot->is_default,
                ])->values(),
            ])
            ->sortBy('position')
            ->values();

        // The flat default/optional split the basket payload is still built
        // from, kept in step with the sections above.
        $flat = $sections->flatMap->options;

        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'base_price' => (float) $product->price,
            'variants' => $this->variants($product),
            'sections' => $sections,
            'defaults' => $flat->where('preselected', true)->values(),
            'optionals' => $flat->where('preselected', false)->values(),
            'has_toppings' => $flat->isNotEmpty(),
        ]);
    }

    /**
     * The sizes this item comes in.
     *
     * Only the product page let anyone choose one: every other way into the
     * popup — a card, a listing, the wishlist, a basket recommendation —
     * opened it with no variant, so a customer could never ask for the large.
     */
    private function variants(Product $product): array
    {
        return $product->variants()
            ->where('is_active', true)
            ->orderBy('price')
            ->get()
            ->map(fn ($v) => [
                'id' => $v->id,
                'name' => $v->name,
                'price' => (float) $v->price,
            ])
            ->values()
            ->all();
    }

    private function empty(Product $product): JsonResponse
    {
        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'base_price' => (float) $product->price,
            'variants' => [],
            'sections' => [],
            'defaults' => [],
            'optionals' => [],
            'has_toppings' => false,
        ]);
    }
}
