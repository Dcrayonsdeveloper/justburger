<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per-item notes: "no onions", "extra crispy", "cut in half".
     *
     * On by default, because almost everything the kitchen makes can be varied.
     * The exceptions are things that come sealed and are simply handed over -
     * bottled water and tubs of ice cream - where a note would only mislead
     * whoever reads the slip.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('allow_item_note')->default(true)->after('customize_enabled');
        });

        DB::table('products')
            ->whereIn('category_id', function ($q) {
                $q->select('id')->from('categories')->where('name', 'Ice Cream');
            })
            ->orWhere('name', 'like', '%Water%')
            ->orWhere('name', 'like', '%Ice Cream%')
            ->update(['allow_item_note' => false]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('allow_item_note');
        });
    }
};
