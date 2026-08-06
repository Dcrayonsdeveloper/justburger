<x-layouts.app>
    <x-slot name="title">
        {{ request('category') ? ($categories->firstWhere('slug', request('category'))?->name ?? 'Menu') : 'Full Menu' }} — {{ \App\Models\Setting::get('site_name', config('app.name')) }}
    </x-slot>

    @push('meta')
        @php
            $metaCat   = request('category') ? ($categories->firstWhere('slug', request('category'))?->name ?? null) : null;
            $siteName  = \App\Models\Setting::get('site_name', config('app.name'));
            $metaDesc  = $metaCat
                ? "Order {$metaCat} from {$siteName}. Browse our full menu and place your order online or on WhatsApp."
                : "Browse the full menu at {$siteName}. Fresh burgers, sides, drinks and more — order online or on WhatsApp.";
        @endphp
        <meta name="description" content="{{ $metaDesc }}">
        <link rel="canonical" href="{{ url('/menu') }}">
        <meta property="og:title" content="{{ $metaCat ?? 'Full Menu' }} — {{ $siteName }}">
        <meta property="og:description" content="{{ $metaDesc }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/menu') }}">
        @if(request()->anyFilled(['category', 'brand', 'min_price', 'max_price', 'rating', 'in_stock', 'on_sale', 'sort']))
            <meta name="robots" content="noindex, follow">
        @endif
    @endpush

    <x-slot name="styles">
    <style>
        .menu-page { background:#fafaf8; color:#111111; min-height:60vh; }

        /* Page header */
        .menu-page-header {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:1.25rem 1.25rem 1rem;
        }
        @media(min-width:1024px){ .menu-page-header { padding:1.5rem 2rem 1.25rem; } }

        /* Header search */
        .menu-search {
            position:relative;
            flex:1 1 220px;
            max-width:340px;
        }
        .menu-search-icon {
            position:absolute; left:.85rem; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:rgba(0,0,0,.35); pointer-events:none;
        }
        .menu-search input {
            width:100%;
            padding:.6rem 1rem .6rem 2.35rem;
            font-size:.85rem;
            color:#111111;
            background:#fff;
            border:1px solid rgba(0,0,0,.15);
            border-radius:99px;
            outline:none;
            transition:border-color .15s ease, box-shadow .15s ease;
        }
        .menu-search input::placeholder { color:rgba(0,0,0,.35); }
        .menu-search input:focus {
            border-color:#C8102E;
            box-shadow:0 0 0 3px rgba(200,16,46,.12);
        }
        .menu-search input::-webkit-search-cancel-button { cursor:pointer; }
        /* Full width on mobile — this is the only search box on the site */
        @media(max-width:1023px){
            .menu-search { flex-basis:100%; max-width:none; }
        }

        /* Category tabs */
        .cat-tabs {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            overflow:visible;
        }
        .cat-tabs-inner {
            max-width:1240px;
            margin:0 auto;
            display:flex;
            gap:.4rem;
            overflow-x:auto;
            padding:.65rem 1.25rem .85rem;
            -webkit-overflow-scrolling:touch;
        }
        .cat-tabs-inner::-webkit-scrollbar { height:4px; }
        .cat-tabs-inner::-webkit-scrollbar-track { background:transparent; }
        .cat-tabs-inner::-webkit-scrollbar-thumb { background:rgba(0,0,0,.15); border-radius:4px; }
        .cat-tabs-inner { scrollbar-width:thin; scrollbar-color:rgba(0,0,0,.15) transparent; }
        .cat-tab {
            display:inline-flex;
            align-items:center;
            padding:.4rem .95rem;
            font-size:.8rem;
            font-weight:600;
            border-radius:99px;
            white-space:nowrap;
            text-decoration:none;
            border:1.5px solid rgba(0,0,0,.14);
            color:rgba(0,0,0,.55);
            background:#fff;
            transition:all .14s;
            flex-shrink:0;
        }
        .cat-tab:hover { border-color:#C8102E; color:#C8102E; }
        .cat-tab.active { background:#C8102E; color:#fff; border-color:#C8102E; }

        /* Sort select */
        .menu-sort-select {
            font-size:.8rem;
            color:rgba(0,0,0,.6);
            border:1px solid rgba(0,0,0,.15);
            border-radius:.35rem;
            padding:.38rem 2rem .38rem .65rem;
            outline:none;
            cursor:pointer;
            appearance:none;
            background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='rgba(0,0,0,.4)' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right .6rem center;
        }
        .menu-sort-select:focus { border-color:#C8102E; }

        /* Product list item (Nando's style) */
        .menu-item-row {
            display:flex;
            align-items:center;
            gap:1rem;
            padding:.9rem 1.25rem;
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.06);
            transition:background .1s;
        }
        .menu-item-row:last-child { border-bottom:none; }
        .menu-item-row:hover { background:#fef5f5; }
        .menu-item-link {
            flex:1;
            min-width:0;
            text-decoration:none;
            color:inherit;
            display:block;
        }
        .menu-item-cat {
            font-size:.62rem;
            font-weight:700;
            letter-spacing:.1em;
            text-transform:uppercase;
            color:#C8102E;
            margin-bottom:.18rem;
        }
        .menu-item-name {
            font-size:.93rem;
            font-weight:700;
            color:#111111;
            line-height:1.3;
            margin-bottom:.2rem;
        }
        .menu-item-desc {
            font-size:.77rem;
            color:rgba(0,0,0,.48);
            line-height:1.45;
            margin-bottom:.35rem;
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient:vertical;
            overflow:hidden;
        }
        .menu-item-price {
            font-size:.9rem;
            font-weight:700;
            color:#111111;
        }
        .menu-item-right {
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:.45rem;
            flex-shrink:0;
        }
        .menu-item-img {
            width:86px;
            height:86px;
            border-radius:.55rem;
            object-fit:cover;
            display:block;
        }
        @media(max-width:480px){
            .menu-item-img { width:72px; height:72px; }
            .menu-item-row { padding:.8rem 1rem; }
        }
        .menu-add-btn {
            width:86px;
            padding:.32rem .5rem;
            font-size:.7rem;
            font-weight:700;
            border:none;
            border-radius:99px;
            cursor:pointer;
            background:#C8102E;
            color:#fff;
            transition:background .14s;
            text-align:center;
        }
        @media(max-width:480px){ .menu-add-btn { width:72px; font-size:.65rem; } }

        /* Cart sidebar */
        .cart-sidebar {
            display:none;
        }
        @media(min-width:1024px) {
            .cart-sidebar {
                display:flex;
                flex-direction:column;
                position:sticky;
                top:calc(72px + 48px + 1rem);
                align-self:flex-start;
                width:310px;
                flex-shrink:0;
                max-height:calc(100vh - 72px - 48px - 2rem);
                background:#fff;
                border:1px solid rgba(0,0,0,.1);
                border-top:3px solid #C8102E;
                border-radius:.75rem;
                overflow:hidden;
                box-shadow:0 2px 16px rgba(0,0,0,.06);
            }
        }
        .cs-head {
            padding:.9rem 1.1rem;
            border-bottom:1px solid rgba(0,0,0,.07);
            flex-shrink:0;
        }
        .cs-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900;
            font-size:1.15rem;
            text-transform:uppercase;
            letter-spacing:.04em;
            color:#111111;
        }
        /* Scrollable items area */
        .cs-items {
            flex:1;
            overflow-y:auto;
            min-height:0;
        }
        .cs-items::-webkit-scrollbar { width:4px; }
        .cs-items::-webkit-scrollbar-track { background:transparent; }
        .cs-items::-webkit-scrollbar-thumb { background:rgba(0,0,0,.14); border-radius:4px; }
        .cs-footer {
            border-top:1px solid rgba(0,0,0,.08);
            padding:.9rem 1.1rem;
            flex-shrink:0;
            background:#fff;
        }
        .cs-row {
            display:flex;
            align-items:flex-start;
            gap:.65rem;
            padding:.7rem 1.1rem;
            border-bottom:1px solid rgba(0,0,0,.05);
        }
        .cs-row:last-child { border-bottom:none; }
        .cs-row-body { flex:1; min-width:0; }
        .cs-row-name { font-size:.83rem; font-weight:600; color:#111111; line-height:1.3; }
        .cs-row-line { font-size:.78rem; color:rgba(0,0,0,.45); margin-top:.12rem; }
        .cs-qty-wrap { display:flex; align-items:center; gap:.4rem; margin-top:.35rem; }
        .cs-qty-btn {
            width:22px; height:22px; border-radius:50%;
            border:1.5px solid rgba(0,0,0,.2);
            background:#fff; display:flex; align-items:center; justify-content:center;
            cursor:pointer; color:#111111; transition:all .12s; flex-shrink:0;
        }
        .cs-qty-btn:hover { border-color:#C8102E; color:#C8102E; }
        .cs-qty-val { font-size:.82rem; font-weight:700; min-width:1.2rem; text-align:center; }
        .cs-del-btn {
            background:none; border:none; cursor:pointer; padding:.2rem;
            color:rgba(0,0,0,.22); flex-shrink:0; transition:color .12s;
        }
        .cs-del-btn:hover { color:#C8102E; }
        .cs-empty {
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:2.5rem 1.5rem; text-align:center;
        }

        /* Mobile FAB */
        .order-fab {
            position:fixed; bottom:76px; left:50%;
            transform:translateX(-50%);
            z-index:35;
            display:flex; align-items:center; gap:.55rem;
            padding:.65rem 1.4rem;
            background:#111111; color:#fff;
            font-weight:700; font-size:.85rem;
            border-radius:99px;
            box-shadow:0 4px 20px rgba(0,0,0,.3);
            white-space:nowrap; text-decoration:none;
        }

        @keyframes spin { to { transform:rotate(360deg); } }
    </style>
    </x-slot>

    @php
        $activeCat  = request('category');
        $searchTerm = trim((string) request('q'));
        $metaCat   = $activeCat ? ($categories->firstWhere('slug', $activeCat)?->name ?? null) : null;
        $freeThreshold = \App\Models\Setting::get('free_delivery_threshold', 20);
    @endphp

    <div class="menu-page">

        {{-- ── Page header ── --}}
        <div class="menu-page-header">
            <div style="max-width:1240px; margin:0 auto;">
                <nav style="display:flex;align-items:center;gap:.35rem;font-size:.78rem;color:rgba(0,0,0,.38);margin-bottom:.55rem;">
                    <a href="{{ url('/') }}" style="color:rgba(0,0,0,.38);text-decoration:none;" class="hover:text-[#C8102E] transition-colors">Home</a>
                    <span>/</span>
                    <span style="color:#111111;font-weight:600;">Our Menu</span>
                </nav>
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;">
                    <div>
                        <h1 style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:clamp(1.6rem,4vw,2.2rem);text-transform:uppercase;letter-spacing:.04em;color:#111111;line-height:1.1;">
                            {{ $metaCat ?? 'Our Full Menu' }}
                        </h1>
                        @if($searchTerm)
                            <p style="font-size:.82rem;color:rgba(0,0,0,.42);margin-top:.15rem;">
                                {{ $products->total() }} {{ Str::plural('result', $products->total()) }} for
                                <span style="color:#111111;font-weight:600;">"{{ $searchTerm }}"</span>
                                <a href="{{ route('products.index', request()->except(['q','page'])) }}"
                                   style="color:#C8102E;font-weight:600;text-decoration:none;margin-left:.35rem;">Clear</a>
                            </p>
                        @else
                            <p style="font-size:.82rem;color:rgba(0,0,0,.42);margin-top:.15rem;">{{ $products->total() }} items</p>
                        @endif
                    </div>
                    <form action="{{ route('products.index') }}" method="GET" class="menu-search" id="menu-search">
                        <svg class="menu-search-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="search" name="q" id="menu-search-input" value="{{ request('q') }}"
                               placeholder="Search the menu..."
                               autocomplete="off" enterkeyhint="search"
                               aria-label="Search the menu">
                        @if(request()->filled('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Category tabs ── --}}
        <div class="cat-tabs">
            <div class="cat-tabs-inner">
                <a href="{{ route('products.index', array_merge(request()->except(['category','page']), [])) }}"
                   class="cat-tab {{ !$activeCat ? 'active' : '' }}">All</a>
                @foreach($categories as $category)
                <a href="{{ route('products.index', array_merge(request()->except(['category','page']), ['category' => $category->slug])) }}"
                   class="cat-tab {{ $activeCat === $category->slug ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var active = document.querySelector('.cat-tab.active');
                if (active) {
                    active.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'instant' });
                }
            });

            // Arriving from the header / bottom-bar search icon (#menu-search):
            // scroll the box into view and focus it.
            (function () {
                function focusSearch() {
                    if (window.location.hash !== '#menu-search') return;
                    var input = document.getElementById('menu-search-input');
                    if (!input) return;
                    input.scrollIntoView({ block: 'center', behavior: 'smooth' });
                    input.focus({ preventScroll: true });
                }
                document.addEventListener('DOMContentLoaded', focusSearch);
                window.addEventListener('hashchange', focusSearch);
            })();
        </script>

        {{-- ── Main layout ── --}}
        <div style="max-width:1240px; margin:0 auto; padding:1.25rem 1rem 5rem;">
            <div style="display:flex; align-items:flex-start; gap:1.25rem;">

                {{-- ── Products area ── --}}
                <div style="flex:1; min-width:0;">

                    {{-- Toolbar --}}
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.55rem 1.25rem;background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:.75rem .75rem 0 0;border-bottom:none;">
                        <span style="font-size:.78rem;color:rgba(0,0,0,.38);margin-right:auto;">{{ $products->total() }} items</span>
                        @if(request()->hasAny(['category','min_price','max_price','rating','in_stock','on_sale']))
                        <a href="{{ route('products.index', request()->only(['category','sort','q'])) }}"
                           style="font-size:.75rem;color:#C8102E;font-weight:600;text-decoration:none;">Clear filters</a>
                        @endif
                        <div style="display:flex;align-items:center;gap:.4rem;">
                            <label style="font-size:.77rem;color:rgba(0,0,0,.38);" class="hidden sm:inline">Sort:</label>
                            <select class="menu-sort-select"
                                    onchange="window.location.href = '{{ route('products.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})">
                                <option value="newest"      {{ request('sort') === 'newest'      ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc"   {{ request('sort') === 'price_asc'   ? 'selected' : '' }}>Price ↑</option>
                                <option value="price_desc"  {{ request('sort') === 'price_desc'  ? 'selected' : '' }}>Price ↓</option>
                                <option value="rating"      {{ request('sort') === 'rating'      ? 'selected' : '' }}>Top Rated</option>
                                <option value="bestselling" {{ request('sort') === 'bestselling' ? 'selected' : '' }}>Bestselling</option>
                            </select>
                        </div>
                    </div>

                    {{-- Items list --}}
                    @if($products->count())
                        <div style="background:#fff;border:1px solid rgba(0,0,0,.08);border-top:none;border-radius:0 0 .75rem .75rem;overflow:hidden;">
                            @foreach($products as $product)
                            @php
                                $rawImg = $product->primary_image_url;
                                $imgSrc = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
                                    ? $rawImg
                                    : asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
                                $fallback = asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
                            @endphp
                            <div class="menu-item-row" x-data="{ adding:false, added:false }">
                                <a href="{{ route('product.show', $product) }}" class="menu-item-link">
                                    @if($product->category)
                                    <div class="menu-item-cat">{{ $product->category->name }}</div>
                                    @endif
                                    <div class="menu-item-name">{{ $product->name }}</div>
                                    @if($product->short_description)
                                    <div class="menu-item-desc">{{ $product->short_description }}</div>
                                    @endif
                                    <div class="menu-item-price">@price($product->price)</div>
                                </a>
                                <div class="menu-item-right">
                                    <img src="{{ $imgSrc }}"
                                         alt="{{ $product->name }}"
                                         class="menu-item-img"
                                         loading="lazy"
                                         onerror="this.onerror=null;this.src='{{ $fallback }}';">
                                    <button class="menu-add-btn"
                                            @click.prevent="$store.toppingsModal.open({{ $product->id }}, 1)"
                                            style="background:#C8102E;color:#fff;">
                                        + Add
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($products->hasPages())
                        <nav style="display:flex;align-items:center;justify-content:center;gap:.35rem;padding:1.25rem 0;">
                            {{-- Previous --}}
                            @if($products->onFirstPage())
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:rgba(0,0,0,.2);cursor:default;">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @php
                                $current = $products->currentPage();
                                $last = $products->lastPage();
                                $pages = [];
                                $pages[] = 1;
                                for ($i = max(2, $current - 1); $i <= min($last - 1, $current + 1); $i++) {
                                    $pages[] = $i;
                                }
                                if ($last > 1) $pages[] = $last;
                                $pages = array_unique($pages);
                                sort($pages);
                            @endphp
                            @foreach($pages as $k => $page)
                                @if($k > 0 && $page - $pages[$k - 1] > 1)
                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:36px;font-size:.78rem;color:rgba(0,0,0,.3);">…</span>
                                @endif
                                @if($page === $current)
                                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .4rem;border-radius:.45rem;font-size:.82rem;font-weight:700;color:#fff;background:#C8102E;">{{ $page }}</span>
                                @else
                                    <a href="{{ $products->url($page) }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .4rem;border-radius:.45rem;font-size:.82rem;font-weight:600;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @else
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:rgba(0,0,0,.2);cursor:default;">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            @endif
                        </nav>
                        @endif

                    @else
                    <div style="text-align:center;padding:4rem 1.5rem;background:#fff;border:1px solid rgba(0,0,0,.08);border-top:none;border-radius:0 0 .75rem .75rem;">
                        <div style="width:56px;height:56px;border-radius:50%;background:rgba(0,0,0,.05);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg style="width:26px;height:26px;color:rgba(0,0,0,.22);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#111111;margin-bottom:.3rem;">Nothing found</h3>
                        @if($searchTerm)
                            <p style="font-size:.83rem;color:rgba(0,0,0,.38);margin-bottom:1rem;">No menu items match &ldquo;{{ $searchTerm }}&rdquo;. Try a shorter word.</p>
                        @else
                            <p style="font-size:.83rem;color:rgba(0,0,0,.38);margin-bottom:1rem;">Try a different category.</p>
                        @endif
                        <a href="{{ route('products.index') }}" style="display:inline-flex;align-items:center;padding:.55rem 1.25rem;background:#C8102E;color:#fff;font-weight:700;font-size:.83rem;border-radius:99px;text-decoration:none;">
                            View All Items
                        </a>
                    </div>
                    @endif

                </div>

                {{-- ── Cart sidebar (desktop only) ── --}}
                <div class="cart-sidebar" x-data>
                    {{-- Header --}}
                    <div class="cs-head">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span class="cs-title">Your Order</span>
                            <span x-show="$store.cart.itemCount > 0" x-cloak
                                  style="font-size:.72rem;color:rgba(0,0,0,.4);font-weight:600;"
                                  x-text="$store.cart.itemCount + ' item' + ($store.cart.itemCount !== 1 ? 's' : '')"></span>
                        </div>
                    </div>

                    {{-- Scrollable items --}}
                    <div class="cs-items">
                        {{-- Loading --}}
                        <div x-show="$store.cart.isLoading" x-cloak
                             style="display:flex;justify-content:center;padding:2rem;">
                            <svg style="width:20px;height:20px;animation:spin 1s linear infinite;color:#C8102E;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity:.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>

                        {{-- Empty state --}}
                        <div x-show="!$store.cart.isLoading && $store.cart.items.length === 0" x-cloak class="cs-empty">
                            <svg style="width:44px;height:44px;color:rgba(0,0,0,.14);margin-bottom:.9rem;" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p style="font-size:.85rem;font-weight:600;color:rgba(0,0,0,.35);">Your basket is empty</p>
                            <p style="font-size:.76rem;color:rgba(0,0,0,.28);margin-top:.25rem;">Add items from the menu</p>
                        </div>

                        {{-- Items --}}
                        <template x-for="item in $store.cart.items" :key="item.id">
                            <div class="cs-row">
                                <div class="cs-row-body">
                                    <div class="cs-row-name" x-text="item.product_name || item.name"></div>
                                    <template x-if="item.toppings && item.toppings.added?.length">
                                        <div style="font-size:.62rem;color:#16a34a;line-height:1.2;margin-top:.1rem;">
                                            <span>+ </span>
                                            <template x-for="(t, i) in item.toppings.added" :key="t.id">
                                                <span x-text="t.name + (i < item.toppings.added.length - 1 ? ', ' : '')"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="item.toppings && item.toppings.removed?.length">
                                        <div style="font-size:.62rem;color:#dc2626;line-height:1.2;">
                                            <span>No </span>
                                            <template x-for="(t, i) in item.toppings.removed" :key="t.id">
                                                <span x-text="t.name + (i < item.toppings.removed.length - 1 ? ', ' : '')"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <div class="cs-row-line" x-text="'£' + parseFloat(item.line_price || item.price).toFixed(2) + ' each'"></div>
                                    <div class="cs-qty-wrap">
                                        <button class="cs-qty-btn"
                                                @click="item.quantity > 1 ? $store.cart.update(item.id, item.quantity - 1) : $store.cart.remove(item.id)">
                                            <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <span class="cs-qty-val" x-text="item.quantity"></span>
                                        <button class="cs-qty-btn"
                                                @click="$store.cart.update(item.id, item.quantity + 1)">
                                            <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.35rem;flex-shrink:0;">
                                    <span style="font-size:.85rem;font-weight:700;color:#111111;"
                                          x-text="'£' + parseFloat(item.price * item.quantity).toFixed(2)"></span>
                                    <button class="cs-del-btn" @click="$store.cart.remove(item.id)">
                                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Footer --}}
                    <div class="cs-footer" x-show="$store.cart.items.length > 0" x-cloak>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.8rem;">
                            <span style="font-size:.88rem;font-weight:700;color:#111111;">Sub-Total</span>
                            <span style="font-size:.95rem;font-weight:800;color:#111111;"
                                  x-text="'£' + parseFloat($store.cart.subtotal).toFixed(2)"></span>
                        </div>
                        <a href="{{ route('cart.index') }}"
                           style="display:block;width:100%;padding:.7rem;background:#C8102E;color:#fff;font-weight:700;font-size:.88rem;text-align:center;border-radius:.45rem;text-decoration:none;transition:background .14s;"
                           onmouseover="this.style.background='#a50e26'" onmouseout="this.style.background='#C8102E'">
                            View Basket &amp; Checkout
                        </a>
                        @if($freeThreshold)
                        <p style="font-size:.7rem;color:rgba(0,0,0,.32);text-align:center;margin-top:.5rem;">
                            Free delivery on orders over @price($freeThreshold)
                        </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Mobile "View Order" floating button ── --}}
        <a href="{{ route('cart.index') }}"
           x-data
           x-show="$store.cart.itemCount > 0"
           x-cloak
           class="lg:hidden order-fab">
            <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            View Order
            <span x-text="'(' + $store.cart.itemCount + ')'" style="opacity:.75;"></span>
        </a>

    </div>

    {{-- GA4 view_item_list --}}
    @if(config('services.ga4.measurement_id') && $products->count())
    @php
        $ga4Items = $products->getCollection()->values()->map(fn($p,$i) => [
            'item_id'       => $p->sku ?? (string) $p->id,
            'item_name'     => $p->name,
            'item_category' => $p->category?->name ?? '',
            'price'         => (float) $p->price,
            'index'         => $i,
        ]);
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'view_item_list', {
                    item_list_id: 'full_menu',
                    item_list_name: 'Full Menu',
                    items: {!! json_encode($ga4Items, JSON_UNESCAPED_UNICODE) !!}
                });
            }
        });
    </script>
    @endif

</x-layouts.app>
