<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "product_topping records: " . DB::table('product_topping')->count() . "\n";
echo "Products with toppings: " . DB::table('product_topping')->distinct('product_id')->count('product_id') . "\n";
echo "Active toppings: " . DB::table('toppings')->where('is_active', 1)->count() . "\n";

echo "\nSample pivot data:\n";
$pivots = DB::table('product_topping')->limit(5)->get();
foreach ($pivots as $p) {
    echo "  product_id=$p->product_id, topping_id=$p->topping_id, is_default=$p->is_default\n";
}

echo "\nCartController has toppings: ";
$cc = file_get_contents(__DIR__ . '/app/Http/Controllers/CartController.php');
echo (str_contains($cc, 'toppings_added') ? 'YES' : 'NO') . "\n";

echo "\nHomepage button check:\n";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$resp = $kernel->handle(Illuminate\Http\Request::create('/', 'GET'));
$html = $resp->getContent();
preg_match_all('/toppingsModal\.open\((\d+)/', $html, $m);
echo "Buttons with toppingsModal.open(): " . count($m[1]) . "\n";
if (count($m[1]) > 0) {
    echo "Sample IDs: " . implode(', ', array_slice(array_unique($m[1]), 0, 5)) . "\n";
}
