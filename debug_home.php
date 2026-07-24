<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\Setting;

$featuredCount = (int) Setting::get('homepage_featured_count', 10);
$bestsellersCount = (int) Setting::get('homepage_bestsellers_count', 10);
$productEager = ['category:id,name,slug', 'brand:id,name,slug', 'primaryImage'];

echo "=== Settings ===\n";
echo "homepage_featured_count: " . Setting::get('homepage_featured_count', '(default 10)') . "\n";
echo "homepage_bestsellers_count: " . Setting::get('homepage_bestsellers_count', '(default 10)') . "\n";

echo "\n=== Featured Products Query ===\n";
try {
    $featuredProducts = Product::query()
        ->where('is_active', true)
        ->where('stock_quantity', '>', 0)
        ->where('is_featured', true)
        ->with($productEager)
        ->orderBy('created_at', 'desc')
        ->take($featuredCount)
        ->get();
    echo "Count: " . $featuredProducts->count() . "\n";
    foreach ($featuredProducts->take(3) as $p) {
        $img = $p->primaryImage;
        echo "  - $p->name (ID:$p->id) img:" . ($img ? $img->url : 'NO IMAGE') . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Bestsellers Query ===\n";
try {
    $bestsellers = Product::query()
        ->where('is_active', true)
        ->where('stock_quantity', '>', 0)
        ->with($productEager)
        ->orderBy('sales_count', 'desc')
        ->take($bestsellersCount)
        ->get();
    echo "Count: " . $bestsellers->count() . "\n";
    foreach ($bestsellers->take(3) as $p) {
        echo "  - $p->name (sales:$p->sales_count)\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Product Card Component ===\n";
$componentPath = resource_path('views/components/product-card.blade.php');
echo "Exists: " . (file_exists($componentPath) ? 'YES' : 'MISSING') . "\n";

echo "\n=== Toppings Modal Component ===\n";
$modalPath = resource_path('views/components/toppings-modal.blade.php');
echo "Exists: " . (file_exists($modalPath) ? 'YES' : 'MISSING') . "\n";

echo "\n=== Check for errors in blade compilation ===\n";
try {
    $blade = app('blade.compiler');
    $blade->compile(resource_path('views/components/product-card.blade.php'));
    echo "product-card.blade.php: Compiles OK\n";
} catch (\Exception $e) {
    echo "product-card.blade.php ERROR: " . $e->getMessage() . "\n";
}
