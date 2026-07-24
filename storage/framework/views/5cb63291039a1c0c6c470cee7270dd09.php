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

     <?php $__env->slot('title', null, []); ?> General Settings <?php $__env->endSlot(); ?>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-neutral-900">Settings</h1>
        <p class="text-neutral-600">Manage your store configuration</p>
    </div>

    <!-- Settings Navigation -->
    <?php echo $__env->make('admin.settings.partials.nav', ['active' => 'general'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form action="<?php echo e(route('admin.settings.general.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Store Information -->
            <div class="card">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Store Information</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label form-label-required">Site Name</label>
                        <input type="text" name="site_name" value="<?php echo e(old('site_name', $settings['site_name'] ?? '')); ?>" required class="form-input">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label">Tagline</label>
                        <input type="text" name="site_tagline" value="<?php echo e(old('site_tagline', $settings['site_tagline'] ?? '')); ?>" class="form-input">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['site_tagline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label form-label-required">Email Address</label>
                        <input type="email" name="site_email" value="<?php echo e(old('site_email', $settings['site_email'] ?? '')); ?>" required class="form-input">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['site_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="site_phone" value="<?php echo e(old('site_phone', $settings['site_phone'] ?? '')); ?>" class="form-input">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['site_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="form-label">Address</label>
                        <textarea name="site_address" rows="3" class="form-textarea"><?php echo e(old('site_address', $settings['site_address'] ?? '')); ?></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['site_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="form-error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Regional Settings -->
            <div class="card">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Regional Settings</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label form-label-required">Timezone</label>
                        <select name="timezone" required class="form-select">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($tz); ?>" <?php if(($settings['timezone'] ?? 'UTC') === $tz): echo 'selected'; endif; ?>><?php echo e($tz); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label form-label-required">Date Format</label>
                        <select name="date_format" required class="form-select">
                            <option value="M d, Y" <?php if(($settings['date_format'] ?? 'M d, Y') === 'M d, Y'): echo 'selected'; endif; ?>><?php echo e(now()->format('M d, Y')); ?></option>
                            <option value="d/m/Y" <?php if(($settings['date_format'] ?? '') === 'd/m/Y'): echo 'selected'; endif; ?>><?php echo e(now()->format('d/m/Y')); ?></option>
                            <option value="m/d/Y" <?php if(($settings['date_format'] ?? '') === 'm/d/Y'): echo 'selected'; endif; ?>><?php echo e(now()->format('m/d/Y')); ?></option>
                            <option value="Y-m-d" <?php if(($settings['date_format'] ?? '') === 'Y-m-d'): echo 'selected'; endif; ?>><?php echo e(now()->format('Y-m-d')); ?></option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label form-label-required">Currency</label>
                        <select name="currency" required class="form-select">
                            <option value="USD" <?php if(($settings['currency'] ?? 'USD') === 'USD'): echo 'selected'; endif; ?>>USD - US Dollar</option>
                            <option value="EUR" <?php if(($settings['currency'] ?? '') === 'EUR'): echo 'selected'; endif; ?>>EUR - Euro</option>
                            <option value="GBP" <?php if(($settings['currency'] ?? '') === 'GBP'): echo 'selected'; endif; ?>>GBP - British Pound</option>
                            <option value="INR" <?php if(($settings['currency'] ?? '') === 'INR'): echo 'selected'; endif; ?>>INR - Indian Rupee</option>
                            <option value="CAD" <?php if(($settings['currency'] ?? '') === 'CAD'): echo 'selected'; endif; ?>>CAD - Canadian Dollar</option>
                            <option value="AUD" <?php if(($settings['currency'] ?? '') === 'AUD'): echo 'selected'; endif; ?>>AUD - Australian Dollar</option>
                            <option value="JPY" <?php if(($settings['currency'] ?? '') === 'JPY'): echo 'selected'; endif; ?>>JPY - Japanese Yen</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label form-label-required">Currency Symbol</label>
                        <input type="text" name="currency_symbol" value="<?php echo e(old('currency_symbol', $settings['currency_symbol'] ?? '$')); ?>" required maxlength="5" class="form-input" placeholder="e.g. $, €, £, £, ¥">
                        <p class="text-xs text-neutral-600 mt-1">The symbol displayed with prices (e.g. $, €, £, £, ¥)</p>
                    </div>
                    <div>
                        <label class="form-label form-label-required">Currency Position</label>
                        <select name="currency_position" required class="form-select">
                            <option value="before" <?php if(($settings['currency_position'] ?? 'before') === 'before'): echo 'selected'; endif; ?>>Before amount ($99.99)</option>
                            <option value="after" <?php if(($settings['currency_position'] ?? '') === 'after'): echo 'selected'; endif; ?>>After amount (99.99$)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/settings/general.blade.php ENDPATH**/ ?>