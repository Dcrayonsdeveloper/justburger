<!-- Mobile Bottom Navigation -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-[#111111] border-t border-white/10 z-40 safe-area-inset-bottom">
    <div class="flex items-center justify-around h-16">
        <a href="<?php echo e(url('/')); ?>" class="flex flex-col items-center gap-1 px-3 py-2 <?php echo e(request()->routeIs('home') ? 'text-[#C8102E]' : 'text-white/60'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>

        <a href="<?php echo e(route('products.index')); ?>" class="flex flex-col items-center gap-1 px-3 py-2 <?php echo e(request()->routeIs('products.*') ? 'text-[#C8102E]' : 'text-white/60'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span class="text-xs font-medium">Menu</span>
        </a>

        <?php $waPhone = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('site_mobile', '')); ?>
        <a href="<?php echo e($waPhone ? 'https://wa.me/' . $waPhone . '?text=' . urlencode('Hi! I\'d like to place an order.') : route('products.index')); ?>"
           <?php echo e($waPhone ? 'target="_blank" rel="noopener"' : ''); ?>

           class="flex flex-col items-center gap-1 px-3 py-2 text-[#25D366]">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="text-xs font-medium">Order</span>
        </a>

        <a href="<?php echo e(route('cart.index')); ?>" x-data class="flex flex-col items-center gap-1 px-3 py-2 relative <?php echo e(request()->routeIs('cart*') ? 'text-[#C8102E]' : 'text-white/60'); ?>">
            <span class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="$store.cart.itemCount > 0"
                      x-text="$store.cart.itemCount"
                      x-cloak
                      style="position:absolute;top:-5px;right:-7px;min-width:16px;height:16px;background:#C8102E;color:#fff;font-size:9px;font-weight:700;border-radius:99px;display:flex;align-items:center;justify-content:center;padding:0 3px;line-height:1;"></span>
            </span>
            <span class="text-xs font-medium">Basket</span>
        </a>

        <a href="<?php echo e(auth()->check() ? route('account.dashboard') : route('login')); ?>" class="flex flex-col items-center gap-1 px-3 py-2 <?php echo e(request()->routeIs('account.*') ? 'text-[#C8102E]' : 'text-white/60'); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-xs font-medium">Account</span>
        </a>
    </div>
</nav>

<!-- Bottom nav padding is handled in app.css with safe-area-inset support -->
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/partials/mobile-bottom-nav.blade.php ENDPATH**/ ?>