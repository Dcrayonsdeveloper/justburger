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

     <?php $__env->slot('title', null, []); ?> Dashboard <?php $__env->endSlot(); ?>

     <?php $__env->slot('header', null, []); ?> 
        <h1 class="text-xl font-semibold text-neutral-900">Home</h1>
     <?php $__env->endSlot(); ?>

    
    <div class="flex items-center gap-2 mb-5" x-data>
        <form method="GET" action="<?php echo e(route('admin.dashboard')); ?>" x-ref="filterForm" class="flex items-center gap-2">
            <input type="hidden" name="start_date" x-ref="startDate" value="<?php echo e(request('start_date')); ?>">
            <input type="hidden" name="end_date" x-ref="endDate" value="<?php echo e(request('end_date')); ?>">
            <?php
                $isToday = request('start_date') == today()->format('Y-m-d') && request('end_date') == today()->format('Y-m-d');
                $is7d = request('start_date') == now()->subDays(6)->format('Y-m-d') && request('end_date') == today()->format('Y-m-d');
                $is30d = request('start_date') == now()->subDays(29)->format('Y-m-d') && request('end_date') == today()->format('Y-m-d');
                $isMonth = request('start_date') == now()->startOfMonth()->format('Y-m-d') && request('end_date') == today()->format('Y-m-d');
                $isYear = request('start_date') == now()->startOfYear()->format('Y-m-d') && request('end_date') == today()->format('Y-m-d');
                $noFilter = !$hasDateFilter;
                $pill = 'px-3 py-1.5 text-sm font-medium rounded-lg transition-colors cursor-pointer';
                $pillActive = 'color:#fff';
                $pillNormal = 'border:1px solid #c9cccf;color:#303030;background:#fff';
            ?>
            <button type="button" @click="$refs.startDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.endDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.filterForm.submit()"
                    class="<?php echo e($pill); ?>" style="<?php echo e($isToday ? 'background:#1a1a1a;'.$pillActive : $pillNormal); ?>">Today</button>
            <button type="button" @click="$refs.startDate.value='<?php echo e(now()->subDays(6)->format('Y-m-d')); ?>';$refs.endDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.filterForm.submit()"
                    class="<?php echo e($pill); ?>" style="<?php echo e($is7d ? 'background:#1a1a1a;'.$pillActive : $pillNormal); ?>">7 Days</button>
            <button type="button" @click="$refs.startDate.value='<?php echo e(now()->subDays(29)->format('Y-m-d')); ?>';$refs.endDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.filterForm.submit()"
                    class="<?php echo e($pill); ?>" style="<?php echo e($is30d || $noFilter ? 'background:#1a1a1a;'.$pillActive : $pillNormal); ?>">30 Days</button>
            <button type="button" @click="$refs.startDate.value='<?php echo e(now()->startOfMonth()->format('Y-m-d')); ?>';$refs.endDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.filterForm.submit()"
                    class="<?php echo e($pill); ?>" style="<?php echo e($isMonth ? 'background:#1a1a1a;'.$pillActive : $pillNormal); ?>">This Month</button>
            <button type="button" @click="$refs.startDate.value='<?php echo e(now()->startOfYear()->format('Y-m-d')); ?>';$refs.endDate.value='<?php echo e(today()->format('Y-m-d')); ?>';$refs.filterForm.submit()"
                    class="<?php echo e($pill); ?>" style="<?php echo e($isYear ? 'background:#1a1a1a;'.$pillActive : $pillNormal); ?>">This Year</button>
        </form>
    </div>

    
    <div class="bg-white overflow-hidden mb-5" style="border-radius:12px;border:1px solid #e3e3e3">
        <div class="flex">
            <div class="flex-1 px-5 py-4">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Orders</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo e(number_format($topOrders)); ?></p>
            </div>
            <div class="flex-1 px-5 py-4" style="border-left:1px solid #e3e3e3">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Revenue</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo format_price($topRevenue); ?></p>
            </div>
            <div class="flex-1 px-5 py-4" style="border-left:1px solid #e3e3e3">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Customers</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo e(number_format($totalCustomers)); ?></p>
            </div>
            <div class="flex-1 px-5 py-4" style="border-left:1px solid #e3e3e3">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Confirmed</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo e(number_format($pendingOrders)); ?></p>
            </div>
            <div class="flex-1 px-5 py-4" style="border-left:1px solid #e3e3e3">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Returns</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo e(number_format($totalReturns)); ?></p>
            </div>
            <div class="flex-1 px-5 py-4" style="border-left:1px solid #e3e3e3">
                <p class="text-xs font-medium mb-1" style="color:#6d7175">Products</p>
                <p class="text-2xl font-semibold" style="color:#1a1a1a"><?php echo e(number_format($totalProducts)); ?></p>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        <div class="lg:col-span-2 bg-white" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Revenue Overview</p>
                <p class="text-xs" style="color:#6d7175"><?php echo e($hasDateFilter ? $startDate->format('M d') . ' - ' . $endDate->format('M d, Y') : 'Last 7 Days'); ?></p>
            </div>
            <div class="p-4"><canvas id="revenueChart" height="240"></canvas></div>
        </div>
        <div class="bg-white" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Order Status</p>
            </div>
            <div class="p-4 flex items-center justify-center"><canvas id="orderStatusChart" height="220"></canvas></div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        <div class="lg:col-span-2 bg-white" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Monthly Revenue</p>
            </div>
            <div class="p-4"><canvas id="monthlyRevenueChart" height="200"></canvas></div>
        </div>
        <div class="bg-white" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Performance</p>
            </div>
            <div class="p-5 space-y-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['label' => 'Completion Rate', 'value' => $completionRate, 'detail' => number_format($completedOrders).' of '.number_format($totalOrders).' delivered', 'color' => '#10b981'],
                    ['label' => 'Cancellation Rate', 'value' => $cancellationRate, 'detail' => number_format($cancelledOrders).' of '.number_format($totalOrders).' cancelled', 'color' => '#ef4444'],
                    ['label' => 'Active Products', 'value' => $productActiveRate, 'detail' => number_format($activeProducts).' of '.number_format($totalProducts).' active', 'color' => '#6366f1'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="flex items-center gap-4">
                    <div class="relative w-14 h-14 shrink-0">
                        <svg class="w-14 h-14 -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="52" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                            <circle cx="60" cy="60" r="52" fill="none" stroke="<?php echo e($metric['color']); ?>" stroke-width="8" stroke-dasharray="<?php echo e(2*3.14159*52); ?>" stroke-dashoffset="<?php echo e(2*3.14159*52*(1-$metric['value']/100)); ?>" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center"><span class="text-xs font-bold" style="color:#1a1a1a"><?php echo e($metric['value']); ?>%</span></div>
                    </div>
                    <div>
                        <p class="text-sm font-medium" style="color:#1a1a1a"><?php echo e($metric['label']); ?></p>
                        <p class="text-xs" style="color:#6d7175"><?php echo e($metric['detail']); ?></p>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="pt-4 space-y-2" style="border-top:1px solid #e3e3e3">
                    <div class="flex justify-between text-sm"><span style="color:#6d7175">Total Revenue</span><span class="font-semibold" style="color:#1a1a1a"><?php echo format_price($totalRevenue); ?></span></div>
                    <div class="flex justify-between text-sm"><span style="color:#6d7175">Total Orders</span><span class="font-semibold" style="color:#1a1a1a"><?php echo e(number_format($totalOrders)); ?></span></div>
                    <div class="flex justify-between text-sm"><span style="color:#6d7175">Total Sellers</span><span class="font-semibold" style="color:#1a1a1a"><?php echo e(number_format($totalSellers)); ?></span></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 bg-white overflow-hidden" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Recent Orders</p>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-xs font-medium" style="color:#2c6ecb">View all</a>
            </div>
            <table class="w-full">
                <thead><tr style="border-bottom:1px solid #e3e3e3">
                    <th class="px-4 py-3 text-left text-xs font-medium" style="color:#6d7175">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-medium" style="color:#6d7175">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium" style="color:#6d7175">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium" style="color:#6d7175">Total</th>
                </tr></thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-neutral-50 cursor-pointer" onclick="window.location='<?php echo e(route('admin.orders.show', $order)); ?>'" style="border-bottom:1px solid #f0f0f0">
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium" style="color:#2c6ecb"><?php echo e($order->order_number); ?></span>
                            <p class="text-xs" style="color:#6d7175"><?php echo e($order->created_at->diffForHumans()); ?></p>
                        </td>
                        <td class="px-4 py-3 text-sm" style="color:#1a1a1a"><?php echo e($order->user->full_name ?? 'Guest'); ?></td>
                        <td class="px-4 py-3">
                            <?php $sc = match($order->status) { 'delivered','completed' => ['#e3f1df','#1a7431'], 'cancelled' => ['#fde8e8','#c53030'], default => ['#fef3c7','#92400e'] }; ?>
                            <span class="text-xs font-medium px-2 py-0.5 rounded" style="background:<?php echo e($sc[0]); ?>;color:<?php echo e($sc[1]); ?>"><?php echo e(ucfirst(str_replace('_',' ',$order->status))); ?></span>
                        </td>
                        <td class="px-4 py-3 text-sm text-right font-medium" style="color:#1a1a1a"><?php echo format_price($order->total); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="4" class="px-4 py-8 text-center text-sm" style="color:#6d7175">No orders yet</td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="bg-white overflow-hidden" style="border-radius:12px;border:1px solid #e3e3e3">
            <div class="px-5 py-4" style="border-bottom:1px solid #e3e3e3">
                <p class="text-sm font-semibold" style="color:#1a1a1a">Top Products</p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="px-4 py-3 flex items-center gap-3" style="<?php echo e(!$loop->last ? 'border-bottom:1px solid #f0f0f0' : ''); ?>">
                <span class="text-xs font-medium w-4 text-center shrink-0" style="color:#999"><?php echo e($i+1); ?></span>
                <div class="w-8 h-8 rounded overflow-hidden shrink-0" style="background:#f4f4f4;border:1px solid #e3e3e3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->primary_image_url): ?>
                        <img src="<?php echo e($product->primary_image_url); ?>" class="w-full h-full object-cover">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate" style="color:#1a1a1a"><?php echo e($product->name); ?></p>
                    <p class="text-xs" style="color:#6d7175"><?php echo e($product->total_sold ?? 0); ?> sold</p>
                </div>
                <span class="text-sm font-medium" style="color:#1a1a1a"><?php echo format_price($product->price); ?></span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="p-4 text-center text-sm" style="color:#6d7175">No products yet</div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fontFamily = "'Inter', sans-serif";

            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
                    datasets: [{
                        label: 'Revenue', data: <?php echo json_encode($chartRevenue, 15, 512) ?>,
                        borderColor: '#5c6ac4', backgroundColor: 'rgba(92,106,196,.06)',
                        borderWidth: 2, fill: true, tension: 0.4,
                        pointBackgroundColor: '#5c6ac4', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 3, pointHoverRadius: 5
                    }, {
                        label: 'Orders', data: <?php echo json_encode($chartOrders, 15, 512) ?>,
                        borderColor: '#47c1bf', backgroundColor: 'rgba(71,193,191,.04)',
                        borderWidth: 2, fill: true, tension: 0.4,
                        pointBackgroundColor: '#47c1bf', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 2, pointHoverRadius: 4,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16, font: { size: 11, family: fontFamily } } } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11, family: fontFamily }, color: '#999' } },
                        y: { position: 'left', grid: { color: '#f5f5f5' }, ticks: { font: { size: 11, family: fontFamily }, color: '#999', callback: v => '£'+v.toLocaleString() } },
                        y1: { position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { size: 11, family: fontFamily }, color: '#999', stepSize: 1 } }
                    }
                }
            });

            const statusData = <?php echo json_encode($orderStatusCounts, 15, 512) ?>;
            new Chart(document.getElementById('orderStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase()+s.slice(1).replace('_',' ')),
                    datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(s => ({pending:'#f59e0b',confirmed:'#3b82f6',processing:'#8b5cf6',packed:'#6366f1',shipped:'#06b6d4',out_for_delivery:'#14b8a6',delivered:'#10b981',completed:'#059669',cancelled:'#ef4444',returned:'#f97316'})[s]||'#bbb'), borderWidth: 2, borderColor: '#fff', hoverOffset: 4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 10, font: { size: 11, family: fontFamily } } } } }
            });

            new Chart(document.getElementById('monthlyRevenueChart'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($monthLabels, 15, 512) ?>,
                    datasets: [{ label: 'Revenue', data: <?php echo json_encode($monthData, 15, 512) ?>, backgroundColor: 'rgba(92,106,196,.15)', hoverBackgroundColor: 'rgba(92,106,196,.3)', borderColor: '#5c6ac4', borderWidth: 1, borderRadius: 6, borderSkipped: false }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: { size: 11, family: fontFamily }, color: '#999' } }, y: { grid: { color: '#f5f5f5' }, ticks: { font: { size: 11, family: fontFamily }, color: '#999', callback: v => '£'+v.toLocaleString() } } } }
            });
        });
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
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>