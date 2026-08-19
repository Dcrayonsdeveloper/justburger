<x-layouts.app>
    <x-slot name="title">Checkout — {{ \App\Models\Setting::get('site_name', config('app.name')) }}</x-slot>

    @push('meta')
        <meta name="description" content="Secure checkout at {{ \App\Models\Setting::get('site_name', config('app.name')) }}.">
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="Checkout — {{ \App\Models\Setting::get('site_name', config('app.name')) }}">
        <meta property="og:description" content="Complete your order securely.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ route('checkout.index') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Checkout — {{ \App\Models\Setting::get('site_name', config('app.name')) }}">

        <?php
        $checkoutSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Checkout',
            'description' => 'Secure checkout at ' . \App\Models\Setting::get('site_name', config('app.name')),
            'url' => route('checkout.index'),
            'breadcrumb' => [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Cart', 'item' => route('cart.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => 'Checkout'],
                ],
            ],
            'potentialAction' => [
                '@type' => 'OrderAction',
                'target' => route('checkout.process'),
            ],
        ];
        ?>
        <script type="application/ld+json">{!! json_encode($checkoutSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        <style>
            .iti { width: 100%; }
            .iti__tel-input { width: 100% !important; }
        </style>
    @endpush

    <x-slot name="styles">
    <style>
        /* ─── Base ─── */
        .ck-page { background:#fafaf8; color:#111111; min-height:70vh; }

        /* ─── Header ─── */
        .ck-header {
            background:#fff; border-bottom:1px solid rgba(0,0,0,.08);
            padding:1rem 1.25rem;
        }
        .ck-bc {
            display:flex; flex-wrap:wrap; align-items:center; gap:.3rem .45rem;
            font-size:.78rem; color:rgba(0,0,0,.38); margin-bottom:.5rem;
            max-width:1100px; margin-left:auto; margin-right:auto;
        }
        .ck-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .ck-bc a:hover { color:#C8102E; }
        .ck-bc-sep { opacity:.4; }
        .ck-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:clamp(1.4rem,3.5vw,1.8rem);
            text-transform:uppercase; letter-spacing:.03em; color:#111111;
            line-height:1.1; max-width:1100px; margin:0 auto;
            display:flex; align-items:center; gap:.5rem;
        }
        .ck-user { font-size:.75rem; color:rgba(0,0,0,.45); font-weight:400; text-transform:none; letter-spacing:0; }

        /* ─── Grid ─── */
        .ck-grid {
            max-width:1100px; margin:0 auto;
            padding:1.5rem 1rem 3rem;
        }
        @media(min-width:1024px) {
            .ck-grid { display:flex; align-items:flex-start; gap:1.5rem; }
            .ck-left { flex:1; min-width:0; }
            .ck-right { width:360px; flex-shrink:0; position:sticky; top:1rem; }
        }

        /* ─── Section cards ─── */
        .ck-card {
            background:#fff; border-radius:.75rem;
            border:1px solid rgba(0,0,0,.08);
            margin-bottom:1rem;
            box-shadow:0 1px 4px rgba(0,0,0,.04);
        }
        .ck-card-head {
            display:flex; align-items:center; gap:.5rem;
            padding:.75rem 1rem;
            border-bottom:1px solid rgba(0,0,0,.06);
            background:rgba(0,0,0,.015); border-radius:.75rem .75rem 0 0;
        }
        .ck-step {
            width:1.5rem; height:1.5rem; border-radius:50%;
            background:#C8102E; color:#fff;
            font-size:.65rem; font-weight:800;
            display:flex; align-items:center; justify-content:center;
        }
        .ck-card-label {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:700; font-size:.85rem;
            text-transform:uppercase; letter-spacing:.05em; color:#111111;
        }
        .ck-card-body { padding:1rem; }

        /* ─── Inputs ─── */
        .ck-label {
            display:block; font-size:.7rem; font-weight:600;
            color:rgba(0,0,0,.5); margin-bottom:.25rem; text-transform:uppercase; letter-spacing:.04em;
        }
        .ck-input {
            width:100%; font-size:.85rem; color:#111111;
            border:1px solid rgba(0,0,0,.12); border-radius:.5rem;
            padding:.55rem .75rem; background:#fff;
            transition:border-color .15s, box-shadow .15s;
        }
        .ck-input:focus { border-color:#C8102E; outline:none; box-shadow:0 0 0 3px rgba(200,16,46,.1); }
        .ck-input::placeholder { color:rgba(0,0,0,.3); }
        .ck-error { font-size:.7rem; color:#C8102E; margin-top:.2rem; }

        /* ─── Address card ─── */
        .ck-addr {
            display:flex; align-items:flex-start; gap:.65rem;
            padding:.65rem .75rem; border:1px solid rgba(0,0,0,.1);
            border-radius:.5rem; cursor:pointer; transition:all .15s;
        }
        .ck-addr:hover { border-color:rgba(200,16,46,.3); }
        .ck-addr.active { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-addr input[type="radio"] { accent-color:#C8102E; margin-top:.15rem; }
        .ck-addr-name { font-size:.8rem; font-weight:600; color:#111111; }
        .ck-addr-default {
            font-size:.6rem; font-weight:700; color:#C8102E;
            background:rgba(200,16,46,.08); padding:.1rem .4rem;
            border-radius:99px; text-transform:uppercase; letter-spacing:.04em;
        }
        .ck-addr-detail { font-size:.75rem; color:rgba(0,0,0,.55); line-height:1.4; }

        /* ─── Payment options ─── */
        .ck-pay-opt {
            border:1px solid rgba(0,0,0,.1); border-radius:.5rem;
            cursor:pointer; transition:all .15s; overflow:hidden;
        }
        .ck-pay-opt:hover { border-color:rgba(200,16,46,.3); }
        .ck-pay-opt.active { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-pay-opt input[type="radio"] { accent-color:#C8102E; }
        .ck-pay-row {
            display:flex; align-items:center; gap:.65rem;
            padding:.65rem .75rem;
        }
        .ck-pay-icon {
            width:2rem; height:2rem; border-radius:.4rem;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }
        .ck-pay-name { font-size:.82rem; font-weight:600; color:#111111; }
        .ck-pay-desc { font-size:.72rem; color:rgba(0,0,0,.45); }

        /* ─── Order summary (right) ─── */
        .ck-summary {
            background:#fff; border-radius:.75rem;
            border:1px solid rgba(0,0,0,.08);
            box-shadow:0 2px 10px rgba(0,0,0,.05);
            overflow:hidden;
        }
        .ck-summary-head {
            padding:.75rem 1rem;
            border-bottom:1px solid rgba(0,0,0,.06);
            font-family:'Barlow Condensed',sans-serif;
            font-weight:700; font-size:.9rem;
            text-transform:uppercase; letter-spacing:.04em; color:#111111;
        }

        /* ─── Item rows ─── */
        .ck-item {
            display:flex; gap:.65rem; padding:.6rem 0;
            border-bottom:1px solid rgba(0,0,0,.05);
        }
        .ck-item:last-child { border-bottom:0; }
        .ck-item-img {
            width:52px; height:52px; border-radius:.4rem;
            overflow:hidden; flex-shrink:0; background:#f5f2ef;
        }
        .ck-item-img img { width:100%; height:100%; object-fit:cover; }
        .ck-item-name { font-size:.78rem; font-weight:600; color:#111111; line-height:1.3; }
        .ck-item-qty {
            display:inline-flex; align-items:center; gap:.35rem;
            margin-top:.25rem;
        }
        .ck-qty-btn {
            width:1.35rem; height:1.35rem; border-radius:.25rem;
            background:rgba(0,0,0,.05); border:1px solid rgba(0,0,0,.1);
            display:flex; align-items:center; justify-content:center;
            font-size:.7rem; color:#111111; cursor:pointer; transition:all .15s;
        }
        .ck-qty-btn:hover { background:rgba(200,16,46,.08); border-color:rgba(200,16,46,.2); }
        .ck-qty-num { font-size:.75rem; font-weight:700; color:#111111; min-width:1.2rem; text-align:center; }
        .ck-item-remove {
            font-size:.65rem; color:#C8102E; cursor:pointer;
            margin-left:.5rem; text-decoration:none; font-weight:600;
        }
        .ck-item-remove:hover { text-decoration:underline; }
        .ck-item-price { font-size:.78rem; font-weight:700; color:#111111; white-space:nowrap; }

        /* ─── Coupon ─── */
        .ck-coupon-scroll {
            display:flex; gap:.5rem; overflow-x:auto;
            padding-bottom:.35rem; -webkit-overflow-scrolling:touch;
        }
        .ck-coupon-card {
            flex-shrink:0; width:10.5rem;
            border:1px dashed rgba(0,0,0,.15); border-radius:.5rem;
            padding:.55rem .65rem; transition:all .15s;
        }
        .ck-coupon-card.applied { border-color:#C8102E; background:rgba(200,16,46,.04); }
        .ck-coupon-code {
            font-size:.65rem; font-weight:800; color:#C8102E;
            background:rgba(200,16,46,.08); padding:.1rem .45rem;
            border-radius:.25rem; font-family:monospace; letter-spacing:.03em;
        }
        .ck-coupon-desc { font-size:.68rem; color:rgba(0,0,0,.5); line-height:1.35; margin:.3rem 0; }
        .ck-coupon-btn {
            width:100%; font-size:.68rem; font-weight:700;
            border:1px solid #C8102E; color:#C8102E;
            border-radius:.3rem; padding:.3rem 0; cursor:pointer;
            background:transparent; transition:all .15s;
        }
        .ck-coupon-btn:hover { background:#C8102E; color:#fff; }
        .ck-coupon-rm {
            width:100%; font-size:.68rem; font-weight:600;
            border:1px solid rgba(200,16,46,.25); color:#C8102E;
            border-radius:.3rem; padding:.3rem 0; cursor:pointer;
            background:transparent; transition:all .15s;
        }
        .ck-coupon-rm:hover { background:rgba(200,16,46,.06); }

        /* ─── Price rows ─── */
        .ck-prices { padding:1rem; }
        .ck-price-row {
            display:flex; align-items:center; justify-content:space-between;
            font-size:.78rem; padding:.25rem 0;
        }
        .ck-price-label { color:rgba(0,0,0,.5); }
        .ck-price-val { font-weight:600; color:#111111; }
        .ck-price-green { color:#2E7D32; font-weight:600; }
        .ck-price-red { color:#C8102E; font-weight:600; }
        .ck-price-divider {
            border:0; border-top:1px dashed rgba(0,0,0,.1);
            margin:.5rem 0;
        }
        .ck-total-row {
            display:flex; align-items:center; justify-content:space-between;
            padding:.35rem 0;
        }
        .ck-total-label {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1rem; text-transform:uppercase;
            letter-spacing:.03em; color:#111111;
        }
        .ck-total-val {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:1.15rem; color:#C8102E;
        }

        /* ─── Place order button ─── */
        .ck-submit-btn {
            display:block; width:100%;
            padding:.85rem 1rem;
            background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:.95rem;
            text-transform:uppercase; letter-spacing:.06em;
            border:0; border-radius:.5rem; cursor:pointer;
            transition:background .15s, transform .1s;
            box-shadow:0 2px 8px rgba(200,16,46,.25);
        }
        .ck-submit-btn:hover { background:#a00d24; }
        .ck-submit-btn:active { transform:scale(.98); }
        .ck-submit-btn:disabled { opacity:.5; cursor:not-allowed; }

        /* ─── Trust badges ─── */
        .ck-trust {
            display:flex; align-items:center; justify-content:center;
            gap:1.25rem; padding:.75rem 1rem;
            border-top:1px solid rgba(0,0,0,.06);
        }
        .ck-trust-item {
            display:flex; align-items:center; gap:.3rem;
            font-size:.65rem; font-weight:600; color:rgba(0,0,0,.4);
            text-transform:uppercase; letter-spacing:.03em;
        }
        .ck-trust-item svg { width:.9rem; height:.9rem; }

        /* ─── Misc ─── */
        .ck-link { color:#C8102E; text-decoration:none; font-weight:600; }
        .ck-link:hover { text-decoration:underline; }
        .ck-text-muted { color:rgba(0,0,0,.4); }
        .ck-saved-banner {
            background:rgba(46,125,50,.08); border-radius:.4rem;
            padding:.5rem .75rem; text-align:center;
            font-size:.75rem; font-weight:600; color:#2E7D32;
        }
        .ck-ship-nudge {
            border-radius:.5rem; padding:.6rem .85rem; margin-bottom:1rem;
        }
        .ck-ship-bar {
            height:5px; border-radius:99px; overflow:hidden; margin-top:.4rem;
        }

        /* ─── Express checkout ─── */
        .ck-express {
            background:linear-gradient(135deg,#111111,#2a1f1b);
            border-radius:.75rem; padding:.85rem 1rem;
            color:#fff; margin-bottom:1rem;
            display:flex; align-items:center; justify-content:space-between; gap:.75rem;
        }
        .ck-express-label { font-size:.72rem; font-weight:700; }
        .ck-express-detail { font-size:.65rem; opacity:.7; margin-top:.15rem; }
        .ck-express-btn {
            padding:.5rem 1.25rem;
            background:#C8102E; color:#fff;
            font-weight:800; font-size:.75rem;
            border:0; border-radius:.4rem; cursor:pointer;
            text-transform:uppercase; letter-spacing:.04em;
            white-space:nowrap; transition:background .15s;
        }
        .ck-express-btn:hover { background:#a00d24; }
        .ck-express-btn:disabled { opacity:.5; }

        /* ─── GPS Location Button ─── */
        .ck-gps-btn {
            display:flex; align-items:center; gap:.5rem;
            width:100%; padding:.7rem .85rem;
            background:linear-gradient(135deg,rgba(200,16,46,.06),rgba(200,16,46,.03));
            border:1.5px dashed rgba(200,16,46,.3);
            border-radius:.6rem; cursor:pointer;
            transition:all .2s; margin-bottom:.75rem;
        }
        .ck-gps-btn:hover { background:rgba(200,16,46,.08); border-color:rgba(200,16,46,.5); }
        .ck-gps-btn:disabled { opacity:.5; cursor:wait; }
        .ck-gps-icon {
            width:2.2rem; height:2.2rem; border-radius:50%;
            background:#C8102E; color:#fff;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; box-shadow:0 2px 8px rgba(200,16,46,.25);
        }
        .ck-gps-icon svg { width:1.1rem; height:1.1rem; }
        .ck-gps-icon.locating { animation:ck-pulse 1.2s ease-in-out infinite; }
        @keyframes ck-pulse {
            0%,100% { box-shadow:0 0 0 0 rgba(200,16,46,.4); }
            50% { box-shadow:0 0 0 10px rgba(200,16,46,0); }
        }
        .ck-gps-text { font-size:.82rem; font-weight:700; color:#C8102E; }
        .ck-gps-sub { font-size:.68rem; color:rgba(0,0,0,.4); font-weight:400; margin-top:.1rem; }
        .ck-gps-status {
            font-size:.72rem; padding:.4rem .65rem;
            border-radius:.4rem; margin-bottom:.65rem;
            display:flex; align-items:center; gap:.35rem;
        }
        .ck-gps-status.success { background:rgba(46,125,50,.08); color:#2E7D32; }
        .ck-gps-status.error { background:rgba(200,16,46,.06); color:#C8102E; }

        /* ─── Mini map preview ─── */
        .ck-map-preview {
            width:100%; height:120px; border-radius:.5rem;
            overflow:hidden; margin-bottom:.75rem;
            border:1px solid rgba(0,0,0,.08);
            background:#f0ece8; position:relative;
        }
        .ck-map-preview img { width:100%; height:100%; object-fit:cover; }
        .ck-map-pin {
            position:absolute; top:50%; left:50%;
            transform:translate(-50%,-100%);
            font-size:1.5rem; filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));
        }

        /* ─── Add address form ─── */
        .ck-new-addr {
            background:rgba(0,0,0,.02); border:1px solid rgba(0,0,0,.08);
            border-radius:.5rem; padding:.85rem; margin-top:.65rem;
        }
        .ck-new-addr-title { font-size:.8rem; font-weight:700; color:#111111; margin-bottom:.6rem; }

        /* ─── Mobile bottom bar ─── */
        @media(max-width:1023px) {
            .ck-right { margin-top:1rem; }
        }
    </style>
    </x-slot>

    {{-- Facebook Pixel: InitiateCheckout --}}
    @if(!empty($fbEventId) && config('services.facebook.pixel_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof fbq !== 'undefined') {
                fbq('track', 'InitiateCheckout', {
                    content_ids: {!! json_encode($cart->items->pluck('product_id')->map('strval')->values()->toArray()) !!},
                    content_type: 'product',
                    value: {{ (float) ($cart->subtotal - $cart->discount) }},
                    currency: 'GBP',
                    num_items: {{ $cart->items->sum('quantity') }}
                }, {eventID: '{{ $fbEventId }}'});
            }
        });
    </script>
    @endif

    <div class="ck-page">
        {{-- ─── Header ─── --}}
        <div class="ck-header">
            <nav class="ck-bc">
                <a href="{{ url('/') }}">Home</a>
                <span class="ck-bc-sep">/</span>
                <a href="{{ route('cart.index') }}">Cart</a>
                <span class="ck-bc-sep">/</span>
                <span style="color:rgba(0,0,0,.6);">Checkout</span>
            </nav>
            <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;">
                <h1 class="ck-title">
                    <a href="{{ route('cart.index') }}" style="color:#111111;text-decoration:none;display:flex;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    Checkout
                </h1>
            </div>
        </div>


        @php
            $methodOrder = ['stripe' => 'stripe_enabled', 'cod' => 'cod_enabled'];
            $firstMethod = 'cod';
            foreach ($methodOrder as $method => $key) {
                if (($paymentSettings[$key] ?? '1') === '1') { $firstMethod = $method; break; }
            }
        @endphp

        <form action="{{ route('checkout.process') }}" method="POST"
              x-data="checkoutForm('{{ $firstMethod }}')"
              @submit.prevent="handleSubmit($event)">
            @csrf

            <input type="hidden" name="delivery_method" value="collection">

            <div class="ck-grid">
                {{-- ═══ LEFT COLUMN ═══ --}}
                <div class="ck-left">

                    {{-- ── Collection only ── --}}
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">
                                <svg style="width:.7rem;height:.7rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/></svg>
                            </div>
                            <span class="ck-card-label">Collection</span>
                        </div>
                        <div class="ck-card-body">
                            <div style="padding:.75rem .9rem;background:rgba(46,125,50,.06);border:1px solid rgba(46,125,50,.15);border-radius:.4rem;">
                                <p style="font-size:.8rem;font-weight:700;color:#2E7D32;margin:0 0 .2rem;">
                                    <svg style="width:.8rem;height:.8rem;display:inline;vertical-align:-1px;margin-right:.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Collect your order from the restaurant
                                </p>
                                <p style="font-size:.78rem;color:rgba(0,0,0,.6);margin:0;">
                                    {{ \App\Models\Setting::get('site_address', '525 Staines Road, Bedfont, Middx. TW14 8BP') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ── Section 1: Contact + Shipping ── --}}
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">1</div>
                            <span class="ck-card-label">
                                @if($isGuest) Contact Details @else Contact Details @endif
                            </span>
                        </div>
                        <div class="ck-card-body">
                            {{-- Collection only — we just need the customer's name to call when the order is ready. --}}
                            <div>
                                <label class="ck-label">Name *</label>
                                <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()?->full_name ?? '') }}" required autocomplete="name" autofocus
                                       class="ck-input" placeholder="Full name">
                                @error('guest_name') <p class="ck-error">{{ $message }}</p> @enderror
                            </div>
                            <input type="hidden" name="same_billing_address" value="1">
                        </div>
                    </div>

                    {{-- Billing always matches the contact/collection details --}}
                    @if(!$isGuest)
                    <input type="hidden" name="same_billing_address" value="1">
                    @endif

                    {{-- ── Section 3: Payment ── --}}
                    <div class="ck-card">
                        <div class="ck-card-head">
                            <div class="ck-step">2</div>
                            <span class="ck-card-label">Payment</span>
                        </div>
                        <div class="ck-card-body" style="display:flex;flex-direction:column;gap:.55rem;">
                            {{-- Stripe (hosted card checkout) --}}
                            @if(($paymentSettings['stripe_enabled'] ?? '1') === '1')
                            <div @click="paymentMethod = 'stripe'"
                                 :class="paymentMethod === 'stripe' ? 'active' : ''"
                                 class="ck-pay-opt">
                                <div class="ck-pay-row">
                                    <input type="radio" name="payment_method" value="stripe" x-model="paymentMethod">
                                    <div class="ck-pay-icon"
                                         :style="paymentMethod === 'stripe' ? 'background:rgba(99,91,255,.10);color:#635BFF;' : 'background:rgba(0,0,0,.04);color:rgba(0,0,0,.4);'">
                                        <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9v9.75c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125V9m-19.5 0V6.375c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125V9m-19.5 0h19.5"/></svg>
                                    </div>
                                    <div>
                                        <p class="ck-pay-name">Pay Online</p>
                                        <p class="ck-pay-desc">Card, Apple Pay & Google Pay — secured by Stripe</p>
                                    </div>
                                    <svg style="margin-left:auto;height:20px;width:auto;flex-shrink:0;" viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Stripe"><title>Stripe</title><path fill="#635BFF" fill-rule="evenodd" clip-rule="evenodd" d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.97.81l.02 6.12c.4.44.98.78 1.95.78 1.52 0 2.54-1.65 2.54-3.87 0-2.15-1.04-3.84-2.54-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zm-4.32 9.35v9.79H19.8V5.57h3.7l.12 1.22c1-1.77 3.07-1.41 3.62-1.22v3.79c-.52-.17-2.29-.43-3.32.86zm-8.55 4.72c0 2.43 2.6 1.68 3.12 1.46v3.36c-.55.3-1.54.54-2.89.54a4.15 4.15 0 0 1-4.27-4.24l.02-13.17 4.02-.86v3.54h3.14V9.1h-3.14v5.85zm-4.91.7c0 2.97-2.31 4.66-5.73 4.66a11.2 11.2 0 0 1-4.46-.93v-3.93c1.38.75 3.1 1.31 4.46 1.31.92 0 1.53-.24 1.53-1C6.4 13.77 0 14.51 0 9.95 0 7.04 2.28 5.3 5.62 5.3c1.36 0 2.72.2 4.09.75v3.88a9.23 9.23 0 0 0-4.1-1.06c-.86 0-1.44.25-1.44.9 0 1.85 6.29.97 6.29 5.86z"></path></svg>
                                </div>
                            </div>
                            @endif

                            {{-- Cash on Delivery — shown only when enabled in Admin → Settings → Payment --}}
                            @if(($paymentSettings['cod_enabled'] ?? '1') === '1')
                            <div @click="paymentMethod = 'cod'"
                                 :class="paymentMethod === 'cod' ? 'active' : ''"
                                 class="ck-pay-opt">
                                <div class="ck-pay-row">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod">
                                    <div class="ck-pay-icon"
                                         :style="paymentMethod === 'cod' ? 'background:rgba(200,16,46,.08);color:#C8102E;' : 'background:rgba(0,0,0,.04);color:rgba(0,0,0,.4);'">
                                        <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="ck-pay-name">Cash on Delivery</p>
                                        <p class="ck-pay-desc">{{ $paymentSettings['cod_instructions'] ?? 'Pay with cash when you collect your order.' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @error('payment_method')
                                <p class="ck-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    {{-- Order Notes --}}
                    <div class="ck-card">
                        <div class="ck-card-body">
                            <label class="ck-label">Order Notes (optional)</label>
                            <textarea name="notes" rows="2" class="ck-input" style="resize:none;"
                                      placeholder="Any notes for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ═══ RIGHT COLUMN — Order Summary ═══ --}}
                <div class="ck-right">
{{-- Promo code --}}
                        <div style="padding:.75rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);"
                             x-data="{
                                 code: '', applying: false, error: '',
                                 apply() {
                                     if (!this.code.trim() || this.applying) return;
                                     this.applying = true; this.error = '';
                                     fetch('{{ route('cart.apply-coupon') }}', {
                                         method: 'POST',
                                         headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                         body: JSON.stringify({ code: this.code })
                                     })
                                     .then(r => r.ok ? location.reload() : r.json().then(d => { this.error = d.error || 'Invalid code'; this.applying = false; }))
                                     .catch(() => { this.error = 'Something went wrong.'; this.applying = false; });
                                 }
                             }">
                            <div style="display:flex;align-items:center;gap:.35rem;margin-bottom:.5rem;">
                                <svg style="width:.85rem;height:.85rem;color:#D4A017;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#111111;">Have a code?</span>
                            </div>
                            @if($cart->coupon_id)
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
                                    <p style="font-size:.75rem;color:#2E7D32;font-weight:600;margin:0;">
                                        &#10003; {{ $cart->coupon->code ?? 'Coupon' }} applied
                                    </p>
                                    <button type="button"
                                            @click="
                                                fetch('{{ route('cart.remove-coupon') }}', {
                                                    method: 'DELETE',
                                                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                                }).then(r => r.ok ? location.reload() : null)
                                              "
                                            style="font-size:.72rem;font-weight:700;color:#C8102E;background:none;border:0;cursor:pointer;padding:.2rem .3rem;">
                                        Remove
                                    </button>
                                </div>
                            @else
                            {{-- Not a <form>: this sits inside the main checkout form, and a
                                 nested form is invalid HTML — the browser drops it, so @submit
                                 never fires and the button submits the order instead. --}}
                            <div style="display:flex;gap:.4rem;">
                                <input type="text" x-model="code" placeholder="Promo / discount code"
                                       autocomplete="off" spellcheck="false"
                                       @keydown.enter.prevent="apply()"
                                       style="flex:1;min-width:0;padding:.5rem .65rem;font-size:.8rem;border:1px solid rgba(0,0,0,.15);border-radius:.35rem;outline:none;text-transform:uppercase;">
                                <button type="button" @click="apply()" :disabled="applying"
                                        style="padding:.5rem .9rem;font-size:.78rem;font-weight:700;color:#fff;background:#C8102E;border:0;border-radius:.35rem;cursor:pointer;white-space:nowrap;">
                                    <span x-show="!applying">Apply</span>
                                    <span x-show="applying" x-cloak>...</span>
                                </button>
                            </div>
                            <p x-show="error" x-cloak x-text="error" style="font-size:.72rem;color:#C8102E;margin:.35rem 0 0;"></p>
                            @endif
                        </div>

                        {{-- Coupons --}}
                        @if($availableCoupons->count())
                        <div style="padding:.75rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);" x-data="{ applying: false }">
                            <div style="display:flex;align-items:center;gap:.35rem;margin-bottom:.5rem;">
                                <svg style="width:.85rem;height:.85rem;color:#D4A017;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#111111;">Coupons</span>
                            </div>
                            <div class="ck-coupon-scroll">
                                @foreach($availableCoupons as $coupon)
                                    <div class="ck-coupon-card {{ $cart->coupon_id === $coupon->id ? 'applied' : '' }}">
                                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.25rem;">
                                            <span class="ck-coupon-code">{{ $coupon->code }}</span>
                                            @if($cart->coupon_id === $coupon->id)
                                                <span style="font-size:.6rem;font-weight:600;color:#2E7D32;background:rgba(46,125,50,.1);padding:.1rem .3rem;border-radius:.2rem;">Applied</span>
                                            @endif
                                        </div>
                                        <p class="ck-coupon-desc" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $coupon->name }}</p>
                                        @if($cart->coupon_id !== $coupon->id)
                                            <button type="button" :disabled="applying" class="ck-coupon-btn"
                                                    @click="
                                                        applying = true;
                                                        fetch('{{ route('cart.apply-coupon') }}', {
                                                            method: 'POST',
                                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                                            body: JSON.stringify({ code: '{{ $coupon->code }}' })
                                                        }).then(r => {
                                                            if (r.ok) { location.reload(); }
                                                            else { return r.json().then(d => { alert(d.error || 'Could not apply coupon'); applying = false; }); }
                                                        }).catch(() => { alert('Something went wrong'); applying = false; })
                                                    ">
                                                Apply
                                            </button>
                                        @else
                                            <button type="button" class="ck-coupon-rm"
                                                    @click="fetch('{{ route('cart.remove-coupon') }}', {
                                                        method: 'DELETE',
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                                    }).then(() => location.reload())">
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Applied coupon badge --}}
                        @if($cart->coupon)
                            <div style="padding:.5rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);background:rgba(46,125,50,.04);">
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <div style="display:flex;align-items:center;gap:.35rem;">
                                        <span class="ck-coupon-code">{{ $cart->coupon->code }}</span>
                                        @if($cart->coupon->auto_apply)
                                            <span style="font-size:.58rem;color:#C8102E;background:rgba(200,16,46,.08);padding:.1rem .3rem;border-radius:.2rem;font-weight:600;">Auto</span>
                                        @endif
                                        <span style="font-size:.7rem;color:#2E7D32;font-weight:600;">
                                            @if($cart->coupon->type === 'percentage')
                                                {{ intval($cart->coupon->value) }}% off
                                            @elseif($cart->coupon->type === 'fixed')
                                                @price($cart->coupon->value) off
                                            @elseif($cart->coupon->type === 'buy_x_get_y')
                                                Buy {{ $cart->coupon->conditions['buy_qty'] ?? 0 }} Get {{ $cart->coupon->conditions['get_qty'] ?? 0 }}{{ $cart->coupon->value >= 100 ? ' Free' : '' }}
                                            @endif
                                        </span>
                                    </div>
                                    <span style="font-size:.82rem;font-weight:700;color:#2E7D32;">-@price($cart->discount)</span>
                                </div>
                            </div>
                        @endif

                        {{-- Order items --}}
                        <div style="padding:.5rem 1rem;border-bottom:1px solid rgba(0,0,0,.06);">
                            <p style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:rgba(0,0,0,.4);margin-bottom:.35rem;">
                                {{ $cart->items->sum('quantity') }} {{ $cart->items->sum('quantity') === 1 ? 'Item' : 'Items' }}
                            </p>
                            <div style="max-height:14rem;overflow-y:auto;">
                                @foreach($cart->items as $item)
                                    @php
                                        $rawImg = $item->product->primary_image_url;
                                        $itemImg = ($rawImg && !str_ends_with(strtolower($rawImg), '.svg'))
                                            ? $rawImg
                                            : asset('images/products/product-' . (($item->product->id % 27) + 1) . '.jpg');
                                    @endphp
                                    <div class="ck-item">
                                        <div class="ck-item-img">
                                            <img src="{{ $itemImg }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <p class="ck-item-name">{{ $item->product->name }}</p>
                                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                                <span class="ck-item-qty">
                                                    <button type="button" class="ck-qty-btn" onclick="fetch('/cart/{{ $item->id }}',{method:'PUT',headers:{'Content-Type':'application/json','X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'},body:JSON.stringify({quantity:{{ max(1,$item->quantity-1) }}})}).then(()=>location.reload())">-</button>
                                                    <span class="ck-qty-num">{{ $item->quantity }}</span>
                                                    <button type="button" class="ck-qty-btn" onclick="fetch('/cart/{{ $item->id }}',{method:'PUT',headers:{'Content-Type':'application/json','X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'},body:JSON.stringify({quantity:{{ $item->quantity+1 }}})}).then(()=>location.reload())">+</button>
                                                    <a href="#" class="ck-item-remove" onclick="event.preventDefault();if(confirm('Remove this item?'))fetch('/cart/{{ $item->id }}',{method:'DELETE',headers:{'X-XSRF-TOKEN':decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1]||''),'Accept':'application/json'}}).then(()=>location.reload())">Remove</a>
                                                </span>
                                                <span class="ck-item-price">@price(($item->price + $item->toppings_total) * $item->quantity)</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price breakdown --}}
                        <div class="ck-prices">
                            <div class="ck-price-row">
                                <span class="ck-price-label">Subtotal</span>
                                <span class="ck-price-val">@price($cart->subtotal)</span>
                            </div>

                            @if($cart->discount > 0)
                                <div class="ck-price-row">
                                    <span class="ck-price-label">Coupon Discount</span>
                                    <span class="ck-price-green">-@price($cart->discount)</span>
                                </div>
                            @endif


                            @php $shipFee = 0; @endphp




                            <hr class="ck-price-divider">

                            @php
                                // Collection only — no delivery fee to add. The only
                                // saving is a coupon the customer applied themselves.
                                $displayTotal = $cart->total;
                                $totalSavings = $cart->discount;
                                $codMinOrder = 10;
                                $showCod = $displayTotal >= $codMinOrder;
                            @endphp

                            <div class="ck-total-row">
                                <span class="ck-total-label">Total</span>
                                                                <span class="ck-total-val">@price($displayTotal)</span>
                            </div>

                            @if($totalSavings > 0)
                                <div class="ck-saved-banner" style="margin-top:.65rem;">
                                    You save @price($totalSavings) on this order
                                </div>
                            @endif
                        </div>

                        {{-- Place Order --}}
                        <div style="padding:0 1rem 1rem;">
                            <button type="submit" :disabled="processing" class="ck-submit-btn">
                                <span x-show="!processing">
                                    <template x-if="paymentMethod === 'stripe'">
                                        <span>Pay Now &middot;
                                                                                        <span>@price($displayTotal)</span>
                                        </span>
                                    </template>
                                    <template x-if="paymentMethod === 'cod'">
                                        <span>Place Order</span>
                                    </template>
                                </span>
                                <span x-show="processing" x-cloak style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                                    <svg style="width:.9rem;height:.9rem;" class="animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    Processing...
                                </span>
                            </button>
                            <p x-show="error" x-text="error" class="ck-error" style="text-align:center;margin-top:.5rem;" x-cloak></p>
                        </div>

                        {{-- Trust badges --}}
                        <div class="ck-trust">
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Secure
                            </div>
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Genuine
                            </div>
                            <div class="ck-trust-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Fresh Daily
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div style="padding:.35rem 1rem .75rem;text-align:center;">
                            <p style="font-size:.62rem;color:rgba(0,0,0,.35);line-height:1.5;">
                                By placing your order, you agree to our
                                <a href="{{ route('terms') }}" class="ck-link" style="font-size:.62rem;">Terms</a> &
                                <a href="{{ route('privacy') }}" class="ck-link" style="font-size:.62rem;">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            // ─── Shared reverse-geocoding helper ───
            function reverseGeocode(lat, lng) {
                return fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng + '&addressdetails=1&zoom=18', {
                    headers: { 'Accept-Language': 'en' }
                }).then(r => r.json());
            }

            function parseAddress(data) {
                const a = data.address || {};
                return {
                    line1: [a.house_number, a.road].filter(Boolean).join(' ') || '',
                    line2: a.suburb || a.neighbourhood || a.hamlet || '',
                    city: a.city || a.town || a.village || a.municipality || '',
                    state: a.state || a.county || '',
                    postcode: a.postcode || '',
                    display: data.display_name || '',
                };
            }

            // ─── Guest checkout: GPS + address fields ───
            // Field labels and input ids shared by the address forms, so a failed
            // save can name the field instead of saying "Something went wrong".
            const ADDR_LABELS = {
                name: 'Full name', phone: 'Phone', address_line1: 'Address',
                address_line2: 'Area / Landmark', postal_code: 'Postcode',
                city: 'City', state: 'County', country: 'Country',
            };
            const ADDR_INPUTS = {
                name: 'new_addr_name', phone: 'new_addr_phone', address_line1: 'new_addr_line1',
                address_line2: 'new_addr_line2', postal_code: 'new_addr_pincode',
                city: 'new_addr_city', state: 'new_addr_state',
            };

            function addressGPS() {
                return {
                    // GPS state
                    gpsLoading: false,
                    gpsStatus: '',
                    gpsSuccess: false,
                    gpsLat: null,
                    gpsLng: null,

                    // Address fields (bound to inputs)
                    pin: '',
                    city: '',
                    state: '',
                    pinTimeout: null,

                    detectLocation() {
                        if (!navigator.geolocation) {
                            this.gpsStatus = 'GPS not supported by your browser';
                            this.gpsSuccess = false;
                            return;
                        }

                        this.gpsLoading = true;
                        this.gpsStatus = '';

                        navigator.geolocation.getCurrentPosition(
                            (pos) => {
                                this.gpsLat = pos.coords.latitude;
                                this.gpsLng = pos.coords.longitude;
                                this.fillFromGPS(pos.coords.latitude, pos.coords.longitude);
                            },
                            (err) => {
                                this.gpsLoading = false;
                                if (err.code === 1) {
                                    this.gpsStatus = 'Location permission denied. Please allow access in your browser settings.';
                                } else if (err.code === 2) {
                                    this.gpsStatus = 'Unable to determine your location. Please enter address manually.';
                                } else {
                                    this.gpsStatus = 'Location request timed out. Please try again.';
                                }
                                this.gpsSuccess = false;
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                        );
                    },

                    async fillFromGPS(lat, lng) {
                        try {
                            const data = await reverseGeocode(lat, lng);
                            const addr = parseAddress(data);

                            // Fill address fields
                            this.pin = addr.postcode;
                            this.city = addr.city;
                            this.state = addr.state;

                            // Fill non-Alpine inputs via DOM
                            const line1El = document.querySelector('[name="shipping_address_line_1"]');
                            const line2El = document.querySelector('[name="shipping_address_line_2"]');
                            if (line1El) line1El.value = addr.line1;
                            if (line2El) line2El.value = addr.line2;

                            this.gpsStatus = 'Address detected — please verify details below';
                            this.gpsSuccess = true;
                            this.gpsLoading = false;

                            // Also run serviceability check
                            if (this.pin) this.fetchPinData();
                        } catch (e) {
                            this.gpsStatus = 'Could not detect address. Please enter manually.';
                            this.gpsSuccess = false;
                            this.gpsLoading = false;
                        }
                    },

                    fetchPinData() {
                        clearTimeout(this.pinTimeout);
                        if (this.pin.length < 5) return;

                        this.pinTimeout = setTimeout(() => {
                            // Postcode lookup for city/state autofill
                            fetch('https://api.postalpincode.in/pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    if (data[0] && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length) {
                                        const po = data[0].PostOffice[0];
                                        if (!this.city) this.city = po.District || po.Division || '';
                                        if (!this.state) this.state = po.State || '';
                                    }
                                })
                                .catch(() => {});
                        }, 400);
                    }
                };
            }

            // ─── Authenticated user: GPS for inline "new address" form ───
            function addressGPSInline() {
                return {
                    gpsLoading: false,
                    gpsStatus: '',
                    gpsSuccess: false,

                    // Address fields
                    pin: '',
                    city: '',
                    state: '',
                    line1: '',
                    line2: '',
                    pinTimeout: null,
                    savingAddress: false,

                    resetFieldErrors() {
                        Object.values(ADDR_INPUTS).forEach(id => {
                            const el = document.getElementById(id);
                            if (el) el.style.borderColor = '';
                        });
                    },

                    showFieldErrors(messages, fields) {
                        const errEl = document.getElementById('new_addr_error');
                        errEl.innerHTML = messages.map(m => '<div>' + m + '</div>').join('');
                        errEl.style.display = 'block';
                        (fields || []).forEach(k => {
                            const el = document.getElementById(ADDR_INPUTS[k]);
                            if (el) el.style.borderColor = '#C8102E';
                        });
                        const first = (fields || []).map(k => document.getElementById(ADDR_INPUTS[k])).find(Boolean);
                        if (first) first.focus();
                    },

                    saveAddress() {
                        if (this.savingAddress) return;
                        this.resetFieldErrors();

                        const val = id => (document.getElementById(id)?.value || '').trim();
                        const values = {
                            name: val('new_addr_name'),
                            phone: val('new_addr_phone'),
                            address_line1: (this.line1 || '').trim(),
                            address_line2: (this.line2 || '').trim(),
                            postal_code: (this.pin || '').trim(),
                            city: (this.city || '').trim(),
                            state: (this.state || '').trim(),
                            country: 'GB',
                        };

                        const required = ['name', 'phone', 'address_line1', 'postal_code', 'city'];
                        const missing = required.filter(k => !values[k]);
                        if (missing.length) {
                            this.showFieldErrors(missing.map(k => ADDR_LABELS[k] + ' is required.'), missing);
                            return;
                        }

                        this.savingAddress = true;
                        fetch('{{ route('account.addresses.store') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify(values),
                        })
                        .then(r => r.json().then(d => ({ status: r.status, ok: r.ok, data: d })).catch(() => ({ status: r.status, ok: r.ok, data: null })))
                        .then(({ status, ok, data }) => {
                            this.savingAddress = false;
                            if (ok) {
                                location.href = '{{ route('checkout.index') }}?address=' + ((data && data.address) ? data.address.id : '');
                                return;
                            }
                            if (status === 422 && data && data.errors) {
                                const keys = Object.keys(data.errors);
                                this.showFieldErrors(keys.map(k => (data.errors[k][0] || (ADDR_LABELS[k] + ' is invalid.'))
                                    .replace(/address line1/i, 'Address')
                                    .replace(/postal code/i, 'Postcode')
                                    .replace(/\bstate\b/i, 'County')), keys);
                                return;
                            }
                            this.showFieldErrors([(data && data.message) || 'Could not save the address. Please try again.'], []);
                        })
                        .catch(() => {
                            this.savingAddress = false;
                            this.showFieldErrors(['Could not reach the server. Check your connection and try again.'], []);
                        });
                    },


                    detectLocation() {
                        if (!navigator.geolocation) {
                            this.gpsStatus = 'GPS not supported by your browser';
                            this.gpsSuccess = false;
                            return;
                        }

                        this.gpsLoading = true;
                        this.gpsStatus = '';

                        navigator.geolocation.getCurrentPosition(
                            (pos) => this.fillFromGPS(pos.coords.latitude, pos.coords.longitude),
                            (err) => {
                                this.gpsLoading = false;
                                this.gpsStatus = err.code === 1
                                    ? 'Location permission denied.'
                                    : 'Could not detect location. Enter manually.';
                                this.gpsSuccess = false;
                            },
                            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
                        );
                    },

                    async fillFromGPS(lat, lng) {
                        try {
                            const data = await reverseGeocode(lat, lng);
                            const addr = parseAddress(data);

                            this.pin = addr.postcode;
                            this.city = addr.city;
                            this.state = addr.state;
                            this.line1 = addr.line1;
                            this.line2 = addr.line2;

                            this.gpsStatus = 'Address detected — verify below';
                            this.gpsSuccess = true;
                            this.gpsLoading = false;

                            if (this.pin) this.fetchPinData();
                        } catch (e) {
                            this.gpsStatus = 'Could not detect address.';
                            this.gpsSuccess = false;
                            this.gpsLoading = false;
                        }
                    },

                    fetchPinData() {
                        clearTimeout(this.pinTimeout);
                        if (this.pin.length < 5) return;

                        this.pinTimeout = setTimeout(() => {
                            fetch('https://api.postalpincode.in/pincode/' + this.pin)
                                .then(r => r.json())
                                .then(data => {
                                    if (data[0] && data[0].Status === 'Success' && data[0].PostOffice && data[0].PostOffice.length) {
                                        const po = data[0].PostOffice[0];
                                        if (!this.city) this.city = po.District || po.Division || '';
                                        if (!this.state) this.state = po.State || '';
                                    }
                                })
                                .catch(() => {});
                        }, 400);
                    }
                };
            }

            let abandonedCaptureTimeout = null;
            let lastCapturedData = '';
            function captureAbandoned(immediate) {
                clearTimeout(abandonedCaptureTimeout);
                const delay = immediate ? 0 : 2000;
                abandonedCaptureTimeout = setTimeout(() => {
                    const phone = (document.querySelector('[name="guest_phone"]')?.value || '').replace(/\D/g, '');
                    const email = document.querySelector('[name="guest_email"]')?.value || '';
                    const name = document.querySelector('[name="guest_name"]')?.value || '';

                    if (phone.length < 10 && !email.includes('@')) return;

                    const dataKey = phone + '|' + email + '|' + name;
                    if (dataKey === lastCapturedData) return;
                    lastCapturedData = dataKey;

                    fetch('{{ route("checkout.abandoned.capture") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ phone, email, name }),
                    }).catch(() => {});
                }, delay);
            }

            function checkoutForm(firstMethod) {
                return {
                    sameBilling: true,
                    paymentMethod: firstMethod,
                    deliveryMethod: 'collection',
                    showAddressForm: false,
                    savingAddress: false,
                    processing: false,
                    error: '',

                    handleSubmit(e) {
                        this.error = '';
                        if (this.paymentMethod === 'stripe') {
                            this.initiateStripe(e.target);
                        } else {
                            // COD / partial pay → standard server-side checkout (process())
                            e.target.submit();
                        }
                    },

                    async initiateStripe(form) {
                        this.processing = true;
                        const data = Object.fromEntries(new FormData(form).entries());

                        try {
                            const response = await fetch('{{ route("checkout.stripe.create") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify(data),
                            });

                            const result = await response.json();

                            if (!response.ok || !result.url) {
                                this.error = result.error || result.message || 'Something went wrong. Please try again.';
                                this.processing = false;
                                return;
                            }

                            // Redirect to Stripe's hosted checkout page.
                            window.location.href = result.url;
                        } catch (err) {
                            this.error = 'Network error. Please check your connection and try again.';
                            this.processing = false;
                        }
                    },
                };
            }
        </script>

        {{-- GA4 begin_checkout --}}
        @if(config('services.ga4.measurement_id'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @php
                    $ga4CheckoutItems = $cart->items->map(function ($item) {
                        return [
                            'item_id' => $item->product->sku ?? (string) $item->product_id,
                            'item_name' => $item->product->name,
                            'price' => (float) $item->price,
                            'quantity' => $item->quantity,
                        ];
                    });
                @endphp
                var checkoutItems = {!! json_encode($ga4CheckoutItems, JSON_UNESCAPED_UNICODE) !!};
                gtag('event', 'begin_checkout', {
                    currency: 'GBP',
                    value: {{ (float) $cart->total }},
                    items: checkoutItems
                });
            });
        </script>
        @endif
    </x-slot>
</x-layouts.app>
