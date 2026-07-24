<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Sign In - <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=barlow:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Barlow', sans-serif;
            background: #111;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo a {
            text-decoration: none;
            font-family: 'Anton', Impact, 'Arial Black', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1;
        }
        .logo .red { color: #C8102E; }
        .logo .white { color: #fff; }

        .admin-badge {
            display: inline-block;
            margin-top: .75rem;
            padding: .25rem .75rem;
            background: rgba(200,16,46,.15);
            border: 1px solid rgba(200,16,46,.3);
            border-radius: 2rem;
            font-size: .75rem;
            font-weight: 700;
            color: #C8102E;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Card */
        .card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 1rem;
            padding: 2rem 1.75rem;
        }
        .card h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: .25rem;
        }
        .card .subtitle {
            font-size: .9rem;
            color: rgba(255,255,255,.45);
            margin-bottom: 1.5rem;
        }

        /* Form */
        .form-group { margin-bottom: 1.15rem; }
        .form-group label {
            display: block;
            font-size: .85rem;
            font-weight: 700;
            color: rgba(255,255,255,.7);
            margin-bottom: .4rem;
        }
        .form-group input {
            width: 100%;
            padding: .7rem 1rem;
            font-size: .95rem;
            background: rgba(255,255,255,.06);
            border: 1.5px solid rgba(255,255,255,.12);
            border-radius: .6rem;
            color: #fff;
            outline: none;
            font-family: 'Barlow', sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-group input::placeholder { color: rgba(255,255,255,.25); }
        .form-group input:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200,16,46,.15);
        }
        .form-group .error {
            font-size: .8rem;
            color: #f87171;
            margin-top: .3rem;
        }

        /* Password wrapper */
        .pw-wrap { position: relative; }
        .pw-wrap input { padding-right: 44px; }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,.35);
            padding: 4px;
            transition: color .2s;
        }
        .pw-toggle:hover { color: rgba(255,255,255,.6); }

        /* Remember */
        .remember {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-top: .75rem;
            margin-bottom: 1.25rem;
        }
        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #C8102E;
            border-radius: 3px;
        }
        .remember label {
            font-size: .85rem;
            color: rgba(255,255,255,.5);
            cursor: pointer;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            padding: .8rem 1rem;
            background: #C8102E;
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            border: none;
            border-radius: .6rem;
            cursor: pointer;
            font-family: 'Barlow', sans-serif;
            transition: background .2s, transform .1s;
        }
        .btn-submit:hover { background: #A50E26; }
        .btn-submit:active { transform: scale(.98); }

        /* Alert */
        .alert {
            padding: .75rem 1rem;
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.25);
            border-radius: .6rem;
            font-size: .85rem;
            color: #f87171;
            margin-bottom: 1.25rem;
        }

        /* Back link */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .85rem;
            color: rgba(255,255,255,.35);
            text-decoration: none;
            transition: color .2s;
        }
        .back-link a:hover { color: #C8102E; }

        /* Footer */
        .footer {
            margin-top: 2rem;
            font-size: .75rem;
            color: rgba(255,255,255,.2);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="logo">
            <a href="<?php echo e(url('/')); ?>">
                <span class="red">JUST</span><span class="white">BURGERS</span>
            </a>
            <br>
            <span class="admin-badge">Admin Panel</span>
        </div>

        <div class="card">
            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to the admin dashboard</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="admin@justburgers.com">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="password" required placeholder="Enter your password">
                        <button type="button" class="pw-toggle" onclick="var p=document.getElementById('password'); p.type=p.type==='password'?'text':'password';">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="btn-submit">Sign In</button>
            </form>
        </div>

        <div class="back-link">
            <a href="<?php echo e(url('/')); ?>">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to website
            </a>
        </div>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>