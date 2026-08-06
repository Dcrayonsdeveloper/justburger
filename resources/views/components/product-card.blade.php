@props(['product', 'showQuickView' => false, 'compact' => false])

@php
    $rating     = $product->rating ?? 0;
    $reviewCount = $product->review_count ?? 0;
    $placeholder = asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
    // Category image as food photo fallback
    $catImg = $product->category
        ? asset('images/categories/' . $product->category->slug . '.jpg')
        : $placeholder;
    $rawImg = $product->primary_image_url;
    $imgSrc = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg')) ? $rawImg : $placeholder;
@endphp

@if($compact)
    {{-- Compact card — used in horizontal sliders on homepage --}}
    <div {{ $attributes->merge(['class' => 'group shrink-0 w-full flex flex-col h-full']) }}>
        <a href="{{ route('products.show', $product) }}" class="block relative">
            <div class="aspect-square rounded-xl overflow-hidden mb-2.5">
                <img src="{{ $imgSrc }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='{{ $catImg }}';">
            </div>
        </a>

        <div class="flex-1 flex flex-col px-0.5">
            <a href="{{ route('products.show', $product) }}" class="block" style="text-decoration:none;">
                <h3 class="text-[16px] font-bold text-white line-clamp-2 mb-1.5 leading-snug group-hover:text-[#D4A017] transition-colors"
                    style="min-height:2.5em;">
                    {{ $product->name }}
                </h3>
            </a>

            {{-- Stars --}}
            @if($reviewCount > 0)
            <div class="flex items-center gap-1 mb-1.5">
                <div style="display:flex;gap:1px;">
                    @for($i = 1; $i <= 5; $i++)
                        <svg style="width:11px;height:11px;fill:{{ $i <= round($rating) ? '#D4A017' : 'rgba(255,255,255,.18)' }};" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span style="font-size:.68rem;color:rgba(255,255,255,.35);">({{ $reviewCount }})</span>
            </div>
            @endif

            <div style="margin-top:auto;padding-top:.5rem;">
                <span style="font-size:.95rem;font-weight:800;color:#D4A017;display:block;margin-bottom:.5rem;">@price($product->price)</span>
                <button @click="$store.toppingsModal.open({{ $product->id }}, 1)"
                        class="btn-add-order-sm">
                    Add to Order
                </button>
            </div>
        </div>
    </div>

@else
    {{-- Full menu card --}}
    <div {{ $attributes->merge(['class' => 'group flex flex-col rounded-xl overflow-hidden']) }}
       style="background:#fff; border:1px solid rgba(0,0,0,.08); transition:transform .3s cubic-bezier(.25,.1,.25,1), box-shadow .3s, border-color .3s;"
       onmouseenter="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,.12)';this.style.borderColor='rgba(200,16,46,.25)';"
       onmouseleave="this.style.transform='';this.style.boxShadow='';this.style.borderColor='';">

        {{-- Image --}}
        <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden" style="aspect-ratio:4/3;">
            <img src="{{ $imgSrc }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
                 loading="lazy"
                 onerror="this.onerror=null;this.src='{{ $catImg }}';"
                 style="transition:transform .5s cubic-bezier(.25,.1,.25,1);">

            {{-- Category label --}}
            @if($product->category)
            <span style="position:absolute;top:.6rem;left:.6rem;background:#C8102E;color:#fff;font-size:.6rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:.18rem .55rem;border-radius:99px;box-shadow:0 2px 8px rgba(200,16,46,.3);">
                {{ $product->category->name }}
            </span>
            @endif
        </a>

        {{-- Content --}}
        <div style="padding:.9rem 1rem 1rem; display:flex; flex-direction:column; flex:1;">
            <a href="{{ route('products.show', $product) }}" style="text-decoration:none;">
                <h3 style="font-size:.9rem;font-weight:700;color:#111111;line-height:1.35;margin-bottom:.5rem;min-height:2.4rem;"
                    class="line-clamp-2 group-hover:text-[#C8102E] transition-colors">
                    {{ $product->name }}
                </h3>
            </a>

            {{-- Stars --}}
            @if($reviewCount > 0)
            <div style="display:flex;align-items:center;gap:.35rem;margin-bottom:.6rem;">
                <div style="display:flex;gap:1px;">
                    @for($i = 1; $i <= 5; $i++)
                        <svg style="width:12px;height:12px;fill:{{ $i <= round($rating) ? '#D4A017' : 'rgba(0,0,0,.15)' }};" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span style="font-size:.7rem;color:rgba(0,0,0,.38);">({{ $reviewCount }})</span>
            </div>
            @endif

            {{-- Description snippet --}}
            @if($product->short_description)
            <p style="font-size:.78rem;color:rgba(0,0,0,.48);line-height:1.5;margin-bottom:.7rem;"
               class="line-clamp-2">
                {{ $product->short_description }}
            </p>
            @endif

            {{-- Price + CTA --}}
            <div style="margin-top:auto;padding-top:.6rem;border-top:1px solid rgba(0,0,0,.07);">
                <span style="font-size:1.1rem;font-weight:800;color:#111111;display:block;margin-bottom:.55rem;">@price($product->price)</span>
                <button @click="$store.toppingsModal.open({{ $product->id }}, 1)"
                        class="btn-add-order">
                    Add to Order
                </button>
            </div>
        </div>
    </div>
@endif
