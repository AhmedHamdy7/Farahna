@extends('layouts.customer')
@section('title', $event->coupleName())

@section('content')
<div class="container">

    {{-- Back --}}
    <a href="{{ route('customer.dashboard') }}"
       style="display:inline-flex; align-items:center; gap:.4rem; color:#78716c; text-decoration:none; margin-bottom:1.5rem; font-size:.9rem;">
        ← رجوع للأحداث
    </a>

    @if(session('success'))
        <div style="background:#dcfce7; border:1px solid #bbf7d0; color:#166534; padding:1rem 1.25rem; border-radius:10px; margin-bottom:1.25rem; font-size:.9rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Card --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div>
                <h1 style="font-family:'Playfair Display',serif; font-size:1.8rem; color:#e11d48;">
                    {{ $event->coupleName() }}
                </h1>
                <p style="color:#78716c; margin-top:.35rem;">
                    📅 {{ $event->event_date->format('d/m/Y') }}
                    @if($event->event_time) · {{ $event->event_time }} @endif
                    &nbsp;|&nbsp;
                    📍 {{ $event->venue_name }}
                </p>
            </div>
            <span style="
                padding:.4rem 1rem; border-radius:999px; font-size:.8rem; font-weight:600;
                background:{{ $event->is_published ? '#dcfce7' : '#fef9c3' }};
                color:{{ $event->is_published ? '#166534' : '#854d0e' }};
            ">
                {{ $event->is_published ? '✓ منشور' : '○ مسودة' }}
            </span>
            <a href="{{ route('customer.events.edit', $event) }}"
               class="btn btn-outline" style="font-size:.85rem; padding:.4rem 1rem;">
                ✏️ تعديل
            </a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; align-items:start;">

        {{-- Left Column --}}
        <div>

            {{-- Invitation Link --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <h2 style="font-weight:700; margin-bottom:1rem;">🔗 رابط الدعوة</h2>
                <div style="display:flex; align-items:center; gap:.75rem; background:#f5f5f4; padding:.75rem 1rem; border-radius:8px;">
                    <span style="font-size:.9rem; color:#44403c; flex:1; word-break:break-all;">
                        {{ $event->invitationUrl() }}
                    </span>
                    <button onclick="navigator.clipboard.writeText('{{ $event->invitationUrl() }}'); this.textContent='✓ تم';"
                            class="btn btn-outline" style="font-size:.8rem; padding:.35rem .8rem; flex-shrink:0;">
                        نسخ
                    </button>
                </div>
                @if($event->isPasswordProtected())
                    <p style="margin-top:.5rem; font-size:.8rem; color:#78716c;">
                        🔒 محمية بكلمة مرور @if($event->password_hint) · تلميح: {{ $event->password_hint }} @endif
                    </p>
                @endif
            </div>

            {{-- Stats --}}
            @php
                $allWishes  = $event->wishes;
                $rsvpAll    = $event->rsvpResponses;
                $rsvpYes    = $rsvpAll->where('attending', \App\Enums\RsvpStatus::Yes)->count();
                $rsvpNo     = $rsvpAll->where('attending', \App\Enums\RsvpStatus::No)->count();
                $rsvpMaybe  = $rsvpAll->where('attending', \App\Enums\RsvpStatus::Maybe)->count();
                $totalGuests= $rsvpAll->where('attending', \App\Enums\RsvpStatus::Yes)->sum('guests_count');
            @endphp
            <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">
                <div class="card" style="text-align:center;">
                    <p style="font-size:1.6rem; font-weight:700; color:#16a34a;">{{ $rsvpYes }}</p>
                    <p style="font-size:.75rem; color:#78716c;">✅ حاضر</p>
                </div>
                <div class="card" style="text-align:center;">
                    <p style="font-size:1.6rem; font-weight:700; color:#dc2626;">{{ $rsvpNo }}</p>
                    <p style="font-size:.75rem; color:#78716c;">❌ غائب</p>
                </div>
                <div class="card" style="text-align:center;">
                    <p style="font-size:1.6rem; font-weight:700; color:#d97706;">{{ $rsvpMaybe }}</p>
                    <p style="font-size:.75rem; color:#78716c;">🤔 ربما</p>
                </div>
                <div class="card" style="text-align:center;">
                    <p style="font-size:1.6rem; font-weight:700; color:#7c3aed;">{{ $totalGuests }}</p>
                    <p style="font-size:.75rem; color:#78716c;">👥 إجمالي الضيوف</p>
                </div>
            </div>

            {{-- RSVP Responses --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <h2 style="font-weight:700; margin-bottom:1rem;">📋 ردود الحضور ({{ $rsvpAll->count() }})</h2>

                @if($rsvpAll->isEmpty())
                    <p style="color:#78716c; text-align:center; padding:1.5rem 0; font-size:.9rem;">
                        لم يرد أحد بعد
                    </p>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; font-size:.875rem;">
                            <thead>
                                <tr style="border-bottom:2px solid #e7e5e4; text-align:right;">
                                    <th style="padding:.6rem .75rem; color:#78716c; font-weight:600;">الاسم</th>
                                    <th style="padding:.6rem .75rem; color:#78716c; font-weight:600;">الهاتف</th>
                                    <th style="padding:.6rem .75rem; color:#78716c; font-weight:600;">الحضور</th>
                                    <th style="padding:.6rem .75rem; color:#78716c; font-weight:600;">عدد الأشخاص</th>
                                    <th style="padding:.6rem .75rem; color:#78716c; font-weight:600;">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rsvpAll as $rsvp)
                                    <tr style="border-bottom:1px solid #f5f5f4;">
                                        <td style="padding:.65rem .75rem; font-weight:600;">{{ $rsvp->guest_name }}</td>
                                        <td style="padding:.65rem .75rem; color:#78716c; direction:ltr;">{{ $rsvp->phone ?? '—' }}</td>
                                        <td style="padding:.65rem .75rem;">
                                            @if($rsvp->attending === \App\Enums\RsvpStatus::Yes)
                                                <span style="background:#dcfce7; color:#166534; padding:.2rem .65rem; border-radius:999px; font-size:.75rem; font-weight:600;">✅ حاضر</span>
                                            @elseif($rsvp->attending === \App\Enums\RsvpStatus::No)
                                                <span style="background:#fee2e2; color:#991b1b; padding:.2rem .65rem; border-radius:999px; font-size:.75rem; font-weight:600;">❌ غائب</span>
                                            @else
                                                <span style="background:#fef9c3; color:#854d0e; padding:.2rem .65rem; border-radius:999px; font-size:.75rem; font-weight:600;">🤔 ربما</span>
                                            @endif
                                        </td>
                                        <td style="padding:.65rem .75rem; text-align:center;">{{ $rsvp->guests_count }}</td>
                                        <td style="padding:.65rem .75rem; color:#78716c; font-size:.8rem;">{{ $rsvp->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Wishes --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                    <h2 style="font-weight:700;">💌 التهاني ({{ $allWishes->count() }})</h2>
                    @if($allWishes->where('is_approved', false)->count() > 0)
                        <span style="background:#fef9c3; color:#854d0e; padding:.25rem .75rem; border-radius:999px; font-size:.75rem; font-weight:600;">
                            {{ $allWishes->where('is_approved', false)->count() }} في انتظار الموافقة
                        </span>
                    @endif
                </div>

                @if($allWishes->isEmpty())
                    <p style="color:#78716c; text-align:center; padding:1.5rem 0; font-size:.9rem;">
                        لم يكتب أحد تهنئة بعد
                    </p>
                @else
                    <div style="display:grid; gap:.75rem;">
                        @foreach($allWishes as $wish)
                            <div style="
                                border:1px solid {{ $wish->is_approved ? '#bbf7d0' : '#e7e5e4' }};
                                border-radius:12px; padding:1rem 1.25rem;
                                background:{{ $wish->is_approved ? '#f0fdf4' : '#fafaf9' }};
                            ">
                                <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem;">
                                    <div style="flex:1;">
                                        <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.4rem;">
                                            <span style="font-weight:700; font-size:.95rem; color:#e11d48;">{{ $wish->guest_name }}</span>
                                            @if($wish->is_approved)
                                                <span style="font-size:.7rem; background:#dcfce7; color:#166534; padding:.1rem .5rem; border-radius:999px;">✓ معتمدة</span>
                                            @else
                                                <span style="font-size:.7rem; background:#fef9c3; color:#854d0e; padding:.1rem .5rem; border-radius:999px;">⏳ انتظار</span>
                                            @endif
                                        </div>
                                        <p style="color:#44403c; line-height:1.6; font-size:.9rem;">{{ $wish->message }}</p>
                                        <p style="font-size:.75rem; color:#a8a29e; margin-top:.4rem;">{{ $wish->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div style="display:flex; gap:.4rem; flex-shrink:0;">
                                        <form method="POST" action="{{ route('customer.events.wishes.approve', [$event, $wish]) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" style="
                                                border:1px solid {{ $wish->is_approved ? '#d1d5db' : '#16a34a' }};
                                                color:{{ $wish->is_approved ? '#78716c' : '#16a34a' }};
                                                background:transparent; border-radius:8px;
                                                padding:.3rem .7rem; font-size:.75rem; cursor:pointer;
                                            ">
                                                {{ $wish->is_approved ? 'إلغاء الاعتماد' : '✓ اعتماد' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('customer.events.wishes.delete', [$event, $wish]) }}"
                                              onsubmit="return confirm('حذف هذه التهنئة؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="
                                                border:1px solid #fca5a5; color:#dc2626;
                                                background:transparent; border-radius:8px;
                                                padding:.3rem .7rem; font-size:.75rem; cursor:pointer;
                                            ">🗑</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Gallery --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                    <h2 style="font-weight:700;">🖼️ معرض الصور ({{ $event->gallery->count() }} / 20)</h2>
                </div>

                @if(session('gallery_success'))
                    <div style="background:#dcfce7; border:1px solid #bbf7d0; color:#166534; padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:.875rem;">
                        {{ session('gallery_success') }}
                    </div>
                @endif

                @if($errors->hasBag('default') && $errors->has('photos'))
                    <div style="background:#fff1f2; border:1px solid #fecdd3; color:#be123c; padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:.875rem;">
                        @foreach($errors->get('photos.*') as $msgs)
                            @foreach($msgs as $msg)<p>{{ $msg }}</p>@endforeach
                        @endforeach
                    </div>
                @endif

                {{-- Upload Form --}}
                @if($event->gallery->count() < 20)
                <form method="POST"
                      action="{{ route('customer.events.gallery.store', $event) }}"
                      enctype="multipart/form-data"
                      id="galleryForm">
                    @csrf
                    <label for="photoInput" style="
                        display:flex; flex-direction:column; align-items:center; justify-content:center;
                        gap:.5rem; border:2px dashed #e7e5e4; border-radius:12px;
                        padding:1.5rem; cursor:pointer; transition:all .2s;
                        color:#78716c; font-size:.9rem; margin-bottom:1rem;
                        background:#fafaf9;
                    " onmouseover="this.style.borderColor='#e11d48';this.style.color='#e11d48'"
                       onmouseout="this.style.borderColor='#e7e5e4';this.style.color='#78716c'">
                        <span style="font-size:2rem;">📷</span>
                        <span style="font-weight:600;">اضغط لاختيار الصور</span>
                        <span style="font-size:.78rem;">JPG, PNG, WEBP · حتى 5 ميجا للصورة · حتى {{ 20 - $event->gallery->count() }} صورة</span>
                    </label>
                    <input type="file" id="photoInput" name="photos[]"
                           accept="image/jpeg,image/png,image/webp"
                           multiple style="display:none;"
                           onchange="previewPhotos(this)">

                    <div id="photoPreview" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(80px,1fr)); gap:.5rem; margin-bottom:.75rem;"></div>

                    <button type="submit" id="uploadBtn" style="display:none;"
                            class="btn btn-primary" style="width:100%;">
                        ⬆️ رفع الصور
                    </button>
                </form>
                @endif

                {{-- Existing Photos --}}
                @if($event->gallery->isNotEmpty())
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(100px,1fr)); gap:.6rem; margin-top:.5rem;">
                    @foreach($event->gallery as $photo)
                    <div style="position:relative; aspect-ratio:1; border-radius:8px; overflow:hidden; group;">
                        <img src="{{ Storage::url($photo->image_path) }}"
                             alt="" style="width:100%; height:100%; object-fit:cover;">
                        <form method="POST"
                              action="{{ route('customer.events.gallery.destroy', [$event, $photo]) }}"
                              onsubmit="return confirm('حذف هذه الصورة؟')"
                              style="position:absolute; top:4px; left:4px;">
                            @csrf @method('DELETE')
                            <button type="submit" style="
                                background:rgba(0,0,0,.6); color:#fff; border:none;
                                border-radius:6px; width:26px; height:26px;
                                font-size:.75rem; cursor:pointer; line-height:1;
                            ">✕</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                    @if($event->gallery->count() >= 20)
                    @else
                        <p style="text-align:center; color:#a8a29e; font-size:.85rem; padding:.5rem 0;">لم تُرفع صور بعد</p>
                    @endif
                @endif
            </div>

        </div>

        {{-- Right Column --}}
        <div style="position:sticky; top:1.5rem;">
            <div class="card" style="margin-bottom:1rem;">
                <h3 style="font-weight:600; margin-bottom:.75rem;">تفاصيل الحفل</h3>
                <dl style="font-size:.875rem; line-height:2.2;">
                    <dt style="color:#78716c;">القالب</dt>
                    <dd style="font-weight:500;">{{ $event->template?->name ?? '—' }}</dd>
                    <dt style="color:#78716c;">التاريخ</dt>
                    <dd style="font-weight:500;">{{ $event->event_date->format('d/m/Y') }}</dd>
                    @if($event->event_time)
                        <dt style="color:#78716c;">الوقت</dt>
                        <dd style="font-weight:500;">{{ $event->event_time }}</dd>
                    @endif
                    <dt style="color:#78716c;">القاعة</dt>
                    <dd style="font-weight:500;">{{ $event->venue_name }}</dd>
                    @if($event->venue_address)
                        <dt style="color:#78716c;">العنوان</dt>
                        <dd style="font-weight:500;">{{ $event->venue_address }}</dd>
                    @endif
                </dl>
            </div>

            @if($event->isPasswordProtected())
            <div class="card">
                <h3 style="font-weight:600; margin-bottom:.5rem;">🔒 حماية بكلمة مرور</h3>
                @if($event->password_hint)
                    <p style="font-size:.85rem; color:#78716c;">تلميح: {{ $event->password_hint }}</p>
                @endif
            </div>
            @endif
        </div>

    </div>

</div>
@push('scripts')
<script>
function previewPhotos(input) {
    const preview = document.getElementById('photoPreview');
    const btn     = document.getElementById('uploadBtn');
    preview.innerHTML = '';
    if (!input.files.length) { btn.style.display = 'none'; return; }

    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'aspect-ratio:1;border-radius:8px;overflow:hidden;background:#f5f5f4;';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });

    btn.style.display = 'inline-flex';
    btn.textContent   = `⬆️ رفع ${input.files.length} صورة`;
}
</script>
@endpush

@endsection
