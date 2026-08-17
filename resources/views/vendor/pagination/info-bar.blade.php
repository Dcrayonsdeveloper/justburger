@if ($paginator->total() > 0)
    <div class="flex items-center justify-between gap-3">
        <div class="text-sm text-neutral-600">
            @if ($paginator->total() === 1)
                Showing <span class="font-medium text-neutral-900">1</span> result
            @else
                Showing
                <span class="font-medium text-neutral-900">{{ $paginator->firstItem() }}</span>–<span class="font-medium text-neutral-900">{{ $paginator->lastItem() }}</span>
                of <span class="font-medium text-neutral-900">{{ $paginator->total() }}</span>
            @endif
        </div>

        @if ($paginator->hasPages())
            <div class="flex items-center gap-1">
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-neutral-400 border border-neutral-200 rounded-lg cursor-not-allowed" aria-hidden="true">&lsaquo;</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 py-1.5 text-sm text-neutral-700 border border-neutral-300 rounded-lg hover:bg-neutral-50" aria-label="Previous">&lsaquo;</a>
                @endif

                <span class="px-2 text-sm text-neutral-500">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 py-1.5 text-sm text-neutral-700 border border-neutral-300 rounded-lg hover:bg-neutral-50" aria-label="Next">&rsaquo;</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-neutral-400 border border-neutral-200 rounded-lg cursor-not-allowed" aria-hidden="true">&rsaquo;</span>
                @endif
            </div>
        @endif
    </div>
@endif
