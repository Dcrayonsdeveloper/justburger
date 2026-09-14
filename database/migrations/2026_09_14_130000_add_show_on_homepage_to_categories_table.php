<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('show_on_homepage')->default(false)->after('exclude_from_bestsellers');
        });

        // Seed the flag from whatever the homepage is showing right now, so the
        // grid looks identical the moment this lands. That was the first six
        // active categories by position that have at least one active product —
        // the same query HomeController used before the flag existed.
        $current = DB::table('categories')
            ->where('is_active', true)
            ->whereIn('id', function ($q) {
                $q->select('category_id')
                    ->from('products')
                    ->where('is_active', true)
                    ->whereNull('deleted_at')
                    ->groupBy('category_id');
            })
            ->orderBy('position')
            ->limit(6)
            ->pluck('id');

        if ($current->isNotEmpty()) {
            DB::table('categories')->whereIn('id', $current)->update(['show_on_homepage' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('show_on_homepage');
        });
    }
};
