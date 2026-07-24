<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// 1. Check routes file
echo "=== Route Check ===\n";
$routesContent = file_get_contents(__DIR__ . '/routes/web.php');
preg_match('/.*toppings.*/', $routesContent, $m);
echo "Route definition: " . ($m[0] ?? 'NOT FOUND') . "\n";

// 2. Test API for multiple products
echo "\n=== API Test (first 3 products) ===\n";
$products = DB::table('products')->where('is_active', 1)->limit(3)->pluck('id', 'name');
foreach ($products as $name => $id) {
    $resp = $kernel->handle(Illuminate\Http\Request::create("/api/product/$id/toppings", 'GET'));
    $data = json_decode($resp->getContent(), true);
    $toppingCount = ($data ? count($data['defaults'] ?? []) + count($data['optionals'] ?? []) : 0);
    echo "  Product $id ($name): HTTP " . $resp->getStatusCode() . ", toppings: $toppingCount, has_toppings: " . ($data['has_toppings'] ?? 'N/A') . "\n";
}

// 3. Check product_topping pivot
echo "\n=== product_topping pivot ===\n";
echo "Total pivot records: " . DB::table('product_topping')->count() . "\n";
echo "Products with toppings: " . DB::table('product_topping')->distinct('product_id')->count('product_id') . "\n";

// 4. Check toppings table
echo "\n=== Toppings table ===\n";
echo "Total: " . DB::table('toppings')->count() . "\n";
echo "Active: " . DB::table('toppings')->where('is_active', 1)->count() . "\n";

// 5. Check cart add route
echo "\n=== Cart routes ===\n";
$cartRoutes = file_get_contents(__DIR__ . '/routes/web.php');
preg_match_all('/.*cart.*/', $cartRoutes, $cm);
foreach (($cm[0] ?? []) as $r) echo "  " . trim($r) . "\n";

// 6. Check CartController for toppings support
echo "\n=== CartController toppings support ===\n";
$cartController = file_get_contents(__DIR__ . '/app/Http/Controllers/CartController.php');
echo "Has toppings_added: " . (str_contains($cartController, 'toppings_added') ? 'YES' : 'NO') . "\n";
echo "Has toppings_removed: " . (str_contains($cartController, 'toppings_removed') ? 'YES' : 'NO') . "\n";

// 7. Render homepage, extract a product card's onclick
$resp = $kernel->handle(Illuminate\Http\Request::create('/', 'GET'));
$html = $resp->getContent();
preg_match_all('/toppingsModal\.open\((\d+)/', $html, $matches);
$ids = array_unique($matches[1] ?? []);
echo "\n=== Product IDs in homepage onclick handlers ===\n";
echo "Total buttons: " . count($matches[1] ?? []) . "\n";
echo "Sample IDs: " . implode(', ', array_slice($ids, 0, 5)) . "\n";

$kernel->terminate(Illuminate\Http\Request::create('/', 'GET'), $resp);
