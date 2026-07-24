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

     <?php $__env->slot('title', null, []); ?> Tax Settings <?php $__env->endSlot(); ?>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-neutral-900">Settings</h1>
        <p class="text-neutral-600">Manage your store configuration</p>
    </div>

    <!-- Settings Navigation -->
    <?php echo $__env->make('admin.settings.partials.nav', ['active' => 'tax'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form action="<?php echo e(route('admin.settings.tax.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tax Options -->
            <div class="card">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Tax Options</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-900">Enable Taxes</p>
                            <p class="text-xs text-neutral-600">Calculate and apply taxes to orders</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="tax_enabled" value="1" <?php if($settings['tax_enabled'] ?? true): echo 'checked'; endif; ?> class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <div>
                        <label class="form-label">Prices Entered With Tax</label>
                        <select name="tax_calculation" class="form-select">
                            <option value="exclusive" <?php if(($settings['tax_calculation'] ?? 'exclusive') === 'exclusive'): echo 'selected'; endif; ?>>No, I will enter prices exclusive of tax</option>
                            <option value="inclusive" <?php if(($settings['tax_calculation'] ?? '') === 'inclusive'): echo 'selected'; endif; ?>>Yes, I will enter prices inclusive of tax</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Calculate Tax Based On</label>
                        <select name="tax_based_on" class="form-select">
                            <option value="shipping" <?php if(($settings['tax_based_on'] ?? 'shipping') === 'shipping'): echo 'selected'; endif; ?>>Customer shipping address</option>
                            <option value="billing" <?php if(($settings['tax_based_on'] ?? '') === 'billing'): echo 'selected'; endif; ?>>Customer billing address</option>
                            <option value="store" <?php if(($settings['tax_based_on'] ?? '') === 'store'): echo 'selected'; endif; ?>>Shop base address</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-neutral-900">Round Tax at Subtotal</p>
                            <p class="text-xs text-neutral-600">Round tax at subtotal level instead of per line</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="tax_round_at_subtotal" value="1" <?php if($settings['tax_round_at_subtotal'] ?? false): echo 'checked'; endif; ?> class="sr-only peer">
                            <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Display Options -->
            <div class="card h-fit">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Display Options</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label">Display Prices in Cart</label>
                        <select name="tax_display_cart" class="form-select">
                            <option value="excluding" <?php if(($settings['tax_display_cart'] ?? 'excluding') === 'excluding'): echo 'selected'; endif; ?>>Excluding tax</option>
                            <option value="including" <?php if(($settings['tax_display_cart'] ?? '') === 'including'): echo 'selected'; endif; ?>>Including tax</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Display Prices During Checkout</label>
                        <select name="tax_display_checkout" class="form-select">
                            <option value="excluding" <?php if(($settings['tax_display_checkout'] ?? 'excluding') === 'excluding'): echo 'selected'; endif; ?>>Excluding tax</option>
                            <option value="including" <?php if(($settings['tax_display_checkout'] ?? '') === 'including'): echo 'selected'; endif; ?>>Including tax</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>

    <!-- Tax Rates Link -->
    <div class="mt-6 card px-5 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-neutral-900">Tax Rates</h3>
                <p class="text-xs text-neutral-600">Configure tax rates by region</p>
            </div>
            <a href="<?php echo e(route('admin.settings.tax-rates.index')); ?>" class="btn btn-secondary">
                Manage Tax Rates
            </a>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/settings/tax.blade.php ENDPATH**/ ?>