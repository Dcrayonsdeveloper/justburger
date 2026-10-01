<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Let a guest keep a wishlist, the way they already keep a basket.
     *
     * `carts` has had `user_id` nullable with a `session_id` beside it from the
     * start; `wishlists` never did, so saving a product demanded an account.
     * This brings the two into line.
     */
    public function up(): void
    {
        // The unique index is the only one covering user_id, and MySQL refuses
        // to drop an index a foreign key still needs (errno 1553), so the
        // replacement has to exist first.
        Schema::table('wishlists', function (Blueprint $table) {
            $table->index(['user_id', 'product_id', 'variant_id'], 'wishlists_owner_product_index');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropUnique('wishlists_user_id_product_id_variant_id_unique');
        });

        // Raw SQL rather than ->change(): it alters only nullability and leaves
        // the existing foreign key alone.
        DB::statement('ALTER TABLE wishlists MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('wishlists', function (Blueprint $table) {
            $table->string('session_id', 100)->nullable()->after('user_id');
            $table->index(['session_id', 'product_id'], 'wishlists_session_product_index');
        });

        // No unique index replaces the old one on purpose. With two nullable
        // owner columns MySQL treats every NULL as distinct, so a unique index
        // would not actually prevent duplicates - WishlistController checks for
        // an existing row before inserting, which does.
    }

    public function down(): void
    {
        // Guest rows cannot survive a NOT NULL user_id.
        DB::table('wishlists')->whereNull('user_id')->delete();

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex('wishlists_session_product_index');
            $table->dropColumn('session_id');
        });

        DB::statement('ALTER TABLE wishlists MODIFY user_id BIGINT UNSIGNED NOT NULL');

        Schema::table('wishlists', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id', 'variant_id']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex('wishlists_owner_product_index');
        });
    }
};
