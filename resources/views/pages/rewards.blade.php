<x-layouts.app>
    <x-slot name="title">Rewards - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Join {{ \App\Models\Setting::get('site_name', config('app.name')) }} Rewards and get free food, fast. Collect stamps every time you order and unlock delicious rewards.">
        <link rel="canonical" href="{{ url('/rewards') }}">
    @endpush

    <!-- Hero (outside white wrapper — dark body bg matches hero overlay) -->
    <section class="relative overflow-hidden flex items-center justify-center" style="min-height:540px;">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/banners/banner1.webp') }}');"></div>
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center px-6" style="padding:90px 24px;">
            <p class="text-lg sm:text-xl text-white font-medium mb-4">Get more of the good stuff with</p>
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold uppercase tracking-tight leading-none mb-5 -rotate-3">
                <span class="flex flex-col items-center [&>span]:bg-[#C8102E]">
                    <span class="inline-block px-3 py-1 text-white rounded-xl">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</span>
                    <span class="inline-block px-3 py-1 text-white rounded-xl -mt-0.5">Rewards</span>
                </span>
            </h1>
            <div class="flex flex-col items-center gap-1 mb-10">
                <span class="text-lg sm:text-xl text-white font-bold">Join now and get free food, fast.</span>
                <span class="text-lg sm:text-xl text-white font-bold">It's as easy as 1, 2, 3.</span>
            </div>
            <div class="flex items-center justify-center gap-3">
                @auth
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center bg-[#1A1210] text-white px-7 py-3 text-sm font-bold border-2 border-[#1A1210] hover:bg-black transition-colors">
                        Start Ordering
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#1A1210] text-white px-7 py-3 text-sm font-bold border-2 border-[#1A1210] hover:bg-black transition-colors">
                        Join Now
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-white text-[#1A1210] px-7 py-3 text-sm font-bold border-2 border-[#1A1210] hover:bg-neutral-50 transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <div class="bg-white text-[#1A1210]">

        <!-- Rewards Your Way -->
        <section style="padding:40px 0 44px;">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#1A1210] mb-5" style="font-family:'Playfair Display',serif;font-style:italic;">Rewards your way</h2>

                    <p class="text-sm sm:text-base text-neutral-700 leading-relaxed mb-2">
                        Once you've got them, it's up to you how to use them. Stick with your go-to or mix things up and try something new.
                    </p>
                    <p class="text-sm sm:text-base text-neutral-700 leading-relaxed mb-2">
                        Use them when and where you want &mdash; whether you're ordering online, by phone, or via WhatsApp. You've got the power.
                    </p>
                    <p class="text-sm sm:text-base text-neutral-700 leading-relaxed mb-5">
                        Sign up today and start collecting so you can get more of the good stuff.
                    </p>

                    @auth
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center bg-[#1A1210] text-white px-8 py-3.5 text-sm font-bold border-2 border-[#1A1210] hover:bg-black transition-colors">
                            Start Ordering
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#1A1210] text-white px-8 py-3.5 text-sm font-bold border-2 border-[#1A1210] hover:bg-black transition-colors">
                            Join Now
                        </a>
                    @endauth
                </div>
            </div>
        </section>

    </div>
</x-layouts.app>
