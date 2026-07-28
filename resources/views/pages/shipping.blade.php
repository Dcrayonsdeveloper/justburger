<x-layouts.app>
    <x-slot name="title">Delivery Information - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Delivery and collection information for {{ \App\Models\Setting::get('site_name', config('app.name')) }}. Order by phone, WhatsApp, or online from our Feltham takeaway.">
        <link rel="canonical" href="{{ url('/shipping') }}">
    @endpush

    <div class="bg-white text-[#222222]">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-100">
        <div class="container mx-auto px-4 py-2.5">
            <x-breadcrumb :items="[['label' => 'Delivery Info', 'url' => null]]" />
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="w-14 h-14 mx-auto rounded-full bg-[#C8102E]/5 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-1.5">Delivery & Collection</h1>
                <p class="text-[16px] text-neutral-600">How to get your food from {{ \App\Models\Setting::get('site_name', config('app.name')) }}.</p>
            </div>

            <!-- Order Options Cards -->
            <div class="mb-8">
                <p class="text-xs font-semibold text-[#C8102E] uppercase tracking-wider pb-3">How to Order</p>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-white border border-neutral-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-[#C8102E]/5 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-neutral-900">Call to Order</h3>
                                <p class="text-xs text-neutral-600 mt-0.5">Phone us directly</p>
                                <a href="tel:{{ \App\Models\Setting::get('site_phone', '+4420889 05008') }}" class="text-sm font-bold text-[#C8102E] mt-1.5 block">{{ \App\Models\Setting::get('site_phone', '+44 20889 05008') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-neutral-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.556 4.124 1.528 5.858L.058 23.708l5.97-1.442A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75c-1.9 0-3.727-.513-5.32-1.484l-.38-.227-3.546.857.896-3.453-.25-.394A9.686 9.686 0 012.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-neutral-900">WhatsApp Order</h3>
                                <p class="text-xs text-neutral-600 mt-0.5">Message us your order</p>
                                <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '447368429896') }}" target="_blank" class="text-sm font-bold text-green-600 mt-1.5 block">{{ \App\Models\Setting::get('site_mobile', '+44 7368 429 896') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-neutral-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-neutral-900">Order Online</h3>
                                <p class="text-xs text-neutral-600 mt-0.5">Browse our menu and order</p>
                                <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-600 mt-1.5 block">View Menu</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-neutral-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-neutral-900">Collection</h3>
                                <p class="text-xs text-neutral-600 mt-0.5">Pick up from our shop</p>
                                <p class="text-sm font-bold text-amber-600 mt-1.5">{{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Sections -->
            <div x-data="{ open: null }" class="space-y-3">

                <p class="text-xs font-semibold text-[#C8102E] uppercase tracking-wider pt-2 pb-1">Collection</p>

                <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                    <button @click="open = open === 1 ? null : 1"
                            class="w-full px-5 py-3.5 flex items-center justify-between text-left gap-3 hover:bg-neutral-50/50 transition-colors">
                        <span class="text-sm font-medium text-neutral-900">How does collection work?</span>
                        <svg class="w-4 h-4 text-neutral-600 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse>
                        <div class="px-5 pb-4 text-[16px] text-neutral-600 leading-relaxed border-t border-neutral-50">
                            <p class="pt-3">Place your order by phone, WhatsApp, or online. We'll prepare it fresh and let you know when it's ready. Just pop in and collect from our shop at {{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, TW14 8BP') }}.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                    <button @click="open = open === 2 ? null : 2"
                            class="w-full px-5 py-3.5 flex items-center justify-between text-left gap-3 hover:bg-neutral-50/50 transition-colors">
                        <span class="text-sm font-medium text-neutral-900">How long does my order take to prepare?</span>
                        <svg class="w-4 h-4 text-neutral-600 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse>
                        <div class="px-5 pb-4 text-[16px] text-neutral-600 leading-relaxed border-t border-neutral-50">
                            <p class="pt-3">Most orders are ready within 15-25 minutes. During busy periods (Friday and Saturday evenings), it may take a little longer. We'll always give you an estimated time when you place your order.</p>
                        </div>
                    </div>
                </div>

                <p class="text-xs font-semibold text-[#C8102E] uppercase tracking-wider pt-4 pb-1">Online Orders</p>

                <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                    <button @click="open = open === 3 ? null : 3"
                            class="w-full px-5 py-3.5 flex items-center justify-between text-left gap-3 hover:bg-neutral-50/50 transition-colors">
                        <span class="text-sm font-medium text-neutral-900">How can I track my online order?</span>
                        <svg class="w-4 h-4 text-neutral-600 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse>
                        <div class="px-5 pb-4 text-[16px] text-neutral-600 leading-relaxed border-t border-neutral-50">
                            <p class="pt-3">Once your order is confirmed, you'll receive an email confirmation. You can also log into your account and check the status in your order history. For phone/WhatsApp orders, just message or call us for an update.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                    <button @click="open = open === 4 ? null : 4"
                            class="w-full px-5 py-3.5 flex items-center justify-between text-left gap-3 hover:bg-neutral-50/50 transition-colors">
                        <span class="text-sm font-medium text-neutral-900">What payment methods do you accept?</span>
                        <svg class="w-4 h-4 text-neutral-600 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse>
                        <div class="px-5 pb-4 text-[16px] text-neutral-600 leading-relaxed border-t border-neutral-50">
                            <p class="pt-3">We accept cash and card payments in store. For online orders, we accept all major credit and debit cards (Visa, MasterCard, American Express) through our secure checkout.</p>
                        </div>
                    </div>
                </div>

                <p class="text-xs font-semibold text-[#C8102E] uppercase tracking-wider pt-4 pb-1">Issues & Support</p>

                <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                    <button @click="open = open === 5 ? null : 5"
                            class="w-full px-5 py-3.5 flex items-center justify-between text-left gap-3 hover:bg-neutral-50/50 transition-colors">
                        <span class="text-sm font-medium text-neutral-900">What if there's an issue with my order?</span>
                        <svg class="w-4 h-4 text-neutral-600 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 5" x-collapse>
                        <div class="px-5 pb-4 text-[16px] text-neutral-600 leading-relaxed border-t border-neutral-50">
                            <p class="pt-3">If anything isn't right with your order, please let us know straight away. Call us on {{ \App\Models\Setting::get('site_phone', '+44 20889 05008') }} or WhatsApp {{ \App\Models\Setting::get('site_mobile', '+44 7368 429 896') }} and we'll sort it out for you.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Still Need Help -->
            <div class="mt-10 bg-white border border-neutral-100 rounded-xl p-6 sm:p-8 text-center">
                <div class="w-11 h-11 mx-auto rounded-full bg-[#C8102E]/5 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-[15px] font-bold text-neutral-900 mb-1">Need more help?</h3>
                <p class="text-[16px] text-neutral-600 mb-4">Our team is available to assist with any questions.</p>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center px-4 py-2 bg-[#C8102E] hover:bg-[#a00d24] text-white text-sm font-semibold rounded-xl transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
    </div>
</x-layouts.app>
