<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Sections in the customize popup. Until now the grouping lived in a
        // free-text `toppings.group` column that the admin could not edit and
        // the storefront ignored, so every topping landed in one flat list.
        Schema::create('topping_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('toppings', function (Blueprint $table) {
            $table->foreignId('topping_group_id')->nullable()->after('price')
                ->constrained('topping_groups')->nullOnDelete();
        });

        // Which sections a given product shows. A section switched off here
        // hides its options for that product without losing which ones were
        // ticked, so switching it back on restores the previous selection.
        Schema::create('product_topping_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('topping_group_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_enabled')->default(true);
            $table->unique(['product_id', 'topping_group_id']);
        });

        // --- Carry the existing data across so nothing regresses on deploy ---

        // 1. Promote each distinct legacy group string to a real section.
        $legacy = DB::table('toppings')->select('group')->distinct()->pluck('group')
            ->filter()->values();

        $position = 0;
        $groupIdByLegacy = [];

        foreach ($legacy as $name) {
            $groupIdByLegacy[$name] = DB::table('topping_groups')->insertGetId([
                'name' => Str::headline($name),
                'slug' => Str::slug($name),
                'position' => $position++,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($groupIdByLegacy as $name => $id) {
            DB::table('toppings')->where('group', $name)->update(['topping_group_id' => $id]);
        }

        // 2. Pre-select becomes per-product. The old flag was global, so seed
        //    every existing product link from it — the popup keeps behaving
        //    exactly as it does today until someone edits a product.
        DB::table('product_topping')
            ->whereIn('topping_id', fn ($q) => $q->select('id')->from('toppings')->where('is_preselected', true))
            ->update(['is_default' => true]);

        // 3. Every section a product already has toppings in starts enabled,
        //    so no product silently loses its popup options.
        $pairs = DB::table('product_topping')
            ->join('toppings', 'toppings.id', '=', 'product_topping.topping_id')
            ->whereNotNull('toppings.topping_group_id')
            ->select('product_topping.product_id', 'toppings.topping_group_id')
            ->distinct()
            ->get();

        foreach ($pairs->chunk(500) as $chunk) {
            DB::table('product_topping_group')->insert(
                $chunk->map(fn ($r) => [
                    'product_id' => $r->product_id,
                    'topping_group_id' => $r->topping_group_id,
                    'is_enabled' => true,
                ])->all()
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_topping_group');

        Schema::table('toppings', function (Blueprint $table) {
            $table->dropForeign(['topping_group_id']);
            $table->dropColumn('topping_group_id');
        });

        Schema::dropIfExists('topping_groups');
    }
};
