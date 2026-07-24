<header id="main-header" x-data="{ visible: true, lastScroll: 0 }"
       x-on:scroll.window="
           let y = window.scrollY;
           if (y < 60) { visible = true }
           else if (y < lastScroll) { visible = true }
           else if (y > lastScroll + 5) { visible = false }
           lastScroll = y;
       "
       class="fixed left-0 right-0 z-40"
       :style="'top:0; transition: transform 0.3s ease; transform: translateY(' + (visible ? '0' : '-100%') + ')'">

    <!-- Main Nav Bar -->
    <div style="background-color:#111111;">
        <div class="flex items-center h-16 lg:h-[72px]">

            <!-- Left: Logo -->
            <a href="<?php echo e(url('/')); ?>" class="shrink-0 flex items-center px-5 lg:px-8" style="text-decoration:none;">
                <span style="font-family:'Anton',Impact,'Arial Black',sans-serif;font-size:1.45rem;letter-spacing:2px;text-transform:uppercase;line-height:1;white-space:nowrap;"><span style="color:#C8102E;">JUST</span><span style="color:#fff;margin-left:2px;">BURGERS</span></span>
            </a>

            <!-- Center: Navigation (desktop only) -->
            <nav class="hidden lg:flex items-center gap-0.5 flex-1 justify-center px-4">

                <!-- Menu -->
                <a href="<?php echo e(route('products.index')); ?>" class="px-4 py-2 text-[16px] text-white font-semibold tracking-wide transition-colors hover:text-white/70">Menu</a>


                <!-- Shop dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="px-4 py-2 text-[16px] text-white font-semibold tracking-wide transition-colors flex items-center gap-1.5 rounded" :class="open ? 'border border-white' : 'border border-transparent hover:text-white/70'">
                        Order
                        <svg class="w-3 h-3 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute top-full left-0 z-50 pt-0">
                        <div class="w-52 bg-white shadow-xl border-b-[3px] border-b-[#C8102E] overflow-hidden">
                            <a href="<?php echo e(route('products.index')); ?>" class="block px-5 py-3.5 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">Full Menu</a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('app.wholesale_enabled')): ?>
                                <hr class="border-neutral-100">
                                <a href="<?php echo e(route('wholesale')); ?>" class="block px-5 py-3.5 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">Wholesale</a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- About -->
                <a href="<?php echo e(route('about')); ?>" class="px-4 py-2 text-[16px] text-white font-semibold tracking-wide transition-colors hover:text-white/70">About</a>

                <!-- Help -->
                <a href="<?php echo e(route('contact')); ?>" class="px-4 py-2 text-[16px] text-white font-semibold tracking-wide transition-colors hover:text-white/70">Help</a>


            </nav>

            <!-- Right: Account + Order CTA -->
            <div class="flex items-center gap-4 lg:gap-5 ml-auto px-4 lg:px-6">

                <!-- Account icon / dropdown -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="hidden lg:flex items-center justify-center text-white hover:text-white/70 transition-colors" aria-label="Log In">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <div class="relative hidden lg:block" x-data="dropdown()">
                        <button @click="toggle()" class="flex items-center gap-2 text-white hover:text-white/70 transition-colors" aria-label="Account">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition @click.outside="close()" class="absolute right-0 mt-2 w-52 bg-white border-b-[3px] border-b-[#C8102E] shadow-xl z-50 overflow-hidden">
                            <div class="px-5 py-3 border-b border-neutral-100">
                                <div class="text-sm font-semibold text-neutral-900"><?php echo e(auth()->user()->full_name); ?></div>
                                <div class="text-xs text-neutral-500"><?php echo e(auth()->user()->email); ?></div>
                            </div>
                            <a href="<?php echo e(route('account.dashboard')); ?>" class="block px-5 py-3 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">Dashboard</a>
                            <a href="<?php echo e(route('account.orders.index')); ?>" class="block px-5 py-3 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">My Orders</a>
                            <a href="<?php echo e(route('account.profile')); ?>" class="block px-5 py-3 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">Profile Settings</a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->deliveryPartner): ?>
                                <a href="<?php echo e(route('delivery.login')); ?>" class="block px-5 py-3 text-sm text-[#C8102E] hover:bg-red-50 font-semibold transition-colors">Delivery Panel</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('account.become-delivery-partner')); ?>" class="block px-5 py-3 text-sm text-[#C8102E] hover:bg-red-50 font-semibold transition-colors">Become a Delivery Partner</a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <hr class="border-neutral-100">
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-5 py-3 text-sm text-neutral-700 hover:bg-neutral-50 hover:text-[#C8102E] transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Cart icon (desktop) -->
                <a href="<?php echo e(route('cart.index')); ?>" x-data class="hidden lg:flex items-center justify-center relative text-white hover:text-white/70 transition-colors" aria-label="Basket">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span x-show="$store.cart.itemCount > 0"
                          x-text="$store.cart.itemCount"
                          x-cloak
                          style="position:absolute;top:-8px;right:-10px;min-width:18px;height:18px;background:#C8102E;color:#fff;font-size:11px;font-weight:700;border-radius:100px;display:flex;align-items:center;justify-content:center;padding:0 4px;line-height:1;border:2px solid #111111;"></span>
                </a>

                <!-- Order Online CTA (desktop only) -->
                <a href="<?php echo e(route('products.index')); ?>" class="hidden lg:inline-flex items-center px-6 py-2.5 bg-[#C8102E] text-white text-sm font-bold rounded hover:bg-[#a00d24] transition-colors">
                    Order Online
                </a>

                <!-- Mobile menu button -->
                <button @click="$dispatch('toggle-mobile-nav')" class="lg:hidden p-1.5 text-white/80 hover:text-white" aria-label="Open menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
<div id="header-spacer"
     class="h-16 lg:h-18"
     aria-hidden="true"></div>
<script>
    (function () {
        function syncSpacer() {
            var hdr = document.getElementById('main-header');
            var spc = document.getElementById('header-spacer');
            if (hdr && spc) spc.style.height = hdr.offsetHeight + 'px';
        }
        syncSpacer();
        window.addEventListener('resize', syncSpacer);
    })();
</script>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/partials/header.blade.php ENDPATH**/ ?>