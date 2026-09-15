{{--
    The words on a hero banner, plus where its button goes.

    These map straight onto what the customer sees on the homepage slide:

        name         the small coloured tag   "EVERYDAY · LUNCHTIME"
        title        the big headline         "BURGER & FRIES / £5.50"
        subtitle     the line underneath      "The best lunch deal in Feltham."
        button_text  the red button           "ORDER NOW"
        link         where that button goes

    The title is a textarea because the homepage renders its line breaks —
    that is how "BURGER & FRIES" and "£5.50" end up on separate lines.

    Expects: $banner (null when creating) and $categories.
--}}
@php
    $b = $banner ?? null;

    // Work out which link option the saved value corresponds to, so reopening
    // the form shows what is actually set rather than resetting to a default.
    $savedLink = old('link_custom', $b?->link);
    $menuPath = route('products.index', [], false);
    $savedCategory = null;

    if ($b?->link && str_contains($b->link, '?category=')) {
        $savedCategory = urldecode(explode('?category=', $b->link)[1] ?? '');
        $savedCategory = explode('&', $savedCategory)[0] ?: null;
    }

    $linkType = old('link_type', match (true) {
        $savedCategory !== null => 'category',
        empty($b?->link), $b?->link === $menuPath => 'menu',
        default => 'custom',
    });
@endphp

<div class="card">
    <div class="p-4 border-b border-neutral-200">
        <h2 class="font-semibold text-neutral-900">Banner Content</h2>
        <p class="text-xs text-neutral-500 mt-0.5">What the customer reads on the slide.</p>
    </div>
    <div class="p-4 space-y-4">

        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Label <span class="text-danger-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $b?->name) }}" required
                   class="form-input w-full" placeholder="e.g. Everyday · Lunchtime">
            <p class="text-xs text-neutral-500 mt-1">The small coloured tag above the headline. Also names this banner in the list.</p>
            @error('name')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Headline</label>
            <textarea name="title" rows="2" class="form-input w-full"
                      placeholder="Burger &amp; Fries&#10;£5.50">{{ old('title', $b?->title) }}</textarea>
            <p class="text-xs text-neutral-500 mt-1">The big text. Press Enter for a new line &mdash; each line appears stacked, so &ldquo;Burger &amp; Fries&rdquo; then &ldquo;&pound;5.50&rdquo;.</p>
            @error('title')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Supporting line</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $b?->subtitle) }}"
                   class="form-input w-full" placeholder="e.g. The best lunch deal in Feltham. Full stop.">
            <p class="text-xs text-neutral-500 mt-1">The smaller line under the headline. Leave empty to show nothing.</p>
            @error('subtitle')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Button text</label>
            <input type="text" name="button_text" value="{{ old('button_text', $b?->button_text) }}"
                   class="form-input w-full" placeholder="e.g. Order Now">
            <p class="text-xs text-neutral-500 mt-1">Leave empty and no button appears on the slide.</p>
            @error('button_text')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="card" x-data="{ linkType: '{{ $linkType }}' }">
    <div class="p-4 border-b border-neutral-200">
        <h2 class="font-semibold text-neutral-900">Button Link</h2>
        <p class="text-xs text-neutral-500 mt-0.5">Where the button takes the customer.</p>
    </div>
    <div class="p-4 space-y-4">
        <div>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Send them to</label>
            <select name="link_type" x-model="linkType" class="form-select w-full">
                <option value="menu">The whole menu</option>
                <option value="category">A category</option>
                <option value="custom">Somewhere else (custom link)</option>
            </select>
        </div>

        <div x-show="linkType === 'category'" x-cloak>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Category</label>
            <select name="link_category" class="form-select w-full">
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}"
                        @selected(old('link_category', $savedCategory) === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <p class="text-xs text-neutral-500 mt-1">Only categories with items in them are listed.</p>
            @error('link_category')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        <div x-show="linkType === 'custom'" x-cloak>
            <label class="block text-sm font-medium text-neutral-700 mb-1">Link</label>
            <input type="text" name="link_custom" value="{{ $linkType === 'custom' ? $savedLink : '' }}"
                   class="form-input w-full" placeholder="/contact">
            <p class="text-xs text-neutral-500 mt-1">A path on this site such as <code>/contact</code>, or a full address.</p>
            @error('link_custom')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        @if($b?->link)
            <p class="text-xs text-neutral-500">Currently points at <code>{{ $b->link }}</code></p>
        @endif
    </div>
</div>
