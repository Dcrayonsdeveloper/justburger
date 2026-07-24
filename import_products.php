<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$sql = file_get_contents(__DIR__ . '/products_data.sql');
$statements = array_filter(explode(";\n", $sql));

$success = 0;
$errors = 0;

foreach ($statements as $stmt) {
    $stmt = trim($stmt);
    if (empty($stmt)) continue;
    // Remove trailing semicolon if present
    $stmt = rtrim($stmt, ';');
    try {
        DB::statement($stmt);
        $success++;
    } catch (\Exception $e) {
        $errors++;
        echo "ERROR: " . substr($e->getMessage(), 0, 200) . "\n";
    }
}

echo "\nDone: $success success, $errors errors\n";
echo "Products: " . DB::table('products')->where('is_active', 1)->count() . "\n";
echo "ProductImages: " . DB::table('product_images')->count() . "\n";
