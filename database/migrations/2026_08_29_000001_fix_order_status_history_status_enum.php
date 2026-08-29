<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The order_status_history.status enum drifted behind orders.status: it was
     * missing the collection statuses 'preparing' and 'ready'. Because
     * Order::updateStatus() logs every change into this table, marking an order
     * Preparing or Ready threw "Data truncated for column 'status'" and the whole
     * status change failed. Bring the enum back in line with orders.status.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `order_status_history` MODIFY `status` ENUM('pending','confirmed','processing','preparing','packed','ready','shipped','out_for_delivery','delivered','cancelled','returned') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `order_status_history` MODIFY `status` ENUM('pending','confirmed','processing','packed','shipped','out_for_delivery','delivered','cancelled','returned') NOT NULL");
    }
};
