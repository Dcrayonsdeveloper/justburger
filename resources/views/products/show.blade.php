<x-layouts.app>
    <x-slot name="title">{{ $product->name }} — {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="{{ Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160) }}">
        <link rel="canonical" href="{{ route('products.show', $product->slug) }}">
        <meta property="og:title" content="{{ $product->name }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160) }}">
        <meta property="og:image" content="{{ $product->primary_image_url }}">
        <meta property="og:type" content="restaurant.menu_item">
        <meta property="og:url" content="{{ route('products.show', $product->slug) }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $product->name }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160) }}">
        <meta name="twitter:image" content="{{ $product->primary_image_url }}">
        <x-product-schema :productSchema="$productSchema ?? null" :faqSchema="$faqSchema ?? null" />
    @endpush

    <x-slot name="styles">
    <style>
        .dish-page { background:#fafaf8; }

        /* Breadcrumb */
        .dish-bc-bar {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:.75rem 1.25rem;
        }
        .dish-bc {
            max-width:1200px; margin:0 auto;
            display:flex; flex-wrap:wrap; align-items:center;
            gap:.3rem .45rem; font-size:.78rem; color:rgba(0,0,0,.38);
        }
        .dish-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .dish-bc a:hover { color:#C8102E; }
        .dish-bc-sep { opacity:.4; }

        /* Main product section */
        .dish-main {
            max-width:1200px; margin:0 auto;
            padding:1.75rem 1.25rem 2.5rem;
            display:grid;
            grid-template-columns:1fr;
            gap:1.75rem;
        }
        @media(min-width:768px){
            .dish-main { grid-template-columns:1fr 1fr; gap:2rem; }
        }
        @media(min-width:1024px){
            .dish-main { grid-template-columns:5fr 4fr; gap:2.5rem; }
        }

        /* Image panel */
        .dish-img-wrap {
            background:#fff;
            border-radius:1rem;
            overflow:hidden;
            aspect-ratio:4/3;
            display:flex; align-items:center; justify-content:center;
            border:1px solid rgba(0,0,0,.07);
            position:relative;
            box-shadow:0 8px 32px rgba(0,0,0,.1);
            transition:box-shadow .3s;
        }
        .dish-img-wrap:hover { box-shadow:0 12px 40px rgba(0,0,0,.14); }
        .dish-img-wrap img {
            width:100%; height:100%;
            object-fit:cover;
            transition:transform .6s cubic-bezier(.25,.1,.25,1);
        }
        .dish-img-wrap:hover img { transform:scale(1.06); }
        .dish-img-badge {
            position:absolute; top:.75rem; left:.75rem;
            display:flex; gap:.35rem;
        }
        .dish-img-badge span {
            font-size:.6rem; font-weight:800;
            text-transform:uppercase; letter-spacing:.06em;
            padding:.3rem .65rem; border-radius:99px;
            backdrop-filter:blur(6px);
        }
        .badge-popular { background:rgba(200,16,46,.9); color:#fff; }
        .badge-new { background:rgba(212,160,23,.9); color:#fff; }
        .badge-spicy { background:rgba(200,80,0,.9); color:#fff; }

        /* Info panel */
        .dish-info { display:flex; flex-direction:column; gap:1.1rem; }

        .dish-cat-eyebrow {
            font-size:.68rem; font-weight:800; letter-spacing:.16em;
            text-transform:uppercase; color:#C8102E;
        }
        .dish-name {
            font-family:'Barlow Condensed', sans-serif;
            font-weight:900; font-size:clamp(1.8rem,5vw,2.8rem);
            line-height:1.05; color:#111111;
            text-transform:uppercase; letter-spacing:.02em;
            margin:-.1rem 0;
        }
        .dish-price-tag {
            font-size:1.6rem; font-weight:900; color:#C8102E; line-height:1;
        }
        .dish-short-desc {
            font-size:.95rem; color:rgba(0,0,0,.58); line-height:1.7;
        }

        /* Stars */
        .dish-stars { display:flex; align-items:center; gap:.5rem; }

        /* Order panel */
        .order-panel {
            background:#fff;
            border:1px solid rgba(0,0,0,.09);
            border-top:3px solid #C8102E;
            border-radius:.85rem;
            padding:1.35rem 1.35rem 1.5rem;
            display:flex; flex-direction:column; gap:.7rem;
            animation:panelUp .5s ease both;
            box-shadow:0 6px 28px rgba(0,0,0,.08);
        }
        @keyframes panelUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @media(min-width:768px){
            .order-panel {
                position:sticky; top:calc(72px + 1rem);
            }
        }

        /* Quantity selector */
        .qty-selector {
            display:flex; align-items:center; gap:0;
            border:1.5px solid rgba(0,0,0,.12);
            border-radius:99px; overflow:hidden;
            width:fit-content;
            transition:border-color .2s, box-shadow .2s;
        }
        .qty-selector:hover { border-color:rgba(200,16,46,.3); box-shadow:0 0 0 3px rgba(200,16,46,.08); }
        .qty-btn {
            width:2.5rem; height:2.5rem;
            display:flex; align-items:center; justify-content:center;
            background:#fff; border:none; cursor:pointer;
            color:#111111; font-size:1.1rem; font-weight:700;
            transition:background .12s, transform .1s;
        }
        .qty-btn:hover { background:rgba(200,16,46,.06); }
        .qty-btn:active:not(:disabled) { transform:scale(.9); }
        .qty-btn:disabled { opacity:.3; cursor:default; }
        .qty-val {
            min-width:2.5rem; text-align:center;
            font-size:1rem; font-weight:800; color:#111111;
        }

        .btn-add {
            display:flex; align-items:center; justify-content:center; gap:.55rem;
            width:100%; background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1.05rem; padding:.9rem 1.5rem;
            border-radius:99px; border:none; cursor:pointer;
            transition:background .18s, transform .1s, box-shadow .18s;
            text-transform:uppercase; letter-spacing:.04em;
            box-shadow:0 3px 12px rgba(200,16,46,.25);
            position:relative; overflow:hidden;
        }
        .btn-add::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(120deg, transparent 30%, rgba(255,255,255,.18) 50%, transparent 70%);
            transform:translateX(-100%); transition:transform .5s;
        }
        .btn-add:hover { background:#a50e26; box-shadow:0 6px 20px rgba(200,16,46,.35); }
        .btn-add:hover::after { transform:translateX(100%); }
        .btn-add:active { transform:scale(.97); }
        .btn-wa {
            display:flex; align-items:center; justify-content:center; gap:.55rem;
            width:100%; background:#25D366; color:#fff;
            font-weight:700; font-size:.95rem; padding:.8rem 1.5rem;
            border-radius:99px; text-decoration:none;
            transition:background .18s, transform .1s, box-shadow .18s;
            box-shadow:0 3px 10px rgba(37,211,102,.2);
        }
        .btn-wa:hover { background:#1ebe5d; box-shadow:0 5px 18px rgba(37,211,102,.3); transform:translateY(-1px); }
        .btn-wa:active { transform:translateY(0); }
        .btn-outline {
            display:flex; align-items:center; justify-content:center; gap:.5rem;
            width:100%; background:transparent; color:rgba(0,0,0,.5);
            font-weight:600; font-size:.9rem; padding:.75rem 1.5rem;
            border-radius:99px; border:1.5px solid rgba(0,0,0,.15);
            text-decoration:none; cursor:pointer;
            transition:all .18s, transform .1s;
        }
        .btn-outline:hover { border-color:#C8102E; color:#C8102E; background:rgba(200,16,46,.03); }
        .btn-outline:active { transform:scale(.98); }

        /* Opening hours in panel */
        .panel-hours { border-top:1px solid rgba(0,0,0,.08); padding-top:.9rem; }
        .panel-hours-title {
            font-size:.68rem; font-weight:700; letter-spacing:.09em;
            text-transform:uppercase; color:rgba(0,0,0,.35); margin-bottom:.45rem;
        }
        .hours-row {
            display:flex; justify-content:space-between;
            font-size:.82rem; padding:.2rem 0;
            border-bottom:1px solid rgba(0,0,0,.04);
        }
        .hours-row:last-child { border-bottom:none; }
        .hours-day { color:rgba(0,0,0,.5); }
        .hours-time { color:#C8102E; font-weight:600; }

        /* Body sections */
        .dish-body {
            max-width:1200px; margin:0 auto;
            padding:0 1.25rem 3rem;
            display:grid;
            grid-template-columns:1fr;
            gap:2rem;
        }
        @media(min-width:1024px){
            .dish-body { grid-template-columns:7fr 5fr; gap:2.5rem; }
        }

        .dish-section-title {
            font-family:'Barlow Condensed', sans-serif;
            font-weight:900; font-size:1.45rem;
            text-transform:uppercase; letter-spacing:.04em;
            color:#111111; margin-bottom:.9rem;
            padding-bottom:.5rem;
            border-bottom:2px solid #C8102E;
            display:inline-block;
        }
        .dish-desc { font-size:.97rem; color:rgba(0,0,0,.62); line-height:1.8; }

        .dish-attr { display:flex; gap:1rem; padding:.6rem 0; border-bottom:1px solid rgba(0,0,0,.06); font-size:.88rem; }
        .dish-attr-key { width:7.5rem; flex-shrink:0; color:rgba(0,0,0,.38); font-weight:600; }
        .dish-attr-val { color:rgba(0,0,0,.7); }

        /* Reviews */
        .review-card { padding:1.1rem 0; border-bottom:1px solid rgba(0,0,0,.07); }
        .review-card:last-child { border-bottom:none; }
        .review-name { font-weight:700; font-size:.9rem; color:#111111; }
        .review-date { font-size:.75rem; color:rgba(0,0,0,.3); }
        .review-text { font-size:.93rem; color:rgba(0,0,0,.62); line-height:1.65; margin-top:.45rem; }

        .r-label { display:block; font-size:.8rem; color:rgba(0,0,0,.45); margin-bottom:.4rem; font-weight:600; }
        .r-input {
            width:100%; background:#fff; border:1.5px solid rgba(0,0,0,.12);
            border-radius:.5rem; padding:.6rem .85rem; font-size:.9rem; color:#111111;
            outline:none; transition:border-color .14s;
        }
        .r-input:focus { border-color:#C8102E; }
        .r-input::placeholder { color:rgba(0,0,0,.25); }

        /* Related */
        .rel-item {
            display:flex; align-items:center; gap:.85rem;
            padding:.8rem 0; border-bottom:1px solid rgba(0,0,0,.07);
            text-decoration:none; transition:opacity .14s;
        }
        .rel-item:last-child { border-bottom:none; }
        .rel-item:hover { opacity:.75; }
        .rel-thumb {
            width:56px; height:56px; border-radius:.5rem;
            overflow:hidden; flex-shrink:0; background:#f0ece8;
        }
        .rel-name { font-weight:700; font-size:.87rem; color:#111111; }
        .rel-price { font-size:.82rem; color:#C8102E; font-weight:700; margin-top:.1rem; }
        .rel-add-btn {
            width:34px; height:34px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            background:#C8102E; color:#fff;
            border:none; border-radius:50%; cursor:pointer;
            font-size:1.1rem; font-weight:700; line-height:1;
            transition:background .14s, transform .15s, box-shadow .14s;
            box-shadow:0 2px 8px rgba(200,16,46,.2);
        }
        .rel-add-btn:hover { background:#a50e26; transform:scale(1.1); box-shadow:0 4px 14px rgba(200,16,46,.3); }
        .rel-add-btn:active { transform:scale(.9); }

        /* ─── Sticky mobile bottom bar ─── */
        .mobile-bottom-bar {
            display:none;
            position:fixed; bottom:0; left:0; right:0;
            z-index:90;
            background:rgba(255,255,255,.92);
            backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
            border-top:1px solid rgba(0,0,0,.08);
            box-shadow:0 -6px 28px rgba(0,0,0,.1);
            padding:.75rem 1rem calc(.75rem + env(safe-area-inset-bottom, 0px));
            transform:translateY(100%);
            transition:transform .3s cubic-bezier(.4,0,.2,1);
        }
        .mobile-bottom-bar.visible { transform:translateY(0); }
        @media(max-width:767px){
            .mobile-bottom-bar { display:flex; align-items:center; gap:.75rem; }
        }
        .mbb-info { flex:1; min-width:0; }
        .mbb-name {
            font-size:.82rem; font-weight:700; color:#111111;
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .mbb-price { font-size:1rem; font-weight:900; color:#C8102E; }
        .mbb-qty {
            display:flex; align-items:center; gap:0;
            border:1.5px solid rgba(0,0,0,.12);
            border-radius:99px; overflow:hidden;
        }
        .mbb-qty-btn {
            width:2rem; height:2rem;
            display:flex; align-items:center; justify-content:center;
            background:#fff; border:none; cursor:pointer;
            color:#111111; font-size:.95rem; font-weight:700;
        }
        .mbb-qty-val {
            min-width:1.8rem; text-align:center;
            font-size:.85rem; font-weight:800; color:#111111;
        }
        .mbb-add-btn {
            background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:.9rem;
            padding:.6rem 1.25rem; border-radius:99px;
            border:none; cursor:pointer;
            text-transform:uppercase; letter-spacing:.03em;
            white-space:nowrap;
            transition:background .14s, transform .1s, box-shadow .14s;
            box-shadow:0 3px 10px rgba(200,16,46,.25);
        }
        .mbb-add-btn:hover { background:#a50e26; }
        .mbb-add-btn:active { transform:scale(.95); }

        /* Info tags */
        .dish-info-tags {
            display:flex; flex-wrap:wrap; gap:.45rem;
        }
        .dish-tag {
            display:inline-flex; align-items:center; gap:.3rem;
            padding:.35rem .7rem;
            border-radius:99px; font-size:.72rem; font-weight:600;
            border:1px solid rgba(0,0,0,.1);
            color:rgba(0,0,0,.55); background:#fff;
            transition:transform .15s, box-shadow .15s;
        }
        .dish-tag:hover { transform:translateY(-1px); box-shadow:0 2px 8px rgba(0,0,0,.06); }
        .dish-tag svg { width:.8rem; height:.8rem; }
        .dish-tag.green { color:#2E7D32; border-color:rgba(46,125,50,.2); background:rgba(46,125,50,.04); }
        .dish-tag.red { color:#C8102E; border-color:rgba(200,16,46,.2); background:rgba(200,16,46,.04); }
        .dish-tag.gold { color:#B8860B; border-color:rgba(212,160,23,.25); background:rgba(212,160,23,.06); }

        /* Compare at price */
        .dish-old-price {
            font-size:1rem; font-weight:600; color:rgba(0,0,0,.3);
            text-decoration:line-through; margin-left:.5rem;
        }
        .dish-discount-badge {
            font-size:.68rem; font-weight:800; color:#fff;
            background:#C8102E; padding:.2rem .55rem;
            border-radius:99px; margin-left:.5rem;
        }
    </style>
    </x-slot>

    @php
        $rawImg   = $product->primary_image_url;
        $imgSrc   = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
            ? $rawImg
            : asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
        $fallback = asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
        $phone    = \App\Models\Setting::get('site_phone', '');
        $waPhone  = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '447368998035'));
        $waMsg    = urlencode('Hi! I\'d like to order: ' . $product->name);
        $openHoursArr = [
            'Mon–Tue' => \App\Models\Setting::get('hours_monday', '12:00 – 10:00 PM'),
            'Wed–Thu' => \App\Models\Setting::get('hours_wednesday', '12:00 – 10:30 PM'),
            'Fri–Sat' => \App\Models\Setting::get('hours_friday', '11:45 AM – 11:00 PM'),
            'Sun'     => \App\Models\Setting::get('hours_sunday', '4:00 – 10:00 PM'),
        ];
    @endphp

    @php
        $sizeVariants = $product->variants->where('is_active', true)->values();
        $sizes = $sizeVariants->map(fn ($v) => ['id' => $v->id, 'name' => $v->name, 'price' => (float) $v->price])->values();
        $regularVariant = $sizeVariants->firstWhere('name', 'Regular') ?? $sizeVariants->first();
        $defaultVariantId = $regularVariant?->id;
        $basePrice = $regularVariant ? (float) $regularVariant->price : (float) $product->price;
    @endphp
    <div class="dish-page"
         x-data="{ sizes: {{ \Illuminate\Support\Js::from($sizes) }}, sel: { variantId: {{ $defaultVariantId ? $defaultVariantId : 'null' }}, unitPrice: {{ $basePrice }} } }">

        {{-- Breadcrumb --}}
        <div class="dish-bc-bar">
            <nav class="dish-bc">
                <a href="{{ url('/') }}">Home</a>
                <span class="dish-bc-sep">/</span>
                <a href="{{ route('products.index') }}">Menu</a>
                @if($product->category)
                    <span class="dish-bc-sep">/</span>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                @endif
                <span class="dish-bc-sep">/</span>
                <span style="color:#111111;font-weight:600;">{{ $product->name }}</span>
            </nav>
        </div>

        {{-- ── Main: image + order panel ── --}}
        <div class="dish-main">

            {{-- Left: product image --}}
            <div>
                <div class="dish-img-wrap">
                    <img src="{{ $imgSrc }}"
                         alt="{{ $product->name }}"
                         onerror="this.onerror=null;this.src='{{ $fallback }}';">
                    <div class="dish-img-badge">
                        @if($product->sales_count > 10)
                            <span class="badge-popular">Popular</span>
                        @endif
                        @if($product->created_at && $product->created_at->diffInDays(now()) < 30)
                            <span class="badge-new">New</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: info + order panel --}}
            <div class="dish-info">

                {{-- Category / name / price --}}
                @if($product->category)
                <div class="dish-cat-eyebrow">{{ $product->category->name }}</div>
                @endif

                <h1 class="dish-name">{{ $product->name }}</h1>

                @if($product->review_count > 0)
                <div class="dish-stars">
                    <div style="display:flex;gap:2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg style="width:15px;height:15px;fill:{{ $i <= round($product->rating) ? '#D4A017' : 'rgba(0,0,0,.12)' }};" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <a href="#reviews" @click.prevent="document.getElementById('reviews').scrollIntoView({behavior:'smooth',block:'start'})" style="font-size:.8rem;color:rgba(0,0,0,.4);text-decoration:none;cursor:pointer;">
                        {{ number_format($product->review_count) }} {{ Str::plural('review', $product->review_count) }}
                    </a>
                </div>
                @endif

                @if($product->short_description)
                <p class="dish-short-desc">{{ $product->short_description }}</p>
                @endif

                {{-- Info tags --}}
                <div class="dish-info-tags">
                    @if($product->stock_quantity > 0)
                        <span class="dish-tag green">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Available
                        </span>
                    @else
                        <span class="dish-tag red">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Sold Out
                        </span>
                    @endif
                    @if($product->review_count > 0 && $product->rating >= 4)
                        <span class="dish-tag gold">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Top Rated
                        </span>
                    @endif
                    @if($product->category)
                        <span class="dish-tag">{{ $product->category->name }}</span>
                    @endif
                </div>

                {{-- Order panel --}}
                <div class="order-panel" x-data="{ qty:1, adding:false, added:false }">
                    {{-- Size selector (Regular / Large) --}}
                    <template x-if="sizes.length > 1">
                        <div style="display:flex;gap:.5rem;margin-bottom:.9rem;">
                            <template x-for="s in sizes" :key="s.id">
                                <button type="button" @click="sel.variantId = s.id; sel.unitPrice = s.price"
                                        style="flex:1;padding:.6rem .5rem;border:2px solid rgba(0,0,0,.12);border-radius:.7rem;background:#fff;font-weight:800;font-size:.82rem;cursor:pointer;transition:all .15s;"
                                        :style="sel.variantId === s.id ? { borderColor:'#C8102E', background:'#fff5f5', color:'#C8102E' } : {}">
                                    <span x-text="s.name"></span> · £<span x-text="s.price.toFixed(2)"></span>
                                </button>
                            </template>
                        </div>
                    </template>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div class="dish-price-tag">
                                £<span x-text="sel.unitPrice.toFixed(2)"></span>
                                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                                    <span class="dish-old-price">@price($product->compare_at_price)</span>
                                    <span class="dish-discount-badge">{{ round((1 - $product->price / $product->compare_at_price) * 100) }}% OFF</span>
                                @endif
                            </div>
                            <div style="font-size:.72rem;color:rgba(0,0,0,.35);text-transform:uppercase;letter-spacing:.07em;margin-top:.2rem;">Per serving</div>
                        </div>
                        {{-- Quantity selector --}}
                        <div class="qty-selector">
                            <button type="button" class="qty-btn" @click="qty > 1 ? qty-- : null" :disabled="qty <= 1">-</button>
                            <span class="qty-val" x-text="qty"></span>
                            <button type="button" class="qty-btn" @click="qty < 20 ? qty++ : null" :disabled="qty >= 20">+</button>
                        </div>
                    </div>

                    {{-- Add to Basket --}}
                    @if($product->stock_quantity > 0)
                    <button @click="$store.toppingsModal.open({{ $product->id }}, qty, sel.variantId)"
                            class="btn-add">
                        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Add to Basket — £<span x-text="(sel.unitPrice * qty).toFixed(2)"></span></span>
                    </button>
                    @else
                    <div style="padding:.75rem;background:#fef2f2;border-radius:99px;text-align:center;font-size:.88rem;font-weight:600;color:#C8102E;">
                        Currently Unavailable
                    </div>
                    @endif

                    {{-- Call --}}
                    @if($phone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="btn-outline">
                        <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call to Order
                    </a>
                    @endif

                    {{-- View Full Menu --}}
                    <a href="{{ route('products.index') }}" class="btn-outline">
                        <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        View Full Menu
                    </a>

                    {{-- Opening hours --}}
                    @if(count($openHoursArr))
                    <div class="panel-hours">
                        <div class="panel-hours-title">Opening Hours</div>
                        @foreach($openHoursArr as $day => $time)
                        <div class="hours-row">
                            <span class="hours-day">{{ $day }}</span>
                            <span class="hours-time">{{ $time }}</span>
                        </div>
                        @endforeach
                    </div>
                    @elseif(\App\Models\Setting::get('opening_hours_text', ''))
                    <div class="panel-hours">
                        <div class="panel-hours-title">Opening Hours</div>
                        <p style="font-size:.85rem;color:rgba(0,0,0,.55);line-height:1.6;">
                            {{ \App\Models\Setting::get('opening_hours_text') }}
                        </p>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ── Body: description + reviews ── --}}
        <div style="border-top:1px solid rgba(0,0,0,.08); background:#fff; padding:2rem 0 0;">
            <div class="dish-body">

                {{-- Left: description + attributes + reviews --}}
                <div style="display:flex;flex-direction:column;gap:2.25rem;">

                    {{-- Description --}}
                    @if($product->description && $product->description !== $product->short_description)
                    <div>
                        <h2 class="dish-section-title">About This Dish</h2>
                        <div class="dish-desc">{!! $product->description !!}</div>
                    </div>
                    @elseif($product->short_description)
                    <div>
                        <h2 class="dish-section-title">About This Dish</h2>
                        <p class="dish-desc">{{ $product->short_description }}</p>
                    </div>
                    @endif

                    {{-- Attributes --}}
                    @if(is_array($product->attributes) && count($product->attributes))
                    <div>
                        <h2 class="dish-section-title">Details</h2>
                        <div>
                            @foreach($product->attributes as $key => $val)
                            <div class="dish-attr">
                                <span class="dish-attr-key">{{ $key }}</span>
                                <span class="dish-attr-val">{{ $val }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Reviews --}}
                    <div id="reviews">
                        <h2 class="dish-section-title">Customer Reviews</h2>

                        @if($product->review_count > 0)
                        <div style="display:flex;align-items:center;gap:1rem;padding:1rem;border-radius:.75rem;background:rgba(212,160,23,.06);border:1px solid rgba(212,160,23,.18);margin-bottom:1.5rem;">
                            <span style="font-size:2.8rem;font-weight:900;color:#D4A017;line-height:1;">{{ number_format($product->rating, 1) }}</span>
                            <div>
                                <div style="display:flex;gap:3px;margin-bottom:.3rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg style="width:17px;height:17px;fill:{{ $i <= round($product->rating) ? '#D4A017' : 'rgba(0,0,0,.12)' }};" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span style="font-size:.8rem;color:rgba(0,0,0,.45);">Based on {{ number_format($product->review_count) }} {{ Str::plural('review', $product->review_count) }}</span>
                            </div>
                        </div>
                        @endif

                        @forelse($displayReviews as $review)
                        <div class="review-card">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem;">
                                <span class="review-name">{{ $review->reviewer_name }}</span>
                                <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:2px;margin-bottom:.4rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg style="width:12px;height:12px;fill:{{ $i <= $review->rating ? '#D4A017' : 'rgba(0,0,0,.12)' }};" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                @if($review->title)
                                    <span style="font-size:.83rem;font-weight:600;color:rgba(0,0,0,.65);margin-left:.3rem;">{{ $review->title }}</span>
                                @endif
                            </div>
                            <p class="review-text">{{ $review->content }}</p>
                        </div>
                        @empty
                        <p style="font-size:.9rem;color:rgba(0,0,0,.38);margin-bottom:1.25rem;">No reviews yet — be the first!</p>
                        @endforelse

                        {{-- Write a review --}}
                        @php $reviewErrors = $errors->hasAny(['guest_name','guest_email','rating','content','honeypot']); @endphp
                        <div style="margin-top:1.25rem;" x-data="{ open: {{ $reviewErrors ? 'true' : 'false' }} }"
                             @if($reviewErrors) x-init="$nextTick(() => $el.scrollIntoView({ behavior:'smooth', block:'center' }))" @endif>
                            <button @click="open = !open" class="btn-outline" style="width:auto;padding:.55rem 1.25rem;font-size:.85rem;">
                                ✍ Write a Review
                            </button>
                            <form x-show="open" x-cloak
                                  x-transition:enter="transition ease-out duration-200"
                                  x-transition:enter-start="opacity-0 -translate-y-1"
                                  x-transition:enter-end="opacity-100 translate-y-0"
                                  method="POST"
                                  action="{{ route('product.guest-review', $product) }}"
                                  style="margin-top:1.1rem;padding:1.25rem;border-radius:.85rem;background:#f5f3f0;border:1px solid rgba(0,0,0,.09);">
                                @csrf
                                <input type="text" name="honeypot" class="hidden" value="" tabindex="-1" autocomplete="off">
                                @if($reviewErrors)
                                    <div style="margin-bottom:1rem;padding:.7rem .9rem;border-radius:.6rem;background:#fdecea;border:1px solid #f5c2c0;">
                                        @foreach($errors->all() as $reviewError)
                                            <p style="font-size:.8rem;color:#b3261e;line-height:1.5;">{{ $reviewError }}</p>
                                        @endforeach
                                    </div>
                                @endif
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                                    <div>
                                        <label class="r-label">Your Name</label>
                                        <input type="text" name="guest_name" value="{{ old('guest_name') }}" required class="r-input" placeholder="e.g. James T.">
                                    </div>
                                    <div>
                                        <label class="r-label">Email Address</label>
                                        <input type="email" name="guest_email" value="{{ old('guest_email') }}" required class="r-input" placeholder="your@email.com">
                                    </div>
                                </div>
                                <div style="margin-bottom:1rem;">
                                    <label class="r-label">Rating</label>
                                    <div x-data="{ rating:{{ (int) old('rating', 0) }}, hover:0 }" style="display:flex;gap:.4rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                        <button type="button" @click="rating = {{ $i }}" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0">
                                            <svg fill="#C9C2B4" style="width:30px;height:30px;cursor:pointer;transition:fill .1s;"
                                                 :style="(hover||rating) >= {{ $i }} ? 'fill:#D4A017' : 'fill:#C9C2B4'"
                                                 viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                        @endfor
                                        <input type="hidden" name="rating" :value="rating">
                                    </div>
                                </div>
                                <div style="margin-bottom:1rem;">
                                    <label class="r-label">Your Review</label>
                                    <textarea name="content" required rows="4" minlength="20"
                                              class="r-input" style="resize:none;"
                                              placeholder="Tell us what you thought of this dish...">{{ old('content') }}</textarea>
                                </div>
                                <button type="submit" class="btn-add" style="width:auto;padding:.65rem 1.5rem;">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right: more from category --}}
                @if($relatedProducts->count())
                <div>
                    <h2 class="dish-section-title">More from {{ $product->category?->name ?? 'the Menu' }}</h2>
                    <div>
                        @foreach($relatedProducts->take(8) as $rel)
                        @php
                            $relRawImg = $rel->primary_image_url;
                            $relImg = ($relRawImg && !str_ends_with(strtolower($relRawImg), '.svg'))
                                ? $relRawImg
                                : asset('images/products/product-' . (($rel->id % 27) + 1) . '.jpg');
                            $relFallback = asset('images/products/product-' . (($rel->id % 27) + 1) . '.jpg');
                        @endphp
                        <div class="rel-item">
                            <a href="{{ route('products.show', $rel) }}" style="display:contents;text-decoration:none;color:inherit;">
                                <div class="rel-thumb">
                                    <img src="{{ $relImg }}"
                                         onerror="this.onerror=null;this.src='{{ $relFallback }}';"
                                         alt="{{ $rel->name }}" loading="lazy"
                                         style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div class="rel-name">{{ $rel->name }}</div>
                                    <div class="rel-price">@price($rel->price)</div>
                                </div>
                            </a>
                            @if($rel->stock_quantity > 0)
                            <button class="rel-add-btn"
                                    onclick="Alpine.store('toppingsModal').open({{ $rel->id }}, 1)">
                                +
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- ── Sticky mobile bottom bar ── --}}
        @if($product->stock_quantity > 0)
        <div class="mobile-bottom-bar"
             x-data="{ qty:1, show:false, adding:false }"
             x-init="
                const panel = document.querySelector('.order-panel');
                if (panel) {
                    new IntersectionObserver(([e]) => { show = !e.isIntersecting; }, { threshold:0 }).observe(panel);
                }
             "
             :class="show ? 'visible' : ''">
            <div class="mbb-info">
                <div class="mbb-name">{{ $product->name }}</div>
                <div class="mbb-price">£<span x-text="sel.unitPrice.toFixed(2)"></span></div>
            </div>
            <div class="mbb-qty">
                <button type="button" class="mbb-qty-btn" @click="qty > 1 ? qty-- : null">-</button>
                <span class="mbb-qty-val" x-text="qty"></span>
                <button type="button" class="mbb-qty-btn" @click="qty < 20 ? qty++ : null">+</button>
            </div>
            <button class="mbb-add-btn"
                    @click="$store.toppingsModal.open({{ $product->id }}, qty, sel.variantId)">
                <span x-text="'Add £' + (sel.unitPrice * qty).toFixed(2)"></span>
            </button>
        </div>
        @endif

    </div>{{-- /.dish-page --}}

    {{-- Analytics --}}
    @if(config('services.ga4.measurement_id') || config('services.facebook.pixel_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(config('services.ga4.measurement_id'))
            if (typeof gtag !== 'undefined') {
                gtag('event', 'view_item', {
                    currency: 'GBP',
                    value: {{ (float) $product->price }},
                    items: [{ item_id: '{{ $product->sku ?? $product->id }}', item_name: @json($product->name), item_category: @json($product->category?->name ?? ''), price: {{ (float) $product->price }}, quantity: 1 }]
                });
            }
            @endif
            @if(config('services.facebook.pixel_id'))
            if (typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', { content_name: @json($product->name), content_category: @json($product->category?->name ?? ''), content_ids: ['{{ $product->id }}'], content_type: 'product', value: {{ (float) $product->price }}, currency: 'GBP' }@if(!empty($fbEventId)), { eventID: '{{ $fbEventId }}' }@endif);
            }
            @endif
        });
    </script>
    @endif

</x-layouts.app>
