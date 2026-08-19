<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Records when an order's receipt reached the printer, so auto-printing can
     * tell a new order from one already dealt with. Without it, a till left open
     * would reprint the same receipt on every poll.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('receipt_printed_at')->nullable()->after('ready_at');
            // The poller asks "what is unprinted since X" on a timer, so this
            // pair carries the query.
            $table->index(['receipt_printed_at', 'created_at'], 'orders_receipt_print_idx');
        });

        // Orders that predate auto-printing were handled by hand. Marking them
        // printed stops the first switch-on spitting out the whole back catalogue.
        DB::table('orders')
            ->whereNull('receipt_printed_at')
            ->update(['receipt_printed_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_receipt_print_idx');
            $table->dropColumn('receipt_printed_at');
        });
    }
};
