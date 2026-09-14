<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Drop the shared "Veggies" section. Per-product ingredients replace it:
     * what an item is made of is now typed on the item itself, rather than
     * picked out of a menu-wide list.
     *
     * This removes its options everywhere, the paid ones included — that was
     * the explicit decision, not a side effect.
     */
    public function up(): void
    {
        $group = DB::table('topping_groups')->whereRaw('LOWER(slug) = ?', ['veggies'])->first()
            ?? DB::table('topping_groups')->whereRaw('LOWER(name) = ?', ['veggies'])->first();

        if (! $group) {
            return;
        }

        // Deleting the toppings cascades product_topping, so no product is left
        // pointing at an option that no longer exists.
        DB::table('toppings')->where('topping_group_id', $group->id)->delete();

        // Deleting the section cascades product_topping_group the same way.
        DB::table('topping_groups')->where('id', $group->id)->delete();
    }

    public function down(): void
    {
        // Nothing to reverse — the section and its options are gone, and the
        // rows cannot be reconstructed from anything left behind. Rolling back
        // simply leaves the catalogue as it is.
    }
};
