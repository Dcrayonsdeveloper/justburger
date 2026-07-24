<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test toppings API
$response = $kernel->handle(
    Illuminate\Http\Request::create('/api/product/327/toppings', 'GET')
);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Body: " . $response->getContent() . "\n";

// Check if toppings-modal is in the homepage HTML
$homeResp = $kernel->handle(
    Illuminate\Http\Request::create('/', 'GET')
);
$html = $homeResp->getContent();
echo "\nHome has toppings-modal div: " . (str_contains($html, 'x-data="toppingsModal()"') || str_contains($html, 'toppingsModal') ? 'YES' : 'NO') . "\n";
echo "Home has \$store.toppingsModal: " . (str_contains($html, '$store.toppingsModal') ? 'YES' : 'NO') . "\n";

$kernel->terminate($response, $homeResp);
