<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The coupon form offers "No minimum" and "Unlimited" for these two fields,
     * and CouponController validates both as nullable — but the columns were
     * NOT NULL, so saving a coupon without them died with
     * "Column 'min_order_amount' cannot be null" and a 500.
     */
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('min_order_amount', 10, 2)->nullable()->default(null)->change();
            $table->unsignedInteger('usage_per_user')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('min_order_amount', 10, 2)->default(0)->nullable(false)->change();
            $table->unsignedInteger('usage_per_user')->default(1)->nullable(false)->change();
        });
    }
};
