<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg?v=3">
    <link rel="shortcut icon" href="/images/icons/favicon.svg?v=3">
    {{-- Page size is written here at runtime so the roll feeds exactly the receipt's length, then cuts. --}}
    <style id="page-size">@page { size: 80mm 297mm; margin: 0; }</style>
    <style>
        /*
         | Sized for an 80mm thermal roll (Epson TM-T20II and compatibles):
         | 80mm paper, 72mm printable area, 4mm non-printable edge each side.
         | Screen and print use identical metrics, so the preview is true size
         | and the printed height can be measured from the on-screen layout.
         */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#e9eaed; font-family:'Segoe UI', system-ui, sans-serif; color:#111; padding:24px 12px; }

        /* Toolbar + hint (screen only) */
        .toolbar { width:80mm; margin:0 auto 10px; display:flex; gap:8px; justify-content:center; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border:none; border-radius:8px;
               font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; }
        .btn-primary { background:#111; color:#fff; }
        .btn-light { background:#fff; color:#111; border:1px solid #d0d0d0; }
        .print-hint { width:80mm; margin:0 auto 14px; font-size:10.5px; line-height:1.6; color:#555; text-align:center; }

        /* Receipt paper — 80mm wide, 4mm gutters, 72mm of printable content */
        .receipt {
            width:80mm; margin:0 auto; background:#fff; padding:3mm 4mm;
            font-family:'Courier New', ui-monospace, monospace; font-size:9pt; line-height:1.45; color:#000;
            box-shadow:0 2px 14px rgba(0,0,0,.12);
        }
        .center { text-align:center; }
        .rc-name { font-size:13pt; font-weight:700; letter-spacing:.3mm; }
        .rc-sub { font-size:8pt; }
        .rc-type { font-weight:700; font-size:11pt; letter-spacing:.6mm; margin:2mm 0 1mm; }
        .rc-note { font-size:8pt; }
        .hr { border:0; border-top:1px dashed #000; margin:2mm 0; }

        .rc-meta { font-size:8.5pt; }
        .rc-meta strong { font-weight:700; }

        .rc-item { display:flex; justify-content:space-between; gap:2mm; margin:1mm 0; page-break-inside:avoid; }
        .rc-item .qty { white-space:nowrap; }
        .rc-item .nm { flex:1; overflow-wrap:anywhere; }
        .rc-item .amt { white-space:nowrap; text-align:right; }
        .rc-item-variant { font-size:8pt; padding-left:6mm; overflow-wrap:anywhere; page-break-inside:avoid; }

        .rc-row { display:flex; justify-content:space-between; gap:2mm; margin:.8mm 0; font-size:9pt; page-break-inside:avoid; }
        .rc-row.total { font-weight:700; font-size:11pt; }

        /* Monochrome print head — no colour, no grey. Everything stays solid black. */
        .rc-paid { font-weight:700; text-align:center; letter-spacing:.3mm; padding:2mm 0; font-size:9.5pt; }

        .rc-foot { font-size:7.5pt; text-align:center; }

        @media print {
            html, body { width:80mm; background:#fff; padding:0; margin:0; }
            .toolbar, .print-hint { display:none !important; }
            .receipt { box-shadow:none; margin:0; }
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
        {{-- Shared by the admin and customer routes; each passes where "Back" goes. --}}
        <a href="{{ $backUrl }}" class="btn btn-light">Back</a>
    </div>

    <div class="print-hint">
        Shown at true size for an 80mm roll.<br>
        Printer setup: paper <strong>Roll Paper 80 x 297mm</strong>, margins <strong>None</strong>, scale <strong>100%</strong>.
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
            <div class="rc-paid">** ORDER HAS BEEN PAID **</div>
        @else
            <div class="rc-paid">** AWAITING PAYMENT **</div>
        @endif

        <hr class="hr">

        <div class="rc-foot">
            IMPORTANT: For food allergen info, call the restaurant or check the menu.<br><br>
            Thank you for your order!
        </div>
    </div>

    <script>
        /*
         | Thermal rolls have no fixed page length. Measure the rendered receipt and
         | set @page to exactly that height (+ a 6mm gap so the cutter clears the last
         | line), otherwise the printer feeds a full 297mm page for every receipt.
         | CSS px are fixed at 96dpi, so px -> mm is a constant.
         */
        (function () {
            var PX_TO_MM = 25.4 / 96;
            var CUT_FEED_MM = 6;

            function setPageHeight() {
                var receipt = document.querySelector('.receipt');
                if (!receipt) return;
                var mm = receipt.getBoundingClientRect().height * PX_TO_MM + CUT_FEED_MM;
                document.getElementById('page-size').textContent =
                    '@page { size: 80mm ' + mm.toFixed(1) + 'mm; margin: 0; }';
            }

            setPageHeight();
            window.addEventListener('load', setPageHeight);
            window.addEventListener('beforeprint', setPageHeight);
        })();
    </script>
</body>
</html>
