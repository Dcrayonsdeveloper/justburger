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

     <?php $__env->slot('title', null, []); ?> Delivery Dashboard <?php $__env->endSlot(); ?>

    <div class="flex items-center justify-between mb-5">
        <h1 class="text-xl font-semibold text-gray-900">Delivery Dashboard</h1>
        <div class="flex gap-2">
            <form action="<?php echo e(route('admin.delivery.pickup')); ?>" method="POST" class="inline" x-data>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="package_count" value="<?php echo e($stats['pending']); ?>">
                <button type="submit" class="btn btn-outline text-sm">Request Pickup</button>
            </form>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg"><?php echo e(session('error')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <div class="text-2xl font-bold text-amber-600"><?php echo e($stats['pending']); ?></div>
            <div class="text-xs text-gray-600">Pending Booking</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <div class="text-2xl font-bold text-blue-600"><?php echo e($stats['shipped']); ?></div>
            <div class="text-xs text-gray-600">In Transit</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <div class="text-2xl font-bold text-purple-600"><?php echo e($stats['out_for_delivery']); ?></div>
            <div class="text-xs text-gray-600">Out for Delivery</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <div class="text-2xl font-bold text-green-600"><?php echo e($stats['delivered']); ?></div>
            <div class="text-xs text-gray-600">Delivered (7d)</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <div class="text-2xl font-bold text-red-600"><?php echo e($stats['rto']); ?></div>
            <div class="text-xs text-gray-600">RTO (30d)</div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($analytics)): ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs text-gray-500 mb-1">Total Shipped (30d)</div>
            <div class="text-xl font-bold text-gray-900"><?php echo e($analytics['total_shipped']); ?></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs text-gray-500 mb-1">Delivery Rate</div>
            <div class="text-xl font-bold <?php echo e($analytics['delivery_rate'] >= 90 ? 'text-green-600' : ($analytics['delivery_rate'] >= 75 ? 'text-amber-600' : 'text-red-600')); ?>"><?php echo e($analytics['delivery_rate']); ?>%</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs text-gray-500 mb-1">RTO Rate</div>
            <div class="text-xl font-bold <?php echo e($analytics['rto_rate'] <= 5 ? 'text-green-600' : ($analytics['rto_rate'] <= 15 ? 'text-amber-600' : 'text-red-600')); ?>"><?php echo e($analytics['rto_rate']); ?>%</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs text-gray-500 mb-1">Avg Delivery Days</div>
            <div class="text-xl font-bold text-gray-900"><?php echo e(round($analytics['avg_delivery_days'], 1)); ?></div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6" x-data="pincodeChecker()">
        <h2 class="font-semibold text-gray-900 mb-3">Pincode Serviceability & Cost Calculator</h2>
        <div class="flex gap-3 items-end">
            <div>
                <label class="text-xs font-medium text-gray-600">Delivery Pincode</label>
                <input type="text" x-model="pincode" maxlength="6" class="form-input w-40" placeholder="110001" @keyup.enter="check()">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">Weight (grams)</label>
                <input type="number" x-model="weight" class="form-input w-28" value="500">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">Payment</label>
                <select x-model="paymentType" class="form-select w-32">
                    <option value="Pre-paid">Prepaid</option>
                    <option value="COD">COD</option>
                </select>
            </div>
            <button @click="check()" class="btn btn-primary text-sm" :disabled="loading">
                <span x-show="!loading">Check</span>
                <span x-show="loading">Checking...</span>
            </button>
        </div>

        <div x-show="result" x-cloak class="mt-3 p-3 rounded-lg" :class="result?.serviceable ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'">
            <template x-if="result?.serviceable">
                <div class="text-sm">
                    <p class="font-medium text-green-700">Serviceable - <span x-text="result.city"></span>, <span x-text="result.state_code"></span></p>
                    <div class="flex gap-4 mt-1 text-xs text-gray-600">
                        <span>COD: <span x-text="result.cod ? 'Yes' : 'No'" :class="result.cod ? 'text-green-600 font-medium' : 'text-red-600'"></span></span>
                        <span>Prepaid: <span x-text="result.prepaid ? 'Yes' : 'No'" :class="result.prepaid ? 'text-green-600 font-medium' : 'text-red-600'"></span></span>
                        <span x-show="result.zone">Zone: <span x-text="result.zone" class="font-medium"></span></span>
                        <span x-show="result.estimated_cost">Est. Cost: <span x-text="'£' + result.estimated_cost" class="font-bold text-gray-900"></span></span>
                    </div>
                </div>
            </template>
            <template x-if="result && !result.serviceable">
                <p class="text-sm text-red-700" x-text="result.message || 'Not serviceable'"></p>
            </template>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="font-semibold text-gray-900">Ready to Ship (<?php echo e($stats['pending']); ?>)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Order</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Items</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Payment</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($order->order_number); ?></a>
                        </td>
                        <td class="px-4 py-2 text-gray-700"><?php echo e($order->customer_name ?? $order->user?->full_name ?? 'Guest'); ?></td>
                        <td class="px-4 py-2 text-gray-600"><?php echo e($order->items->count()); ?> item(s)</td>
                        <td class="px-4 py-2 font-medium"><?php echo format_price($order->total); ?></td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full <?php echo e($order->payment_method === 'cod' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700'); ?>">
                                <?php echo e(strtoupper($order->payment_method)); ?>

                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-500 text-xs"><?php echo e($order->created_at->format('M d, h:i A')); ?></td>
                        <td class="px-4 py-2 text-right">
                            <form action="<?php echo e(route('admin.delivery.book', $order)); ?>" method="POST" class="inline" onsubmit="return confirm('Book Delhivery shipment for <?php echo e($order->order_number); ?>?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25"/></svg>
                                    Book Delivery
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No orders pending shipment</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-4 py-3 border-b border-gray-200">
            <h2 class="font-semibold text-gray-900">In Transit (<?php echo e($stats['shipped'] + $stats['out_for_delivery']); ?>)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left">Order</th>
                        <th class="px-4 py-2 text-left">AWB</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Shipped</th>
                        <th class="px-4 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $shippedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50" x-data="{ tracking: null, showTracking: false }">
                        <td class="px-4 py-2">
                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($order->order_number); ?></a>
                        </td>
                        <td class="px-4 py-2 font-mono text-xs text-gray-700"><?php echo e($order->tracking_number); ?></td>
                        <td class="px-4 py-2 text-gray-700"><?php echo e($order->customer_name ?? $order->user?->full_name ?? 'Guest'); ?></td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full <?php echo e($order->status === 'shipped' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-500 text-xs"><?php echo e($order->shipped_at?->format('M d') ?? '-'); ?></td>
                        <td class="px-4 py-2 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="fetch('<?php echo e(route('admin.delivery.track', $order)); ?>').then(r=>r.json()).then(d=>{tracking=d;showTracking=true})"
                                        class="text-xs text-blue-600 hover:underline">Track</button>
                                <a href="<?php echo e(route('admin.delivery.label', $order)); ?>" class="text-xs text-gray-600 hover:underline">Label</a>
                                <form action="<?php echo e(route('admin.delivery.cancel', $order)); ?>" method="POST" class="inline" onsubmit="return confirm('Cancel this shipment?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Cancel</button>
                                </form>
                            </div>
                            
                            <div x-show="showTracking" x-cloak class="mt-2 text-left p-3 bg-gray-50 rounded-lg text-xs">
                                <template x-if="tracking?.success">
                                    <div>
                                        <p class="font-medium" x-text="'Status: ' + tracking.status"></p>
                                        <p class="text-gray-500" x-text="'Location: ' + tracking.status_location"></p>
                                        <p x-show="tracking.expected_date" class="text-gray-500" x-text="'Expected: ' + tracking.expected_date"></p>
                                        <template x-if="tracking.scans?.length">
                                            <div class="mt-2 space-y-1 max-h-40 overflow-y-auto">
                                                <template x-for="scan in tracking.scans" :key="scan.datetime">
                                                    <div class="flex gap-2">
                                                        <span class="text-gray-400 whitespace-nowrap" x-text="scan.datetime"></span>
                                                        <span x-text="scan.status + ' - ' + scan.location"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="tracking && !tracking.success">
                                    <p class="text-red-600" x-text="tracking.message"></p>
                                </template>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No shipments in transit</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
    function pincodeChecker() {
        return {
            pincode: '', weight: 500, paymentType: 'Pre-paid', loading: false, result: null,
            async check() {
                if (this.pincode.length !== 6) return;
                this.loading = true;
                try {
                    const res = await fetch(`<?php echo e(route('admin.delivery.check-pincode')); ?>?pincode=${this.pincode}&weight=${this.weight}&payment_type=${this.paymentType}`);
                    this.result = await res.json();
                } catch(e) { this.result = { serviceable: false, message: 'Error' }; }
                this.loading = false;
            }
        };
    }
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/delivery/index.blade.php ENDPATH**/ ?>