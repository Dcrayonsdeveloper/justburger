<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toppings', function (Blueprint $table) {
            // Pre-select is now a property of the topping itself: when set, the
            // topping arrives ticked (and free) on every product that offers it.
            $table->boolean('is_preselected')->default(false)->after('price');
        });

        Schema::table('products', function (Blueprint $table) {
            // Master switch for the customize dialog. Off by default so a new
            // product never surprises anyone with a topping popup.
            $table->boolean('customize_enabled')->default(false)->after('is_featured');
        });

        // Carry over what already exists so nothing regresses on deploy:
        // any topping that was a per-product default becomes globally pre-selected,
        // and every product that already has toppings keeps its dialog.
        DB::table('toppings')
            ->whereIn('id', fn ($q) => $q->select('topping_id')->from('product_topping')->where('is_default', true))
            ->update(['is_preselected' => true]);

        DB::table('products')
            ->whereIn('id', fn ($q) => $q->select('product_id')->from('product_topping'))
            ->update(['customize_enabled' => true]);
    }

    public function down(): void
    {
        Schema::table('toppings', function (Blueprint $table) {
            $table->dropColumn('is_preselected');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('customize_enabled');
        });
    }
};
