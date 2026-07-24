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

     <?php $__env->slot('title', null, []); ?> Email Settings <?php $__env->endSlot(); ?>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-neutral-900">Settings</h1>
        <p class="text-neutral-600">Manage your store configuration</p>
    </div>

    <!-- Settings Navigation -->
    <?php echo $__env->make('admin.settings.partials.nav', ['active' => 'email'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form action="<?php echo e(route('admin.settings.email.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- SMTP Configuration -->
            <div class="card">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Mail Configuration</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label form-label-required">Mail Driver</label>
                        <select name="mail_driver" required class="form-select">
                            <option value="smtp" <?php if(($settings['mail_driver'] ?? 'smtp') === 'smtp'): echo 'selected'; endif; ?>>SMTP</option>
                            <option value="sendmail" <?php if(($settings['mail_driver'] ?? '') === 'sendmail'): echo 'selected'; endif; ?>>Sendmail</option>
                            <option value="mailgun" <?php if(($settings['mail_driver'] ?? '') === 'mailgun'): echo 'selected'; endif; ?>>Mailgun</option>
                            <option value="ses" <?php if(($settings['mail_driver'] ?? '') === 'ses'): echo 'selected'; endif; ?>>Amazon SES</option>
                            <option value="postmark" <?php if(($settings['mail_driver'] ?? '') === 'postmark'): echo 'selected'; endif; ?>>Postmark</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="mail_host" value="<?php echo e(old('mail_host', $settings['mail_host'] ?? '')); ?>" placeholder="smtp.example.com" class="form-input">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Port</label>
                            <input type="number" name="mail_port" value="<?php echo e(old('mail_port', $settings['mail_port'] ?? '587')); ?>" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Encryption</label>
                            <select name="mail_encryption" class="form-select">
                                <option value="">None</option>
                                <option value="tls" <?php if(($settings['mail_encryption'] ?? 'tls') === 'tls'): echo 'selected'; endif; ?>>TLS</option>
                                <option value="ssl" <?php if(($settings['mail_encryption'] ?? '') === 'ssl'): echo 'selected'; endif; ?>>SSL</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Username</label>
                        <input type="text" name="mail_username" value="<?php echo e(old('mail_username', $settings['mail_username'] ?? '')); ?>" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="mail_password" value="" placeholder="<?php echo e(!empty($settings['mail_password']) ? '••••••••••••' : 'Enter password'); ?>" class="form-input">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings['mail_password'])): ?>
                            <p class="text-xs text-neutral-600 mt-1">Password is saved. Leave blank to keep current value.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- From Address -->
            <div class="card h-fit">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Sender Details</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label form-label-required">From Email</label>
                        <input type="email" name="mail_from_address" value="<?php echo e(old('mail_from_address', $settings['mail_from_address'] ?? '')); ?>" required placeholder="noreply@example.com" class="form-input">
                    </div>

                    <div>
                        <label class="form-label form-label-required">From Name</label>
                        <input type="text" name="mail_from_name" value="<?php echo e(old('mail_from_name', $settings['mail_from_name'] ?? '')); ?>" required placeholder="Your Store Name" class="form-input">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" class="btn btn-secondary" onclick="testEmail()">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Send Test Email
            </button>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>

    <script>
        function testEmail() {
            alert('Test email functionality would send a test email to the admin.');
        }
    </script>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/settings/email.blade.php ENDPATH**/ ?>