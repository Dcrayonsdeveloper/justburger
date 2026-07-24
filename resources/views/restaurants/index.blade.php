<x-layouts.app>
    @php
        $brandColor = \App\Models\Setting::get('brand_primary_color', '#C8102E');
    @endphp

    <x-slot name="title">{{ \App\Models\Setting::get('restaurants_page_title', 'Restaurants') }} - {{ config('app.name') }}</x-slot>

    {{-- Hero Section --}}
    <div class="relative" style="background:#1a1a1a;min-height:340px;">
        @if($heroImage = \App\Models\Setting::get('restaurants_hero_image'))
            <img src="{{ $heroImage }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-60">
        @endif
        <div class="relative flex flex-col items-center justify-center text-center px-5" style="min-height:340px;">
            <h1 style="font-family:'Playfair Display',Georgia,serif;font-style:italic;font-weight:700;font-size:clamp(32px,5vw,52px);color:#fff;">
                {{ \App\Models\Setting::get('restaurants_hero_heading', 'Find a JustBurgers near you') }}
            </h1>
            <p class="text-base mt-3" style="color:rgba(255,255,255,0.8);max-width:480px;">
                {{ \App\Models\Setting::get('restaurants_hero_subtext', 'Enter a postcode or town to find your nearest restaurant') }}
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('restaurants') }}" method="GET" class="w-full mt-6" style="max-width:540px;">
                <div class="flex">
                    <div class="relative flex-1">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        </span>
                        <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="e.g. Delhi, 110001" class="w-full pl-12 pr-4 py-3.5 border-2 border-r-0 border-neutral-300 rounded-l-lg text-base focus:outline-none" style="background:#fff;" autocomplete="off">
                    </div>
                    <button type="submit" class="px-8 py-3.5 font-bold text-base text-white rounded-r-lg transition-colors" style="background:{{ $brandColor }};">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Results --}}
    <div style="background:#f7f3ef;min-height:50vh;padding:40px 0 60px;">
        <div class="container mx-auto px-5 lg:px-8">

            @if($stores->isEmpty())
                <div class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    <p class="text-lg font-semibold text-neutral-700">No restaurants found</p>
                    @if($search)
                        <p class="text-base text-neutral-500 mt-1">Try a different search term</p>
                    @else
                        <p class="text-base text-neutral-500 mt-1">Restaurants will appear here once added</p>
                    @endif
                </div>
            @else
                {{-- Grouped by City --}}
                @foreach($grouped as $city => $cityStores)
                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" style="padding:40px 0 32px;{{ !$loop->last ? 'border-bottom:1px solid #ddd;' : '' }}">

                        {{-- City Heading --}}
                        <h2 style="font-family:'Playfair Display',Georgia,serif;font-weight:900;font-style:italic;font-size:clamp(30px,4vw,48px);line-height:1;color:#1a1a1a;margin:0 0 10px;">{{ $city }}</h2>
                        <p class="text-base" style="color:#555;max-width:800px;line-height:1.6;">
                            {{ \App\Models\Setting::get('restaurants_city_desc_' . Str::slug($city), 'Visit our JustBurgers in ' . $city . '. Fresh, flame-grilled burgers delivered to your door or ready for pickup. We\'re open for Eat-In, Collect and Delivery.') }}
                        </p>

                        {{-- Toggle --}}
                        <button @click="open = !open" class="flex items-center gap-1.5 text-sm font-semibold" style="color:#1a1a1a;margin:14px 0 0;">
                            <span x-text="open ? 'Hide restaurants' : 'Show restaurants'"></span>
                            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/></svg>
                        </button>

                        {{-- Store Cards Grid --}}
                        <div x-show="open" x-collapse style="margin-top:20px;">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3" style="gap:16px;">
                                @foreach($cityStores as $store)
                                    <div class="bg-white" style="border:1px solid #e0dbd5;padding:24px;">

                                        {{-- Store Name --}}
                                        <h3 class="font-bold" style="color:#1a1a1a;font-size:17px;margin:0;">{{ $store->name }}</h3>

                                        {{-- Dotted Separator --}}
                                        <div style="border-bottom:2px dotted #ccc;margin:14px 0;"></div>

                                        {{-- Address Block --}}
                                        <div style="color:#333;font-size:16px;line-height:1.7;">
                                            @if($store->address)
                                                <p style="margin:0;">{{ $store->address }}</p>
                                            @endif
                                            @if($store->city)
                                                <p style="margin:0;">{{ $store->city }}</p>
                                            @endif
                                            @if($store->postal_code)
                                                <p class="flex items-center gap-1" style="margin:0;">
                                                    {{ $store->postal_code }}
                                                    <svg class="w-3 h-3" style="color:#888;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                                </p>
                                            @endif
                                            @if($store->phone)
                                                <p class="font-bold" style="margin:6px 0 0;">
                                                    <a href="tel:{{ $store->phone }}" class="underline hover:no-underline" style="color:#1a1a1a;">{{ $store->phone }}</a>
                                                </p>
                                            @endif
                                        </div>

                                        {{-- View Details Link --}}
                                        <a href="{{ route('restaurants.show', $store) }}" class="inline-flex items-center gap-1.5 font-bold" style="color:#1a1a1a;font-size:16px;margin-top:16px;">
                                            View full restaurant details
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-layouts.app>
