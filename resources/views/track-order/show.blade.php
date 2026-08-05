<x-layouts.app>
    <x-slot name="title">Tracking - {{ $order->order_number }}</x-slot>

    <div class="bg-white text-[#222222]">
    <div class="bg-neutral-50 border-b border-neutral-100">
        <div class="container mx-auto px-4 py-3">
            <x-breadcrumb :items="[
                ['label' => 'Track Order', 'url' => route('track-order')],
                ['label' => $order->order_number, 'url' => null],
            ]" />
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <div>
                    <a href="{{ route('track-order') }}" class="text-[16px] text-primary-600 hover:text-primary-700 font-medium inline-flex items-center gap-1.5 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Track another order
                    </a>
                    <h1 class="text-lg sm:text-xl font-bold text-neutral-900">Order {{ $order->order_number }}</h1>
                    <p class="text-[16px] text-neutral-600 mt-1">Placed on {{ $order->created_at->format('F d, Y') }}</p>
                </div>
                @if($latestShipment && $latestShipment->tracking_number)
                    <div class="sm:text-right">
                        <p class="text-xs text-neutral-600">Tracking ID</p>
                        <p class="font-mono font-bold text-primary-600 text-sm">{{ $latestShipment->tracking_number }}</p>
                        @if($latestShipment->carrier)
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-info-50 text-info-700 mt-1">{{ $latestShipment->carrier }}</span>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Tracking Card --}}
            <div class="bg-white border border-neutral-100 rounded-xl mb-6 overflow-hidden">
                <div class="p-5 sm:p-6">
                    @if(in_array($order->status, ['cancelled', 'returned']))
                        <div class="text-center py-8">
                            <div class="w-14 h-14 mx-auto rounded-full bg-danger-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-danger-600">Order {{ ucfirst($order->status) }}</h2>
                            <p class="text-[16px] text-neutral-600 mt-1">
                                {{ $order->status === 'cancelled' ? 'This order has been cancelled.' : 'This order has been returned.' }}
                            </p>
                        </div>
                    @elseif($order->status === 'pending')
                        <div class="text-center py-8">
                            <div class="w-14 h-14 mx-auto rounded-full bg-warning-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-warning-600">Order Pending</h2>
                            <p class="text-[16px] text-neutral-600 mt-1">Your order is being reviewed. Tracking will be available once confirmed.</p>
                        </div>
                    @else
                        @php $trackingSteps = $order->getTrackingSteps(); @endphp

                        {{-- Horizontal Timeline (Desktop) --}}
                        <div class="hidden md:block">
                            <div class="relative">
                                <div class="flex items-start justify-between">
                                    @foreach($trackingSteps as $index => $step)
                                        <div class="flex-1 {{ $index < count($trackingSteps) - 1 ? 'relative' : '' }}">
                                            <div class="flex flex-col items-center">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center z-10 relative transition-all
                                                    {{ $step['completed'] ? 'bg-success-500 text-white' : ($step['current'] ? 'bg-primary-500 text-white ring-4 ring-primary-100 animate-pulse' : 'bg-neutral-100 text-neutral-600') }}">
                                                    @if($step['completed'] && !$step['current'])
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    @elseif($step['icon'] === 'clipboard-check')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                        </svg>
                                                    @elseif($step['icon'] === 'cube')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                        </svg>
                                                    @elseif($step['icon'] === 'truck')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                                        </svg>
                                                    @elseif($step['icon'] === 'map-pin')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                    @elseif($step['icon'] === 'check-circle')
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <p class="mt-2.5 text-[16px] font-semibold text-center {{ $step['completed'] || $step['current'] ? 'text-neutral-900' : 'text-neutral-600' }}">
                                                    {{ $step['label'] }}
                                                </p>
                                                @if($step['timestamp'])
                                                    <p class="text-xs text-neutral-600 text-center mt-0.5">{{ $step['timestamp']->format('M d, Y') }}</p>
                                                    <p class="text-xs text-neutral-600 text-center">{{ $step['timestamp']->format('h:i A') }}</p>
                                                @endif
                                            </div>
                                            @if($index < count($trackingSteps) - 1)
                                                <div class="absolute top-5 left-1/2 w-full h-0.5 {{ $trackingSteps[$index + 1]['completed'] || $trackingSteps[$index + 1]['current'] ? 'bg-success-500' : 'bg-neutral-200' }}"></div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Vertical Timeline (Mobile) --}}
                        <div class="md:hidden">
                            <div class="relative">
                                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-neutral-200"></div>
                                <div class="space-y-5">
                                    @foreach($trackingSteps as $step)
                                        <div class="flex gap-3.5 relative">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center z-10 shrink-0 transition-all
                                                {{ $step['completed'] ? 'bg-success-500 text-white' : ($step['current'] ? 'bg-primary-500 text-white ring-4 ring-primary-100' : 'bg-neutral-100 text-neutral-600') }}">
                                                @if($step['completed'] && !$step['current'])
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @elseif($step['icon'] === 'clipboard-check')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                    </svg>
                                                @elseif($step['icon'] === 'cube')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                @elseif($step['icon'] === 'truck')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                                    </svg>
                                                @elseif($step['icon'] === 'map-pin')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                @elseif($step['icon'] === 'check-circle')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 pt-1.5">
                                                <p class="text-[16px] font-semibold {{ $step['completed'] || $step['current'] ? 'text-neutral-900' : 'text-neutral-600' }}">
                                                    {{ $step['label'] }}
                                                </p>
                                                @if($step['timestamp'])
                                                    <p class="text-xs text-neutral-600 mt-0.5">{{ $step['timestamp']->format('M d, Y \a\t h:i A') }}</p>
                                                @elseif($step['current'])
                                                    <p class="text-xs text-primary-500 mt-0.5">In progress...</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="bg-white border border-neutral-100 rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-neutral-100">
                    <h2 class="text-[15px] font-semibold text-neutral-900">Items in this Order</h2>
                </div>
                <div class="divide-y divide-neutral-100">
                    @foreach($order->items as $item)
                        <div class="px-5 py-4 flex gap-3.5">
                            <img src="{{ $item->product->primary_image_url ?? '' }}" alt="{{ $item->product_name }}"
                                 class="w-14 h-14 rounded-lg object-cover bg-neutral-100 shrink-0">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-[16px] font-medium text-neutral-900 truncate">{{ $item->product_name }}</h3>
                                @if($item->variant_name)
                                    <p class="text-xs text-neutral-600">{{ $item->variant_name }}</p>
                                @endif
                                <p class="text-xs text-neutral-600 mt-0.5">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layouts.app>
