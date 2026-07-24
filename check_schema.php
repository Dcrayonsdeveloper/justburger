<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = DB::select('DESCRIBE products');
foreach ($cols as $c) {
    echo $c->Field . "\n";
}
