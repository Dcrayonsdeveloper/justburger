<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The contact form no longer requires an email address, so the column has
     * to accept null — otherwise an enquiry left without one fails to insert.
     */
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('email', 255)->nullable(false)->change();
        });
    }
};
