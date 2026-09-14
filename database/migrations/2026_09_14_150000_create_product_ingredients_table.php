<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // What the item is actually made of, typed per product on its own edit
        // screen. Unlike toppings these are not a shared library — "lettuce" on
        // a burger is not the same row as "lettuce" on a kebab — and they are
        // always included, so the customer sees them ticked and can only take
        // them off.
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_ingredients');
    }
};
