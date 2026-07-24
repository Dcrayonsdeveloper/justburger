<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=barlow:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Barlow', sans-serif;
            background: #111;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.25rem;
        }

        .auth-wrapper { width: 100%; max-width: 420px; }

        /* Logo */
        .auth-logo {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .auth-logo a {
            text-decoration: none;
            font-family: 'Anton', Impact, 'Arial Black', sans-serif;
            font-size: 2rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1;
        }
        .auth-logo .red { color: #C8102E; }
        .auth-logo .white { color: #fff; }

        /* Card */
        .auth-card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 1rem;
            padding: 2rem 1.75rem;
        }
        .auth-card h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: .25rem;
        }
        .auth-subtitle {
            font-size: .9rem;
            color: rgba(255,255,255,.45);
            margin-bottom: 1.5rem;
        }

        /* Inputs */
        .auth-label {
            display: block;
            font-size: .85rem;
            font-weight: 700;
            color: rgba(255,255,255,.7);
            margin-bottom: .35rem;
        }
        .auth-input {
            width: 100%;
            padding: .7rem 1rem;
            background: rgba(255,255,255,.06);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: .6rem;
            font-size: .95rem;
            font-family: inherit;
            color: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .auth-input::placeholder { color: rgba(255,255,255,.25); }
        .auth-input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200,16,46,.15);
        }
        .auth-input-error { border-color: #ef4444; }

        /* Buttons */
        .auth-btn-primary {
            width: 100%;
            padding: .8rem 1rem;
            background: #C8102E;
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            font-family: inherit;
            border-radius: .6rem;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }
        .auth-btn-primary:hover { background: #A50E26; }
        .auth-btn-primary:active { transform: scale(.98); }
        .auth-btn-primary:disabled { opacity: .5; cursor: default; }

        .auth-btn-outline {
            width: 100%;
            padding: .75rem 1rem;
            background: transparent;
            border: 1.5px solid rgba(255,255,255,.15);
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            font-family: inherit;
            border-radius: .6rem;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }
        .auth-btn-outline:hover {
            background: rgba(255,255,255,.05);
            border-color: rgba(255,255,255,.25);
        }

        /* Social buttons */
        .auth-social-row { display: flex; gap: .75rem; }
        .auth-social-btn {
            flex: 1;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .7rem;
            background: rgba(255,255,255,.06);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: .6rem;
            color: rgba(255,255,255,.7);
            font-size: .9rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, border-color .2s;
        }
        .auth-social-btn:hover {
            background: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.2);
        }
        .auth-social-btn svg { width: 18px; height: 18px; }

        /* Divider */
        .auth-divider {
            display: flex; align-items: center; gap: .75rem;
            margin: 1.25rem 0;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: rgba(255,255,255,.1);
        }
        .auth-divider span {
            font-size: .8rem; color: rgba(255,255,255,.35); white-space: nowrap;
        }

        /* Checkbox */
        .auth-check-row {
            display: flex; align-items: center; gap: .5rem;
            margin-top: .75rem;
        }
        .auth-check-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #C8102E; border-radius: 3px;
        }
        .auth-check-row label {
            font-size: .85rem; color: rgba(255,255,255,.5);
        }

        /* Links */
        .auth-link {
            color: #C8102E; text-decoration: none;
            font-weight: 700; font-size: .85rem;
            transition: opacity .2s;
        }
        .auth-link:hover { opacity: .8; text-decoration: underline; }

        .auth-text-btn {
            background: none; border: none;
            color: rgba(255,255,255,.4); font-size: .85rem;
            font-family: inherit;
            cursor: pointer; transition: color .2s;
        }
        .auth-text-btn:hover { color: #C8102E; }

        .auth-error { font-size: .8rem; color: #f87171; margin-top: .3rem; }
        .auth-success {
            padding: .75rem 1rem;
            background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25);
            border-radius: .6rem; color: #34d399;
            font-size: .9rem; margin-bottom: 1rem;
        }
        .auth-hint { font-size: .8rem; color: rgba(255,255,255,.3); margin-top: .25rem; }

        .auth-terms { font-size: .8rem; color: rgba(255,255,255,.35); line-height: 1.6; margin-top: 1.25rem; }
        .auth-terms a { color: #C8102E; text-decoration: none; }
        .auth-terms a:hover { text-decoration: underline; }

        .auth-step-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: .5rem;
        }
        .auth-step-id { font-size: .9rem; color: rgba(255,255,255,.5); }
        .auth-step-id strong { color: #fff; }

        .auth-otp-input {
            text-align: center; letter-spacing: 8px;
            font-weight: 700; font-size: 1.2rem;
        }

        .auth-back-link {
            display: inline-flex; align-items: center; gap: .35rem;
            font-size: .85rem; color: rgba(255,255,255,.3);
            text-decoration: none; transition: color .2s;
        }
        .auth-back-link:hover { color: #C8102E; }

        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: .75rem;
            color: rgba(255,255,255,.15);
        }
    </style>
</head>
<body x-data style="margin:0;">

<div class="auth-wrapper"
     x-data="{
        mode: '{{ $errors->has('full_name') || $errors->has('phone') || $errors->has('terms') || old('_register') || request()->get('mode') === 'register' ? 'register' : 'login' }}'
     }">

    <!-- Logo -->
    <div class="auth-logo">
        <a href="{{ url('/') }}">
            <span class="red">JUST</span><span class="white">BURGERS</span>
        </a>
    </div>

    <!-- ============================
         LOGIN FORM
         ============================ -->
    <div x-show="mode === 'login'" x-cloak:remove>
        <div class="auth-card" x-data="unifiedLogin()">
            <h1>Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account to continue</p>

            @if(session('success'))
                <div class="auth-success">{{ session('success') }}</div>
            @endif

            {{-- Step 1: Enter email or phone --}}
            <div x-show="step === 'identifier'" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="auth-label">Email or Phone Number</label>
                    <input type="text" x-model="identifier" @keyup.enter="continueLogin()" autofocus
                           class="auth-input" placeholder="Enter your email or mobile">
                </div>
                <button @click="continueLogin()" type="button" class="auth-btn-primary">Continue</button>
                <p x-show="error" x-text="error" class="auth-error" x-cloak></p>
            </div>

            {{-- Step 2a: Password login --}}
            <div x-show="step === 'password'" x-cloak style="display:flex;flex-direction:column;gap:1rem;">
                <div class="auth-step-header">
                    <p class="auth-step-id"><span x-text="identifier"></span></p>
                    <button @click="step='identifier';error=''" type="button" class="auth-link">Change</button>
                </div>
                <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1rem;">
                    @csrf
                    <input type="hidden" name="email" :value="identifier">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem;">
                            <label class="auth-label" style="margin:0;">Password</label>
                            <a href="{{ route('password.request') }}" class="auth-link">Forgot?</a>
                        </div>
                        <input type="password" name="password" required autocomplete="current-password" class="auth-input">
                    </div>
                    <button type="submit" class="auth-btn-primary">Sign In</button>
                </form>
                <div style="text-align:center;">
                    <button @click="sendOtpForIdentifier()" type="button" class="auth-text-btn">Sign in with OTP instead</button>
                </div>
            </div>

            {{-- Step 2b: OTP sent --}}
            <div x-show="step === 'otp_sent'" x-cloak style="display:flex;flex-direction:column;gap:1rem;">
                <div class="auth-step-header">
                    <p class="auth-step-id">OTP sent to <strong x-text="identifier"></strong></p>
                    <button @click="step='identifier';error=''" type="button" class="auth-link">Change</button>
                </div>
                <div>
                    <label class="auth-label">Enter OTP</label>
                    <input type="text" x-model="otp" maxlength="6" inputmode="numeric" @keyup.enter="verifyOtp()"
                           class="auth-input auth-otp-input" placeholder="- - - - - -">
                </div>
                <button @click="verifyOtp()" :disabled="verifying" type="button" class="auth-btn-primary">
                    <span x-show="!verifying">Verify & Sign In</span>
                    <span x-show="verifying">Verifying...</span>
                </button>
                <p x-show="error" x-text="error" class="auth-error" x-cloak></p>
                <p class="auth-hint">OTP sent via WhatsApp + Email. Valid 10 min.</p>
            </div>

            {{-- Sending OTP --}}
            <div x-show="step === 'sending_otp'" x-cloak style="padding:1.25rem 0;text-align:center;">
                <p style="font-size:.95rem;color:rgba(255,255,255,.5);">Sending OTP to <strong style="color:#fff;" x-text="identifier"></strong>...</p>
            </div>

            <div class="auth-check-row">
                <input type="checkbox" id="remember">
                <label for="remember">Keep me signed in</label>
            </div>
        </div>

        <!-- Social Login -->
        <div class="auth-divider"><span>Or continue with</span></div>
        <div class="auth-social-row">
            @if(config('services.google.client_id'))
            <a href="{{ route('social.redirect', 'google') }}" class="auth-social-btn">
                <svg viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Google
            </a>
            @endif
            <a href="{{ route('social.redirect', 'facebook') }}" class="auth-social-btn">
                <svg fill="#1877F2" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </a>
        </div>

        <!-- Switch to register -->
        <div class="auth-divider"><span>New to {{ \App\Models\Setting::get('site_name', config('app.name')) }}?</span></div>
        <button @click="mode = 'register'" class="auth-btn-outline">
            Create your account
        </button>

        <!-- Back to home -->
        <div style="text-align:center;margin-top:1.5rem;">
            <a href="{{ url('/') }}" class="auth-back-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to {{ \App\Models\Setting::get('site_name', config('app.name')) }}
            </a>
        </div>
    </div>

    <!-- ============================
         REGISTER FORM
         ============================ -->
    <div x-show="mode === 'register'" x-cloak>
        <div class="auth-card">
            <h1>Create Account</h1>
            <p class="auth-subtitle">Join us and start ordering</p>

            <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <input type="hidden" name="_register" value="1">

                <div>
                    <label for="full_name" class="auth-label">Your name</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required autocomplete="name"
                           class="auth-input @error('full_name') auth-input-error @enderror" placeholder="First and last name">
                    @error('full_name')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="auth-label">Mobile number <span style="font-weight:400;color:rgba(255,255,255,.3);">(optional)</span></label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel"
                           class="auth-input @error('phone') auth-input-error @enderror" placeholder="Mobile number">
                    @error('phone')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg_email" class="auth-label">Email</label>
                    <input type="email" name="email" id="reg_email" value="{{ old('_register') ? old('email') : '' }}" required autocomplete="email"
                           class="auth-input @if(old('_register')) @error('email') auth-input-error @enderror @endif">
                    @if(old('_register'))
                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label for="reg_password" class="auth-label">Password</label>
                    <input type="password" name="password" id="reg_password" required autocomplete="new-password"
                           class="auth-input @if(old('_register')) @error('password') auth-input-error @enderror @endif"
                           placeholder="At least 8 characters">
                    <p class="auth-hint">Passwords must be at least 8 characters.</p>
                    @if(old('_register'))
                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label for="password_confirmation" class="auth-label">Re-enter password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" class="auth-input">
                </div>

                <button type="submit" class="auth-btn-primary" style="margin-top:.25rem;">Create Account</button>
            </form>

            <p class="auth-terms">
                By creating an account, you agree to {{ \App\Models\Setting::get('site_name', config('app.name')) }}'s
                <a href="{{ route('terms') }}">Conditions of Use</a>
                and
                <a href="{{ route('privacy') }}">Privacy Notice</a>.
            </p>
        </div>

        <!-- Switch to login -->
        <div class="auth-divider"><span>Already have an account?</span></div>
        <button @click="mode = 'login'" class="auth-btn-outline">
            Sign in to your account
        </button>

        <div style="text-align:center;margin-top:1.5rem;">
            <a href="{{ url('/') }}" class="auth-back-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to {{ \App\Models\Setting::get('site_name', config('app.name')) }}
            </a>
        </div>
    </div>

    <div class="auth-footer">
        &copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', config('app.name')) }}. All rights reserved.
    </div>
</div>

<script>
function unifiedLogin() {
    return {
        identifier: '', otp: '', step: 'identifier',
        sending: false, verifying: false, error: '',

        continueLogin() {
            if (!this.identifier.trim()) { this.error = 'Enter email or phone number'; return; }
            this.error = '';
            const isPhone = /^\+?\d[\d\s-]{8,}$/.test(this.identifier.replace(/\s/g, ''));
            if (isPhone) {
                this.sendOtpForIdentifier();
            } else {
                this.step = 'password';
            }
        },

        async sendOtpForIdentifier() {
            this.step = 'sending_otp'; this.error = '';
            try {
                const r = await fetch('{{ route("otp.send-login") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                    body: JSON.stringify({ identifier: this.identifier })
                });
                if (r.status === 429) { this.error = 'Too many attempts. Please wait a few minutes.'; this.step = 'identifier'; return; }
                const d = await r.json();
                if (d.success) { this.step = 'otp_sent'; }
                else { this.error = d.message || 'Failed to send OTP'; this.step = 'identifier'; }
            } catch(e) { this.error = 'Something went wrong. Please try again.'; this.step = 'identifier'; }
        },

        async verifyOtp() {
            if (!this.otp || this.otp.length !== 6) { this.error = 'Enter 6-digit OTP'; return; }
            this.verifying = true; this.error = '';
            try {
                const r = await fetch('{{ route("otp.verify-login") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                    body: JSON.stringify({ identifier: this.identifier, otp: this.otp })
                });
                if (r.status === 429) { this.error = 'Too many attempts. Please wait a few minutes.'; this.verifying = false; return; }
                const d = await r.json();
                if (d.success) { window.location.href = d.redirect; }
                else { this.error = d.message || 'Invalid OTP'; }
            } catch(e) { this.error = 'Something went wrong. Please try again.'; }
            this.verifying = false;
        }
    };
}
function otpReset() {
    return {
        identifier: '', otp: '', password: '', passwordConfirm: '',
        step: 1, sending: false, verifying: false, resetting: false, error: '', success: '',
        async sendOtp() {
            if (!this.identifier) return;
            this.sending = true; this.error = '';
            try {
                const r = await fetch('{{ route("otp.send-reset") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ identifier: this.identifier })
                });
                const d = await r.json();
                if (d.success) { this.step = 2; }
                else { this.error = d.message; }
            } catch(e) { this.error = 'Network error'; }
            this.sending = false;
        },
        async verifyOtp() {
            if (!this.otp || this.otp.length !== 6) { this.error = 'Enter 6-digit OTP'; return; }
            this.verifying = true; this.error = '';
            try {
                const r = await fetch('{{ route("otp.verify-reset") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ identifier: this.identifier, otp: this.otp })
                });
                const d = await r.json();
                if (d.success) { this.step = 3; }
                else { this.error = d.message; }
            } catch(e) { this.error = 'Network error'; }
            this.verifying = false;
        },
        async resetPassword() {
            if (this.password.length < 8) { this.error = 'Password must be at least 8 characters'; return; }
            if (this.password !== this.passwordConfirm) { this.error = 'Passwords do not match'; return; }
            this.resetting = true; this.error = '';
            try {
                const r = await fetch('{{ route("otp.reset-password") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                    body: JSON.stringify({ password: this.password, password_confirmation: this.passwordConfirm })
                });
                const d = await r.json();
                if (d.success) { window.location.href = d.redirect; }
                else { this.error = d.message; }
            } catch(e) { this.error = 'Network error'; }
            this.resetting = false;
        }
    };
}
</script>
</body>
</html>
