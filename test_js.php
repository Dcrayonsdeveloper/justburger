<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::create('/', 'GET'));
$html = $response->getContent();

echo "Has Alpine: " . (str_contains($html, 'Alpine') ? 'YES' : 'NO') . "\n";
echo "Has axios: " . (str_contains($html, 'axios') ? 'YES' : 'NO') . "\n";
echo "Has toppingsModal store: " . (str_contains($html, 'toppingsModal') ? 'YES' : 'NO') . "\n";
echo "Has x-cloak style: " . (str_contains($html, 'x-cloak') ? 'YES' : 'NO') . "\n";
echo "Has cart store: " . (str_contains($html, "Alpine.store('cart')") || str_contains($html, '$store.cart') ? 'YES' : 'NO') . "\n";

// Check if the toppings modal section has proper z-index
preg_match('/toppings-modal.*?class="fixed inset-0 z-(\d+)"/s', $html, $m);
echo "Toppings modal z-index: " . ($m[1] ?? 'NOT FOUND') . "\n";

// Check cart sidebar z-index
preg_match('/cart-sidebar.*?z-(\d+)/s', $html, $m2);
echo "Cart sidebar z-index: " . ($m2[1] ?? 'NOT FOUND') . "\n";

// Check if CSRF token exists
echo "Has csrf-token meta: " . (str_contains($html, 'csrf-token') ? 'YES' : 'NO') . "\n";

$kernel->terminate(Illuminate\Http\Request::create('/', 'GET'), $response);
