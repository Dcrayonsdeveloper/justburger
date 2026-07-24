<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toppings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('group')->default('extras'); // sauce, cheese, veggies, extras
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('product_topping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('topping_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_default')->default(false);
            $table->unique(['product_id', 'topping_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_topping');
        Schema::dropIfExists('toppings');
    }
};
