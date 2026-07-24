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

     <?php $__env->slot('title', null, []); ?> Checkout — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?> <?php $__env->endSlot(); ?>

    <?php $__env->startPush('meta'); ?>
        <meta name="description" content="Secure checkout at <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>.">
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="Checkout — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>">
        <meta property="og:description" content="Complete your order securely.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(route('checkout.index')); ?>">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Checkout — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>">

        <?php
        $checkoutSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Checkout',
            'description' => 'Secure checkout at ' . \App\Models\Setting::get('site_name', config('app.name')),
            'url' => route('checkout.index'),
            'breadcrumb' => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Cart', 'item' => route('cart.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => 'Checkout'],
                ],
            ],
            'potentialAction' => [
                '@type' => 'OrderAction',
                'target' => route('checkout.process'),
            ],
        ];
        ?>
        <script type="application/ld+json"><?php echo json_encode($checkoutSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
        <style>
            .iti { width: 100%; }
            .iti__tel-input { width: 100% !important; }
        </style>
    <?php $__env->stopPush(); ?>

     <?php $__env->slot('styles', null, []); ?> 
    <style>
        /* ─── Base ─── */
        .ck-page { background:#fafaf8; color:#111111; min-height:70vh; }

        /* ─── Header ─── */
        .ck-header {
            background:#fff; border-bottom:1px solid rgba(0,0,0,.08);
            padding:1rem 1.25rem;
        }
        .ck-bc {
            display:flex; flex-wrap:wrap; align-items:center; gap:.3rem .45rem;
            font-size:.78rem; color:rgba(0,0,0,.38); margin-bottom:.5rem;
            max-width:1100px; margin-left:auto; margin-right:auto;
        }
        .ck-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .ck-bc a:hover { color:#C8102E; }
        .ck-bc-sep { opacity:.4; }
        .ck-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:clamp(1.4rem,3.5vw,1.8rem);
            text-transform:uppercase; letter-spacing:.03em; color:#111111;
            line-height:1.1; max-width:1100px; margin:0 auto;
            display:flex; align-items:center; gap:.5rem;
        }
        .ck-user { font-size:.75rem; color:rgba(0,0,0,.45); font-weight:400; text-transform:none; letter-spacing:0; }

        /* ─── Grid ─── */
        .ck-grid {
            max-width:1100px; margin:0 auto;
            padding:1.5rem 1rem 3rem;
        }
        @media(min-width:1024px) {
            .ck-grid { display:flex; align-items:flex-start; gap:1.5rem; }
            .ck-left { flex:1; min-width:0; }
            .ck-right { width:360px; flex-shrink:0; position:sticky; top:1rem; }
        }

        /* ─── Section cards ─── */
        .ck-card {
            background:#fff; border-radius:.75rem;
            border:1px solid rgba(0,0,0,.08);
            margin-bottom:1rem;
            box-shadow:0 1px 4px rgba(0,0,0,.04);
        }
        .ck-card-head {
            display:flex; align-items:center; gap:.5rem;
            padding:.75rem 1rem;
            border-bottom:1px solid rgba(0,0,0,.06);
            background:rgba(0,0,0,.015); border-radius:.75rem .75rem 0 0;
        }
        .ck-step {
            width:1.5rem; height:1.5rem; border-radius:50%;
            background:#C8102E; color:#fff;
            font-size:.65rem; font-weight:800;
            display:flex; align-items:center; justify-content:center;
        }
        .ck-card-label {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:700; font-size:.85rem;
            text-transform:uppercase; letter-spacing:.05em; color:#111111;
        }
        .ck-card-body { padding:1rem; }

        /* ─── Inputs ─── */
        .ck-label {
            display:block; font-size:.7rem; font-weight:600;
            color:rgba(0,0,0,.5); margin-bottom:.25rem; text-transform:uppercase; letter-spacing:.04em;
        }
        .ck-input {
            width:100%; font-size:.85rem; color:#111111;
            border:1px solid rgba(0,0,0,.12); border-radius:.5rem;
            padding:.55rem .75rem; background:#fff;
            transition:border-color .15s, box-shadow .15s;
        }
        .ck-input:focus { border-color:#C8102E; outline:none; box-shadow:0 0 0 3px rgba(200,16,46,.1); }
        .ck-input::placeholder { color:rgba(0,0,0,.3); }
        .ck-error { font-size:.7rem; color:#C8102E; margin-top:.2rem; }

        /* ─── Address card ─── */
        .ck-addr {
            display:flex; align-items:flex-start; gap:.65rem;
            padding:.65rem .75rem; border:1px solid rgba(0,0,0,.1);
            border-radius:.5rem; cursor:pointer; transition:all .15s;
        }
        .ck-addr:hover { border-color:rgba(200,16,46,.3); }
        .ck-addr.active { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-addr input[type="radio"] { accent-color:#C8102E; margin-top:.15rem; }
        .ck-addr-name { font-size:.8rem; font-weight:600; color:#111111; }
        .ck-addr-default {
            font-size:.6rem; font-weight:700; color:#C8102E;
            background:rgba(200,16,46,.08); padding:.1rem .4rem;
            border-radius:99px; text-transform:uppercase; letter-spacing:.04em;
        }
        .ck-addr-detail { font-size:.75rem; color:rgba(0,0,0,.55); line-height:1.4; }

        /* ─── Payment options ─── */
        .ck-pay-opt {
            border:1px solid rgba(0,0,0,.1); border-radius:.5rem;
            cursor:pointer; transition:all .15s; overflow:hidden;
        }
        .ck-pay-opt:hover { border-color:rgba(200,16,46,.3); }
        .ck-pay-opt.active { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-pay-opt input[type="radio"] { accent-color:#C8102E; }
        .ck-pay-row {
            display:flex; align-items:center; gap:.65rem;
            padding:.65rem .75rem;
        }
        .ck-pay-icon {
            width:2rem; height:2rem; border-radius:.4rem;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .ck-pay-name { font-size:.82rem; font-weight:600; color:#111111; }
        .ck-pay-desc { font-size:.72rem; color:rgba(0,0,0,.45); }

        /* ─── Order summary (right) ─── */
        .ck-summary {
            background:#fff; border-radius:.75rem;
            border:1px solid rgba(0,0,0,.08);
            box-shadow:0 2px 10px rgba(0,0,0,.05);
            overflow:hidden;
        }
        .ck-summary-head {
            padding:.75rem 1rem;
            border-bottom:1px solid rgba(0,0,0,.06);
            font-family:'Barlow Condensed',sans-serif;
            font-weight:700; font-size:.9rem;
            text-transform:uppercase; letter-spacing:.04em; color:#111111;
        }

        /* ─── Item rows ─── */
        .ck-item {
            display:flex; gap:.65rem; padding:.6rem 0;
            border-bottom:1px solid rgba(0,0,0,.05);
        }
        .ck-item:last-child { border-bottom:0; }
        .ck-item-img {
            width:52px; height:52px; border-radius:.4rem;
            overflow:hidden; flex-shrink:0; background:#f5f2ef;
        }
        .ck-item-img img { width:100%; height:100%; object-fit:cover; }
        .ck-item-name { font-size:.78rem; font-weight:600; color:#111111; line-height:1.3; }
        .ck-item-qty {
            display:inline-flex; align-items:center; gap:.35rem;
            margin-top:.25rem;
        }
        .ck-qty-btn {
            width:1.35rem; height:1.35rem; border-radius:.25rem;
            background:rgba(0,0,0,.05); border:1px solid rgba(0,0,0,.1);
            display:flex; align-items:center; justify-content:center;
            font-size:.7rem; color:#111111; cursor:pointer; transition:all .15s;
        }
        .ck-qty-btn:hover { background:rgba(200,16,46,.08); border-color:rgba(200,16,46,.2); }
        .ck-qty-num { font-size:.75rem; font-weight:700; color:#111111; min-width:1.2rem; text-align:center; }
        .ck-item-remove {
            font-size:.65rem; color:#C8102E; cursor:pointer;
            margin-left:.5rem; text-decoration:none; font-weight:600;
        }
        .ck-item-remove:hover { text-decoration:underline; }
        .ck-item-price { font-size:.78rem; font-weight:700; color:#111111; white-space:nowrap; }

        /* ─── Coupon ─── */
        .ck-coupon-scroll {
            display:flex; gap:.5rem; overflow-x:auto;
            padding-bottom:.35rem; -webkit-overflow-scrolling:touch;
        }
        .ck-coupon-card {
            flex-shrink:0; width:10.5rem;
            border:1px dashed rgba(0,0,0,.15); border-radius:.5rem;
            padding:.55rem .65rem; transition:all .15s;
        }
        .ck-coupon-card.applied { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-coupon-code {
            font-size:.65rem; font-weight:800; color:#C8102E;
            background:rgba(200,16,46,.08); padding:.1rem .45rem;
            border-radius:.25rem; font-family:monospace; letter-spacing:.03em;
        }
        .ck-coupon-desc { font-size:.68rem; color:rgba(0,0,0,.5); line-height:1.35; margin:.3rem 0; }
        .ck-coupon-btn {
            width:100%; font-size:.68rem; font-weight:700;
            border:1px solid #C8102E; color:#C8102E;
            border-radius:.3rem; padding:.3rem 0; cursor:pointer;
            background:transparent; transition:all .15s;
        }
        .ck-coupon-btn:hover { background:#C8102E; color:#fff; }
        .ck-coupon-rm {
            width:100%; font-size:.68rem; font-weight:600;
            border:1px solid rgba(200,16,46,.25); color:#C8102E;
            border-radius:.3rem; padding:.3rem 0; cursor:pointer;
            background:transparent; transition:all .15s;
        }
        .ck-coupon-rm:hover { background:rgba(200,16,46,.06); }

        /* ─── Price rows ─── */
        .ck-prices { padding:1rem; }
        .ck-price-row {
            display:flex; align-items:center; justify-content:space-between;
            font-size:.78rem; padding:.25rem 0;
        }
        .ck-price-label { color:rgba(0,0,0,.5); }
        .ck-price-val { font-weight:600; color:#111111; }
        .ck-price-green { color:#2E7D32; font-weight:600; }
        .ck-price-red { color:#C8102E; font-weight:600; }
        .ck-price-divider {
            border:0; border-top:1px dashed rgba(0,0,0,.1);
            margin:.5rem 0;
        }
        .ck-total-row {
            display:flex; align-items:center; justify-content:space-between;
            padding:.35rem 0;
        }
        .ck-total-label {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1rem; text-transform:uppercase;
            letter-spacing:.03em; color:#111111;
        }
        .ck-total-val {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:1.15rem; color:#C8102E;
        }

        /* ─── Place order button ─── */
        .ck-submit-btn {
            display:block; width:100%;
            padding:.85rem 1rem;
            background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:.95rem;
            text-transform:uppercase; letter-spacing:.06em;
            border:0; border-radius:.5rem; cursor:pointer;
            transition:background .15s, transform .1s;
            box-shadow:0 2px 8px rgba(200,16,46,.25);
        }
        .ck-submit-btn:hover { background:#a00d24; }
        .ck-submit-btn:active { transform:scale(.98); }
        .ck-submit-btn:disabled { opacity:.5; cursor:not-allowed; }

        /* ─── Trust badges ─── */
        .ck-trust {
            display:flex; align-items:center; justify-content:center;
            gap:1.25rem; padding:.75rem 1rem;
            border-top:1px solid rgba(0,0,0,.06);
        }
        .ck-trust-item {
            display:flex; align-items:center; gap:.3rem;
            font-size:.65rem; font-weight:600; color:rgba(0,0,0,.4);
            text-transform:uppercase; letter-spacing:.03em;
        }
        .ck-trust-item svg { width:.9rem; height:.9rem; }

        /* ─── Misc ─── */
        .ck-link { color:#C8102E; text-decoration:none; font-weight:600; }
        .ck-link:hover { text-decoration:underline; }
        .ck-text-muted { color:rgba(0,0,0,.4); }
        .ck-saved-banner {
            background:rgba(46,125,50,.08); border-radius:.4rem;
            padding:.5rem .75rem; text-align:center;
            font-size:.75rem; font-weight:600; color:#2E7D32;
        }
        .ck-ship-nudge {
            border-radius:.5rem; padding:.6rem .85rem; margin-bottom:1rem;
        }
        .ck-ship-bar {
            height:5px; border-radius:99px; overflow:hidden; margin-top:.4rem;
        }

        /* ─── Express checkout ─── */
        .ck-express {
            background:linear-gradient(135deg,#111111,#2a1f1b);
            border-radius:.75rem; padding:.85rem 1rem;
            color:#fff; margin-bottom:1rem;
            display:flex; align-items:center; justify-content:space-between; gap:.75rem;
        }
        .ck-express-label { font-size:.72rem; font-weight:700; }
        .ck-express-detail { font-size:.65rem; opacity:.7; margin-top:.15rem; }
        .ck-express-btn {
            padding:.5rem 1.25rem;
            background:#C8102E; color:#fff;
            font-weight:800; font-size:.75rem;
            border:0; border-radius:.4rem; cursor:pointer;
            text-transform:uppercase; letter-spacing:.04em;
            white-space:nowrap; transition:background .15s;
        }
        .ck-express-btn:hover { background:#a00d24; }
        .ck-express-btn:disabled { opacity:.5; }

        /* ─── GPS Location Button ─── */
        .ck-gps-btn {
            display:flex; align-items:center; gap:.5rem;
            width:100%; padding:.7rem .85rem;
            background:linear-gradient(135deg,rgba(200,16,46,.06),rgba(200,16,46,.03));
            border:1.5px dashed rgba(200,16,46,.3);
            border-radius:.6rem; cursor:pointer;
            transition:all .2s; margin-bottom:.75rem;
        }
        .ck-gps-btn:hover { background:rgba(200,16,46,.08); border-color:rgba(200,16,46,.5); }
        .ck-gps-btn:disabled { opacity:.5; cursor:wait; }
        .ck-gps-icon {
            width:2.2rem; height:2.2rem; border-radius:50%;
            background:#C8102E; color:#fff;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; box-shadow:0 2px 8px rgba(200,16,46,.25);
        }
        .ck-gps-icon svg { width:1.1rem; height:1.1rem; }
        .ck-gps-icon.locating { animation:ck-pulse 1.2s ease-in-out infinite; }
        @keyframes ck-pulse {
            0%,100% { box-shadow:0 0 0 0 rgba(200,16,46,.4); }
            50% { box-shadow:0 0 0 10px rgba(200,16,46,0); }
        }
        .ck-gps-text { font-size:.82rem; font-weight:700; color:#C8102E; }
        .ck-gps-sub { font-size:.68rem; color:rgba(0,0,0,.4); font-weight:400; margin-top:.1rem; }
        .ck-gps-status {
            font-size:.72rem; padding:.4rem .65rem;
            border-radius:.4rem; margin-bottom:.65rem;
            display:flex; align-items:center; gap:.35rem;
        }
        .ck-gps-status.success { background:rgba(46,125,50,.08); color:#2E7D32; }
        .ck-gps-status.error { background:rgba(200,16,46,.06); color:#C8102E; }

        /* ─── Mini map preview ─── */
        .ck-map-preview {
            width:100%; height:120px; border-radius:.5rem;
            overflow:hidden; margin-bottom:.75rem;
            border:1px solid rgba(0,0,0,.08);
            background:#f0ece8; position:relative;
        }
        .ck-map-preview img { width:100%; height:100%; object-fit:cover; }
        .ck-map-pin {
            position:absolute; top:50%; left:50%;
            transform:translate(-50%,-100%);
            font-size:1.5rem; filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));
        }

        /* ─── Add address form ─── */
        .ck-new-addr {
            background:rgba(0,0,0,.02); border:1px solid rgba(0,0,0,.08);
            border-radius:.5rem; padding:.85rem; margin-top:.65rem;
        }
        .ck-new-addr-title { font-size:.8rem; font-weight:700; color:#111111; margin-bottom:.6rem; }

        /* ─── Mobile bottom bar ─── */
        @media(max-width:1023px) {
            .ck-right { margin-top:1rem; }
        }
    </style>
     <?php $__env->endSlot(); ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($fbEventId) && config('services.facebook.pixel_id')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof fbq !== 'undefined') {
                fbq('track', 'InitiateCheckout', {
                    content_ids: <?php echo json_encode($cart->items->pluck('product_id')->map('strval')->values()->toArray()); ?>,
                    content_type: 'product',
                    value: <?php echo e((float) ($cart->subtotal - $cart->discount)); ?>,
                    currency: 'GBP',
                    num_items: <?php echo e($cart->items->sum('quantity')); ?>

                }, {eventID: '<?php echo e($fbEventId); ?>'});
            }
        });
    </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="ck-page">
        
        <div class="ck-header">
            <nav class="ck-bc">
                <a href="<?php echo e(url('/')); ?>">Home</a>
                <span class="ck-bc-sep">/</span>
                <a href="<?php echo e(route('cart.index')); ?>">Cart</a>
                <span class="ck-bc-sep">/</span>
                <span style="color:rgba(0,0,0,.6);">Checkout</span>
            </nav>
            <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;">
                <h1 class="ck-title">
                    <a href="<?php echo e(route('cart.index')); ?>" style="color:#111111;text-decoration:none;display:flex;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    Checkout
                </h1>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <span class="ck-user"><?php echo e(auth()->user()->name); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="ck-link" style="font-size:.72rem;background:none;border:0;cursor:pointer;">Logout</button>
                    </form>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($oneClickReady) && $defaultAddress): ?>
        <div style="max-width:1100px;margin:0 auto;padding:1rem 1rem 0;" x-data="{ expressLoading: false }">
            <div class="ck-express">
                <div style="min-width:0;">
                    <p class="ck-express-label">Express Checkout</p>
                    <p class="ck-express-detail">Deliver to <?php echo e($defaultAddress->name); ?> — <?php echo e($defaultAddress->city); ?>, <?php echo e($defaultAddress->postal_code); ?></p>
                </div>
                <form action="<?php echo e(route('checkout.process')); ?>" method="POST" @submit="expressLoading = true">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="shipping_address_id" value="<?php echo e($defaultAddress->id); ?>">
                    <input type="hidden" name="same_billing_address" value="1">
                    <input type="hidden" name="payment_method" value="<?php echo e($checkoutPreference->default_payment_method ?? 'cod'); ?>">
                    <input type="hidden" name="express_checkout" value="1">
                    <button type="submit" :disabled="expressLoading" class="ck-express-btn">
                        <span x-show="!expressLoading">Place Order</span>
                        <span x-show="expressLoading">Processing...</span>
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php
            $methodOrder = ['razorpay' => 'razorpay_enabled', 'cod' => 'cod_enabled'];
            $firstMethod = 'cod';
            foreach ($methodOrder as $method => $key) {
                if (($paymentSettings[$key] ?? '1') === '1') { $firstMethod = $method; break; }
            }
        ?>

        <form action="<?php echo e(route('checkout.process')); ?>" method="POST"
              x-data="checkoutForm('<?php echo e($firstMethod); ?>')"
              @submit.prevent="handleSubmit($event)">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="delivery_method" :value="deliveryMethod">

            <div class="ck-grid">
                
                <div class="ck-left">

                    
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">
                                <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/></svg>
                            </div>
                            <span class="ck-card-label">How would you like your order?</span>
                        </div>
                        <div class="ck-card-body">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                                <label style="display:flex;align-items:center;gap:.75rem;padding:.85rem 1rem;border-radius:.5rem;cursor:pointer;transition:all .15s;"
                                       :style="deliveryMethod === 'collection' ? 'border:2px solid #C8102E;background:rgba(200,16,46,.04)' : 'border:2px solid rgba(0,0,0,.1);background:#fff'"
                                       @click="deliveryMethod = 'collection'">
                                    <div style="width:2.5rem;height:2.5rem;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .15s;"
                                         :style="deliveryMethod === 'collection' ? 'background:rgba(200,16,46,.1);color:#C8102E' : 'background:rgba(0,0,0,.05);color:rgba(0,0,0,.35)'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </div>
                                    <div>
                                        <span style="font-size:.82rem;font-weight:700;display:block;" :style="deliveryMethod === 'collection' ? 'color:#C8102E' : 'color:#111'">Collection</span>
                                        <span style="font-size:.65rem;color:rgba(0,0,0,.4);line-height:1.3;">Pick up from store</span>
                                    </div>
                                </label>
                                <label style="display:flex;align-items:center;gap:.75rem;padding:.85rem 1rem;border-radius:.5rem;cursor:pointer;transition:all .15s;"
                                       :style="deliveryMethod === 'delivery' ? 'border:2px solid #C8102E;background:rgba(200,16,46,.04)' : 'border:2px solid rgba(0,0,0,.1);background:#fff'"
                                       @click="deliveryMethod = 'delivery'">
                                    <div style="width:2.5rem;height:2.5rem;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .15s;"
                                         :style="deliveryMethod === 'delivery' ? 'background:rgba(200,16,46,.1);color:#C8102E' : 'background:rgba(0,0,0,.05);color:rgba(0,0,0,.35)'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                    </div>
                                    <div>
                                        <span style="font-size:.82rem;font-weight:700;display:block;" :style="deliveryMethod === 'delivery' ? 'color:#C8102E' : 'color:#111'">Delivery</span>
                                        <span style="font-size:.65rem;color:rgba(0,0,0,.4);line-height:1.3;">Within 3 miles &middot; £5.00</span>
                                    </div>
                                </label>
                            </div>
                            <template x-if="deliveryMethod === 'collection'">
                                <div style="margin-top:.75rem;padding:.6rem .75rem;background:rgba(46,125,50,.06);border:1px solid rgba(46,125,50,.15);border-radius:.4rem;">
                                    <p style="font-size:.75rem;font-weight:600;color:#2E7D32;margin:0;">
                                        <svg style="width:.75rem;height:.75rem;display:inline;vertical-align:-1px;margin-right:.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Collect from: <?php echo e(\App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP')); ?>

                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">1</div>
                            <span class="ck-card-label">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isGuest): ?> Contact & Delivery <?php else: ?> Delivery Address <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </div>
                        <div class="ck-card-body">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isGuest): ?>
                            
                            <p style="font-size:.75rem;color:rgba(0,0,0,.45);margin-bottom:.75rem;">
                                Have an account? <a href="<?php echo e(route('login')); ?>" class="ck-link">Log in</a> for faster checkout.
                            </p>

                            <div style="display:flex;flex-direction:column;gap:.65rem;margin-bottom:.75rem;">
                                <div>
                                    <label class="ck-label">Phone *</label>
                                    <input type="tel" name="guest_phone" id="guest_phone" value="<?php echo e(old('guest_phone')); ?>" required autocomplete="tel" autofocus
                                           class="ck-input" placeholder="+44 7700 900000"
                                           @input="captureAbandoned(false)" @blur="captureAbandoned(true)">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['guest_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem;">
                                    <div>
                                        <label class="ck-label">Name *</label>
                                        <input type="text" name="guest_name" value="<?php echo e(old('guest_name')); ?>" required autocomplete="name"
                                               class="ck-input" placeholder="Full name"
                                               @input="captureAbandoned(false)" @blur="captureAbandoned(true)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['guest_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="ck-label">Email *</label>
                                        <input type="email" name="guest_email" value="<?php echo e(old('guest_email')); ?>" required autocomplete="email"
                                               class="ck-input" placeholder="email@example.com"
                                               @input="captureAbandoned(false)" @blur="captureAbandoned(true)">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <hr style="border:0;border-top:1px dashed rgba(0,0,0,.1);margin:.75rem 0;">

                            
                            <div style="display:flex;flex-direction:column;gap:.65rem;" x-data="addressGPS()">

                                
                                <button type="button" class="ck-gps-btn" @click="detectLocation()" :disabled="gpsLoading">
                                    <div class="ck-gps-icon" :class="gpsLoading ? 'locating' : ''">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!gpsLoading">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <svg x-show="gpsLoading" x-cloak class="animate-spin" style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="ck-gps-text" x-text="gpsLoading ? 'Detecting your location...' : 'Use My Current Location'"></p>
                                        <p class="ck-gps-sub" x-text="gpsLoading ? 'This may take a few seconds' : 'Auto-fill address using GPS'"></p>
                                    </div>
                                </button>

                                
                                <div x-show="gpsStatus" x-cloak class="ck-gps-status" :class="gpsSuccess ? 'success' : 'error'">
                                    <svg style="width:.8rem;height:.8rem;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <template x-if="gpsSuccess">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </template>
                                        <template x-if="!gpsSuccess">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </template>
                                    </svg>
                                    <span x-text="gpsStatus"></span>
                                </div>

                                
                                <div x-show="gpsLat && gpsLng" x-cloak class="ck-map-preview">
                                    <img :src="'https://maps.geoapify.com/v1/staticmap?style=osm-bright&width=600&height=200&center=lonlat:' + gpsLng + ',' + gpsLat + '&zoom=16&apiKey=0620a370bbfb4c20b23e88c8c1c1e090'" alt="Your location">
                                    <div class="ck-map-pin">📍</div>
                                </div>
                                <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:.65rem;">
                                    <div>
                                        <label class="ck-label">Postcode *</label>
                                        <input type="text" name="shipping_postal_code" x-model="pin" @input="fetchPinData()" value="<?php echo e(old('shipping_postal_code')); ?>" required maxlength="8" autocomplete="postal-code"
                                               class="ck-input" placeholder="E1 6AN">
                                        <p x-show="pinError" x-text="pinError" class="ck-error" x-cloak></p>
                                        <p x-show="pinServiceable === true" style="font-size:.68rem;color:#2E7D32;margin-top:.2rem;display:flex;align-items:center;gap:.2rem;" x-cloak>
                                            <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Delivery available
                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="ck-label">City *</label>
                                        <input type="text" name="shipping_city" x-model="city" value="<?php echo e(old('shipping_city')); ?>" required autocomplete="address-level2"
                                               class="ck-input" placeholder="London">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="ck-label">County</label>
                                        <input type="text" name="shipping_state" x-model="state" value="<?php echo e(old('shipping_state')); ?>" autocomplete="address-level1"
                                               class="ck-input" placeholder="County">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="ck-label">Recipient *</label>
                                        <input type="text" name="shipping_name" value="<?php echo e(old('shipping_name')); ?>" required autocomplete="shipping name"
                                               class="ck-input" placeholder="Recipient name">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <label class="ck-label">Address *</label>
                                    <input type="text" name="shipping_address_line_1" value="<?php echo e(old('shipping_address_line_1')); ?>" required autocomplete="address-line1"
                                           class="ck-input" placeholder="House no., Street">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_address_line_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="ck-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label class="ck-label">Address Line 2</label>
                                    <input type="text" name="shipping_address_line_2" value="<?php echo e(old('shipping_address_line_2')); ?>" autocomplete="address-line2"
                                           class="ck-input" placeholder="Flat, Floor, Landmark (optional)">
                                </div>
                            </div>
                            <input type="hidden" name="same_billing_address" value="1">

                            <?php else: ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($addresses->count()): ?>
                                <div style="display:flex;flex-direction:column;gap:.5rem;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <label class="ck-addr <?php echo e($address->id === $defaultAddress?->id ? 'active' : ''); ?>">
                                            <input type="radio" name="shipping_address_id" value="<?php echo e($address->id); ?>"
                                                   <?php echo e($address->id === $defaultAddress?->id ? 'checked' : ''); ?>>
                                            <div style="flex:1;min-width:0;">
                                                <div style="display:flex;align-items:center;gap:.4rem;">
                                                    <span class="ck-addr-name"><?php echo e($address->name); ?></span>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($address->is_default): ?>
                                                        <span class="ck-addr-default">Default</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <p class="ck-addr-detail">
                                                    <?php echo e($address->address_line_1); ?><?php echo e($address->address_line_2 ? ', ' . $address->address_line_2 : ''); ?>,
                                                    <?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->postal_code); ?>

                                                    &middot; <?php echo e($address->phone); ?>

                                                </p>
                                            </div>
                                        </label>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <button type="button" @click="showAddressForm = !showAddressForm"
                                        style="display:inline-flex;align-items:center;gap:.3rem;margin-top:.65rem;font-size:.75rem;font-weight:600;color:#C8102E;background:none;border:0;cursor:pointer;">
                                    <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span x-text="showAddressForm ? 'Cancel' : 'Add New Address'"></span>
                                </button>
                            <?php else: ?>
                                <div style="text-align:center;padding:1.5rem 0;" x-show="!showAddressForm">
                                    <p style="font-size:.8rem;color:rgba(0,0,0,.45);margin-bottom:.65rem;">No saved addresses found.</p>
                                    <button type="button" @click="showAddressForm = true"
                                            style="display:inline-flex;align-items:center;gap:.3rem;font-size:.78rem;font-weight:700;color:#fff;background:#C8102E;border:0;padding:.5rem 1rem;border-radius:.4rem;cursor:pointer;">
                                        <svg style="width:.85rem;height:.85rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Add Address
                                    </button>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div x-show="showAddressForm" x-collapse x-cloak class="ck-new-addr" x-data="addressGPSInline()">
                                <h3 class="ck-new-addr-title">New Address</h3>
                                <div style="display:flex;flex-direction:column;gap:.55rem;">

                                    
                                    <button type="button" class="ck-gps-btn" style="margin-bottom:.25rem;" @click="detectLocation()" :disabled="gpsLoading">
                                        <div class="ck-gps-icon" :class="gpsLoading ? 'locating' : ''">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!gpsLoading">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <svg x-show="gpsLoading" x-cloak class="animate-spin" style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="ck-gps-text" x-text="gpsLoading ? 'Detecting...' : 'Use My Location'"></p>
                                            <p class="ck-gps-sub">Auto-fill address using GPS</p>
                                        </div>
                                    </button>
                                    <div x-show="gpsStatus" x-cloak class="ck-gps-status" :class="gpsSuccess ? 'success' : 'error'" style="margin-bottom:.25rem;">
                                        <span x-text="gpsStatus"></span>
                                    </div>

                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.55rem;">
                                        <div>
                                            <label class="ck-label">Full Name *</label>
                                            <input type="text" id="new_addr_name" class="ck-input" placeholder="Full name">
                                        </div>
                                        <div>
                                            <label class="ck-label">Phone *</label>
                                            <input type="tel" id="new_addr_phone" class="ck-input" placeholder="+44 7700 900000">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="ck-label">Address *</label>
                                        <input type="text" id="new_addr_line1" class="ck-input" placeholder="House no., Street" x-model="line1">
                                    </div>
                                    <div>
                                        <label class="ck-label">Area / Landmark</label>
                                        <input type="text" id="new_addr_line2" class="ck-input" placeholder="Optional" x-model="line2">
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.55rem;">
                                        <div>
                                            <label class="ck-label">Postcode *</label>
                                            <input type="text" id="new_addr_pincode" x-model="pin" @input="fetchPinData()" maxlength="8"
                                                   class="ck-input" placeholder="E1 6AN">
                                            <p x-show="pinError" x-text="pinError" class="ck-error" x-cloak></p>
                                        </div>
                                        <div>
                                            <label class="ck-label">City *</label>
                                            <input type="text" id="new_addr_city" x-model="city" class="ck-input" placeholder="London">
                                        </div>
                                        <div>
                                            <label class="ck-label">County</label>
                                            <input type="text" id="new_addr_state" x-model="state" class="ck-input" placeholder="County">
                                        </div>
                                    </div>
                                    <div id="new_addr_error" class="ck-error" style="display:none;"></div>
                                    <div style="display:flex;gap:.5rem;padding-top:.35rem;">
                                        <button type="button" :disabled="savingAddress"
                                                @click="
                                                    let name = document.getElementById('new_addr_name').value.trim();
                                                    let phone = document.getElementById('new_addr_phone').value.trim();
                                                    let line1 = document.getElementById('new_addr_line1').value.trim();
                                                    let line2 = document.getElementById('new_addr_line2').value.trim();
                                                    let pincode = pin;
                                                    let errEl = document.getElementById('new_addr_error');
                                                    if (!name || !phone || !line1 || !city || !state || !pincode) {
                                                        errEl.textContent = 'Please fill all required fields.';
                                                        errEl.style.display = 'block';
                                                        return;
                                                    }
                                                    errEl.style.display = 'none';
                                                    savingAddress = true;
                                                    fetch('<?php echo e(route('account.addresses.store')); ?>', {
                                                        method: 'POST',
                                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' },
                                                        body: JSON.stringify({ name, phone, address_line_1: line1, address_line_2: line2, city, state, postal_code: pincode })
                                                    }).then(r => r.json().then(d => ({ok: r.ok, data: d}))).then(({ok, data}) => {
                                                        savingAddress = false;
                                                        if (ok) { location.reload(); }
                                                        else {
                                                            let msg = data.message || Object.values(data.errors || {}).flat().join(', ') || 'Failed to save address';
                                                            errEl.textContent = msg;
                                                            errEl.style.display = 'block';
                                                        }
                                                    }).catch(() => { savingAddress = false; errEl.textContent = 'Something went wrong.'; errEl.style.display = 'block'; });
                                                "
                                                style="padding:.45rem 1rem;font-size:.78rem;font-weight:700;color:#fff;background:#C8102E;border:0;border-radius:.4rem;cursor:pointer;transition:background .15s;"
                                                onmouseover="this.style.background='#a00d24'" onmouseout="this.style.background='#C8102E'">
                                            <span x-show="!savingAddress">Save Address</span>
                                            <span x-show="savingAddress" style="display:inline-flex;align-items:center;gap:.3rem;">
                                                <svg style="width:.75rem;height:.75rem;" class="animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                                Saving...
                                            </span>
                                        </button>
                                        <button type="button" @click="showAddressForm = false"
                                                style="padding:.45rem 1rem;font-size:.78rem;font-weight:600;color:rgba(0,0,0,.5);border:1px solid rgba(0,0,0,.12);background:#fff;border-radius:.4rem;cursor:pointer;">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['shipping_address_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ck-error" style="margin-top:.35rem;"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isGuest): ?>
                    <div class="ck-card">
                        <div class="ck-card-body" style="padding:.75rem 1rem;">
                            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                                <input type="checkbox" name="same_billing_address" value="1" x-model="sameBilling"
                                       style="accent-color:#C8102E;width:.9rem;height:.9rem;">
                                <span style="font-size:.82rem;font-weight:600;color:#111111;">Billing same as delivery</span>
                            </label>

                            <div x-show="!sameBilling" x-collapse style="margin-top:.65rem;padding-top:.65rem;border-top:1px solid rgba(0,0,0,.08);">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($addresses->count()): ?>
                                    <div style="display:flex;flex-direction:column;gap:.4rem;">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <label class="ck-addr">
                                                <input type="radio" name="billing_address_id" value="<?php echo e($address->id); ?>">
                                                <div style="flex:1;min-width:0;">
                                                    <span class="ck-addr-name"><?php echo e($address->name); ?></span>
                                                    <p class="ck-addr-detail"><?php echo e($address->address_line_1); ?>, <?php echo e($address->city); ?>, <?php echo e($address->state); ?></p>
                                                </div>
                                            </label>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">2</div>
                            <span class="ck-card-label">Payment</span>
                        </div>
                        <div class="ck-card-body" style="display:flex;flex-direction:column;gap:.55rem;">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($paymentSettings['razorpay_enabled'] ?? '1') === '1'): ?>
                            <div @click="paymentMethod = 'razorpay'"
                                 :class="paymentMethod === 'razorpay' ? 'active' : ''"
                                 class="ck-pay-opt">
                                <div class="ck-pay-row">
                                    <input type="radio" name="payment_method" value="razorpay" x-model="paymentMethod">
                                    <div class="ck-pay-icon" style="background:rgba(0,0,0,.04);">
                                        <img src="<?php echo e(asset('images/razorpay.png')); ?>" alt="Razorpay" style="height:1.1rem;width:auto;">
                                    </div>
                                    <div>
                                        <p class="ck-pay-name">Pay Online</p>
                                        <p class="ck-pay-desc">Cards, UPI, Net Banking & more</p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($paymentSettings['cod_enabled'] ?? '1') === '1' && $cart->subtotal >= 199): ?>
                            <div @click="paymentMethod = 'cod'"
                                 :class="paymentMethod === 'cod' ? 'active' : ''"
                                 class="ck-pay-opt">
                                <div class="ck-pay-row">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod">
                                    <div class="ck-pay-icon"
                                         :style="paymentMethod === 'cod' ? 'background:rgba(200,16,46,.08);color:#C8102E;' : 'background:rgba(0,0,0,.04);color:rgba(0,0,0,.4);'">
                                        <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="ck-pay-name">Partial Pay</p>
                                        <p class="ck-pay-desc">Pay <?php echo e(currency_symbol()); ?><?php echo e(\App\Models\Setting::get('cod_advance_amount', 100)); ?> now, rest on delivery</p>
                                    </div>
                                </div>
                                <div x-show="paymentMethod === 'cod'" x-collapse>
                                    <div style="padding:0 .75rem .65rem;">
                                        <div style="display:flex;align-items:center;gap:.4rem;padding:.5rem .65rem;background:rgba(200,16,46,.04);border:1px solid rgba(200,16,46,.12);border-radius:.4rem;font-size:.72rem;color:#111111;">
                                            <svg style="width:.85rem;height:.85rem;color:#C8102E;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            <span>Pay <strong style="color:#C8102E;"><?php echo format_price(\App\Models\Setting::get('cod_advance_amount', 100)); ?></strong> advance to confirm. <strong><?php echo format_price($cart->total - \App\Models\Setting::get('cod_advance_amount', 100) > 0 ? $cart->total - \App\Models\Setting::get('cod_advance_amount', 100) : 0); ?></strong> on delivery.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="ck-error"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>


                    
                    <div class="ck-card">
                        <div class="ck-card-body">
                            <label class="ck-label">Order Notes (optional)</label>
                            <textarea name="notes" rows="2" class="ck-input" style="resize:none;"
                                      placeholder="Special delivery instructions..."><?php echo e(old('notes')); ?></textarea>
                        </div>
                    </div>
                </div>

                
                <div class="ck-right">
                    
                    <?php
                        $deliveryMinOrder = (float) \App\Models\Setting::get('delivery_min_order', 25);
                        $deliveryFee = (float) \App\Models\Setting::get('delivery_fee', 5);
                        $cartSubtotal = (float) $cart->subtotal;
                    ?>
                    <div x-show="deliveryMethod === 'delivery'" x-cloak>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cartSubtotal < $deliveryMinOrder): ?>
                            <div class="ck-ship-nudge" style="background:rgba(200,16,46,.06);border:1px solid rgba(200,16,46,.15);">
                                <p style="font-size:.78rem;color:#C8102E;font-weight:700;margin:0;">Add <?php echo format_price($deliveryMinOrder - $cartSubtotal); ?> more for delivery (min £<?php echo e(number_format($deliveryMinOrder, 2)); ?>)</p>
                                <div class="ck-ship-bar" style="background:rgba(200,16,46,.12);">
                                    <div style="background:#C8102E;height:100%;width:<?php echo e(min(100, ($cartSubtotal / $deliveryMinOrder) * 100)); ?>%;border-radius:99px;"></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="ck-ship-nudge" style="background:rgba(46,125,50,.08);border:1px solid rgba(46,125,50,.15);">
                                <p style="font-size:.78rem;color:#2E7D32;font-weight:700;margin:0;">&#10003; Delivery available &middot; £<?php echo e(number_format($deliveryFee, 2)); ?> fee</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div x-show="deliveryMethod === 'collection'">
                        <div class="ck-ship-nudge" style="background:rgba(46,125,50,.08);border:1px solid rgba(46,125,50,.15);">
                            <p style="font-size:.78rem;color:#2E7D32;font-weight:700;margin:0;">&#10003; Collection — no delivery fee</p>
                        </div>
                    </div>

                    <div class="ck-summary">
                        <div class="ck-summary-head">
                            Your Order
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableCoupons->count()): ?>
                        <div style="padding:.75rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);" x-data="{ applying: false }">
                            <div style="display:flex;align-items:center;gap:.35rem;margin-bottom:.5rem;">
                                <svg style="width:.85rem;height:.85rem;color:#D4A017;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#111111;">Coupons</span>
                            </div>
                            <div class="ck-coupon-scroll">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableCoupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="ck-coupon-card <?php echo e($cart->coupon_id === $coupon->id ? 'applied' : ''); ?>">
                                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.25rem;">
                                            <span class="ck-coupon-code"><?php echo e($coupon->code); ?></span>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->coupon_id === $coupon->id): ?>
                                                <span style="font-size:.6rem;font-weight:600;color:#2E7D32;background:rgba(46,125,50,.1);padding:.1rem .3rem;border-radius:.2rem;">Applied</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <p class="ck-coupon-desc" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?php echo e($coupon->name); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->coupon_id !== $coupon->id): ?>
                                            <button type="button" :disabled="applying" class="ck-coupon-btn"
                                                    @click="
                                                        applying = true;
                                                        fetch('<?php echo e(route('cart.apply-coupon')); ?>', {
                                                            method: 'POST',
                                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' },
                                                            body: JSON.stringify({ code: '<?php echo e($coupon->code); ?>' })
                                                        }).then(r => {
                                                            if (r.ok) { location.reload(); }
                                                            else { return r.json().then(d => { alert(d.error || 'Could not apply coupon'); applying = false; }); }
                                                        }).catch(() => { alert('Something went wrong'); applying = false; })
                                                    ">
                                                Apply
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="ck-coupon-rm"
                                                    @click="fetch('<?php echo e(route('cart.remove-coupon')); ?>', {
                                                        method: 'DELETE',
                                                        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' }
                                                    }).then(() => location.reload())">
                                                Remove
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->coupon): ?>
                            <div style="padding:.5rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);background:rgba(46,125,50,.04);">
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <div style="display:flex;align-items:center;gap:.35rem;">
                                        <span class="ck-coupon-code"><?php echo e($cart->coupon->code); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->coupon->auto_apply): ?>
                                            <span style="font-size:.58rem;color:#C8102E;background:rgba(200,16,46,.08);padding:.1rem .3rem;border-radius:.2rem;font-weight:600;">Auto</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span style="font-size:.7rem;color:#2E7D32;font-weight:600;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->coupon->type === 'percentage'): ?>
                                                <?php echo e(intval($cart->coupon->value)); ?>% off
                                            <?php elseif($cart->coupon->type === 'fixed'): ?>
                                                <?php echo format_price($cart->coupon->value); ?> off
                                            <?php elseif($cart->coupon->type === 'buy_x_get_y'): ?>
                                                Buy <?php echo e($cart->coupon->conditions['buy_qty'] ?? 0); ?> Get <?php echo e($cart->coupon->conditions['get_qty'] ?? 0); ?><?php echo e($cart->coupon->value >= 100 ? ' Free' : ''); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </span>
                                    </div>
                                    <span style="font-size:.82rem;font-weight:700;color:#2E7D32;">-<?php echo format_price($cart->discount); ?></span>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div style="padding:.5rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);">
                            <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(0,0,0,.4);margin-bottom:.35rem;">
                                <?php echo e($cart->items->sum('quantity')); ?> <?php echo e($cart->items->sum('quantity') === 1 ? 'Item' : 'Items'); ?>

                            </p>
                            <div style="max-height:14rem;overflow-y:auto;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $rawImg = $item->product->primary_image_url;
                                        $itemImg = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
                                            ? $rawImg
                                            : asset('images/products/product-' . (($item->product->id % 27) + 1) . '.jpg');
                                    ?>
                                    <div class="ck-item">
                                        <div class="ck-item-img">
                                            <img src="<?php echo e($itemImg); ?>" alt="<?php echo e($item->product->name); ?>">
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <p class="ck-item-name"><?php echo e($item->product->name); ?></p>
                                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                                <span class="ck-item-qty">
                                                    <button type="button" class="ck-qty-btn" onclick="fetch('/cart/<?php echo e($item->id); ?>',{method:'PUT',headers:{'Content-Type':'application/json','X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'},body:JSON.stringify({quantity:<?php echo e(max(1,$item->quantity-1)); ?>})}).then(()=>location.reload())">-</button>
                                                    <span class="ck-qty-num"><?php echo e($item->quantity); ?></span>
                                                    <button type="button" class="ck-qty-btn" onclick="fetch('/cart/<?php echo e($item->id); ?>',{method:'PUT',headers:{'Content-Type':'application/json','X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'},body:JSON.stringify({quantity:<?php echo e($item->quantity+1); ?>})}).then(()=>location.reload())">+</button>
                                                    <a href="#" class="ck-item-remove" onclick="event.preventDefault();if(confirm('Remove this item?'))fetch('/cart/<?php echo e($item->id); ?>',{method:'DELETE',headers:{'X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'}}).then(()=>location.reload())">Remove</a>
                                                </span>
                                                <span class="ck-item-price"><?php echo format_price($item->price * $item->quantity); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="ck-prices">
                            <div class="ck-price-row">
                                <span class="ck-price-label">Subtotal</span>
                                <span class="ck-price-val"><?php echo format_price($cart->subtotal); ?></span>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->discount > 0): ?>
                                <div class="ck-price-row">
                                    <span class="ck-price-label">Coupon Discount</span>
                                    <span class="ck-price-green">-<?php echo format_price($cart->discount); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                            <?php $shipFee = $deliveryFee; ?>
                            <div class="ck-price-row">
                                <span class="ck-price-label">Delivery</span>
                                <template x-if="deliveryMethod === 'delivery'">
                                    <span class="ck-price-val"><?php echo format_price($deliveryFee); ?></span>
                                </template>
                                <template x-if="deliveryMethod === 'collection'">
                                    <span class="ck-price-green">FREE (Collection)</span>
                                </template>
                            </div>
                            <p x-show="deliveryMethod === 'delivery'" x-cloak style="font-size:.65rem;color:rgba(0,0,0,.35);">Within 3 miles &middot; Mon–Sat 10am–4pm</p>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($loyaltyPoints) && $loyaltyPoints > 0): ?>
                                <div class="ck-price-row" style="padding-top:.35rem;border-top:1px dashed rgba(0,0,0,.08);"
                                     x-data="{ usePoints: false, pointsToUse: <?php echo e(min($loyaltyPoints, (int) ceil(($cart->subtotal - $cart->discount) / 0.25))); ?> }">
                                    <div style="display:flex;align-items:center;gap:.4rem;">
                                        <input type="checkbox" name="use_loyalty_points" value="1" x-model="usePoints"
                                               style="accent-color:#D4A017;width:.75rem;height:.75rem;">
                                        <span style="font-size:.75rem;font-weight:600;color:#B8860B;">Use <?php echo e(number_format($loyaltyPoints)); ?> points</span>
                                        <span style="font-size:.62rem;color:rgba(0,0,0,.35);">(worth <?php echo format_price($loyaltyValue); ?>)</span>
                                    </div>
                                    <template x-if="usePoints">
                                        <span style="font-size:.78rem;font-weight:600;color:#B8860B;">-<?php echo format_price($loyaltyValue); ?></span>
                                    </template>
                                    <input type="hidden" name="loyalty_points_used" :value="usePoints ? <?php echo e($loyaltyPoints); ?> : 0">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cart->tax > 0): ?>
                                <div class="ck-price-row">
                                    <span class="ck-price-label">Tax (incl.)</span>
                                    <span style="font-size:.7rem;color:#2E7D32;font-weight:500;">incl. <?php echo format_price($cart->tax); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <hr class="ck-price-divider">

                            <?php
                                $displayTotalDelivery = $cart->total + $deliveryFee;
                                $displayTotalCollection = $cart->total;
                                $totalSavings = $cart->discount;
                                if (isset($navratriActive) && $navratriActive) {
                                    $navSave = round(($cart->subtotal - $cart->discount) * 0.05, 2);
                                    $displayTotalDelivery = max(0, $displayTotalDelivery - $navSave);
                                    $displayTotalCollection = max(0, $displayTotalCollection - $navSave);
                                    $totalSavings += $navSave;
                                }
                                $displayTotal = $displayTotalDelivery;
                                $codMinOrder = 10;
                                $showCod = $displayTotal >= $codMinOrder;
                            ?>

                            <div class="ck-total-row">
                                <span class="ck-total-label">Total</span>
                                <span class="ck-total-val" x-show="deliveryMethod === 'delivery'"><?php echo format_price($displayTotalDelivery); ?></span>
                                <span class="ck-total-val" x-show="deliveryMethod === 'collection'"><?php echo format_price($displayTotalCollection); ?></span>
                            </div>
                            <p style="font-size:.62rem;color:rgba(0,0,0,.35);text-align:center;margin-top:.15rem;">Inclusive of all taxes</p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalSavings > 0): ?>
                                <div class="ck-saved-banner" style="margin-top:.65rem;">
                                    You save <?php echo format_price($totalSavings); ?> on this order
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div style="padding:0 1rem 1rem;">
                            <button type="submit" :disabled="processing" class="ck-submit-btn">
                                <span x-show="!processing">
                                    <template x-if="paymentMethod === 'razorpay'">
                                        <span>Pay Now &middot;
                                            <span x-show="deliveryMethod === 'delivery'"><?php echo format_price($displayTotalDelivery); ?></span>
                                            <span x-show="deliveryMethod === 'collection'"><?php echo format_price($displayTotalCollection); ?></span>
                                        </span>
                                    </template>
                                    <template x-if="paymentMethod === 'cod'">
                                        <span>Pay <?php echo e(currency_symbol()); ?><?php echo e(\App\Models\Setting::get('cod_advance_amount', 100)); ?> & Place Order</span>
                                    </template>
                                </span>
                                <span x-show="processing" x-cloak style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                    <svg style="width:.9rem;height:.9rem;" class="animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Processing...
                                </span>
                            </button>
                            <p x-show="error" x-text="error" class="ck-error" style="text-align:center;margin-top:.5rem;" x-cloak></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isGuest && $addresses->isEmpty()): ?>
                                <p class="ck-error" style="text-align:center;margin-top:.5rem;">Please add an address to place your order.</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="ck-trust">
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Secure
                            </div>
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Genuine
                            </div>
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Fresh Daily
                            </div>
                        </div>

                        
                        <div style="padding:.35rem 1rem .75rem;text-align:center;">
                            <p style="font-size:.62rem;color:rgba(0,0,0,.35);line-height:1.5;">
                                By placing your order, you agree to our
                                <a href="<?php echo e(route('terms')); ?>" class="ck-link" style="font-size:.62rem;">Terms</a> &
                                <a href="<?php echo e(route('privacy')); ?>" class="ck-link" style="font-size:.62rem;">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

     <?php $__env->slot('scripts', null, []); ?> 
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            // ─── Shared reverse-geocoding helper ───
            function reverseGeocode(lat, lng) {
                return fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng + '&addressdetails=1&zoom=18', {
                    headers: { 'Accept-Language': 'en' }
                }).then(r => r.json());
            }

            function parseAddress(data) {
                const a = data.address || {};
                return {
                    line1: [a.house_number, a.road].filter(Boolean).join(' ') || '',
                    line2: a.suburb || a.neighbourhood || a.hamlet || '',
                    city: a.city || a.town || a.village || a.municipality || '',
                    state: a.state || a.county || '',
                    postcode: a.postcode || '',
                    display: data.display_name || '',
                };
            }

            // ─── Guest checkout: GPS + address fields ───
            function addressGPS() {
                return {
                    // GPS state
                    gpsLoading: false,
                    gpsStatus: '',
                    gpsSuccess: false,
                    gpsLat: null,
                    gpsLng: null,

                    // Address fields (bound to inputs)
                    pin: '',
                    city: '',
                    state: '',
                    pinError: '',
                    pinServiceable: null,
                    pinTimeout: null,

                    detectLocation() {
                        if (!navigator.geolocation) {
                            this.gpsStatus = 'GPS not supported by your browser';
                            this.gpsSuccess = false;
                            return;
                        }

                        this.gpsLoading = true;
                        this.gpsStatus = '';

                        navigator.geolocation.getCurrentPosition(
                            (pos) => {
                                this.gpsLat = pos.coords.latitude;
                                this.gpsLng = pos.coords.longitude;
                                this.fillFromGPS(pos.coords.latitude, pos.coords.longitude);
                            },
                            (err) => {
                                this.gpsLoading = false;
                                if (err.code === 1) {
                                    this.gpsStatus = 'Location permission denied. Please allow access in your browser settings.';
                                } else if (err.code === 2) {
                                    this.gpsStatus = 'Unable to determine your location. Please enter address manually.';
                                } else {
                                    this.gpsStatus = 'Location request timed out. Please try again.';
                                }
                                this.gpsSuccess = false;
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                        );
                    },

                    async fillFromGPS(lat, lng) {
                        try {
                            const data = await reverseGeocode(lat, lng);
                            const addr = parseAddress(data);

                            // Fill address fields
                            this.pin = addr.postcode;
                            this.city = addr.city;
                            this.state = addr.state;

                            // Fill non-Alpine inputs via DOM
                            const line1El = document.querySelector('[name="shipping_address_line_1"]');
                            const line2El = document.querySelector('[name="shipping_address_line_2"]');
                            if (line1El) line1El.value = addr.line1;
                            if (line2El) line2El.value = addr.line2;

                            this.gpsStatus = 'Address detected — please verify details below';
                            this.gpsSuccess = true;
                            this.gpsLoading = false;

                            // Also run serviceability check
                            if (this.pin) this.fetchPinData();
                        } catch (e) {
                            this.gpsStatus = 'Could not detect address. Please enter manually.';
                            this.gpsSuccess = false;
                            this.gpsLoading = false;
                        }
                    },

                    fetchPinData() {
                        this.pinError = '';
                        this.pinServiceable = null;
                        clearTimeout(this.pinTimeout);
                        if (this.pin.length < 5) return;

                        this.pinTimeout = setTimeout(() => {
                            // Postcode lookup for city/state autofill
                            fetch('https://api.postalpincode.in/pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    if (data[0] && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length) {
                                        const po = data[0].PostOffice[0];
                                        if (!this.city) this.city = po.District || po.Division || '';
                                        if (!this.state) this.state = po.State || '';
                                    }
                                })
                                .catch(() => {});

                            // Serviceability check
                            fetch('/api/check-pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    this.pinServiceable = data.serviceable === true;
                                    if (!data.serviceable) {
                                        this.pinError = 'Delivery not available to this postcode';
                                    }
                                })
                                .catch(() => {});
                        }, 400);
                    }
                };
            }

            // ─── Authenticated user: GPS for inline "new address" form ───
            function addressGPSInline() {
                return {
                    gpsLoading: false,
                    gpsStatus: '',
                    gpsSuccess: false,

                    // Address fields
                    pin: '',
                    city: '',
                    state: '',
                    line1: '',
                    line2: '',
                    pinError: '',
                    pinServiceable: null,
                    pinTimeout: null,

                    detectLocation() {
                        if (!navigator.geolocation) {
                            this.gpsStatus = 'GPS not supported by your browser';
                            this.gpsSuccess = false;
                            return;
                        }

                        this.gpsLoading = true;
                        this.gpsStatus = '';

                        navigator.geolocation.getCurrentPosition(
                            (pos) => this.fillFromGPS(pos.coords.latitude, pos.coords.longitude),
                            (err) => {
                                this.gpsLoading = false;
                                this.gpsStatus = err.code === 1
                                    ? 'Location permission denied.'
                                    : 'Could not detect location. Enter manually.';
                                this.gpsSuccess = false;
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                        );
                    },

                    async fillFromGPS(lat, lng) {
                        try {
                            const data = await reverseGeocode(lat, lng);
                            const addr = parseAddress(data);

                            this.pin = addr.postcode;
                            this.city = addr.city;
                            this.state = addr.state;
                            this.line1 = addr.line1;
                            this.line2 = addr.line2;

                            this.gpsStatus = 'Address detected — verify below';
                            this.gpsSuccess = true;
                            this.gpsLoading = false;

                            if (this.pin) this.fetchPinData();
                        } catch (e) {
                            this.gpsStatus = 'Could not detect address.';
                            this.gpsSuccess = false;
                            this.gpsLoading = false;
                        }
                    },

                    fetchPinData() {
                        this.pinError = '';
                        this.pinServiceable = null;
                        clearTimeout(this.pinTimeout);
                        if (this.pin.length < 5) return;

                        this.pinTimeout = setTimeout(() => {
                            fetch('https://api.postalpincode.in/pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    if (data[0] && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length) {
                                        const po = data[0].PostOffice[0];
                                        if (!this.city) this.city = po.District || po.Division || '';
                                        if (!this.state) this.state = po.State || '';
                                    }
                                })
                                .catch(() => {});

                            fetch('/api/check-pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    this.pinServiceable = data.serviceable === true;
                                    if (!data.serviceable) this.pinError = 'Delivery not available to this postcode';
                                })
                                .catch(() => {});
                        }, 400);
                    }
                };
            }

            let abandonedCaptureTimeout = null;
            let lastCapturedData = '';
            function captureAbandoned(immediate) {
                clearTimeout(abandonedCaptureTimeout);
                const delay = immediate ? 0 : 2000;
                abandonedCaptureTimeout = setTimeout(() => {
                    const phone = (document.querySelector('[name="guest_phone"]')?.value || '').replace(/\D/g, '');
                    const email = document.querySelector('[name="guest_email"]')?.value || '';
                    const name = document.querySelector('[name="guest_name"]')?.value || '';

                    if (phone.length < 10 && !email.includes('@')) return;

                    const dataKey = phone + '|' + email + '|' + name;
                    if (dataKey === lastCapturedData) return;
                    lastCapturedData = dataKey;

                    fetch('<?php echo e(route("checkout.abandoned.capture")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        },
                        body: JSON.stringify({ phone, email, name }),
                    }).catch(() => {});
                }, delay);
            }

            function checkoutForm(firstMethod) {
                return {
                    sameBilling: true,
                    paymentMethod: firstMethod,
                    deliveryMethod: 'collection',
                    showAddressForm: false,
                    savingAddress: false,
                    processing: false,
                    error: '',

                    handleSubmit(e) {
                        this.error = '';
                        this.initiateRazorpay(e.target);
                    },

                    async initiateRazorpay(form) {
                        this.processing = true;
                        const formData = new FormData(form);
                        const data = Object.fromEntries(formData.entries());

                        try {
                            const response = await fetch('<?php echo e(route("checkout.razorpay.create")); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify(data),
                            });

                            const result = await response.json();

                            if (!response.ok) {
                                this.error = result.error || result.message || 'Something went wrong. Please try again.';
                                this.processing = false;
                                return;
                            }

                            this.openRazorpayCheckout(result);
                        } catch (err) {
                            this.error = 'Network error. Please check your connection and try again.';
                            this.processing = false;
                        }
                    },

                    openRazorpayCheckout(orderData) {
                        const self = this;

                        const options = {
                            key: orderData.key,
                            amount: orderData.amount,
                            currency: orderData.currency,
                            name: orderData.name,
                            description: orderData.description,
                            order_id: orderData.order_id,
                            prefill: orderData.prefill,
                            theme: {
                                color: '#C8102E',
                                backdrop_color: 'rgba(0, 0, 0, 0.5)',
                            },
                            modal: {
                                ondismiss: function() {
                                    self.processing = false;
                                    self.error = 'Payment was cancelled. You can try again.';
                                },
                                confirm_close: true,
                                escape: false,
                            },
                            handler: function(response) {
                                self.verifyPayment(response);
                            },
                        };

                        const rzp = new Razorpay(options);
                        rzp.on('payment.failed', function(response) {
                            self.processing = false;
                            self.error = response.error.description || 'Payment failed. Please try again.';
                        });
                        rzp.open();
                    },

                    async verifyPayment(paymentResponse) {
                        try {
                            const response = await fetch('<?php echo e(route("checkout.razorpay.verify")); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    razorpay_order_id: paymentResponse.razorpay_order_id,
                                    razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                    razorpay_signature: paymentResponse.razorpay_signature,
                                }),
                            });

                            const result = await response.json();

                            if (result.success && result.redirect) {
                                window.location.href = result.redirect;
                            } else {
                                this.error = result.error || 'Payment verification failed. Please contact support.';
                                this.processing = false;
                            }
                        } catch (err) {
                            this.error = 'Verification failed. If amount was deducted, it will be refunded. Please contact support.';
                            this.processing = false;
                        }
                    },
                };
            }
        </script>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.ga4.measurement_id')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php
                    $ga4CheckoutItems = $cart->items->map(function ($item) {
                        return [
                            'item_id' => $item->product->sku ?? (string) $item->product_id,
                            'item_name' => $item->product->name,
                            'price' => (float) $item->price,
                            'quantity' => $item->quantity,
                        ];
                    });
                ?>
                var checkoutItems = <?php echo json_encode($ga4CheckoutItems, JSON_UNESCAPED_UNICODE); ?>;
                gtag('event', 'begin_checkout', {
                    currency: 'GBP',
                    value: <?php echo e((float) $cart->total); ?>,
                    items: checkoutItems
                });
            });
        </script>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php $__env->endSlot(); ?>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/checkout/index.blade.php ENDPATH**/ ?>