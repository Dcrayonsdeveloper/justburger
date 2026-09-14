{{--
    What the item is made of, typed per product — the same repeater shape as
    Sizes / variants above.

    Ingredients carry no price. They are already part of the item, so they
    arrive ticked in the customer's popup under an "Ingredients" heading and
    read "Included"; the only thing a customer can do is take one off.

    Expects: $product (null on create).
--}}
@php
    $isEdit = isset($product) && $product;

    $ingredientRows = old(
        'ingredients',
        $isEdit ? $product->ingredients->map(fn ($i) => ['name' => $i->name])->all() : []
    );
@endphp

<div class="card overflow-hidden mt-5" x-data="{ rows: {{ Js::from(array_values($ingredientRows)) }} }">
    <div class="px-5 py-4">
        <h2 class="text-base font-semibold text-neutral-900">Ingredients</h2>
        <p class="text-xs text-neutral-500 mt-0.5">
            What this item is made of &mdash; one per line. They appear in the customer's popup under
            <strong>Ingredients</strong>, already ticked and marked &ldquo;Included&rdquo;, so the only thing a
            customer can do is take one off (&ldquo;no onions&rdquo;). Leave empty and no Ingredients section appears.
        </p>
    </div>

    <div class="px-5 pb-5">
        <div class="space-y-2 mb-3" x-show="rows.length">
            <template x-for="(row, i) in rows" :key="i">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-neutral-400 w-5 shrink-0 text-right" x-text="i + 1"></span>
                    <input type="text" :name="`ingredients[${i}][name]`" x-model="row.name"
                           placeholder="e.g. Lettuce" class="form-input flex-1">
                    <span class="text-xs text-green-600 font-medium w-16 shrink-0">Included</span>
                    <button type="button" @click="rows.splice(i, 1)"
                            class="w-9 h-9 shrink-0 flex items-center justify-center rounded-lg text-neutral-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                            title="Remove ingredient">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
        </div>

        <button type="button" @click="rows.push({ name: '' })"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add ingredient
        </button>
    </div>
</div>
