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

     <?php $__env->slot('title', null, []); ?> 
        <?php echo e(request('category') ? ($categories->firstWhere('slug', request('category'))?->name ?? 'Menu') : 'Full Menu'); ?> — <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>

     <?php $__env->endSlot(); ?>

    <?php $__env->startPush('meta'); ?>
        <?php
            $metaCat   = request('category') ? ($categories->firstWhere('slug', request('category'))?->name ?? null) : null;
            $siteName  = \App\Models\Setting::get('site_name', config('app.name'));
            $metaDesc  = $metaCat
                ? "Order {$metaCat} from {$siteName}. Browse our full menu and place your order online or on WhatsApp."
                : "Browse the full menu at {$siteName}. Fresh burgers, sides, drinks and more — order online or on WhatsApp.";
        ?>
        <meta name="description" content="<?php echo e($metaDesc); ?>">
        <link rel="canonical" href="<?php echo e(url('/menu')); ?>">
        <meta property="og:title" content="<?php echo e($metaCat ?? 'Full Menu'); ?> — <?php echo e($siteName); ?>">
        <meta property="og:description" content="<?php echo e($metaDesc); ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(url('/menu')); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->anyFilled(['category', 'brand', 'min_price', 'max_price', 'rating', 'in_stock', 'on_sale', 'sort'])): ?>
            <meta name="robots" content="noindex, follow">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php $__env->stopPush(); ?>

     <?php $__env->slot('styles', null, []); ?> 
    <style>
        .menu-page { background:#fafaf8; color:#111111; min-height:60vh; }

        /* Page header */
        .menu-page-header {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:1.25rem 1.25rem 1rem;
        }
        @media(min-width:1024px){ .menu-page-header { padding:1.5rem 2rem 1.25rem; } }

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
     <?php $__env->endSlot(); ?>

    <?php
        $activeCat = request('category');
        $metaCat   = $activeCat ? ($categories->firstWhere('slug', $activeCat)?->name ?? null) : null;
        $freeThreshold = \App\Models\Setting::get('free_delivery_threshold', 20);
    ?>

    <div class="menu-page">

        
        <div class="menu-page-header">
            <div style="max-width:1240px; margin:0 auto;">
                <nav style="display:flex;align-items:center;gap:.35rem;font-size:.78rem;color:rgba(0,0,0,.38);margin-bottom:.55rem;">
                    <a href="<?php echo e(url('/')); ?>" style="color:rgba(0,0,0,.38);text-decoration:none;" class="hover:text-[#C8102E] transition-colors">Home</a>
                    <span>/</span>
                    <span style="color:#111111;font-weight:600;">Our Menu</span>
                </nav>
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;">
                    <div>
                        <h1 style="font-family:'Barlow Condensed',sans-serif;font-weight:900;font-size:clamp(1.6rem,4vw,2.2rem);text-transform:uppercase;letter-spacing:.04em;color:#111111;line-height:1.1;">
                            <?php echo e($metaCat ?? 'Our Full Menu'); ?>

                        </h1>
                        <p style="font-size:.82rem;color:rgba(0,0,0,.42);margin-top:.15rem;"><?php echo e($products->total()); ?> items</p>
                    </div>
                    <?php $waPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('site_mobile', '')); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($waPhone): ?>
                    <a href="https://wa.me/<?php echo e($waPhone); ?>?text=<?php echo e(urlencode('Hi! I\'d like to place an order.')); ?>"
                       target="_blank" rel="noopener"
                       style="display:inline-flex;align-items:center;gap:.5rem;padding:.55rem 1.2rem;background:#25D366;color:#fff;font-weight:700;font-size:.82rem;border-radius:99px;text-decoration:none;">
                        <svg style="width:15px;height:15px;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Order on WhatsApp
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="cat-tabs">
            <div class="cat-tabs-inner">
                <a href="<?php echo e(route('products.index', array_merge(request()->except(['category','page']), []))); ?>"
                   class="cat-tab <?php echo e(!$activeCat ? 'active' : ''); ?>">All</a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e(route('products.index', array_merge(request()->except(['category','page']), ['category' => $category->slug]))); ?>"
                   class="cat-tab <?php echo e($activeCat === $category->slug ? 'active' : ''); ?>">
                    <?php echo e($category->name); ?>

                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var active = document.querySelector('.cat-tab.active');
                if (active) {
                    active.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'instant' });
                }
            });
        </script>

        
        <div style="max-width:1240px; margin:0 auto; padding:1.25rem 1rem 5rem;">
            <div style="display:flex; align-items:flex-start; gap:1.25rem;">

                
                <div style="flex:1; min-width:0;">

                    
                    <div style="display:flex;align-items:center;gap:.75rem;padding:.55rem 1.25rem;background:#fff;border:1px solid rgba(0,0,0,.08);border-radius:.75rem .75rem 0 0;border-bottom:none;">
                        <span style="font-size:.78rem;color:rgba(0,0,0,.38);margin-right:auto;"><?php echo e($products->total()); ?> items</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['category','min_price','max_price','rating','in_stock','on_sale'])): ?>
                        <a href="<?php echo e(route('products.index', request()->only(['category','sort']))); ?>"
                           style="font-size:.75rem;color:#C8102E;font-weight:600;text-decoration:none;">Clear filters</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div style="display:flex;align-items:center;gap:.4rem;">
                            <label style="font-size:.77rem;color:rgba(0,0,0,.38);" class="hidden sm:inline">Sort:</label>
                            <select class="menu-sort-select"
                                    onchange="window.location.href = '<?php echo e(route('products.index')); ?>?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})">
                                <option value="newest"      <?php echo e(request('sort') === 'newest'      ? 'selected' : ''); ?>>Newest</option>
                                <option value="price_asc"   <?php echo e(request('sort') === 'price_asc'   ? 'selected' : ''); ?>>Price ↑</option>
                                <option value="price_desc"  <?php echo e(request('sort') === 'price_desc'  ? 'selected' : ''); ?>>Price ↓</option>
                                <option value="rating"      <?php echo e(request('sort') === 'rating'      ? 'selected' : ''); ?>>Top Rated</option>
                                <option value="bestselling" <?php echo e(request('sort') === 'bestselling' ? 'selected' : ''); ?>>Bestselling</option>
                            </select>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->count()): ?>
                        <div style="background:#fff;border:1px solid rgba(0,0,0,.08);border-top:none;border-radius:0 0 .75rem .75rem;overflow:hidden;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $rawImg = $product->primary_image_url;
                                $imgSrc = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
                                    ? $rawImg
                                    : asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
                                $fallback = asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
                            ?>
                            <div class="menu-item-row" x-data="{ adding:false, added:false }">
                                <a href="<?php echo e(route('product.show', $product)); ?>" class="menu-item-link">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                                    <div class="menu-item-cat"><?php echo e($product->category->name); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="menu-item-name"><?php echo e($product->name); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->short_description): ?>
                                    <div class="menu-item-desc"><?php echo e($product->short_description); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="menu-item-price"><?php echo format_price($product->price); ?></div>
                                </a>
                                <div class="menu-item-right">
                                    <img src="<?php echo e($imgSrc); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         class="menu-item-img"
                                         loading="lazy"
                                         onerror="this.onerror=null;this.src='<?php echo e($fallback); ?>';">
                                    <button class="menu-add-btn"
                                            @click.prevent="$store.toppingsModal.open(<?php echo e($product->id); ?>, 1)"
                                            style="background:#C8102E;color:#fff;">
                                        + Add
                                    </button>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
                        <nav style="display:flex;align-items:center;justify-content:center;gap:.35rem;padding:1.25rem 0;">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->onFirstPage()): ?>
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:rgba(0,0,0,.2);cursor:default;">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($products->previousPageUrl()); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php
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
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($k > 0 && $page - $pages[$k - 1] > 1): ?>
                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:36px;font-size:.78rem;color:rgba(0,0,0,.3);">…</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page === $current): ?>
                                    <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .4rem;border-radius:.45rem;font-size:.82rem;font-weight:700;color:#fff;background:#C8102E;"><?php echo e($page); ?></span>
                                <?php else: ?>
                                    <a href="<?php echo e($products->url($page)); ?>" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 .4rem;border-radius:.45rem;font-size:.82rem;font-weight:600;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'"><?php echo e($page); ?></a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasMorePages()): ?>
                                <a href="<?php echo e($products->nextPageUrl()); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:#111111;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;transition:all .14s;" onmouseover="this.style.borderColor='#C8102E';this.style.color='#C8102E'" onmouseout="this.style.borderColor='rgba(0,0,0,.12)';this.style.color='#111111'">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            <?php else: ?>
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:.45rem;font-size:.82rem;color:rgba(0,0,0,.2);cursor:default;">
                                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </nav>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php else: ?>
                    <div style="text-align:center;padding:4rem 1.5rem;background:#fff;border:1px solid rgba(0,0,0,.08);border-top:none;border-radius:0 0 .75rem .75rem;">
                        <div style="width:56px;height:56px;border-radius:50%;background:rgba(0,0,0,.05);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            <svg style="width:26px;height:26px;color:rgba(0,0,0,.22);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 style="font-size:1rem;font-weight:700;color:#111111;margin-bottom:.3rem;">Nothing found</h3>
                        <p style="font-size:.83rem;color:rgba(0,0,0,.38);margin-bottom:1rem;">Try a different category.</p>
                        <a href="<?php echo e(route('products.index')); ?>" style="display:inline-flex;align-items:center;padding:.55rem 1.25rem;background:#C8102E;color:#fff;font-weight:700;font-size:.83rem;border-radius:99px;text-decoration:none;">
                            View All Items
                        </a>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                
                <div class="cart-sidebar" x-data>
                    
                    <div class="cs-head">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span class="cs-title">Your Order</span>
                            <span x-show="$store.cart.itemCount > 0" x-cloak
                                  style="font-size:.72rem;color:rgba(0,0,0,.4);font-weight:600;"
                                  x-text="$store.cart.itemCount + ' item' + ($store.cart.itemCount !== 1 ? 's' : '')"></span>
                        </div>
                    </div>

                    
                    <div class="cs-items">
                        
                        <div x-show="$store.cart.isLoading" x-cloak
                             style="display:flex;justify-content:center;padding:2rem;">
                            <svg style="width:20px;height:20px;animation:spin 1s linear infinite;color:#C8102E;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity:.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>

                        
                        <div x-show="!$store.cart.isLoading && $store.cart.items.length === 0" x-cloak class="cs-empty">
                            <svg style="width:44px;height:44px;color:rgba(0,0,0,.14);margin-bottom:.9rem;" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p style="font-size:.85rem;font-weight:600;color:rgba(0,0,0,.35);">Your basket is empty</p>
                            <p style="font-size:.76rem;color:rgba(0,0,0,.28);margin-top:.25rem;">Add items from the menu</p>
                        </div>

                        
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

                    
                    <div class="cs-footer" x-show="$store.cart.items.length > 0" x-cloak>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.8rem;">
                            <span style="font-size:.88rem;font-weight:700;color:#111111;">Sub-Total</span>
                            <span style="font-size:.95rem;font-weight:800;color:#111111;"
                                  x-text="'£' + parseFloat($store.cart.subtotal).toFixed(2)"></span>
                        </div>
                        <a href="<?php echo e(route('cart.index')); ?>"
                           style="display:block;width:100%;padding:.7rem;background:#C8102E;color:#fff;font-weight:700;font-size:.88rem;text-align:center;border-radius:.45rem;text-decoration:none;transition:background .14s;"
                           onmouseover="this.style.background='#a50e26'" onmouseout="this.style.background='#C8102E'">
                            View Basket &amp; Checkout
                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($freeThreshold): ?>
                        <p style="font-size:.7rem;color:rgba(0,0,0,.32);text-align:center;margin-top:.5rem;">
                            Free delivery on orders over <?php echo format_price($freeThreshold); ?>
                        </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        
        <a href="<?php echo e(route('cart.index')); ?>"
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

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.ga4.measurement_id') && $products->count()): ?>
    <?php
        $ga4Items = $products->getCollection()->values()->map(fn($p,$i) => [
            'item_id'       => $p->sku ?? (string) $p->id,
            'item_name'     => $p->name,
            'item_category' => $p->category?->name ?? '',
            'price'         => (float) $p->price,
            'index'         => $i,
        ]);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'view_item_list', {
                    item_list_id: 'full_menu',
                    item_list_name: 'Full Menu',
                    items: <?php echo json_encode($ga4Items, JSON_UNESCAPED_UNICODE); ?>

                });
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/products/index.blade.php ENDPATH**/ ?>