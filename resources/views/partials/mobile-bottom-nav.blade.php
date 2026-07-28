<!-- Mobile Bottom Navigation -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-[#111111] border-t border-white/10 z-40 safe-area-inset-bottom">
    <div class="flex items-center justify-around h-16">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 px-3 py-2 {{ request()->routeIs('home') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>

        <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-1 px-3 py-2 {{ request()->routeIs('products.*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span class="text-xs font-medium">Menu</span>
        </a>

        <a href="{{ route('products.index') }}" class="flex flex-col items-center gap-1 px-3 py-2 {{ request()->routeIs('products.*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="text-xs font-medium">Order</span>
        </a>

        <a href="{{ route('cart.index') }}" x-data class="flex flex-col items-center gap-1 px-3 py-2 relative {{ request()->routeIs('cart*') ? 'text-[#C8102E]' : 'text-white/60' }}">
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

        <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}" class="flex flex-col items-center gap-1 px-3 py-2 {{ request()->routeIs('account.*') ? 'text-[#C8102E]' : 'text-white/60' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-xs font-medium">Account</span>
        </a>
    </div>
</nav>

<!-- Bottom nav padding is handled in app.css with safe-area-inset support -->
