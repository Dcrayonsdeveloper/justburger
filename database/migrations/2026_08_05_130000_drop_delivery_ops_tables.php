<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove the delivery-OPERATIONS feature (rider/partner panel + Delhivery
     * courier integration).
     *
     * Drops the `delivery_partners` table and every column that references it,
     * plus the courier-only order columns. The customer delivery-vs-collection
     * checkout flow is unaffected.
     *
     * KEPT: `order_shipments` (used by manual admin/seller shipping + customer
     * order tracking) — only its `delivery_partner_id` column is removed.
     */
    public function up(): void
    {
        // Reassign any delivery-partner users to plain customers BEFORE the enum shrinks.
        DB::statement("UPDATE users SET role = 'customer' WHERE role = 'delivery_partner'");

        // returns.pickup_partner_id (3rd FK into delivery_partners).
        // Keep pickup_scheduled_at / picked_up_at — they are generic return-status
        // timestamps, not delivery-partner-specific.
        if (Schema::hasColumn('returns', 'pickup_partner_id')) {
            Schema::table('returns', function (Blueprint $table) {
                $table->dropForeign(['pickup_partner_id']);
                $table->dropColumn('pickup_partner_id');
            });
        }

        // orders.delivery_partner_id (FK + composite index [delivery_partner_id, status])
        if (Schema::hasColumn('orders', 'delivery_partner_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['delivery_partner_id']);
                $table->dropIndex(['delivery_partner_id', 'status']);
                $table->dropColumn('delivery_partner_id');
            });
        }

        // order_shipments.delivery_partner_id (FK) — KEEP the table itself
        if (Schema::hasColumn('order_shipments', 'delivery_partner_id')) {
            Schema::table('order_shipments', function (Blueprint $table) {
                $table->dropForeign(['delivery_partner_id']);
                $table->dropColumn('delivery_partner_id');
            });
        }

        // delivery_partners table (its user_id FK drops with it)
        Schema::dropIfExists('delivery_partners');

        // courier-only order columns
        Schema::table('orders', function (Blueprint $table) {
            foreach (['expected_delivery_date', 'payment_collected', 'payment_collected_at', 'payment_collected_by'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // Remove 'delivery_partner' from the users.role enum (keep 'affiliate').
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer','seller','staff','admin','affiliate') DEFAULT 'customer'");
    }

    /**
     * Irreversible: the delivery-operations feature and its data were removed.
     */
    public function down(): void
    {
        // No-op.
    }
};
