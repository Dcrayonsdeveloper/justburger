<x-layouts.admin>
    <x-slot name="title">Customize</x-slot>

    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Customize</h1>
            <p class="text-sm text-neutral-600 mt-1">Toppings customers can add. Every topping here appears in the popup for any product with Customize turned on under Menu &rarr; All Items.</p>
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

    {{-- ── Add topping ── --}}
    <div class="card p-5 mb-6">
        <h2 class="text-base font-semibold text-neutral-900 mb-1">Add Topping</h2>
        <p class="text-xs text-neutral-500 mb-4">Leave the price at 0.00 for a free topping. Tick <strong>Pre-select</strong> and it arrives already ticked in the customer's popup.</p>

        <form action="{{ route('admin.customize.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">

                <div class="md:col-span-4">
                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="e.g. Bacon"
                           class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>

                <div class="md:col-span-3">
                    <label for="price" class="block text-sm font-medium text-neutral-700 mb-1">Price (&pound;)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', '0.00') }}"
                           class="w-32 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <p class="text-xs text-neutral-400 mt-1">0.00 shows as &ldquo;Free&rdquo;</p>
                </div>

                <div class="md:col-span-5 flex flex-col gap-2 md:pt-7">
                    <label class="inline-flex items-center gap-1.5 text-sm text-neutral-700 cursor-pointer select-none">
                        <input type="checkbox" name="is_preselected" value="1"
                               class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                        Pre-select
                    </label>
                    <label class="inline-flex items-center gap-1.5 text-sm text-neutral-700 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                        Active
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-neutral-100">
                <input type="hidden" name="position" value="{{ old('position', 0) }}">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Topping
                </button>
            </div>
        </form>
    </div>

    {{-- ── All toppings ── --}}
    <div class="card overflow-hidden" x-data="{ editing: null, form: {} }">
        <div class="px-5 py-4 border-b border-neutral-100 flex items-center justify-between">
            <h2 class="text-base font-semibold text-neutral-900">All Toppings</h2>
            <span class="text-xs text-neutral-500">{{ $toppings->count() }} total</span>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-neutral-50 border-b border-neutral-200">
                    <th class="text-left px-4 py-3 font-semibold text-neutral-600">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-neutral-600">Price</th>
                    <th class="text-center px-4 py-3 font-semibold text-neutral-600">Pre-select</th>
                    <th class="text-center px-4 py-3 font-semibold text-neutral-600">Status</th>
                    <th class="text-right px-4 py-3 font-semibold text-neutral-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($toppings as $topping)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-neutral-900">{{ $topping->name }}</td>
                        <td class="px-4 py-3">
                            @if($topping->price > 0)
                                <span class="font-semibold">&pound;{{ number_format($topping->price, 2) }}</span>
                            @else
                                <span class="text-green-600 font-medium">Free</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.customize.toggle-preselected', $topping) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf @method('PUT')
                                <button type="submit" role="switch" aria-checked="{{ $topping->is_preselected ? 'true' : 'false' }}"
                                        title="{{ $topping->is_preselected ? 'Stop this topping arriving ticked' : 'Make this topping arrive ticked in the popup' }}"
                                        style="position:relative;display:inline-block;width:2.5rem;height:1.35rem;border:none;border-radius:99px;cursor:pointer;transition:background .15s;background:{{ $topping->is_preselected ? '#C8102E' : '#d4d4d4' }};">
                                    <span style="position:absolute;top:.15rem;left:.15rem;width:1.05rem;height:1.05rem;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .15s;{{ $topping->is_preselected ? 'transform:translateX(1.15rem);' : '' }}"></span>
                                </button>
                                <span class="text-xs font-medium {{ $topping->is_preselected ? 'text-primary-700' : 'text-neutral-400' }}">{{ $topping->is_preselected ? 'On' : 'Off' }}</span>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.customize.toggle-active', $topping) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf @method('PUT')
                                <button type="submit" role="switch" aria-checked="{{ $topping->is_active ? 'true' : 'false' }}"
                                        title="{{ $topping->is_active ? 'Switch off' : 'Switch on' }}"
                                        style="position:relative;display:inline-block;width:2.5rem;height:1.35rem;border:none;border-radius:99px;cursor:pointer;transition:background .15s;background:{{ $topping->is_active ? '#16a34a' : '#d4d4d4' }};">
                                    <span style="position:absolute;top:.15rem;left:.15rem;width:1.05rem;height:1.05rem;background:#fff;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .15s;{{ $topping->is_active ? 'transform:translateX(1.15rem);' : '' }}"></span>
                                </button>
                                <span class="text-xs font-medium {{ $topping->is_active ? 'text-success-700' : 'text-neutral-400' }}">{{ $topping->is_active ? 'Active' : 'Inactive' }}</span>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button type="button"
                                        @click="editing = {{ $topping->id }}; form = {{ Js::from([
                                            'name' => $topping->name,
                                            'price' => number_format((float) $topping->price, 2, '.', ''),
                                            'position' => (int) $topping->position,
                                        ]) }}"
                                        class="p-1.5 text-neutral-400 hover:text-primary-600 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.customize.destroy', $topping) }}" method="POST"
                                      onsubmit="return confirm('Delete &quot;{{ $topping->name }}&quot;? It will disappear from the customize popup everywhere. Set it Inactive instead if you only want to hide it.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-neutral-400 hover:text-red-600 rounded transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-neutral-400">No toppings yet &mdash; add your first one above.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Edit modal --}}
        <div x-show="editing !== null" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="editing = null">
            <div class="absolute inset-0 bg-black/40" @click="editing = null"></div>

            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-5">
                <h3 class="text-base font-semibold text-neutral-900 mb-4">Edit Topping</h3>

                <form :action="'{{ url('admin/customize') }}/' + editing" method="POST">
                    @csrf @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="form.name" required
                                   class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Price (&pound;)</label>
                            <input type="number" name="price" step="0.01" min="0" x-model="form.price"
                                   class="w-32 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Position</label>
                            <input type="number" name="position" min="0" x-model="form.position"
                                   class="w-28 px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-2 mt-5 pt-4 border-t border-neutral-100">
                        <button type="button" @click="editing = null" class="px-4 py-2 text-sm font-medium text-neutral-600 hover:text-neutral-900">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.admin>
