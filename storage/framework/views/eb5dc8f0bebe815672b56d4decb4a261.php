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

     <?php $__env->slot('title', null, []); ?> Orders <?php $__env->endSlot(); ?>

     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold text-neutral-900">Orders</h1>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.orders.index', ['export' => 'csv'])); ?>" class="btn btn-secondary text-sm">Export</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    
     <?php $__env->slot('statsBar', null, []); ?> 
        <?php echo $__env->make('admin.partials.stats-bar', ['stats' => [
            ['label' => 'Orders', 'value' => number_format($stats['total'] ?? 0), 'sparkline' => '2,15 10,12 18,8 26,14 34,6 42,11 50,4 58,9', 'color' => '#5c6ac4'],
            ['label' => 'Items ordered', 'value' => number_format(($stats['total'] ?? 0) * 2), 'sparkline' => '2,14 10,10 18,12 26,6 34,9 42,4 50,8 58,3', 'color' => '#47c1bf'],
            ['label' => 'Returns', 'value' => '£' . number_format($stats['cancelled'] ?? 0), 'sparkline' => '2,10 10,10 18,10 26,10 34,10 42,10 50,10 58,10', 'color' => '#9c6ade'],
            ['label' => 'Orders fulfilled', 'value' => number_format($stats['completed'] ?? 0), 'sparkline' => '2,16 10,14 18,12 26,10 34,8 42,6 50,4 58,2', 'color' => '#5c6ac4'],
        ]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
     <?php $__env->endSlot(); ?>

    
    <?php
        $currentStatus = request('status', '');
        $currentPayment = request('payment_status', '');
        $tabs = [
            '' => 'All',
            'confirmed' => 'Unfulfilled',
            'processing' => 'Processing',
            'shipped' => 'On Its Way',
            'delivered' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    ?>

    <div class="card overflow-hidden">
        
        <div class="flex items-center gap-0 px-4 pt-3" style="border-bottom:1px solid #e1e1e1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e(route('admin.orders.index', array_merge(request()->except('status', 'page'), $value ? ['status' => $value] : []))); ?>"
                   class="px-3 pb-3 text-sm font-medium transition-colors relative <?php echo e($currentStatus === $value ? 'text-neutral-900' : 'text-neutral-500 hover:text-neutral-700'); ?>">
                    <?php echo e($label); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStatus === $value): ?>
                        <span class="absolute bottom-0 left-0 right-0 h-0.5 rounded-full" style="background:#1a1a1a"></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="px-4 py-3" style="border-bottom:1px solid #e1e1e1">
            <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStatus): ?>
                    <input type="hidden" name="status" value="<?php echo e($currentStatus); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="relative flex-1 max-w-sm">
                    <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Filter orders" class="form-input w-full pl-9 text-sm" style="height:36px">
                </div>
                <select name="payment_status" class="form-input text-sm" style="height:36px;width:auto" onchange="this.form.submit()">
                    <option value="">Payment status</option>
                    <option value="pending" <?php echo e($currentPayment === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="paid" <?php echo e($currentPayment === 'paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="failed" <?php echo e($currentPayment === 'failed' ? 'selected' : ''); ?>>Failed</option>
                    <option value="refunded" <?php echo e($currentPayment === 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search', 'payment_status', 'date_from', 'date_to'])): ?>
                    <a href="<?php echo e(route('admin.orders.index', $currentStatus ? ['status' => $currentStatus] : [])); ?>" class="text-xs text-neutral-500 hover:text-neutral-700 shrink-0">Clear</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>
        </div>

        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr style="border-bottom:1px solid #e1e1e1">
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 w-8">
                            <input type="checkbox" class="form-checkbox rounded">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500">Customer</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-neutral-500">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500">Payment status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500">Fulfillment status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-neutral-500">Items</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-neutral-50 cursor-pointer" onclick="window.location='<?php echo e(route('admin.orders.show', $order)); ?>'" style="border-bottom:1px solid #f0f0f0">
                            <td class="px-4 py-3" onclick="event.stopPropagation()">
                                <input type="checkbox" class="form-checkbox rounded" value="<?php echo e($order->id); ?>">
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium" style="color:#005bd3"><?php echo e($order->order_number); ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-neutral-600"><?php echo e($order->created_at->isToday() ? 'Today at ' . $order->created_at->format('g:i a') : ($order->created_at->isYesterday() ? 'Yesterday at ' . $order->created_at->format('g:i a') : $order->created_at->format('M d, Y'))); ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-neutral-900"><?php echo e($order->user->full_name ?? 'Guest'); ?></span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="text-sm text-neutral-900"><?php echo format_price($order->total); ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                    $payColor = match($order->payment_status) {
                                        'paid' => ['bg' => '#e3f1df', 'text' => '#1a7431', 'dot' => '#1a7431'],
                                        'pending' => ['bg' => '#fff3cd', 'text' => '#856404', 'dot' => '#ffc107'],
                                        'failed' => ['bg' => '#fde8e8', 'text' => '#c53030', 'dot' => '#e53e3e'],
                                        'refunded' => ['bg' => '#e9ecef', 'text' => '#495057', 'dot' => '#6c757d'],
                                        default => ['bg' => '#e9ecef', 'text' => '#495057', 'dot' => '#6c757d'],
                                    };
                                ?>
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded" style="background:<?php echo e($payColor['bg']); ?>;color:<?php echo e($payColor['text']); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background:<?php echo e($payColor['dot']); ?>"></span>
                                    <?php echo e(ucfirst($order->payment_status)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                    $fulfillColor = match($order->status) {
                                        'delivered', 'completed' => ['bg' => '#e3f1df', 'text' => '#1a7431', 'label' => 'Fulfilled'],
                                        'shipped', 'out_for_delivery' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'label' => 'In transit'],
                                        'cancelled', 'returned' => ['bg' => '#fde8e8', 'text' => '#c53030', 'label' => 'Cancelled'],
                                        default => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'Unfulfilled'],
                                    };
                                ?>
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded" style="background:<?php echo e($fulfillColor['bg']); ?>;color:<?php echo e($fulfillColor['text']); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background:<?php echo e($fulfillColor['text']); ?>"></span>
                                    <?php echo e($fulfillColor['label']); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-sm text-neutral-600"><?php echo e($order->items->count()); ?> <?php echo e(Str::plural('item', $order->items->count())); ?></span>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background:#f0f0f0">
                                        <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-900 mb-1">No orders found</p>
                                    <p class="text-sm text-neutral-500">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search', 'status', 'payment_status'])): ?>
                                            Try changing the filters or search term.
                                        <?php else: ?>
                                            Orders will appear here when customers place them.
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->hasPages()): ?>
            <div class="px-4 py-3 flex items-center justify-between text-sm" style="border-top:1px solid #e1e1e1">
                <span class="text-neutral-500"><?php echo e($orders->firstItem()); ?>-<?php echo e($orders->lastItem()); ?> of <?php echo e($orders->total()); ?></span>
                <div class="flex items-center gap-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->onFirstPage()): ?>
                        <span class="px-2 py-1 text-neutral-300">&laquo;</span>
                    <?php else: ?>
                        <a href="<?php echo e($orders->previousPageUrl()); ?>" class="px-2 py-1 text-neutral-600 hover:text-neutral-900">&laquo;</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->hasMorePages()): ?>
                        <a href="<?php echo e($orders->nextPageUrl()); ?>" class="px-2 py-1 text-neutral-600 hover:text-neutral-900">&raquo;</a>
                    <?php else: ?>
                        <span class="px-2 py-1 text-neutral-300">&raquo;</span>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>