<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

     <?php $__env->slot('title', null, []); ?> <?php echo e($product->name); ?> — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?> <?php $__env->endSlot(); ?>

    <?php $__env->startPush('meta'); ?>
        <meta name="description" content="<?php echo e(Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160)); ?>">
        <link rel="canonical" href="<?php echo e(route('products.show', $product->slug)); ?>">
        <meta property="og:title" content="<?php echo e($product->name); ?>">
        <meta property="og:description" content="<?php echo e(Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160)); ?>">
        <meta property="og:image" content="<?php echo e($product->primary_image_url); ?>">
        <meta property="og:type" content="restaurant.menu_item">
        <meta property="og:url" content="<?php echo e(route('products.show', $product->slug)); ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo e($product->name); ?>">
        <meta name="twitter:description" content="<?php echo e(Str::limit(strip_tags($product->description ?? $product->short_description ?? ''), 160)); ?>">
        <meta name="twitter:image" content="<?php echo e($product->primary_image_url); ?>">
        <?php if (isset($component)) { $__componentOriginal3b707055a4f397d547a1a68409aa6aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b707055a4f397d547a1a68409aa6aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-schema','data' => ['productSchema' => $productSchema ?? null,'faqSchema' => $faqSchema ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-schema'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['productSchema' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($productSchema ?? null),'faqSchema' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($faqSchema ?? null)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b707055a4f397d547a1a68409aa6aaa)): ?>
