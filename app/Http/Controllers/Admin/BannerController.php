<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        $perPage = request()->input('per_page', 10);
        $banners = Banner::orderBy('priority')->paginate($perPage)->withQueryString();

        return view('admin.banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.banners.create', ['categories' => $this->linkCategories()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'image' => 'required|image|max:5120',
            'mobile_image' => 'nullable|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'link_type' => 'nullable|in:menu,category,custom',
            'link_category' => 'nullable|string|exists:categories,slug',
            // Not 'url': every banner links to a path on this site, and the url
            // rule rejects "/menu?category=burgers" — which made it impossible
            // to save any existing banner through this form.
            'link_custom' => 'nullable|string|max:500',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['link'] = $this->resolveLink($request);
        unset($validated['link_type'], $validated['link_category'], $validated['link_custom']);

        $validated['image_url'] = $request->file('image')->store('banners', 'public');

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image_url'] = $request->file('mobile_image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', [
            'banner' => $banner,
            'categories' => $this->linkCategories(),
        ]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:50',
            'image' => 'nullable|image|max:5120',
            'mobile_image' => 'nullable|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'link_type' => 'nullable|in:menu,category,custom',
            'link_category' => 'nullable|string|exists:categories,slug',
            // Not 'url': every banner links to a path on this site, and the url
            // rule rejects "/menu?category=burgers" — which made it impossible
            // to save any existing banner through this form.
            'link_custom' => 'nullable|string|max:500',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['link'] = $this->resolveLink($request);
        unset($validated['link_type'], $validated['link_category'], $validated['link_custom']);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('banners', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image_url'] = $request->file('mobile_image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
    }


    /**
     * Build the banner's destination from the picker.
     *
     * Banners point at the menu, so a category is chosen rather than a URL
     * typed. The custom option is kept for the occasional link that is not a
     * category, and stored as given.
     */
    private function resolveLink(Request $request): ?string
    {
        return match ($request->input('link_type', 'menu')) {
            'category' => $request->filled('link_category')
                ? route('products.index', ['category' => $request->input('link_category')], false)
                : route('products.index', [], false),
            'custom' => trim((string) $request->input('link_custom')) ?: null,
            default => route('products.index', [], false),
        };
    }

    /**
     * Categories a banner can point at — active ones that actually hold
     * something, so a banner cannot link to an empty listing.
     */
    private function linkCategories()
    {
        return Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderBy('position')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'banners' => 'required|array',
            'banners.*.id' => 'required|exists:banners,id',
            'banners.*.priority' => 'required|integer',
        ]);

        foreach ($validated['banners'] as $item) {
            Banner::where('id', $item['id'])->update(['priority' => $item['priority']]);
        }

        return back()->with('success', 'Banners reordered');
    }
}
