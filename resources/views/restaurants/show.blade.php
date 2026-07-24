<x-layouts.app>
    @php
        $brandColor = \App\Models\Setting::get('brand_primary_color', '#C8102E');
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $todayName = now()->format('l');
    @endphp

    <x-slot name="title">{{ $store->name }} - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    {{-- Hero: Dark header with store info + hours --}}
    <div style="background:#1a1a1a;color:#fff;">
        <div class="container mx-auto px-5 lg:px-8" style="padding:48px 0 56px;">
            <div class="grid grid-cols-1 lg:grid-cols-2" style="gap:40px;">

                {{-- Left: Store Info --}}
                <div style="padding:0 20px;">
                    <h1 style="font-family:'Barlow',sans-serif;font-weight:900;font-size:clamp(32px,5vw,52px);line-height:1;margin:0 0 24px;">{{ $store->name }}</h1>

                    <div style="font-size:16px;line-height:1.8;color:rgba(255,255,255,0.85);">
                        @if($store->address)<p style="margin:0;">{{ $store->address }}</p>@endif
                        @if($store->city)<p style="margin:0;">{{ $store->city }},</p>@endif
                        @if($store->postal_code)<p style="margin:0;">{{ $store->postal_code }}</p>@endif
                    </div>

                    @if($store->phone)
                        <p class="font-bold" style="font-size:16px;margin:12px 0 0;">{{ $store->phone }}</p>
                    @endif

                    @if($hours)
                        @php
                            $todayHours = $hours[strtolower($todayName)] ?? null;
                        @endphp
                        @if($todayHours)
                            <span class="inline-block font-bold" style="background:{{ $brandColor }};color:#fff;padding:4px 14px;font-size:var(--text-body-sm);margin-top:14px;">
                                {{ $todayHours }}
                            </span>
                        @endif
                    @endif

                    @if($store->email)
                        <p style="font-size:16px;color:rgba(255,255,255,0.6);margin-top:10px;">{{ $store->email }}</p>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3" style="margin-top:24px;">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 font-bold text-sm" style="border:2px solid #fff;color:#fff;padding:10px 24px;">
                            Order Now
                        </a>
                        @if($store->phone)
                            <a href="tel:{{ $store->phone }}" class="inline-flex items-center gap-2 font-bold text-sm" style="border:2px solid rgba(255,255,255,0.3);color:#fff;padding:10px 24px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                                Call Us
                            </a>
                        @endif
                    </div>

                    {{-- Facilities --}}
                    @if(!empty($facilities))
                        <div class="flex flex-wrap gap-4" style="margin-top:28px;">
                            @foreach($facilities as $facility)
                                <div class="flex flex-col items-center gap-2" style="width:60px;">
                                    <div class="flex items-center justify-center" style="width:44px;height:44px;border-radius:50%;border:1.5px solid rgba(255,255,255,0.3);">
                                        @switch($facility)
                                            @case('wifi')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z"/></svg>
                                                @break
                                            @case('delivery')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0H21M3.375 14.25h3.75m0 0V5.625m0 8.625h6.375M7.125 5.625h9.75a1.125 1.125 0 0 1 1.125 1.125v3h1.5a1.5 1.5 0 0 1 1.28.72l1.35 2.16a1.5 1.5 0 0 1 .22.78v3.24"/></svg>
                                                @break
                                            @case('parking')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3H6v18h4v-6h3c3.31 0 6-2.69 6-6s-2.69-6-6-6zm.2 8H10V7h3.2c1.1 0 2 .9 2 2s-.9 2-2 2z"/></svg>
                                                @break
                                            @case('wheelchair')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="4.5" r="1.5"/><path d="M9 8h4.5l1.5 6H9l-1.5 6"/><circle cx="9" cy="19.5" r="1.5"/><circle cx="15" cy="19.5" r="1.5"/></svg>
                                                @break
                                            @case('outdoor')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                                                @break
                                            @case('dine_in')
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m18-4.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                                @break
                                            @default
                                                <svg class="w-5 h-5" style="color:#fff;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                        @endswitch
                                    </div>
                                    <span style="font-size:10px;color:rgba(255,255,255,0.5);text-align:center;line-height:1.2;">{{ ucfirst(str_replace('_', ' ', $facility)) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Right: Opening Hours --}}
                @if($hours)
                    <div style="padding:0 20px;">
                        <table style="width:100%;border-collapse:collapse;">
                            @foreach($days as $day)
                                @php $key = strtolower($day); @endphp
                                <tr style="border-bottom:1px solid rgba(255,255,255,0.1);{{ $day === $todayName ? 'font-weight:700;' : '' }}">
                                    <td style="padding:14px 0;font-size:16px;color:{{ $day === $todayName ? '#fff' : 'rgba(255,255,255,0.7)' }};">{{ $day }}</td>
                                    <td style="padding:14px 0;font-size:16px;text-align:right;color:{{ $day === $todayName ? '#fff' : 'rgba(255,255,255,0.7)' }};">{{ $hours[$key] ?? 'Closed' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Map Section (dark like Nando's) --}}
    <div style="background:#1a1a1a;color:#fff;">
        <div class="container mx-auto px-5 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2" style="gap:40px;padding:60px 0;">

                {{-- Nearby Text --}}
                <div style="padding:0 20px;">
                    <h2 style="font-family:'Playfair Display',Georgia,serif;font-weight:700;font-style:italic;font-size:clamp(26px,3vw,38px);line-height:1;color:#fff;margin:0 0 16px;">Nearby</h2>
                    <p style="font-size:16px;line-height:1.7;color:rgba(255,255,255,0.7);">
                        {{ \App\Models\Setting::get('restaurant_nearby_text_' . $store->id,
                            'Visit our JustBurgers at ' . $store->name . '. ' .
                            ($store->address ? 'Located at ' . $store->address . ', ' . ($store->city ?? '') . '. ' : '') .
                            'We\'re open for Eat-In, Collect and Delivery. Come grab your favourite flame-grilled burgers!'
                        ) }}
                    </p>
                </div>

                {{-- Map Embed --}}
                <div style="padding:0 20px;">
                    @php
                        $mapQuery = urlencode(implode(', ', array_filter([$store->address, $store->city, $store->state, $store->postal_code])));
                    @endphp
                    <div style="background:#ddd;min-height:300px;position:relative;overflow:hidden;">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $mapQuery }}&output=embed"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $mapQuery }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 font-bold text-sm"
                       style="background:#fff;border:2px solid #fff;color:#1a1a1a;padding:10px 20px;margin-top:16px;">
                        Map & Directions
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Work at JustBurgers --}}
    <div style="background:#1a1a1a;border-top:1px solid rgba(255,255,255,0.1);">
        <div class="container mx-auto px-5 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2" style="gap:0;">
                {{-- Left: Image --}}
                <div style="min-height:360px;background:#2a2a2a;overflow:hidden;">
                    <img src="{{ \App\Models\Setting::get('restaurant_work_image', asset('images/banners/our-story.jpg')) }}" alt="Work at {{ \App\Models\Setting::get('site_name', config('app.name')) }}" class="w-full h-full object-cover" loading="lazy">
                </div>

                {{-- Right: Work at text --}}
                <div class="flex flex-col items-center justify-center text-center" style="padding:50px 40px;color:#fff;">
                    <span class="inline-block font-bold text-sm" style="background:{{ $brandColor }};color:#fff;padding:4px 14px;margin-bottom:12px;">Work at</span>
                    <h2 style="font-family:'Playfair Display',Georgia,serif;font-weight:900;font-style:italic;font-size:clamp(30px,4vw,48px);line-height:1;margin:0 0 20px;">{{ \App\Models\Setting::get('site_name', config('app.name')) }}</h2>
                    <p style="font-size:16px;line-height:1.7;color:rgba(255,255,255,0.7);max-width:400px;">
                        {{ \App\Models\Setting::get('restaurant_work_text', 'Join our growing family! We care as much about our team as we do our legendary flame-grilled burgers — because it\'s the people that make the food.') }}
                    </p>
                    @php $applyUrl = \App\Models\Setting::get('restaurant_careers_url'); @endphp
                    @if($applyUrl)
                        <a href="{{ $applyUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 font-bold text-sm" style="border:2px solid #fff;color:#fff;padding:10px 24px;margin-top:20px;">
                            Apply now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Promo / Order Section --}}
    <div style="background:#1a1a1a;border-top:1px solid rgba(255,255,255,0.1);">
        <div class="container mx-auto px-5 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2" style="gap:0;">
                {{-- Left: Promo Text --}}
                <div class="flex flex-col justify-center" style="padding:50px 40px;color:#fff;">
                    <span class="inline-block font-bold text-sm self-start" style="background:{{ $brandColor }};color:#fff;padding:4px 14px;margin-bottom:12px;">
                        {{ \App\Models\Setting::get('restaurant_promo_tag', 'Love great food?') }}
                    </span>
                    <h2 style="font-family:'Playfair Display',Georgia,serif;font-weight:900;font-style:italic;font-size:clamp(28px,4vw,44px);line-height:1.1;margin:0 0 24px;">
                        {{ \App\Models\Setting::get('restaurant_promo_heading', 'Order online from ' . \App\Models\Setting::get('site_name', config('app.name'))) }}
                    </h2>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 font-bold text-sm self-start" style="border:2px solid #fff;color:#fff;padding:10px 24px;">
                        {{ \App\Models\Setting::get('restaurant_promo_button', 'Order Now') }}
                    </a>
                </div>

                {{-- Right: Image --}}
                <div style="min-height:320px;background:#2a2a2a;overflow:hidden;">
                    <img src="{{ \App\Models\Setting::get('restaurant_promo_image', asset('images/banners/banner2.webp')) }}" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" class="w-full h-full object-cover" loading="lazy">
                </div>
            </div>
        </div>
    </div>

    {{-- Back to all restaurants --}}
    <div style="background:#1a1a1a;border-top:1px solid rgba(255,255,255,0.1);padding:32px 0;">
        <div class="container mx-auto px-5 lg:px-8">
            <a href="{{ route('restaurants') }}" class="inline-flex items-center gap-2 font-bold text-sm" style="color:rgba(255,255,255,0.7);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                Back to all restaurants
            </a>
        </div>
    </div>
</x-layouts.app>
