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

     <?php $__env->slot('title', null, []); ?> Edit <?php echo e($product->name); ?> <?php $__env->endSlot(); ?>

     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-sm">
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="text-neutral-500 hover:text-neutral-800 transition-colors">Products</a>
                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-neutral-900 font-semibold"><?php echo e($product->name); ?></span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_active): ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-600">Draft</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex items-center gap-2">
                <form action="<?php echo e(route('admin.products.duplicate', $product)); ?>" method="POST" style="display:inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-secondary text-sm">Duplicate</button>
                </form>
                <a href="<?php echo e(route('products.show', $product)); ?>" target="_blank" class="btn btn-secondary text-sm">
                    View
                </a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button" class="btn btn-secondary text-sm">
                        More actions
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-neutral-200 py-1 z-50">
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Back to products</a>
                    </div>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div x-data="productForm()" x-ref="productFormRoot">
        <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="flex gap-5" style="align-items: flex-start;">
                
                <div class="flex-1 space-y-5" style="min-width: 0;">

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Title</h2>
                        </div>
                        <div class="px-5 pb-5 space-y-4">
                            <div>
                                <label for="name" class="form-label form-label-required">Product name</label>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name', $product->name)); ?>" required
                                       class="form-input w-full <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       x-ref="productName"
                                       @input="if(!slugManual) slug = toSlug($event.target.value); autoGenerateSeo($event.target.value)">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" name="slug" id="slug" x-model="slug"
                                       class="form-input w-full <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       @input="slugManual = ($event.target.value.trim() !== '')">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label for="short_description" class="form-label">Short description</label>
                                <textarea name="short_description" id="short_description" rows="2"
                                          class="form-input w-full <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label for="description" class="form-label form-label-required">Description</label>
                                <textarea name="description" id="description" rows="6" required
                                          class="form-input w-full <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo old('description', $product->description); ?></textarea>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card overflow-hidden" x-data="imageManager()">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Media</h2>
                        </div>
                        <div class="px-5 pb-5 space-y-5">
                            
                            <div>
                                <label class="form-label">Main image (thumbnail)</label>
                                <p class="text-xs text-neutral-500 mb-3">This is the primary display image for the product.</p>
                                <div class="flex items-start gap-4">
                                    <?php $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first(); ?>
                                    
                                    <div class="relative w-32 h-32 rounded-lg overflow-hidden ring-2 ring-neutral-300 shrink-0"
                                         x-show="!mainImageChanged && !mainImageDeleted">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($primaryImage): ?>
                                            <img src="<?php echo e($primaryImage->url); ?>" class="w-full h-full object-cover">
                                            <span class="absolute bottom-0 left-0 right-0 px-2 py-1 bg-neutral-800 text-white text-center" style="font-size: 10px; font-weight: 600;">Main Image</span>
                                        <?php else: ?>
                                            <div class="w-full h-full bg-neutral-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    
                                    <div x-show="mainPreview" x-transition
                                         class="relative w-32 h-32 rounded-lg overflow-hidden ring-2 ring-neutral-300 shrink-0">
                                        <img :src="mainPreview" class="w-full h-full object-cover">
                                        <button type="button" @click="removeNewMainImage()"
                                                class="absolute top-1.5 right-1.5 w-6 h-6 bg-white/90 hover:bg-red-50 rounded-full flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                        <span class="absolute bottom-0 left-0 right-0 px-2 py-1 bg-neutral-800 text-white text-center" style="font-size: 10px; font-weight: 600;">New Main</span>
                                    </div>
                                    
                                    <div class="flex-1 border-2 border-dashed border-neutral-300 rounded-lg p-4 text-center hover:border-neutral-400 transition-colors cursor-pointer"
                                         @click="$refs.mainFileInput.click()"
                                         :class="{ 'border-blue-400 bg-blue-50/50': mainDragOver }"
                                         @dragover.prevent="mainDragOver = true"
                                         @dragleave.prevent="mainDragOver = false"
                                         @drop.prevent="mainDragOver = false; handleMainImage($event.dataTransfer.files[0])">
                                        <input type="file" name="main_image" accept="image/jpeg,image/jpg,image/png,image/webp,image/gif"
                                               x-ref="mainFileInput" class="hidden" @change="handleMainImage($event.target.files[0])">
                                        <div class="flex flex-col items-center py-2">
                                            <svg class="w-8 h-8 text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-sm font-medium text-neutral-700">Click to replace main image</p>
                                            <p class="text-xs text-neutral-500 mt-1">JPEG, PNG, WebP, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['main_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="border-t border-neutral-100"></div>

                            
                            <div>
                                <label class="form-label">Gallery images</label>

                                <?php $galleryImages = $product->images->where('id', '!=', $primaryImage?->id)->sortBy('position'); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryImages->count()): ?>
                                    <p class="text-xs text-neutral-500 mb-3">Current gallery images</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 mb-5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="relative group rounded-lg overflow-hidden ring-1 ring-neutral-200"
                                                 x-show="!deletedIds.includes(<?php echo e($image->id); ?>)">
                                                <img src="<?php echo e($image->url); ?>" alt="<?php echo e($image->alt_text); ?>" class="w-full aspect-square object-cover">
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors"></div>
                                                <button type="button" @click="markForDelete(<?php echo e($image->id); ?>)"
                                                        class="absolute top-1.5 right-1.5 w-6 h-6 bg-white/90 hover:bg-red-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" title="Delete">
                                                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <template x-for="id in deletedIds" :key="id">
                                    <input type="hidden" name="delete_images[]" :value="id">
                                </template>

                                <p class="text-xs text-neutral-500 mb-3">Add more gallery images. Max 10 images, 2MB each.</p>
                                <div class="border-2 border-dashed border-neutral-300 rounded-lg p-5 text-center hover:border-neutral-400 transition-colors cursor-pointer"
                                     @click="$refs.galleryInput.click()"
                                     @dragover.prevent="galleryDragOver = true"
                                     @dragleave.prevent="galleryDragOver = false"
                                     @drop.prevent="galleryDragOver = false; handleGalleryFiles($event.dataTransfer.files)"
                                     :class="{ 'border-blue-400 bg-blue-50/50': galleryDragOver }">
                                    <input type="file" name="images[]" multiple accept="image/jpeg,image/jpg,image/png,image/webp,image/gif"
                                           x-ref="galleryInput" class="hidden" @change="handleGalleryFiles($event.target.files)">
                                    <div class="flex flex-col items-center py-1">
                                        <svg class="w-7 h-7 text-neutral-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <p class="text-sm font-medium text-neutral-700">Click to upload or drag and drop</p>
                                        <p class="text-xs text-neutral-500 mt-1">JPEG, PNG, WebP, GIF up to 2MB</p>
                                    </div>
                                </div>

                                <div x-show="galleryPreviews.length > 0" x-transition class="mt-4">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                        <template x-for="(preview, index) in galleryPreviews" :key="index">
                                            <div class="relative group rounded-lg overflow-hidden ring-1 ring-neutral-200">
                                                <img :src="preview.url" class="w-full aspect-square object-cover">
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors"></div>
                                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-green-600 text-white rounded" style="font-size: 10px; font-weight: 600;">New</span>
                                                <button type="button" @click="removeGalleryImage(index)"
                                                        class="absolute top-1.5 right-1.5 w-6 h-6 bg-white/90 hover:bg-red-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                                <div class="absolute bottom-0 left-0 right-0 px-2 py-1 bg-black/50 text-white truncate" style="font-size: 10px;">
                                                    <span x-text="preview.name"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <p class="text-xs text-neutral-500 mt-2">
                                        <span x-text="galleryPreviews.length"></span> new image(s) to upload
                                    </p>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Pricing</h2>
                        </div>
                        <div class="px-5 pb-5">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="price" class="form-label form-label-required">Price</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 text-sm">$</span>
                                        <input type="number" name="price" id="price" value="<?php echo e(old('price', $product->price)); ?>" required
                                               step="0.01" min="0"
                                               class="form-input w-full pl-7 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="form-error"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label for="sale_price" class="form-label">Compare at price / MRP</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 text-sm">$</span>
                                        <input type="number" name="sale_price" id="sale_price" value="<?php echo e(old('sale_price', $product->sale_price)); ?>"
                                               step="0.01" min="0"
                                               class="form-input w-full pl-7 <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="form-error"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label for="cost_price" class="form-label">Cost price</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 text-sm">$</span>
                                        <input type="number" name="cost_price" id="cost_price" value="<?php echo e(old('cost_price', $product->cost_price)); ?>"
                                               step="0.01" min="0"
                                               class="form-input w-full pl-7 <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="form-error"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Inventory</h2>
                        </div>
                        <div class="px-5 pb-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="sku" class="form-label form-label-required">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" value="<?php echo e(old('sku', $product->sku)); ?>" required
                                           class="form-input w-full <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="form-error"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div>
                                    <label for="stock_quantity" class="form-label form-label-required">Stock quantity</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" value="<?php echo e(old('stock_quantity', $product->stock_quantity)); ?>" required
                                           min="0"
                                           class="form-input w-full <?php $__errorArgs = ['stock_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['stock_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="form-error"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attributes->count()): ?>
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Attributes</h2>
                            <p class="text-xs text-neutral-500 mt-0.5">Select applicable attributes for this product. Leave blank to skip.</p>
                        </div>
                        <div class="px-5 pb-5">
                            <?php $productAttrs = $product->attributes ?? []; ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div>
                                        <label class="form-label">
                                            <?php echo e($attribute->name); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($productAttrs[$attribute->name])): ?>
                                                <span class="inline-flex items-center justify-center w-1.5 h-1.5 rounded-full bg-green-500 ml-1"></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </label>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attribute->type === 'text'): ?>
                                            <input type="text" name="product_attributes[<?php echo e($attribute->name); ?>]"
                                                   value="<?php echo e(old('product_attributes.' . $attribute->name, $productAttrs[$attribute->name] ?? '')); ?>"
                                                   class="form-input w-full text-sm"
                                                   placeholder="Enter <?php echo e(strtolower($attribute->name)); ?>">
                                        <?php else: ?>
                                            <select name="product_attributes[<?php echo e($attribute->name); ?>]" class="form-input w-full text-sm">
                                                <option value="">-- Select --</option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attribute->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                    <option value="<?php echo e($value->value); ?>"
                                                            <?php echo e(old('product_attributes.' . $attribute->name, $productAttrs[$attribute->name] ?? '') === $value->value ? 'selected' : ''); ?>>
                                                        <?php echo e($value->value); ?>

                                                    </option>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </select>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attribute->type === 'color' && $attribute->values->count()): ?>
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $attribute->values->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($value->color_code): ?>
                                                            <div class="w-5 h-5 rounded-full border border-neutral-200 cursor-default <?php echo e(isset($productAttrs[$attribute->name]) && $productAttrs[$attribute->name] === $value->value ? 'ring-2 ring-neutral-800' : ''); ?>" style="background-color: <?php echo e($value->color_code); ?>" title="<?php echo e($value->value); ?>"></div>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4 flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-neutral-900">Search engine listing</h2>
                            <button type="button" @click="autoFillSeo()" class="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                Auto-generate
                            </button>
                        </div>
                        <div class="px-5 pb-5 space-y-4">
                            
                            <div class="border border-neutral-200 rounded-lg p-4 bg-neutral-50">
                                <p class="text-xs text-neutral-500 mb-2 font-medium">Search engine preview</p>
                                <div>
                                    <p class="text-blue-700 text-base font-medium truncate" style="font-family: Arial, sans-serif;" x-text="seoTitle || '<?php echo e(addslashes($product->meta_title ?: $product->name)); ?>'"></p>
                                    <p class="text-green-700 text-xs truncate mt-0.5" style="font-family: Arial, sans-serif;"><?php echo e(url('/')); ?>/product/<span x-text="slug || '<?php echo e($product->slug); ?>'"></span></p>
                                    <p class="text-neutral-600 text-xs mt-1 line-clamp-2" style="font-family: Arial, sans-serif;" x-text="seoDescription || '<?php echo e(addslashes($product->meta_description ?: Str::limit(strip_tags($product->description), 160))); ?>'"></p>
                                </div>
                            </div>

                            <div>
                                <label for="meta_title" class="form-label">Meta title</label>
                                <input type="text" name="meta_title" id="meta_title" value="<?php echo e(old('meta_title', $product->meta_title)); ?>"
                                       class="form-input w-full <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       x-model="seoTitle"
                                       maxlength="70">
                                <p class="text-xs text-neutral-400 mt-1"><span x-text="seoTitle ? seoTitle.length : 0"></span> / 70 characters</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div>
                                <label for="meta_description" class="form-label">Meta description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                          class="form-input w-full <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          x-model="seoDescription"
                                          maxlength="160"><?php echo e(old('meta_description', $product->meta_description)); ?></textarea>
                                <p class="text-xs text-neutral-400 mt-1"><span x-text="seoDescription ? seoDescription.length : 0"></span> / 160 characters</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>

                
                <div class="space-y-5" style="width: 340px; flex-shrink: 0;">

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Status</h2>
                        </div>
                        <div class="px-5 pb-5">
                            <select name="is_active" class="form-input w-full">
                                <option value="1" <?php echo e(old('is_active', $product->is_active) ? 'selected' : ''); ?>>Active</option>
                                <option value="0" <?php echo e(!old('is_active', $product->is_active) ? 'selected' : ''); ?>>Draft</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <h2 class="text-sm font-semibold text-neutral-900">Product organization</h2>
                        </div>
                        <div class="px-5 pb-5 space-y-4">
                            <div>
                                <label for="category_id" class="form-label form-label-required">Category</label>
                                <select name="category_id" id="category_id" required
                                        class="form-input w-full <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Select category</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label for="brand_id" class="form-label">Brand</label>
                                <select name="brand_id" id="brand_id"
                                        class="form-input w-full <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Select brand</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id', $product->brand_id) == $brand->id ? 'selected' : ''); ?>>
                                            <?php echo e($brand->name); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div>
                                <label for="seller_id" class="form-label">Seller</label>
                                <select name="seller_id" id="seller_id"
                                        class="form-input w-full <?php $__errorArgs = ['seller_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Select seller</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($seller->id); ?>" <?php echo e(old('seller_id', $product->seller_id) == $seller->id ? 'selected' : ''); ?>>
                                            <?php echo e($seller->store_name); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['seller_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="form-error"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="border-t border-neutral-100 pt-4">
                                <label class="form-label">Tags</label>
                                <p class="text-xs text-neutral-500">Coming soon</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card overflow-hidden">
                        <div class="px-5 py-4">
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>

                                       class="form-checkbox">
                                <span class="text-sm font-semibold text-neutral-900">Featured product</span>
                            </label>
                            <p class="text-xs text-neutral-500 mt-1 ml-6">Show this product in featured sections on the storefront.</p>
                        </div>
                    </div>

                </div>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($toppings) && $toppings->count()): ?>
            <?php
                $productToppingIds = $product->toppings->pluck('id')->toArray();
                $productDefaultIds = $product->toppings->where('pivot.is_default', true)->pluck('id')->toArray();
            ?>
            <div class="card overflow-hidden mt-5">
                <div class="px-5 py-4 border-b border-neutral-100">
                    <h2 class="text-base font-semibold text-neutral-900">Toppings</h2>
                    <p class="text-xs text-neutral-500 mt-0.5">Select available toppings and mark which are included by default</p>
                </div>
                <div class="px-5 py-4 space-y-2 max-h-72 overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $toppings->groupBy('group'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupToppings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="mb-3">
                            <p class="text-xs font-bold text-neutral-500 uppercase tracking-wider mb-1.5"><?php echo e(ucfirst($group)); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $groupToppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="flex items-center gap-3 py-1">
                                    <label class="flex items-center gap-2 cursor-pointer flex-1">
                                        <input type="checkbox" name="toppings[]" value="<?php echo e($topping->id); ?>"
                                               <?php echo e(in_array($topping->id, old('toppings', $productToppingIds)) ? 'checked' : ''); ?>

                                               class="form-checkbox">
                                        <span class="text-sm text-neutral-800"><?php echo e($topping->name); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topping->price > 0): ?>
                                            <span class="text-xs text-neutral-400">(+&pound;<?php echo e(number_format($topping->price, 2)); ?>)</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </label>
                                    <label class="flex items-center gap-1.5 cursor-pointer text-xs text-neutral-500">
                                        <input type="checkbox" name="default_toppings[]" value="<?php echo e($topping->id); ?>"
                                               <?php echo e(in_array($topping->id, old('default_toppings', $productDefaultIds)) ? 'checked' : ''); ?>

                                               class="form-checkbox">
                                        Default
                                    </label>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="sticky bottom-0 z-40 mt-5 -mx-6 px-6 py-3 bg-white border-t border-neutral-200 flex items-center justify-end gap-3" style="margin-left: -1.5rem; margin-right: -1.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Discard</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

        
        <div class="mt-8 card overflow-hidden" style="border-color: #fca5a5;">
            <div class="px-5 py-4">
                <h2 class="text-sm font-semibold text-red-700">Danger zone</h2>
            </div>
            <div class="px-5 pb-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-900">Delete this product</p>
                    <p class="text-xs text-neutral-500">Once deleted, this action cannot be undone.</p>
                </div>
                <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete &quot;<?php echo e($product->name); ?>&quot;? This cannot be undone.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete product</button>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .ck-editor__editable { min-height: 200px; }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { border-color: #d4d4d4; }
        .ck.ck-editor__main>.ck-editor__editable.ck-focused { border-color: var(--color-primary-500, #7c3aed); box-shadow: 0 0 0 1px var(--color-primary-500, #7c3aed); }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        function productForm() {
            return {
                slug: '<?php echo e(old("slug", $product->slug)); ?>',
                slugManual: true,
                seoTitle: '<?php echo e(addslashes(old("meta_title", $product->meta_title ?? ""))); ?>',
                seoDescription: '<?php echo e(addslashes(old("meta_description", $product->meta_description ?? ""))); ?>',
                seoManualTitle: <?php echo e(old('meta_title', $product->meta_title) ? 'true' : 'false'); ?>,
                seoManualDescription: <?php echo e(old('meta_description', $product->meta_description) ? 'true' : 'false'); ?>,
                toSlug(text) {
                    return text
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_]+/g, '-')
                        .replace(/-+/g, '-')
                        .replace(/^-+|-+$/g, '');
                },
                autoGenerateSeo(title) {
                    if (!this.seoManualTitle || this.seoTitle === '') {
                        this.seoTitle = title ? (title + ' - <?php echo e(addslashes(config("app.name"))); ?>').substring(0, 70) : '';
                        this.seoManualTitle = false;
                    }
                    if (!this.seoManualDescription || this.seoDescription === '') {
                        this.seoDescription = title ? ('Shop ' + title + ' at <?php echo e(addslashes(config("app.name"))); ?>. Great prices, fast shipping, and quality guaranteed.').substring(0, 160) : '';
                        this.seoManualDescription = false;
                    }
                },
                autoFillSeo() {
                    var titleEl = document.getElementById('name');
                    var title = titleEl ? titleEl.value : '';
                    if (!title) {
                        if (typeof toastr !== 'undefined') toastr.warning('Enter a product name first.');
                        return;
                    }
                    this.seoTitle = (title + ' - <?php echo e(addslashes(config("app.name"))); ?>').substring(0, 70);
                    this.seoDescription = ('Shop ' + title + ' at <?php echo e(addslashes(config("app.name"))); ?>. Great prices, fast shipping, and quality guaranteed.').substring(0, 160);
                    this.seoManualTitle = false;
                    this.seoManualDescription = false;
                }
            };
        }

        function imageManager() {
            return {
                deletedIds: [],
                mainPreview: null,
                mainImageChanged: false,
                mainImageDeleted: false,
                mainDragOver: false,
                galleryPreviews: [],
                galleryDragOver: false,
                galleryFileList: new DataTransfer(),
                handleMainImage(file) {
                    if (!file || !file.type.startsWith('image/')) return;
                    if (file.size > 2 * 1024 * 1024) {
                        toastr.error(file.name + ' exceeds 2MB limit.');
                        return;
                    }
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    this.$refs.mainFileInput.files = dt.files;
                    this.mainImageChanged = true;
                    const reader = new FileReader();
                    reader.onload = (e) => { this.mainPreview = e.target.result; };
                    reader.readAsDataURL(file);
                },
                removeNewMainImage() {
                    this.mainPreview = null;
                    this.mainImageChanged = false;
                    this.$refs.mainFileInput.value = '';
                },
                markForDelete(id) {
                    if (!confirm('Mark this image for deletion?')) return;
                    this.deletedIds.push(id);
                },
                handleGalleryFiles(files) {
                    for (const file of files) {
                        if (!file.type.startsWith('image/')) continue;
                        if (file.size > 2 * 1024 * 1024) {
                            toastr.error(file.name + ' exceeds 2MB limit.');
                            continue;
                        }
                        if (this.galleryPreviews.length >= 10) {
                            toastr.error('Maximum 10 gallery images.');
                            break;
                        }
                        this.galleryFileList.items.add(file);
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.galleryPreviews.push({ url: e.target.result, name: file.name });
                        };
                        reader.readAsDataURL(file);
                    }
                    this.$refs.galleryInput.files = this.galleryFileList.files;
                },
                removeGalleryImage(index) {
                    this.galleryPreviews.splice(index, 1);
                    this.galleryFileList.items.remove(index);
                    this.$refs.galleryInput.files = this.galleryFileList.files;
                }
            };
        }

        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList', '|', 'link', 'blockQuote', '|', 'undo', 'redo'],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                }
            })
            .catch(error => console.error(error));
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>