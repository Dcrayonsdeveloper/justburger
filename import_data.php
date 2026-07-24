<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$sql = file_get_contents(__DIR__ . '/homepage_data.sql');
$statements = array_filter(explode(";\n", $sql));

$success = 0;
$errors = 0;

foreach ($statements as $stmt) {
    $stmt = trim($stmt);
    if (empty($stmt)) continue;
    try {
        DB::statement($stmt);
        $success++;
    } catch (\Exception $e) {
        $errors++;
        echo "ERROR: " . substr($e->getMessage(), 0, 120) . "\n";
    }
}

echo "\nDone: $success success, $errors errors\n";
echo "Banners: " . DB::table('banners')->count() . "\n";
echo "HomeSections: " . DB::table('homepage_sections')->count() . "\n";
echo "Products: " . DB::table('products')->where('is_active', 1)->count() . "\n";
echo "Categories: " . DB::table('categories')->where('is_active', 1)->count() . "\n";
echo "ProductImages: " . DB::table('product_images')->count() . "\n";
