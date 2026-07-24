@component('mail::message')
# Welcome to {{ \App\Models\Setting::get('site_name', config('app.name')) }}!

Hi {{ $user->first_name }},

We are thrilled to have you join the {{ \App\Models\Setting::get('site_name', config('app.name')) }} family! Thank you for creating your account with us.

At {{ \App\Models\Setting::get('site_name', config('app.name')) }}, we are passionate about providing quality products. From everyday essentials to the latest items, we have everything you need.

---

## Here Is What You Can Look Forward To

- **Curated Menu** -- Handcrafted burgers, crispy sides, and refreshing drinks for every craving
- **Quality You Can Trust** -- Durable, reliable products you can count on
- **Exclusive Deals** -- Member-only discounts and early access to sales
- **Easy Returns** -- Hassle-free returns within 7 days of delivery

@component('mail::button', ['url' => url('/shop')])
Start Shopping
@endcomponent

---

## Your Account Details

**Name:** {{ $user->full_name }}
**Email:** {{ $user->email }}

You can manage your profile, track orders, and save your favorite items all from your account dashboard.

@component('mail::button', ['url' => url('/account'), 'color' => 'success'])
Visit Your Account
@endcomponent

If you have any questions or need assistance, our friendly support team is always ready to help. Just reply to this email or visit our help center.

We cannot wait to serve you the best burgers in town!

Warm regards,
**{{ \App\Models\Setting::get('site_name', config('app.name')) }}**
@endcomponent
