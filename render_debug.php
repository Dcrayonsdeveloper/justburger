<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Clear log first
file_put_contents(__DIR__ . '/storage/logs/laravel.log', '');

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/', 'GET')
);
$html = $response->getContent();

echo "Status: " . $response->getStatusCode() . "\n";
echo "Length: " . strlen($html) . "\n";
echo "fpTrack: " . (str_contains($html, 'fpTrack') ? 'YES' : 'NO') . "\n";
echo "bsTrack: " . (str_contains($html, 'bsTrack') ? 'YES' : 'NO') . "\n";

// Check errors
$log = file_get_contents(__DIR__ . '/storage/logs/laravel.log');
if ($log) {
    echo "\n=== ERRORS DURING RENDER ===\n";
    echo substr($log, 0, 3000) . "\n";
} else {
    echo "\nNo errors in log\n";
}

$kernel->terminate($request, $response);
