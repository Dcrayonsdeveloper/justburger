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

     <?php $__env->slot('title', null, []); ?> Customers <?php $__env->endSlot(); ?>

    
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-gray-900">Customers</h1>
    </div>

    
    <?php echo $__env->make('admin.partials.stats-bar', ['stats' => [
        ['label' => 'Total customers', 'value' => number_format($customers->total()), 'sparkline' => '2,16 10,14 18,12 26,10 34,8 42,6 50,4 58,2', 'color' => '#5c6ac4'],
        ['label' => 'Returning rate', 'value' => '0%', 'sparkline' => '2,10 10,10 18,10 26,10 34,10 42,10 50,10 58,10', 'color' => '#47c1bf'],
        ['label' => 'Avg order value', 'value' => '£0', 'sparkline' => '2,10 10,10 18,10 26,10 34,10 42,10 50,10 58,10', 'color' => '#9c6ade'],
    ]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="bg-white rounded-xl shadow-sm" x-data="{ checkAll: false }">

        
        <div class="flex gap-0 px-4" style="border-bottom:1px solid #e1e1e1">
            <a href="<?php echo e(route('admin.customers.index')); ?>"
               class="relative px-4 py-3 text-sm font-medium text-gray-900">
                All
                <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-900 rounded-t"></span>
            </a>
        </div>

        
        <div class="flex items-center gap-2 p-4" style="border-bottom:1px solid #e1e1e1">
            <form action="<?php echo e(route('admin.customers.index')); ?>" method="GET" class="flex items-center gap-2 flex-1">
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Search customers"
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                </div>
                <button type="submit" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Search
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search')): ?>
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>
        </div>

        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50" style="border-bottom:1px solid #e1e1e1">
                        <th class="w-10 px-4 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300" x-model="checkAll">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total spent</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-gray-50 cursor-pointer" style="border-bottom:1px solid #e1e1e1"
                            onclick="window.location='<?php echo e(route('admin.customers.show', $customer)); ?>'">
                            <td class="px-4 py-3" onclick="event.stopPropagation()">
                                <input type="checkbox" class="rounded border-gray-300" :checked="checkAll">
                            </td>
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo e($customer->full_name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($customer->email); ?></p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700"><?php echo e($customer->orders_count); ?></td>
                            <td class="px-4 py-3 text-gray-700"><?php echo format_price($customer->orders_sum_total ?? 0); ?></td>
                            <td class="px-4 py-3 text-gray-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->city || $customer->country): ?>
                                    <?php echo e(collect([$customer->city, $customer->country])->filter()->implode(', ')); ?>

                                <?php else: ?>
                                    —
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-500"><?php echo e($customer->created_at->format('M d, Y')); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">No customers found</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customers->hasPages()): ?>
            <div class="px-4 py-3 flex items-center justify-between" style="border-top:1px solid #e1e1e1">
                <p class="text-sm text-gray-500">
                    Showing <?php echo e($customers->firstItem()); ?>–<?php echo e($customers->lastItem()); ?> of <?php echo e($customers->total()); ?>

                </p>
                <div class="flex items-center gap-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customers->onFirstPage()): ?>
                        <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-lg">&lsaquo; Previous</span>
                    <?php else: ?>
                        <a href="<?php echo e($customers->previousPageUrl()); ?>" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">&lsaquo; Previous</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customers->hasMorePages()): ?>
                        <a href="<?php echo e($customers->nextPageUrl()); ?>" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Next &rsaquo;</a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-lg">Next &rsaquo;</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>