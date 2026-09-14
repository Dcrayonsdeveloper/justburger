<x-layouts.admin>
    <x-slot name="title">Customize</x-slot>

    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Customize</h1>
            <p class="text-sm text-neutral-600 mt-1">
                The sections and options that make up the customize popup. Which of them each item offers &mdash;
                and which arrive ticked &mdash; is set on the item itself under Menu &rarr; All Items.
            </p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-3 bg-success-50 text-success-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div x-data="{ editingOption: null, optionForm: {}, editingSection: null, sectionForm: {}, addingTo: null }">

        {{-- Add a section --}}
        <div class="card p-5 mb-6">
            <h2 class="text-base font-semibold text-neutral-900 mb-1">Add Section</h2>
            <p class="text-xs text-neutral-500 mb-4">
                A section is a heading in the customer's popup &mdash; &ldquo;Veggies&rdquo;, &ldquo;Sauce&rdquo;, &ldquo;Extras&rdquo;. Options live inside a section.
            </p>

            <form action="{{ route('admin.customize.sections.store') }}" method="POST" class="flex flex-wrap items-end gap-3">
                @csrf
                <div class="flex-1 min-w-[16rem]">
                    <label for="section_name" class="block text-sm font-medium text-neutral-700 mb-1">Section name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="section_name" value="{{ old('name') }}" required
                           placeholder="e.g. Cheese"
                           class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Section
                </button>
            </form>
        </div>

        {{-- Sections and their options --}}
        @forelse($groups as $group)
            <div class="card overflow-hidden mb-5">
                <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between gap-4 {{ $group->is_active ? '' : 'bg-neutral-50' }}">
                    <div class="min-w-0">
                        <h2 class="text-base font-semibold text-neutral-900 flex items-center gap-2">
                            {{ $group->name }}
                            <span class="text-xs font-normal text-neutral-400">{{ $group->toppings->count() }} {{ Str::plural('option', $group->toppings->count()) }}</span>
                        </h2>
                        @unless($group->is_active)
                            <p class="text-xs text-neutral-500 mt-0.5">Hidden from every popup while this is switched off.</p>
                        @endunless
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <form action="{{ route('admin.customize.sections.toggle-active', $group) }}" method="POST" class="inline-flex items-center gap-2 mr-1">
                            @csrf @method('PUT')
                            <button type="submit" role="switch" aria-checked="{{ $group->is_active ? 'true' : 'false' }}"
                                    title="{{ $group->is_active ? 'Hide this section from every popup' : 'Show this section again' }}"
                                    style="position:relative;display:inline-block;width:2.5rem;height:1.35rem;border:none;border-radius:99px;cursor:pointer;transition:background .15s;background:{{ $group->is_active ? '#16a34a' : '#d4d4d4' }};">
                                <span style="position:absolute;top:.15rem;left:.15rem;width:1.05rem;height:1.05rem;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .15s;{{ $group->is_active ? 'transform:translateX(1.15rem);' : '' }}"></span>
                            </button>
                            <span class="text-xs font-medium {{ $group->is_active ? 'text-success-700' : 'text-neutral-400' }}">{{ $group->is_active ? 'On' : 'Off' }}</span>
                        </form>

                        <button type="button"
                                @click="editingSection = {{ $group->id }}; sectionForm = {{ Js::from(['name' => $group->name, 'position' => (int) $group->position]) }}"
                                class="p-1.5 text-neutral-400 hover:text-primary-600 rounded transition-colors" title="Rename section">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>

                        <form action="{{ route('admin.customize.sections.destroy', $group) }}" method="POST"
                              onsubmit="return confirm('Delete the &quot;{{ $group->name }}&quot; section? Its options move to Ungrouped and stop showing until you file them under another section. Switch it Off instead if you only want to hide it.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-600 rounded transition-colors" title="Delete section">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                @include('admin.customize._options-table', ['items' => $group->toppings, 'group' => $group])
            </div>
        @empty
            <div class="card p-8 text-center text-neutral-400 mb-5">
                No sections yet &mdash; add your first one above, then put options inside it.
            </div>
        @endforelse

        {{-- Options with no section --}}
        @if($ungrouped->isNotEmpty())
            <div class="card overflow-hidden mb-5">
                <div class="px-5 py-4 border-b border-neutral-100 bg-amber-50">
                    <h2 class="text-base font-semibold text-neutral-900">Ungrouped</h2>
                    <p class="text-xs text-neutral-600 mt-0.5">
                        These options have no section, so they never appear in the popup. Edit each one and file it under a section.
                    </p>
                </div>
                @include('admin.customize._options-table', ['items' => $ungrouped, 'group' => null])
            </div>
        @endif

        {{-- Edit section dialog --}}
        <div x-show="editingSection !== null" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="editingSection = null">
            <div class="absolute inset-0 bg-black/40" @click="editingSection = null"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-5">
                <h3 class="text-base font-semibold text-neutral-900 mb-4">Edit Section</h3>
                <form :action="'{{ url('admin/customize/sections') }}/' + editingSection" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="sectionForm.name" required
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Position</label>
                            <input type="number" name="position" min="0" x-model="sectionForm.position"
                                   class="w-28 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <p class="text-xs text-neutral-400 mt-1">Lower numbers show first in the popup.</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 mt-5 pt-4 border-t border-neutral-100">
                        <button type="button" @click="editingSection = null" class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Add option dialog --}}
        <div x-show="addingTo !== null" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="addingTo = null">
            <div class="absolute inset-0 bg-black/40" @click="addingTo = null"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-5">
                <h3 class="text-base font-semibold text-neutral-900 mb-4">Add Option</h3>
                <form action="{{ route('admin.customize.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="topping_group_id" :value="addingTo">
                    <input type="hidden" name="is_active" value="1">
                    <input type="hidden" name="position" value="0">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="e.g. Bacon"
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Price (&pound;)</label>
                            <input type="number" name="price" step="0.01" min="0" placeholder="Leave blank"
                                   class="w-32 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <p class="text-xs text-neutral-400 mt-1">Leave blank (or 0) and it shows as &ldquo;Included&rdquo;.</p>
                        </div>
                        <div>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="is_preselected" value="1" class="form-checkbox">
                                <span class="text-sm text-neutral-700">Pre-select</span>
                            </label>
                            <p class="text-xs text-neutral-400 mt-1">Arrives already ticked on every item that offers it.</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 mt-5 pt-4 border-t border-neutral-100">
                        <button type="button" @click="addingTo = null" class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Option</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit option dialog --}}
        <div x-show="editingOption !== null" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="editingOption = null">
            <div class="absolute inset-0 bg-black/40" @click="editingOption = null"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-5">
                <h3 class="text-base font-semibold text-neutral-900 mb-4">Edit Option</h3>
                <form :action="'{{ url('admin/customize') }}/' + editingOption" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="optionForm.name" required
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Section</label>
                            <select name="topping_group_id" x-model="optionForm.topping_group_id"
                                    class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">&mdash; Ungrouped (hidden from the popup) &mdash;</option>
                                @foreach($groups as $opt)
                                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Price (&pound;)</label>
                            <input type="number" name="price" step="0.01" min="0" x-model="optionForm.price" placeholder="Leave blank"
                                   class="w-32 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <p class="text-xs text-neutral-400 mt-1">Leave blank (or 0) and it shows as &ldquo;Included&rdquo;.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Position</label>
                            <input type="number" name="position" min="0" x-model="optionForm.position"
                                   class="w-28 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 mt-5 pt-4 border-t border-neutral-100">
                        <button type="button" @click="editingOption = null" class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.admin>
