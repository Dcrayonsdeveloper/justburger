<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg?v=3">
    <link rel="shortcut icon" href="/images/icons/favicon.svg?v=3">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#e9eaed; font-family:'Segoe UI', system-ui, sans-serif; color:#111; padding:24px 12px; }

        /* Toolbar (screen only) */
        .toolbar { max-width:320px; margin:0 auto 14px; display:flex; gap:8px; justify-content:center; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border:none; border-radius:8px;
               font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; }
        .btn-primary { background:#111; color:#fff; }
        .btn-light { background:#fff; color:#111; border:1px solid #d0d0d0; }

        /* Receipt paper */
        .receipt {
            max-width:320px; margin:0 auto; background:#fff; padding:22px 20px;
            font-family:'Courier New', ui-monospace, monospace; font-size:12.5px; line-height:1.55; color:#1a1a1a;
            box-shadow:0 2px 14px rgba(0,0,0,.12);
        }
        .center { text-align:center; }
        .rc-name { font-size:16px; font-weight:800; letter-spacing:.5px; }
        .rc-sub { font-size:11px; color:#333; }
        .rc-type { font-weight:800; font-size:13px; letter-spacing:2px; margin:8px 0 2px; }
        .rc-note { font-size:11px; color:#333; }
        .hr { border:0; border-top:1px dashed #999; margin:10px 0; }

        .rc-meta { font-size:11.5px; }
        .rc-meta strong { font-weight:700; }

        .rc-item { display:flex; justify-content:space-between; gap:10px; margin:5px 0; }
        .rc-item .qty { white-space:nowrap; }
        .rc-item .nm { flex:1; }
        .rc-item .amt { white-space:nowrap; text-align:right; }
        .rc-item-variant { font-size:11px; color:#555; padding-left:26px; }

        .rc-row { display:flex; justify-content:space-between; gap:10px; margin:3px 0; font-size:12px; }
        .rc-row.total { font-weight:800; font-size:14px; }
        .rc-row .neg { }

        .rc-paid { font-weight:800; text-align:center; letter-spacing:1px; padding:8px 0; }
        .rc-paid.ok { color:#0a7c2f; }
        .rc-paid.due { color:#b3261e; }

        .rc-foot { font-size:10.5px; color:#444; text-align:center; }

        @media print {
            body { background:#fff; padding:0; }
            .toolbar { display:none !important; }
            .receipt { box-shadow:none; max-width:100%; padding:0; }
        }
    </style>
</head>
<body>
    @php
        $siteName = \App\Models\Setting::get('site_name', config('app.name', 'Just Burgers Plus'));
        $address  = \App\Models\Setting::get('site_address', \App\Models\Setting::get('company_address', ''));
        $phone    = \App\Models\Setting::get('site_phone', '');

        // Fulfilment type — the store is collection-only, but honour a delivery order if one exists.
        $isDelivery = ($order->metadata['delivery_method'] ?? null) === 'delivery' || (float) $order->shipping_cost > 0;
        $orderType  = $isDelivery ? 'DELIVERY' : 'COLLECTION';

        $subtotal    = (float) $order->subtotal;
        $discount    = (float) $order->discount;
        $shipping    = (float) $order->shipping_cost;
        $tax         = (float) $order->tax;
        $foodTotal   = $subtotal - $discount;
        $isPaid      = $order->payment_status === 'paid';

        // "Paid by" — from the captured payment where possible.
        $payment = $order->payments->sortByDesc('id')->first();
        $method  = $order->metadata['payment_method'] ?? ($payment->method ?? null);
        $last4   = null;
        if ($payment && is_array($payment->gateway_response)) {
            $gr = $payment->gateway_response;
            $last4 = data_get($gr, 'payment_method_details.card.last4')
                ?? data_get($gr, 'charges.data.0.payment_method_details.card.last4')
                ?? data_get($gr, 'payment_intent.charges.data.0.payment_method_details.card.last4');
        }
        $paidLabel = match(true) {
            in_array($method, ['stripe', 'card']) => 'Card' . ($last4 ? ' ****' . $last4 : ''),
            $method === 'cod'                     => 'Cash on collection',
            $method                               => ucfirst($method),
            default                               => 'N/A',
        };

        $customerName  = $order->shipping_address_snapshot['name'] ?? $order->guest_name ?? ($order->user->full_name ?? null);
        $customerPhone = $order->shipping_address_snapshot['phone'] ?? $order->guest_phone ?? ($order->user->phone ?? null);
    @endphp

    <div class="toolbar">
        <button onclick="window.print()" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Print
        </button>
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-light">Back</a>
    </div>

    <div class="receipt">
        {{-- Header --}}
        <div class="center">
            <div class="rc-name">{{ $siteName }}</div>
            @if($address)<div class="rc-sub">{{ $address }}</div>@endif
            @if($phone)<div class="rc-sub">Tel: {{ $phone }}</div>@endif
            <div class="rc-type">{{ $orderType }}</div>
            <div class="rc-note">Don't cook hot food until we notify you.</div>
        </div>

        <hr class="hr">

        {{-- Meta --}}
        <div class="rc-meta">
            <div><strong>Order number:</strong> {{ $order->order_number }}</div>
            <div>{{ $order->created_at->format('d M Y, g:i A') }}</div>
            @if($customerName)<div>{{ $customerName }}@if($customerPhone) · {{ $customerPhone }}@endif</div>@endif
        </div>

        <hr class="hr">

        {{-- Items --}}
        @foreach($order->items as $item)
            <div class="rc-item">
                <span class="qty">{{ (int) $item->quantity }} &times;</span>
                <span class="nm">{{ $item->product_name }}</span>
                <span class="amt">{{ format_price($item->total) }}</span>
            </div>
            @if($item->variant_name)
                <div class="rc-item-variant">{{ $item->variant_name }}</div>
            @endif
        @endforeach

        <hr class="hr">

        {{-- Totals (real order figures — no fabricated charges) --}}
        <div class="rc-row"><span>Subtotal</span><span>{{ format_price($subtotal) }}</span></div>
        @if($discount > 0)
            <div class="rc-row"><span>Restaurant discount</span><span class="neg">-{{ format_price($discount) }}</span></div>
            <div class="rc-row"><span>Food and drink total</span><span>{{ format_price($foodTotal) }}</span></div>
        @endif
        @if($tax > 0)
            <div class="rc-row"><span>Tax</span><span>{{ format_price($tax) }}</span></div>
        @endif
        @if($isDelivery)
            <div class="rc-row"><span>Delivery charge</span><span>{{ format_price($shipping) }}</span></div>
        @endif

        <hr class="hr">

        <div class="rc-row total"><span>Total Due</span><span>{{ format_price($order->total) }}</span></div>

        <hr class="hr">

        {{-- Payment --}}
        <div class="rc-row">
            <span>Paid by:<br>{{ $paidLabel }}</span>
            <span>{{ format_price($isPaid ? ($order->paid_amount > 0 ? $order->paid_amount : $order->total) : 0) }}</span>
        </div>

        @if($isPaid)
            <div class="rc-paid ok">** ORDER HAS BEEN PAID **</div>
        @else
            <div class="rc-paid due">** AWAITING PAYMENT **</div>
        @endif

        <hr class="hr">

        <div class="rc-foot">
            IMPORTANT: For food allergen info, call the restaurant or check the menu.<br><br>
            Thank you for your order!
        </div>
    </div>
</body>
</html>
