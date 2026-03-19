<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'فرحنا') – فرحنا</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:    #c9a84c;
            --gold-d:  #a8863a;
            --gold-l:  #e0c878;
            --gold-bg: #faf7ee;
            --gold-xl: #f0e8c8;
            --navy:    #0a1628;
            --navy-m:  #162035;
            --text:    #12100e;
            --muted:   #6b6358;
            --border:  #e8e3d8;
            --white:   #ffffff;
            --surface: #faf8f3;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
        }

        /* ─── Navbar ─── */
        .navbar {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 12px rgba(18,16,14,.05);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-style: italic;
            color: var(--gold-d);
            text-decoration: none;
            font-weight: 700;
        }

        .navbar-nav { display: flex; align-items: center; gap: 1rem; }

        .nav-link {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color .2s;
        }
        .nav-link:hover { color: var(--gold-d); }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem 1.25rem;
            border-radius: 8px;
            font-size: .9rem;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            border: none;
            font-weight: 600;
        }
        .btn-primary {
            background: var(--navy);
            color: var(--gold-l);
            box-shadow: 0 2px 10px rgba(10,22,40,.25);
        }
        .btn-primary:hover {
            background: var(--navy-m);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(10,22,40,.35);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold-d); background: var(--gold-bg); }

        /* ─── Container ─── */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ─── Card ─── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(18,16,14,.04);
        }

        /* ─── Alert ─── */
        .alert-error {
            background: #fff8f0;
            border: 1px solid #f0d898;
            color: var(--gold-d);
            padding: .75rem 1rem;
            border-radius: 8px;
            font-size: .875rem;
            margin-bottom: 1rem;
        }

        /* ─── Form ─── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .875rem; font-weight: 600; margin-bottom: .4rem; color: var(--text); }
        .form-input {
            width: 100%;
            padding: .6rem .9rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: .95rem;
            transition: border-color .2s, box-shadow .2s;
            background: var(--white);
            color: var(--text);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,.15);
        }
        .form-error { color: #be123c; font-size: .8rem; margin-top: .3rem; }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('customer.dashboard') }}" class="navbar-brand">فرحنا ♥</a>
    <div class="navbar-nav">
        @auth
            <a href="{{ route('customer.dashboard') }}" class="nav-link">أحداثي</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-outline">خروج</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link">تسجيل الدخول</a>
            <a href="{{ route('register') }}" class="btn btn-primary">ابدأ مجاناً</a>
        @endauth
    </div>
</nav>

<main>
    @yield('content')
</main>

@livewireScripts
@stack('scripts')

</body>
</html>
