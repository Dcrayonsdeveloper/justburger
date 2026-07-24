<x-layouts.app>
    <x-slot name="title">Returns Policy - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Returns and exchange policy for {{ \App\Models\Setting::get('site_name', config('app.name')) }}. Easy returns on products within the return window.">
        <link rel="canonical" href="{{ url('/returns') }}">
    @endpush

    <div class="bg-white text-[#222222]">
    <div class="bg-neutral-50 border-b border-neutral-100">
        <div class="container mx-auto px-4 py-3">
            <x-breadcrumb :items="[['label' => 'Returns Policy', 'url' => null]]" />
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-14 h-14 mx-auto rounded-full bg-warning-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <h1 class="text-lg sm:text-xl font-bold text-neutral-900">Returns Policy</h1>
                <p class="text-[16px] text-neutral-600 mt-2">We want you to be completely satisfied with your purchase.</p>
            </div>

            <!-- Food Order Policy -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 mb-4">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-2">Food Order Policy</h2>
                <p class="text-[16px] text-neutral-600 leading-relaxed">
                    All food orders are non-returnable once delivered. Due to the perishable nature of our food items,
                    we cannot accept returns on delivered meals. Please check your order upon delivery and report any
                    issues immediately.
                </p>
            </div>

            <!-- When We Issue Refunds -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 mb-4">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-3">When We Issue Refunds</h2>
                <p class="text-[16px] text-neutral-600 mb-3">We will gladly issue a refund or replacement if:</p>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        You received the wrong order or missing items
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Your food arrived in a damaged or spoiled condition
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        There is a significant quality issue with your meal
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-success-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Your order was not delivered within the estimated delivery window
                    </li>
                </ul>
            </div>

            <!-- Non-Refundable Situations -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 mb-4">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-3">Non-Refundable Situations</h2>
                <p class="text-[16px] text-neutral-600 mb-3">Refunds will not be issued in the following cases:</p>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-danger-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Change of mind after the order has been prepared
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-danger-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Incorrect delivery address provided by the customer
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-danger-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Customer was unavailable to receive the delivery
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-danger-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Complaints raised more than 24 hours after delivery
                    </li>
                    <li class="flex items-start gap-2 text-[16px] text-neutral-600">
                        <svg class="w-4 h-4 text-danger-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Personal taste preferences (e.g., spice level, seasoning)
                    </li>
                </ul>
            </div>

            <!-- How to Report an Issue - Steps -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 mb-4">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-5">How to Report an Issue</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                    <div class="text-center">
                        <div class="w-10 h-10 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-primary-600">1</span>
                        </div>
                        <h3 class="text-sm font-semibold text-neutral-900 mb-1">Contact Us</h3>
                        <p class="text-xs text-neutral-600 leading-relaxed">Reach out via your account, phone, or email within 24 hours of delivery.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-primary-600">2</span>
                        </div>
                        <h3 class="text-sm font-semibold text-neutral-900 mb-1">Share Details</h3>
                        <p class="text-xs text-neutral-600 leading-relaxed">Provide your order number and photos of the issue so we can investigate.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-sm font-bold text-primary-600">3</span>
                        </div>
                        <h3 class="text-sm font-semibold text-neutral-900 mb-1">Get Resolved</h3>
                        <p class="text-xs text-neutral-600 leading-relaxed">We will issue a refund, replacement, or store credit within 3-5 business days.</p>
                    </div>
                </div>
            </div>

            <!-- Refunds -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 mb-4">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-2">Refunds</h2>
                <div class="space-y-2.5 text-[16px] text-neutral-600 leading-relaxed">
                    <p>
                        Once your complaint is reviewed and approved, we will send you an email to notify
                        you of the resolution.
                    </p>
                    <p>
                        If a refund is approved, the credit will automatically be applied to your original
                        payment method within 3-5 business days. Alternatively, you may choose store credit
                        for your next order.
                    </p>
                </div>
            </div>

            <!-- Order Cancellation + Replacements side by side -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6">
                    <h2 class="text-[15px] font-bold text-neutral-900 mb-2">Order Cancellation</h2>
                    <p class="text-[16px] text-neutral-600 leading-relaxed">
                        You may cancel your order for a full refund before it enters preparation.
                        Once the kitchen starts preparing your food, cancellations are no longer possible.
                    </p>
                </div>
                <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6">
                    <h2 class="text-[15px] font-bold text-neutral-900 mb-2">Replacements</h2>
                    <p class="text-[16px] text-neutral-600 leading-relaxed">
                        If your order arrived with wrong or missing items, we will send a replacement
                        at no additional charge as quickly as possible.
                    </p>
                </div>
            </div>

            <!-- Wrong or Missing Items -->
            <div class="bg-warning-50 border border-warning-200 rounded-xl p-5 sm:p-6 mb-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-warning-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[15px] font-bold text-neutral-900 mb-1">Wrong or Missing Items</h2>
                        <p class="text-[16px] text-neutral-600 leading-relaxed">
                            If you received the wrong items or something is missing from your order, please contact us
                            within 24 hours of delivery with photos. We will arrange for a replacement or full refund.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Questions -->
            <div class="bg-white border border-neutral-100 rounded-xl p-5 sm:p-6 text-center">
                <h2 class="text-[15px] font-bold text-neutral-900 mb-2">Questions?</h2>
                <p class="text-[16px] text-neutral-600 mb-4">Our support team is here to help with your returns.</p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-2 text-[16px] font-medium text-primary-600 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Us
                    </a>
                    <a href="{{ route('returns') }}" class="inline-flex items-center gap-2 px-4 py-2 text-[16px] font-medium text-neutral-700 border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        FAQs
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>
</x-layouts.app>
