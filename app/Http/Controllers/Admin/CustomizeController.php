<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Single-screen manager for the product customize options (toppings).
 * Add a topping at the top, every topping listed in the table below.
 */
class CustomizeController extends Controller
{
    public function index(): View
    {
        $toppings = Topping::query()
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('admin.customize.index', ['toppings' => $toppings]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Topping::create($data);

        return redirect()
            ->route('admin.customize.index')
            ->with('success', 'Topping "' . $data['name'] . '" added.');
    }

    public function update(Request $request, Topping $topping): RedirectResponse
    {
        $topping->update($this->validated($request, $topping));

        return redirect()
            ->route('admin.customize.index')
            ->with('success', 'Topping "' . $topping->name . '" updated.');
    }

    public function destroy(Topping $topping): RedirectResponse
    {
        $name = $topping->name;

        $topping->delete();

        return redirect()
            ->route('admin.customize.index')
            ->with('success', "Topping \"{$name}\" deleted.");
    }

    /**
     * Flip Active straight from the table, so it never depends on the edit
     * dialog's checkbox state.
     */
    public function toggleActive(Topping $topping): RedirectResponse
    {
        $topping->update(['is_active' => ! $topping->is_active]);

        return redirect()
            ->route('admin.customize.index')
            ->with('success', "Topping \"{$topping->name}\" is now " . ($topping->is_active ? 'active' : 'inactive') . '.');
    }

    /**
     * Shared validation. A pre-selected topping arrives ticked in the popup and
     * is included with the item, so its price is never collected — store 0 so
     * the figure on screen matches what the customer is actually charged.
     */
    private function validated(Request $request, ?Topping $topping = null): array
    {
        $unique = 'unique:toppings,name' . ($topping ? ',' . $topping->id : '');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $unique],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_preselected'] = $request->boolean('is_preselected');
        $data['is_active'] = $request->boolean('is_active');
        $data['position'] = $data['position'] ?? 0;
        $data['price'] = $data['is_preselected'] ? 0 : (float) ($data['price'] ?? 0);

        // The group column is unused by the storefront but is non-nullable.
        if (! $topping) {
            $data['group'] = 'extras';
        }

        return $data;
    }
}
