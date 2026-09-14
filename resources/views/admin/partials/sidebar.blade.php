<!-- Mobile sidebar backdrop -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 z-20 lg:hidden" style="background:rgba(0,0,0,.5)"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-60 transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col" style="background:#1a1a1a">

    @php $user = auth('admin')->user(); @endphp

    <!-- Logo -->
    <div class="flex items-center h-14 px-4" style="border-bottom:1px solid rgba(255,255,255,.08)">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2" style="text-decoration:none">
            <span style="font-family:'Anton',Impact,'Arial Black',sans-serif;font-size:1.1rem;letter-spacing:2px;text-transform:uppercase;line-height:1"><span style="color:#C8102E">JUST</span><span style="color:#fff">BURGERS</span></span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 pt-3 pb-4 text-sm" style="scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.1) transparent">

        <style>
            .sb-link { transition: background .15s, color .15s; font-weight: 500; color: rgba(255,255,255,.6); }
            .sb-link:hover { background: rgba(255,255,255,.08); color: rgba(255,255,255,.9); }
            .sb-link.active { background: rgba(255,255,255,.1); color: #fff; font-weight: 600; }
            .sb-link.active:hover { background: rgba(255,255,255,.12); }
            .sb-sub { color: rgba(255,255,255,.45); }
            .sb-sub:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.8); }
            .sb-sub.active { color: #fff; font-weight: 600; }
        </style>

        @php
            $isActive = fn($patterns) => request()->routeIs(...(array)$patterns);
            $linkClass = 'sb-link flex items-center gap-3 px-2 py-1.5 rounded-lg mb-px';
            $activeClass = 'active';
            $normalClass = '';
            $subClass = 'sb-sub block px-2 py-1 rounded-md text-xs';
        @endphp

        <!-- Dashboard -->
        @if($user->canAccessSection('dashboard'))
        <a href="{{ route('admin.dashboard') }}" class="{{ $linkClass }} {{ $isActive('admin.dashboard') ? $activeClass : $normalClass }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            Dashboard
        </a>
        @endif

        <!-- Orders -->
        @if($user->canAccessSection('orders'))
        @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
        <div x-data="{ open: {{ $isActive(['admin.orders.*','admin.abandoned-checkouts']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="{{ $linkClass }} w-full text-left {{ $isActive(['admin.orders.*','admin.abandoned-checkouts']) ? $activeClass : $normalClass }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                Orders
                @if($pendingOrders > 0)
                <span class="ml-auto text-xs rounded-full px-1.5" style="background:#C8102E;color:#fff">{{ $pendingOrders }}</span>
                @endif
            </button>
            <div x-show="open" x-cloak class="ml-8 space-y-px mb-1">
                <a href="{{ route('admin.orders.index') }}" class="{{ $subClass }} {{ $isActive('admin.orders.*') ? 'active' : '' }}">All Orders</a>
                <a href="{{ route('admin.abandoned-checkouts') }}" class="{{ $subClass }} {{ $isActive('admin.abandoned-checkouts') ? 'active' : '' }}">Abandoned Checkouts</a>
            </div>
        </div>
        @endif

        <!-- Menu (Products) -->
        @if($user->canAccessSection('catalog'))
        <div x-data="{ open: {{ $isActive(['admin.products.*','admin.categories.*']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="{{ $linkClass }} w-full text-left {{ $isActive(['admin.products.*','admin.categories.*']) ? $activeClass : $normalClass }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M16.5 6V4.125a2.625 2.625 0 0 0-10.5 0V6"/></svg>
                Menu
            </button>
            <div x-show="open" x-cloak class="ml-8 space-y-px mb-1">
                <a href="{{ route('admin.products.index') }}" class="{{ $subClass }} {{ $isActive('admin.products.*') ? 'active' : '' }}">All Items</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ $subClass }} {{ $isActive('admin.categories.*') ? 'active' : '' }}">Categories</a>
            </div>
        </div>
        @endif

        <!-- Customize (toppings) -->
        @if($user->canAccessSection('catalog'))
        <a href="{{ route('admin.customize.index') }}" class="{{ $linkClass }} {{ $isActive('admin.customize.*') ? $activeClass : $normalClass }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
            Customize
        </a>
        @endif

        <!-- Customers -->
        @if($user->canAccessSection('customers'))
        <a href="{{ route('admin.customers.index') }}" class="{{ $linkClass }} {{ $isActive('admin.customers.*') ? $activeClass : $normalClass }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
            Customers
        </a>
        @endif

        <!-- Quick Actions — Discounts, Banners and the newsletter live here
             now; the Marketing hub is no longer in the menu. -->
        @if($user->canAccessSection('marketing'))
        @php
            $quickActionRoutes = ['admin.coupons.*', 'admin.flash-sales.*', 'admin.banners.*', 'admin.newsletter.*'];
        @endphp
        <div x-data="{ open: {{ $isActive($quickActionRoutes) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="{{ $linkClass }} w-full text-left {{ $isActive($quickActionRoutes) ? $activeClass : $normalClass }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                Quick Actions
            </button>
            <div x-show="open" x-cloak class="ml-8 space-y-px mb-1">
                <a href="{{ route('admin.coupons.index') }}" class="{{ $subClass }} {{ $isActive(['admin.coupons.*','admin.flash-sales.*']) ? 'active' : '' }}">Discounts</a>
                <a href="{{ route('admin.banners.index') }}" class="{{ $subClass }} {{ $isActive('admin.banners.*') ? 'active' : '' }}">Banners</a>
                <a href="{{ route('admin.newsletter.index') }}" class="{{ $subClass }} {{ $isActive('admin.newsletter.*') ? 'active' : '' }}">Newsletter</a>
            </div>
        </div>
        @endif

        <!-- Content -->
        @if($user->canAccessSection('content'))
        <div x-data="{ open: {{ $isActive(['admin.pages.*','admin.reviews.*']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="{{ $linkClass }} w-full text-left {{ $isActive(['admin.pages.*','admin.reviews.*']) ? $activeClass : $normalClass }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                Content
            </button>
            <div x-show="open" x-cloak class="ml-8 space-y-px mb-1">
                <a href="{{ route('admin.pages.index') }}" class="{{ $subClass }} {{ $isActive('admin.pages.*') ? 'active' : '' }}">Pages</a>
                <a href="{{ route('admin.reviews.index') }}" class="{{ $subClass }} {{ $isActive('admin.reviews.*') ? 'active' : '' }}">Reviews</a>
            </div>
        </div>
        @endif

        <!-- Analytics -->
        @if($user->canAccessSection('reports'))
        <a href="{{ route('admin.reports.analytics') }}" class="{{ $linkClass }} {{ $isActive('admin.reports.*') ? $activeClass : $normalClass }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
            Analytics
        </a>
        @endif

        <!-- Support -->
        @php
            $unreadEnquiries = \App\Models\Enquiry::where('status', 'new')->count();
            $openTickets = \App\Models\SupportTicket::where('status', 'open')->count();
            $supportBadge = $unreadEnquiries + $openTickets;
        @endphp
        <div x-data="{ open: {{ $isActive(['admin.enquiries.*','admin.support-tickets.*']) ? 'true' : 'false' }} }">
            <button @click="open = !open" class="{{ $linkClass }} w-full text-left {{ $isActive(['admin.enquiries.*','admin.support-tickets.*']) ? $activeClass : $normalClass }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>
                Support
                @if($supportBadge > 0)
                <span class="ml-auto text-xs rounded-full px-1.5" style="background:#C8102E;color:#fff">{{ $supportBadge }}</span>
                @endif
            </button>
            {{-- The parent badge totals both, which tells you something is waiting
                 but not which. Each child carries its own count so a glance at the
                 collapsed menu says where to go. Uses the counts already taken
                 above — no extra queries per page load. --}}
            <div x-show="open" x-cloak class="ml-8 space-y-px mb-1">
                <a href="{{ route('admin.enquiries.index') }}" class="{{ $subClass }} flex items-center {{ $isActive('admin.enquiries.*') ? 'active' : '' }}">
                    Enquiries
                    @if($unreadEnquiries > 0)
                        <span class="ml-auto text-[10px] leading-none rounded-full px-1.5 py-0.5" style="background:#C8102E;color:#fff">{{ $unreadEnquiries }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.support-tickets.index') }}" class="{{ $subClass }} flex items-center {{ $isActive('admin.support-tickets.*') ? 'active' : '' }}">
                    Tickets
                    @if($openTickets > 0)
                        <span class="ml-auto text-[10px] leading-none rounded-full px-1.5 py-0.5" style="background:#C8102E;color:#fff">{{ $openTickets }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Staff -->
        @if($user->canAccessSection('staff'))
        <div class="mt-2 pt-2" style="border-top:1px solid rgba(255,255,255,.08)">
            <a href="{{ route('admin.staff.index') }}" class="{{ $subClass }} mb-px {{ $isActive('admin.staff.*') ? 'active' : '' }}">Staff</a>
        </div>
        @endif
    </nav>

    <!-- Settings (pinned bottom) -->
    @if($user->canAccessSection('settings'))
    <div class="px-2 pb-3 pt-1" style="border-top:1px solid rgba(255,255,255,.08)">
        <a href="{{ route('admin.settings.general') }}" class="{{ $linkClass }} {{ $isActive('admin.settings.*') ? $activeClass : $normalClass }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
            Settings
        </a>
    </div>
    @endif
</aside>
