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

     <?php $__env->slot('title', null, []); ?> SEO Settings <?php $__env->endSlot(); ?>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-neutral-900">Settings</h1>
        <p class="text-neutral-600">Manage your store configuration</p>
    </div>

    <!-- Settings Navigation -->
    <?php echo $__env->make('admin.settings.partials.nav', ['active' => 'seo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <form action="<?php echo e(route('admin.settings.seo.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Meta Tags -->
            <div class="card">
                <div class="px-5 py-3.5 border-b border-neutral-200">
                    <h2 class="text-sm font-semibold text-neutral-900">Default Meta Tags</h2>
                    <p class="text-xs text-neutral-600">Used when pages don't have specific meta tags</p>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" value="<?php echo e(old('meta_title', $settings['meta_title'] ?? '')); ?>" maxlength="70" class="form-input">
                        <p class="text-xs text-neutral-600 mt-1">Max 70 characters</p>
                    </div>

                    <div>
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" rows="3" maxlength="160" class="form-textarea"><?php echo e(old('meta_description', $settings['meta_description'] ?? '')); ?></textarea>
                        <p class="text-xs text-neutral-600 mt-1">Max 160 characters</p>
                    </div>

                    <div>
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="<?php echo e(old('meta_keywords', $settings['meta_keywords'] ?? '')); ?>" placeholder="keyword1, keyword2, keyword3" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Open Graph Image URL</label>
                        <input type="text" name="og_image" value="<?php echo e(old('og_image', $settings['og_image'] ?? '')); ?>" placeholder="https://example.com/og-image.jpg" class="form-input">
                        <p class="text-xs text-neutral-600 mt-1">Recommended size: 1200x630 pixels</p>
                    </div>
                </div>
            </div>

            <!-- Analytics & Tracking -->
            <div class="space-y-6">
                <div class="card">
                    <div class="px-5 py-3.5 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Analytics & Tracking</h2>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="form-label">Google Analytics ID</label>
                            <input type="text" name="google_analytics_id" value="<?php echo e(old('google_analytics_id', $settings['google_analytics_id'] ?? '')); ?>" placeholder="G-XXXXXXXXXX" class="form-input">
                        </div>

                        <div>
                            <label class="form-label">Google Tag Manager ID</label>
                            <input type="text" name="google_tag_manager_id" value="<?php echo e(old('google_tag_manager_id', $settings['google_tag_manager_id'] ?? '')); ?>" placeholder="GTM-XXXXXXX" class="form-input">
                        </div>

                        <div>
                            <label class="form-label">Facebook Pixel ID</label>
                            <input type="text" name="facebook_pixel_id" value="<?php echo e(old('facebook_pixel_id', $settings['facebook_pixel_id'] ?? '')); ?>" placeholder="XXXXXXXXXXXXXXXX" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="px-5 py-3.5 border-b border-neutral-200">
                        <h2 class="text-sm font-semibold text-neutral-900">Robots.txt</h2>
                    </div>
                    <div class="p-5">
                        <textarea name="robots_txt" rows="8" class="form-textarea font-mono" placeholder="User-agent: *
Allow: /
Disallow: /admin/
Disallow: /account/"><?php echo e(old('robots_txt', $settings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /account/")); ?></textarea>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/settings/seo.blade.php ENDPATH**/ ?>