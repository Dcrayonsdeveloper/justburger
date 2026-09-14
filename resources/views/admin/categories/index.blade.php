<x-layouts.admin>
    <x-slot name="title">Collections</x-slot>

    {{-- Header: "Collections" title + "Add collection" button --}}
    <div class="flex items-center justify-between mb-4">
        <h1 style="font-size:20px;font-weight:600;color:#1a1a1a;line-height:28px">Collections</h1>
        <a href="{{ route('admin.categories.create') }}"
           style="background:#1a1a1a;color:#fff;font-size:13px;font-weight:500;padding:6px 12px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px"
           onmouseenter="this.style.background='#333'"
           onmouseleave="this.style.background='#1a1a1a'">
            Add collection
        </a>
    </div>

    {{-- Main card --}}
    <div style="background:#fff;border-radius:12px;box-shadow:0 1px 2px rgba(0,0,0,0.06),0 0 0 1px rgba(0,0,0,0.07)"
         x-data="categoryBulkActions()">

        {{-- Tab row + toolbar --}}
        <div class="flex items-center justify-between" style="padding:0 12px;border-bottom:1px solid #e1e1e1">
            <div class="flex items-center gap-0">
                {{-- "All" tab --}}
                <button style="font-size:13px;font-weight:500;color:#1a1a1a;padding:10px 12px;border-bottom:2px solid #1a1a1a;background:none;border-top:none;border-left:none;border-right:none;cursor:pointer">
                    All
                </button>
            </div>
        </div>

        {{-- Bulk actions bar — only once something is ticked --}}
        <div x-show="selected.length > 0" x-cloak
             class="flex items-center gap-3"
             style="padding:10px 12px;background:#f7f7f7;border-bottom:1px solid #e1e1e1">
            <span style="font-size:13px;color:#1a1a1a" x-text="selected.length + ' selected'"></span>
            <form method="POST" action="{{ route('admin.categories.bulk-delete') }}" class="inline" @submit="return confirmDelete($event)">
                @csrf
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit"
                        style="background:#fff;border:1px solid #ccc;color:#d72c0d;font-size:12px;font-weight:500;padding:4px 10px;border-radius:6px;cursor:pointer"
                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                    Delete selected
                </button>
            </form>
            <button type="button" @click="selected = []" style="font-size:12px;color:#616161;background:none;border:none;cursor:pointer">Clear</button>
        </div>

        {{-- Table --}}
        @if($categories->total() > 0)
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="border-bottom:1px solid #e1e1e1">
                        <th style="width:28px;padding:10px 0 10px 12px;text-align:left">
                            <input type="checkbox" @change="toggleAll($event)"
                                   :checked="allTicked" x-effect="$el.indeterminate = someTicked"
                                   title="Select all on this page"
                                   style="width:16px;height:16px;accent-color:#1a1a1a;cursor:pointer;border-radius:4px" />
                        </th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Title</th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Products</th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Product conditions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr style="border-bottom:1px solid #e1e1e1;cursor:pointer"
                            onclick="window.location='{{ route('admin.categories.edit', $category) }}'"
                            onmouseenter="this.style.background='#f9f9f9'"
                            onmouseleave="this.style.background='#fff'">
                            <td style="width:28px;padding:10px 0 10px 12px" onclick="event.stopPropagation()">
                                <input type="checkbox" value="{{ $category->id }}" x-model="selected"
                                       style="width:16px;height:16px;accent-color:#1a1a1a;cursor:pointer;border-radius:4px" />
                            </td>
                            <td style="padding:10px 12px">
                                <div class="flex items-center gap-3">
                                    @if($category->image_url)
                                        <img src="{{ asset(ltrim($category->image_url, '/')) }}" alt="{{ $category->name }}"
                                             style="width:36px;height:36px;border-radius:8px;object-fit:cover;border:1px solid #e1e1e1;flex-shrink:0" />
                                    @else
                                        <div style="width:36px;height:36px;border-radius:8px;background:#f1f1f1;border:1px solid #e1e1e1;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                                                <path d="M3.5 3A1.5 1.5 0 002 4.5v11A1.5 1.5 0 003.5 17h13a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0016.5 3h-13zm4.25 4a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0zm-1.06 2.81L5 12.44V15.5h10v-2.44l-2.31-2.31a.75.75 0 00-1.06 0L9.31 13 7.75 11.44a1 1 0 00-1.06-.63z" fill="#8a8a8a"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <span style="font-size:13px;font-weight:500;color:#1a1a1a">{{ $category->name }}</span>
                                        @if($category->children && $category->children->count() > 0)
                                            <p style="font-size:12px;color:#616161;margin:1px 0 0 0">{{ $category->children->count() }} subcollections</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding:10px 12px;font-size:13px;color:#1a1a1a">
                                {{ $category->total_products_count ?? $category->products_count }}
                            </td>
                            <td style="padding:10px 12px;font-size:13px;color:#1a1a1a">
                                @if($category->parent)
                                    {{ $category->parent->name }}
                                @elseif($category->is_active)
                                    <span style="color:#616161">Manual</span>
                                @else
                                    <span style="color:#616161">Draft</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($categories->hasPages())
                <div class="flex items-center justify-center" style="padding:12px 16px;border-top:1px solid #e1e1e1">
                    <div class="flex items-center gap-2">
                        {{-- Previous --}}
                        @if($categories->onFirstPage())
                            <span style="padding:4px 8px;border:1px solid #e1e1e1;border-radius:8px;cursor:not-allowed;opacity:0.4;display:flex;align-items:center">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M12 5l-5 5 5 5" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" style="padding:4px 8px;border:1px solid #ccc;border-radius:8px;display:flex;align-items:center;text-decoration:none" onmouseenter="this.style.background='#f6f6f6'" onmouseleave="this.style.background='#fff'">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M12 5l-5 5 5 5" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @endif

                        <span style="font-size:13px;color:#1a1a1a">{{ $categories->currentPage() }} of {{ $categories->lastPage() }}</span>

                        {{-- Next --}}
                        @if($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" style="padding:4px 8px;border:1px solid #ccc;border-radius:8px;display:flex;align-items:center;text-decoration:none" onmouseenter="this.style.background='#f6f6f6'" onmouseleave="this.style.background='#fff'">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M8 5l5 5-5 5" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span style="padding:4px 8px;border:1px solid #e1e1e1;border-radius:8px;cursor:not-allowed;opacity:0.4;display:flex;align-items:center">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M8 5l5 5-5 5" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center" style="padding:60px 20px;text-align:center">
                <div style="width:48px;height:48px;border-radius:12px;background:#f1f1f1;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                    <svg width="24" height="24" viewBox="0 0 20 20" fill="none">
                        <path d="M3.5 3A1.5 1.5 0 002 4.5v11A1.5 1.5 0 003.5 17h13a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0016.5 3h-13z" fill="#8a8a8a"/>
                    </svg>
                </div>
                <p style="font-size:14px;font-weight:500;color:#1a1a1a;margin:0 0 4px 0">No collections found</p>
                <p style="font-size:13px;color:#616161;margin:0 0 16px 0">Create your first collection to organize your products.</p>
                <a href="{{ route('admin.categories.create') }}"
                   style="background:#1a1a1a;color:#fff;font-size:13px;font-weight:500;padding:6px 12px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center"
                   onmouseenter="this.style.background='#333'"
                   onmouseleave="this.style.background='#1a1a1a'">
                    Add collection
                </a>
            </div>
        @endif
    </div>

@push('scripts')
<script>
    // Ticking rows reveals the bulk bar; the header box drives every row on the
    // page and shows the indeterminate dash while only some are ticked.
    function categoryBulkActions() {
        return {
            selected: [],
            ids: @json($categories->pluck('id')->map(fn ($id) => (string) $id)),
            get allTicked() {
                return this.ids.length > 0 && this.selected.length === this.ids.length;
            },
            get someTicked() {
                return this.selected.length > 0 && this.selected.length < this.ids.length;
            },
            toggleAll(e) {
                this.selected = e.target.checked ? [...this.ids] : [];
            },
            confirmDelete(e) {
                const n = this.selected.length;
                if (!confirm('Delete ' + n + ' ' + (n === 1 ? 'collection' : 'collections') + '? Products in them are kept but left with no category.')) {
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
