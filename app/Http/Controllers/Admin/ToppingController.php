<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToppingController extends Controller
{
    public function index(): View
    {
        $toppings = Topping::withCount('products')
            ->orderBy('position')
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('admin.toppings.index', compact('toppings'));
    }

    public function create(): View
    {
        return view('admin.toppings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:toppings',
            'price' => 'required|numeric|min:0',
            'group' => 'required|string|in:veggies,cheese,sauce,extras',
            'is_active' => 'boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['position'] = $validated['position'] ?? 0;

        Topping::create($validated);

        return redirect()->route('admin.toppings.index')->with('success', 'Topping created successfully');
    }

    public function edit(Topping $topping): View
    {
        return view('admin.toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:toppings,name,' . $topping->id,
            'price' => 'required|numeric|min:0',
            'group' => 'required|string|in:veggies,cheese,sauce,extras',
            'is_active' => 'boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['position'] = $validated['position'] ?? 0;

        $topping->update($validated);

        return redirect()->route('admin.toppings.index')->with('success', 'Topping updated successfully');
    }

    public function destroy(Topping $topping): RedirectResponse
    {
        $topping->delete();

        return redirect()->route('admin.toppings.index')->with('success', 'Topping deleted successfully');
    }
}
