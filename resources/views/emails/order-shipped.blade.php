@component('mail::message')
# Your Order Is On Its Way!

Hi {{ $order->user->first_name }},

Exciting news -- your order **#{{ $order->order_number }}** is out for delivery and on its way to you!

@if($trackingNumber)
**Tracking Number:** {{ $trackingNumber }}

You can use this tracking number to follow your order's progress.

@component('mail::button', ['url' => url('/orders/' . $order->id . '/track')])
Track Your Order
@endcomponent
@else
@component('mail::button', ['url' => url('/orders/' . $order->id)])
View Order Details
@endcomponent
@endif

---

## Order Summary

**Order Number:** #{{ $order->order_number }}
**Out for Delivery:** {{ $order->shipped_at ? $order->shipped_at->format('M d, Y \a\t h:i A') : now()->format('M d, Y \a\t h:i A') }}

@component('mail::table')
| Item | Qty | Price |
|:-----|:---:|------:|
@foreach ($order->items as $item)
| {{ $item->product_name }}@if($item->variant_name) ({{ $item->variant_name }})@endif | {{ $item->quantity }} | {{ format_price($item->total) }} |
@endforeach
| | **Total:** | **{{ format_price($order->total) }}** |
@endcomponent

@if($order->shipping_address_snapshot)
**Delivering To:**
{{ $order->shipping_address_snapshot['name'] ?? '' }}
{{ $order->shipping_address_snapshot['address_line_1'] ?? '' }}
@if(!empty($order->shipping_address_snapshot['address_line_2'])){{ $order->shipping_address_snapshot['address_line_2'] }}@endif
{{ $order->shipping_address_snapshot['city'] ?? '' }}, {{ $order->shipping_address_snapshot['state'] ?? '' }} {{ $order->shipping_address_snapshot['postal_code'] ?? '' }}
@endif

We will notify you once your order has been delivered. If you have any questions about your delivery, our support team is here to help.

Happy ordering!

Warm regards,
**{{ \App\Models\Setting::get('site_name', config('app.name')) }}**
@endcomponent
