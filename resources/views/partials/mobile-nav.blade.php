<!-- Mobile Navigation Drawer -->
<div x-data="{ open: false }"
     @toggle-mobile-nav.window="open = !open"
     @keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="lg:hidden fixed inset-0 z-50"
     role="dialog"
     aria-modal="true"
     aria-label="Navigation menu">

    <!-- Backdrop -->
    <div x-show="open"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Drawer -->
    <div x-show="open"
         x-transition:enter="transition-transform ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 w-[85vw] max-w-xs bg-[#111111] shadow-xl flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 shrink-0">
            <a href="{{ url('/') }}" class="flex items-center" style="text-decoration:none;">
                <span style="font-family:'Anton',Impact,'Arial Black',sans-serif;font-size:1.2rem;letter-spacing:2px;text-transform:uppercase;line-height:1;white-space:nowrap;"><span style="color:#C8102E;">JUST</span><span style="color:#fff;margin-left:2px;">BURGERS</span></span>
            </a>
            <button @click="open = false" class="p-2 text-white/60 hover:text-white rounded-full hover:bg-white/10 focus:outline-none" aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- User section -->
        <div class="px-5 py-4 border-b border-white/10 shrink-0">
            @guest
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 py-2.5 text-center text-sm font-bold text-white bg-[#C8102E] hover:bg-[#A50E26] rounded transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="flex-1 py-2.5 text-center text-sm font-bold text-white border border-white/20 rounded hover:bg-white/10 transition-colors">Register</a>
                </div>
            @else
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#C8102E]/20 rounded-full flex items-center justify-center shrink-0">
                        @if(auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->full_name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-sm font-bold text-[#C8102E]">{{ substr(auth()->user()->first_name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-white truncate">{{ auth()->user()->full_name }}</div>
                        <div class="text-xs text-white/40 truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            @endguest
        </div>

        <!-- Search -->
        <div class="px-5 py-3 border-b border-white/10 shrink-0">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative">
                    <svg class="w-4 h-4 text-white/40 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search products..."
                           class="w-full pl-9 pr-3 py-2.5 text-sm bg-white/5 border border-white/10 rounded text-white placeholder-white/30 focus:outline-none focus:border-[#C8102E]">
                </div>
            </form>
        </div>

        <!-- Scrollable Navigation -->
        <nav class="flex-1 overflow-y-auto">
            <div class="py-3">
                <!-- Quick Links -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors {{ request()->routeIs('home') ? 'text-[#C8102E]! bg-[#C8102E]/10 font-bold' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>

                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Our Menu
                </a>

                <a href="{{ route('restaurants') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors {{ request()->routeIs('restaurants*') ? 'text-[#C8102E]! bg-[#C8102E]/10 font-bold' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Restaurants
                </a>

                <!-- Menu Section -->
                <div class="mt-3 pt-3 border-t border-white/10">
                    <p class="px-5 py-2 text-[11px] font-bold text-white/30 uppercase tracking-widest">Our Menu</p>

                    @foreach($navCategories ?? [] as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="block px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                            {{ $cat->name }}
                        </a>
                    @endforeach

                    <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-5 py-3 text-sm text-[#C8102E] hover:bg-[#C8102E]/10 font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Full Menu
                    </a>
                </div>

                <!-- Account Links -->
                @auth
                    <div class="mt-3 pt-3 border-t border-white/10">
                        <p class="px-5 py-2 text-[11px] font-bold text-white/30 uppercase tracking-widest">My Account</p>

                        <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('account.orders.index') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            My Orders
                        </a>

                        <a href="{{ route('wishlist') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Wishlist
                        </a>

                        <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Settings
                        </a>

                        @if(auth()->user()->deliveryPartner)
                            <a href="{{ route('delivery.login') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-[#C8102E] hover:bg-[#C8102E]/10 font-bold transition-colors">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                </svg>
                                Delivery Panel
                            </a>
                        @else
                            <a href="{{ route('account.become-delivery-partner') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-[#C8102E] hover:bg-[#C8102E]/10 font-bold transition-colors">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                </svg>
                                Become Delivery Partner
                            </a>
                        @endif
                    </div>

                    <!-- Logout -->
                    <div class="mt-3 pt-3 border-t border-white/10 pb-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full px-5 py-3 text-sm text-white/40 hover:text-[#C8102E] hover:bg-[#C8102E]/10 transition-colors">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </nav>
    </div>
</div>
