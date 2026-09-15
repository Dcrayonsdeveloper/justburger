<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg?v=3">
    <link rel="shortcut icon" href="/images/icons/favicon.svg?v=3">
    {{-- Page size is written here at runtime so the roll feeds exactly the receipt's length, then cuts. --}}
    <style id="page-size">@page { size: 72mm 297mm; margin: 0; }</style>
    <style>
        /*
         | Sized for an 80mm thermal roll (Epson TM-T20II and compatibles).
         |
         | The paper is 80mm but the head only prints about 72mm of it, and it
         | starts at the left edge rather than centring. Laying the page out at
         | the full 80mm therefore pushed the last few millimetres past what the
         | head can reach, and every right-aligned price lost its pence: "£47.10"
         | came out as "£47.". So the PAGE is 72mm — the printable width, not the
         | paper width — and the content sits inside that with its own gutters.
         |
         | The head also cannot reach the first few millimetres of that width.
         | At a 2mm left gutter the printed slip shaved the left side off the
         | first character of every full-width line: "Order number" came out as
         | "Drder number", "Total Due" as "Fotal Due", "1 x" as "l x", "Subtotal"
         | and "Paid by" missing their first stroke. Centred lines were fine,
         | and so were the option lines, because .rc-opt and .rc-item-variant
         | add another 4mm of their own - which is what pins the dead zone at
         | roughly 3mm from the page edge.
         |
         | The left gutter is therefore 6mm: about 1.2 characters clear of where
         | the clipping stopped, without giving away more width than that costs.
         |
         | The right is 3mm, not 2mm, so the slip looks centred on PAPER. The
         | left 3mm of the page never prints, so a 6mm left gutter and a 3mm
         | right one come out as an even 3mm of white down each side. On screen
         | the preview looks left-heavy for exactly that reason - it shows the
         | dead strip the printer cannot.
         |
         | Screen and print use identical metrics, so the preview is true size
         | and the printed height can be measured from the on-screen layout.
         */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#e9eaed; font-family:'Segoe UI', system-ui, sans-serif; color:#111; padding:24px 12px; }

        /* Toolbar + hint (screen only) */
        .toolbar { width:72mm; margin:0 auto 10px; display:flex; gap:8px; justify-content:center; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border:none; border-radius:8px;
               font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; }
        .btn-primary { background:#111; color:#fff; }
        .btn-light { background:#fff; color:#111; border:1px solid #d0d0d0; }
        .print-hint { width:72mm; margin:0 auto 14px; font-size:10.5px; line-height:1.6; color:#555; text-align:center; }

        /* Receipt paper — 72mm of printable width, 6mm/3mm gutters, 63mm of text */
        .receipt {
            width:72mm; margin:0 auto; background:#fff; padding:3mm 3mm 3mm 6mm;
            font-family:'Courier New', ui-monospace, monospace; font-size:12pt; line-height:1.35; color:#000;
            /* Thermal heads print thin strokes faintly. Courier New is monospace,
               so bold has identical advance widths - nothing reflows, it just
               lands darker and reads across the counter. */
            font-weight:700;
            box-shadow:0 2px 14px rgba(0,0,0,.12);
        }
        .center { text-align:center; }
        .rc-name { font-size:16pt; font-weight:700; letter-spacing:.15mm; }
        .rc-sub { font-size:10pt; }
        .rc-type { font-weight:700; font-size:14pt; letter-spacing:.4mm; margin:2mm 0 1mm; }
        .rc-note { font-size:10pt; }
        .hr { border:0; border-top:1px dashed #000; margin:2mm 0; }

        .rc-meta { font-size:11.5pt; }
        .rc-meta strong { font-weight:700; }

        .rc-item { display:flex; justify-content:space-between; gap:2mm; margin:1mm 0; page-break-inside:avoid; }
        .rc-item .qty { white-space:nowrap; }
        .rc-item .nm { flex:1; overflow-wrap:anywhere; }
        .rc-item .amt { white-space:nowrap; text-align:right; }
        .rc-item-variant { font-size:11pt; padding-left:4mm; overflow-wrap:anywhere; page-break-inside:avoid; }

        /* Customisations. Indented under their item so it is unambiguous which
           burger they belong to, and marked with +/- rather than colour: the
           print head is monochrome, so green and red would both come out black. */
        .rc-opt { font-size:11pt; padding-left:4mm; overflow-wrap:anywhere; page-break-inside:avoid; }
        .rc-opt-item { font-size:11pt; padding-left:8mm; overflow-wrap:anywhere; page-break-inside:avoid; }
        .rc-opt .lead, .rc-item-variant .lead { font-weight:700; }

        /* Order note. The one thing on the slip the kitchen must not skim past,
           so it gets a box of its own — the only boxed element on the receipt. */
        .rc-kitchen-note { border:1.5px solid #000; padding:1.5mm 2mm; margin:2mm 0; page-break-inside:avoid; }
        .rc-kitchen-note .hdr { font-size:11.5pt; font-weight:700; letter-spacing:.3mm; margin-bottom:.8mm; }
        .rc-kitchen-note .body { font-size:12.5pt; font-weight:700; overflow-wrap:anywhere; }

        .rc-row { display:flex; justify-content:space-between; gap:2mm; margin:.8mm 0; font-size:12pt; page-break-inside:avoid; }
        .rc-row.total { font-weight:700; font-size:15pt; }

        /* Monochrome print head — no colour, no grey. Everything stays solid black. */
        .rc-paid { font-weight:700; text-align:center; letter-spacing:.3mm; padding:2mm 0; font-size:13pt; }

        .rc-foot { font-size:10pt; text-align:center; }

        @media print {
            html, body { width:72mm; background:#fff; padding:0; margin:0; }
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

        // Shown under COLLECTION / DELIVERY. Blank the setting to print nothing.
        $collectionNote = \App\Models\Setting::get(
            'receipt_collection_note',
            'Collect your food from the shop in 15 minutes.'
        );

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
        @if($isTest ?? false)
            {{-- Unmistakable on paper: nobody should cook from this slip. --}}
            <div class="center rc-type">*** TEST PRINT ***</div>
            <div class="center rc-note">Not a real order — no food required.</div>
            <hr class="hr">
        @endif

        {{-- Header --}}
        <div class="center">
            <div class="rc-name">{{ $siteName }}</div>
            @if($address)<div class="rc-sub">{{ $address }}</div>@endif
            @if($phone)<div class="rc-sub">Tel: {{ $phone }}</div>@endif
            <div class="rc-type">{{ $orderType }}</div>
            {{-- How long the food will be. A setting rather than a fixed string:
                 the wait changes with how busy the shop is, and the counter
                 should be able to reword it without a deploy. --}}
            @if(filled($collectionNote))
                <div class="rc-note">{{ $collectionNote }}</div>
            @endif
        </div>

        <hr class="hr">

        {{-- Meta --}}
        <div class="rc-meta">
            <div><strong>Order number:</strong> {{ $order->order_number }}</div>
            @if($customerName)
                <div><strong>Name:</strong> {{ $customerName }}</div>
            @endif
            <div>{{ $order->created_at->format('d M Y, g:i A') }}</div>
        </div>

        <hr class="hr">

        {{-- Items --}}
        @foreach($order->items as $item)
            <div class="rc-item">
                <span class="qty">{{ (int) $item->quantity }} &times;</span>
                <span class="nm">{{ $item->product_name }}</span>
                <span class="amt">{{ format_price($item->total) }}</span>
            </div>
            {{-- The size the customer picked. Labelled, because on its own a
                 bare "Large" under the item name reads like part of the name. --}}
            @if($item->variant_name)
                <div class="rc-item-variant"><span class="lead">Size:</span> {{ $item->variant_name }}</div>
            @endif

            {{-- What the customer chose, under the section it came from, so the
                 kitchen reads "Sauce: ..." rather than one undifferentiated "+"
                 run. Options carry their section from the basket; anything
                 older, or from before sections existed, falls back to "Extras"
                 rather than being dropped. Prices are shown where there is one,
                 so the line can still be checked against the total.

                 What the customer took OFF is deliberately not printed: the
                 shop asked for it out, and the kitchen works from what is on
                 the slip rather than what is absent from it. It is still on the
                 order, so the admin can see it. --}}
            @php
                $opts = $item->toppings_list;
                $chosen = collect($opts['kept'] ?? [])->concat($opts['added'] ?? [])
                    ->filter(fn ($t) => filled($t['name'] ?? null))
                    ->groupBy(fn ($t) => trim($t['section'] ?? '') ?: 'Extras');
            @endphp
            @foreach($chosen as $section => $picked)
                <div class="rc-opt"><span class="lead">{{ $section }}:</span></div>
                @foreach($picked as $t)
                    <div class="rc-opt-item">{{ $t['name'] }}@if(($t['price'] ?? 0) > 0) ({{ format_price($t['price']) }})@endif@unless($loop->last),@endunless</div>
                @endforeach
            @endforeach
        @endforeach

        {{-- Order note. Optional — most orders carry none, and the box only
             appears when the customer actually wrote something. Placed directly
             under the items it applies to, and boxed so it cannot be skimmed
             past on a busy pass. --}}
        @if(filled($order->notes))
            <div class="rc-kitchen-note">
                <div class="hdr">** CUSTOMER NOTE **</div>
                <div class="body">{{ $order->notes }}</div>
            </div>
        @endif

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
                    '@page { size: 72mm ' + mm.toFixed(1) + 'mm; margin: 0; }';
            }

            setPageHeight();
            window.addEventListener('load', setPageHeight);
            window.addEventListener('beforeprint', setPageHeight);
        })();
    </script>

    @if($isTest ?? false)
        {{-- The point of the test page is the print itself, so fire it unprompted.
             What lands on the roll is then a true rehearsal of a real order. --}}
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 500);
            });
        </script>
    @endif
</body>
</html>
