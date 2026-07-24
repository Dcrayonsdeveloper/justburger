<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductToppingController extends Controller
{
    public function __invoke(Product $product): JsonResponse
    {
        $product->load(['toppings' => fn ($q) => $q->active()->ordered()]);

        $defaults = [];
        $optionals = [];

        foreach ($product->toppings as $topping) {
            $item = [
                'id' => $topping->id,
                'name' => $topping->name,
                'price' => (float) $topping->price,
                'group' => $topping->group,
            ];

            if ($topping->pivot->is_default) {
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
