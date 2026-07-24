<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get all active product IDs
$allProducts = DB::table('products')->where('is_active', 1)->pluck('id');
// Get products that already have toppings
$withToppings = DB::table('product_topping')->distinct()->pluck('product_id');
// Products missing toppings
$missing = $allProducts->diff($withToppings);

echo "Total active products: " . $allProducts->count() . "\n";
echo "Already have toppings: " . $withToppings->count() . "\n";
echo "Missing toppings: " . $missing->count() . "\n";

if ($missing->isEmpty()) {
    echo "All products have toppings!\n";
    exit;
}

// Get the topping assignments from an existing product (327) as template
$template = DB::table('product_topping')->where('product_id', 327)->get();
echo "Template toppings from product 327: " . $template->count() . " records\n";

// Assign same toppings to all missing products
$inserts = [];
foreach ($missing as $productId) {
    foreach ($template as $t) {
        $inserts[] = [
            'product_id' => $productId,
            'topping_id' => $t->topping_id,
            'is_default' => $t->is_default,
        ];
    }
}

// Batch insert
foreach (array_chunk($inserts, 500) as $chunk) {
    DB::table('product_topping')->insert($chunk);
}

echo "Inserted " . count($inserts) . " topping assignments\n";
echo "Total product_topping records now: " . DB::table('product_topping')->count() . "\n";
echo "Products with toppings now: " . DB::table('product_topping')->distinct('product_id')->count('product_id') . "\n";
