<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check product image paths
echo "=== Product Image URLs ===\n";
$images = DB::table('product_images')->limit(10)->get();
foreach ($images as $img) {
    $path = public_path($img->image_url);
    $exists = file_exists($path) ? 'EXISTS' : 'MISSING';
    echo "$exists: $img->image_url\n";
}

echo "\n=== Category Images ===\n";
$cats = DB::table('categories')->where('is_active', 1)->get();
foreach ($cats as $cat) {
    if ($cat->image_url) {
        $path = public_path($cat->image_url);
        $exists = file_exists($path) ? 'EXISTS' : 'MISSING';
        echo "$exists: $cat->image_url ($cat->name)\n";
    } else {
        echo "NO IMAGE: $cat->name\n";
    }
}

echo "\n=== Banner Images ===\n";
$banners = DB::table('banners')->get();
foreach ($banners as $b) {
    $path = public_path($b->image_url);
    $exists = file_exists($path) ? 'EXISTS' : 'MISSING';
    echo "$exists: $b->image_url ($b->name)\n";
}

echo "\n=== Homepage Section Images ===\n";
$sections = DB::table('homepage_sections')->get();
foreach ($sections as $s) {
    if ($s->image_url) {
        $path = public_path($s->image_url);
        $exists = file_exists($path) ? 'EXISTS' : 'MISSING';
        echo "$exists: $s->image_url ($s->key)\n";
    }
}
