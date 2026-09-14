{{--
    The Customize panel on a product's edit/create screen.

    Three things are set here, all per product:
      • the master switch (customize_enabled) — off means no popup at all
      • which sections this item shows          → topping_sections[]
      • which options it offers, and which of   → toppings[] / topping_preselect[]
        those arrive already ticked

    Switching a section off leaves its ticks alone, so switching it back on
    restores exactly what was there before.

    Expects: $toppingGroups, and $product (null on create).
--}}
@php
    $isEdit = isset($product) && $product;

    $offeredIds = collect(old('toppings', $isEdit ? $product->toppings->pluck('id')->all() : []))
        ->map(fn ($id) => (int) $id)->all();

    // An option already on this product keeps whatever was chosen for it here.
    // One that is not yet on it falls back to the option's own Pre-select
    // switch on the Customize page, which is what that switch is for — the
    // default for items that take the option on later.
    $savedPreselect = $isEdit
        ? $product->toppings->where('pivot.is_default', true)->pluck('id')->all()
        : [];
    $linkedIds = $isEdit ? $product->toppings->pluck('id')->all() : [];

    $preselectIds = collect(old('topping_preselect', array_merge(
        $savedPreselect,
        $toppingGroups->flatMap->toppings
            ->filter(fn ($t) => $t->is_preselected && ! in_array($t->id, $linkedIds, true))
            ->pluck('id')->all()
    )))->map(fn ($id) => (int) $id)->all();

    // A section with no saved row has never been chosen for this product, so it
    // stays off until someone picks it. On create everything starts off.
    $enabledSectionIds = collect(old(
        'topping_sections',
        $isEdit
            ? $product->toppingGroups->where('pivot.is_enabled', true)->pluck('id')->all()
            : []
    ))->map(fn ($id) => (int) $id)->all();

    $state = [
        'sections'  => $toppingGroups->mapWithKeys(fn ($g) => [$g->id => in_array($g->id, $enabledSectionIds, true)]),
        'offered'   => $toppingGroups->flatMap->toppings->mapWithKeys(fn ($t) => [$t->id => in_array($t->id, $offeredIds, true)]),
        'preselect' => $toppingGroups->flatMap->toppings->mapWithKeys(fn ($t) => [$t->id => in_array($t->id, $preselectIds, true)]),
    ];
@endphp

