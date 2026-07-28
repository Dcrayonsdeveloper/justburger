<x-layouts.app>
    <x-slot name="title">Offers & Deals - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Exclusive offers and deals at {{ \App\Models\Setting::get('site_name', config('app.name')) }}. Lunchtime deals, family meals, and special discounts on charbroiled burgers in Feltham.">
        <link rel="canonical" href="{{ url('/offers') }}">
    @endpush

    <!-- Hero -->
    <section class="relative overflow-hidden bg-[#111111] py-14 lg:py-20">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/banners/banner1.webp') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#111111]/80 to-[#111111]"></div>
        <div class="container mx-auto px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold uppercase tracking-tight leading-none mb-4 -rotate-2">
                    <span class="flex flex-col items-center [&>span]:bg-[#C8102E]">
                        <span class="inline-block px-3 py-1 text-white rounded-xl">Offers &</span>
                        <span class="inline-block px-3 py-1 text-white rounded-xl -mt-0.5">Deals</span>
                    </span>
                </h1>
                <p class="text-base text-white/60 max-w-md mx-auto">Great food at great prices. Check out our current offers below.</p>
            </div>
        </div>
    </section>

    <!-- Offers -->
    <section class="bg-[#111111] py-12 lg:py-20">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="grid gap-8 max-w-4xl mx-auto">

                <!-- OFFER 1: Lunchtime Deal -->
                <div class="bg-[#231A17] rounded-2xl overflow-hidden border border-white/5">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <div class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-2xl bg-[#C8102E]/10 flex items-center justify-center text-4xl lg:text-5xl">
                                🍔
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-[#C8102E]">Daily Deal</span>
                                    <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-500/20 text-green-400">Available Now</span>
                                </div>
                                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Lunchtime Deal &mdash; Burger & Fries Only £5.50</h2>
                                <p class="text-sm text-white/60 mb-4">Available every day during lunch hours. Choose any regular burger with a portion of fries for just £5.50. The perfect quick lunch.</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-[#C8102E] hover:bg-[#a00d24] transition-colors">
                                    View Menu
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OFFER 2: Family Meal Deal -->
                <div class="bg-[#231A17] rounded-2xl overflow-hidden border border-white/5">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <div class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-2xl bg-amber-500/10 flex items-center justify-center text-4xl lg:text-5xl">
                                👨‍👩‍👧‍👦
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-amber-600">Best Value</span>
                                </div>
                                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Family Meal Deals</h2>
                                <p class="text-sm text-white/60 mb-4">Feed the whole family with our Family Meal combos. Burgers, chicken strips, fries, drinks and more &mdash; all at a great price. Check our Family Meals section on the menu.</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 transition-colors">
                                    View Family Meals
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OFFER 3: WhatsApp Ordering -->
                <div class="bg-[#231A17] rounded-2xl overflow-hidden border border-white/5">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <div class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-2xl bg-green-500/10 flex items-center justify-center text-4xl lg:text-5xl">
                                📱
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-green-600">Easy Ordering</span>
                                </div>
                                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Order via WhatsApp</h2>
                                <p class="text-sm text-white/60 mb-4">Skip the queue! Send us your order on WhatsApp and we'll have it ready for collection when you arrive. Quick, easy, and no waiting around.</p>
                                <div class="flex flex-wrap gap-3">
                                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '447368429896') }}?text={{ urlencode('Hi! I\'d like to place an order please.') }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-[#25D366] hover:bg-[#20BD5A] transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.556 4.124 1.528 5.858L.058 23.708l5.97-1.442A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75c-1.9 0-3.727-.513-5.32-1.484l-.38-.227-3.546.857.896-3.453-.25-.394A9.686 9.686 0 012.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75z"/></svg>
                                        WhatsApp Order
                                    </a>
                                    <a href="tel:{{ \App\Models\Setting::get('site_phone', '+4420889 05008') }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold text-white border border-white/20 hover:bg-white/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        Call {{ \App\Models\Setting::get('site_phone', '+44 20889 05008') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OFFER 4: Kids Eat for Less -->
                <div class="bg-[#231A17] rounded-2xl overflow-hidden border border-white/5">
                    <div class="p-6 lg:p-8">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <div class="flex-shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-2xl bg-purple-500/10 flex items-center justify-center text-4xl lg:text-5xl">
                                🧒
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-purple-600">Kids Menu</span>
                                </div>
                                <h2 class="text-xl lg:text-2xl font-bold text-white mb-2">Kids Meals from £4.00</h2>
                                <p class="text-sm text-white/60 mb-4">Tasty meals just for the little ones. Kids Nuggets or Kids Burger with fries and a drink &mdash; starting from just £4.00. Proper food at pocket-friendly prices.</p>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 transition-colors">
                                    View Kids Menu
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
