<x-layouts.app>
    <x-slot name="title">What's New — {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        @php $siteName = \App\Models\Setting::get('site_name', config('app.name')); @endphp
        <meta name="description" content="Discover the latest additions to the {{ $siteName }} menu. Fresh burgers, sides and more — order online.">
        <link rel="canonical" href="{{ url('/new-arrivals') }}">
        <meta property="og:title" content="What's New — {{ $siteName }}">
        <meta property="og:description" content="Discover the latest additions to the {{ $siteName }} menu.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/new-arrivals') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="What's New — {{ $siteName }}">
    @endpush

    <x-slot name="styles">
    <style>
        .na-page { background:#fafaf8; color:#1a1210; min-height:70vh; }

        /* ─── Header ─── */
        .na-header {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:1.1rem 1.25rem;
        }
        .na-bc {
            display:flex; flex-wrap:wrap; align-items:center; gap:.3rem .45rem;
            font-size:.78rem; color:rgba(0,0,0,.38); margin-bottom:.5rem;
            max-width:1100px; margin-left:auto; margin-right:auto;
        }
        .na-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .na-bc a:hover { color:#C8102E; }
        .na-bc-sep { opacity:.4; }
        .na-title-bar {
            max-width:1100px; margin:0 auto;
            display:flex; align-items:center; justify-content:space-between; gap:1rem;
        }
        .na-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:clamp(1.5rem,4vw,2rem);
            text-transform:uppercase; letter-spacing:.03em; color:#1a1210;
            line-height:1.1; display:flex; align-items:center; gap:.5rem;
        }
        .na-badge {
            font-size:.65rem; font-weight:700;
            background:#C8102E; color:#fff;
            padding:.15rem .55rem; border-radius:99px;
            letter-spacing:.02em;
        }
        .na-subtitle {
            font-size:.82rem; color:rgba(0,0,0,.45); margin-top:.25rem;
        }

        /* ─── Product list (Nando's row style) ─── */
        .na-list {
            max-width:1100px; margin:0 auto;
            padding:0 1rem 3rem;
        }
        .na-item {
            display:flex; align-items:center; gap:1rem;
            padding:.9rem 1.25rem;
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.06);
            transition:background .12s;
        }
        .na-item:first-child { border-radius:.75rem .75rem 0 0; margin-top:1.25rem; border-top:1px solid rgba(0,0,0,.06); }
        .na-item:last-child { border-radius:0 0 .75rem .75rem; border-bottom:none; }
        .na-item:hover { background:#fef5f5; }

        .na-item-link {
            flex:1; min-width:0;
            text-decoration:none; color:inherit; display:block;
        }
        .na-item-cat {
            font-size:.62rem; font-weight:700;
            letter-spacing:.1em; text-transform:uppercase;
            color:#C8102E; margin-bottom:.18rem;
        }
        .na-item-name {
            font-size:.93rem; font-weight:700;
            color:#1a1210; line-height:1.3; margin-bottom:.2rem;
        }
        .na-item-desc {
            font-size:.77rem; color:rgba(0,0,0,.48);
            line-height:1.45; margin-bottom:.35rem;
            display:-webkit-box; -webkit-line-clamp:2;
            -webkit-box-orient:vertical; overflow:hidden;
        }
        .na-item-meta {
            display:flex; align-items:center; gap:.6rem;
        }
        .na-item-price {
            font-size:.9rem; font-weight:700; color:#1a1210;
        }
        .na-item-old-price {
            font-size:.75rem; color:rgba(0,0,0,.35);
            text-decoration:line-through;
        }
        .na-item-new-tag {
            font-size:.55rem; font-weight:800;
            background:#C8102E; color:#fff;
            padding:.12rem .4rem; border-radius:.2rem;
            text-transform:uppercase; letter-spacing:.06em;
        }

        .na-item-right {
            display:flex; flex-direction:column;
            align-items:center; gap:.45rem; flex-shrink:0;
        }
        .na-item-img {
            width:86px; height:86px; border-radius:.55rem;
            object-fit:cover; display:block; background:#f5f2ef;
        }
        @media(max-width:480px){
            .na-item-img { width:72px; height:72px; }
            .na-item { padding:.8rem 1rem; }
        }
        .na-add-btn {
            width:86px; padding:.32rem .5rem;
            font-size:.7rem; font-weight:700;
            border:none; border-radius:99px;
            cursor:pointer; transition:all .14s;
            text-align:center; background:#C8102E; color:#fff;
        }
        .na-add-btn:hover { background:#a00d24; }
        @media(max-width:480px){ .na-add-btn { width:72px; font-size:.65rem; } }

        /* ─── Empty state ─── */
        .na-empty {
            text-align:center; padding:4rem 1rem;
            max-width:1100px; margin:0 auto;
        }
        .na-empty-icon {
            width:4rem; height:4rem; margin:0 auto 1rem;
            color:rgba(0,0,0,.15);
        }
        .na-empty-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1.2rem;
            text-transform:uppercase; color:#1a1210;
            margin-bottom:.35rem;
        }
        .na-empty-text { font-size:.85rem; color:rgba(0,0,0,.4); margin-bottom:1.25rem; }
        .na-browse-btn {
            display:inline-block; padding:.6rem 1.5rem;
            background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:700; font-size:.85rem;
            text-transform:uppercase; letter-spacing:.04em;
            text-decoration:none; border-radius:.4rem;
            transition:background .15s;
        }
        .na-browse-btn:hover { background:#a00d24; }

        /* ─── Loading spinner ─── */
        .na-spinner {
            display:flex; justify-content:center; padding:2rem 0;
        }
        .na-spinner svg {
            width:1.5rem; height:1.5rem; color:#C8102E;
        }
    </style>
    </x-slot>

    <div class="na-page">
        {{-- ─── Header ─── --}}
        <div class="na-header">
            <nav class="na-bc">
                <a href="{{ url('/') }}">Home</a>
                <span class="na-bc-sep">/</span>
                <a href="{{ route('products.index') }}">Menu</a>
                <span class="na-bc-sep">/</span>
                <span style="color:rgba(0,0,0,.6);">What's New</span>
            </nav>
            <div class="na-title-bar">
                <div>
                    <h1 class="na-title">
                        What's New
                        <span class="na-badge">{{ $products->total() }}</span>
                    </h1>
                    <p class="na-subtitle">Latest additions to our menu</p>
                </div>
            </div>
        </div>

        {{-- ─── Product List ─── --}}
        @if($products->count())
            <div class="na-list"
                 x-data="{
                    page: {{ $products->currentPage() }},
                    loading: false,
                    hasMore: {{ $products->hasMorePages() ? 'true' : 'false' }},
                    loadMore() {
                        if (this.loading || !this.hasMore) return;
                        this.loading = true;
                        this.page++;
                        const url = new URL(window.location.href);
                        url.searchParams.set('page', this.page);
                        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(r => r.json())
                            .then(data => {
                                this.$refs.grid.insertAdjacentHTML('beforeend', data.html);
                                this.hasMore = data.hasMore;
                                this.loading = false;
                            })
                            .catch(() => { this.loading = false; });
                    }
                 }"
                 x-init="new IntersectionObserver((e) => { if (e[0].isIntersecting) loadMore(); }, { rootMargin: '200px' }).observe($refs.sentinel)">

                <div x-ref="grid">
                    @foreach($products as $product)
                        @include('products._new-arrival-row', ['product' => $product])
                    @endforeach
                </div>

                <div x-ref="sentinel" style="height:1rem;"></div>
                <div x-show="loading" x-cloak class="na-spinner">
                    <svg class="animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </div>
            </div>
        @else
            <div class="na-empty">
                <svg class="na-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <h3 class="na-empty-title">No New Items Yet</h3>
                <p class="na-empty-text">Check back soon for new additions to the menu.</p>
                <a href="{{ route('products.index') }}" class="na-browse-btn">Browse Full Menu</a>
            </div>
        @endif
    </div>
</x-layouts.app>
