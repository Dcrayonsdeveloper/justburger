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

     <?php $__env->slot('title', null, []); ?> Tax Rates <?php $__env->endSlot(); ?>

    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-neutral-600 mb-1">
                <a href="<?php echo e(route('admin.settings.tax')); ?>" class="hover:text-primary-600">Tax Settings</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-neutral-900">Tax Rates</span>
            </div>
            <h1 class="text-2xl font-bold text-neutral-900">Tax Rates</h1>
            <p class="text-neutral-600">Configure tax rates by region</p>
        </div>
        <a href="<?php echo e(route('admin.settings.tax-rates.create')); ?>" class="btn btn-primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Tax Rate
        </a>
    </div>
    <div class="card overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($taxRates->total() > 0): ?>
            <div class="px-5 py-3 border-b border-neutral-200">
                <?php echo e($taxRates->links('vendor.pagination.info-bar')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">State</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-neutral-600 uppercase">CGST %</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-neutral-600 uppercase">SGST %</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-neutral-600 uppercase">IGST %</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-neutral-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-neutral-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $taxRates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxRate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-neutral-50">
                            <td class="px-4 py-3 font-medium text-neutral-900"><?php echo e($taxRate->name); ?></td>
                            <td class="px-4 py-3 text-sm text-neutral-600"><?php echo e($taxRate->state ?? '-'); ?></td>
                            <td class="px-4 py-3 text-sm text-right"><?php echo e(number_format($taxRate->cgst_rate, 2)); ?>%</td>
                            <td class="px-4 py-3 text-sm text-right"><?php echo e(number_format($taxRate->sgst_rate, 2)); ?>%</td>
                            <td class="px-4 py-3 text-sm text-right"><?php echo e(number_format($taxRate->igst_rate, 2)); ?>%</td>
                            <td class="px-4 py-3">
                                <span class="badge <?php echo e($taxRate->is_active ? 'badge-success' : 'badge-error'); ?>">
                                    <?php echo e($taxRate->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.settings.tax-rates.edit', $taxRate)); ?>" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.settings.tax-rates.destroy', $taxRate)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this tax rate?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-danger-600 hover:text-danger-700 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-neutral-600">
                                No tax rates configured yet.
                                <a href="<?php echo e(route('admin.settings.tax-rates.create')); ?>" class="text-primary-600 hover:text-primary-700 font-medium ml-1">Add one now</a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($taxRates->hasPages()): ?>
            <div class="px-4 py-3 border-t border-neutral-200">
                <?php echo e($taxRates->links()); ?>

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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/settings/tax-rates/index.blade.php ENDPATH**/ ?>