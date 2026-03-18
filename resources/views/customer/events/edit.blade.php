@extends('layouts.customer')
@section('title', 'تعديل – ' . $event->coupleName())

@section('content')
<div class="container" style="max-width:720px;">

    {{-- Back --}}
    <a href="{{ route('customer.events.show', $event) }}"
       style="display:inline-flex; align-items:center; gap:.4rem; color:#78716c; text-decoration:none; margin-bottom:1.5rem; font-size:.9rem;">
        ← رجوع للحدث
    </a>

    {{-- Header --}}
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#1c1917;">
            تعديل بيانات الحفل
        </h1>
        <p style="color:#78716c; font-size:.9rem; margin-top:.25rem;">{{ $event->coupleName() }}</p>
    </div>

    @if(session('success'))
        <div style="background:#dcfce7; border:1px solid #bbf7d0; color:#166534; padding:1rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; font-size:.9rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#fff1f2; border:1px solid #fecdd3; color:#be123c; padding:1rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; font-size:.875rem;">
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul style="margin-top:.5rem; padding-right:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('customer.events.update', $event) }}">
        @csrf @method('PUT')

        {{-- ── تفاصيل الحفل ── --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <h2 style="font-weight:700; font-size:1rem; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #e7e5e4;">
                💍 تفاصيل الحفل
            </h2>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">اسم العريس *</label>
                    <input type="text" name="groom_name" class="form-input @error('groom_name') border-red @enderror"
                           value="{{ old('groom_name', $event->groom_name) }}" required>
                    @error('groom_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">اسم العروسة *</label>
                    <input type="text" name="bride_name" class="form-input @error('bride_name') border-red @enderror"
                           value="{{ old('bride_name', $event->bride_name) }}" required>
                    @error('bride_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">تاريخ الحفل *</label>
                    <input type="date" name="event_date" class="form-input @error('event_date') border-red @enderror"
                           value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" required>
                    @error('event_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">الوقت</label>
                    <input type="time" name="event_time" class="form-input"
                           value="{{ old('event_time', $event->event_time) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">اسم القاعة *</label>
                <input type="text" name="venue_name" class="form-input @error('venue_name') border-red @enderror"
                       value="{{ old('venue_name', $event->venue_name) }}" required>
                @error('venue_name')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">العنوان</label>
                <input type="text" name="venue_address" class="form-input"
                       value="{{ old('venue_address', $event->venue_address) }}"
                       placeholder="مثال: القاهرة، مصر الجديدة">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">رابط الخريطة</label>
                <input type="url" name="venue_map_link" class="form-input @error('venue_map_link') border-red @enderror"
                       value="{{ old('venue_map_link', $event->venue_map_link) }}"
                       placeholder="https://maps.google.com/...">
                @error('venue_map_link')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── إعدادات النشر ── --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <h2 style="font-weight:700; font-size:1rem; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #e7e5e4;">
                🌐 إعدادات النشر
            </h2>

            <div class="form-group">
                <label class="form-label">الرابط المخصص (Subdomain)</label>
                <div style="display:flex; align-items:center; gap:.5rem;">
                    <input type="text" name="subdomain" class="form-input @error('subdomain') border-red @enderror"
                           value="{{ old('subdomain', $event->subdomain) }}"
                           placeholder="ahmed-and-sara"
                           style="flex:1;">
                    <span style="color:#78716c; font-size:.875rem; white-space:nowrap;">
                        .{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                    </span>
                </div>
                @error('subdomain')<p class="form-error">{{ $message }}</p>@enderror
                <p style="font-size:.78rem; color:#a8a29e; margin-top:.3rem;">اتركه فارغاً لو مش عاوز subdomain مخصص</p>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label style="display:flex; align-items:center; gap:.75rem; cursor:pointer; user-select:none;">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1"
                           {{ old('is_published', $event->is_published) ? 'checked' : '' }}
                           style="width:18px; height:18px; accent-color:#e11d48; cursor:pointer;">
                    <span style="font-size:.95rem; font-weight:500;">نشر الدعوة (ظاهرة للضيوف)</span>
                </label>
            </div>
        </div>

        {{-- ── كلمة المرور ── --}}
        <div class="card" style="margin-bottom:1.5rem;">
            <h2 style="font-weight:700; font-size:1rem; margin-bottom:1.25rem; padding-bottom:.75rem; border-bottom:1px solid #e7e5e4;">
                🔒 كلمة المرور
            </h2>

            @if($event->isPasswordProtected())
                <div style="background:#fef9c3; border:1px solid #fde68a; border-radius:8px; padding:.75rem 1rem; margin-bottom:1rem; font-size:.85rem; color:#854d0e;">
                    ⚠️ الدعوة محمية حالياً بكلمة مرور. اكتب كلمة مرور جديدة لتغييرها، أو اتركها فارغة للإبقاء على الحالية.
                </div>
            @endif

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label class="form-label">{{ $event->isPasswordProtected() ? 'كلمة مرور جديدة' : 'كلمة المرور' }}</label>
                    <input type="password" name="new_password" class="form-input @error('new_password') border-red @enderror"
                           placeholder="{{ $event->isPasswordProtected() ? 'اتركها فارغة للإبقاء' : 'اتركها فارغة بدون حماية' }}">
                    @error('new_password')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">تلميح كلمة المرور</label>
                    <input type="text" name="password_hint" class="form-input"
                           value="{{ old('password_hint', $event->password_hint) }}"
                           placeholder="مثال: تاريخ ميلادي">
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div style="display:flex; gap:.75rem; justify-content:flex-end;">
            <a href="{{ route('customer.events.show', $event) }}"
               class="btn btn-outline">إلغاء</a>
            <button type="submit" class="btn btn-primary">
                💾 حفظ التعديلات
            </button>
        </div>

    </form>

</div>

<style>
    .form-group  { margin-bottom: 1rem; }
    .form-label  { display:block; font-size:.875rem; font-weight:600; margin-bottom:.4rem; color:#1c1917; }
    .form-input  {
        width:100%; padding:.7rem 1rem;
        border:1.5px solid #e7e5e4; border-radius:10px;
        font-family:inherit; font-size:.95rem; background:#fafaf9;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus {
        outline:none; border-color:#e11d48;
        box-shadow:0 0 0 3px rgba(225,29,72,.1); background:#fff;
    }
    .border-red  { border-color:#fca5a5 !important; }
    .form-error  { color:#be123c; font-size:.8rem; margin-top:.3rem; }
</style>
@endsection
