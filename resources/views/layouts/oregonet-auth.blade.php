<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'OREGONET') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Token warna sama dengan halaman Home guest */
        :root{
            --red:#DC2626;
            --red-dark:#B91C1C;
            --ink:#111827;
            --muted:#6B7280;
            --line:#F1F1F1;
            --field:#E5E7EB;
        }

        body{
            margin:0;
            font-family:'Figtree',ui-sans-serif,system-ui,sans-serif;
            background:#E5E7EB;
            color:var(--ink);
            -webkit-font-smoothing:antialiased;
        }

        .au-page{
            max-width:480px;
            width:100%;
            min-height:100vh;
            margin:0 auto;
            background:#F8F9FB;
            box-shadow:0 20px 40px -20px rgba(17,24,39,.25);
            overflow-x:hidden;
            padding-bottom:32px;
        }

        /* ============ HERO ============ */
        .au-hero{
            position:relative;
            overflow:hidden;
            padding:22px 20px 76px;
            color:#fff;
            background:linear-gradient(135deg,#111827 0%,#1F2937 55%,#3B0A0A 100%);
            border-radius:0 0 32px 32px;
        }
        .au-hero::before{
            content:"";
            position:absolute;
            width:240px;height:240px;
            right:-80px;top:-90px;
            border-radius:50%;
            background:radial-gradient(circle,rgba(220,38,38,.55),rgba(220,38,38,0) 70%);
        }
        .au-hero > *{position:relative;z-index:1;}

        .au-lang{
            display:flex;
            justify-content:flex-end;
        }
        .au-lang-group{
            display:inline-flex;
            padding:3px;
            border-radius:999px;
            background:rgba(255,255,255,.12);
        }
        .au-lang a{
            padding:5px 12px;
            border-radius:999px;
            font-size:11px;
            font-weight:800;
            color:rgba(255,255,255,.7);
            text-decoration:none;
            -webkit-tap-highlight-color:transparent;
        }
        .au-lang a.is-active{
            background:#fff;
            color:var(--red-dark);
        }
        .au-lang a:focus-visible{outline:2px solid #fff;outline-offset:2px;}

        .au-brand{
            display:flex;
            align-items:center;
            gap:14px;
            margin-top:18px;
        }
        .au-logo{
            width:52px;height:52px;
            flex-shrink:0;
            border-radius:16px;
            display:flex;align-items:center;justify-content:center;
            background:linear-gradient(135deg,#DC2626,#B91C1C);
            box-shadow:0 10px 18px -6px rgba(220,38,38,.6);
        }
        .au-logo svg{width:28px;height:28px;color:#fff;}
        .au-brand-name{
            font-size:20px;
            font-weight:800;
            letter-spacing:.02em;
            line-height:1.1;
        }
        .au-brand-sub{
            margin-top:3px;
            font-size:12px;
            font-weight:600;
            color:rgba(255,255,255,.65);
        }

        /* ============ CARD ============ */
        .au-body{padding:0 16px;margin-top:-48px;position:relative;z-index:2;}
        .au-card{
            background:#fff;
            border:1px solid var(--line);
            border-radius:24px;
            padding:22px 18px 20px;
            box-shadow:0 18px 30px -18px rgba(17,24,39,.35);
        }
        .au-title{
            font-size:20px;
            font-weight:800;
            line-height:1.2;
            color:var(--ink);
        }
        .au-sub{
            margin-top:4px;
            font-size:12px;
            color:var(--muted);
        }

        .au-form{margin-top:18px;display:grid;gap:14px;}

        .au-label{
            display:block;
            margin-bottom:6px;
            font-size:12px;
            font-weight:700;
            color:#374151;
        }
        .au-input{
            display:block;
            width:100%;
            box-sizing:border-box;
            padding:12px 14px;
            font-size:14px;
            font-family:inherit;
            color:var(--ink);
            background:#F9FAFB;
            border:1px solid var(--field);
            border-radius:14px;
            outline:none;
            transition:border-color .15s ease,box-shadow .15s ease,background .15s ease;
        }
        .au-input::placeholder{color:#9CA3AF;}
        .au-input:focus{
            background:#fff;
            border-color:var(--red);
            box-shadow:0 0 0 4px rgba(220,38,38,.12);
        }
        .au-input.has-error{border-color:var(--red);}
        .au-error{
            margin-top:6px;
            font-size:12px;
            font-weight:600;
            color:var(--red-dark);
        }

        .au-pw{position:relative;}
        .au-pw .au-input{padding-right:46px;}
        .au-pw-toggle{
            position:absolute;
            top:50%;right:6px;
            transform:translateY(-50%);
            width:34px;height:34px;
            display:flex;align-items:center;justify-content:center;
            border:0;
            border-radius:10px;
            background:transparent;
            color:#9CA3AF;
            cursor:pointer;
        }
        .au-pw-toggle:hover{color:var(--ink);}
        .au-pw-toggle:focus-visible{outline:2px solid var(--red);outline-offset:1px;}
        .au-pw-toggle svg{width:20px;height:20px;}
        .au-pw-toggle .eye-off{display:none;}
        .au-pw-toggle.is-on .eye{display:none;}
        .au-pw-toggle.is-on .eye-off{display:block;}

        .au-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }
        .au-check{
            display:inline-flex;
            align-items:center;
            gap:8px;
            font-size:12.5px;
            color:#4B5563;
            cursor:pointer;
        }
        .au-check input{
            width:16px;height:16px;
            margin:0;
            accent-color:var(--red);
        }
        .au-link{
            font-size:12.5px;
            font-weight:700;
            color:var(--red);
            text-decoration:none;
        }
        .au-link:hover{color:var(--red-dark);text-decoration:underline;}
        .au-link:focus-visible{outline:2px solid var(--red);outline-offset:2px;border-radius:4px;}

        .au-btn{
            width:100%;
            padding:14px 18px;
            border:0;
            border-radius:14px;
            font-family:inherit;
            font-size:14px;
            font-weight:800;
            color:#fff;
            cursor:pointer;
            background:linear-gradient(135deg,#DC2626,#B91C1C);
            box-shadow:0 10px 18px -8px rgba(220,38,38,.6);
            transition:transform .15s ease,box-shadow .15s ease;
            -webkit-tap-highlight-color:transparent;
        }
        .au-btn:hover{box-shadow:0 14px 22px -8px rgba(220,38,38,.7);}
        .au-btn:active{transform:scale(.98);}
        .au-btn:focus-visible{outline:3px solid rgba(220,38,38,.35);outline-offset:2px;}

        .au-foot{
            margin-top:18px;
            text-align:center;
            font-size:12.5px;
            color:var(--muted);
        }
        .au-foot .au-link{margin-left:4px;}

        @media (prefers-reduced-motion:reduce){
            .au-input,.au-btn{transition:none;}
        }
    </style>
</head>
<body>

<div class="au-page">

    {{-- Hero --}}
    <header class="au-hero">



        <div class="au-brand">
            <span class="au-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                </svg>
            </span>
            <div>
                <p class="au-brand-name">OREGONET</p>
                <p class="au-brand-sub">Apartment Services</p>
            </div>
        </div>

    </header>

    {{-- Konten (form) --}}
    <main class="au-body">
        <div class="au-card">
            @yield('content')
        </div>
    </main>

</div>

<script>
    // Tampilkan / sembunyikan password
    document.querySelectorAll('[data-toggle-pw]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.togglePw);
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.classList.toggle('is-on', show);
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        });
    });
</script>

</body>
</html>
