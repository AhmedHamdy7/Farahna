<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->coupleName() }} – دعوة زفاف</title>

    <meta property="og:title"       content="{{ $event->coupleName() }}">
    <meta property="og:description" content="{{ $event->event_date->format('d F Y') }} · {{ $event->venue_name }}">
    <meta property="og:type"        content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=Tajawal:wght@300;400;500;700&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

        :root {
            --cream:   #fafaf8;
            --white:   #ffffff;
            --gold:    #a07832;
            --gold-l:  #c9a84c;
            --gold-xl: #e8d5a3;
            --charcoal:#2c2c2c;
            --muted:   #8a8680;
            --border:  rgba(160,120,50,.2);
            --border2: rgba(160,120,50,.12);
            --pb-accent:   #a07832;
            --pb-btn-text: #fff;
            --map-bg: #f8f5ef; --map-text: #1a1208; --map-accent: #a07832;
        }

        html { scroll-behavior:smooth; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            overflow-x: hidden;
        }

        .preview-spacer { height:60px; }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh;
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            text-align:center; padding:4rem 2rem;
            position:relative;
            background:var(--white);
            overflow:hidden;
        }
        .hero::before {
            content:'';
            position:absolute; inset:0;
            background:
                radial-gradient(ellipse at 50% 0%, rgba(160,120,50,.04) 0%, transparent 60%),
                radial-gradient(ellipse at 50% 100%, rgba(160,120,50,.03) 0%, transparent 60%);
            pointer-events:none;
        }
        .hero-ornament {
            color:var(--gold); font-size:1.4rem; letter-spacing:.5em;
            margin-bottom:2rem; opacity:.7;
            animation:fadeIn .8s .2s both;
        }
        .hero-label {
            font-size:.75rem; letter-spacing:.7em; text-transform:uppercase;
            color:var(--muted); margin-bottom:1.5rem;
            font-family:'Montserrat', sans-serif;
            animation:fadeIn .8s .4s both;
        }
        .hero-rule {
            width:120px; height:1px; background:var(--border);
            margin:0 auto 2.5rem;
            animation:fadeIn .8s .5s both;
        }
        .hero-monogram {
            width:110px; height:110px; border-radius:50%;
            border:1px solid var(--border);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 2.5rem;
            background:linear-gradient(135deg, rgba(160,120,50,.05), rgba(232,213,163,.1));
            animation:fadeIn .8s .6s both;
        }
        .hero-monogram-text {
            font-family:'Cormorant Garamond', serif;
            font-size:2.4rem; font-weight:600; color:var(--gold);
            letter-spacing:.05em; line-height:1;
        }
        .hero-names {
            font-family:'Cormorant Garamond', serif;
            font-size:clamp(2.4rem, 7vw, 4.2rem);
            font-weight:600;
            color:var(--charcoal);
            line-height:1.1; margin-bottom:.75rem;
            animation:fadeIn .8s .8s both;
        }
        .hero-ampersand {
            display:block;
            font-style:italic; font-size:.65em;
            color:var(--gold); margin:.2rem 0;
        }
        .hero-date-strip {
            display:inline-flex; align-items:center; gap:1.5rem;
            font-size:.8rem; letter-spacing:.25em; text-transform:uppercase;
            color:var(--muted); font-family:'Montserrat', sans-serif;
            margin-top:2rem; padding:1rem 2.5rem;
            border-top:1px solid var(--border2); border-bottom:1px solid var(--border2);
            animation:fadeIn .8s 1s both;
        }
        .hero-date-strip .dot { color:var(--gold-l); }

        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:none; } }

        /* ─── GOLD RULE ─── */
        .gold-rule {
            display:flex; align-items:center; gap:1.25rem;
            margin:2.5rem auto; max-width:320px;
        }
        .gold-rule::before, .gold-rule::after {
            content:''; flex:1; height:1px; background:var(--border);
        }
        .gold-rule span { color:var(--gold-l); font-size:1rem; }

        /* ─── SECTIONS ─── */
        section { padding:5rem 2rem; }
        .section-inner { max-width:880px; margin:0 auto; }
        .section-eyebrow {
            font-size:.7rem; letter-spacing:.6em; text-transform:uppercase;
            color:var(--gold); font-family:'Montserrat', sans-serif;
            display:block; margin-bottom:1rem;
        }
        .section-title {
            font-family:'Cormorant Garamond', serif;
            font-size:clamp(1.8rem, 4vw, 2.8rem);
            font-weight:600; color:var(--charcoal);
            margin-bottom:1rem; line-height:1.2;
        }
        .section-sub { color:var(--muted); line-height:1.9; font-size:.95rem; }
        section:nth-child(even) { background:var(--white); }

        /* ─── COUNTDOWN ─── */
        .countdown-wrap {
            display:grid; grid-template-columns:repeat(4,1fr);
            gap:.75rem; max-width:560px; margin:3rem auto 0;
        }
        .cd-cell {
            text-align:center; padding:1.75rem .5rem;
            border:1px solid var(--border2);
            border-radius:2px; background:var(--white);
            position:relative;
        }
        .cd-cell::after {
            content:'';
            position:absolute; bottom:0; left:15%; right:15%; height:1px;
            background:linear-gradient(90deg, transparent, var(--gold-l), transparent);
        }
        .cd-num {
            font-family:'Cormorant Garamond', serif;
            font-size:2.8rem; font-weight:600; color:var(--gold);
            display:block; line-height:1;
        }
        .cd-label { font-size:.65rem; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); margin-top:.4rem; display:block; }

        /* ─── DETAILS ─── */
        .details-list { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem; margin-top:2.5rem; }
        .detail-row {
            display:flex; gap:1.25rem; align-items:flex-start;
            padding:1.5rem; border:1px solid var(--border2);
            border-radius:2px; background:var(--cream);
            transition:border-color .3s;
        }
        .detail-row:hover { border-color:var(--gold); }
        .d-icon  { font-size:1.5rem; flex-shrink:0; }
        .d-label { font-size:.7rem; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); margin-bottom:.3rem; }
        .d-value { font-size:.95rem; color:var(--charcoal); font-weight:500; line-height:1.5; }
        .d-link  { color:var(--gold); text-decoration:none; font-size:.85rem; display:inline-block; margin-top:.35rem; }
        .d-link:hover { text-decoration:underline; }

        /* ─── GALLERY ─── */
        .gallery-carousel-wrap { display:flex; align-items:center; gap:.75rem; }
        .gallery-viewport { flex:1; overflow:hidden; border-radius:2px; }
        .gallery-track { display:flex; gap:.6rem; transition:transform .5s cubic-bezier(.4,0,.2,1); }
        .gallery-card { flex-shrink:0; overflow:hidden; cursor:pointer; border:1px solid var(--border2); }
        .gallery-card img { width:100%; aspect-ratio:1; object-fit:cover; display:block; transition:transform .4s; }
        .gallery-card:hover img { transform:scale(1.04); }
        .gallery-btn {
            flex-shrink:0; width:44px; height:44px; border-radius:50%;
            border:1px solid var(--border); background:var(--white);
            color:var(--gold); font-size:1rem; cursor:pointer; transition:all .2s;
            display:flex; align-items:center; justify-content:center;
        }
        .gallery-btn:hover { background:var(--gold); color:var(--white); border-color:var(--gold); }
        .gallery-btn:disabled { opacity:.3; pointer-events:none; }
        .gallery-dots { display:flex; justify-content:center; gap:.5rem; margin-top:1.25rem; }
        .gallery-dot { width:5px; height:5px; border-radius:50%; background:var(--border); cursor:pointer; transition:all .3s; }
        .gallery-dot.active { background:var(--gold); transform:scale(1.5); }

        /* ─── LIGHTBOX ─── */
        .lightbox { position:fixed; inset:0; background:rgba(0,0,0,.9); display:flex; align-items:center; justify-content:center; z-index:9999; opacity:0; pointer-events:none; transition:opacity .3s; }
        .lightbox.open { opacity:1; pointer-events:all; }
        .lightbox img { max-width:90vw; max-height:90vh; border-radius:2px; }
        .lb-btn { position:absolute; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.15); color:#fff; cursor:pointer; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-size:1rem; transition:all .2s; }
        .lb-btn:hover { background:rgba(255,255,255,.2); }
        .lb-close { top:1.5rem; right:1.5rem; }
        .lb-prev  { left:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-next  { right:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-counter { position:absolute; bottom:1.5rem; left:50%; transform:translateX(-50%); color:rgba(255,255,255,.5); font-size:.8rem; }

        /* ─── WISHES ─── */
        .wish-card { background:var(--cream); border:1px solid var(--border2); padding:1.5rem; margin-bottom:1rem; border-radius:2px; }
        .wish-card::before { display:none; }
        .wish-text  { font-size:.95rem; line-height:1.9; color:var(--charcoal); margin-bottom:.75rem; font-family:'Cormorant Garamond', serif; font-style:italic; font-size:1.05rem; }
        .wish-name  { font-size:.8rem; color:var(--gold); font-weight:600; }
        .wish-time  { font-size:.75rem; color:var(--muted); margin-inline-start:.75rem; }

        /* ─── FORMS ─── */
        .f-label { display:block; font-size:.72rem; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); margin-bottom:.4rem; }
        .f-input, .f-select, .f-textarea {
            width:100%; padding:.8rem 1rem;
            border:1px solid var(--border2); border-radius:2px;
            background:var(--white); font-family:inherit; font-size:.95rem;
            color:var(--charcoal); transition:border-color .2s;
            appearance:none; resize:vertical;
        }
        .f-input:focus, .f-select:focus, .f-textarea:focus { outline:none; border-color:var(--gold); }
        .f-error { color:#c0392b; font-size:.8rem; margin-top:.3rem; }
        .f-group { margin-bottom:1.1rem; }
        .f-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }

        /* ─── BUTTONS ─── */
        .btn-primary {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.85rem 2.5rem; background:var(--gold);
            color:var(--white); border:none; cursor:pointer;
            font-family:inherit; font-size:.9rem; font-weight:600;
            letter-spacing:.05em; transition:all .25s; border-radius:2px;
        }
        .btn-primary:hover { background:var(--gold-l); box-shadow:0 4px 20px rgba(160,120,50,.3); }
        .btn-outline {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.7rem 2rem; border:1px solid var(--border);
            color:var(--gold); background:transparent; cursor:pointer;
            font-family:inherit; font-size:.875rem; transition:all .25s; border-radius:2px;
        }
        .btn-outline:hover { background:var(--gold); color:var(--white); border-color:var(--gold); }

        /* ─── FOOTER ─── */
        footer { background:var(--charcoal); color:rgba(255,255,255,.5); text-align:center; padding:4rem 2rem; }
        footer .footer-names { font-family:'Cormorant Garamond', serif; font-size:1.8rem; font-weight:600; color:var(--gold-xl); margin-bottom:.75rem; display:block; }
        footer .footer-date  { font-size:.75rem; letter-spacing:.3em; text-transform:uppercase; }

        @media (max-width:640px) {
            .countdown-wrap { grid-template-columns:repeat(2,1fr); }
            .f-grid2 { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ─── HERO ─── --}}
<section class="hero" id="hero">
    <p class="hero-ornament">— ✦ —</p>
    <p class="hero-label">دعوة زفاف</p>
    <div class="hero-rule"></div>

    @php
        $initials = mb_substr($event->groom_name, 0, 1) . ' & ' . mb_substr($event->bride_name ?? '', 0, 1);
    @endphp
    <div class="hero-monogram">
        <span class="hero-monogram-text">{{ $initials }}</span>
    </div>

    <h1 class="hero-names">
        {{ $event->groom_name }}
        <span class="hero-ampersand">&</span>
        {{ $event->bride_name }}
    </h1>

    <div class="hero-date-strip">
        <span>{{ $event->event_date->translatedFormat('d F') }}</span>
        <span class="dot">◆</span>
        <span>{{ $event->event_date->format('Y') }}</span>
        @if($event->venue_name)
            <span class="dot">◆</span>
            <span>{{ $event->venue_name }}</span>
        @endif
    </div>
</section>

{{-- ─── Countdown ─── --}}
<section id="countdown" style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">العد التنازلي</span>
        <h2 class="section-title">الوقت المتبقي</h2>
        <div class="gold-rule"><span>◆</span></div>

        <div class="countdown-wrap">
            <div class="cd-cell"><span class="cd-num" id="cd-days">00</span><span class="cd-label">يوم</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-hours">00</span><span class="cd-label">ساعة</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-mins">00</span><span class="cd-label">دقيقة</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-secs">00</span><span class="cd-label">ثانية</span></div>
        </div>
    </div>
</section>

{{-- ─── Details ─── --}}
<section id="details">
    <div class="section-inner" style="text-align:center;">
        <span class="section-eyebrow">تفاصيل الحفل</span>
        <h2 class="section-title">معلومات المناسبة</h2>
        <div class="gold-rule"><span>◆</span></div>

        <div class="details-list">
            <div class="detail-row">
                <span class="d-icon">📅</span>
                <div>
                    <p class="d-label">التاريخ</p>
                    <p class="d-value">{{ $event->event_date->translatedFormat('l، d F Y') }}</p>
                </div>
            </div>

            @if($event->event_time)
            <div class="detail-row">
                <span class="d-icon">⏰</span>
                <div>
                    <p class="d-label">الوقت</p>
                    <p class="d-value">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</p>
                </div>
            </div>
            @endif

            <div class="detail-row">
                <span class="d-icon">📍</span>
                <div>
                    <p class="d-label">المكان</p>
                    <p class="d-value">{{ $event->venue_name }}</p>
                    @if($event->venue_address)
                        <p style="font-size:.85rem; color:var(--muted); margin-top:.25rem;">{{ $event->venue_address }}</p>
                    @endif
                    @if($event->venue_map_link)
                        <a href="{{ $event->venue_map_link }}" target="_blank" class="d-link">🗺 اعرض على الخريطة ←</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Gallery ─── --}}
