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

     <?php $__env->slot('title', null, []); ?> Your Order — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?> <?php $__env->endSlot(); ?>

     <?php $__env->slot('styles', null, []); ?> 
    <style>
        .cart-page { background:#fafaf8; color:#111111; min-height:70vh; }

        /* ─── Page header ─── */
        .cart-header {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:1.1rem 1.25rem;
        }
        .page-bc {
            display:flex; flex-wrap:wrap; align-items:center; gap:.3rem .45rem;
            font-size:.78rem; color:rgba(0,0,0,.38); margin-bottom:.65rem;
            max-width:1100px; margin-left:auto; margin-right:auto;
        }
        .page-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .page-bc a:hover { color:#C8102E; }
        .page-bc-sep { opacity:.4; }
        .cart-heading {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:clamp(1.6rem,4vw,2.2rem);
            text-transform:uppercase; letter-spacing:.03em; color:#111111;
            line-height:1.1; display:flex; align-items:center; gap:.6rem;
            max-width:1100px; margin:0 auto;
        }
        .cart-count-badge {
            font-size:.75rem; font-weight:700;
            background:#C8102E; color:#fff;
            padding:.15rem .6rem; border-radius:99px; letter-spacing:0;
        }

        /* ─── Item card ─── */
        .cart-item {
            background:#fff;
            border:1px solid rgba(0,0,0,.09);
            border-radius:.85rem;
            padding:1rem 1.1rem;
            display:flex;
            gap:1rem;
            transition:box-shadow .25s, border-color .25s, transform .25s, opacity .3s;
            box-shadow:0 2px 8px rgba(0,0,0,.04);
            animation:cartItemIn .4s ease both;
        }
        .cart-item:hover { box-shadow:0 6px 20px rgba(0,0,0,.1); border-color:rgba(200,16,46,.2); transform:translateY(-2px); }
        @keyframes cartItemIn {
            from { opacity:0; transform:translateX(-12px); }
            to   { opacity:1; transform:translateX(0); }
        }

        .cart-item-img {
            width:100px; height:100px; border-radius:.65rem;
            overflow:hidden; flex-shrink:0; background:#f0ece8;
            border:1px solid rgba(0,0,0,.07);
            transition:transform .3s;
        }
        .cart-item:hover .cart-item-img { transform:scale(1.04); }
        .cart-item-img img { width:100%;height:100%;object-fit:cover;display:block; }

        .cart-item-name {
            font-size:.92rem; font-weight:700; color:#111111; line-height:1.35;
            text-decoration:none;
        }
        .cart-item-name:hover { color:#C8102E; }
        .cart-item-cat {
            font-size:.72rem; color:rgba(0,0,0,.35); margin-top:.15rem;
            text-transform:uppercase; letter-spacing:.06em;
        }
        .cart-item-price { font-size:1rem; font-weight:800; color:#C8102E; margin-top:.3rem; }

        /* ─── Qty stepper pill ─── */
        .qty-wrap {
            display:inline-flex; align-items:center;
            background:#fafaf8;
            border:1px solid rgba(0,0,0,.12);
            border-radius:99px; overflow:hidden;
            transition:border-color .2s, box-shadow .2s;
        }
        .qty-wrap:hover { border-color:rgba(200,16,46,.3); box-shadow:0 0 0 3px rgba(200,16,46,.07); }
        .qty-btn {
            width:36px; height:36px; border:none; cursor:pointer;
            background:transparent; color:#111111; font-size:1.1rem; font-weight:700;
            display:flex; align-items:center; justify-content:center;
            transition:background .15s, color .15s, transform .1s;
        }
        .qty-btn:hover:not(:disabled) { background:#C8102E; color:#fff; }
        .qty-btn:active:not(:disabled) { transform:scale(.88); }
        .qty-btn:disabled { opacity:.28; cursor:not-allowed; }
        .qty-val {
            font-size:.9rem; font-weight:700; color:#111111;
            min-width:32px; text-align:center; user-select:none;
        }

        /* ─── Remove button ─── */
        .remove-btn {
            background:none; border:none; cursor:pointer; padding:.35rem;
            color:rgba(0,0,0,.22); transition:color .15s, background .15s, transform .1s;
            display:flex; align-items:center; border-radius:.4rem;
        }
        .remove-btn:hover { color:#C8102E; background:rgba(200,16,46,.06); }
        .remove-btn:active { transform:scale(.9); }

        /* ─── Order summary panel ─── */
        .order-summary {
            background:#fff;
            border:1px solid rgba(0,0,0,.1);
            border-top:3px solid #C8102E;
            border-radius:1rem;
            overflow:hidden;
            box-shadow:0 8px 32px rgba(0,0,0,.09);
            animation:summaryUp .5s ease .15s both;
        }
        @keyframes summaryUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .summary-header {
            padding:.9rem 1.1rem;
            border-bottom:1px solid rgba(0,0,0,.07);
            display:flex; align-items:center; gap:.55rem;
        }
        .summary-header-title {
            font-size:.72rem; font-weight:800; letter-spacing:.1em;
            text-transform:uppercase; color:rgba(0,0,0,.4);
        }
        .summary-row {
            display:flex; align-items:center; justify-content:space-between;
            font-size:.87rem; padding:.42rem 0;
        }
        .summary-label { color:rgba(0,0,0,.45); }
        .summary-val { font-weight:600; color:#111111; }
        .summary-divider { height:1px; background:rgba(0,0,0,.08); margin:.8rem 0; }
        .summary-total-label { font-size:1rem; font-weight:800; color:#111111; }
        .summary-total-val { font-size:1.15rem; font-weight:900; color:#C8102E; }

        /* ─── Checkout btn ─── */
        .btn-checkout {
            display:flex; width:100%; padding:1rem 1.5rem;
            align-items:center; justify-content:center; gap:.5rem;
            background:#C8102E; color:#fff; font-weight:800; font-size:.95rem;
            border-radius:99px; text-decoration:none; border:none; cursor:pointer;
            transition:background .15s, transform .1s, box-shadow .15s;
            letter-spacing:.03em;
            box-shadow:0 4px 14px rgba(200,16,46,.25);
            position:relative; overflow:hidden;
        }
        .btn-checkout::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(120deg, transparent 30%, rgba(255,255,255,.18) 50%, transparent 70%);
            transform:translateX(-100%); transition:transform .5s;
        }
        .btn-checkout:hover { background:#a50e26; color:#fff; transform:translateY(-2px); box-shadow:0 6px 22px rgba(200,16,46,.35); }
        .btn-checkout:hover::after { transform:translateX(100%); }
        .btn-checkout:active { transform:none; box-shadow:0 2px 8px rgba(200,16,46,.2); }

        /* ─── Coupon ─── */
        .coupon-input {
            flex:1; background:#fafaf8; border:1px solid rgba(0,0,0,.14);
            border-right:none; border-radius:.5rem 0 0 .5rem; padding:.6rem .9rem;
            font-size:.85rem; color:#111111; outline:none;
            transition:border-color .2s, box-shadow .2s;
        }
        .coupon-input::placeholder { color:rgba(0,0,0,.28); }
        .coupon-input:focus { border-color:#C8102E; box-shadow:0 0 0 3px rgba(200,16,46,.08); }
        .coupon-apply-btn {
            padding:.6rem 1.1rem; background:#C8102E; color:#fff; font-size:.82rem;
            font-weight:700; border:none; border-radius:0 .5rem .5rem 0; cursor:pointer;
            transition:background .15s, transform .1s;
        }
        .coupon-apply-btn:hover { background:#a50e26; }
        .coupon-apply-btn:active { transform:scale(.95); }

        /* ─── Trust badges ─── */
        .trust-row {
            display:flex; align-items:center; justify-content:center; gap:.75rem;
            flex-wrap:wrap; padding:.85rem 1.1rem 0;
        }
        .trust-item {
            display:flex; align-items:center; gap:.3rem;
            font-size:.68rem; color:rgba(0,0,0,.35); font-weight:600;
        }

        /* ─── Delivery nudge ─── */
        .nudge-bar {
            padding:.85rem 1.1rem;
            border-bottom:1px solid rgba(0,0,0,.07);
            background:#fffbf0;
        }
        .nudge-label { font-size:.78rem; color:#b45309; font-weight:600; margin-bottom:.4rem; }
        .nudge-track { background:rgba(0,0,0,.08); border-radius:99px; height:6px; overflow:hidden; }
        .nudge-fill {
            background:linear-gradient(90deg,#D4A017,#f0c040); height:100%; border-radius:99px;
            transition:width .5s cubic-bezier(.4,0,.2,1);
            position:relative; overflow:hidden;
        }
        .nudge-fill::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent);
            animation:nudgeShimmer 2.5s infinite;
        }
        @keyframes nudgeShimmer {
            from { transform:translateX(-100%); }
            to   { transform:translateX(100%); }
        }

        .free-delivery-banner {
            padding:.7rem 1.1rem;
            background:#f0fdf4;
            border-bottom:1px solid rgba(22,163,74,.2);
        }

        /* ─── Empty state ─── */
        .empty-state { text-align:center; padding:5rem 1rem 4rem; }
        .empty-icon-wrap {
            width:104px; height:104px; border-radius:50%;
            background:#fff;
            border:2px dashed rgba(0,0,0,.12);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 1.5rem;
            animation:emptyFloat 3s ease-in-out infinite;
            box-shadow:0 4px 20px rgba(0,0,0,.05);
        }
        @keyframes emptyFloat {
            0%, 100% { transform:translateY(0); box-shadow:0 4px 20px rgba(0,0,0,.05); }
            50% { transform:translateY(-10px); box-shadow:0 12px 28px rgba(0,0,0,.08); }
        }

        /* ─── You may also like ─── */
        .rec-card {
            flex-shrink:0; width:165px; background:#fff;
            border:1px solid rgba(0,0,0,.09); border-radius:.85rem; overflow:hidden;
            transition:box-shadow .25s, border-color .25s, transform .25s;
            box-shadow:0 2px 8px rgba(0,0,0,.04);
        }
        .rec-card:hover { box-shadow:0 8px 24px rgba(0,0,0,.12); border-color:rgba(200,16,46,.2); transform:translateY(-4px); }
    </style>
     <?php $__env->endSlot(); ?>

    
    <div class="cart-header">
        <nav class="page-bc">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <span class="page-bc-sep">/</span>
            <a href="<?php echo e(route('products.index')); ?>">Menu</a>
            <span class="page-bc-sep">/</span>
            <span style="color:#111111;font-weight:600;">Your Basket</span>
        </nav>
        <h1 class="cart-heading" x-data>
            Your Order
            <span class="cart-count-badge" x-show="$store.cart.itemCount > 0"
                  x-text="$store.cart.itemCount + (parseInt($store.cart.itemCount) === 1 ? ' item' : ' items')"
                  x-cloak></span>
        </h1>
    </div>

    <div class="cart-page">
        <div style="max-width:1100px; margin:0 auto; padding:1.5rem 1.25rem 3.5rem;">

            <div x-data="cartPage()" x-cloak>

                
                <div x-data x-init="$el.remove()" style="display:flex;flex-direction:column;gap:.75rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 3; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:.85rem;padding:1rem 1.1rem;display:flex;gap:1rem;animation:pulse 1.5s infinite;">
                        <div style="width:90px;height:90px;border-radius:.65rem;background:rgba(0,0,0,.06);flex-shrink:0;"></div>
                        <div style="flex:1;padding:.25rem 0;">
                            <div style="height:14px;background:rgba(0,0,0,.07);border-radius:4px;width:55%;margin-bottom:.55rem;"></div>
                            <div style="height:11px;background:rgba(0,0,0,.05);border-radius:4px;width:30%;margin-bottom:.7rem;"></div>
                            <div style="height:18px;background:rgba(0,0,0,.07);border-radius:4px;width:22%;"></div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}</style>
                </div>

                <template x-if="items.length > 0">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-6">

                        
                        <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:.65rem;">

                            <template x-for="item in items" :key="item.id">
                                <div class="cart-item">
                                    
                                    <a :href="item.product_url" class="cart-item-img" style="text-decoration:none;">
                                        <img :src="item.image || '<?php echo e(asset('images/products/justburgers/cheeseburger.jpg')); ?>'"
                                             :alt="item.name"
                                             onerror="this.src='<?php echo e(asset('images/products/justburgers/cheeseburger.jpg')); ?>'">
                                    </a>

                                    
                                    <div style="flex:1;min-width:0;display:flex;flex-direction:column;justify-content:space-between;padding:.1rem 0;">
                                        <div>
                                            <a :href="item.product_url" class="cart-item-name" x-text="item.name"></a>
                                            <template x-if="item.toppings && (item.toppings.added?.length || item.toppings.removed?.length || item.toppings.kept?.length)">
                                                <div style="margin-top:.2rem;">
                                                    <template x-if="item.toppings.kept?.length">
                                                        <p style="font-size:.68rem;color:#666;line-height:1.3;margin:0;">
                                                            <span>With: </span>
                                                            <template x-for="(t, i) in item.toppings.kept" :key="t.id">
                                                                <span x-text="t.name + (i < item.toppings.kept.length - 1 ? ', ' : '')"></span>
                                                            </template>
                                                        </p>
                                                    </template>
                                                    <template x-if="item.toppings.added?.length">
                                                        <p style="font-size:.68rem;color:#16a34a;line-height:1.3;margin:0;">
                                                            <span>+ </span>
                                                            <template x-for="(t, i) in item.toppings.added" :key="t.id">
                                                                <span x-text="t.name + (t.price > 0 ? ' (' + fp(t.price) + ')' : '') + (i < item.toppings.added.length - 1 ? ', ' : '')"></span>
                                                            </template>
                                                        </p>
                                                    </template>
                                                    <template x-if="item.toppings.removed?.length">
                                                        <p style="font-size:.68rem;color:#dc2626;line-height:1.3;margin:0;">
                                                            <span>No </span>
                                                            <template x-for="(t, i) in item.toppings.removed" :key="t.id">
                                                                <span x-text="t.name + (i < item.toppings.removed.length - 1 ? ', ' : '')"></span>
                                                            </template>
                                                        </p>
                                                    </template>
                                                </div>
                                            </template>
                                            <div class="cart-item-price" x-text="fp(item.line_price || item.price)"></div>
                                        </div>

                                        
                                        <div style="display:flex;align-items:center;gap:.75rem;margin-top:.5rem;flex-wrap:wrap;">
                                            <div class="qty-wrap">
                                                <button class="qty-btn"
                                                        @click="updateQty(item, item.quantity - 1)"
                                                        :disabled="item.quantity <= 1 || item.updating"
                                                        aria-label="Decrease">
                                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                                </button>
                                                <span class="qty-val" x-text="item.quantity"></span>
                                                <button class="qty-btn"
                                                        @click="updateQty(item, item.quantity + 1)"
                                                        :disabled="item.quantity >= 20 || item.updating"
                                                        aria-label="Increase">
                                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                </button>
                                            </div>

                                            
                                            <button @click="removeItem(item)" class="remove-btn" title="Remove item">
                                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>

                                            
                                            <span x-show="item.quantity > 1"
                                                  x-text="fp(item.price * item.quantity)"
                                                  style="margin-left:auto;font-size:.88rem;font-weight:700;color:rgba(0,0,0,.45);"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            
                            <div style="display:flex;justify-content:flex-end;padding-top:.25rem;">
                                <button @click="clearCart()"
                                        style="font-size:.74rem;color:rgba(0,0,0,.28);background:none;border:none;cursor:pointer;padding:.3rem .5rem;transition:color .15s;"
                                        onmouseover="this.style.color='#C8102E'" onmouseout="this.style.color='rgba(0,0,0,.28)'">
                                    Clear all items
                                </button>
                            </div>
                        </div>

                        
                        <div class="lg:w-[330px] shrink-0">
                            <div class="order-summary lg:sticky lg:top-20">

                                
                                <?php $freeThreshold = (float) \App\Models\Setting::get('free_shipping_threshold', 20); ?>
                                <template x-if="subtotal < <?php echo e($freeThreshold); ?>">
                                    <div class="nudge-bar">
                                        <p class="nudge-label">
                                            Add <span x-text="fp(<?php echo e($freeThreshold); ?> - subtotal)"></span> more for FREE delivery
                                        </p>
                                        <div class="nudge-track">
                                            <div class="nudge-fill"
                                                 :style="'width:'+Math.min(100,(subtotal/<?php echo e($freeThreshold); ?>)*100)+'%'"></div>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="subtotal >= <?php echo e($freeThreshold); ?>">
                                    <div class="free-delivery-banner">
                                        <p style="font-size:.82rem;color:#4ade80;font-weight:700;display:flex;align-items:center;gap:.4rem;">
                                            <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            You qualify for FREE delivery!
                                        </p>
                                    </div>
                                </template>

                                
                                <div class="summary-header">
                                    <svg style="width:15px;height:15px;color:rgba(0,0,0,.4);flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <span class="summary-header-title"
                                          x-text="'Order Summary · ' + totalQty + ' item' + (totalQty !== 1 ? 's' : '')"></span>
                                </div>

                                
                                <div style="padding:.9rem 1.1rem;border-bottom:1px solid rgba(0,0,0,.07);">
                                    <template x-if="coupon">
                                        <div style="display:flex;align-items:center;justify-content:space-between;padding:.6rem .85rem;background:rgba(22,163,74,.1);border:1px dashed rgba(22,163,74,.3);border-radius:.5rem;">
                                            <div>
                                                <span style="font-size:.8rem;font-weight:700;color:#4ade80;" x-text="coupon.code"></span>
                                                <span style="font-size:.72rem;color:rgba(0,0,0,.4);margin-left:.4rem;">applied</span>
                                                <p style="font-size:.72rem;color:#4ade80;margin-top:.15rem;" x-text="couponLabel"></p>
                                            </div>
                                            <button @click="removeCoupon()"
                                                    style="font-size:.72rem;color:#C8102E;background:none;border:none;cursor:pointer;font-weight:700;padding:.2rem .4rem;">
                                                Remove
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="!coupon">
                                        <div>
                                            <form @submit.prevent="applyCoupon()" style="display:flex;">
                                                <input type="text" x-model="couponCode"
                                                       placeholder="Promo / discount code"
                                                       class="coupon-input" required>
                                                <button type="submit" class="coupon-apply-btn"
                                                        :disabled="applyingCoupon"
                                                        x-text="applyingCoupon ? '...' : 'Apply'"></button>
                                            </form>
                                            <template x-if="couponError">
                                                <p style="font-size:.72rem;color:#f87171;margin-top:.4rem;" x-text="couponError"></p>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                
                                <div style="padding:.9rem 1.1rem;">
                                    <div style="display:flex;flex-direction:column;gap:.05rem;">
                                        <div class="summary-row">
                                            <span class="summary-label">Subtotal</span>
                                            <span class="summary-val" x-text="fp(subtotal)"></span>
                                        </div>
                                        <template x-if="discount > 0">
                                            <div class="summary-row">
                                                <span class="summary-label" x-text="couponLabel || 'Promo discount'"></span>
                                                <span style="font-weight:700;color:#4ade80;" x-text="'− ' + fp(discount)"></span>
                                            </div>
                                        </template>
                                        <div class="summary-row">
                                            <span class="summary-label">Delivery</span>
                                            <template x-if="subtotal >= <?php echo e($freeThreshold); ?>">
                                                <span style="font-weight:700;color:#4ade80;font-size:.85rem;">FREE</span>
                                            </template>
                                            <template x-if="subtotal < <?php echo e($freeThreshold); ?>">
                                                <span class="summary-val" x-text="fp(<?php echo e((float) \App\Models\Setting::get('shipping_charge', 2.99)); ?>)"></span>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="summary-divider"></div>

                                    <div style="display:flex;align-items:center;justify-content:space-between;">
                                        <span class="summary-total-label">Total</span>
                                        <span class="summary-total-val" x-text="fp(totalAmount)"></span>
                                    </div>

                                    <template x-if="discount > 0">
                                        <p style="font-size:.74rem;font-weight:600;color:#4ade80;text-align:center;margin-top:.55rem;">
                                            You save <span x-text="fp(discount)"></span> on this order!
                                        </p>
                                    </template>
                                </div>

                                
                                <div style="padding:0 1.1rem 1rem;">
                                    <a href="<?php echo e(route('checkout.index')); ?>" class="btn-checkout">
                                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Proceed to Checkout
                                        <svg style="width:15px;height:15px;margin-left:.2rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                    </a>
                                </div>

                                
                                <div class="trust-row" style="padding-bottom:.85rem;">
                                    <span class="trust-item">
                                        <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Secure checkout
                                    </span>
                                    <span style="color:rgba(0,0,0,.15);">·</span>
                                    <span class="trust-item">
                                        <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Fast delivery
                                    </span>
                                    <span style="color:rgba(0,0,0,.15);">·</span>
                                    <span class="trust-item">
                                        <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Local restaurant
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>

                
                <template x-if="items.length === 0">
                    <div class="empty-state">
                        <div class="empty-icon-wrap">
                            <svg style="width:40px;height:40px;color:rgba(0,0,0,.22);" fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h2 style="font-family:'Barlow Condensed',sans-serif;font-size:1.8rem;font-weight:900;text-transform:uppercase;color:#111111;margin-bottom:.5rem;">Your basket is empty</h2>
                        <p style="font-size:.92rem;color:rgba(0,0,0,.5);margin-bottom:2rem;max-width:300px;margin-left:auto;margin-right:auto;line-height:1.6;">
                            Looks like you haven't added anything yet. Browse our menu to get started.
                        </p>
                        <a href="<?php echo e(route('products.index')); ?>"
                           style="display:inline-flex;align-items:center;gap:.5rem;padding:.85rem 2rem;background:#C8102E;color:#fff;font-weight:700;font-size:.9rem;border-radius:99px;text-decoration:none;transition:background .15s;"
                           onmouseover="this.style.background='#a50e26'" onmouseout="this.style.background='#C8102E'">
                            Browse Menu
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </template>

            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($recommendations)): ?>
            <div style="margin-top:3rem;border-top:1px solid rgba(0,0,0,.08);padding-top:2rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.1rem;">
                    <h2 style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:1.4rem;text-transform:uppercase;letter-spacing:.04em;color:#111111;">
                        You May Also Like
                    </h2>
                    <a href="<?php echo e(route('products.index')); ?>"
                       style="font-size:.78rem;color:rgba(0,0,0,.4);text-decoration:none;" class="hover:text-[#C8102E] transition-colors">
                        View all →
                    </a>
                </div>
                <div style="display:flex;gap:.85rem;overflow-x:auto;padding-bottom:.75rem;-webkit-overflow-scrolling:touch;" class="scrollbar-hide">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="rec-card">
                        <a href="<?php echo e($rec['url']); ?>" style="display:block;aspect-ratio:1;overflow:hidden;">
                            <img src="<?php echo e($rec['image'] ?: asset('images/products/justburgers/cheeseburger.jpg')); ?>"
                                 alt="<?php echo e($rec['name']); ?>"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .3s;"
                                 onerror="this.src='<?php echo e(asset('images/products/justburgers/cheeseburger.jpg')); ?>'"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </a>
                        <div style="padding:.7rem .8rem;">
                            <a href="<?php echo e($rec['url']); ?>" style="text-decoration:none;">
                                <p style="font-size:.8rem;font-weight:700;color:#111111;line-height:1.3;" class="line-clamp-2"><?php echo e($rec['name']); ?></p>
                            </a>
                            <p style="font-size:.9rem;font-weight:800;color:#C8102E;margin:.3rem 0 .6rem;"><?php echo format_price($rec['price']); ?></p>
                            <button @click="$store.toppingsModal.open(<?php echo e($rec['id']); ?>, 1)"
                                    style="width:100%;padding:.42rem;font-size:.72rem;font-weight:700;background:#C8102E;color:#fff;border:none;border-radius:99px;cursor:pointer;transition:background .15s;"
                                    onmouseover="this.style.background='#a50e26'" onmouseout="this.style.background='#C8102E'">
                                Add to Order
                            </button>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>

    <?php
        $cartItems = $cart->items->map(fn($item) => [
            'id'            => $item->id,
            'product_id'    => $item->product_id,
            'name'          => $item->product->name,
            'brand'         => $item->product->brand?->name,
            'image'         => (($img = $item->product->primary_image_url) && !str_ends_with(strtolower($img), '.svg')) ? $img : asset('images/products/product-' . (($item->product->id % 27) + 1) . '.jpg'),
            'product_url'   => route('product.show', $item->product),
            'price'         => (float) $item->price,
            'toppings_total'=> (float) $item->toppings_total,
            'line_price'    => (float) $item->price + $item->toppings_total,
            'toppings'      => $item->toppings_list,
            'mrp'           => (float) $item->product->mrp,
            'discount_pct'  => $item->product->discount_percentage ?? 0,
            'quantity'      => $item->quantity,
            'updating'      => false,
        ])->values();
        $cartCoupon = null;
        if ($cart->coupon) {
            $cartCoupon = ['code' => $cart->coupon->code, 'type' => $cart->coupon->type, 'value' => (float) $cart->coupon->value, 'auto_apply' => $cart->coupon->auto_apply];
            if ($cart->coupon->type === 'buy_x_get_y' && $cart->coupon->conditions) {
                $cartCoupon['buy_qty'] = (int) ($cart->coupon->conditions['buy_qty'] ?? 0);
                $cartCoupon['get_qty'] = (int) ($cart->coupon->conditions['get_qty'] ?? 0);
            }
        }
        $cartDiscount = (float) $cart->discount;
    ?>

    <script>
        function cartPage() {
            return {
                items: <?php echo json_encode($cartItems, 15, 512) ?>,
                coupon: <?php echo json_encode($cartCoupon, 15, 512) ?>,
                discount: <?php echo e($cartDiscount); ?>,
                couponCode: '',
                couponError: '',
                applyingCoupon: false,
                csrfToken: '<?php echo e(csrf_token()); ?>',
                currencySymbol: '<?php echo e(currency_symbol()); ?>',
                currencyPosition: '<?php echo e(currency_position()); ?>',

                fp(amount) {
                    const f = parseFloat(amount).toFixed(2);
                    return this.currencyPosition === 'after' ? f + this.currencySymbol : this.currencySymbol + f;
                },
                get totalQty()    { return this.items.reduce((s,i) => s + i.quantity, 0); },
                get subtotal()    { return this.items.reduce((s,i) => s + i.price * i.quantity, 0); },
                get totalAmount() { return Math.max(0, this.subtotal - this.discount); },

                async updateQty(item, qty) {
                    if (qty < 1 || qty > 20 || item.updating) return;
                    item.updating = true;
                    const old = item.quantity;
                    item.quantity = qty;
                    try {
                        const r = await fetch(`/cart/${item.id}`, { method:'PUT', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':this.csrfToken,'Accept':'application/json'}, body:JSON.stringify({quantity:qty}) });
                        const d = await r.json();
                        if (!r.ok) { item.quantity = old; this.toast(d.error||'Error','error'); }
                        else { this.syncCoupon(d); this.updateBadge(); }
                    } catch { item.quantity = old; }
                    finally { item.updating = false; }
                },

                async removeItem(item) {
                    if (item.updating) return;
                    item.updating = true;
                    try {
                        const r = await fetch(`/cart/${item.id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':this.csrfToken,'Accept':'application/json'} });
                        const d = await r.json();
                        if (r.ok) { this.items = this.items.filter(i => i.id !== item.id); this.syncCoupon(d); this.updateBadge(); }
                    } catch {} finally { item.updating = false; }
                },

                async clearCart() {
                    try {
                        const r = await fetch('/cart', { method:'DELETE', headers:{'X-CSRF-TOKEN':this.csrfToken,'Accept':'application/json'} });
                        if (r.ok) { this.items = []; this.coupon = null; this.discount = 0; this.updateBadge(); }
                    } catch {}
                },

                async applyCoupon() {
                    if (!this.couponCode.trim() || this.applyingCoupon) return;
                    this.applyingCoupon = true; this.couponError = '';
                    try {
                        const r = await fetch('/cart/apply-coupon', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':this.csrfToken,'Accept':'application/json'}, body:JSON.stringify({code:this.couponCode}) });
                        const d = await r.json();
                        if (r.ok) { this.syncCoupon(d); this.couponCode = ''; }
                        else { this.couponError = d.error || 'Invalid code'; }
                    } catch { this.couponError = 'Something went wrong'; }
                    finally { this.applyingCoupon = false; }
                },

                async removeCoupon() {
                    try {
                        const r = await fetch('/cart/remove-coupon', { method:'DELETE', headers:{'X-CSRF-TOKEN':this.csrfToken,'Accept':'application/json'} });
                        const d = await r.json();
                        if (r.ok) this.syncCoupon(d);
                    } catch {}
                },

                syncCoupon(d) {
                    if (d.cart_discount !== undefined) this.discount = d.cart_discount;
                    this.coupon = d.coupon || null;
                    if (!this.coupon) this.discount = 0;
                },

                get couponLabel() {
                    if (!this.coupon) return '';
                    if (this.coupon.type === 'buy_x_get_y') return 'Buy '+(this.coupon.buy_qty||0)+' Get '+(this.coupon.get_qty||0)+(this.coupon.value>=100?' Free':' at '+this.coupon.value+'% off');
                    if (this.coupon.type === 'percentage') return this.coupon.code+' ('+this.coupon.value+'% off)';
                    return this.coupon.code;
                },

                updateBadge() {
                    const s = Alpine.store('cart');
                    if (s) s.items = this.items.map(i => ({quantity:i.quantity,price:i.price}));
                },

                toast(msg, type='success') {
                    const s = Alpine.store('toast');
                    if (s) type==='error' ? s.error(msg) : s.success(msg);
                },
            };
        }
    </script>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.ga4.measurement_id')): ?>
    <?php
        $ga4CartItems = $cart->items->map(fn($i) => ['item_id'=>$i->product->sku??(string)$i->product_id,'item_name'=>$i->product->name,'price'=>(float)$i->price,'quantity'=>$i->quantity]);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'view_cart', { currency:'GBP', value:<?php echo e((float) $cart->total); ?>, items:<?php echo json_encode($ga4CartItems, JSON_UNESCAPED_UNICODE); ?> });
            }
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/cart/index.blade.php ENDPATH**/ ?>