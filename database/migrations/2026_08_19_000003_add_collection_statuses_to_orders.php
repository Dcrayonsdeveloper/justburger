<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A collection-only burger shop has three states an order can be in:
     * ordered, being made, ready to collect. `preparing` and `ready` join the
     * enum to say that directly, instead of borrowing delivery words.
     *
     * The old values stay in the enum on purpose. Historical orders keep the
     * status they were given; Order::collectionStage() maps them onto the three
     * steps for display, so nothing has to be rewritten.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE orders MODIFY status
            ENUM('pending','confirmed','processing','preparing','packed','ready',
                 'shipped','out_for_delivery','delivered','cancelled','returned')
            NULL DEFAULT 'pending'
        ");

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('preparing_at')->nullable()->after('confirmed_at');
            $table->timestamp('ready_at')->nullable()->after('preparing_at');
        });

        // Orders already placed are being made right now as far as anyone knows,
        // so give them a preparing_at to measure the collection window from.
        DB::table('orders')
            ->whereIn('status', ['pending', 'confirmed', 'processing'])
            ->whereNull('preparing_at')
            ->update(['preparing_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        DB::table('orders')->where('status', 'preparing')->update(['status' => 'confirmed']);
        DB::table('orders')->where('status', 'ready')->update(['status' => 'delivered']);

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['preparing_at', 'ready_at']);
        });

        DB::statement("
            ALTER TABLE orders MODIFY status
            ENUM('pending','confirmed','processing','packed','shipped',
                 'out_for_delivery','delivered','cancelled','returned')
            NULL DEFAULT 'pending'
        ");
    }
};
