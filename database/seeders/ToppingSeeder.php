<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Topping;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ToppingSeeder extends Seeder
{
    public function run(): void
    {
        $toppings = [
            // Veggies
            ['name' => 'Lettuce', 'group' => 'veggies', 'price' => 0, 'position' => 1],
            ['name' => 'Tomato', 'group' => 'veggies', 'price' => 0, 'position' => 2],
            ['name' => 'Onion', 'group' => 'veggies', 'price' => 0, 'position' => 3],
            ['name' => 'Pickles', 'group' => 'veggies', 'price' => 0, 'position' => 4],
            ['name' => 'Jalapeños', 'group' => 'veggies', 'price' => 0.50, 'position' => 5],

            // Cheese
            ['name' => 'American Cheese', 'group' => 'cheese', 'price' => 0.50, 'position' => 6],
            ['name' => 'Cheddar Cheese', 'group' => 'cheese', 'price' => 0.50, 'position' => 7],
            ['name' => 'Swiss Cheese', 'group' => 'cheese', 'price' => 0.75, 'position' => 8],

            // Sauces
            ['name' => 'Ketchup', 'group' => 'sauce', 'price' => 0, 'position' => 9],
            ['name' => 'Mayonnaise', 'group' => 'sauce', 'price' => 0, 'position' => 10],
            ['name' => 'Mustard', 'group' => 'sauce', 'price' => 0, 'position' => 11],
            ['name' => 'BBQ Sauce', 'group' => 'sauce', 'price' => 0, 'position' => 12],
            ['name' => 'Hot Sauce', 'group' => 'sauce', 'price' => 0, 'position' => 13],

            // Extras
            ['name' => 'Bacon', 'group' => 'extras', 'price' => 1.50, 'position' => 14],
            ['name' => 'Fried Egg', 'group' => 'extras', 'price' => 1.00, 'position' => 15],
            ['name' => 'Extra Patty', 'group' => 'extras', 'price' => 2.50, 'position' => 16],
            ['name' => 'Avocado', 'group' => 'extras', 'price' => 1.50, 'position' => 17],
            ['name' => 'Mushrooms', 'group' => 'extras', 'price' => 0.75, 'position' => 18],
        ];

        foreach ($toppings as $data) {
            Topping::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                $data
            );
        }

        // Assign common default toppings to all burger products
        $defaultToppingIds = Topping::whereIn('slug', [
            'lettuce', 'tomato', 'onion', 'ketchup', 'mayonnaise',
        ])->pluck('id')->toArray();

        $optionalToppingIds = Topping::whereNotIn('id', $defaultToppingIds)
            ->pluck('id')->toArray();

        // Attach toppings to burger-related products
        $burgerProducts = Product::where('is_active', true)
            ->whereHas('category', function ($q) {
                $q->where('name', 'like', '%burger%')
                  ->orWhere('slug', 'like', '%burger%')
                  ->orWhere('name', 'like', '%classic%')
                  ->orWhere('name', 'like', '%gourmet%');
            })
            ->get();

        foreach ($burgerProducts as $product) {
            $sync = [];
            foreach ($defaultToppingIds as $id) {
                $sync[$id] = ['is_default' => true];
            }
            foreach ($optionalToppingIds as $id) {
                $sync[$id] = ['is_default' => false];
            }
            $product->toppings()->syncWithoutDetaching($sync);
        }

        $this->command->info('Seeded ' . count($toppings) . ' toppings, assigned to ' . $burgerProducts->count() . ' burger products.');
    }
}
