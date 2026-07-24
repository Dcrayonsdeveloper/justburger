<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

     <?php $__env->slot('title', null, []); ?> About Us - <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?> <?php $__env->endSlot(); ?>

    <?php $__env->startPush('meta'); ?>
        <meta name="description" content="<?php echo e(\App\Models\Setting::get('site_name', 'Just Burgers Plus')); ?> — charbroiled burgers in Bedfont since 1989. <?php echo e(\App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP')); ?>. We have no other branch.">
        <link rel="canonical" href="<?php echo e(url('/about')); ?>">
        <meta property="og:title" content="Our Story - <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>">
        <meta property="og:description" content="<?php echo e(\App\Models\Setting::get('site_name', 'Just Burgers Plus')); ?> — charbroiled burgers in Bedfont since 1989. We have no other branch.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo e(url('/about')); ?>">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="About Us - <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>">
        <meta name="twitter:description" content="Learn about <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?> - your go-to destination for fresh, handcrafted burgers and bold flavors.">
    <?php $__env->stopPush(); ?>

    <!-- ============================================
         HERO: OUR STORY
         ============================================ -->
    <section class="relative overflow-hidden bg-[#111111] min-h-[500px] lg:min-h-[600px] flex items-center">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('<?php echo e(asset('images/banners/banner1.webp')); ?>');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-[#111111]/50 to-transparent"></div>
        <div class="container mx-auto px-6 lg:px-8 relative z-10 py-20 lg:py-28">
            <div class="max-w-2xl">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold uppercase tracking-tight leading-none mb-6 -rotate-2">
                    <span class="flex flex-col items-start [&>span]:bg-[#C8102E]">
                        <span class="inline-block px-3 py-1 text-white rounded-xl">Our</span>
                        <span class="inline-block px-3 py-1 text-white rounded-xl -mt-0.5">Story</span>
                    </span>
                </h1>
                <p class="text-lg sm:text-xl text-white/80 max-w-lg leading-relaxed">
                    <?php echo e(\App\Models\Setting::get('about_hero_text', 'Charbroiled burgers in Feltham since 1989. We have no other branch.')); ?>

                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 z-10">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-[40px] lg:h-[60px]" fill="#111111">
                <polygon points="0,60 1440,20 1440,60"/>
            </svg>
        </div>
    </section>


    <!-- ============================================
         THE STORY
         ============================================ -->
    <section class="bg-[#111111] py-20 lg:py-28">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                <!-- Image -->
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                        <img src="<?php echo e(asset('images/banners/our-story.jpg')); ?>" alt="Our Story" class="w-full h-full object-cover" loading="lazy">
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <p class="text-xs font-bold text-[#C8102E] uppercase tracking-widest mb-4">How it started</p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white uppercase tracking-tight leading-tight mb-6">
                        Serving Feltham Since 1989
                    </h2>
                    <div class="space-y-4 text-base text-white/60 leading-relaxed">
                        <p>
                            <?php echo e(\App\Models\Setting::get('about_story_p1', 'Just Burgers Plus has been a Feltham favourite since 1989. What started as a small charbroiled burger shop on Staines Road has grown into one of the most trusted takeaways in the area — serving fresh, flame-grilled burgers to generations of loyal customers.')); ?>

                        </p>
                        <p>
                            <?php echo e(\App\Models\Setting::get('about_story_p2', 'For over 35 years, our commitment has never changed: quality ingredients, proper cooking methods, and generous portions at fair prices. Every burger is charbroiled to order — never pre-made, never microwaved.')); ?>

                        </p>
                        <p>
                            <?php echo e(\App\Models\Setting::get('about_story_p3', 'From our classic Cheese Burger to the loaded Gangsta Burger, from crispy Chicken Strips to creamy Milkshakes — everything on our menu is made with care. We have no other branch, so all our attention goes into this one shop, making sure every customer leaves happy.')); ?>

                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================================
         WHAT MAKES US SPECIAL
         ============================================ -->
    <section class="bg-[#231A17] py-20 lg:py-28">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-xs font-bold text-[#C8102E] uppercase tracking-widest mb-3">Our Promise</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white uppercase tracking-tight leading-tight">
                    What Makes Us Special
                </h2>
                <p class="text-base text-white/50 mt-3 max-w-md mx-auto">It's not just a burger. It's a craft.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <!-- Fresh Ingredients -->
                <div class="bg-[#111111] rounded-2xl p-8 text-center group hover:bg-[#2a2220] transition-colors">
                    <div class="w-14 h-14 bg-[#C8102E]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">Fresh Daily</h3>
                    <p class="text-sm text-white/50 leading-relaxed">Every ingredient sourced fresh, every single day. Never frozen, always quality.</p>
                </div>

                <!-- Flame-Grilled -->
                <div class="bg-[#111111] rounded-2xl p-8 text-center group hover:bg-[#2a2220] transition-colors">
                    <div class="w-14 h-14 bg-[#C8102E]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 6.51 6.51 0 009 4.5a6.5 6.5 0 016.362.714z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1.001A3.75 3.75 0 0012 18z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">Flame-Grilled</h3>
                    <p class="text-sm text-white/50 leading-relaxed">Our signature flame-grilled technique for that perfect char and smoky flavour.</p>
                </div>

                <!-- Bold Flavours -->
                <div class="bg-[#111111] rounded-2xl p-8 text-center group hover:bg-[#2a2220] transition-colors">
                    <div class="w-14 h-14 bg-[#C8102E]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">Bold Flavours</h3>
                    <p class="text-sm text-white/50 leading-relaxed">Handcrafted sauces and seasonings you won't find anywhere else.</p>
                </div>

                <!-- Made with Love -->
                <div class="bg-[#111111] rounded-2xl p-8 text-center group hover:bg-[#2a2220] transition-colors">
                    <div class="w-14 h-14 bg-[#C8102E]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">Made with Love</h3>
                    <p class="text-sm text-white/50 leading-relaxed">Every burger handmade to order by our passionate team. No shortcuts.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================
         TESTIMONIALS
         ============================================ -->
    <section class="bg-[#111111] py-20 lg:py-28">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-xs font-bold text-[#C8102E] uppercase tracking-widest mb-3">Testimonials</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white uppercase tracking-tight leading-tight">
                    What Our Customers Say
                </h2>
                <p class="text-base text-white/50 mt-3">Don't take our word for it &mdash; hear from the people who love our food.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-[#231A17] rounded-2xl p-7">
                    <div class="flex items-center gap-0.5 mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <p class="text-sm text-white/60 leading-relaxed mb-5">
                        "The burgers here are unreal &mdash; juicy, perfectly seasoned, and the buns are always so fresh. This is the only place I order from now. Proper quality."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#C8102E]/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-[#C8102E]">J</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">James T.</div>
                            <div class="text-xs text-white/40">Regular Customer</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-[#231A17] rounded-2xl p-7">
                    <div class="flex items-center gap-0.5 mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <p class="text-sm text-white/60 leading-relaxed mb-5">
                        "Best burgers in town, hands down. The flame-grilled flavour is incredible and the sauces are next level. My mates and I come here every weekend."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-purple-400">S</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Sophie L.</div>
                            <div class="text-xs text-white/40">Regular Customer</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-[#231A17] rounded-2xl p-7">
                    <div class="flex items-center gap-0.5 mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <p class="text-sm text-white/60 leading-relaxed mb-5">
                        "You can taste the quality in every bite. Fresh ingredients, proper portions, and the staff genuinely care about getting it right. Absolute gem of a place."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-emerald-400">M</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Marcus W.</div>
                            <div class="text-xs text-white/40">Regular Customer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================
         EXPLORE OUR MENU
         ============================================ -->
    <section class="bg-[#231A17] py-20 lg:py-28">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-xs font-bold text-[#C8102E] uppercase tracking-widest mb-3">Explore</p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white uppercase tracking-tight leading-tight mb-4">
                        Our Menu
                    </h2>
                    <p class="text-base text-white/60 leading-relaxed mb-4">
                        From our signature flame-grilled classics to loaded gourmet stacks, there's something for everyone. Fresh buns, premium patties, and sauces made in-house.
                    </p>
                    <p class="text-base text-white/60 leading-relaxed mb-6">
                        Whether you're after a quick bite or a proper feast, we've got you covered.
                    </p>
                    <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-[#C8102E] text-white px-8 py-3 font-bold text-sm hover:bg-[#a00d24] transition-colors">
                        View Full Menu
                    </a>
                </div>
                <div class="relative">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-[#111111]">
                        <img src="<?php echo e(asset('images/banners/banner2.webp')); ?>" alt="Our Menu" class="w-full h-full object-cover" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================
         CTA: ORDER NOW
         ============================================ -->
    <section class="relative overflow-hidden bg-[#C8102E]">
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('<?php echo e(asset('images/banners/banner2.webp')); ?>');"></div>
        <div class="container mx-auto px-6 lg:px-8 relative z-10 py-20 lg:py-28">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white uppercase tracking-tight leading-none mb-4 -rotate-2">
                    <span class="flex flex-col items-center [&>span]:bg-white/15">
                        <span class="inline-block px-4 py-1.5 rounded-xl">Ready to</span>
                        <span class="inline-block px-4 py-1.5 rounded-xl -mt-0.5">Taste the Best?</span>
                    </span>
                </h2>
                <p class="text-lg text-white/80 mb-8 max-w-md mx-auto">Life's too short for boring burgers. Call us or WhatsApp your order.</p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="tel:<?php echo e(\App\Models\Setting::get('site_phone', '02088905008')); ?>" class="inline-flex items-center gap-2 bg-white text-[#C8102E] rounded px-8 py-3 font-bold text-sm hover:bg-white/90 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        Call to Order
                    </a>
                    <a href="https://wa.me/<?php echo e(\App\Models\Setting::get('whatsapp_number', '447368998035')); ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 border-2 border-white text-white rounded px-8 py-2.5 font-bold text-sm hover:bg-white hover:text-[#C8102E] transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.556 4.124 1.528 5.858L.058 23.708l5.97-1.442A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75c-1.9 0-3.727-.513-5.32-1.484l-.38-.227-3.546.857.896-3.453-.25-.394A9.686 9.686 0 012.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75z"/></svg>
                        WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/pages/about.blade.php ENDPATH**/ ?>