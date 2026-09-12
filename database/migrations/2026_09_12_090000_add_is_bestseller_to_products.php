<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A hand-picked Best Sellers carousel.
 *
 * The homepage ranked that section by sales_count, which sounds right until a
 * shop has barely any sales history: two test orders were enough to put a
 * bottle of water and a Pepsi at the top of "what everyone orders". The shop
 * knows what its best sellers are, so let them say so.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Indexed because the homepage filters on it on every visit.
            $table->boolean('is_bestseller')->default(false)->index()->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_bestseller');
        });
    }
};
