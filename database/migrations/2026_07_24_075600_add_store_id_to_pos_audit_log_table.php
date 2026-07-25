<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pos_audit_log', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->index(['store_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_audit_log', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropIndex(['store_id', 'created_at']);
            $table->dropColumn('store_id');
        });
    }
};
