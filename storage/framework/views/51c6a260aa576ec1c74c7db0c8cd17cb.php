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

     <?php $__env->slot('title', null, []); ?> Discounts <?php $__env->endSlot(); ?>

    
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-semibold text-gray-900">Discounts</h1>
        <a href="<?php echo e(route('admin.coupons.create')); ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
            Create discount
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200"
         x-data="{
             tab: '<?php echo e(request('status', 'all')); ?>',
             search: '<?php echo e(request('search', '')); ?>',
             selected: [],
             allIds: <?php echo e($coupons->pluck('id')); ?>,
             toggleAll(checked) { this.selected = checked ? [...this.allIds] : []; },
             isAllSelected() { return this.allIds.length > 0 && this.selected.length === this.allIds.length; }
         }">

        
        <div class="flex items-center gap-0 px-4" style="border-bottom:1px solid #e1e1e1">
            <?php
                $tabs = [
                    'all' => 'All',
                    'active' => 'Active',
                    'expired' => 'Expired',
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e(route('admin.coupons.index', array_merge(request()->except('status', 'page'), $key === 'all' ? [] : ['status' => $key]))); ?>"
                   class="relative px-4 py-3 text-sm font-medium transition-colors
                          <?php echo e(request('status', 'all') === $key ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700'); ?>">
                    <?php echo e($label); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status', 'all') === $key): ?>
                        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-gray-900 rounded-full"></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="px-4 py-3" style="border-bottom:1px solid #e1e1e1">
            <form action="<?php echo e(route('admin.coupons.index')); ?>" method="GET" class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status')): ?>
                    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="relative flex-1 max-w-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Search discounts"
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                </div>
            </form>
        </div>

        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="border-bottom:1px solid #e1e1e1">
                        <th class="pl-4 pr-0 py-3 w-10">
                            <input type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-500"
                                   @change="toggleAll($event.target.checked)"
                                   :checked="isAllSelected()">
                        </th>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Value</th>
                        <th class="px-4 py-3">Usage</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Expires</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-gray-50 cursor-pointer group" style="border-bottom:1px solid #e1e1e1"
                            onclick="if(!event.target.closest('input[type=checkbox]')) window.location='<?php echo e(route('admin.coupons.edit', $coupon)); ?>'">
                            <td class="pl-4 pr-0 py-3 w-10" onclick="event.stopPropagation()">
                                <input type="checkbox" class="rounded border-gray-300 text-gray-900 focus:ring-gray-500"
                                       value="<?php echo e($coupon->id); ?>"
                                       :checked="selected.includes(<?php echo e($coupon->id); ?>)"
                                       @change="selected.includes(<?php echo e($coupon->id); ?>) ? selected.splice(selected.indexOf(<?php echo e($coupon->id); ?>), 1) : selected.push(<?php echo e($coupon->id); ?>)">
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-medium text-gray-900"><?php echo e($coupon->code); ?></span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <?php echo e(ucfirst(str_replace('_', ' ', $coupon->type))); ?>

                            </td>
                            <td class="px-4 py-3 text-gray-900 font-medium">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupon->type === 'percentage'): ?>
                                    <?php echo e($coupon->value); ?>%
                                <?php elseif($coupon->type === 'free_shipping'): ?>
                                    Free shipping
                                <?php else: ?>
                                    <?php echo format_price($coupon->value); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <?php echo e($coupon->times_used ?? 0); ?><?php echo e($coupon->usage_limit ? ' / ' . $coupon->usage_limit : ''); ?>

                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupon->isValid()): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                <?php elseif($coupon->expires_at?->isPast()): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Expired</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupon->expires_at): ?>
                                    <?php echo e($coupon->expires_at->format('M d, Y')); ?>

                                <?php else: ?>
                                    --
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <p class="text-gray-500 text-sm">No discounts found</p>
                                <a href="<?php echo e(route('admin.coupons.create')); ?>"
                                   class="inline-flex items-center mt-3 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                                    Create discount
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupons->hasPages()): ?>
            <div class="px-4 py-3 flex items-center justify-between" style="border-top:1px solid #e1e1e1">
                <div class="text-sm text-gray-600">
                    Showing <?php echo e($coupons->firstItem()); ?>-<?php echo e($coupons->lastItem()); ?> of <?php echo e($coupons->total()); ?>

                </div>
                <div class="flex items-center gap-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupons->onFirstPage()): ?>
                        <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 rounded-lg cursor-not-allowed">&lsaquo;</span>
                    <?php else: ?>
                        <a href="<?php echo e($coupons->previousPageUrl()); ?>" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">&lsaquo;</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupons->hasMorePages()): ?>
                        <a href="<?php echo e($coupons->nextPageUrl()); ?>" class="px-3 py-1.5 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">&rsaquo;</a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 rounded-lg cursor-not-allowed">&rsaquo;</span>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>