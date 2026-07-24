@php
    $rawImg = $product->primary_image_url;
    $imgSrc = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
        ? $rawImg
        : asset('images/products/product-' . (($product->id % 27) + 1) . '.jpg');
    $hasDiscount = $product->compare_at_price && $product->compare_at_price > $product->price;
@endphp
<div class="na-item">
    <a href="{{ route('products.show', $product->slug) }}" class="na-item-link">
        @if($product->category)
            <div class="na-item-cat">{{ $product->category->name }}</div>
        @endif
        <div class="na-item-name">{{ $product->name }}</div>
        @if($product->short_description)
            <div class="na-item-desc">{{ $product->short_description }}</div>
        @endif
        <div class="na-item-meta">
            <span class="na-item-price">@price($product->price)</span>
            @if($hasDiscount)
                <span class="na-item-old-price">@price($product->compare_at_price)</span>
            @endif
            <span class="na-item-new-tag">New</span>
        </div>
    </a>
    <div class="na-item-right">
        <img src="{{ $imgSrc }}" alt="{{ $product->name }}" class="na-item-img" loading="lazy">
        <button class="na-add-btn"
                onclick="window.dispatchEvent(new CustomEvent('add-to-cart', { detail: { productId: {{ $product->id }}, quantity: 1 }}))">
            Add +
        </button>
    </div>
</div>
