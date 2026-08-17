<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ \App\Models\Setting::get('site_name', config('app.name')) }}</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg?v=3">
    <link rel="shortcut icon" href="/images/icons/favicon.svg?v=3">

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
        /* x-show clears the element's inline `display`, which would wipe an inline
           display:flex and leave gap doing nothing. Keep it in a class. */
        .auth-stack { display:flex; flex-direction:column; gap:1rem; }

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
            <div x-show="step === 'identifier'" class="auth-stack">
                <div>
                    <label class="auth-label">Email or Phone Number</label>
                    <input type="text" x-model="identifier" @keyup.enter="continueLogin()" autofocus
                           class="auth-input" placeholder="Enter your email or mobile">
                </div>
                <button @click="continueLogin()" type="button" class="auth-btn-primary">Continue</button>
                <p x-show="error" x-text="error" class="auth-error" x-cloak></p>
            </div>

            {{-- Step 2a: Password login --}}
            <div x-show="step === 'password'" x-cloak class="auth-stack">
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
            </div>

            <div class="auth-check-row">
                <input type="checkbox" id="remember">
                <label for="remember">Keep me signed in</label>
            </div>
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
                    <label for="reg_email" class="auth-label">Email</label>
                    <input type="email" name="email" id="reg_email" value="{{ old('_register') ? old('email') : '' }}" required autocomplete="email" placeholder="you@example.com"
                           class="auth-input @if(old('_register')) @error('email') auth-input-error @enderror @endif">
                    @if(old('_register'))
                        @error('email')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label for="phone" class="auth-label">Mobile number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required autocomplete="tel"
                           class="auth-input @error('phone') auth-input-error @enderror" placeholder="07123 456789">
                    @error('phone')
                        <p class="auth-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reg_password" class="auth-label">Password</label>
                    <input type="password" name="password" id="reg_password" required autocomplete="new-password"
                           class="auth-input @if(old('_register')) @error('password') auth-input-error @enderror @endif"
                           placeholder="At least 8 characters">
                    @if(old('_register'))
                        @error('password')
                            <p class="auth-error">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <div>
                    <label for="password_confirmation" class="auth-label">Re-enter password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" class="auth-input" placeholder="Re-enter your password">
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
        identifier: '', step: 'identifier',
        error: '',

        continueLogin() {
            if (!this.identifier.trim()) { this.error = 'Enter email or phone number'; return; }
            this.error = '';
            // Email or phone — the next step is always the password.
            this.step = 'password';
        },
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
