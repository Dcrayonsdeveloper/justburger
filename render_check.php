<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);
$html = $response->getContent();

echo "Page length: " . strlen($html) . " bytes\n";
echo "Has fpTrack (featured): " . (str_contains($html, 'fpTrack') ? 'YES' : 'NO') . "\n";
echo "Has bsTrack (bestsellers): " . (str_contains($html, 'bsTrack') ? 'YES' : 'NO') . "\n";
echo "Has product-card: " . (str_contains($html, 'product-card') ? 'YES' : 'NO') . "\n";
echo "Has hero-slide: " . (str_contains($html, 'hero-slide') ? 'YES' : 'NO') . "\n";
echo "Has cat-grid (menu): " . (str_contains($html, 'cat-grid') ? 'YES' : 'NO') . "\n";
echo "Has ld-wrap (lunchtime): " . (str_contains($html, 'ld-wrap') ? 'YES' : 'NO') . "\n";
echo "Has op-panel (order): " . (str_contains($html, 'op-panel') ? 'YES' : 'NO') . "\n";
echo "Has newsletter: " . (str_contains($html, 'newsletter') ? 'YES' : 'NO') . "\n";
echo "Has toppings-modal: " . (str_contains($html, 'toppings-modal') ? 'YES' : 'NO') . "\n";

// Check for errors
echo "\nHTTP Status: " . $response->getStatusCode() . "\n";
if (str_contains($html, 'Whoops') || str_contains($html, 'Error') || str_contains($html, 'exception')) {
    // Find error message
    preg_match('/<title>(.*?)<\/title>/s', $html, $m);
    echo "Page title: " . ($m[1] ?? 'N/A') . "\n";
}

$kernel->terminate($request, $response);