<?php $attributes = $__attributesOriginal3b707055a4f397d547a1a68409aa6aaa; ?>
<?php unset($__attributesOriginal3b707055a4f397d547a1a68409aa6aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b707055a4f397d547a1a68409aa6aaa)): ?>
<?php $component = $__componentOriginal3b707055a4f397d547a1a68409aa6aaa; ?>
<?php unset($__componentOriginal3b707055a4f397d547a1a68409aa6aaa); ?>
<?php endif; ?>
    <?php $__env->stopPush(); ?>

     <?php $__env->slot('styles', null, []); ?> 
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
     <?php $__env->endSlot(); ?>

    <?php
        $rawImg   = $product->primary_image_url;
        $imgSrc   = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
            ? $rawImg
            : asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
        $fallback = asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
        $phone    = \App\Models\Setting::get('site_phone', '');
        $waPhone  = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('site_mobile', ''));
        $waMsg    = urlencode('Hi! I\'d like to order: ' . $product->name);
        $openHoursArr = [
            'Mon–Tue' => \App\Models\Setting::get('hours_monday', '12:00 – 9:00 PM'),
            'Wed–Thu' => \App\Models\Setting::get('hours_wednesday', '12:00 – 10:00 PM'),
            'Fri–Sat' => \App\Models\Setting::get('hours_friday', '12:00 – 11:00 PM'),
            'Sun'     => \App\Models\Setting::get('hours_sunday', '4:00 – 10:00 PM'),
        ];
    ?>

    <div class="dish-page">

        
        <div class="dish-bc-bar">
            <nav class="dish-bc">
                <a href="<?php echo e(url('/')); ?>">Home</a>
                <span class="dish-bc-sep">/</span>
                <a href="<?php echo e(route('products.index')); ?>">Menu</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                    <span class="dish-bc-sep">/</span>
                    <a href="<?php echo e(route('categories.show', $product->category->slug)); ?>"><?php echo e($product->category->name); ?></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span class="dish-bc-sep">/</span>
                <span style="color:#111111;font-weight:600;"><?php echo e($product->name); ?></span>
            </nav>
        </div>

        
        <div class="dish-main">

            
            <div>
                <div class="dish-img-wrap">
                    <img src="<?php echo e($imgSrc); ?>"
                         alt="<?php echo e($product->name); ?>"
                         onerror="this.onerror=null;this.src='<?php echo e($fallback); ?>';">
                    <div class="dish-img-badge">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->sales_count > 10): ?>
                            <span class="badge-popular">Popular</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->created_at && $product->created_at->diffInDays(now()) < 30): ?>
                            <span class="badge-new">New</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="dish-info">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                <div class="dish-cat-eyebrow"><?php echo e($product->category->name); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <h1 class="dish-name"><?php echo e($product->name); ?></h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->review_count > 0): ?>
                <div class="dish-stars">
                    <div style="display:flex;gap:2px;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg style="width:15px;height:15px;fill:<?php echo e($i <= round($product->rating) ? '#D4A017' : 'rgba(0,0,0,.12)'); ?>;" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <a href="#reviews" @click.prevent="document.getElementById('reviews').scrollIntoView({behavior:'smooth',block:'start'})" style="font-size:.8rem;color:rgba(0,0,0,.4);text-decoration:none;cursor:pointer;">
                        <?php echo e(number_format($product->review_count)); ?> <?php echo e(Str::plural('review', $product->review_count)); ?>

                    </a>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->short_description): ?>
                <p class="dish-short-desc"><?php echo e($product->short_description); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="dish-info-tags">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->stock_quantity > 0): ?>
                        <span class="dish-tag green">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Available
                        </span>
                    <?php else: ?>
                        <span class="dish-tag red">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Sold Out
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->review_count > 0 && $product->rating >= 4): ?>
                        <span class="dish-tag gold">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Top Rated
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                        <span class="dish-tag"><?php echo e($product->category->name); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="order-panel" x-data="{ qty:1, adding:false, added:false }">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div class="dish-price-tag">
                                <?php echo format_price($product->price); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->compare_at_price && $product->compare_at_price > $product->price): ?>
                                    <span class="dish-old-price"><?php echo format_price($product->compare_at_price); ?></span>
                                    <span class="dish-discount-badge"><?php echo e(round((1 - $product->price / $product->compare_at_price) * 100)); ?>% OFF</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div style="font-size:.72rem;color:rgba(0,0,0,.35);text-transform:uppercase;letter-spacing:.07em;margin-top:.2rem;">Per serving</div>
                        </div>
                        
                        <div class="qty-selector">
                            <button type="button" class="qty-btn" @click="qty > 1 ? qty-- : null" :disabled="qty <= 1">-</button>
                            <span class="qty-val" x-text="qty"></span>
                            <button type="button" class="qty-btn" @click="qty < 20 ? qty++ : null" :disabled="qty >= 20">+</button>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->stock_quantity > 0): ?>
                    <button @click="$store.toppingsModal.open(<?php echo e($product->id); ?>, qty)"
                            class="btn-add">
                        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Add to Basket — £<span x-text="(<?php echo e((float) $product->price); ?> * qty).toFixed(2)"></span></span>
                    </button>
                    <?php else: ?>
                    <div style="padding:.75rem;background:#fef2f2;border-radius:99px;text-align:center;font-size:.88rem;font-weight:600;color:#C8102E;">
                        Currently Unavailable
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($waPhone): ?>
                    <a href="https://wa.me/<?php echo e($waPhone); ?>?text=<?php echo e($waMsg); ?>" target="_blank" rel="noopener" class="btn-wa">
                        <svg style="width:18px;height:18px;flex-shrink:0;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Order on WhatsApp
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($phone): ?>
                    <a href="tel:<?php echo e(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="btn-outline">
                        <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call to Order
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <a href="<?php echo e(route('products.index')); ?>" class="btn-outline">
                        <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        View Full Menu
                    </a>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($openHoursArr)): ?>
                    <div class="panel-hours">
                        <div class="panel-hours-title">Opening Hours</div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $openHoursArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="hours-row">
                            <span class="hours-day"><?php echo e($day); ?></span>
                            <span class="hours-time"><?php echo e($time); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <?php elseif(\App\Models\Setting::get('opening_hours_text', '')): ?>
                    <div class="panel-hours">
                        <div class="panel-hours-title">Opening Hours</div>
                        <p style="font-size:.85rem;color:rgba(0,0,0,.55);line-height:1.6;">
                            <?php echo e(\App\Models\Setting::get('opening_hours_text')); ?>

                        </p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>
            </div>
        </div>

        
        <div style="border-top:1px solid rgba(0,0,0,.08); background:#fff; padding:2rem 0 0;">
            <div class="dish-body">

                
                <div style="display:flex;flex-direction:column;gap:2.25rem;">

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description && $product->description !== $product->short_description): ?>
                    <div>
                        <h2 class="dish-section-title">About This Dish</h2>
                        <div class="dish-desc"><?php echo $product->description; ?></div>
                    </div>
                    <?php elseif($product->short_description): ?>
                    <div>
                        <h2 class="dish-section-title">About This Dish</h2>
                        <p class="dish-desc"><?php echo e($product->short_description); ?></p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($product->attributes) && count($product->attributes)): ?>
                    <div>
                        <h2 class="dish-section-title">Details</h2>
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $product->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="dish-attr">
                                <span class="dish-attr-key"><?php echo e($key); ?></span>
                                <span class="dish-attr-val"><?php echo e($val); ?></span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div id="reviews">
                        <h2 class="dish-section-title">Customer Reviews</h2>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->review_count > 0): ?>
                        <div style="display:flex;align-items:center;gap:1rem;padding:1rem;border-radius:.75rem;background:rgba(212,160,23,.06);border:1px solid rgba(212,160,23,.18);margin-bottom:1.5rem;">
                            <span style="font-size:2.8rem;font-weight:900;color:#D4A017;line-height:1;"><?php echo e(number_format($product->rating, 1)); ?></span>
                            <div>
                                <div style="display:flex;gap:3px;margin-bottom:.3rem;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <svg style="width:17px;height:17px;fill:<?php echo e($i <= round($product->rating) ? '#D4A017' : 'rgba(0,0,0,.12)'); ?>;" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                <span style="font-size:.8rem;color:rgba(0,0,0,.45);">Based on <?php echo e(number_format($product->review_count)); ?> <?php echo e(Str::plural('review', $product->review_count)); ?></span>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $displayReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="review-card">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem;">
                                <span class="review-name"><?php echo e($review->reviewer_name); ?></span>
                                <span class="review-date"><?php echo e($review->created_at->format('d M Y')); ?></span>
                            </div>
                            <div style="display:flex;align-items:center;gap:2px;margin-bottom:.4rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <svg style="width:12px;height:12px;fill:<?php echo e($i <= $review->rating ? '#D4A017' : 'rgba(0,0,0,.12)'); ?>;" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->title): ?>
                                    <span style="font-size:.83rem;font-weight:600;color:rgba(0,0,0,.65);margin-left:.3rem;"><?php echo e($review->title); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <p class="review-text"><?php echo e($review->content); ?></p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p style="font-size:.9rem;color:rgba(0,0,0,.38);margin-bottom:1.25rem;">No reviews yet — be the first!</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div style="margin-top:1.25rem;" x-data="{ open: false }">
                            <button @click="open = !open" class="btn-outline" style="width:auto;padding:.55rem 1.25rem;font-size:.85rem;">
                                ✍ Write a Review
                            </button>
                            <form x-show="open" x-cloak
                                  x-transition:enter="transition ease-out duration-200"
                                  x-transition:enter-start="opacity-0 -translate-y-1"
                                  x-transition:enter-end="opacity-100 translate-y-0"
                                  method="POST"
                                  action="<?php echo e(route('product.guest-review', $product)); ?>"
                                  style="margin-top:1.1rem;padding:1.25rem;border-radius:.85rem;background:#f5f3f0;border:1px solid rgba(0,0,0,.09);">
                                <?php echo csrf_field(); ?>
                                <input type="text" name="honeypot" class="hidden" value="" tabindex="-1" autocomplete="off">
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                                    <div>
                                        <label class="r-label">Your Name</label>
                                        <input type="text" name="guest_name" required class="r-input" placeholder="e.g. James T.">
                                    </div>
                                    <div>
                                        <label class="r-label">Email Address</label>
                                        <input type="email" name="guest_email" required class="r-input" placeholder="your@email.com">
                                    </div>
                                </div>
                                <div style="margin-bottom:1rem;">
                                    <label class="r-label">Rating</label>
                                    <div x-data="{ rating:0, hover:0 }" style="display:flex;gap:.4rem;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button" @click="rating = <?php echo e($i); ?>" @mouseenter="hover = <?php echo e($i); ?>" @mouseleave="hover = 0">
                                            <svg style="width:30px;height:30px;cursor:pointer;transition:fill .1s;"
                                                 :style="(hover||rating) >= <?php echo e($i); ?> ? 'fill:#D4A017' : 'fill:rgba(0,0,0,.12)'"
                                                 viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <input type="hidden" name="rating" :value="rating">
                                    </div>
                                </div>
                                <div style="margin-bottom:1rem;">
                                    <label class="r-label">Your Review</label>
                                    <textarea name="content" required rows="4" minlength="20"
                                              class="r-input" style="resize:none;"
                                              placeholder="Tell us what you thought of this dish..."></textarea>
                                </div>
                                <button type="submit" class="btn-add" style="width:auto;padding:.65rem 1.5rem;">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedProducts->count()): ?>
                <div>
                    <h2 class="dish-section-title">More from <?php echo e($product->category?->name ?? 'the Menu'); ?></h2>
                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedProducts->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $relRawImg = $rel->primary_image_url;
                            $relImg = ($relRawImg && !str_ends_with(strtolower($relRawImg), '.svg'))
                                ? $relRawImg
                                : asset('images/products/product-' . (($rel->id % 27) + 1) . '.jpg');
                            $relFallback = asset('images/products/product-' . (($rel->id % 27) + 1) . '.jpg');
                        ?>
                        <div class="rel-item">
                            <a href="<?php echo e(route('products.show', $rel)); ?>" style="display:contents;text-decoration:none;color:inherit;">
                                <div class="rel-thumb">
                                    <img src="<?php echo e($relImg); ?>"
                                         onerror="this.onerror=null;this.src='<?php echo e($relFallback); ?>';"
                                         alt="<?php echo e($rel->name); ?>" loading="lazy"
                                         style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div style="flex:1;min-width:0;">
                                    <div class="rel-name"><?php echo e($rel->name); ?></div>
                                    <div class="rel-price"><?php echo format_price($rel->price); ?></div>
                                </div>
                            </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rel->stock_quantity > 0): ?>
                            <button class="rel-add-btn"
                                    onclick="Alpine.store('toppingsModal').open(<?php echo e($rel->id); ?>, 1)">
                                +
                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->stock_quantity > 0): ?>
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
                <div class="mbb-name"><?php echo e($product->name); ?></div>
                <div class="mbb-price"><?php echo format_price($product->price); ?></div>
            </div>
            <div class="mbb-qty">
                <button type="button" class="mbb-qty-btn" @click="qty > 1 ? qty-- : null">-</button>
                <span class="mbb-qty-val" x-text="qty"></span>
                <button type="button" class="mbb-qty-btn" @click="qty < 20 ? qty++ : null">+</button>
            </div>
            <button class="mbb-add-btn"
                    @click="$store.toppingsModal.open(<?php echo e($product->id); ?>, qty)">
                <span x-text="'Add £' + (<?php echo e((float) $product->price); ?> * qty).toFixed(2)"></span>
            </button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.ga4.measurement_id') || config('services.facebook.pixel_id')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if(config('services.ga4.measurement_id')): ?>
            if (typeof gtag !== 'undefined') {
                gtag('event', 'view_item', {
                    currency: 'GBP',
                    value: <?php echo e((float) $product->price); ?>,
                    items: [{ item_id: '<?php echo e($product->sku ?? $product->id); ?>', item_name: <?php echo json_encode($product->name, 15, 512) ?>, item_category: <?php echo json_encode($product->category?->name ?? '', 15, 512) ?>, price: <?php echo e((float) $product->price); ?>, quantity: 1 }]
                });
            }
            <?php endif; ?>
            <?php if(config('services.facebook.pixel_id')): ?>
            if (typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', { content_name: <?php echo json_encode($product->name, 15, 512) ?>, content_category: <?php echo json_encode($product->category?->name ?? '', 15, 512) ?>, content_ids: ['<?php echo e($product->id); ?>'], content_type: 'product', value: <?php echo e((float) $product->price); ?>, currency: 'GBP' }<?php if(!empty($fbEventId)): ?>, { eventID: '<?php echo e($fbEventId); ?>' }<?php endif; ?>);
            }
            <?php endif; ?>
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/products/show.blade.php ENDPATH**/ ?>