@extends('layouts.customer')
@section('title', 'إنشاء حساب')

@section('content')
<div style="min-height: calc(100vh - 64px); display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div style="width: 100%; max-width: 440px;">

        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #e11d48;">ابدأ رحلتك ♥</h1>
            <p style="color: #78716c; margin-top: .5rem;">أنشئ حسابك وابدأ بدعوتك المجانية</p>
        </div>

        <div class="card">
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="intended_template" value="{{ session('intended_template') ?? request('template') }}">

                <div class="form-group">
                    <label class="form-label">الاسم</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:.75rem; margin-top:.5rem;">
                    إنشاء الحساب
                </button>
            </form>
        </div>

        <p style="text-align:center; margin-top:1.5rem; color:#78716c; font-size:.9rem;">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}{{ session('intended_template') || request('template') ? '?template='.(session('intended_template') ?? request('template')) : '' }}" style="color:#e11d48; text-decoration:none; font-weight:500;">سجّل الدخول</a>
        </p>
    </div>
</div>
@endsection
