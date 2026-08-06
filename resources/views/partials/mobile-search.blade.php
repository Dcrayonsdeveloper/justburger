<!-- Mobile Search Sheet -->
<div x-data="{ open: false }"
     @toggle-mobile-search.window="open = !open; if (open) $nextTick(() => $refs.mobileSearchInput.focus())"
     @keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="lg:hidden fixed inset-0 z-50"
     role="dialog"
     aria-modal="true"
     aria-label="Search">

    <!-- Backdrop -->
    <div x-show="open"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div x-show="open"
         x-transition:enter="transition-transform ease-out duration-250"
         x-transition:enter-start="-translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition-transform ease-in duration-150"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="-translate-y-full"
         class="fixed top-0 left-0 right-0 bg-[#111111] shadow-xl">

        <div class="flex items-center gap-2 px-4 py-3">
            <form action="{{ route('search') }}" method="GET" class="flex-1">
                <div class="relative">
                    <svg class="w-4 h-4 text-white/40 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" name="q" x-ref="mobileSearchInput"
                           value="{{ request('q') }}"
                           placeholder="Search the menu..."
                           autocomplete="off" enterkeyhint="search"
                           class="w-full pl-9 pr-3 py-2.5 text-sm bg-white/5 border border-white/10 rounded text-white placeholder-white/30 focus:outline-none focus:border-[#C8102E]">
                </div>
            </form>
            <button @click="open = false" class="p-2 text-white/60 hover:text-white rounded-full hover:bg-white/10 focus:outline-none shrink-0" aria-label="Close search">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        @if(!empty($navCategories) && count($navCategories))
            <div class="px-4 pb-4">
                <p class="text-[11px] font-bold text-white/30 uppercase tracking-widest mb-2">Browse the menu</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($navCategories as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                           class="px-3 py-1.5 text-xs font-semibold text-white/70 bg-white/5 border border-white/10 rounded-full hover:bg-white/10 hover:text-white transition-colors">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
