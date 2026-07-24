<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

     <?php $__env->slot('title', null, []); ?> Analytics <?php $__env->endSlot(); ?>

    <?php
        $rate = $funnel['visitors'] > 0 ? round(($funnel['completed'] / $funnel['visitors']) * 100, 2) : 0;
        $cartRate = $funnel['visitors'] > 0 ? round(($funnel['add_to_cart'] / $funnel['visitors']) * 100, 1) : 0;
        $checkoutRate = $funnel['add_to_cart'] > 0 ? round(($funnel['checkout'] / $funnel['add_to_cart']) * 100, 1) : 0;
    ?>

    
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-neutral-900">Analytics</h1>
        <p class="text-sm text-neutral-500 mt-0.5">Traffic and conversion insights</p>
    </div>

    
    <div class="flex items-center gap-2 mb-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
            7   => 'Last 7 days',
            30  => 'Last 30 days',
            90  => 'Last 90 days',
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <a href="<?php echo e(route('admin.reports.analytics', ['period' => $val])); ?>"
               class="px-3.5 py-1.5 text-sm rounded-lg font-medium transition
                   <?php echo e($period == $val
                       ? 'bg-neutral-900 text-white'
                       : 'bg-white text-neutral-600 hover:bg-neutral-100'); ?>"
               style="border:1px solid <?php echo e($period == $val ? '#171717' : '#e1e1e1'); ?>">
                <?php echo e($label); ?>

            </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    
    <div class="bg-white rounded-xl mb-6 overflow-hidden" style="border:1px solid #e1e1e1">
        <div class="grid grid-cols-2 lg:grid-cols-4">
            
            <div class="px-5 py-4 lg:border-r" style="border-color:#e1e1e1">
                <p class="text-xs text-neutral-500 font-medium mb-1">Unique Visitors</p>
                <div class="flex items-end justify-between gap-3">
                    <p class="text-2xl font-semibold text-neutral-900 leading-none"><?php echo e(number_format($funnel['visitors'])); ?></p>
                    <svg class="w-16 h-8 text-neutral-300" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="2,28 12,22 22,24 32,16 42,18 52,10 62,14" stroke="#a0a0a0" fill="none" />
                    </svg>
                </div>
            </div>
            
            <div class="px-5 py-4 lg:border-r" style="border-color:#e1e1e1">
                <p class="text-xs text-neutral-500 font-medium mb-1">Product Views</p>
                <div class="flex items-end justify-between gap-3">
                    <p class="text-2xl font-semibold text-neutral-900 leading-none"><?php echo e(number_format($funnel['product_views'])); ?></p>
                    <svg class="w-16 h-8 text-neutral-300" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="2,26 12,20 22,22 32,12 42,14 52,8 62,10" stroke="#a0a0a0" fill="none" />
                    </svg>
                </div>
            </div>
            
            <div class="px-5 py-4 border-t lg:border-t-0 lg:border-r" style="border-color:#e1e1e1">
                <p class="text-xs text-neutral-500 font-medium mb-1">Add to Cart</p>
                <div class="flex items-end justify-between gap-3">
                    <p class="text-2xl font-semibold text-neutral-900 leading-none"><?php echo e(number_format($funnel['add_to_cart'])); ?></p>
                    <svg class="w-16 h-8 text-neutral-300" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="2,24 12,26 22,18 32,20 42,14 52,16 62,12" stroke="#a0a0a0" fill="none" />
                    </svg>
                </div>
            </div>
            
            <div class="px-5 py-4 border-t lg:border-t-0" style="border-color:#e1e1e1">
                <p class="text-xs text-neutral-500 font-medium mb-1">Completed Orders</p>
                <div class="flex items-end justify-between gap-3">
                    <p class="text-2xl font-semibold text-neutral-900 leading-none"><?php echo e(number_format($funnel['completed'])); ?></p>
                    <svg class="w-16 h-8 text-neutral-300" viewBox="0 0 64 32" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="2,28 12,24 22,26 32,18 42,20 52,12 62,8" stroke="#a0a0a0" fill="none" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($funnel['visitors'] > 0): ?>
        <div class="bg-white rounded-xl mb-6 overflow-hidden" style="border:1px solid #e1e1e1">
            <div class="grid grid-cols-3">
                <div class="px-5 py-4" style="border-right:1px solid #e1e1e1">
                    <p class="text-xs text-neutral-500 font-medium mb-1">View &rarr; Cart Rate</p>
                    <p class="text-xl font-semibold text-neutral-900"><?php echo e($cartRate); ?>%</p>
                    <p class="text-xs text-neutral-400 mt-1"><?php echo e(number_format($funnel['add_to_cart'])); ?> of <?php echo e(number_format($funnel['visitors'])); ?> visitors</p>
                </div>
                <div class="px-5 py-4" style="border-right:1px solid #e1e1e1">
                    <p class="text-xs text-neutral-500 font-medium mb-1">Cart &rarr; Order Rate</p>
                    <p class="text-xl font-semibold text-neutral-900"><?php echo e($checkoutRate); ?>%</p>
                    <p class="text-xs text-neutral-400 mt-1"><?php echo e(number_format($funnel['checkout'])); ?> of <?php echo e(number_format($funnel['add_to_cart'])); ?> carts</p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-neutral-500 font-medium mb-1">Overall Conversion</p>
                    <p class="text-xl font-semibold text-neutral-900"><?php echo e($rate); ?>%</p>
                    <p class="text-xs text-neutral-400 mt-1"><?php echo e(number_format($funnel['completed'])); ?> of <?php echo e(number_format($funnel['visitors'])); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl mb-6" style="border:1px solid #e1e1e1">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #e1e1e1">
            <h2 class="text-sm font-semibold text-neutral-900">Traffic Overview</h2>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trafficData->sum('pageviews') > 0): ?>
                <div class="flex items-center gap-4 text-xs text-neutral-500">
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm" style="background:rgba(156,0,173,0.4)"></span>
                        Page Views
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-0.5 rounded" style="background:#06b6d4"></span>
                        Visitors
                    </span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="p-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trafficData->sum('pageviews') > 0): ?>
                <div style="height:260px; position:relative;">
                    <canvas id="trafficChart"></canvas>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center py-16 text-neutral-400">
                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm font-medium text-neutral-500">No traffic data for this period</p>
                    <p class="text-xs text-neutral-400 mt-1">Product view tracking will appear here once customers start browsing</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white rounded-xl" style="border:1px solid #e1e1e1">
            <div class="px-5 py-4" style="border-bottom:1px solid #e1e1e1">
                <h2 class="text-sm font-semibold text-neutral-900">Conversion Funnel</h2>
                <p class="text-xs text-neutral-500 mt-0.5">Drop-off at each stage</p>
            </div>
            <div class="p-5 space-y-4">
                <?php
                    $funnelSteps = [
                        ['label' => 'Unique Visitors',   'value' => $funnel['visitors'],      'color' => '#6366f1'],
                        ['label' => 'Product Views',     'value' => $funnel['product_views'], 'color' => '#8b5cf6'],
                        ['label' => 'Add to Cart',       'value' => $funnel['add_to_cart'],   'color' => '#f59e0b'],
                        ['label' => 'Orders Placed',     'value' => $funnel['checkout'],       'color' => '#06b6d4'],
                        ['label' => 'Paid & Completed',  'value' => $funnel['completed'],      'color' => '#22c55e'],
                    ];
                    $maxFunnel = max($funnel['visitors'], $funnel['product_views'], 1);
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $funnelSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $width   = ($step['value'] / $maxFunnel) * 100;
                        $prev    = $index > 0 ? $funnelSteps[$index - 1]['value'] : $step['value'];
                        $dropoff = $prev > 0 ? round((1 - $step['value'] / $prev) * 100) : 0;
                    ?>
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:<?php echo e($step['color']); ?>"></span>
                                <span class="text-neutral-700 font-medium"><?php echo e($step['label']); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-neutral-900"><?php echo e(number_format($step['value'])); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index > 0 && $dropoff > 0): ?>
                                    <span class="text-xs font-medium text-red-600 bg-red-50 px-1.5 py-0.5 rounded">-<?php echo e($dropoff); ?>%</span>
                                <?php elseif($index > 0 && $dropoff === 0): ?>
                                    <span class="text-xs font-medium text-green-600 bg-green-50 px-1.5 py-0.5 rounded">0%</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <div class="bg-neutral-100 rounded h-2 overflow-hidden">
                            <div class="h-full rounded transition-all duration-700" style="width: <?php echo e(max($width, 1)); ?>%; background:<?php echo e($step['color']); ?>"></div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($funnel['visitors'] == 0): ?>
                    <p class="text-center text-sm text-neutral-500 py-4">No funnel data for this period</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="space-y-6">
            
            <div class="bg-white rounded-xl" style="border:1px solid #e1e1e1">
                <div class="px-5 py-4" style="border-bottom:1px solid #e1e1e1">
                    <h2 class="text-sm font-semibold text-neutral-900">Traffic Sources</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">By referrer origin</p>
                </div>
                <div>
                    <?php
                        $hasSourceData = $sources->where('visitors', '>', 0)->count() > 0;
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasSourceData): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sources->filter(fn($s) => $s['visitors'] > 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="px-5 py-3.5 flex items-center justify-between" style="border-bottom:1px solid #f3f3f3">
                                <span class="text-sm text-neutral-700 font-medium"><?php echo e($source['source']); ?></span>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-neutral-900"><?php echo e(number_format($source['visitors'])); ?></span>
                                    <span class="text-xs text-neutral-400 w-10 text-right"><?php echo e($source['percentage']); ?>%</span>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php else: ?>
                        <div class="px-5 py-10 text-center">
                            <p class="text-sm text-neutral-500">No referrer data available</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white rounded-xl" style="border:1px solid #e1e1e1">
                <div class="px-5 py-4" style="border-bottom:1px solid #e1e1e1">
                    <h2 class="text-sm font-semibold text-neutral-900">Device Breakdown</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">Orders by device type</p>
                </div>
                <div class="p-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($devices['mobile'] + $devices['desktop'] + $devices['tablet'] > 0): ?>
                        <table class="w-full text-sm">
                            <thead>
                                <tr>
                                    <th class="text-left text-xs font-medium text-neutral-500 uppercase pb-3">Device</th>
                                    <th class="text-right text-xs font-medium text-neutral-500 uppercase pb-3">Share</th>
                                    <th class="text-right text-xs font-medium text-neutral-500 uppercase pb-3 w-1/2">Distribution</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $deviceItems = [
                                        ['label' => 'Mobile',  'pct' => $devices['mobile'],  'color' => '#6366f1'],
                                        ['label' => 'Desktop', 'pct' => $devices['desktop'], 'color' => '#06b6d4'],
                                        ['label' => 'Tablet',  'pct' => $devices['tablet'],  'color' => '#f59e0b'],
                                    ];
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $deviceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr style="border-bottom:1px solid #f3f3f3">
                                        <td class="py-2.5 text-neutral-700 font-medium">
                                            <span class="inline-block w-2 h-2 rounded-full mr-2" style="background:<?php echo e($d['color']); ?>"></span><?php echo e($d['label']); ?>

                                        </td>
                                        <td class="py-2.5 text-right font-semibold text-neutral-900"><?php echo e($d['pct']); ?>%</td>
                                        <td class="py-2.5 pl-4">
                                            <div class="bg-neutral-100 rounded h-1.5 overflow-hidden">
                                                <div class="h-full rounded" style="width: <?php echo e($d['pct']); ?>%; background:<?php echo e($d['color']); ?>"></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="py-8 text-center">
                            <p class="text-sm text-neutral-500">No device data available</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="flex items-start gap-3 px-4 py-3 bg-neutral-50 rounded-lg text-xs text-neutral-500" style="border:1px solid #e1e1e1">
        <svg class="w-4 h-4 shrink-0 mt-0.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Analytics data is collected from product views, cart activity, and order records. Traffic sources are derived from HTTP referrer headers. Device breakdown is based on user-agent strings from orders.
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($trafficData->sum('pageviews') > 0): ?>
        <?php $__env->startPush('scripts'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fontFamily = "'Manrope', 'Inter', sans-serif";
                const ctx = document.getElementById('trafficChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($trafficData->pluck('date'), 15, 512) ?>,
                        datasets: [
                            {
                                label: 'Page Views',
                                data: <?php echo json_encode($trafficData->pluck('pageviews'), 15, 512) ?>,
                                backgroundColor: 'rgba(156, 0, 173, 0.18)',
                                hoverBackgroundColor: 'rgba(156, 0, 173, 0.35)',
                                borderColor: 'rgba(156, 0, 173, 0.6)',
                                borderWidth: 1,
                                borderRadius: 5,
                                borderSkipped: false,
                                yAxisID: 'y',
                                order: 2,
                            },
                            {
                                label: 'Unique Visitors',
                                data: <?php echo json_encode($trafficData->pluck('visitors'), 15, 512) ?>,
                                type: 'line',
                                borderColor: '#06b6d4',
                                backgroundColor: 'rgba(6, 182, 212, 0.06)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#06b6d4',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: <?php echo e($period <= 14 ? 4 : 0); ?>,
                                pointHoverRadius: 5,
                                yAxisID: 'y',
                                order: 1,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1a1a1a',
                                titleColor: '#fff',
                                bodyColor: '#ccc',
                                padding: 10,
                                cornerRadius: 8,
                                titleFont: { size: 11, family: fontFamily },
                                bodyFont: { size: 11, family: fontFamily },
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: {
                                    font: { size: 10, family: fontFamily },
                                    color: '#a0a0a0',
                                    maxRotation: 40,
                                    maxTicksLimit: <?php echo e($period <= 14 ? $period : 15); ?>

                                }
                            },
                            y: {
                                grid: { color: '#f3f3f3' },
                                border: { display: false, dash: [4, 4] },
                                ticks: {
                                    font: { size: 10, family: fontFamily },
                                    color: '#a0a0a0',
                                    maxTicksLimit: 6
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/reports/analytics.blade.php ENDPATH**/ ?>