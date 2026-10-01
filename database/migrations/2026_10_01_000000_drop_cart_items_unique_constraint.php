<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The same product at the same size can sit in a basket more than once, so
     * long as the toppings differ - a plain burger and the same burger with
     * bacon are two lines, not one.
     *
     * The unique index came from the original carts migration, which predates
     * the customise popup. It rejected the second line outright
     * ("Duplicate entry '340-508-71'"), and the customer saw "Failed to add to
     * cart". CartController already decides what counts as the same line by
     * hashing the toppings selection, so the index was doing no useful work -
     * only the index it provided for that lookup is worth keeping, which is
     * why a plain one replaces it.
     */
    public function up(): void
    {
        // Create the replacement index BEFORE dropping the unique one. MySQL
        // leans on the unique index's leftmost column to satisfy the cart_id
        // foreign key and refuses the drop while nothing else covers it:
        // "Cannot drop index ...: needed in a foreign key constraint" (1553).
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index(['cart_id', 'product_id', 'variant_id'], 'cart_items_cart_product_variant_index');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique('cart_items_cart_id_product_id_variant_id_unique');
        });
    }

    public function down(): void
    {
        // Same constraint in reverse: the unique index has to be back before
        // the plain one can go.
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['cart_id', 'product_id', 'variant_id']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex('cart_items_cart_product_variant_index');
        });
    }
};
