{{--
    One section's options. `$items` is the topping collection, `$group` the
    section it belongs to (null for the Ungrouped bucket, which has no
    "Add option" button because there is nothing to add it to).
--}}
<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-neutral-50 border-b border-neutral-200">
                <th class="text-left px-4 py-2.5 font-semibold text-neutral-600">Option</th>
                <th class="text-left px-4 py-2.5 font-semibold text-neutral-600">Price</th>
                <th class="text-center px-4 py-2.5 font-semibold text-neutral-600">Status</th>
                <th class="text-right px-4 py-2.5 font-semibold text-neutral-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-100">
            @forelse($items as $topping)
                <tr class="hover:bg-neutral-50 transition-colors">
                    <td class="px-4 py-3 font-medium text-neutral-900">{{ $topping->name }}</td>
                    <td class="px-4 py-3">
                        @if((float) $topping->price > 0)
                            <span class="font-semibold">&pound;{{ number_format($topping->price, 2) }}</span>
                        @else
                            <span class="text-green-600 font-medium">Included</span>
                        @endif
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
                                    @click="editingOption = {{ $topping->id }}; optionForm = {{ Js::from([
                                        'name' => $topping->name,
                                        'price' => (float) $topping->price > 0 ? number_format((float) $topping->price, 2, '.', '') : '',
                                        'position' => (int) $topping->position,
                                        'topping_group_id' => $topping->topping_group_id ? (string) $topping->topping_group_id : '',
                                    ]) }}"
                                    class="p-1.5 text-neutral-400 hover:text-primary-600 rounded transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.customize.destroy', $topping) }}" method="POST"
                                  onsubmit="return confirm('Delete &quot;{{ $topping->name }}&quot;? It disappears from the customize popup on every item. Switch it Inactive instead if you only want to hide it.')">
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
                    <td colspan="4" class="px-4 py-6 text-center text-neutral-400">
                        No options in this section yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($group)
    <div class="px-4 py-3 border-t border-neutral-100 bg-neutral-50/60">
        <button type="button" @click="addingTo = {{ $group->id }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add option to {{ $group->name }}
        </button>
    </div>
@endif
