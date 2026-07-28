<x-layouts.app>
    @php
        $siteName = \App\Models\Setting::get('site_name', config('app.name'));
        $phone = \App\Models\Setting::get('site_phone', '+44 20889 05008');
        $mobile = \App\Models\Setting::get('site_mobile', '+44 7368 429 896');
        $waNumber = \App\Models\Setting::get('whatsapp_number', '447368429896');
        $email = \App\Models\Setting::get('contact_email', 'info@justburgers.com');
        $address = \App\Models\Setting::get('company_address', '525 Staines Road, Bedfont, TW14 8BP');
        $businessHours = \App\Models\Setting::get('business_hours', 'Mon-Thu 12-10PM, Fri-Sat 12-11PM, Sun 12-10PM');
        $openHours = \App\Models\Setting::get('opening_hours', '');
        $openHoursArr = is_array($openHours) ? $openHours : [];
        $mapEmbed = \App\Models\Setting::get('google_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2486.5!2d-0.4517!3d51.4538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2s525+Staines+Road%2C+Bedfont%2C+TW14+8BP!5e0!3m2!1sen!2suk!4v1700000000000');
    @endphp

    <x-slot name="title">Contact Us — {{ $siteName }}</x-slot>

    @push('meta')
        <meta name="description" content="Get in touch with {{ $siteName }}. Call, WhatsApp, or drop us a message — we're here to help with orders, feedback, and enquiries.">
        <link rel="canonical" href="{{ url('/contact') }}">
        <meta property="og:title" content="Contact Us — {{ $siteName }}">
        <meta property="og:description" content="Get in touch with {{ $siteName }}. Call, WhatsApp, or send us a message.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/contact') }}">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Contact Us — {{ $siteName }}">
    @endpush

    <x-slot name="styles">
    <style>
        .ct-page { background:#fafaf8; min-height:70vh; }

        /* ─── Breadcrumb ─── */
        .ct-bc-bar {
            background:#fff;
            border-bottom:1px solid rgba(0,0,0,.08);
            padding:.75rem 1.25rem;
        }
        .ct-bc {
            max-width:1100px; margin:0 auto;
            display:flex; flex-wrap:wrap; align-items:center;
            gap:.3rem .45rem; font-size:.78rem; color:rgba(0,0,0,.38);
        }
        .ct-bc a { color:rgba(0,0,0,.38); text-decoration:none; transition:color .14s; }
        .ct-bc a:hover { color:#C8102E; }
        .ct-bc-sep { opacity:.4; }

        /* ─── Hero ─── */
        .ct-hero {
            background:#1a1210;
            padding:2.5rem 1.25rem 2.75rem;
            text-align:center;
        }
        .ct-hero-inner { max-width:600px; margin:0 auto; }
        .ct-hero h1 {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:clamp(1.8rem,5vw,2.8rem);
            text-transform:uppercase; letter-spacing:.03em;
            color:#fff; line-height:1.05; margin-bottom:.6rem;
        }
        .ct-hero p {
            font-size:.95rem; color:rgba(255,255,255,.5);
            line-height:1.6; max-width:420px; margin:0 auto;
        }

        /* ─── Quick contact cards ─── */
        .ct-quick {
            max-width:1100px; margin:-2rem auto 0;
            padding:0 1.25rem;
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:1rem;
            position:relative; z-index:2;
        }
        @media(max-width:640px){
            .ct-quick { grid-template-columns:1fr; margin-top:-1.5rem; }
        }
        .ct-qcard {
            background:#fff;
            border:1px solid rgba(0,0,0,.08);
            border-radius:.85rem;
            padding:1.25rem;
            text-align:center;
            text-decoration:none;
            transition:box-shadow .18s, transform .12s;
            display:flex; flex-direction:column; align-items:center; gap:.5rem;
        }
        .ct-qcard:hover { box-shadow:0 6px 24px rgba(0,0,0,.08); transform:translateY(-2px); }
        .ct-qcard-icon {
            width:2.8rem; height:2.8rem;
            border-radius:50%;
            display:flex; align-items:center; justify-content:center;
        }
        .ct-qcard-icon svg { width:1.3rem; height:1.3rem; }
        .ct-qcard-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1rem;
            text-transform:uppercase; letter-spacing:.04em;
            color:#1a1210;
        }
        .ct-qcard-detail { font-size:.82rem; color:rgba(0,0,0,.45); }

        /* ─── Main grid ─── */
        .ct-main {
            max-width:1100px; margin:0 auto;
            padding:2.5rem 1.25rem 3rem;
            display:grid;
            grid-template-columns:1fr;
            gap:2rem;
        }
        @media(min-width:768px){
            .ct-main { grid-template-columns:5fr 4fr; gap:2.5rem; }
        }

        /* ─── Form card ─── */
        .ct-form-card {
            background:#fff;
            border:1px solid rgba(0,0,0,.08);
            border-radius:.85rem;
            padding:1.75rem 1.5rem 2rem;
        }
        .ct-form-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:900; font-size:1.35rem;
            text-transform:uppercase; letter-spacing:.03em;
            color:#1a1210; margin-bottom:.35rem;
        }
        .ct-form-sub {
            font-size:.85rem; color:rgba(0,0,0,.4);
            margin-bottom:1.5rem;
        }
        .ct-label {
            display:block; font-size:.78rem; font-weight:700;
            color:rgba(0,0,0,.5); margin-bottom:.35rem;
            letter-spacing:.04em; text-transform:uppercase;
        }
        .ct-label .req { color:#C8102E; }
        .ct-input {
            width:100%; background:#fafaf8;
            border:1.5px solid rgba(0,0,0,.1);
            border-radius:.55rem;
            padding:.7rem .9rem; font-size:.9rem; color:#1a1210;
            outline:none; transition:border-color .14s;
        }
        .ct-input:focus { border-color:#C8102E; }
        .ct-input::placeholder { color:rgba(0,0,0,.22); }
        .ct-input.error { border-color:#ef4444; }
        .ct-error { font-size:.72rem; color:#ef4444; margin-top:.3rem; }
        .ct-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        @media(max-width:480px){ .ct-row { grid-template-columns:1fr; } }
        .ct-field { margin-bottom:1.1rem; }

        .ct-submit {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            background:#C8102E; color:#fff;
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1rem;
            text-transform:uppercase; letter-spacing:.04em;
            padding:.8rem 2rem; border-radius:99px;
            border:none; cursor:pointer;
            transition:background .14s, transform .1s;
            box-shadow:0 3px 12px rgba(200,16,46,.2);
        }
        .ct-submit:hover { background:#a50e26; }
        .ct-submit:active { transform:scale(.97); }

        /* ─── Right sidebar ─── */
        .ct-sidebar { display:flex; flex-direction:column; gap:1.25rem; }

        .ct-info-card {
            background:#fff;
            border:1px solid rgba(0,0,0,.08);
            border-radius:.85rem;
            padding:1.35rem 1.25rem;
        }
        .ct-info-title {
            font-family:'Barlow Condensed',sans-serif;
            font-weight:800; font-size:1.05rem;
            text-transform:uppercase; letter-spacing:.04em;
            color:#1a1210; margin-bottom:.9rem;
            padding-bottom:.5rem;
            border-bottom:2px solid #C8102E;
            display:inline-block;
        }
        .ct-info-row {
            display:flex; align-items:flex-start; gap:.75rem;
            padding:.65rem 0;
            border-bottom:1px solid rgba(0,0,0,.05);
        }
        .ct-info-row:last-child { border-bottom:none; }
        .ct-info-icon {
            width:2.2rem; height:2.2rem; flex-shrink:0;
            border-radius:50%;
            background:rgba(200,16,46,.06);
            display:flex; align-items:center; justify-content:center;
        }
        .ct-info-icon svg { width:1rem; height:1rem; color:#C8102E; }
        .ct-info-label { font-size:.68rem; font-weight:700; color:rgba(0,0,0,.35); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.15rem; }
        .ct-info-val { font-size:.88rem; color:#1a1210; line-height:1.5; }
        .ct-info-val a { color:#C8102E; text-decoration:none; font-weight:600; }
        .ct-info-val a:hover { text-decoration:underline; }

        /* Hours */
        .ct-hours-row {
            display:flex; justify-content:space-between;
            font-size:.82rem; padding:.25rem 0;
            border-bottom:1px solid rgba(0,0,0,.04);
        }
        .ct-hours-row:last-child { border-bottom:none; }
        .ct-hours-day { color:rgba(0,0,0,.5); }
        .ct-hours-time { color:#C8102E; font-weight:600; }

        /* Map */
        .ct-map {
            border-radius:.85rem;
            overflow:hidden;
            border:1px solid rgba(0,0,0,.08);
        }
        .ct-map iframe {
            width:100%; height:240px; display:block; border:0;
        }

        /* ─── Success toast ─── */
        .ct-success {
            max-width:1100px; margin:1.25rem auto 0;
            padding:0 1.25rem;
        }
        .ct-success-inner {
            display:flex; align-items:center; gap:.65rem;
            padding:.85rem 1.1rem;
            background:rgba(22,163,74,.06);
            border:1px solid rgba(22,163,74,.18);
            border-radius:.65rem;
        }
        .ct-success-inner svg { width:1.1rem; height:1.1rem; color:#16a34a; flex-shrink:0; }
        .ct-success-inner p { font-size:.88rem; color:#16a34a; font-weight:600; }
    </style>
    </x-slot>

    <div class="ct-page">

        {{-- Breadcrumb --}}
        <div class="ct-bc-bar">
            <nav class="ct-bc">
                <a href="{{ url('/') }}">Home</a>
                <span class="ct-bc-sep">/</span>
                <span style="color:#1a1210;font-weight:600;">Contact Us</span>
            </nav>
        </div>

        {{-- Hero --}}
        <div class="ct-hero">
            <div class="ct-hero-inner">
                <h1>Get In Touch</h1>
                <p>Have a question, feedback, or want to place a large order? We'd love to hear from you.</p>
            </div>
        </div>

        {{-- Quick contact cards --}}
        <div class="ct-quick">
            @if($phone)
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="ct-qcard">
                <div class="ct-qcard-icon" style="background:rgba(200,16,46,.06);">
                    <svg fill="none" stroke="#C8102E" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div class="ct-qcard-title">Call Us</div>
                <div class="ct-qcard-detail">{{ $phone }}</div>
            </a>
            @endif

            @if($waNumber)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}" target="_blank" rel="noopener" class="ct-qcard">
                <div class="ct-qcard-icon" style="background:rgba(37,211,102,.08);">
                    <svg fill="#25D366" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <div class="ct-qcard-title">WhatsApp</div>
                <div class="ct-qcard-detail">{{ $mobile ?: 'Message us' }}</div>
            </a>
            @endif

            @if($email)
            <a href="mailto:{{ $email }}" class="ct-qcard">
                <div class="ct-qcard-icon" style="background:rgba(200,16,46,.06);">
                    <svg fill="none" stroke="#C8102E" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ct-qcard-title">Email</div>
                <div class="ct-qcard-detail">{{ $email }}</div>
            </a>
            @endif
        </div>

        {{-- Success message --}}
        @if(session('success'))
        <div class="ct-success">
            <div class="ct-success-inner">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Main: form + sidebar --}}
        <div class="ct-main">

            {{-- Left: Contact form --}}
            <div class="ct-form-card">
                <h2 class="ct-form-title">Send Us a Message</h2>
                <p class="ct-form-sub">Fill in the form below and we'll get back to you as soon as possible.</p>

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <div class="ct-row">
                        <div class="ct-field">
                            <label class="ct-label">Your Name <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="ct-input @error('name') error @enderror"
                                   placeholder="e.g. James Wilson">
                            @error('name')<p class="ct-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="ct-field">
                            <label class="ct-label">Email <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="ct-input @error('email') error @enderror"
                                   placeholder="you@example.com">
                            @error('email')<p class="ct-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="ct-row">
                        <div class="ct-field">
                            <label class="ct-label">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   class="ct-input @error('phone') error @enderror"
                                   placeholder="+44 7700 900 000">
                            @error('phone')<p class="ct-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="ct-field">
                            <label class="ct-label">Subject <span class="req">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                   class="ct-input @error('subject') error @enderror"
                                   placeholder="How can we help?">
                            @error('subject')<p class="ct-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="ct-field">
                        <label class="ct-label">Message <span class="req">*</span></label>
                        <textarea name="message" rows="5" required minlength="10"
                                  class="ct-input @error('message') error @enderror"
                                  style="resize:none;"
                                  placeholder="Tell us about your enquiry...">{{ old('message') }}</textarea>
                        @error('message')<p class="ct-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="ct-submit">
                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Right: sidebar --}}
            <div class="ct-sidebar">

                {{-- Contact details --}}
                <div class="ct-info-card">
                    <h3 class="ct-info-title">Contact Details</h3>

                    @if($address)
                    <div class="ct-info-row">
                        <div class="ct-info-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="ct-info-label">Address</div>
                            <div class="ct-info-val">{!! nl2br(e($address)) !!}</div>
                        </div>
                    </div>
                    @endif

                    @if($phone)
                    <div class="ct-info-row">
                        <div class="ct-info-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="ct-info-label">Phone</div>
                            <div class="ct-info-val">
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($email)
                    <div class="ct-info-row">
                        <div class="ct-info-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="ct-info-label">Email</div>
                            <div class="ct-info-val">
                                <a href="mailto:{{ $email }}">{{ $email }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Opening hours --}}
                @if(count($openHoursArr) || $businessHours)
                <div class="ct-info-card">
                    <h3 class="ct-info-title">Opening Hours</h3>
                    @if(count($openHoursArr))
                        @foreach($openHoursArr as $day => $time)
                        <div class="ct-hours-row">
                            <span class="ct-hours-day">{{ $day }}</span>
                            <span class="ct-hours-time">{{ $time }}</span>
                        </div>
                        @endforeach
                    @elseif($businessHours)
                        <p style="font-size:.88rem;color:rgba(0,0,0,.55);line-height:1.6;">{{ $businessHours }}</p>
                    @endif
                </div>
                @endif

                {{-- Map --}}
                @if($mapEmbed)
                <div class="ct-map">
                    <iframe src="{{ $mapEmbed }}"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                @endif

            </div>
        </div>

    </div>
</x-layouts.app>
