<?php
    $siteName = \App\Models\Setting::get('site_name', 'JustBurgers');
    $socialFacebook = \App\Models\Setting::get('social_facebook', '');
    $socialInstagram = \App\Models\Setting::get('social_instagram', '');
    $socialTwitter = \App\Models\Setting::get('social_twitter', '');
    $socialYoutube = \App\Models\Setting::get('social_youtube', '');
    $socialTiktok = \App\Models\Setting::get('social_tiktok', '');
    $socialSnapchat = \App\Models\Setting::get('social_snapchat', '');
    $socialSpotify = \App\Models\Setting::get('social_spotify', '');
?>

<footer class="bg-[#111111] text-white mt-auto">

    <!-- Top: Logo + Social Row -->
    <div class="container mx-auto px-6 lg:px-8 pt-14 pb-10">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-12">
            <a href="<?php echo e(url('/')); ?>" class="inline-block" style="text-decoration:none;">
                <span style="font-family:'Anton',Impact,'Arial Black',sans-serif;font-size:1.6rem;letter-spacing:2px;text-transform:uppercase;line-height:1;white-space:nowrap;"><span style="color:#C8102E;">JUST</span><span style="color:#fff;margin-left:2px;">BURGERS</span></span>
            </a>
            <div class="flex items-center gap-2.5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialFacebook): ?>
                    <a href="<?php echo e($socialFacebook); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="Facebook" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialTwitter): ?>
                    <a href="<?php echo e($socialTwitter); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="X" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialInstagram): ?>
                    <a href="<?php echo e($socialInstagram); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialSnapchat): ?>
                    <a href="<?php echo e($socialSnapchat); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="Snapchat" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12.989-.217.15-.045.296-.09.42-.119.245-.052.484-.076.72-.076.48 0 .87.16 1.14.44.33.35.39.78.33 1.09-.06.32-.27.6-.6.78-.12.06-.27.12-.42.18-.33.14-.72.3-1.08.51-.24.14-.39.29-.48.41-.15.21-.15.42-.12.58.12.59.45 1.14.75 1.62.15.24.3.45.39.65.48.87.54 1.55-.06 2.01-.45.33-1.08.54-1.74.66-.12.021-.24.05-.39.08-.21.06-.45.12-.75.24a.41.41 0 00-.21.18c-.09.15-.12.33-.15.54-.06.42-.12.87-.93 1.08-.42.12-1.05.18-1.65.18-.36 0-.69-.03-1.05-.06-.6-.06-1.2-.12-2.1.42-.93.57-1.68.75-2.31.75-.06 0-.12 0-.18-.01-.06.01-.12.01-.18.01-.63 0-1.38-.18-2.31-.75-.87-.54-1.5-.48-2.1-.42-.36.03-.69.06-1.05.06-.6 0-1.23-.06-1.65-.18-.81-.21-.87-.66-.93-1.08-.03-.21-.06-.39-.15-.54a.41.41 0 00-.21-.18c-.3-.12-.54-.18-.75-.24-.15-.03-.27-.06-.39-.08-.66-.12-1.29-.33-1.74-.66-.6-.46-.54-1.14-.06-2.01.09-.2.24-.41.39-.65.3-.48.63-1.03.75-1.62.03-.16.03-.37-.12-.58-.09-.12-.24-.27-.48-.41-.36-.21-.75-.37-1.08-.51-.15-.06-.3-.12-.42-.18-.33-.18-.54-.46-.6-.78-.06-.31 0-.74.33-1.09.27-.28.66-.44 1.14-.44.236 0 .475.024.72.076.124.029.27.074.42.119.33.097.689.201.989.217.198 0 .326-.045.401-.09-.008-.165-.018-.33-.03-.51l-.003-.06c-.104-1.628-.23-3.654.299-4.847C7.653 1.069 11.013.793 12.006.793h.2z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialTiktok): ?>
                    <a href="<?php echo e($socialTiktok); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="TikTok" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialYoutube): ?>
                    <a href="<?php echo e($socialYoutube); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="YouTube" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($socialSpotify): ?>
                    <a href="<?php echo e($socialSpotify); ?>" class="w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors" aria-label="Spotify" target="_blank" rel="noopener">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Link Columns Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-x-8 gap-y-10 mb-14">

            <!-- Contact Us -->
            <div class="col-span-2 sm:col-span-1">
                <h4 class="text-[16px] font-bold text-white uppercase tracking-wider mb-5">Contact Us</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="tel:<?php echo e(\App\Models\Setting::get('site_phone', '02088905008')); ?>" class="text-sm text-white/60 hover:text-white transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#C8102E] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <?php echo e(\App\Models\Setting::get('site_phone', '020 8890 5008')); ?>

                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/<?php echo e(\App\Models\Setting::get('whatsapp_number', '447368998035')); ?>" target="_blank" rel="noopener" class="text-sm text-white/60 hover:text-white transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.556 4.124 1.528 5.858L.058 23.708l5.97-1.442A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75c-1.9 0-3.727-.513-5.32-1.484l-.38-.227-3.546.857.896-3.453-.25-.394A9.686 9.686 0 012.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75z"/></svg>
                            <?php echo e(\App\Models\Setting::get('site_mobile', '07368 998 035')); ?>

                        </a>
                    </li>
                    <li class="text-sm text-white/60 flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#C8102E] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span><?php echo e(\App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP')); ?></span>
                    </li>
                </ul>
            </div>

            <!-- Menu -->
            <div>
                <h4 class="text-[16px] font-bold text-white uppercase tracking-wider mb-5">Menu</h4>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Full Menu</a></li>
                </ul>
            </div>

            <!-- Explore -->
            <div>
                <h4 class="text-[16px] font-bold text-white uppercase tracking-wider mb-5">Explore</h4>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('about')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Our Story</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div>
                <h4 class="text-[16px] font-bold text-white uppercase tracking-wider mb-5">Help</h4>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('faq')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">FAQs</a></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('login')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">My Account</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('account.dashboard')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">My Account</a></li>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <li><a href="<?php echo e(route('shipping')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Delivery Info</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h4 class="text-[16px] font-bold text-white uppercase tracking-wider mb-5">Legal</h4>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('terms')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Terms & Conditions</a></li>
                    <li><a href="<?php echo e(route('privacy')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="<?php echo e(route('cookie-policy')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">Cookie Policy</a></li>
                    <li><a href="<?php echo e(route('gdpr')); ?>" class="text-sm text-white/60 hover:text-white transition-colors">GDPR</a></li>
                </ul>
            </div>
        </div>

        <!-- Opening Hours -->
        <div class="border-t border-white/10 pt-8 mb-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#C8102E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-semibold text-white">Opening Hours</span>
                </div>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-white/60">
                    <span>Mon–Tue: <?php echo e(\App\Models\Setting::get('hours_monday', '12:00 – 9:00 PM')); ?></span>
                    <span>Wed–Thu: <?php echo e(\App\Models\Setting::get('hours_wednesday', '12:00 – 10:00 PM')); ?></span>
                    <span>Fri–Sat: <?php echo e(\App\Models\Setting::get('hours_friday', '12:00 – 11:00 PM')); ?></span>
                    <span>Sun: <?php echo e(\App\Models\Setting::get('hours_sunday', '4:00 – 10:00 PM')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/10">
        <div class="container mx-auto px-6 lg:px-8 py-5">
            <p class="text-xs text-white/40">&copy; <?php echo e(date('Y')); ?> <?php echo e($siteName); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/partials/footer.blade.php ENDPATH**/ ?>