<x-layouts.app>
    @php
        $brandColor          = \App\Models\Setting::get('brand_primary_color', '#C8102E');
        $menuDescLimit       = (int) \App\Models\Setting::get('menu_description_limit', 100);
        $menuSeeAllThreshold = (int) \App\Models\Setting::get('menu_see_all_threshold', 8);
    @endphp

    <x-slot name="title">{{ \App\Models\Setting::get('menu_page_title', 'Menu') }} - {{ config('app.name') }}</x-slot>

    @push('meta')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&display=swap" rel="stylesheet">
    @endpush

    <x-slot name="styles">
    <style>
        .jbp-h { font-family:'Barlow Condensed','Barlow',sans-serif; font-weight:900; line-height:.9; letter-spacing:-.01em; text-transform:uppercase; }

        /* ── Page ── */
        .menu-page { background:#111; min-height:100vh; padding-bottom:80px; }

        /* ── Hero header ── */
        .menu-hero { position:relative; padding:5rem 1.5rem 4rem; text-align:center; overflow:hidden; }
        .menu-hero-bg { position:absolute; inset:0; background-size:cover; background-position:center; z-index:0; }
        .menu-hero-overlay { position:absolute; inset:0; background:linear-gradient(to bottom, rgba(4,2,1,.52) 0%, rgba(8,4,1,.75) 100%); z-index:1; }
        .menu-hero-content { position:relative; z-index:2; }
        .menu-hero-eyebrow { font-size:.68rem; font-weight:800; letter-spacing:.26em; text-transform:uppercase; color:#C8102E; margin-bottom:.75rem; }
        .menu-hero-title { font-size:clamp(3rem,7vw,6rem); color:#fff; margin-bottom:.75rem; }
        .menu-hero-sub { color:rgba(255,255,255,.42); font-size:1rem; font-weight:500; }

        /* ── Sticky nav ── */
        .menu-nav { background:#0d0a09; border-bottom:1px solid rgba(255,255,255,.07); position:sticky; top:0; z-index:30; }
        .menu-nav-inner { display:flex; align-items:center; gap:.5rem; max-width:80rem; margin:0 auto; padding:0 1rem; }
        .menu-nav-arrow { flex-shrink:0; width:2.25rem; height:2.25rem; display:flex; align-items:center; justify-content:center; border-radius:50%; border:1px solid rgba(255,255,255,.12); color:rgba(255,255,255,.5); cursor:pointer; transition:all .2s; background:transparent; }
        .menu-nav-arrow:hover { border-color:rgba(255,255,255,.4); color:#fff; }
        .menu-tabs-wrap { flex:1; display:flex; align-items:center; gap:.5rem; overflow-x:auto; padding:.75rem .25rem; scrollbar-width:none; -ms-overflow-style:none; scroll-behavior:smooth; }
        .menu-tabs-wrap::-webkit-scrollbar { display:none; }
        .cat-tab { flex-shrink:0; display:inline-flex; align-items:center; padding:.4rem 1.1rem; font-size:.76rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; border-radius:2rem; text-decoration:none; border:1.5px solid rgba(255,255,255,.1); color:rgba(255,255,255,.45); transition:all .2s; white-space:nowrap; }
        .cat-tab:hover { border-color:rgba(255,255,255,.3); color:rgba(255,255,255,.85); }
        .cat-tab.active { background:#C8102E; border-color:#C8102E; color:#fff; }

        /* ── Section ── */
        .cat-section { padding:3.5rem 0 2rem; }
        .cat-section-head { max-width:80rem; margin:0 auto; padding:0 1.5rem 1.75rem; }
        .cat-section-title { font-size:clamp(2rem,4vw,3.25rem); color:#fff; margin-bottom:.3rem; }
        .cat-section-desc { color:rgba(255,255,255,.35); font-size:1rem; line-height:1.6; margin-top:.5rem; max-width:520px; }
        .cat-section-rule { width:3rem; height:3px; background:#C8102E; margin-top:.85rem; border-radius:2px; }

        /* ── Product grid — restaurant menu style ── */
        .cat-product-wrap { max-width:72rem; margin:0 auto; padding:0 2rem; }
        .cat-product-grid { display:flex; flex-direction:column; }
        .menu-item { display:flex; align-items:center; gap:1.75rem; padding:1.5rem 0; background:transparent; text-decoration:none; border-bottom:1px solid rgba(212,160,23,.18); transition:opacity .2s; }
        .menu-item:last-child { border-bottom:none; }
        .menu-item:hover { opacity:.8; }
        .menu-item--even { flex-direction:row-reverse; }
        .menu-item-img { flex-shrink:0; width:88px; height:88px; border-radius:50%; overflow:hidden; border:2px solid rgba(212,160,23,.3); background:#2a1a10; display:flex; align-items:center; justify-content:center; }
        .menu-item-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s ease; }
        .menu-item:hover .menu-item-img img { transform:scale(1.1); }
        .menu-item-placeholder { font-size:1.75rem; opacity:.4; }
        .menu-item-body { flex:1; display:flex; flex-direction:column; gap:.35rem; min-width:0; }
        .menu-item-row { display:flex; align-items:baseline; gap:.6rem; }
        .menu-item-name { font-weight:700; font-size:.95rem; color:#D4A017; line-height:1.25; flex-shrink:0; max-width:55%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .menu-item-dots { flex:1; border-bottom:1px dotted rgba(212,160,23,.28); min-width:.5rem; margin-bottom:.2rem; }
        .menu-item-price { flex-shrink:0; font-weight:800; font-size:.95rem; color:#D4A017; white-space:nowrap; }
        .menu-item-desc { font-size:1rem; color:rgba(255,255,255,.3); line-height:1.5; }
        .menu-item--even .menu-item-body { text-align:right; align-items:flex-end; }
        .menu-item--even .menu-item-row { flex-direction:row-reverse; }

        /* ── See all ── */
        .cat-see-all { margin-top:1.5rem; }
        .cat-see-all a { display:inline-flex; align-items:center; gap:.5rem; font-size:.76rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; border:1.5px solid rgba(255,255,255,.14); color:rgba(255,255,255,.45); padding:.75rem 1.75rem; text-decoration:none; transition:all .2s; }
        .cat-see-all a:hover { border-color:#C8102E; color:#C8102E; }

        /* ── Empty state ── */
        .cat-empty a { display:flex; align-items:center; justify-content:space-between; padding:1.25rem 1.5rem; background:#111111; border:1px solid rgba(255,255,255,.06); text-decoration:none; transition:background .2s; }
        .cat-empty a:hover { background:#221810; }

        /* ── Bottom CTA bar ── */
        .menu-cta-bar { background:#0d0a09; border-top:1px solid rgba(255,255,255,.07); padding:.85rem 1.5rem; }
        .menu-cta-btn { display:flex; align-items:center; justify-content:center; gap:.6rem; background:#C8102E; color:#fff; font-size:.76rem; font-weight:800; letter-spacing:.15em; text-transform:uppercase; padding:.875rem 2rem; width:100%; max-width:360px; margin:0 auto; text-decoration:none; border-radius:2px; transition:background .2s; }
        .menu-cta-btn:hover { background:#a50e25; }

        /* ── Responsive ── */
        @media (min-width: 640px) {
            .menu-item-img { width:104px; height:104px; }
            .menu-item-name { max-width:60%; }
        }
        @media (min-width: 1024px) {
            .menu-item-img { width:116px; height:116px; }
            .cat-product-wrap { padding:0 2.5rem; }
            .menu-item { gap:2.25rem; padding:1.75rem 0; }
            .menu-item-name { font-size:1.05rem; max-width:none; }
        }
    </style>
    </x-slot>

    <div class="menu-page">

        {{-- ── Hero Header ── --}}
        <div class="menu-hero">
            <div class="menu-hero-bg" style="background-image:url('{{ asset('images/banners/our-story.jpg') }}');"></div>
            <div class="menu-hero-overlay"></div>
            <div class="menu-hero-content">
                <p class="menu-hero-eyebrow">{{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP') }} &middot; Since 1989</p>
                <h1 class="jbp-h menu-hero-title">{{ \App\Models\Setting::get('menu_page_heading', 'Our Menu') }}</h1>
                <p class="menu-hero-sub">Charbroiled to order &mdash; freshly made every time</p>
            </div>
        </div>

        {{-- ── Sticky Category Nav ── --}}
        <div x-data="menuNav()" class="menu-nav">
            <div class="menu-nav-inner">
                <button @click="scrollTabs(-220)" class="menu-nav-arrow" aria-label="Scroll left">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <nav x-ref="tabsContainer" class="menu-tabs-wrap">
                    @foreach($categories as $category)
                        <a href="#cat-{{ $category->slug }}"
                           class="cat-tab"
                           :class="activeSection === 'cat-{{ $category->slug }}' ? 'active' : ''"
                           @click.prevent="scrollToSection('cat-{{ $category->slug }}')"
                           data-nav-for="cat-{{ $category->slug }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
                <button @click="scrollTabs(220)" class="menu-nav-arrow" aria-label="Scroll right">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        {{-- ── Category Sections ── --}}
        @foreach($categories as $category)
            <section id="cat-{{ $category->slug }}" class="cat-section menu-section">

                <div class="cat-section-head">
                    <h2 class="jbp-h cat-section-title">{{ $category->name }}</h2>
                    @if($category->description)
                        <p class="cat-section-desc">{{ Str::limit($category->description, $menuDescLimit) }}</p>
                    @endif
                    <div class="cat-section-rule"></div>
                </div>

                @if($category->featured_products->isNotEmpty())
                    @php $catImg = asset('images/categories/' . $category->slug . '.jpg'); @endphp
                    <div class="cat-product-wrap">
                        <div class="cat-product-grid">
                            @foreach($category->featured_products as $product)
                                <a href="{{ route('product.show', $product) }}"
                                   class="menu-item {{ $loop->even ? 'menu-item--even' : '' }}">
                                    <div class="menu-item-img">
                                        <img src="{{ $catImg }}"
                                             onerror="this.onerror=null;this.src='{{ $product->primary_image_url ?: asset('images/banners/our-story.jpg') }}';"
                                             alt="{{ $product->name }}" loading="lazy">
                                    </div>
                                    <div class="menu-item-body">
                                        <div class="menu-item-row">
                                            <span class="menu-item-name">{{ $product->name }}</span>
                                            <span class="menu-item-dots"></span>
                                            <span class="menu-item-price">@price($product->price)</span>
                                        </div>
                                        @if($product->short_description)
                                            <p class="menu-item-desc">{{ Str::limit($product->short_description, $menuDescLimit) }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        @if($category->total_products_count > $menuSeeAllThreshold)
                            <div class="cat-see-all">
                                <a href="{{ route('category.show', $category) }}">
                                    {{ \App\Models\Setting::get('menu_see_all_text', 'See All') }} {{ $category->name }}
                                    <span style="color:rgba(255,255,255,.25);">({{ $category->total_products_count }})</span>
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>

                @else
                    <div class="cat-empty cat-product-wrap">
                        <a href="{{ route('category.show', $category) }}">
                            <span style="color:rgba(255,255,255,.35);font-size:.85rem;">{{ $category->total_products_count }} {{ Str::plural('item', $category->total_products_count) }} available</span>
                            <span style="display:inline-flex;align-items:center;gap:.45rem;font-size:.76rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:#C8102E;">
                                {{ \App\Models\Setting::get('menu_browse_text', 'Browse') }} {{ $category->name }}
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </a>
                    </div>
                @endif

            </section>
        @endforeach

    </div>

    {{-- ── Bottom CTA Bar (fixed) ── --}}
    <div id="menu-cta-bar" class="menu-cta-bar" style="position:fixed;bottom:0;left:0;right:0;z-index:9999;transition:transform .3s ease;">
        <a href="#cat-{{ $categories->first()?->slug }}"
           onclick="event.preventDefault();var _e=document.getElementById('cat-{{ $categories->first()?->slug }}');if(_e)window.scrollTo({top:_e.getBoundingClientRect().top+window.pageYOffset-70,behavior:'smooth'});"
           class="menu-cta-btn">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            {{ \App\Models\Setting::get('menu_cta_text', 'Start Your Order') }}
        </a>
    </div>

    <script>
        (function(){
            var bar = document.getElementById('menu-cta-bar');
            if (!bar) return;
            document.body.appendChild(bar);
            bar.style.transform = 'translateY(0)';
            var footer = document.querySelector('footer');
            var wa = document.getElementById('whatsapp-float');
            if (!footer) return;
            window.addEventListener('scroll', function(){
                var hidden = footer.getBoundingClientRect().top < window.innerHeight;
                bar.style.transform = hidden ? 'translateY(110%)' : 'translateY(0)';
                if (wa) wa.style.bottom = hidden ? '24px' : '76px';
            }, { passive: true });
        })();

        function menuNav(){
            var OFFSET = 70;
            return {
                activeSection: '',
                observer: null,
                scrollTabs(amount){ this.$refs.tabsContainer.scrollBy({ left: amount, behavior: 'smooth' }); },
                init(){
                    var self = this;
                    var sections = document.querySelectorAll('.menu-section');
                    var header   = document.getElementById('main-header');
                    var navEl    = this.$el;
                    sections.forEach(function(s){ s.style.scrollMarginTop = OFFSET + 'px'; });
                    if (header) header.style.transition = 'transform .3s ease';
                    window.addEventListener('scroll', function(){
                        if (!header) return;
                        header.style.transform = window.scrollY >= (navEl.offsetTop || 0)
                            ? 'translateY(-100%)' : 'translateY(0)';
                    }, { passive: true });
                    this.observer = new IntersectionObserver(function(entries){
                        entries.forEach(function(e){
                            if (!e.isIntersecting) return;
                            self.activeSection = e.target.id;
                            var pill = document.querySelector('[data-nav-for="' + e.target.id + '"]');
                            if (!pill) return;
                            var wrap  = self.$refs.tabsContainer;
                            var wRect = wrap.getBoundingClientRect();
                            var pRect = pill.getBoundingClientRect();
                            if (pRect.left < wRect.left || pRect.right > wRect.right) {
                                var target = wrap.scrollLeft + pRect.left - wRect.left
                                           - (wRect.width / 2) + (pRect.width / 2);
                                wrap.scrollTo({ left: target, behavior: 'smooth' });
                            }
                        });
                    }, { rootMargin: '-' + OFFSET + 'px 0px -50% 0px', threshold: 0 });
                    sections.forEach(function(s){ self.observer.observe(s); });
                },
                scrollToSection(id){
                    var el = document.getElementById(id);
                    if (!el) return;
                    var top = el.getBoundingClientRect().top + window.pageYOffset - OFFSET;
                    window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
                },
                destroy(){ if (this.observer) this.observer.disconnect(); }
            };
        }
    </script>

</x-layouts.app>
