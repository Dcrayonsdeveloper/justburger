<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check product_images table columns
echo "=== Product Images Columns ===\n";
$cols = DB::select('DESCRIBE product_images');
foreach ($cols as $c) echo $c->Field . "\n";

echo "\n=== Sample product_images rows ===\n";
$rows = DB::table('product_images')->limit(5)->get();
foreach ($rows as $r) {
    echo json_encode($r) . "\n";
}

echo "\n=== Category image_url check ===\n";
$cats = DB::table('categories')->where('is_active', 1)->get();
foreach ($cats as $cat) {
    if ($cat->image_url) {
        $exists = file_exists(public_path($cat->image_url)) ? 'OK' : 'MISSING';
        echo "$exists: $cat->image_url ($cat->name)\n";
    } else {
        echo "NO-IMG: $cat->name\n";
    }
}

echo "\n=== Banner image check ===\n";
$banners = DB::table('banners')->get();
foreach ($banners as $b) {
    $exists = file_exists(public_path($b->image_url)) ? 'OK' : 'MISSING';
    echo "$exists: $b->image_url ($b->name)\n";
}

echo "\n=== Homepage section image check ===\n";
$sections = DB::table('homepage_sections')->get();
foreach ($sections as $s) {
    if ($s->image_url) {
        $exists = file_exists(public_path($s->image_url)) ? 'OK' : 'MISSING';
        echo "$exists: $s->image_url ($s->key)\n";
    }
}

echo "\n=== Product images file check (first 10) ===\n";
$imgs = DB::table('product_images')->limit(10)->get();
$colNames = array_keys((array)$imgs[0]);
echo "Columns: " . implode(', ', $colNames) . "\n";
// Find the column that stores the image path
foreach ($colNames as $col) {
    if (str_contains($col, 'image') || str_contains($col, 'url') || str_contains($col, 'path')) {
        echo "Image column: $col\n";
        foreach ($imgs as $img) {
            $val = $img->$col;
            if ($val) {
                $exists = file_exists(public_path($val)) ? 'OK' : 'MISSING';
                echo "$exists: $val\n";
            }
        }
    }
}
