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

     <?php $__env->slot('title', null, []); ?> <?php echo e($customer->full_name); ?> <?php $__env->endSlot(); ?>

    <div class="flex items-center gap-2 text-sm text-neutral-600 mb-6">
        <a href="<?php echo e(route('admin.customers.index')); ?>" class="hover:text-primary-600">Customers</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-neutral-900"><?php echo e($customer->full_name); ?></span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info Card -->
            <div class="card p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary-600"><?php echo e(substr($customer->first_name, 0, 1)); ?></span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-neutral-900"><?php echo e($customer->full_name); ?></h1>
                            <p class="text-neutral-600"><?php echo e($customer->email); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->phone): ?>
                                <p class="text-neutral-600"><?php echo e($customer->phone); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_active): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-neutral">Inactive</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="btn btn-secondary btn-sm">Edit</a>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 p-4 bg-neutral-50 rounded-lg">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-neutral-900"><?php echo e($stats['total_orders']); ?></p>
                        <p class="text-sm text-neutral-600">Total Orders</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-neutral-900"><?php echo format_price($stats['total_spent']); ?></p>
                        <p class="text-sm text-neutral-600">Total Spent</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-neutral-900"><?php echo format_price($stats['avg_order_value']); ?></p>
                        <p class="text-sm text-neutral-600">Avg. Order Value</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="p-4 border-b border-neutral-200 flex items-center justify-between">
                    <h2 class="font-semibold text-neutral-900">Recent Orders</h2>
                    <a href="<?php echo e(route('admin.customers.orders', $customer)); ?>" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">Order</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-neutral-600 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-neutral-50">
                                    <td class="px-4 py-3">
                                        <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-medium text-primary-600 hover:text-primary-700">
                                            <?php echo e($order->order_number); ?>

                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-neutral-600"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td class="px-4 py-3">
                                        <span class="badge <?php echo e($order->status === 'completed' ? 'badge-success' : ($order->status === 'pending' ? 'badge-warning' : 'badge-info')); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-right"><?php echo format_price($order->total); ?></td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-neutral-600">
                                        No orders yet
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Account Details -->
            <div class="card p-6">
                <h2 class="font-semibold text-neutral-900 mb-4">Account Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Member Since</dt>
                        <dd class="font-medium"><?php echo e($customer->created_at->format('M d, Y')); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Last Login</dt>
                        <dd class="font-medium"><?php echo e($customer->last_login_at?->diffForHumans() ?? 'Never'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Email Verified</dt>
                        <dd>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->email_verified_at): ?>
                                <span class="text-success-600">Yes</span>
                            <?php else: ?>
                                <span class="text-warning-600">No</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Addresses -->
            <div class="card p-6">
                <h2 class="font-semibold text-neutral-900 mb-4">Saved Addresses</h2>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->addresses && $customer->addresses->count()): ?>
                    <div class="space-y-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="p-3 bg-neutral-50 rounded-lg text-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($address->is_default): ?>
                                    <span class="badge badge-primary mb-2">Default</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <p class="font-medium text-neutral-900"><?php echo e($address->name); ?></p>
                                <p class="text-neutral-600"><?php echo e($address->address_line1); ?></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($address->address_line2): ?>
                                    <p class="text-neutral-600"><?php echo e($address->address_line2); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <p class="text-neutral-600"><?php echo e($address->city); ?>, <?php echo e($address->state); ?> <?php echo e($address->postal_code); ?></p>
                                <p class="text-neutral-600"><?php echo e($address->country); ?></p>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-neutral-600 text-sm">No saved addresses</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="card p-6">
                <h2 class="font-semibold text-neutral-900 mb-4">Actions</h2>
                <div class="space-y-2">
                    <form action="<?php echo e(route('admin.customers.toggle-status', $customer)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_active): ?>
                            <button type="submit" class="btn btn-secondary w-full text-warning-600">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Deactivate Account
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-secondary w-full text-success-600">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Activate Account
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/customers/show.blade.php ENDPATH**/ ?>