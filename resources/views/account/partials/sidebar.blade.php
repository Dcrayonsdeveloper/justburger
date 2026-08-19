<aside class="lg:w-60 shrink-0">
    <nav class="bg-white border border-neutral-100 rounded-xl p-3 space-y-0.5">
        <a href="{{ route('account.dashboard') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[16px] font-medium {{ request()->routeIs('account.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }} transition-colors">
            <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('account.orders.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[16px] font-medium {{ request()->routeIs('account.orders*') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }} transition-colors">
            <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            My Orders
        </a>

        {{-- No Addresses (orders are collected), Returns or My Reviews links:
             the routes still exist, they are simply not surfaced here. --}}

        @if(\App\Models\Setting::get('support_tickets_enabled', true))
        <a href="{{ route('account.tickets.index') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[16px] font-medium {{ request()->routeIs('account.tickets*') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }} transition-colors">
            <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            Raise Ticket
        </a>
        @endif

        <div class="pt-3 mt-3 border-t border-neutral-100">
            <a href="{{ route('account.profile') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[16px] font-medium {{ request()->routeIs('account.profile') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }} transition-colors">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile Settings
            </a>

            <a href="{{ route('account.notifications') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[16px] font-medium {{ request()->routeIs('account.notifications') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900' }} transition-colors">
                <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifications
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="flex items-center gap-2.5 px-3 py-2 rounded-lg w-full text-left text-[16px] font-medium text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900 transition-colors">
                    <svg class="w-4.5 h-4.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</aside>
