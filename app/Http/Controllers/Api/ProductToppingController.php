<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ProductToppingController extends Controller
{
    public function __invoke(Product $product): JsonResponse
    {
        $product->loadMissing('ingredients');

        // The Customize toggle is the master switch for the shared topping
        // library. Ingredients are not part of that library — they are what
        // this item is made of — so they still get a popup, otherwise typing
        // them on the product would silently do nothing.
        if (! $product->customize_enabled) {
            return $this->respond($product, collect());
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

        return $this->respond($product, $sections);
    }

    /**
     * Build the popup payload: the item's own ingredients first, then whatever
     * sections of the shared topping library apply.
     */
    private function respond(Product $product, Collection $sections): JsonResponse
    {
        // Ingredients lead the popup: they are what the item is already made
        // of, so they arrive ticked and free and the customer can only take one
        // off. Their ids are negated so they cannot collide with a topping id
        // in the basket payload, which keys both by id.
        $ingredients = $product->ingredients->map(fn ($i) => [
            'id' => -$i->id,
            'name' => $i->name,
            'price' => 0.0,
            'preselected' => true,
        ])->values();

        if ($ingredients->isNotEmpty()) {
            $sections = $sections->prepend([
                'id' => 'ingredients',
                'name' => 'Ingredients',
                'position' => -1,
                'options' => $ingredients,
            ]);
        }

        // The flat default/optional split the basket payload is still built
        // from, kept in step with the sections above.
        $flat = $sections->flatMap->options;

        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'sections' => $sections->values(),
            'defaults' => $flat->where('preselected', true)->values(),
            'optionals' => $flat->where('preselected', false)->values(),
            'has_toppings' => $flat->isNotEmpty(),
        ]);
    }
}
