<x-layouts.app>
    <x-slot name="title">Blog - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Read the latest articles, tips, and guides about trending products and smart shopping at {{ \App\Models\Setting::get('site_name', config('app.name')) }} blog.">
        <link rel="canonical" href="{{ url('/blog') }}">
        <meta property="og:title" content="Blog - {{ \App\Models\Setting::get('site_name', config('app.name')) }}">
        <meta property="og:description" content="Read the latest articles, tips, and guides about trending products and smart shopping at {{ \App\Models\Setting::get('site_name', config('app.name')) }}.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/blog') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Blog - {{ \App\Models\Setting::get('site_name', config('app.name')) }}">
        <meta name="twitter:description" content="Latest articles about trending products and smart shopping at {{ \App\Models\Setting::get('site_name', config('app.name')) }}.">
    @endpush

    <!-- Hero -->
    <section class="relative overflow-hidden bg-[#1A1210] py-14 lg:py-20">
        <div class="absolute inset-0 bg-cover bg-center opacity-15" style="background-image: url('{{ asset('images/banners/banner1.webp') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#1A1210]/80 to-[#1A1210]"></div>
        <div class="container mx-auto px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold uppercase tracking-tight leading-none mb-4 -rotate-2">
                    <span class="flex flex-col items-center [&>span]:bg-[#C8102E]">
                        <span class="inline-block px-3 py-1 text-white rounded-xl">Our</span>
                        <span class="inline-block px-3 py-1 text-white rounded-xl -mt-0.5">Blog</span>
                    </span>
                </h1>
                <p class="text-base text-white/60 max-w-md mx-auto">Food tips, recipes, and the latest trends — straight from our kitchen.</p>
            </div>
        </div>
    </section>

    <!-- Search & Filters -->
    <section class="bg-[#1A1210] pb-6">
        <div class="container mx-auto px-6 lg:px-8">
            <form method="GET">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-6">
                    <div class="relative w-full sm:w-80">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search posts..."
                               class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-lg text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#C8102E]">
                    </div>
                    @if(request('search'))
                        <button type="submit" class="px-5 py-3 bg-[#C8102E] text-white text-sm font-bold rounded-lg hover:bg-[#A50E26] transition-colors">
                            Search
                        </button>
                    @endif
                </div>

                @if($categories->count())
                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                        <a href="{{ route('blog') }}"
                           class="px-5 py-2 rounded-lg text-sm font-bold transition-colors {{ !request('category') ? 'bg-[#C8102E] text-white' : 'bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10' }}">
                            All Posts
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog', ['category' => $cat]) }}"
                               class="px-5 py-2 rounded-lg text-sm font-bold transition-colors {{ request('category') === $cat ? 'bg-[#C8102E] text-white' : 'bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Posts Grid -->
    <section class="bg-[#1A1210] py-8 lg:py-12">
        <div class="container mx-auto px-6 lg:px-8">
            @if($posts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach($posts as $post)
                        <article class="bg-[#231A17] rounded-2xl overflow-hidden border border-white/5 hover:border-white/10 transition-all duration-200 group flex flex-col">
                            {{-- Image --}}
                            <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-video overflow-hidden shrink-0">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    @php
                                        $gradients = [
                                            'from-[#C8102E]/30 to-[#1A1210]',
                                            'from-[#8B5CF6]/30 to-[#1A1210]',
                                            'from-[#059669]/30 to-[#1A1210]',
                                            'from-[#F59E0B]/30 to-[#1A1210]',
                                            'from-[#3B82F6]/30 to-[#1A1210]',
                                        ];
                                        $gradient = $gradients[crc32($post->title) % count($gradients)];
                                    @endphp
                                    <div class="w-full h-full bg-gradient-to-br {{ $gradient }} flex items-center justify-center p-5 group-hover:scale-105 transition-transform duration-300">
                                        <div class="text-center">
                                            <div class="w-10 h-10 mx-auto mb-3 rounded-full bg-white/10 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                            </div>
                                            <p class="text-white font-bold text-sm leading-snug line-clamp-3 px-2">{{ $post->title }}</p>
                                        </div>
                                    </div>
                                @endif
                            </a>

                            {{-- Content --}}
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    @if($post->category)
                                        <span class="text-[11px] font-bold text-[#C8102E] uppercase tracking-wide">{{ $post->category }}</span>
                                        <span class="text-white/20">·</span>
                                    @endif
                                    <span class="text-[11px] text-white/40">{{ $post->reading_time }} min read</span>
                                </div>

                                <h2 class="font-bold text-white mb-2 line-clamp-2 group-hover:text-[#C8102E] transition-colors text-base leading-snug flex-1">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>

                                @if($post->excerpt)
                                    <p class="text-sm text-white/50 line-clamp-2 mb-4 leading-relaxed">{{ $post->excerpt }}</p>
                                @endif

                                <div class="flex items-center justify-between pt-4 border-t border-white/5 mt-auto">
                                    <span class="text-xs text-white/30">
                                        {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}
                                    </span>
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                       class="text-sm font-bold text-[#C8102E] hover:underline inline-flex items-center gap-1">
                                        Read more
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($posts->hasPages())
                    <div class="flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @endif

            @else
                <div class="text-center py-20">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">No posts found</h3>
                    <p class="text-sm text-white/50">
                        @if(request('search') || request('category'))
                            No posts match your search. <a href="{{ route('blog') }}" class="text-[#C8102E] hover:underline font-bold">Clear filters</a>
                        @else
                            Check back soon for our latest articles.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
