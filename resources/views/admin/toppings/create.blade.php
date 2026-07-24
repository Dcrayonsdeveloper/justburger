<x-layouts.admin>
    <x-slot name="title">Add Topping</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.toppings.index') }}" class="p-1.5 text-neutral-400 hover:text-neutral-600 rounded-lg hover:bg-neutral-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-2xl font-bold text-neutral-900">Add Topping</h1>
        </div>
    </x-slot>

    <div class="max-w-lg">
        <form action="{{ route('admin.toppings.store') }}" method="POST" class="card p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-neutral-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-neutral-700 mb-1">Price (&pound;)</label>
                <input type="number" name="price" id="price" value="{{ old('price', '0.00') }}" step="0.01" min="0"
                       class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <p class="text-xs text-neutral-400 mt-1">Set to 0 for free/included toppings</p>
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="group" class="block text-sm font-medium text-neutral-700 mb-1">Group <span class="text-red-500">*</span></label>
                <select name="group" id="group" class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="veggies" {{ old('group') === 'veggies' ? 'selected' : '' }}>Veggies</option>
                    <option value="cheese" {{ old('group') === 'cheese' ? 'selected' : '' }}>Cheese</option>
                    <option value="sauce" {{ old('group') === 'sauce' ? 'selected' : '' }}>Sauce</option>
                    <option value="extras" {{ old('group', 'extras') === 'extras' ? 'selected' : '' }}>Extras</option>
                </select>
                @error('group') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="position" class="block text-sm font-medium text-neutral-700 mb-1">Position</label>
                <input type="number" name="position" id="position" value="{{ old('position', 0) }}" min="0"
                       class="w-full px-3 py-2 border border-neutral-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-primary-600 rounded border-neutral-300 focus:ring-primary-500">
                <label for="is_active" class="text-sm text-neutral-700">Active</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Create Topping</button>
                <a href="{{ route('admin.toppings.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