<div class="card overflow-hidden mt-5"
     x-data="{
        on: {{ (bool) old('customize_enabled', $isEdit ? $product->customize_enabled : false) ? 'true' : 'false' }},
        sections: {{ Js::from($state['sections']) }},
        offered: {{ Js::from($state['offered']) }},
        preselect: {{ Js::from($state['preselect']) }},
        setAll(ids, v) {
            ids.forEach(id => {
                this.offered[id] = v;
                if (!v) this.preselect[id] = false;
            });
        },
        togglePreselect(id) {
            // Pre-ticking an option implies the item offers it at all.
            this.preselect[id] = !this.preselect[id];
            if (this.preselect[id]) this.offered[id] = true;
        },
        onOfferedChange(id) {
            if (!this.offered[id]) this.preselect[id] = false;
        },
     }">

    <div class="px-5 py-4 flex items-start justify-between gap-4">
        <div>
            <h2 class="text-base font-semibold text-neutral-900">Customize</h2>
            <p class="text-xs text-neutral-500 mt-0.5">
                Off by default. Turn it on, then switch on the sections this item shows and tick the options it offers.
                Mark an option <strong>Pre-ticked</strong> and it arrives already selected in the customer's popup.
                Build the sections and options themselves on the <a href="{{ route('admin.customize.index') }}" class="text-primary-600 underline">Customize</a> page.
                Leave the switch off and no popup appears &mdash; the item goes straight to the basket.
            </p>
        </div>
        <label class="relative inline-flex items-center gap-2 cursor-pointer select-none shrink-0">
            <input type="hidden" name="customize_enabled" value="0">
            <input type="checkbox" name="customize_enabled" value="1" x-model="on" class="sr-only">
            <span class="relative w-11 h-6 bg-neutral-200 rounded-full transition-colors" :class="{ '!bg-primary-600': on }">
                <span class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform" :class="{ 'translate-x-5': on }"></span>
            </span>
            <span class="text-sm font-medium" :class="on ? 'text-primary-700' : 'text-neutral-500'" x-text="on ? 'Enabled' : 'Disabled'"></span>
        </label>
    </div>

    <div x-show="on" x-cloak class="px-5 pb-5 border-t border-neutral-100 pt-4">
        @if($toppingGroups->isEmpty())
            <p class="text-sm text-neutral-500">
                No customize sections exist yet.
                <a href="{{ route('admin.customize.index') }}" class="text-primary-600 underline">Create a section</a>
                first, then choose what this item offers.
            </p>
        @else
            <div class="space-y-3">
                @foreach($toppingGroups as $group)
                    @php $ids = $group->toppings->pluck('id')->all(); @endphp

                    <div class="rounded-lg border border-neutral-200 overflow-hidden"
                         :class="sections[{{ $group->id }}] ? 'border-neutral-200' : 'border-neutral-150 bg-neutral-50/60'">

                        {{-- Section header + on/off --}}
                        <div class="flex items-center justify-between gap-3 px-4 py-2.5 bg-neutral-50 border-b border-neutral-100">
                            <div class="flex items-center gap-2 min-w-0">
                                <h4 class="text-xs font-bold text-neutral-600 uppercase tracking-wider truncate">{{ $group->name }}</h4>
                                <span class="text-xs text-neutral-400 shrink-0">
                                    {{ $group->toppings->count() }} {{ Str::plural('option', $group->toppings->count()) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                <div class="flex items-center gap-2 text-xs" x-show="sections[{{ $group->id }}]">
                                    <button type="button" class="text-primary-600 hover:underline"
                                            @click="setAll({{ Js::from($ids) }}, true)">Select all</button>
                                    <span class="text-neutral-300">|</span>
                                    <button type="button" class="text-neutral-500 hover:underline"
                                            @click="setAll({{ Js::from($ids) }}, false)">Clear</button>
                                </div>

                                <label class="relative inline-flex items-center gap-2 cursor-pointer select-none">
                                    <input type="checkbox" name="topping_sections[]" value="{{ $group->id }}"
                                           x-model="sections[{{ $group->id }}]" class="sr-only">
                                    <span class="relative w-9 h-5 bg-neutral-300 rounded-full transition-colors"
                                          :class="{ '!bg-green-600': sections[{{ $group->id }}] }">
                                        <span class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"
                                              :class="{ 'translate-x-4': sections[{{ $group->id }}] }"></span>
                                    </span>
                                    <span class="text-xs font-medium w-7"
                                          :class="sections[{{ $group->id }}] ? 'text-green-700' : 'text-neutral-400'"
                                          x-text="sections[{{ $group->id }}] ? 'On' : 'Off'"></span>
                                </label>
                            </div>
                        </div>

                        {{-- Options. Hidden rather than removed when the section is
                             off, so the ticks survive and come back untouched. --}}
                        <div x-show="sections[{{ $group->id }}]" x-cloak class="p-3">
                            @if($group->toppings->isEmpty())
                                <p class="text-xs text-neutral-400 px-1 py-2">
                                    This section has no options yet.
                                    <a href="{{ route('admin.customize.index') }}" class="text-primary-600 underline">Add some</a>.
                                </p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach($group->toppings as $t)
                                        <div class="flex items-center gap-2 px-3 py-2 rounded-lg border transition-colors"
                                             :class="offered[{{ $t->id }}] ? 'border-neutral-200 bg-white' : 'border-neutral-150 bg-neutral-50'">

                                            <label class="flex items-center gap-2.5 flex-1 min-w-0 cursor-pointer">
                                                <input type="checkbox" name="toppings[]" value="{{ $t->id }}"
                                                       x-model="offered[{{ $t->id }}]"
                                                       @change="onOfferedChange({{ $t->id }})"
                                                       class="form-checkbox shrink-0">
                                                <span class="flex-1 text-sm text-neutral-800 truncate">{{ $t->name }}</span>
                                            </label>

                                            <span class="text-xs shrink-0 {{ (float) $t->price > 0 ? 'text-neutral-500' : 'text-green-600' }}">
                                                {{ (float) $t->price > 0 ? '+£' . number_format($t->price, 2) : 'Included' }}
                                            </span>

                                            {{-- Pre-ticked toggle --}}
                                            <input type="checkbox" name="topping_preselect[]" value="{{ $t->id }}"
                                                   x-model="preselect[{{ $t->id }}]" class="sr-only">
                                            <button type="button" @click="togglePreselect({{ $t->id }})"
                                                    class="shrink-0 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide transition-colors"
                                                    :class="preselect[{{ $t->id }}]
                                                        ? 'bg-green-100 text-green-700 ring-1 ring-green-300'
                                                        : 'bg-neutral-100 text-neutral-400 hover:bg-neutral-200'"
                                                    :title="preselect[{{ $t->id }}]
                                                        ? 'Arrives ticked in the popup — click to make it optional'
                                                        : 'Click to make this arrive already ticked'">
                                                <span x-text="preselect[{{ $t->id }}] ? '✓ Pre' : 'Pre'"></span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
