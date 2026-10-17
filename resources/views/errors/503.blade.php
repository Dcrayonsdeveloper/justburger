<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Launching Soon — Just Burgers Plus</title>
    <meta name="robots" content="noindex">
    {{--
        Served by storage/framework/maintenance.php with the framework not yet
        booted, so this has to stand on its own: everything inline, nothing from
        the asset pipeline, no Blade data resolved at request time.
    --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500&display=swap">
    <style>
        :root {
            --ink:    #ffffff;
            --ground: #0d0d0d;
            --brand:  #C8102E;
            --muted:  rgba(255,255,255,.45);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body { height: 100%; }

        body {
            background: var(--ground);
            color: var(--ink);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            -webkit-font-smoothing: antialiased;
        }

        /* A very soft warm glow behind the mark, so the panel is not a flat
           black rectangle on a phone screen. */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 70% 55% at 50% 42%, rgba(200,16,46,.16), transparent 70%);
            pointer-events: none;
        }

        .wrap { position: relative; max-width: 640px; }

        .brand {
            font-family: 'Anton', Impact, 'Arial Black', sans-serif;
            font-size: clamp(30px, 7vw, 46px);
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1;
            white-space: nowrap;
        }
        .brand .a { color: var(--brand); }
        .brand .b { color: #fff; margin-left: 2px; }

        .rule {
            width: 54px;
            height: 3px;
            background: var(--brand);
            margin: 28px auto;
            border-radius: 2px;
        }

        h1 {
            font-family: 'Anton', Impact, 'Arial Black', sans-serif;
            font-size: clamp(44px, 13vw, 104px);
            line-height: .95;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-wrap: balance;
        }

        .sub {
            margin-top: 22px;
            font-size: clamp(14px, 3.4vw, 17px);
            line-height: 1.6;
            color: var(--muted);
            letter-spacing: .2px;
        }

        @media (prefers-reduced-motion: no-preference) {
            .wrap > * { animation: rise .6s cubic-bezier(.22,.8,.3,1) backwards; }
            .brand { animation-delay: .05s; }
            .rule  { animation-delay: .15s; }
            h1     { animation-delay: .22s; }
            .sub   { animation-delay: .32s; }
            @keyframes rise {
                from { opacity: 0; transform: translateY(12px); }
                to   { opacity: 1; transform: none; }
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="brand"><span class="a">JUST</span><span class="b">BURGERS</span></div>
        <div class="rule"></div>
        <h1>Launching Soon</h1>
        <p class="sub">We&rsquo;re getting everything ready. Back very soon.</p>
    </div>
</body>
</html>
