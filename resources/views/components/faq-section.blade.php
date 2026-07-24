@props(['faqs' => null])

@php
    $cs = currency_symbol();
    $dispatchTime = \App\Models\Setting::get('dispatch_time', '24 hours');
    $deliveryDays = \App\Models\Setting::get('standard_delivery_days', '3-7');
    $returnDays = \App\Models\Setting::get('return_policy_days', 7);
    $codAdvance = \App\Models\Setting::get('cod_advance_amount', 100);

    $defaultFaqs = [
        ['q' => 'How long does delivery take?', 'a' => "We aim to deliver all orders within 30-45 minutes, depending on your distance from our restaurant. During busy periods such as Friday and Saturday evenings, it may take a little longer."],
        ['q' => 'What if there is an issue with my order?', 'a' => "If anything is not right with your order, please let us know straight away. Call or WhatsApp us and we will do our best to sort it out, whether that means a replacement or a refund."],
        ['q' => 'Is Cash on Delivery available?', 'a' => "Yes! You can pay cash when your order is delivered to your door. We also accept card payments online at checkout."],
        ['q' => 'Is your food freshly prepared?', 'a' => 'Absolutely. Every order is freshly prepared in our kitchen using quality ingredients. We never pre-make meals, so your food is always hot and fresh.'],
        ['q' => 'How can I track my order?', 'a' => 'Once your order is out for delivery, you will receive an update via email. You can also track anytime on our Track Order page using your order number.'],
        ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit and debit cards (Visa, MasterCard, American Express) through our secure online checkout. You can also pay cash on delivery.'],
    ];
    $items = $faqs ?? $defaultFaqs;
@endphp

<section {{ $attributes->merge(['class' => 'py-10 bg-[#F7F8FA]']) }}>
    <div class="container mx-auto px-4">
        <h2 class="text-lg font-bold text-[#0F1111] mb-5 text-center">Frequently Asked Questions</h2>
        <div class="max-w-3xl mx-auto space-y-2" x-data="{ open: null }">
            @foreach($items as $i => $faq)
                <div class="bg-white border border-[#E3E6E6] rounded overflow-hidden">
                    <button type="button"
                            @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-[#F7F8FA] transition-colors">
                        <span class="text-sm font-medium text-[#0F1111] pr-4">{{ $faq['q'] }}</span>
                        <svg class="w-4 h-4 text-[#565959] shrink-0 transition-transform duration-200"
                             :class="open === {{ $i }} && 'rotate-180'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse x-cloak>
                        <div class="px-4 pb-3 text-sm text-[#565959] leading-relaxed border-t border-[#E3E6E6]">
                            <p class="pt-3">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQPage Schema (JSON-LD) --}}
<?php
$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($items)->map(fn($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['a'],
        ],
    ])->toArray(),
];
?>
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
