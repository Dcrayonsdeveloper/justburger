<x-layouts.app>
    <x-slot name="title">FAQ - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Frequently asked questions about {{ \App\Models\Setting::get('site_name', config('app.name')) }}. Find answers about ordering, collection, delivery, and more.">
        <link rel="canonical" href="{{ url('/faq') }}">
        <meta property="og:title" content="FAQ - {{ \App\Models\Setting::get('site_name', config('app.name')) }}">
        <meta property="og:description" content="Frequently asked questions about {{ \App\Models\Setting::get('site_name', config('app.name')) }}. Find answers about ordering, collection, delivery, and more.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/faq') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="FAQ - {{ \App\Models\Setting::get('site_name', config('app.name')) }}">
        <meta name="twitter:description" content="Find answers about ordering, collection, delivery, and more at {{ \App\Models\Setting::get('site_name', config('app.name')) }}.">

        @php
            $faqPhone = \App\Models\Setting::get('site_phone', '02088905008');
            $faqMobile = \App\Models\Setting::get('site_mobile', '07368998035');
            $faqAddress = \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middlesex, TW14 8BP');
            $faqHoursMon = \App\Models\Setting::get('hours_monday', '12:00 - 10:00 PM');
            $faqHoursFri = \App\Models\Setting::get('hours_friday', '11:45 AM - 11:00 PM');
            $faqHoursSun = \App\Models\Setting::get('hours_sunday', '4:00 - 10:00 PM');
        @endphp
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                ['@type' => 'Question', 'name' => 'How do I place an order?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => "You can order by calling us on {$faqPhone}, messaging us on WhatsApp at {$faqMobile}, or ordering online through our website. We'll prepare your food fresh and have it ready for collection."]],
                ['@type' => 'Question', 'name' => 'What payment methods do you accept?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'We accept cash and card payments in store. For online orders, we accept all major credit and debit cards (Visa, MasterCard, American Express) through our secure checkout.']],
                ['@type' => 'Question', 'name' => 'How long does my order take?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => "Most orders are ready within 15-25 minutes. During busy periods (Friday and Saturday evenings), it may take a little longer. We'll always give you an estimated time."]],
                ['@type' => 'Question', 'name' => 'Where are you located?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => "We are at {$faqAddress}. We have no other branch."]],
                ['@type' => 'Question', 'name' => 'What are your opening hours?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => "Monday to Thursday: {$faqHoursMon}, Friday to Saturday: {$faqHoursFri}, Sunday: {$faqHoursSun}."]],
                ['@type' => 'Question', 'name' => "What if there's an issue with my order?", 'acceptedAnswer' => ['@type' => 'Answer', 'text' => "If anything isn't right with your order, please let us know straight away by calling {$faqPhone} or WhatsApp {$faqMobile} and we'll sort it out."]],
                ['@type' => 'Question', 'name' => 'How do I create an account?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Click the Sign Up button at the top of the page and fill in your details. You can also create an account during checkout. Having an account allows you to track orders and save your details.']],
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <!-- Hero -->
    <section style="background:#111111" class="bg-[#111111] py-16 lg:py-24">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white uppercase tracking-tight leading-tight mb-4">
                    Frequently Asked <span class="text-[#C8102E]">Questions</span>
                </h1>
                <p class="text-[16px] text-white/50 max-w-md mx-auto leading-relaxed">Everything you need to know about ordering, delivery, and dining with us.</p>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section style="background:#111111" class="bg-[#111111] pb-16 lg:pb-24">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mx-auto" x-data="{ open: null }">

                <!-- Section: Ordering -->
                <div class="mb-10">
                    <h2 class="text-xs font-bold text-[#C8102E] uppercase tracking-[.2em] mb-5 flex items-center gap-2">
                        <span class="w-6 h-px bg-[#C8102E]"></span>
                        Ordering
                    </h2>

                    <div class="space-y-3">
                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 1 ? null : 1"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">How do I place an order?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 1" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">You can order in three ways: call us on {{ \App\Models\Setting::get('site_phone', '02088905008') }}, message us on WhatsApp at {{ \App\Models\Setting::get('site_mobile', '07368998035') }}, or order online through our website. We'll prepare your food fresh and have it ready for collection.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 2 ? null : 2"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">What payment methods do you accept?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 2" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">We accept cash and card payments in store. For online orders, we accept all major credit and debit cards (Visa, MasterCard, American Express) through our secure checkout.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 3 ? null : 3"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">How long does my order take?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 3" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">Most orders are ready within 15-25 minutes. During busy periods (Friday and Saturday evenings), it may take a little longer. We'll always give you an estimated time when you place your order.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Our Shop -->
                <div class="mb-10">
                    <h2 class="text-xs font-bold text-[#C8102E] uppercase tracking-[.2em] mb-5 flex items-center gap-2">
                        <span class="w-6 h-px bg-[#C8102E]"></span>
                        Our Shop
                    </h2>

                    <div class="space-y-3">
                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 4 ? null : 4"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">Where are you located?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 4" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">We are at {{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP') }}. We have no other branch — this is our only location, and we've been here since 1989.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 5 ? null : 5"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">What are your opening hours?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 5" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">Monday to Thursday: {{ \App\Models\Setting::get('hours_monday', '12:00 – 10:00 PM') }}<br>
                                    Friday to Saturday: {{ \App\Models\Setting::get('hours_friday', '11:45 AM – 11:00 PM') }}<br>
                                    Sunday: {{ \App\Models\Setting::get('hours_sunday', '4:00 – 10:00 PM') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Issues & Refunds -->
                <div class="mb-10">
                    <h2 class="text-xs font-bold text-[#C8102E] uppercase tracking-[.2em] mb-5 flex items-center gap-2">
                        <span class="w-6 h-px bg-[#C8102E]"></span>
                        Issues & Refunds
                    </h2>

                    <div class="space-y-3">
                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 6 ? null : 6"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">What if there's an issue with my order?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 6 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 6" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">If anything isn't right with your order, please let us know straight away. Call us on {{ \App\Models\Setting::get('site_phone', '02088905008') }} or WhatsApp {{ \App\Models\Setting::get('site_mobile', '07368998035') }} and we'll sort it out for you. Your satisfaction is our priority.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 7 ? null : 7"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">How do I request a refund?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 7 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 7" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">For online orders, log into your account, go to your Orders, and select the order in question. For phone/WhatsApp orders, contact us directly. As food is perishable, please report any issues on the same day. We'll process refunds within 5-7 business days.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Account -->
                <div class="mb-12">
                    <h2 class="text-xs font-bold text-[#C8102E] uppercase tracking-[.2em] mb-5 flex items-center gap-2">
                        <span class="w-6 h-px bg-[#C8102E]"></span>
                        Account
                    </h2>

                    <div class="space-y-3">
                        <div class="rounded-xl overflow-hidden" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                            <button @click="open = open === 8 ? null : 8"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left gap-4 hover:bg-white/[.03] transition-colors">
                                <span class="text-[16px] font-bold text-white">How do I create an account?</span>
                                <svg class="w-5 h-5 text-white/30 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open === 8 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open === 8" x-collapse>
                                <div class="px-6 pb-6 text-[16px] text-white/55 leading-relaxed" style="border-top:1px solid rgba(255,255,255,.06)">
                                    <p class="pt-5">Click the "Sign Up" button at the top of the page and fill in your details. You can also create an account during checkout. Having an account allows you to track orders and save your details for faster ordering next time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Need Help -->
                <div class="rounded-2xl p-8 sm:p-10 text-center" style="background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06)">
                    <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-5" style="background:rgba(200,16,46,.1)">
                        <svg class="w-7 h-7 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Still have questions?</h3>
                    <p class="text-[16px] text-white/45 mb-6">Can't find what you're looking for? We're here to help.</p>
                    <a href="{{ route('contact') }}"
                       class="inline-block bg-[#C8102E] hover:bg-[#A50E26] text-white text-[16px] font-bold rounded-xl px-8 py-3.5 transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
