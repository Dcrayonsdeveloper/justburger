<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Seeds the real Just Burgers menu — exact names, descriptions, prices and
 * Reg/Large sizes — into the 10 live categories, replacing the placeholder
 * products.
 *
 * Run with:  php artisan db:seed --class=JustBurgersMenuSeeder --force
 *
 * Items with two prices get size variants (e.g. Regular/Large). Single-price
 * items get no variants (so no size toggle shows on the storefront).
 */
class JustBurgersMenuSeeder extends Seeder
{
    public function run(): void
    {
        $catIds = DB::table('categories')->pluck('id', 'slug');
        $brandId = DB::table('brands')->value('id');
        $now = now();

        // ── 1. Remove the placeholder products + their dependent rows ──
        // (Verified: 0 orders / 0 order_items reference products.)
        Schema::disableForeignKeyConstraints();
        foreach ([
            'cart_items', 'product_topping', 'product_variants', 'product_images',
            'reviews', 'review_images', 'product_reviews', 'wishlists', 'wishlist_items',
            'product_questions', 'recently_viewed', 'search_logs',
        ] as $t) {
            if (Schema::hasTable($t)) {
                DB::table($t)->delete();
            }
        }
        DB::table('products')->delete();
        Schema::enableForeignKeyConstraints();

        // ── 2. Build the menu ──
        $skuNum = 1;
        $created = 0;
        $variants = 0;

        foreach ($this->menu() as $categorySlug => $items) {
            $categoryId = $catIds[$categorySlug] ?? null;
            if (! $categoryId) {
                $this->command->warn("Category '{$categorySlug}' not found — skipping its items.");
                continue;
            }

            foreach ($items as $item) {
                $sku = 'JB-'.str_pad((string) $skuNum++, 3, '0', STR_PAD_LEFT);
                $price = (float) $item['price'];

                $productId = DB::table('products')->insertGetId([
                    'uuid'                => (string) Str::uuid(),
                    'seller_id'           => null,
                    'brand_id'            => $brandId,
                    'category_id'         => $categoryId,
                    'name'                => $item['name'],
                    'slug'                => $this->uniqueSlug($item['name']),
                    'short_description'   => $item['desc'] ?? null,
                    'description'         => $item['desc'] ?? $item['name'],
                    'sku'                 => $sku,
                    'barcode'             => null,
                    'mrp'                 => $price,
                    'price'               => $price,
                    'cost_price'          => round($price * 0.40, 2),
                    'stock_quantity'      => 999,
                    'low_stock_threshold' => 10,
                    'stock_status'        => 'in_stock',
                    'weight'              => null,
                    'weight_unit'         => 'g',
                    'dimension_unit'      => 'cm',
                    'is_active'           => true,
                    'is_featured'         => $item['featured'] ?? false,
                    'is_taxable'          => true,
                    'tax_rate'            => 20.00,
                    'rating'              => 0,
                    'review_count'        => 0,
                    'view_count'          => 0,
                    'sales_count'         => 0,
                    'wishlist_count'      => 0,
                    'status'              => 'approved',
                    'published_at'        => $now,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);
                $created++;

                // Size variants (only when the item has 2+ prices).
                if (! empty($item['sizes'])) {
                    foreach ($item['sizes'] as $variantName => $variantPrice) {
                        DB::table('product_variants')->insert([
                            'product_id'     => $productId,
                            'name'           => $variantName,
                            'sku'            => $sku.'-'.strtoupper(Str::slug($variantName)),
                            'barcode'        => null,
                            'mrp'            => (float) $variantPrice,
                            'price'          => (float) $variantPrice,
                            'stock_quantity' => 999,
                            'attributes'     => null,
                            'is_active'      => true,
                            'created_at'     => $now,
                            'updated_at'     => $now,
                        ]);
                        $variants++;
                    }
                }
            }
        }

        $this->command->info("Just Burgers menu seeded: {$created} products, {$variants} size variants.");
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (DB::table('products')->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * The menu, keyed by category slug. Each item: name, desc, price (Regular/base),
     * optional sizes [variantName => price], optional featured.
     */
    private function menu(): array
    {
        $R = fn ($reg, $large) => ['Regular' => $reg, 'Large' => $large];

        return [
            'burgers' => [
                ['name' => 'CHEESE with Fries', 'desc' => '2 slices of melted cheese', 'price' => 6.90, 'sizes' => $R(6.90, 8.20), 'featured' => true],
                ['name' => 'GARLIC with Fries', 'desc' => 'Unsociable, but irresistible garlic mayo & lettuce', 'price' => 6.90, 'sizes' => $R(6.90, 8.20)],
                ['name' => 'CHILLI with Fries', 'desc' => 'Fiery sauce', 'price' => 6.90, 'sizes' => $R(6.90, 8.20)],
                ['name' => 'BARBECUE with Fries', 'desc' => 'Drenched in barbecue sauce', 'price' => 6.90, 'sizes' => $R(6.90, 8.20)],
                ['name' => 'MEXICAN with Fries', 'desc' => 'Cheese, lettuce, raw onions, chillies with our own chilli sauce', 'price' => 7.20, 'sizes' => $R(7.20, 8.50), 'featured' => true],
                ['name' => 'ORLEANS with Fries', 'desc' => 'Cheese, lettuce, raw onions with our own spicy mayo', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'YANKEE with Fries', 'desc' => 'Cheese, salad & mayonnaise', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'BRONX with Fries', 'desc' => 'Cheese, pepperoni, raw onions, mild American mustard & ketchup', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'HAWAIIAN with Fries', 'desc' => 'Juicy pineapple, cheese & lettuce', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'LOUISANA with Fries', 'desc' => 'Crunchy coleslaw, cheese, lettuce, tomato', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'NEVADA with Fries', 'desc' => 'Bacon, gherkins, fried onions, cheese, lettuce & mayo', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'MALIBU with Fries', 'desc' => 'Prawns in seafood sauce & lettuce', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'MANHATTAN with Fries', 'desc' => 'Bacon, melted cheese & mayo. Double bacon £1 extra', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'NASHVILLE with Fries', 'desc' => 'Mushrooms, melted cheese & mayonnaise', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'MONSTER with Fries', 'desc' => 'Bacon, cheese, onions, lettuce & tomato. Add smoky texan or burger sauce if requested. Mega Monster 12oz add £2 to 8oz price, includes triple cheese', 'price' => 7.50, 'sizes' => $R(7.50, 8.80), 'featured' => true],
                ['name' => 'NEW YORKER SMASH with Fries', 'desc' => 'Smashed beef pattie, slice of melted cheese, mushrooms, fried onions & mayonnaise with lots of chips', 'price' => 7.50, 'sizes' => $R(7.50, 8.80), 'featured' => true],
                ['name' => 'CALIFORNIA DREAMER with Fries', 'desc' => 'Smashed burger, cheese, bacon, fried onions, burger sauce', 'price' => 7.50, 'sizes' => $R(7.50, 8.80), 'featured' => true],
                ['name' => 'LA SMASH with Fries', 'desc' => 'Smashed burger, 2 slices of cheese, fried onions + ketchup + mustard', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'FISH BURGER with Fries', 'desc' => 'Cod fillet topped with tartare sauce & lettuce', 'price' => 7.00, 'sizes' => null],
                ['name' => 'RIBS with Fries', 'desc' => 'Drenched in BBQ sauce', 'price' => 8.80, 'sizes' => null],
            ],

            'chicken-fillet-burgers-with-fries' => [
                ['name' => 'DIXIE', 'desc' => 'Mayonnaise or garlic mayonnaise & lettuce', 'price' => 6.90, 'sizes' => $R(6.90, 8.10), 'featured' => true],
                ['name' => 'EASTSIDE', 'desc' => "Sweet 'n' sour sauce, lettuce & green peppers", 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'WESTSIDE', 'desc' => 'Pineapple, mayonnaise & lettuce', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'SOUTHSIDE', 'desc' => 'Spicy combination of chilli sauce, onions, lettuce & cheese', 'price' => 7.20, 'sizes' => $R(7.20, 8.50)],
                ['name' => 'NORTHSIDE', 'desc' => 'Cheese, lettuce, hash brown with chipotle sauce', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
                ['name' => 'CHICKEN MONSTER', 'desc' => 'Bacon, cheese, onions, lettuce & tomato. Add smoky Texan sauce or mayo if requested', 'price' => 7.50, 'sizes' => $R(7.50, 8.80), 'featured' => true],
                ['name' => 'HELLFIRE', 'desc' => 'Hot & spicy fillet with cheese, jalapeno, lettuce, mayonaise and red hot sauce', 'price' => 7.50, 'sizes' => $R(7.50, 8.80), 'featured' => true],
                ['name' => 'MIAMI HOT with Fries', 'desc' => 'Crispy hot battered filler burger with cheese and crispy streaky bacon with spicy mayo and lettuce', 'price' => 7.50, 'sizes' => $R(7.50, 8.80)],
            ],

            'chicken-strips' => [
                ['name' => 'STRIPS with Fries', 'desc' => '5 chicken breast strips, served with fries or salad & 1 dip', 'price' => 7.50, 'sizes' => null],
                ['name' => 'STRIP COMBO with Fries', 'desc' => '4 chicken breast strips, 4 onion rings, served with fries or ½ fries and ½ salad & 1 dip', 'price' => 7.50, 'sizes' => null],
                ['name' => 'EXTRA STRIPS (no fries)', 'desc' => 'Choose 5 strips & 1 dip, or 8 strips & 2 dips', 'price' => 6.20, 'sizes' => ['5 & 1 Dip' => 6.20, '8 & 2 Dips' => 9.10]],
            ],

            'vegetarian' => [
                ['name' => 'SOYA BURGER with Fries', 'desc' => 'With cheese, salad and mayonnaise', 'price' => 7.00, 'sizes' => null],
                ['name' => 'HALLOUMI CHEESE GRILLED BURGER with Fries', 'desc' => 'Halloumi, lettuce, onions, tomato, cucumber, with sweet chili or burger sauce', 'price' => 7.00, 'sizes' => null],
                ['name' => 'SPICY BEAN BURGER with Fries', 'desc' => 'Soya beans, cheese, lettuce, tomatoes, onion, with mayonnaise', 'price' => 7.00, 'sizes' => null],
            ],

            'kids' => [
                ['name' => 'Chicken Nuggets with Fries (6 Pcs)', 'desc' => '6 pieces, served with fries', 'price' => 4.60, 'sizes' => null],
                ['name' => '3 Mozzarella Cheese Melts', 'desc' => 'Fries or salad & dip', 'price' => 4.60, 'sizes' => null],
                ['name' => 'Cheese Burger with Fries', 'desc' => 'Kids cheese burger, served with fries', 'price' => 4.60, 'sizes' => null],
                ['name' => 'Salad Burger with Fries', 'desc' => 'Kids salad burger, served with fries', 'price' => 4.60, 'sizes' => null],
                ['name' => '3 Chicken Strips with Fries & Dip', 'desc' => '3 chicken strips, served with fries & dip', 'price' => 4.60, 'sizes' => null],
                ['name' => 'Chicken Mayo Burger (Not Fillet) with Fries', 'desc' => 'Chicken mayo burger (not fillet), served with fries', 'price' => 4.60, 'sizes' => null],
            ],

            'kebab-wraps' => [
                ['name' => 'Lamb Grill Kebab', 'desc' => 'In tortilla wrap with lettuce, tomato, cucumber, onion & mint sauce', 'price' => 7.00, 'sizes' => null, 'featured' => true],
                ['name' => 'Chicken Grill Kebab', 'desc' => 'In tortilla wrap with lettuce, tomato, cucumber, onion & mint sauce', 'price' => 7.00, 'sizes' => null],
            ],

            'family-meal' => [
                ['name' => 'REGULAR FAMILY MEAL', 'desc' => '12 chicken strips, 4 regular chips, 1 reg popcorn chicken, 8 onion rings, 1.25L Coke/Pepsi, 4 dips', 'price' => 20.00, 'sizes' => null, 'featured' => true],
            ],

            'chicken-wings' => [
                ['name' => 'CHICKEN WINGS', 'desc' => 'Crispy chicken wings. Flavours: Texan Smoky BBQ, Mango Habanero, Devil Hot, Mild Kick, or Lemon & Herbs', 'price' => 4.99, 'sizes' => ['6 Wings' => 4.99, '10 Wings' => 7.99], 'featured' => true],
            ],

            'milkshakes' => [
                ['name' => 'Strawberry Delight', 'desc' => 'Topped with cream', 'price' => 5.00, 'sizes' => null],
                ['name' => 'Biscoff Dream - Lotus Biscoff', 'desc' => 'Topped with cream + caramel sauce', 'price' => 5.00, 'sizes' => null, 'featured' => true],
                ['name' => 'Choco Choco', 'desc' => 'With cream + chocolate sauce', 'price' => 5.00, 'sizes' => null],
                ['name' => 'Oreo Deluxe', 'desc' => 'With cream + chocolate sauce', 'price' => 5.00, 'sizes' => null, 'featured' => true],
                ['name' => 'Kinder Deluxe', 'desc' => 'With cream + caramel sauce', 'price' => 5.00, 'sizes' => null],
                ['name' => 'Vanilla Classic', 'desc' => 'Vanilla shake', 'price' => 5.00, 'sizes' => null],
                ['name' => 'Marvellous Mango', 'desc' => 'Topped with cream + mango sauce', 'price' => 5.00, 'sizes' => null],
                ['name' => 'Brilliant Banana', 'desc' => 'Topped with cream', 'price' => 5.00, 'sizes' => null],
            ],

            'extras' => [
                ['name' => 'Poppin Chicken', 'desc' => 'Crispy popcorn chicken', 'price' => 3.20, 'sizes' => $R(3.20, 4.20)],
                ['name' => 'Chilli Cheese Nuggets', 'desc' => '8 pieces', 'price' => 4.20, 'sizes' => null],
                ['name' => 'Chicken Nuggets', 'desc' => '20 pieces', 'price' => 6.90, 'sizes' => null],
                ['name' => 'Onion Rings (8)', 'desc' => '8 crispy battered onion rings', 'price' => 2.80, 'sizes' => null],
                ['name' => 'Crispy Garlic Mushrooms', 'desc' => 'Crispy garlic mushrooms', 'price' => 3.40, 'sizes' => null],
                ['name' => 'Fries', 'desc' => 'Crispy golden fries', 'price' => 2.80, 'sizes' => $R(2.80, 3.40)],
                ['name' => 'Cheesy Fries', 'desc' => 'Fries topped with melted cheese', 'price' => 3.90, 'sizes' => null],
                ['name' => 'Curly Fries', 'desc' => 'Seasoned curly fries', 'price' => 3.90, 'sizes' => null],
                ['name' => 'Side Salad', 'desc' => 'Fresh side salad', 'price' => 3.50, 'sizes' => null],
                ['name' => 'Prawn Salad', 'desc' => 'Prawn salad', 'price' => 6.20, 'sizes' => null],
                ['name' => 'Tubs', 'desc' => 'Mayo, Garlic Mayo, Chilli, BBQ, Burger Sauce or Chipotle', 'price' => 1.00, 'sizes' => null],
                ['name' => 'Soft Drinks', 'desc' => '330ml can', 'price' => 1.10, 'sizes' => null],
                ['name' => 'Water', 'desc' => '500ml', 'price' => 1.00, 'sizes' => null],
                ['name' => 'Pepsi / Coca-Cola Bottle', 'desc' => 'Pepsi 2.25L or Coca-Cola 1.75L', 'price' => 2.80, 'sizes' => null],
                ['name' => 'Ice Cream', 'desc' => "Ben & Jerry's, 100ml", 'price' => 2.10, 'sizes' => null],
                ['name' => 'Extra Dip Pot', 'desc' => 'Mayonnaise, Barbecue, Tomato Ketchup, Garlic & Herb or Chilli Sauce — 50p each', 'price' => 0.50, 'sizes' => null],
            ],
        ];
    }
}
