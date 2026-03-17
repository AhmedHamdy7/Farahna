@extends('layouts.customer')
@section('title', 'تسجيل الدخول')

@section('content')
<div style="min-height: calc(100vh - 64px); display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div style="width: 100%; max-width: 420px;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #e11d48;">أهلاً بك!</h1>
            <p style="color: #78716c; margin-top: .5rem;">سجّل دخولك لإدارة دعواتك</p>
        </div>

        <div class="card">
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                    <label style="display:flex; align-items:center; gap:.4rem; font-size:.875rem; cursor:pointer;">
                        <input type="checkbox" name="remember"> تذكّرني
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:.75rem;">
                    دخول
                </button>
            </form>
        </div>

        <p style="text-align:center; margin-top:1.5rem; color:#78716c; font-size:.9rem;">
            ليس لديك حساب؟
            <a href="{{ route('register') }}" style="color:#e11d48; text-decoration:none; font-weight:500;">سجّل الآن مجاناً</a>
        </p>
    </div>
</div>
@endsection
