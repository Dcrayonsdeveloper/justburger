<!-- Mobile Bottom Navigation -->
<nav x-data class="lg:hidden fixed bottom-0 left-0 right-0 bg-[#111111] border-t border-white/10 z-40 safe-area-inset-bottom">
    <div class="flex items-stretch h-16">
        <a href="{{ url('/') }}" class="flex-1 flex flex-col items-center justify-center gap-1 py-2 {{ request()->routeIs('home') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>

        <a href="{{ route('products.index') }}" class="flex-1 flex flex-col items-center justify-center gap-1 py-2 {{ request()->routeIs('products.*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span class="text-xs font-medium">Menu</span>
        </a>

        <a href="{{ route('wishlist') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2 relative {{ request()->routeIs('wishlist*') ? 'text-[#C8102E]' : 'text-white/60' }}"
           aria-label="Wishlist">
            <span class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21.752 12.998 12 21.75l-9.752-8.752a5.25 5.25 0 1 1 7.424-7.424L12 6.9l2.328-2.326a5.25 5.25 0 1 1 7.424 7.424Z"/>
                </svg>
                <span x-show="$store.wishlist.count > 0"
                      x-text="$store.wishlist.count"
                      x-cloak
                      style="position:absolute;top:-5px;right:-7px;min-width:16px;height:16px;background:#C8102E;color:#fff;font-size:9px;font-weight:700;border-radius:99px;display:flex;align-items:center;justify-content:center;padding:0 3px;line-height:1;"></span>
            </span>
            <span class="text-xs font-medium">Wishlist</span>
        </a>

        <a href="{{ route('cart.index') }}" class="flex-1 flex flex-col items-center justify-center gap-1 py-2 relative {{ request()->routeIs('cart*') || request()->routeIs('checkout*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <span class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span x-show="$store.cart.itemCount > 0"
                      x-text="$store.cart.itemCount"
                      x-cloak
                      style="position:absolute;top:-5px;right:-7px;min-width:16px;height:16px;background:#C8102E;color:#fff;font-size:9px;font-weight:700;border-radius:99px;display:flex;align-items:center;justify-content:center;padding:0 3px;line-height:1;"></span>
            </span>
            <span class="text-xs font-medium">Order</span>
        </a>

        <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}" class="flex-1 flex flex-col items-center justify-center gap-1 py-2 {{ request()->routeIs('account.*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-xs font-medium">Account</span>
        </a>
    </div>
</nav>

<!-- Bottom nav padding is handled in app.css with safe-area-inset support -->
