<x-layouts.admin>
    <x-slot name="title">Toppings</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-neutral-900">Toppings</h1>
                <p class="text-sm text-neutral-600 mt-1">Manage toppings that can be added to products</p>
            </div>
            <a href="{{ route('admin.toppings.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Topping
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 p-3 bg-success-50 text-success-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-neutral-50 border-b border-neutral-200">
                    <th class="text-left px-4 py-3 font-semibold text-neutral-600">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-neutral-600">Group</th>
                    <th class="text-left px-4 py-3 font-semibold text-neutral-600">Price</th>
                    <th class="text-center px-4 py-3 font-semibold text-neutral-600">Products</th>
                    <th class="text-center px-4 py-3 font-semibold text-neutral-600">Status</th>
                    <th class="text-center px-4 py-3 font-semibold text-neutral-600">Position</th>
                    <th class="text-right px-4 py-3 font-semibold text-neutral-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse($toppings as $topping)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-4 py-3 font-medium text-neutral-900">{{ $topping->name }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ match($topping->group) {
                                    'veggies' => 'bg-green-100 text-green-700',
                                    'cheese' => 'bg-yellow-100 text-yellow-700',
                                    'sauce' => 'bg-orange-100 text-orange-700',
                                    'extras' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-neutral-100 text-neutral-700',
                                } }}">
                                {{ ucfirst($topping->group) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($topping->price > 0)
                                <span class="font-semibold">&pound;{{ number_format($topping->price, 2) }}</span>
                            @else
                                <span class="text-neutral-400">Free</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-neutral-600">{{ $topping->products_count }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($topping->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-700">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-500">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-neutral-500">{{ $topping->position }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.toppings.edit', $topping) }}" class="p-1.5 text-neutral-400 hover:text-primary-600 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.toppings.destroy', $topping) }}" method="POST" onsubmit="return confirm('Delete this topping?')">
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
                        <td colspan="7" class="px-4 py-8 text-center text-neutral-400">No toppings found. Create your first topping.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($toppings->hasPages())
            <div class="px-4 py-3 border-t border-neutral-100">
                {{ $toppings->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
