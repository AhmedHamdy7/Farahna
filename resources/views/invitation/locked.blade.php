<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دعوة خاصة – فرحنا</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #fff1f2 0%, #fdf8f0 60%, #fce7f3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .lock-card {
            background: #fff;
            border: 1px solid #e7e5e4;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
            animation: fadeUp .6s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .lock-icon {
            font-size: 3rem;
            margin-bottom: 1.25rem;
            display: block;
        }

        .couple-names {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-style: italic;
            color: #1c1917;
            margin-bottom: .5rem;
        }

        .lock-label {
            color: #78716c;
            font-size: .9rem;
            margin-bottom: 2rem;
        }

        @if($event->password_hint)
        .hint-box {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            padding: .9rem 1.1rem;
            margin-bottom: 1.5rem;
            font-size: .875rem;
            color: #9a3412;
            text-align: right;
        }
        .hint-box strong { display: block; margin-bottom: .25rem; }
        @endif

        .form-group { margin-bottom: 1.25rem; text-align: right; }

        .form-label {
            display: block;
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: .4rem;
            color: #1c1917;
        }

        .form-input {
            width: 100%;
            padding: .75rem 1rem;
            border: 1.5px solid #e7e5e4;
            border-radius: 10px;
            font-family: 'Tajawal', sans-serif;
            font-size: 1rem;
            text-align: center;
            letter-spacing: 4px;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #e11d48;
            box-shadow: 0 0 0 3px rgba(225,29,72,.1);
        }

        .form-error {
            color: #be123c;
            font-size: .8rem;
            margin-top: .4rem;
            text-align: center;
        }

        .btn-unlock {
            width: 100%;
            padding: .85rem;
            background: #e11d48;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Tajawal', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-unlock:hover { background: #be123c; }

        .footer-brand {
            margin-top: 2rem;
            font-size: .75rem;
            color: #d6d3d1;
        }
    </style>
</head>
<body>
    <div class="lock-card">
        <span class="lock-icon">🔒</span>

        <h1 class="couple-names">{{ $event->groom_name }} & {{ $event->bride_name }}</h1>
        <p class="lock-label">هذه الدعوة خاصة، يرجى إدخال كلمة المرور للمتابعة</p>

        @if($event->password_hint)
            <div class="hint-box">
                <strong>💡 تلميح:</strong>
                {{ $event->password_hint }}
            </div>
        @endif

        <form method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-input"
                       placeholder="• • • • • •" autofocus required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-unlock">فتح الدعوة 🔓</button>
        </form>

        <p class="footer-brand">Farahna ♥</p>
    </div>
</body>
</html>
