<img src="{{ asset('images/logo.svg') }}" alt="{{ \App\Models\Setting::get('site_name', config('app.name')) }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
