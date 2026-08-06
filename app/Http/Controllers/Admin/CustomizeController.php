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
    /** Topping groups offered in the form. */
    public const GROUPS = [
        'veggies' => 'Veggies',
        'cheese' => 'Cheese',
        'sauce' => 'Sauce',
        'extras' => 'Extras',
    ];

    public function index(): View
    {
        $toppings = Topping::withCount('products')
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('admin.customize.index', [
            'toppings' => $toppings,
            'groups' => self::GROUPS,
        ]);
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
        $used = $topping->products()->count();

        $topping->delete();

        return redirect()
            ->route('admin.customize.index')
            ->with('success', $used > 0
                ? "Topping \"{$name}\" deleted and removed from {$used} product(s)."
                : "Topping \"{$name}\" deleted.");
    }

    /**
     * Shared validation. "Free" and "Pre-select" both force the price to zero —
     * a pre-selected topping is included with the product and never charged, so
     * storing a price on one would be a number we never collect.
     */
    private function validated(Request $request, ?Topping $topping = null): array
    {
        $unique = 'unique:toppings,name' . ($topping ? ',' . $topping->id : '');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $unique],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'group' => ['required', 'string', 'in:' . implode(',', array_keys(self::GROUPS))],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_preselected'] = $request->boolean('is_preselected');
        $data['is_active'] = $request->boolean('is_active');
        $data['position'] = $data['position'] ?? 0;

        $isFree = $request->boolean('is_free') || $data['is_preselected'];
        $data['price'] = $isFree ? 0 : (float) ($data['price'] ?? 0);

        return $data;
    }
}
