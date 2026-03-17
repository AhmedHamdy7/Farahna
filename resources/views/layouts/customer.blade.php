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
            --rose:   #e11d48;
            --rose-light: #fff1f2;
            --gold:   #b45309;
            --text:   #1c1917;
            --muted:  #78716c;
            --border: #e7e5e4;
            --white:  #ffffff;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: #faf9f7;
            color: var(--text);
            min-height: 100vh;
        }

        /* ─── Navbar ─── */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--rose);
            text-decoration: none;
        }

        .navbar-nav { display: flex; align-items: center; gap: 1rem; }

        .nav-link {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color .2s;
        }
        .nav-link:hover { color: var(--rose); }

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
        }
        .btn-primary {
            background: var(--rose);
            color: var(--white);
        }
        .btn-primary:hover { background: #be123c; }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-outline:hover { border-color: var(--rose); color: var(--rose); }

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
            border-radius: 12px;
            padding: 1.5rem;
        }

        /* ─── Alert ─── */
        .alert-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
            padding: .75rem 1rem;
            border-radius: 8px;
            font-size: .875rem;
            margin-bottom: 1rem;
        }

        /* ─── Form ─── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .875rem; font-weight: 500; margin-bottom: .4rem; }
        .form-input {
            width: 100%;
            padding: .6rem .9rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: .95rem;
            transition: border-color .2s;
            background: var(--white);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, .1);
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
