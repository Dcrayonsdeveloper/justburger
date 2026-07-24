<x-layouts.app>
    <x-slot name="title">{{ $siteSettings['site_name'] }} - {{ $siteSettings['site_tagline'] }}</x-slot>

    @push('meta')
        <meta name="description" content="{{ $siteSettings['site_tagline'] }} — Charbroiled burgers, chicken burgers, kebab wraps, milkshakes and more. {{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP') }}">
        <link rel="canonical" href="{{ url('/') }}">
        <meta property="og:title" content="{{ $siteSettings['site_name'] }} - {{ $siteSettings['site_tagline'] }}">
        <meta property="og:description" content="Charbroiled burgers, chicken burgers, kebab wraps, milkshakes. Serving Bedfont since 1989.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        @if($siteSettings['site_logo'])
        <meta property="og:image" content="{{ asset('images/' . $siteSettings['site_logo']) }}">
        @endif
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&display=swap" rel="stylesheet">
        <?php $homeSchema = ['@context'=>'https://schema.org','@graph'=>[['@type'=>'Restaurant','@id'=>url('/').'#business','name'=>\App\Models\Setting::get('site_name','Just Burgers Plus'),'url'=>url('/'),'telephone'=>'+44'.\App\Models\Setting::get('site_phone','020 8890 5008'),'foundingDate'=>'1989','address'=>['@type'=>'PostalAddress','streetAddress'=>'525 Staines Road','addressLocality'=>'Bedfont','addressRegion'=>'Middlesex','postalCode'=>'TW14 8BP','addressCountry'=>'GB'],'servesCuisine'=>['Burgers','American','Fast Food'],'priceRange'=>'£'],['@type'=>'WebSite','@id'=>url('/').'#website','name'=>\App\Models\Setting::get('site_name','Just Burgers Plus'),'url'=>url('/')]]]; ?>
        <script type="application/ld+json">{!! json_encode($homeSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
    @endpush

    <x-slot name="styles">
    <style>
        /* ── Display font ── */
        .jbp-h {
            font-family: 'Barlow Condensed', 'Barlow', sans-serif;
            font-weight: 900;
            line-height: .9;
            letter-spacing: -.01em;
            text-transform: uppercase;
        }

        /* ════════════════════════════════
           HERO
        ════════════════════════════════ */
        .hero-wrap    { position: relative; height: 92vh; min-height: 580px; max-height: 900px; overflow: hidden; background: #1a0e08; }
        .hero-slide   { position: absolute; inset: 0; transition: opacity .75s ease; }
        .hero-bg      { position: absolute; inset: 0; background-size: cover; background-position: center center; }
        .hero-grad    { position: absolute; inset: 0; background: linear-gradient(to top, rgba(10,6,4,1) 0%, rgba(10,6,4,.7) 25%, rgba(10,6,4,.2) 65%, transparent 100%); }
        .hero-body    { position: relative; height: 100%; display: flex; align-items: flex-end; }
        .hero-inner   { width: 100%; max-width: 80rem; margin: 0 auto; padding: 0 1.5rem 7rem 2.5rem; }
        .hero-tag     { display: inline-block; font-size: .7rem; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; padding: .3rem .85rem; margin-bottom: 1.1rem; border-radius: 2px; }
        .hero-title   { font-size: clamp(3.5rem, 8.5vw, 7.5rem); margin-bottom: .9rem; color: #fff; }
        .hero-sub     { color: rgba(255,255,255,.6); font-size: clamp(.95rem, 1.8vw, 1.15rem); font-weight: 500; margin-bottom: 2.25rem; max-width: 400px; line-height: 1.5; }
        .hero-cta     { display: inline-flex; align-items: center; gap: .6rem; background: #C8102E; color: #fff; font-size: .8rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; padding: 1rem 2.25rem; text-decoration: none; transition: background .2s; border-radius: 2px; }
        .hero-cta:hover { background: #a50e25; }
        .hero-bars    { position: absolute; bottom: 2.75rem; left: 2.5rem; display: flex; gap: .6rem; z-index: 20; }
        .hero-bar     { height: 3px; border-radius: 2px; cursor: pointer; transition: all .45s ease; background: rgba(255,255,255,.25); width: 1.4rem; border: none; padding: 0; }
        .hero-bar.on  { background: #fff; width: 2.75rem; }
        .slide-arrow  { position: absolute; top: 50%; transform: translateY(-50%); z-index: 20; width: 2.75rem; height: 2.75rem; border-radius: 50%; border: none; background: transparent; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.4); cursor: pointer; transition: all .2s; }
        .slide-arrow:hover { background: rgba(255,255,255,.12); color: #fff; }

        /* ── Slant divider ── */
        .slant { display: block; width: 100%; overflow: hidden; line-height: 0; }
        .hero-slant { position: absolute; bottom: 0; left: 0; right: 0; z-index: 10; line-height: 0; }

        /* ════════════════════════════════
           ORDER PANEL  (dark navy)
        ════════════════════════════════ */
        .op-panel   { background: #0f1d2e; position: relative; }
        .op-grid    { display: grid; grid-template-columns: 1fr; gap: 2rem; max-width: 72rem; margin: 0 auto; padding: 4rem 1.5rem 5rem; }
        .op-col     { display: flex; flex-direction: column; align-items: center; text-align: center; }
        .op-icon    { width: 3.5rem; height: 3.5rem; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.18); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; flex-shrink: 0; transition: border-color .2s, background .2s; }
        .op-col:hover .op-icon { background: rgba(200,16,46,.2); border-color: #C8102E; }
        .op-title   { color: #fff; font-weight: 700; font-size: 1rem; letter-spacing: .06em; text-transform: uppercase; margin-bottom: .55rem; }
        .op-desc    { color: rgba(255,255,255,.42); font-size: .85rem; line-height: 1.65; margin-bottom: 1.5rem; max-width: 210px; }
        .op-btn     { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; padding: .75rem 1.6rem; font-size: .76rem; font-weight: 800; letter-spacing: .11em; text-transform: uppercase; border: 1.5px solid rgba(255,255,255,.35); color: #fff; text-decoration: none; width: 100%; max-width: 220px; transition: all .2s; border-radius: 2px; }
        .op-btn:hover { background: #fff; color: #0f1d2e; border-color: #fff; }
        .op-divider { display: none; width: 1px; background: rgba(255,255,255,.06); }

        /* ════════════════════════════════
           LUNCHTIME DEAL  (rewards-style)
        ════════════════════════════════ */
        .ld-wrap  { background: #0d0a09; overflow: hidden; }
        .ld-inner { max-width: 72rem; margin: 0 auto; padding: 5rem 1.5rem; display: flex; flex-direction: column; align-items: stretch; gap: 3rem; }
        .ld-text  { flex: 1; display: flex; flex-direction: column; align-items: center; text-align: center; order: 1; }
        .ld-illus { flex: 1; min-height: 320px; order: 2; border-radius: 1.25rem; overflow: hidden; display: flex; }
        .ld-illus img { flex: 1; width: 100%; object-fit: cover; display: block; min-height: 320px; }
        .ld-tag   { display: inline-block; font-size: .68rem; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; background: #C8102E; color: #fff; padding: .3rem .85rem; margin-bottom: 1.1rem; border-radius: 2px; }
        .ld-title { font-size: clamp(3rem, 7vw, 6rem); margin-bottom: .3rem; color: #fff; }
        .ld-price { font-family: 'Barlow Condensed', 'Barlow', sans-serif; font-weight: 900; line-height: 1; color: #C8102E; font-size: clamp(4.5rem, 10vw, 8rem); margin-bottom: .25rem; }
        .ld-note  { color: rgba(255,255,255,.32); font-size: .85rem; margin-bottom: 2.5rem; max-width: 320px; line-height: 1.6; }
        .ld-btns  { display: flex; gap: .85rem; flex-wrap: wrap; justify-content: center; }
        .ld-btn-p { display: inline-flex; align-items: center; gap: .5rem; background: #C8102E; color: #fff; font-size: .78rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; padding: .9rem 2.25rem; text-decoration: none; transition: background .2s; border-radius: 2px; }
        .ld-btn-p:hover { background: #a50e25; }
        .ld-btn-s { display: inline-flex; align-items: center; gap: .5rem; border: 1.5px solid rgba(255,255,255,.25); color: rgba(255,255,255,.6); font-size: .78rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; padding: .875rem 2.25rem; text-decoration: none; transition: all .2s; border-radius: 2px; }
        .ld-btn-s:hover { border-color: #fff; color: #fff; }

        /* ════════════════════════════════
           MENU CATEGORIES
        ════════════════════════════════ */
        .menu-section      { background: #111; padding: 3rem 0; }
        .menu-section-head { text-align: center; margin-bottom: 2rem; }
        .menu-eyebrow      { font-size: .68rem; font-weight: 800; letter-spacing: .24em; text-transform: uppercase; color: #C8102E; margin-bottom: .6rem; }
        .menu-title        { font-size: clamp(2.25rem, 4.5vw, 3.75rem); color: #fff; }
        .cat-grid          { display: grid; grid-template-columns: 1fr; gap: .75rem; max-width: 72rem; margin: 0 auto; padding: 0 1rem; }
        .cat-tile          { border-radius: .875rem; display: flex; align-items: center; gap: .75rem; padding: 1rem 1.1rem; text-decoration: none; transition: transform .25s, box-shadow .25s; }
        .cat-tile:hover    { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,.4); }
        .cat-emoji         { font-size: 2rem; line-height: 1; flex-shrink: 0; width: 2.5rem; text-align: center; }
        .cat-info          { flex: 1; }
        .cat-name          { color: #fff; font-weight: 700; font-size: .9rem; line-height: 1.3; margin-bottom: .15rem; }
        .cat-price         { font-size: .8rem; font-weight: 600; }
        .cat-arr           { margin-left: auto; opacity: .4; flex-shrink: 0; transition: opacity .2s, transform .2s; }
        .cat-tile:hover .cat-arr { opacity: .8; transform: translateX(3px); }

        /* Category palette */
        .cat-red    { background: rgba(200,16,46,.14);   border: 1px solid rgba(200,16,46,.28); }
        .cat-red .cat-price    { color: #ef4444; }
        .cat-amber  { background: rgba(217,119,6,.14);   border: 1px solid rgba(217,119,6,.28); }
        .cat-amber .cat-price  { color: #f59e0b; }
        .cat-green  { background: rgba(22,163,74,.14);   border: 1px solid rgba(22,163,74,.28); }
        .cat-green .cat-price  { color: #22c55e; }
        .cat-blue   { background: rgba(3,105,161,.14);   border: 1px solid rgba(3,105,161,.28); }
        .cat-blue .cat-price   { color: #38bdf8; }
        .cat-purple { background: rgba(124,58,237,.14);  border: 1px solid rgba(124,58,237,.28); }
        .cat-purple .cat-price { color: #a78bfa; }
        .cat-pink   { background: rgba(219,39,119,.14);  border: 1px solid rgba(219,39,119,.28); }
        .cat-pink .cat-price   { color: #f472b6; }

        .menu-cta      { text-align: center; margin-top: 3rem; }
        .menu-cta-btn  { display: inline-flex; align-items: center; gap: .55rem; border: 1.5px solid rgba(255,255,255,.2); color: rgba(255,255,255,.6); font-size: .78rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; padding: .9rem 2.5rem; text-decoration: none; transition: all .2s; border-radius: 2px; }
        .menu-cta-btn:hover { border-color: #fff; color: #fff; }

        /* ════════════════════════════════
           2-UP PROMO CARDS
        ════════════════════════════════ */
        .pc-section { background: #111; padding: 0 0 5rem; }
        .pc-grid    { display: grid; grid-template-columns: 1fr; gap: 1.5rem; max-width: 72rem; margin: 0 auto; padding: 0 1.5rem; }
        .pc-card    { border-radius: 1.25rem; overflow: hidden; text-decoration: none; position: relative; min-height: 360px; display: flex; flex-direction: column; justify-content: flex-end; }
        .pc-bg      { position: absolute; inset: 0; background-size: cover; background-position: center; transition: transform .55s ease; }
        .pc-card:hover .pc-bg { transform: scale(1.04); }
        .pc-overlay { position: absolute; inset: 0; }
        .pc-body    { position: relative; z-index: 1; padding: 2.5rem 2.25rem; }
        .pc-eyebrow { font-size: .68rem; font-weight: 800; letter-spacing: .2em; text-transform: uppercase; margin-bottom: .85rem; }
        .pc-title   { font-size: clamp(2rem, 3.5vw, 3rem); margin-bottom: .55rem; color: #fff; }
        .pc-desc    { font-size: .875rem; margin-bottom: 1.5rem; line-height: 1.55; }
        .pc-link    { display: inline-flex; align-items: center; gap: .45rem; font-size: .76rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; border: 1.5px solid rgba(255,255,255,.45); color: #fff; padding: .7rem 1.6rem; transition: all .2s; border-radius: 2px; text-decoration: none; }
        .pc-link:hover { background: #fff; color: #111; }

        /* ════════════════════════════════
           OPENING HOURS
        ════════════════════════════════ */
        .hours-section { background: #0d0a09; border-top: 1px solid rgba(255,255,255,.05); padding: 3.5rem 0; }
        .hours-inner   { max-width: 72rem; margin: 0 auto; padding: 0 1.5rem; display: flex; flex-direction: column; gap: 2rem; align-items: center; text-align: center; justify-content: center; }
        .hours-head    { flex-shrink: 0; }
        .hours-eyebrow { font-size: .65rem; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; color: #C8102E; margin-bottom: .35rem; }
        .hours-title   { color: #fff; font-size: clamp(1.5rem, 3vw, 2.2rem); margin: 0; }
        .hours-grid    { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem 2.5rem; }
        .hours-item-day  { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: rgba(255,255,255,.28); margin-bottom: .2rem; }
        .hours-item-time { color: #fff; font-weight: 600; font-size: .9rem; white-space: nowrap; }
        .hours-cta-btn   { display: inline-flex; align-items: center; gap: .5rem; border: 1.5px solid rgba(255,255,255,.16); color: rgba(255,255,255,.5); font-size: .76rem; font-weight: 800; letter-spacing: .11em; text-transform: uppercase; padding: .85rem 1.75rem; text-decoration: none; white-space: nowrap; transition: all .2s; border-radius: 2px; }
        .hours-cta-btn:hover { border-color: #fff; color: #fff; }

        /* ════════════════════════════════
           OUR STORY (full-width hero)
        ════════════════════════════════ */
        .story-section  { position: relative; overflow: hidden; min-height: 500px; display: flex; align-items: center; }
        .story-bg       { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .story-overlay  { position: absolute; inset: 0; background: rgba(8,4,2,.78); }
        .story-body     { position: relative; z-index: 1; width: 100%; max-width: 72rem; margin: 0 auto; padding: 6rem 1.5rem; text-align: center; }
        .story-eyebrow  { font-size: .68rem; font-weight: 800; letter-spacing: .24em; text-transform: uppercase; color: #C8102E; margin-bottom: 1rem; }
        .story-title    { font-size: clamp(2.5rem, 5.5vw, 5rem); color: #fff; margin-bottom: 1.25rem; }
        .story-text     { color: rgba(255,255,255,.48); font-size: 1rem; line-height: 1.72; max-width: 500px; margin: 0 auto 2.75rem; }
        .story-cta      { display: inline-flex; align-items: center; gap: .6rem; background: #C8102E; color: #fff; font-size: .8rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; padding: 1.05rem 2.5rem; text-decoration: none; transition: background .2s; border-radius: 2px; }
        .story-cta:hover { background: #a50e25; }

        /* ════════════════════════════════
           RESPONSIVE
        ════════════════════════════════ */
        @media (min-width: 480px) {
            .cat-grid   { grid-template-columns: repeat(2, 1fr); gap: 1rem; padding: 0 1.5rem; }
            .cat-tile   { padding: 1.25rem 1.4rem; gap: 1rem; }
            .menu-section { padding: 5rem 0; }
            .menu-section-head { margin-bottom: 3rem; }
        }
        @media (min-width: 640px) {
            .cat-grid   { grid-template-columns: repeat(3, 1fr); }
            .hours-grid { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 768px) {
            .op-grid     { grid-template-columns: 1fr 1px 1fr 1px 1fr; gap: 0; }
            .op-col      { padding: 1.5rem 2rem; }
            .op-divider  { display: block; align-self: stretch; }
            .pc-grid     { grid-template-columns: 1fr 1fr; }
            .pc-card     { min-height: 440px; }
            .hours-inner { flex-direction: row; align-items: center; text-align: left; gap: 3rem; }
            .hours-grid  { grid-template-columns: repeat(4, auto); gap: 1.25rem 2.5rem; }
        }
        @media (min-width: 1024px) {
            .ld-inner { flex-direction: row; align-items: stretch; gap: 4rem; }
            .ld-text  { align-items: flex-start; text-align: left; order: 1; }
            .ld-illus { order: 2; min-height: 500px; border-radius: 1.5rem; flex: 1; }
            .ld-illus img { min-height: 500px; height: 100%; }
            .ld-btns  { justify-content: flex-start; }
            .cat-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1280px) {
            .cat-grid { grid-template-columns: repeat(6, 1fr); }
            .cat-tile { flex-direction: column; text-align: center; padding: 2rem 1rem; gap: .75rem; }
            .cat-arr  { display: none; }
        }

        /* ════════════════════════════════
           PRODUCT SLIDERS
        ════════════════════════════════ */
        .ps-section    { padding: 5rem 0; background: #0d0a09; border-top: 1px solid rgba(255,255,255,.04); }
        .ps-section--dark { background: #111; }
        .ps-head       { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; max-width: 72rem; margin: 0 auto 2.5rem; padding: 0 1.5rem; flex-wrap: wrap; }
        .ps-head-text  { flex: 1; min-width: 240px; }
        .ps-eyebrow    { font-size: .68rem; font-weight: 800; letter-spacing: .24em; text-transform: uppercase; color: #C8102E; margin-bottom: .5rem; }
        .ps-title      { font-size: clamp(2rem, 4vw, 3.25rem); color: #fff; margin: 0; }
        .ps-view-all   { display: inline-flex; align-items: center; gap: .45rem; border: 1.5px solid rgba(255,255,255,.2); color: rgba(255,255,255,.6); font-size: .72rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; padding: .7rem 1.5rem; text-decoration: none; transition: all .2s; border-radius: 2px; }
        .ps-view-all:hover { border-color: #fff; color: #fff; }

        .ps-wrap       { max-width: 72rem; margin: 0 auto; padding: 0 1.5rem; }
        .ps-track      { display: flex; gap: 1rem; overflow-x: auto; scroll-snap-type: x mandatory; padding-bottom: 1.25rem; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .ps-track::-webkit-scrollbar { display: none; }
        .ps-track > *  { flex: 0 0 72%; scroll-snap-align: start; }
        @media (min-width: 640px) { .ps-track > * { flex: 0 0 44%; } }
        @media (min-width: 1024px) { .ps-track > * { flex: 0 0 26%; } }
        @media (min-width: 1280px) { .ps-track > * { flex: 0 0 21%; } }

        /* ════════════════════════════════
           TESTIMONIALS
        ════════════════════════════════ */
        .tm-section    { background: #0d0a09; padding: 5rem 0; border-top: 1px solid rgba(255,255,255,.04); }
        .tm-head       { text-align: center; margin-bottom: 3rem; max-width: 72rem; margin-left: auto; margin-right: auto; padding: 0 1.5rem; }
        .tm-grid       { display: grid; grid-template-columns: 1fr; gap: 1.25rem; max-width: 72rem; margin: 0 auto; padding: 0 1.5rem; }
        .tm-card       { background: #111111; border: 1px solid rgba(200,16,46,.18); padding: 2rem 1.75rem; border-radius: 1rem; display: flex; flex-direction: column; }
        .tm-stars      { display: flex; gap: 2px; margin-bottom: 1.1rem; }
        .tm-quote      { color: rgba(255,255,255,.7); font-size: .95rem; line-height: 1.7; margin-bottom: 1.5rem; flex: 1; }
        .tm-person     { display: flex; align-items: center; gap: .85rem; }
        .tm-avatar     { width: 2.75rem; height: 2.75rem; border-radius: 50%; background: #C8102E; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .95rem; flex-shrink: 0; }
        .tm-author     { color: #fff; font-weight: 700; font-size: .88rem; }
        .tm-role       { color: rgba(255,255,255,.4); font-size: .75rem; margin-top: .1rem; }
        @media (min-width: 768px) { .tm-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .tm-grid { grid-template-columns: repeat(3, 1fr); } }

        /* ════════════════════════════════
           NEWSLETTER
        ════════════════════════════════ */
        .nl-section  { background: linear-gradient(135deg, #C8102E 0%, #8B0A1D 100%); padding: 4.5rem 0; }
        .nl-inner    { max-width: 46rem; margin: 0 auto; padding: 0 1.5rem; text-align: center; }
        .nl-eyebrow  { font-size: .68rem; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; color: rgba(255,255,255,.65); margin-bottom: .85rem; }
        .nl-title    { font-size: clamp(2rem, 4.5vw, 3.25rem); color: #fff; margin-bottom: .9rem; }
        .nl-text     { color: rgba(255,255,255,.75); font-size: .95rem; margin-bottom: 2rem; line-height: 1.55; }
        .nl-form     { display: flex; gap: .6rem; max-width: 30rem; margin: 0 auto; flex-direction: column; }
        .nl-input    { flex: 1; padding: .95rem 1.2rem; border: none; border-radius: 2px; background: rgba(255,255,255,.14); color: #fff; font-size: .9rem; outline: none; border: 1px solid rgba(255,255,255,.22); }
        .nl-input::placeholder { color: rgba(255,255,255,.55); }
        .nl-input:focus { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.5); }
        .nl-btn      { padding: .95rem 1.75rem; background: #0d0a09; color: #fff; font-size: .76rem; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; border: none; border-radius: 2px; cursor: pointer; transition: background .2s; }
        .nl-btn:hover { background: #fff; color: #C8102E; }
        @media (min-width: 640px) { .nl-form { flex-direction: row; } }

        /* ════════════════════════════════
           ENHANCEMENTS
        ════════════════════════════════ */

        /* WhatsApp green tint */
        .op-col--wa:hover .op-icon { background: rgba(37,211,102,.18) !important; border-color: #25D366 !important; }
        .op-btn--wa { border-color: rgba(37,211,102,.45) !important; }
        .op-btn--wa:hover { background: #25D366 !important; color: #fff !important; border-color: #25D366 !important; }

        /* Product slider arrows */
        .ps-wrap { position: relative; }
        .ps-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 10; width: 2.5rem; height: 2.5rem; border-radius: 50%; border: 1.5px solid rgba(255,255,255,.15); background: rgba(13,10,9,.85); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.5); cursor: pointer; transition: all .2s; }
        .ps-arrow:hover { background: #C8102E; border-color: #C8102E; color: #fff; }
        .ps-arrow--l { left: .25rem; }
        .ps-arrow--r { right: .25rem; }
        @media (max-width: 639px) { .ps-arrow { display: none; } }

        /* Product slider dots */
        .ps-dots { display: flex; justify-content: center; gap: .4rem; margin-top: 1rem; padding: 0 1.5rem; }
        .ps-dot  { width: .5rem; height: .5rem; border-radius: 50%; background: rgba(255,255,255,.15); border: none; padding: 0; cursor: pointer; transition: all .3s; }
        .ps-dot.on { background: #C8102E; width: 1.25rem; border-radius: .25rem; }
        @media (min-width: 1024px) { .ps-dots { display: none; } }

        /* Menu emoji bounce */
        .cat-emoji { transition: transform .3s ease; }
        .cat-tile:hover .cat-emoji { transform: scale(1.3) translateY(-3px); animation: emojiBounce .45s ease; }
        @keyframes emojiBounce { 0% { transform: scale(1) translateY(0); } 40% { transform: scale(1.35) translateY(-6px); } 70% { transform: scale(1.25) translateY(-1px); } 100% { transform: scale(1.3) translateY(-3px); } }

        /* Opening hours — today highlight */
        .hours-item { position: relative; padding-left: 12px; }
        .hours-item--today .hours-item-day  { color: #C8102E !important; }
        .hours-item--today .hours-item-time { color: #fff; font-weight: 700; }
        .hours-item--today::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; border-radius: 2px; background: #C8102E; }

        /* Testimonials mobile carousel */
        @media (max-width: 767px) {
            .tm-grid { display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 1rem; scrollbar-width: none; -webkit-overflow-scrolling: touch; }
            .tm-grid::-webkit-scrollbar { display: none; }
            .tm-card { flex: 0 0 85%; scroll-snap-align: center; }
        }
        .tm-dots { display: flex; justify-content: center; gap: .4rem; margin-top: 1.25rem; }
        .tm-dot  { width: .5rem; height: .5rem; border-radius: 50%; background: rgba(255,255,255,.15); border: none; padding: 0; cursor: pointer; transition: all .3s; }
        .tm-dot.on { background: #C8102E; width: 1.25rem; border-radius: .25rem; }
        @media (min-width: 768px) { .tm-dots { display: none; } }

        /* Our Story parallax */
        .story-bg { transition: transform .1s linear; will-change: transform; }

        /* Lunchtime deal price animation */
        .ld-price { transition: opacity .6s ease, transform .6s ease; }

        /* Fade-in on scroll — only hide when JS is ready (progressive enhancement) */
        .jb-ready .jb-reveal { opacity: 0; transform: translateY(30px); transition: opacity .7s ease, transform .7s ease; }
        .jb-ready .jb-reveal.jb-visible { opacity: 1; transform: translateY(0); }
    </style>
    </x-slot>

    {{-- ════════════════════════════════════════════════════════
         FLASH SALE POPUP
    ════════════════════════════════════════════════════════ --}}
    @if($flashSale)
    <div x-data="flashSalePopup({{ $flashSale->remaining_time }},'{{ $flashSale->slug }}')"
         x-show="open" x-cloak @keydown.escape.window="dismiss()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="dismiss()" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
             class="relative w-full max-w-md overflow-hidden rounded-2xl shadow-2xl" @click.stop>
            <button @click="dismiss()" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center text-white/80 hover:text-white rounded-full hover:bg-white/10 z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="bg-gradient-to-br from-[#C8102E] to-[#8B0A1D] px-6 pt-8 pb-6 text-center">
                <p class="text-white/80 text-xs font-bold tracking-widest uppercase mb-1">Limited Time</p>
                <h2 class="jbp-h text-3xl text-white mb-4">{{ $flashSale->name }}</h2>
                <div class="flex items-center justify-center gap-3">
                    <div class="bg-white/15 rounded-xl px-3 py-2 min-w-[60px] text-center"><span class="block text-2xl font-bold text-white tabular-nums" x-text="hours">00</span><span class="block text-[10px] text-white/70 uppercase">Hrs</span></div>
                    <span class="text-2xl font-bold text-white/50">:</span>
                    <div class="bg-white/15 rounded-xl px-3 py-2 min-w-[60px] text-center"><span class="block text-2xl font-bold text-white tabular-nums" x-text="minutes">00</span><span class="block text-[10px] text-white/70 uppercase">Min</span></div>
                    <span class="text-2xl font-bold text-white/50">:</span>
                    <div class="bg-white/15 rounded-xl px-3 py-2 min-w-[60px] text-center"><span class="block text-2xl font-bold text-white tabular-nums" x-text="seconds">00</span><span class="block text-[10px] text-white/70 uppercase">Sec</span></div>
                </div>
            </div>
            <div class="bg-white px-6 py-5 text-center">
                <a href="{{ route('products.index') }}?flash_sale={{ $flashSale->slug }}" @click="dismiss()"
                   class="inline-flex items-center gap-2 w-full justify-center py-3 bg-[#C8102E] text-white text-sm font-bold rounded-lg">Shop the Sale Now</a>
                <button @click="dismiss()" class="mt-2 text-xs text-neutral-500 hover:text-neutral-700">No thanks</button>
            </div>
        </div>
    </div>
    <script>
    function flashSalePopup(s,slug){return{open:false,remaining:s,timer:null,get hours(){return String(Math.floor(this.remaining/3600)).padStart(2,'0')},get minutes(){return String(Math.floor((this.remaining%3600)/60)).padStart(2,'0')},get seconds(){return String(this.remaining%60).padStart(2,'0')},init(){const k='fs_'+slug;if(sessionStorage.getItem(k))return;setTimeout(()=>{this.open=true;document.body.style.overflow='hidden'},1500);this.timer=setInterval(()=>{if(this.remaining>0)this.remaining--;else{clearInterval(this.timer);this.dismiss()}},1000)},dismiss(){this.open=false;document.body.style.overflow='';sessionStorage.setItem('fs_'+slug,'1');if(this.timer)clearInterval(this.timer)}}}
    </script>
    @endif


    {{-- Alpine component functions — must be defined before Alpine encounters x-data --}}
    <script>
    function sliderNav(track, count) {
        return {
            track, count, cur: 0, pages: 0,
            init() {
                this.$nextTick(() => {
                    if (!this.track) return;
                    this.calcPages();
                    new ResizeObserver(() => this.calcPages()).observe(this.track);
                });
            },
            calcPages() {
                if (!this.track || !this.track.children.length) return;
                const child = this.track.children[0];
                const cw = child.offsetWidth + parseInt(getComputedStyle(this.track).gap || 16);
                const visible = Math.floor(this.track.offsetWidth / cw);
                this.pages = Math.max(1, Math.ceil(this.count / Math.max(visible, 1)));
            },
            scrollBy(dir) {
                if (!this.track) return;
                const child = this.track.children[0];
                const cw = child.offsetWidth + parseInt(getComputedStyle(this.track).gap || 16);
                const visible = Math.floor(this.track.offsetWidth / cw);
                this.track.scrollBy({ left: dir * cw * visible, behavior: 'smooth' });
            },
            goPage(p) {
                if (!this.track || !this.track.children.length) return;
                const child = this.track.children[0];
                const cw = child.offsetWidth + parseInt(getComputedStyle(this.track).gap || 16);
                const visible = Math.floor(this.track.offsetWidth / cw);
                this.track.scrollTo({ left: (p - 1) * cw * visible, behavior: 'smooth' });
            },
            onScroll() {
                if (!this.track || !this.track.children.length) return;
                const child = this.track.children[0];
                const cw = child.offsetWidth + parseInt(getComputedStyle(this.track).gap || 16);
                const visible = Math.floor(this.track.offsetWidth / cw);
                const idx = Math.round(this.track.scrollLeft / (cw * Math.max(visible, 1)));
                this.cur = Math.min(idx + 1, this.pages);
            }
        };
    }
    function priceReveal(finalText) {
        return {
            display: finalText, finalText, animated: false,
            animate() {
                if (this.animated) return;
                this.animated = true;
                const match = this.finalText.match(/[\d.]+/);
                if (!match) return;
                const target = parseFloat(match[0]);
                const prefix = this.finalText.slice(0, this.finalText.indexOf(match[0]));
                const suffix = this.finalText.slice(this.finalText.indexOf(match[0]) + match[0].length);
                const decimals = match[0].includes('.') ? match[0].split('.')[1].length : 0;
                const duration = 800;
                const start = performance.now();
                const step = (now) => {
                    const p = Math.min((now - start) / duration, 1);
                    const ease = 1 - Math.pow(1 - p, 3);
                    const val = (target * ease).toFixed(decimals);
                    this.display = prefix + val + suffix;
                    if (p < 1) requestAnimationFrame(step);
                    else this.display = this.finalText;
                };
                requestAnimationFrame(step);
            }
        };
    }
    </script>

    {{-- ════════════════════════════════════════════════════════
    ░░  S1 — HERO CAROUSEL
        Full-viewport · bottom-left text · bar indicators
    ════════════════════════════════════════════════════════ --}}
    @php
        // Accept image_url stored either as public/ path (e.g. "images/...") OR
        // storage path ("banners/xyz.jpg" from admin uploads). Chooses the right URL.
        $bannerImg = function ($path) {
            if (!$path) return asset('images/placeholder-banner.jpg');
            return str_starts_with($path, 'images/')
                ? asset($path)
                : asset('storage/' . $path);
        };
        // Palette for the hero "eyebrow" tag — cycles by slide index
        $heroTagPalette = [
            ['bg' => '#C8102E', 'fg' => '#fff'],
            ['bg' => '#F59E0B', 'fg' => '#0d0a09'],
            ['bg' => '#ec4899', 'fg' => '#fff'],
            ['bg' => '#22c55e', 'fg' => '#0d0a09'],
        ];
    @endphp

    <section style="background: #1a0e08;" x-data="{
        cur: 0, total: {{ max($banners->count(), 1) }}, tm: null, paused: false,
        sx: 0, sy: 0, swiping: false,
        init(){ this.autoplay() },
        autoplay(){ if(this.total > 1) this.tm = setInterval(() => { if(!this.paused) this.next() }, 6500) },
        next(){ this.cur = (this.cur + 1) % this.total },
        prev(){ this.cur = (this.cur - 1 + this.total) % this.total },
        go(n){ this.cur = n; clearInterval(this.tm); this.autoplay() },
        tstart(e){ this.sx = e.touches[0].clientX; this.sy = e.touches[0].clientY; this.swiping = true },
        tmove(e){ if(!this.swiping) return; const dx = e.touches[0].clientX - this.sx; const dy = e.touches[0].clientY - this.sy; if(Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 12) e.preventDefault() },
        tend(e){ if(!this.swiping) return; this.swiping = false; const dx = e.changedTouches[0].clientX - this.sx; if(dx < -50) { this.go((this.cur+1) % this.total) } else if(dx > 50) { this.go((this.cur-1+this.total) % this.total) } }
    }"
    @mouseenter="paused = true" @mouseleave="paused = false"
    @touchstart.passive="tstart($event)" @touchmove="tmove($event)" @touchend.passive="tend($event)">
        <div class="hero-wrap">

            @forelse($banners as $idx => $banner)
                @php $tag = $heroTagPalette[$idx % count($heroTagPalette)]; @endphp
                <div class="hero-slide"
                     x-show="cur === {{ $idx }}"
                     x-transition:enter="transition-opacity ease-out duration-700"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-500"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                    <div class="hero-bg" style="background-image: url('{{ $bannerImg($banner->image_url) }}');"></div>
                    <div class="hero-grad"></div>
                    <div class="hero-body">
                        <div class="hero-inner">
                            @if($banner->name)
                                <span class="hero-tag" style="background: {{ $tag['bg'] }}; color: {{ $tag['fg'] }};">{{ $banner->name }}</span>
                            @endif
                            <h{{ $idx === 0 ? '1' : '2' }} class="jbp-h hero-title">{!! nl2br(e($banner->title)) !!}</h{{ $idx === 0 ? '1' : '2' }}>
                            @if($banner->subtitle)
                                <p class="hero-sub">{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner->button_text)
                                <a href="{{ $banner->link ?: route('products.index') }}" class="hero-cta">
                                    {{ $banner->button_text }}
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                {{-- Fallback when no banners configured in DB --}}
                <div class="hero-slide">
                    <div class="hero-bg" style="background-image: url('{{ asset('images/products/justburgers/monster-burger.jpg') }}');"></div>
                    <div class="hero-grad"></div>
                    <div class="hero-body">
                        <div class="hero-inner">
                            <span class="hero-tag" style="background: #C8102E; color: #fff;">Established 1989</span>
                            <h1 class="jbp-h hero-title">Charbroiled<br>Burgers</h1>
                            <p class="hero-sub">Flame-grilled to order. The way they should be.</p>
                            <a href="{{ route('products.index') }}" class="hero-cta">
                                Order Now
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse

            {{-- Prev/Next arrows --}}
            <button @click="prev()" class="slide-arrow" style="left: .75rem;" aria-label="Previous slide">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="next()" class="slide-arrow" style="right: .75rem;" aria-label="Next slide">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            {{-- Progress bar indicators (bottom-left, like Nando's) --}}
            <div class="hero-bars">
                <template x-for="i in total" :key="i">
                    <button @click="go(i - 1)"
                            class="hero-bar"
                            :class="cur === (i - 1) ? 'on' : ''"
                            :aria-label="'Slide ' + i"></button>
                </template>
            </div>

            {{-- Angled slant overlaid on banner bottom --}}
            <span class="hero-slant">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none"
                     style="display:block; height:64px; width:100%;" fill="#0f1d2e">
                    <polygon points="0,80 1440,18 1440,80"/>
                </svg>
            </span>
        </div>
    </section>


    {{-- ════════════════════════════════════════════════════════
    ░░  S2 — ORDER PANEL
        Call Us  |  WhatsApp  |  Order Online
    ════════════════════════════════════════════════════════ --}}
    <section class="op-panel jb-reveal">
        <div class="op-grid">

            {{-- Call Us --}}
            <div class="op-col">
                <div class="op-icon">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <p class="op-title">Call Us</p>
                <p class="op-desc">Ring your order through and collect when ready. Telephone orders always welcome.</p>
                <a href="tel:{{ \App\Models\Setting::get('site_phone','02088905008') }}" class="op-btn">
                    {{ \App\Models\Setting::get('site_phone','020 8890 5008') }}
                </a>
            </div>

            <div class="op-divider"></div>

            {{-- WhatsApp --}}
            <div class="op-col op-col--wa">
                <div class="op-icon" style="border-color: rgba(37,211,102,.35);">
                    <svg width="22" height="22" fill="#25D366" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </div>
                <p class="op-title">WhatsApp</p>
                <p class="op-desc">Message us your order on WhatsApp &mdash; quick, easy, confirmed.</p>
                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','447368998035') }}?text={{ urlencode('Hi! I\'d like to place an order please.') }}"
                   target="_blank" rel="noopener" class="op-btn op-btn--wa">
                    Order on WhatsApp
                </a>
            </div>

            <div class="op-divider"></div>

            {{-- Order Online --}}
            <div class="op-col">
                <div class="op-icon">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                </div>
                <p class="op-title">Order Online</p>
                <p class="op-desc">Browse our full menu and place your order online for collection.</p>
                <a href="{{ route('products.index') }}" class="op-btn">
                    View Our Menu
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

        </div>

        {{-- Slant → lunchtime deal --}}
        <span class="slant">
            <svg viewBox="0 0 1440 55" preserveAspectRatio="none"
                 style="display:block; height:44px; width:100%;" fill="#000">
                <polygon points="0,55 1440,14 1440,55"/>
            </svg>
        </span>
    </section>


    {{-- ════════════════════════════════════════════════════════
    ░░  S3 — LUNCHTIME DEAL  (Rewards-style promo)
        Text LEFT · Illustration RIGHT (desktop)
    ════════════════════════════════════════════════════════ --}}
    @php $ld = $sections->get('lunchtime_deal'); @endphp
    @if($ld)
    <div class="ld-wrap jb-reveal">
        <div class="ld-inner">

            {{-- Text panel (left on desktop) --}}
            <div class="ld-text">
                @if(!empty($ld->content['tag']))
                    <span class="ld-tag">{{ $ld->content['tag'] }}</span>
                @endif
                <h2 class="jbp-h ld-title">{!! nl2br(e($ld->title)) !!}</h2>
                @if($ld->subtitle)
                    <p style="color:rgba(255,255,255,.35);font-size:.95rem;margin-bottom:.4rem;font-weight:500;">{{ $ld->subtitle }}</p>
                @endif
                @if(!empty($ld->content['price']))
                    <div class="ld-price" x-data="priceReveal('{{ $ld->content['price'] }}')" x-intersect:enter.once="animate()" x-text="display">{{ $ld->content['price'] }}</div>
                @endif
                @if(!empty($ld->content['note']))
                    <p class="ld-note">{{ $ld->content['note'] }}</p>
                @endif
                <div class="ld-btns">
                    <a href="{{ $ld->button_link ?: route('products.index') }}" class="ld-btn-p">
                        {{ $ld->button_text ?: 'Order Now' }}
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="{{ route('products.index') }}" class="ld-btn-s">View Menu</a>
                </div>
            </div>

            {{-- Illustration (right on desktop) --}}
            <div class="ld-illus">
                <img src="{{ $bannerImg($ld->image_url) }}" alt="{{ $ld->title }}"
                     style="width:100%;height:100%;object-fit:cover;display:block;">
            </div>

        </div>
    </div>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S3B — POPULAR ITEMS  (Featured Products)
    ════════════════════════════════════════════════════════ --}}
    @if($featuredProducts->count())
    <section class="ps-section jb-reveal" x-data="sliderNav($refs.fpTrack, {{ $featuredProducts->count() }})">
        <div class="ps-head">
            <div class="ps-head-text">
                <p class="ps-eyebrow">Fan Favourites</p>
                <h2 class="jbp-h ps-title">Popular Items</h2>
            </div>
            <a href="{{ route('products.index') }}" class="ps-view-all">
                View All
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="ps-wrap">
            <button class="ps-arrow ps-arrow--l" @click="scrollBy(-1)" aria-label="Scroll left">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="ps-track" x-ref="fpTrack" @scroll.passive="onScroll()">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" compact />
                @endforeach
            </div>
            <button class="ps-arrow ps-arrow--r" @click="scrollBy(1)" aria-label="Scroll right">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="ps-dots">
            <template x-for="i in pages" :key="i">
                <button class="ps-dot" :class="cur === i ? 'on' : ''" @click="goPage(i)"></button>
            </template>
        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S4 — MENU CATEGORIES
        6 colour-coded tiles with horizontal arrow at desktop
    ════════════════════════════════════════════════════════ --}}
    @php $menuHead = $sections->get('menu_head'); @endphp
    <section class="menu-section jb-reveal">
        <div style="max-width:72rem;margin:0 auto;padding:0 1.5rem;">
            <div class="menu-section-head">
                <p class="menu-eyebrow">{{ $menuHead?->subtitle ?: 'What We Do Best' }}</p>
                <h2 class="jbp-h menu-title">{{ $menuHead?->title ?: 'Our Menu' }}</h2>
            </div>

            @php
                $catPalette = ['red', 'amber', 'green', 'blue', 'purple', 'pink'];
                $catEmojiMap = [
                    'classic' => '🍔', 'gourmet' => '🔥', 'burger' => '🍔',
                    'chicken' => '🍗', 'fish' => '🐟', 'veggie' => '🥬', 'veg' => '🥬',
                    'kid' => '⭐', 'shake' => '🥤', 'milk' => '🥤', 'drink' => '🥤',
                    'side' => '🍟', 'fries' => '🍟', 'wing' => '🍗', 'kebab' => '🌯',
                    'nugget' => '🍗', 'strip' => '🍗', 'salad' => '🥗', 'dessert' => '🍰',
                    'sauce' => '🍶', 'wrap' => '🌯', 'meal' => '🍽️', 'combo' => '🍽️',
                ];
                $pickEmoji = function ($name) use ($catEmojiMap) {
                    $n = strtolower($name);
                    foreach ($catEmojiMap as $k => $e) {
                        if (str_contains($n, $k)) return $e;
                    }
                    return '🍴';
                };
            @endphp
            <div class="cat-grid">
                @forelse($carouselCategories->take(6) as $idx => $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="cat-tile cat-{{ $catPalette[$idx % count($catPalette)] }}">
                        <span class="cat-emoji">{{ $pickEmoji($category->name) }}</span>
                        <div class="cat-info">
                            <p class="cat-name">{{ $category->name }}</p>
                            <p class="cat-price">{{ $category->products_count }} {{ Str::plural('item', $category->products_count) }}</p>
                        </div>
                        <svg class="cat-arr" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                @empty
                    <a href="{{ route('products.index') }}" class="cat-tile cat-red">
                        <span class="cat-emoji">🍔</span>
                        <div class="cat-info">
                            <p class="cat-name">View Full Menu</p>
                            <p class="cat-price">Everything on offer</p>
                        </div>
                        <svg class="cat-arr" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                @endforelse
            </div>

            <div class="menu-cta">
                <a href="{{ $menuHead?->button_link ?: route('products.index') }}" class="menu-cta-btn">
                    {{ $menuHead?->button_text ?: 'View Full Menu' }}
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>


    {{-- ════════════════════════════════════════════════════════
    ░░  S4B — BESTSELLERS  (Top sellers by sales_count)
    ════════════════════════════════════════════════════════ --}}
    @if($bestsellers->count())
    <section class="ps-section ps-section--dark jb-reveal" x-data="sliderNav($refs.bsTrack, {{ $bestsellers->count() }})">
        <div class="ps-head">
            <div class="ps-head-text">
                <p class="ps-eyebrow">What Everyone Orders</p>
                <h2 class="jbp-h ps-title">Most Popular</h2>
            </div>
            <a href="{{ route('products.index') }}" class="ps-view-all">
                View All
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="ps-wrap">
            <button class="ps-arrow ps-arrow--l" @click="scrollBy(-1)" aria-label="Scroll left">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="ps-track" x-ref="bsTrack" @scroll.passive="onScroll()">
                @foreach($bestsellers as $product)
                    <x-product-card :product="$product" compact />
                @endforeach
            </div>
            <button class="ps-arrow ps-arrow--r" @click="scrollBy(1)" aria-label="Scroll right">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="ps-dots">
            <template x-for="i in pages" :key="i">
                <button class="ps-dot" :class="cur === i ? 'on' : ''" @click="goPage(i)"></button>
            </template>
        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S4C — TODAY'S DEALS  (price < mrp)
    ════════════════════════════════════════════════════════ --}}
    @if($deals->count())
    <section class="ps-section jb-reveal" x-data="sliderNav($refs.dlTrack, {{ $deals->count() }})">
        <div class="ps-head">
            <div class="ps-head-text">
                <p class="ps-eyebrow">Limited Time</p>
                <h2 class="jbp-h ps-title">Today's Deals</h2>
            </div>
            <a href="{{ route('products.index') }}" class="ps-view-all">
                View All
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="ps-wrap">
            <button class="ps-arrow ps-arrow--l" @click="scrollBy(-1)" aria-label="Scroll left">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="ps-track" x-ref="dlTrack" @scroll.passive="onScroll()">
                @foreach($deals as $product)
                    <x-product-card :product="$product" compact />
                @endforeach
            </div>
            <button class="ps-arrow ps-arrow--r" @click="scrollBy(1)" aria-label="Scroll right">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="ps-dots">
            <template x-for="i in pages" :key="i">
                <button class="ps-dot" :class="cur === i ? 'on' : ''" @click="goPage(i)"></button>
            </template>
        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S5 — 2-UP PROMO CARDS
        Left: Speciality burger (red tinted)  ·  Right: Find Us
    ════════════════════════════════════════════════════════ --}}
    @php
        $promoSpec = $sections->get('promo_speciality');
        $promoLoc  = $sections->get('promo_location');
    @endphp
    @if($promoSpec || $promoLoc)
    <section class="pc-section jb-reveal">
        <div class="pc-grid">

            {{-- Card 1: Speciality — food photo + deep red overlay --}}
            @if($promoSpec)
            <a href="{{ $promoSpec->button_link ?: route('products.index') }}" class="pc-card">
                <div class="pc-bg" style="background-image: url('{{ $bannerImg($promoSpec->image_url) }}');"></div>
                <div class="pc-overlay" style="background: linear-gradient(160deg, rgba(120,6,22,.88) 0%, rgba(10,4,2,.6) 100%);"></div>
                <div class="pc-body">
                    @if(!empty($promoSpec->content['eyebrow']))
                        <p class="pc-eyebrow" style="color: rgba(255,200,180,.65);">{{ $promoSpec->content['eyebrow'] }}</p>
                    @endif
                    <h3 class="jbp-h pc-title">{!! nl2br(e($promoSpec->title)) !!}</h3>
                    @if($promoSpec->subtitle)
                        <p class="pc-desc" style="color: rgba(255,255,255,.6);">{{ $promoSpec->subtitle }}</p>
                    @endif
                    @if($promoSpec->button_text)
                    <span class="pc-link">
                        {{ $promoSpec->button_text }}
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                    @endif
                </div>
            </a>
            @endif

            {{-- Card 2: Find Us — dark location photo --}}
            @if($promoLoc)
            <a href="{{ $promoLoc->button_link ?: url('/contact') }}" class="pc-card">
                <div class="pc-bg" style="background-image: url('{{ $bannerImg($promoLoc->image_url) }}'); background-position: center top;"></div>
                <div class="pc-overlay" style="background: linear-gradient(to top, rgba(6,3,2,.95) 0%, rgba(6,3,2,.55) 55%, rgba(6,3,2,.15) 100%);"></div>
                <div class="pc-body">
                    @if(!empty($promoLoc->content['eyebrow']))
                        <p class="pc-eyebrow" style="color: #C8102E;">{{ $promoLoc->content['eyebrow'] }}</p>
                    @endif
                    <h3 class="jbp-h pc-title">{!! nl2br(e($promoLoc->title)) !!}</h3>
                    @if($promoLoc->subtitle)
                        <p class="pc-desc" style="color: rgba(255,255,255,.5);">{{ $promoLoc->subtitle }}</p>
                    @endif
                    @if($promoLoc->button_text)
                    <span class="pc-link">
                        {{ $promoLoc->button_text }}
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </span>
                    @endif
                </div>
            </a>
            @endif

        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S5B — TESTIMONIALS
    ════════════════════════════════════════════════════════ --}}
    @if($testimonials->count())
    <section class="tm-section jb-reveal" x-data="{ tmCur: 0, tmTotal: {{ $testimonials->count() }}, tmScroll(el) { const cards = el.children; if(!cards.length) return; const sl = el.scrollLeft; const cw = cards[0].offsetWidth + 16; this.tmCur = Math.round(sl / cw); } }">
        <div class="tm-head">
            <p class="ps-eyebrow">Word of Mouth</p>
            <h2 class="jbp-h ps-title">What People Say</h2>
        </div>
        <div class="tm-grid" x-ref="tmGrid" @scroll.passive="tmScroll($refs.tmGrid)">
            @foreach($testimonials as $testimonial)
                <div class="tm-card">
                    <div class="tm-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="14" height="14" viewBox="0 0 20 20"
                                 fill="{{ $i <= ($testimonial->rating ?? 5) ? '#D4A017' : 'rgba(255,255,255,.15)' }}">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="tm-quote">&ldquo;{{ $testimonial->content }}&rdquo;</p>
                    <div class="tm-person">
                        @if($testimonial->avatar_url)
                            <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}"
                                 class="tm-avatar" style="object-fit:cover;">
                        @else
                            <div class="tm-avatar">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</div>
                        @endif
                        <div>
                            <p class="tm-author">{{ $testimonial->name }}</p>
                            @if($testimonial->title)
                                <p class="tm-role">{{ $testimonial->title }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tm-dots" style="max-width:72rem;margin-left:auto;margin-right:auto;">
            <template x-for="i in tmTotal" :key="i">
                <button class="tm-dot" :class="tmCur === (i-1) ? 'on' : ''"
                        @click="$refs.tmGrid.children[i-1]?.scrollIntoView({behavior:'smooth',inline:'center',block:'nearest'})"></button>
            </template>
        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S6 — OPENING HOURS
    ════════════════════════════════════════════════════════ --}}
    @php $todayDow = (int) now('Europe/London')->format('N'); @endphp
    <section class="hours-section jb-reveal">
        <div class="hours-inner">
            <div class="hours-head">
                <p class="hours-eyebrow">{{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP') }}</p>
                <h3 class="jbp-h hours-title">Opening Hours</h3>
            </div>
            <div class="hours-grid">
                <div class="hours-item {{ in_array($todayDow, [1,2]) ? 'hours-item--today' : '' }}">
                    <p class="hours-item-day">Mon &amp; Tue</p>
                    <p class="hours-item-time">{{ \App\Models\Setting::get('hours_monday', '12:00 – 9:00 PM') }}</p>
                </div>
                <div class="hours-item {{ in_array($todayDow, [3,4]) ? 'hours-item--today' : '' }}">
                    <p class="hours-item-day">Wed &amp; Thu</p>
                    <p class="hours-item-time">{{ \App\Models\Setting::get('hours_wednesday', '12:00 – 10:00 PM') }}</p>
                </div>
                <div class="hours-item {{ in_array($todayDow, [5,6]) ? 'hours-item--today' : '' }}">
                    <p class="hours-item-day">Fri &amp; Sat</p>
                    <p class="hours-item-time">{{ \App\Models\Setting::get('hours_friday', '12:00 – 11:00 PM') }}</p>
                </div>
                <div class="hours-item {{ $todayDow === 7 ? 'hours-item--today' : '' }}">
                    <p class="hours-item-day">Sunday</p>
                    <p class="hours-item-time">{{ \App\Models\Setting::get('hours_sunday', '4:00 – 10:00 PM') }}</p>
                </div>
            </div>
            <div style="flex-shrink:0;">
                <a href="{{ url('/contact') }}" class="hours-cta-btn">
                    Find Us
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>


    {{-- ════════════════════════════════════════════════════════
    ░░  S7 — OUR STORY  (full-width hero panel)
    ════════════════════════════════════════════════════════ --}}
    @php $story = $sections->get('our_story'); @endphp
    @if($story)
    <section class="story-section jb-reveal">
        <div class="story-bg" style="background-image: url('{{ $bannerImg($story->image_url) }}');"></div>
        <div class="story-overlay"></div>
        <div class="story-body">
            @if(!empty($story->content['eyebrow']))
                <p class="story-eyebrow">{{ $story->content['eyebrow'] }}</p>
            @endif
            <h2 class="jbp-h story-title">{!! nl2br(e($story->title)) !!}</h2>
            @if($story->subtitle)
                <p class="story-text">{{ $story->subtitle }}</p>
            @endif
            @if($story->button_text)
            <a href="{{ $story->button_link ?: url('/about') }}" class="story-cta">
                {{ $story->button_text }}
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
            @endif
        </div>
    </section>
    @endif


    {{-- ════════════════════════════════════════════════════════
    ░░  S8 — NEWSLETTER  (Exclusive offers signup)
    ════════════════════════════════════════════════════════ --}}
    @php $newsletter = $sections->get('newsletter'); @endphp
    @if($newsletter === null || $newsletter->is_active)
    <section class="nl-section jb-reveal"
             x-data="{ email:'', loading:false, done:false, err:'' }">
        <div class="nl-inner">
            <p class="nl-eyebrow">{{ $newsletter?->content['eyebrow'] ?? 'Stay In The Loop' }}</p>
            <h2 class="jbp-h nl-title">{{ $newsletter?->title ?: 'Get Exclusive Offers' }}</h2>
            <p class="nl-text">{{ $newsletter?->subtitle ?: 'Join our list for lunchtime deal alerts, seasonal specials and first dibs on new menu drops. No spam — ever.' }}</p>

            <form class="nl-form"
                  @submit.prevent="
                    loading = true; err = '';
                    try {
                        const res = await fetch('{{ route('newsletter.subscribe') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ email })
                        });
                        if (res.ok) { done = true; email = ''; } else { err = 'Please try again.'; }
                    } catch(e) { err = 'Please try again.'; }
                    loading = false;
                  ">
                <input type="email" required x-model="email" :disabled="loading || done"
                       class="nl-input" placeholder="your@email.com" aria-label="Email address">
                <button type="submit" class="nl-btn" :disabled="loading || done"
                        x-text="loading ? 'Joining...' : (done ? '✓ Joined' : '{{ $newsletter?->button_text ?: 'Sign Me Up' }}')"></button>
            </form>
            <p x-show="err" x-cloak class="nl-text" style="margin-top:1rem;margin-bottom:0;" x-text="err"></p>
        </div>
    </section>
    @endif

    @push('scripts')
    <script>
    /* ── Our Story parallax ── */
    (function() {
        const story = document.querySelector('.story-section');
        if (!story) return;
        const bg = story.querySelector('.story-bg');
        if (!bg) return;
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function() {
                const rect = story.getBoundingClientRect();
                const vh = window.innerHeight;
                if (rect.bottom > 0 && rect.top < vh) {
                    const progress = (vh - rect.top) / (vh + rect.height);
                    bg.style.transform = 'translateY(' + ((progress - 0.5) * 60) + 'px) scale(1.08)';
                }
                ticking = false;
            });
        }, { passive: true });
    })();

    /* ── Fade-in on scroll (IntersectionObserver) ── */
    (function() {
        const els = document.querySelectorAll('.jb-reveal');
        if (!els.length) return;
        // Mark already-visible elements before enabling animations
        const vh = window.innerHeight;
        els.forEach(function(el) {
            if (el.getBoundingClientRect().top < vh) el.classList.add('jb-visible');
        });
        // Now enable the hidden state (progressive: content visible if JS fails)
        document.documentElement.classList.add('jb-ready');
        const obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('jb-visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        els.forEach(function(el) {
            if (!el.classList.contains('jb-visible')) obs.observe(el);
        });
    })();
    </script>
    @endpush

</x-layouts.app>
