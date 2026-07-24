<x-layouts.app>
    <x-slot name="title">Careers - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Join the {{ \App\Models\Setting::get('site_name', config('app.name')) }} team in Feltham. We're always looking for passionate people who love great food.">
        <link rel="canonical" href="{{ url('/careers') }}">
    @endpush

    <!-- Hero -->
    <section class="relative overflow-hidden bg-[#1A1210] py-16 lg:py-24">
        <div class="absolute inset-0 bg-cover bg-center opacity-15" style="background-image: url('{{ asset('images/banners/our-story.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#1A1210]/80 to-[#1A1210]"></div>
        <div class="container mx-auto px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold uppercase tracking-tight leading-none mb-4 -rotate-2">
                    <span class="flex flex-col items-center [&>span]:bg-[#C8102E]">
                        <span class="inline-block px-3 py-1 text-white rounded-xl">Work</span>
                        <span class="inline-block px-3 py-1 text-white rounded-xl -mt-0.5">With Us</span>
                    </span>
                </h1>
                <p class="text-base text-white/60 max-w-md mx-auto">Join our team and help us serve the best charbroiled burgers in Feltham.</p>
            </div>
        </div>
    </section>

    <!-- No Openings + Why Join -->
    <section class="bg-[#1A1210] py-12 lg:py-20">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">

                <!-- No Openings Card -->
                <div class="bg-[#231A17] rounded-2xl p-8 sm:p-12 text-center border border-white/5 mb-12">
                    <div class="w-16 h-16 mx-auto rounded-full bg-[#C8102E]/10 flex items-center justify-center mb-5">
                        <svg class="w-8 h-8 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-3">No Open Positions Right Now</h2>
                    <p class="text-sm text-white/50 mb-6 max-w-md mx-auto">We don't have any active openings at the moment, but we're always looking for talented people. Send us your resume and we'll keep it on file.</p>

                    <div class="inline-flex items-center gap-2 bg-white/5 rounded-lg px-5 py-3 border border-white/10">
                        <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ \App\Models\Setting::get('site_email', 'hello@justburgers.com') }}" class="text-sm font-bold text-[#C8102E] hover:underline">{{ \App\Models\Setting::get('site_email', 'hello@justburgers.com') }}</a>
                    </div>
                </div>

                <!-- Why Join Us -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-[#231A17] rounded-2xl p-7 text-center border border-white/5">
                        <div class="w-12 h-12 rounded-full bg-[#C8102E]/10 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Fast-Growing Brand</h3>
                        <p class="text-xs text-white/50 leading-relaxed">Be part of a rapidly growing food brand with big ambitions.</p>
                    </div>
                    <div class="bg-[#231A17] rounded-2xl p-7 text-center border border-white/5">
                        <div class="w-12 h-12 rounded-full bg-[#C8102E]/10 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Great Team</h3>
                        <p class="text-xs text-white/50 leading-relaxed">Work alongside passionate people who love what they do.</p>
                    </div>
                    <div class="bg-[#231A17] rounded-2xl p-7 text-center border border-white/5">
                        <div class="w-12 h-12 rounded-full bg-[#C8102E]/10 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">Meaningful Work</h3>
                        <p class="text-xs text-white/50 leading-relaxed">Help bring quality, affordable food to our local community in Feltham.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