@if($event->gallery->isNotEmpty())
<section id="gallery">
    <div class="section-inner" style="text-align:center;">
        <span class="section-eyebrow">الصور</span>
        <h2 class="section-title">معرض الصور</h2>
        <div class="gold-rule"><span>◆</span></div>

        <div class="gallery-carousel-wrap">
            <button class="gallery-btn" id="gPrev" onclick="gShift(-1)">←</button>
            <div class="gallery-viewport">
                <div class="gallery-track" id="gTrack">
                    @foreach($event->gallery as $i => $photo)
                        <div class="gallery-card" onclick="lbOpen({{ $i }})">
                            <img src="{{ Storage::url($photo->image_path) }}" alt="صورة {{ $i+1 }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="gallery-btn" id="gNext" onclick="gShift(1)">→</button>
        </div>
        <div class="gallery-dots" id="gDots"></div>
    </div>
</section>
@endif

@include('partials.venue-map')
{{-- ─── Wishes / Guestbook ─── --}}
<section id="wishes">
    <div class="section-inner" style="text-align:center;">
        <span class="section-eyebrow">التهاني</span>
        <h2 class="section-title">كتاب الضيوف</h2>
        <div class="gold-rule"><span>◆</span></div>

        @if($event->approvedWishes->isNotEmpty())
            <div style="margin-bottom:2.5rem; text-align:right; max-width:640px; margin-left:auto; margin-right:auto;">
                @foreach($event->approvedWishes as $wish)
                    <div class="wish-card">
                        <p class="wish-text">{{ $wish->message }}</p>
                        <div style="display:flex; align-items:center;">
                            <span class="wish-time">{{ $wish->created_at->diffForHumans() }}</span>
                            <span class="wish-name">— {{ $wish->guest_name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color:var(--muted); margin-bottom:2rem; font-size:.95rem;">كن أول من يكتب تهنئته ✍️</p>
        @endif

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.wishes', $event) }}" method="POST"
              style="max-width:560px; margin:0 auto; text-align:right;">
            @csrf
            @if(session('wish_success'))
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; padding:1rem; border-radius:2px; margin-bottom:1rem; font-size:.875rem;">
                    ✓ شكراً على تهنئتك! ستظهر بعد المراجعة.
                </div>
            @endif
            <div class="f-group">
                <label class="f-label">اسمك</label>
                <input type="text" name="guest_name" class="f-input" value="{{ old('guest_name') }}" required placeholder="أدخل اسمك">
                @error('guest_name') <p class="f-error">{{ $message }}</p> @enderror
            </div>
            <div class="f-group">
                <label class="f-label">رسالتك</label>
                <textarea name="message" class="f-textarea" rows="4" required placeholder="اكتب تهنئتك هنا...">{{ old('message') }}</textarea>
                @error('message') <p class="f-error">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">💌 أرسل التهنئة</button>
        </form>
        @endif
    </div>
</section>

{{-- ─── RSVP ─── --}}
<section id="rsvp">
    <div class="section-inner" style="text-align:center;">
        <span class="section-eyebrow">تأكيد الحضور</span>
        <h2 class="section-title">هل ستحضر؟</h2>
        <div class="gold-rule"><span>◆</span></div>

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.rsvp', $event) }}" method="POST"
              style="max-width:560px; margin:0 auto; text-align:right;">
            @csrf
            @if(session('rsvp_success'))
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; padding:1rem; border-radius:2px; margin-bottom:1rem; font-size:.875rem;">
                    ✓ تم تسجيل ردك بنجاح، شكراً!
                </div>
            @endif
            <div class="f-grid2">
                <div class="f-group">
                    <label class="f-label">الاسم</label>
                    <input type="text" name="guest_name" class="f-input" value="{{ old('guest_name') }}" required placeholder="اسمك الكريم">
                    @error('guest_name') <p class="f-error">{{ $message }}</p> @enderror
                </div>
                <div class="f-group">
                    <label class="f-label">رقم الهاتف</label>
                    <input type="tel" name="phone" class="f-input" value="{{ old('phone') }}" placeholder="اختياري">
                </div>
            </div>
            <div class="f-grid2">
                <div class="f-group">
                    <label class="f-label">الحضور</label>
                    <select name="attending" class="f-select">
                        <option value="yes"   {{ old('attending')=='yes'   ? 'selected':'' }}>✅ سأحضر</option>
                        <option value="no"    {{ old('attending')=='no'    ? 'selected':'' }}>❌ لن أتمكن</option>
                        <option value="maybe" {{ old('attending')=='maybe' ? 'selected':'' }}>🤔 ربما</option>
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">عدد المرافقين</label>
                    <input type="number" name="guests_count" class="f-input" value="{{ old('guests_count', 1) }}" min="1" max="20">
                </div>

                <div class="form-group">
                    <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;">✓ تأكيد الحضور</button>
        </form>
        @else
            <p style="color:var(--muted); font-size:.9rem;">نموذج الحضور معطّل في وضع المعاينة.</p>
        @endif
    </div>
</section>

{{-- ─── Footer ─── --}}
<footer>
    <span class="footer-names">{{ $event->groom_name }} & {{ $event->bride_name }}</span>
    <div class="gold-rule" style="margin:1.25rem auto;"><span>◆</span></div>
    <p class="footer-date">{{ $event->event_date->translatedFormat('d F Y') }}</p>
    @if($event->venue_name)
        <p style="margin-top:.5rem; font-size:.75rem; opacity:.4;">{{ $event->venue_name }}</p>
    @endif
    <p style="margin-top:2rem; font-size:.7rem; opacity:.25;">Powered by Farahna</p>
</footer>

{{-- ─── Lightbox ─── --}}
<div class="lightbox" id="lb">
    <button class="lb-btn lb-close" onclick="document.getElementById('lb').classList.remove('open');document.body.style.overflow=''">✕</button>
    <button class="lb-btn lb-prev" onclick="lbNav(-1)">←</button>
    <img id="lbImg" src="" alt="">
    <button class="lb-btn lb-next" onclick="lbNav(1)">→</button>
    <span class="lb-counter"><span id="lbCur">1</span> / <span id="lbTotal">1</span></span>
</div>

<script>
// ─── Countdown ───
(function(){
    var target = new Date('{{ $event->event_date->format("Y-m-d") }}T{{ $event->event_time ?? "20:00:00" }}');
    function tick(){
        var diff = target - new Date();
        if(diff <= 0) return;
        var d = Math.floor(diff/86400000);
        var h = Math.floor(diff/3600000%24);
        var m = Math.floor(diff/60000%60);
        var s = Math.floor(diff/1000%60);
        function fmt(n){ return String(n).padStart(2,'0'); }
        document.getElementById('cd-days').textContent  = fmt(d);
        document.getElementById('cd-hours').textContent = fmt(h);
        document.getElementById('cd-mins').textContent  = fmt(m);
        document.getElementById('cd-secs').textContent  = fmt(s);
    }
    tick(); setInterval(tick, 1000);
})();

// ─── Gallery Carousel ───
(function(){
    var track = document.getElementById('gTrack');
    if(!track) return;
    var dotsEl = document.getElementById('gDots');
    var GAP=10, page=0, perPg=4, cardW=0, timer=null;
    var cards = track.querySelectorAll('.gallery-card');
    var total = cards.length;
    window._lbImgs = Array.from(cards).map(function(c){ return c.querySelector('img').src; });
    window._lbIdx  = 0;
    document.getElementById('lbTotal').textContent = total;
    function maxPage(){ return Math.max(0, total - perPg); }
    function render(){
        track.style.transform = 'translateX(-'+(page*(cardW+GAP))+'px)';
        var btnP=document.getElementById('gPrev'), btnN=document.getElementById('gNext');
        if(btnP) btnP.disabled=(page===0);
        if(btnN) btnN.disabled=(page>=maxPage());
        if(!dotsEl) return;
        var pages=Math.ceil(total/perPg); dotsEl.innerHTML='';
        for(var p=0;p<pages;p++){
            var d=document.createElement('span');
            d.className='gallery-dot'+(p===Math.floor(page/perPg)?' active':'');
            (function(t){d.onclick=function(){go(t*perPg);};})(p);
            dotsEl.appendChild(d);
        }
    }
    function go(p){ page=Math.max(0,Math.min(p,maxPage())); render(); clearInterval(timer); timer=setInterval(autoNext,3200); }
    function autoNext(){ page=(page>=maxPage())?0:page+1; render(); }
    function setup(){
        var vw=track.parentElement.offsetWidth;
        perPg=vw<420?2:vw<640?3:4;
        cardW=(vw-GAP*(perPg-1))/perPg;
        cards.forEach(function(c){ c.style.width=cardW+'px'; });
        page=Math.min(page,maxPage()); render();
    }
    window.gShift=function(dir){ go(page+dir); };
    setup();
    if(total>perPg) timer=setInterval(autoNext,3200);
    window.addEventListener('resize',setup);
    var sx=0;
    track.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;},{passive:true});
    track.addEventListener('touchend',function(e){var dx=e.changedTouches[0].clientX-sx; if(Math.abs(dx)>40) window.gShift(dx<0?1:-1);});
})();

// ─── Lightbox ───
function lbOpen(i){
    if(!window._lbImgs||!window._lbImgs.length) return;
    window._lbIdx=i;
    document.getElementById('lbImg').src=window._lbImgs[i];
    document.getElementById('lbCur').textContent=i+1;
    document.getElementById('lb').classList.add('open');
    document.body.style.overflow='hidden';
}
function lbNav(dir){
    if(!window._lbImgs) return;
    window._lbIdx=(window._lbIdx+dir+window._lbImgs.length)%window._lbImgs.length;
    document.getElementById('lbImg').src=window._lbImgs[window._lbIdx];
    document.getElementById('lbCur').textContent=window._lbIdx+1;
}
document.getElementById('lb').addEventListener('click',function(e){
    if(e.target===this){ this.classList.remove('open'); document.body.style.overflow=''; }
});
</script>

@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
