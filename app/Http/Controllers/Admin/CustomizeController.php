<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use App\Models\ToppingGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Single-screen manager for the product customize options.
 *
 * Options live in sections ("Veggies", "Sauce"), and the sections are what the
 * customer sees as headings in the popup. Which sections and options a given
 * product offers — and which arrive ticked — is set per product on the item's
 * edit screen, not here.
 */
class CustomizeController extends Controller
{
    public function index(): View
    {
        $groups = ToppingGroup::query()
            ->ordered()
            ->with('toppings')
            ->get();

        // Options orphaned by a deleted section still need somewhere to show up.
        $ungrouped = Topping::query()
            ->whereNull('topping_group_id')
            ->ordered()
            ->get();

        return view('admin.customize.index', compact('groups', 'ungrouped'));
    }

    // ── Sections ────────────────────────────────────────────────────────────

    public function storeGroup(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topping_groups,name'],
        ]);

        $data['position'] = (int) (ToppingGroup::max('position') ?? -1) + 1;
        $data['is_active'] = true;

        ToppingGroup::create($data);

        return back()->with('success', 'Section "' . $data['name'] . '" added.');
    }

    public function updateGroup(Request $request, ToppingGroup $group): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topping_groups,name,' . $group->id],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['position'] = $data['position'] ?? $group->position;

        $group->update($data);

        return back()->with('success', 'Section "' . $group->name . '" updated.');
    }

    /**
     * Switching a section off hides it from every popup at once, without
     * touching which products offer it — flip it back on and they return.
     */
    public function toggleGroupActive(ToppingGroup $group): RedirectResponse
    {
        $group->update(['is_active' => ! $group->is_active]);

        return back()->with('success', "Section \"{$group->name}\" is now "
            . ($group->is_active ? 'showing in the popup.' : 'hidden from every popup.'));
    }

    public function destroyGroup(ToppingGroup $group): RedirectResponse
    {
        $name = $group->name;

        // The options outlive the section — they drop to "Ungrouped" rather
        // than vanishing from the products that already offer them.
        $group->toppings()->update(['topping_group_id' => null]);
        $group->delete();

        return back()->with('success', "Section \"{$name}\" deleted. Its options moved to Ungrouped.");
    }

    // ── Options ─────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Topping::create($data);

        return back()->with('success', 'Option "' . $data['name'] . '" added.');
    }

    public function update(Request $request, Topping $topping): RedirectResponse
    {
        $topping->update($this->validated($request, $topping));

        return back()->with('success', 'Option "' . $topping->name . '" updated.');
    }

    public function destroy(Topping $topping): RedirectResponse
    {
        $name = $topping->name;

        $topping->delete();

        return back()->with('success', "Option \"{$name}\" deleted.");
    }

    /**
     * Flip Active straight from the table, so it never depends on the edit
     * dialog's checkbox state.
     */
    public function toggleActive(Topping $topping): RedirectResponse
    {
        $topping->update(['is_active' => ! $topping->is_active]);

        return back()->with('success', "Option \"{$topping->name}\" is now "
            . ($topping->is_active ? 'active' : 'inactive') . '.');
    }


    /**
     * Flip Pre-select for an option across the whole menu.
     *
     * Pre-select is a per-product decision (product_topping.is_default) — the
     * same option can be included on a burger and optional on chips. This is
     * the "set it everywhere" control: it writes the option's default, for
     * products that offer it later, and applies it to every product already
     * offering it. An individual item can still be overridden on its own edit
     * screen afterwards.
     *
     * The price is left exactly as it is: pre-select decides what starts
     * ticked, the price decides what it costs, and the customer pays for
     * whatever they leave ticked either way.
     */
    public function togglePreselected(Topping $topping): RedirectResponse
    {
        $on = ! $topping->is_preselected;

        DB::transaction(function () use ($topping, $on) {
            $topping->update(['is_preselected' => $on]);

            DB::table('product_topping')
                ->where('topping_id', $topping->id)
                ->update(['is_default' => $on]);
        });

        $count = DB::table('product_topping')->where('topping_id', $topping->id)->count();

        return back()->with('success', $on
            ? "\"{$topping->name}\" now arrives ticked on {$count} " . Str::plural('item', $count) . '.'
            : "\"{$topping->name}\" is now optional on {$count} " . Str::plural('item', $count) . '.');
    }

    /**
     * Shared validation for the add form and the edit dialog.
     *
     * Active is owned by the table switch, so the edit dialog must never write
     * it — otherwise saving a name or price would silently clear it. A blank
     * price is stored as 0 and renders as "Included" everywhere.
     */
    private function validated(Request $request, ?Topping $topping = null): array
    {
        $unique = 'unique:toppings,name' . ($topping ? ',' . $topping->id : '');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $unique],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'topping_group_id' => ['nullable', 'integer', 'exists:topping_groups,id'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['position'] = $data['position'] ?? 0;
        $data['price'] = (float) ($data['price'] ?? 0);
        $data['topping_group_id'] = $data['topping_group_id'] ?? null;

        if (! $topping) {
            $data['is_active'] = $request->boolean('is_active');
            $data['is_preselected'] = $request->boolean('is_preselected');
            // Legacy free-text column, superseded by topping_group_id. Kept in
            // step so a rollback of the sections migration still reads sanely.
            $data['group'] = 'extras';
        }

        return $data;
    }
}
