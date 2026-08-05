<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop all POS-exclusive tables. The POS (point-of-sale) system was
     * removed from the application entirely.
     *
     * `stores`, `staff` and `credit_notes` are intentionally KEPT — they are
     * shared with the storefront restaurant locator, the admin RBAC/sub-user
     * system, and storefront returns respectively.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Children -> parents.
        Schema::dropIfExists('pos_return_items');
        Schema::dropIfExists('pos_returns');
        Schema::dropIfExists('pos_sale_items');
        Schema::dropIfExists('pos_cash_movements');
        Schema::dropIfExists('pos_held_bills');
        Schema::dropIfExists('pos_audit_log');
        Schema::dropIfExists('pos_sales');
        Schema::dropIfExists('staff_shifts');
        Schema::dropIfExists('pos_registers');
        Schema::dropIfExists('store_transfer_items');
        Schema::dropIfExists('store_transfers');
        Schema::dropIfExists('barcodes');
        Schema::dropIfExists('discount_rules');

        Schema::enableForeignKeyConstraints();

        // Drop the POS-only PIN column from the (kept) staff table.
        if (Schema::hasColumn('staff', 'pin')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->dropColumn('pin');
            });
        }
    }

    /**
     * Irreversible: the POS system and all of its data were removed
     * permanently. The dropped tables cannot be restored.
     */
    public function down(): void
    {
        // No-op.
    }
};
