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
            return response()->json([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'defaults' => [],
                'optionals' => [],
                'has_toppings' => false,
            ]);
        }

        $product->load(['toppings' => fn ($q) => $q->active()->ordered()]);

        $defaults = [];
        $optionals = [];

        foreach ($product->toppings as $topping) {
            // Pre-selected toppings are included with the product, so they are
            // never charged — send 0 rather than a price we would not collect.
            $isPreselected = (bool) $topping->is_preselected;

            $item = [
                'id' => $topping->id,
                'name' => $topping->name,
                'price' => $isPreselected ? 0.0 : (float) $topping->price,
                'group' => $topping->group,
            ];

            if ($isPreselected) {
                $defaults[] = $item;
            } else {
                $optionals[] = $item;
            }
        }

        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'defaults' => $defaults,
            'optionals' => $optionals,
            'has_toppings' => count($defaults) + count($optionals) > 0,
        ]);
    }
}
