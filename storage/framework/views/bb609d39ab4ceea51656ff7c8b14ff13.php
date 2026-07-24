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

     <?php $__env->slot('title', null, []); ?> Pages <?php $__env->endSlot(); ?>

     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <h1 style="font-size:20px;font-weight:600;color:#1a1a1a;line-height:1.2">Pages</h1>
            <a href="<?php echo e(route('admin.pages.create')); ?>"
               style="background:#1a1a1a;border:1px solid #1a1a1a;color:#fff;font-size:13px;font-weight:500;padding:6px 12px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center"
               onmouseover="this.style.background='#333'" onmouseout="this.style.background='#1a1a1a'">
                Add page
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <?php
        $currentStatus = request('status', '');
        $pageIds = $pages->pluck('id')->toArray();
    ?>

    <div style="background:#fff;border-radius:12px;box-shadow:0 1px 2px rgba(0,0,0,0.06),0 1px 3px rgba(0,0,0,0.1);overflow:hidden"
         x-data="{
             selected: [],
             toggleAll(checked) {
                 this.selected = checked ? <?php echo e(json_encode($pageIds)); ?> : [];
             },
             toggle(id) {
                 const idx = this.selected.indexOf(id);
                 idx === -1 ? this.selected.push(id) : this.selected.splice(idx, 1);
             },
             get allChecked() {
                 return this.selected.length === <?php echo e(count($pageIds)); ?> && <?php echo e(count($pageIds)); ?> > 0;
             }
         }">

        
        <div class="flex items-center justify-between" style="border-bottom:1px solid #e1e1e1;padding:0 12px">
            <div class="flex items-center gap-0">
                <?php
                    $tabs = [
                        '' => 'All',
                        'published' => 'Published',
                        'draft' => 'Draft',
                    ];
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e(route('admin.pages.index', array_merge(request()->except('status', 'page'), $statusKey ? ['status' => $statusKey] : []))); ?>"
                       style="padding:10px 12px;font-size:13px;font-weight:500;text-decoration:none;position:relative;<?php echo e($currentStatus === $statusKey ? 'color:#1a1a1a;' : 'color:#616161;'); ?>"
                       onmouseover="this.style.color='#1a1a1a'" onmouseout="this.style.color='<?php echo e($currentStatus === $statusKey ? '#1a1a1a' : '#616161'); ?>'">
                        <?php echo e($label); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStatus === $statusKey): ?>
                            <span style="position:absolute;bottom:-1px;left:12px;right:12px;height:2px;background:#1a1a1a;border-radius:1px"></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <div class="flex items-center gap-2" style="padding:12px;border-bottom:1px solid #e1e1e1">
            <form action="<?php echo e(route('admin.pages.index')); ?>" method="GET" class="flex items-center gap-2 flex-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status')): ?>
                    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex-1 relative">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="#8a8a8a" style="position:absolute;left:10px;top:50%;transform:translateY(-50%)"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Filter pages"
                           style="width:100%;padding:7px 10px 7px 32px;font-size:13px;border:1px solid #c9c9c9;border-radius:8px;outline:none;color:#1a1a1a;background:#fff"
                           onfocus="this.style.borderColor='#005bd3';this.style.boxShadow='0 0 0 1px #005bd3'" onblur="this.style.borderColor='#c9c9c9';this.style.boxShadow='none'">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search'])): ?>
                    <a href="<?php echo e(route('admin.pages.index', request('status') ? ['status' => request('status')] : [])); ?>"
                       style="padding:7px 12px;font-size:13px;color:#323232;text-decoration:none;white-space:nowrap">
                        Clear filters
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>
        </div>

        
        <div x-show="selected.length > 0" x-cloak
             style="padding:8px 12px;background:#f3f3f3;border-bottom:1px solid #e1e1e1" class="flex items-center gap-3">
            <span style="font-size:13px;font-weight:500;color:#323232">
                <span x-text="selected.length"></span> selected
            </span>
        </div>

        
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse">
                <thead>
                    <tr style="border-bottom:1px solid #e1e1e1">
                        <th style="padding:8px 8px 8px 12px;width:36px;text-align:center">
                            <input type="checkbox"
                                   style="width:16px;height:16px;cursor:pointer;accent-color:#1a1a1a"
                                   @change="toggleAll($event.target.checked)"
                                   :checked="allChecked">
                        </th>
                        <th style="padding:8px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Title</th>
                        <th style="padding:8px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Slug</th>
                        <th style="padding:8px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Status</th>
                        <th style="padding:8px 12px;text-align:left;font-size:12px;font-weight:500;color:#616161">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr style="border-bottom:1px solid #f1f1f1;cursor:pointer"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='#fff'"
                            onclick="if(!event.target.closest('input[type=checkbox]')) window.location='<?php echo e(route('admin.pages.edit', $page)); ?>'">
                            <td style="padding:8px 8px 8px 12px;width:36px;text-align:center" onclick="event.stopPropagation()">
                                <input type="checkbox"
                                       style="width:16px;height:16px;cursor:pointer;accent-color:#1a1a1a"
                                       :checked="selected.includes(<?php echo e($page->id); ?>)"
                                       @change="toggle(<?php echo e($page->id); ?>)">
                            </td>
                            <td style="padding:8px 12px">
                                <span style="font-size:13px;font-weight:500;color:#1a1a1a"><?php echo e($page->title); ?></span>
                            </td>
                            <td style="padding:8px 12px">
                                <span style="font-size:13px;color:#616161;font-family:monospace">/<?php echo e($page->slug); ?></span>
                            </td>
                            <td style="padding:8px 12px">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page->is_published): ?>
                                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:12px;font-weight:500;background:#c8f9d4;color:#1a7f37">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#1a7f37;display:inline-block"></span>
                                        Published
                                    </span>
                                <?php else: ?>
                                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:12px;font-weight:500;background:#e4e4e4;color:#616161">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#8a8a8a;display:inline-block"></span>
                                        Draft
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td style="padding:8px 12px;font-size:13px;color:#323232">
                                <?php echo e($page->updated_at ? $page->updated_at->format('M d, Y') : '--'); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" style="padding:48px 12px;text-align:center">
                                <div class="flex flex-col items-center">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#c9c9c9" stroke-width="1.5" style="margin-bottom:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p style="font-size:14px;font-weight:500;color:#1a1a1a;margin-bottom:4px">No pages found</p>
                                    <p style="font-size:13px;color:#616161;margin-bottom:16px">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search', 'status'])): ?>
                                            Try changing the filters or search term.
                                        <?php else: ?>
                                            Create pages for your store like About Us or Contact.
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!request()->hasAny(['search', 'status'])): ?>
                                        <a href="<?php echo e(route('admin.pages.create')); ?>"
                                           style="background:#1a1a1a;color:#fff;font-size:13px;font-weight:500;padding:7px 14px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center">
                                            Add page
                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pages->total() > 0): ?>
            <div class="flex items-center justify-center gap-4" style="padding:12px;border-top:1px solid #e1e1e1">
                <div class="flex items-center gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pages->onFirstPage()): ?>
                        <span style="padding:6px;color:#c9c9c9;cursor:not-allowed">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($pages->previousPageUrl()); ?>" style="padding:6px;color:#616161;text-decoration:none;border-radius:6px;display:inline-flex" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <span style="font-size:13px;color:#323232">
                        <?php echo e($pages->firstItem()); ?>-<?php echo e($pages->lastItem()); ?> of <?php echo e($pages->total()); ?>

                    </span>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pages->hasMorePages()): ?>
                        <a href="<?php echo e($pages->nextPageUrl()); ?>" style="padding:6px;color:#616161;text-decoration:none;border-radius:6px;display:inline-flex" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    <?php else: ?>
                        <span style="padding:6px;color:#c9c9c9;cursor:not-allowed">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </span>
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/pages/index.blade.php ENDPATH**/ ?>