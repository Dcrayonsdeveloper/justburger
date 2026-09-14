<x-layouts.admin>
    <x-slot name="title">Customers</x-slot>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Customers</h1>
    </div>

    {{-- Stats Bar --}}
    @include('admin.partials.stats-bar', ['stats' => [
        ['label' => 'Total customers', 'value' => number_format($customers->total()), 'sparkline' => '2,16 10,14 18,12 26,10 34,8 42,6 50,4 58,2', 'color' => '#5c6ac4'],
        ['label' => 'Returning rate', 'value' => '0%', 'sparkline' => '2,10 10,10 18,10 26,10 34,10 42,10 50,10 58,10', 'color' => '#47c1bf'],
        ['label' => 'Avg order value', 'value' => '£0', 'sparkline' => '2,10 10,10 18,10 26,10 34,10 42,10 50,10 58,10', 'color' => '#9c6ade'],
    ]])

    {{-- Main card --}}
    <div class="bg-white rounded-xl shadow-sm" x-data="customerBulkActions()">

        {{-- Tabs --}}
        <div class="flex gap-0 px-4" style="border-bottom:1px solid #e1e1e1">
            <a href="{{ route('admin.customers.index') }}"
               class="relative px-4 py-3 text-sm font-medium text-gray-900">
                All
                <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-900 rounded-t"></span>
            </a>
        </div>

        {{-- Search row --}}
        <div class="flex items-center gap-2 p-4" style="border-bottom:1px solid #e1e1e1">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-2 flex-1">
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search customers"
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                </div>
                <button type="submit" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.customers.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                @endif
            </form>
        </div>

        {{-- Bulk actions bar — only once something is ticked --}}
        <div x-show="selected.length > 0" x-cloak class="px-4 py-2.5 bg-gray-50 border-b border-gray-200 flex flex-wrap items-center gap-2">
            <span class="text-sm text-gray-700 mr-1" x-text="selected.length + ' selected'"></span>

            <form method="POST" action="{{ route('admin.customers.bulk-deactivate') }}" class="inline" @submit="return confirmAction($event, 'deactivate')">
                @csrf
                <template x-for="id in selected" :key="'d' + id"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="px-3 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                    Deactivate
                </button>
            </form>

            <form method="POST" action="{{ route('admin.customers.bulk-activate') }}" class="inline" @submit="return confirmAction($event, 'reactivate')">
                @csrf
                <template x-for="id in selected" :key="'a' + id"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="px-3 py-1 text-xs font-medium text-green-700 bg-white border border-gray-300 rounded-md hover:bg-green-50 transition">
                    Reactivate
                </button>
            </form>

            <form method="POST" action="{{ route('admin.customers.bulk-delete') }}" class="inline" @submit="return confirmAction($event, 'delete')">
                @csrf
                <template x-for="id in selected" :key="'x' + id"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="px-3 py-1 text-xs font-medium text-red-600 bg-white border border-gray-300 rounded-md hover:bg-red-50 transition">
                    Delete
                </button>
            </form>

            <button type="button" @click="selected = []" class="text-xs text-gray-500 hover:text-gray-700 ml-1">Clear</button>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50" style="border-bottom:1px solid #e1e1e1">
                        <th class="w-10 px-4 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300" @change="toggleAll($event)"
                                   :checked="allTicked" x-effect="$el.indeterminate = someTicked"
                                   title="Select all on this page">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total spent</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50 cursor-pointer" style="border-bottom:1px solid #e1e1e1"
                            onclick="window.location='{{ route('admin.customers.show', $customer) }}'">
                            <td class="px-4 py-3" onclick="event.stopPropagation()">
                                <input type="checkbox" class="rounded border-gray-300" value="{{ $customer->id }}" x-model="selected">
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $customer->full_name }}
                                        @unless($customer->is_active)
                                            <span class="ml-1.5 text-[10px] font-bold uppercase tracking-wide px-1.5 py-0.5 rounded bg-red-100 text-red-700">Deactivated</span>
                                        @endunless
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $customer->orders_count }}</td>
                            <td class="px-4 py-3 text-gray-700">@price($customer->orders_sum_total ?? 0)</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if($customer->city || $customer->country)
                                    {{ collect([$customer->city, $customer->country])->filter()->implode(', ') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $customer->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">No customers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
            <div class="px-4 py-3 flex items-center justify-between" style="border-top:1px solid #e1e1e1">
                <p class="text-sm text-gray-500">
                    Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ $customers->total() }}
                </p>
                <div class="flex items-center gap-1">
                    @if($customers->onFirstPage())
                        <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-lg">&lsaquo; Previous</span>
                    @else
                        <a href="{{ $customers->previousPageUrl() }}" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">&lsaquo; Previous</a>
                    @endif
                    @if($customers->hasMorePages())
                        <a href="{{ $customers->nextPageUrl() }}" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Next &rsaquo;</a>
                    @else
                        <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-lg">Next &rsaquo;</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

@push('scripts')
<script>
    // Ticking rows reveals the bulk bar; the header box drives every row on the
    // page and shows the indeterminate dash while only some are ticked.
    function customerBulkActions() {
        return {
            selected: [],
            ids: @json($customers->pluck('id')->map(fn ($id) => (string) $id)),
            get allTicked() {
                return this.ids.length > 0 && this.selected.length === this.ids.length;
            },
            get someTicked() {
                return this.selected.length > 0 && this.selected.length < this.ids.length;
            },
            toggleAll(e) {
                this.selected = e.target.checked ? [...this.ids] : [];
            },
            confirmAction(e, kind) {
                const n = this.selected.length;
                const who = n + ' ' + (n === 1 ? 'customer' : 'customers');
                const messages = {
                    deactivate: 'Deactivate ' + who + '? They will be signed out straight away and cannot sign in until reactivated.',
                    reactivate: 'Reactivate ' + who + '? They will be able to sign in again.',
                    delete: 'Delete ' + who + ' permanently? Their past orders are kept, but the account is gone and they could sign up again with the same email.',
                };
                if (!confirm(messages[kind])) {
                    e.preventDefault();
                    return false;
                }
                return true;
            },
        };
    }
</script>
@endpush
</x-layouts.admin>
