<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->groom_name }} – عيد ميلاد سعيد</title>

    <meta property="og:title"       content="{{ $event->groom_name }} – عيد ميلاد سعيد">
    <meta property="og:description" content="{{ $event->event_date->format('d F Y') }} · {{ $event->venue_name }}">
    <meta property="og:type"        content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Tajawal:wght@300;400;500;700&family=Cormorant+Garamond:ital,wght@0,400;1,400&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

        :root {
            --bg:         #0a0a0a;
            --bg2:        #111111;
            --bg3:        #161616;
            --gold:       #c9a227;
            --gold-light: #f0d060;
            --gold-dim:   #7a6115;
            --text:       #f0ece4;
            --muted:      #8a8070;
            --border:     rgba(201,162,39,.25);
            --pb-accent:   #c9a227;
            --pb-btn-text: #0a0a0a;
            --map-bg: #0e0a00; --map-text: #f0d060; --map-accent: #c9a227;
        }

        html { scroll-behavior:smooth; }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ─── PREVIEW SPACER ─── */
        .preview-spacer { height:60px; }

        /* ─── SPARKLES ─── */
        .sparkles {
            position:absolute; inset:0;
            pointer-events:none; overflow:hidden; z-index:0;
        }
        .sparkle {
            position:absolute;
            width:3px; height:3px;
            border-radius:50%;
            background:var(--gold-light);
            animation: sparkle-float var(--dur, 6s) var(--delay, 0s) infinite ease-in-out;
            opacity:0;
        }
        @keyframes sparkle-float {
            0%   { opacity:0; transform:translateY(0) scale(0); }
            15%  { opacity:1; transform:translateY(-20px) scale(1); }
            85%  { opacity:.6; transform:translateY(-80px) scale(.8); }
            100% { opacity:0; transform:translateY(-120px) scale(0); }
        }
        .star {
            position:absolute;
            color:var(--gold);
            animation: star-twinkle var(--dur,3s) var(--delay,0s) infinite;
            font-size:var(--size, 14px);
            opacity:0;
        }
        @keyframes star-twinkle {
            0%,100% { opacity:0; transform:scale(0) rotate(0deg); }
            50%      { opacity:1; transform:scale(1) rotate(180deg); }
        }

        /* ─── PROGRESS BAR ─── */
        .progress-bar {
            position:fixed; top:0; left:0; right:0; height:3px; z-index:1000;
            background:rgba(255,255,255,.05);
        }
        .progress-fill {
            height:100%;
            background:linear-gradient(90deg, var(--gold-dim), var(--gold), var(--gold-light), var(--gold));
            background-size:200%;
            animation:progress-shimmer 2s linear infinite;
            width:0;
            transition:width .2s;
        }
        @keyframes progress-shimmer {
            0%   { background-position:100% 0; }
            100% { background-position:-100% 0; }
        }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh;
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            text-align:center; padding:3rem 2rem;
            position:relative;
            background:radial-gradient(ellipse at 50% 0%, #1a1500 0%, var(--bg) 70%);
            overflow:hidden;
        }
        .hero::after {
            content:'';
            position:absolute; inset:0;
            background:
                radial-gradient(circle at 20% 80%, rgba(201,162,39,.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(201,162,39,.05) 0%, transparent 50%);
            pointer-events:none;
        }
        .hero-label {
            font-family:'Cinzel', serif;
            font-size:.85rem; letter-spacing:.5em;
            color:var(--gold); text-transform:uppercase;
            margin-bottom:2rem;
            opacity:0; animation:fadeInDown .8s .3s forwards;
        }
        .hero-ring {
            width:220px; height:220px; border-radius:50%;
            border:1px solid var(--border);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 2rem;
            position:relative;
            box-shadow:0 0 60px rgba(201,162,39,.15), inset 0 0 40px rgba(201,162,39,.05);
            animation:ring-pulse 3s ease-in-out infinite;
            opacity:0; animation:fadeIn .8s .5s forwards, ring-pulse 3s 1.3s ease-in-out infinite;
        }
        @keyframes ring-pulse {
            0%,100% { box-shadow:0 0 40px rgba(201,162,39,.1), inset 0 0 30px rgba(201,162,39,.04); }
            50%      { box-shadow:0 0 80px rgba(201,162,39,.25), inset 0 0 50px rgba(201,162,39,.08); }
        }
        .hero-age {
            font-family:'Cinzel', serif;
            font-size:5rem; font-weight:700;
            color:var(--gold);
            line-height:1;
            text-shadow:0 0 40px rgba(201,162,39,.5);
        }
        .hero-name {
            font-family:'Cinzel', serif;
            font-size:clamp(2.2rem, 6vw, 3.8rem);
            font-weight:700;
            background:linear-gradient(135deg, var(--gold-dim), var(--gold), var(--gold-light), var(--gold));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text;
            line-height:1.2; margin-bottom:1.5rem;
            opacity:0; animation:fadeIn .8s .7s forwards;
        }
        .hero-subtitle {
            font-size:1.1rem; color:var(--muted); letter-spacing:.1em;
            margin-bottom:3rem;
            opacity:0; animation:fadeInUp .8s .9s forwards;
        }
        .hero-date {
            font-family:'Cinzel', serif;
            font-size:.95rem; letter-spacing:.3em;
            color:var(--gold); text-transform:uppercase;
            padding:.6rem 2rem;
            border:1px solid var(--border);
            border-radius:2px;
            opacity:0; animation:fadeInUp .8s 1.1s forwards;
        }
        @keyframes fadeIn     { to { opacity:1; } }
        @keyframes fadeInDown { from { opacity:0; transform:translateY(-15px); } to { opacity:1; transform:none; } }
        @keyframes fadeInUp   { from { opacity:0; transform:translateY(15px);  } to { opacity:1; transform:none; } }

        /* ─── GOLD DIVIDER ─── */
        .gold-divider {
            display:flex; align-items:center; gap:1rem;
            margin:1.5rem auto; max-width:300px;
        }
        .gold-divider::before, .gold-divider::after {
            content:''; flex:1; height:1px; background:var(--border);
        }
        .gold-divider span { color:var(--gold); font-size:1.2rem; }

        /* ─── SECTIONS ─── */
        section {
            padding:5rem 2rem;
            position:relative;
        }
        .section-inner {
            max-width:860px; margin:0 auto;
        }
        .section-badge {
            display:inline-block;
            font-family:'Cinzel', serif;
            font-size:.7rem; letter-spacing:.5em; text-transform:uppercase;
            color:var(--gold); border:1px solid var(--border);
            padding:.35rem 1.2rem; border-radius:2px;
            margin-bottom:1.5rem;
        }
        .section-title {
            font-family:'Cinzel', serif;
            font-size:clamp(1.6rem, 4vw, 2.4rem);
            font-weight:600; color:var(--text);
            margin-bottom:1rem; line-height:1.3;
        }
        .section-sub {
            color:var(--muted); font-size:1rem; margin-bottom:3rem;
            line-height:1.8;
        }
        section:nth-child(even) { background:var(--bg2); }

        /* ─── COUNTDOWN ─── */
        .countdown-grid {
            display:grid;
            grid-template-columns:repeat(4, 1fr);
            gap:1rem; max-width:600px; margin:0 auto;
        }
        .countdown-card {
            background:var(--bg3);
            border:1px solid var(--border);
            border-radius:6px; padding:1.5rem .75rem;
            text-align:center;
            position:relative; overflow:hidden;
        }
        .countdown-card::before {
            content:'';
            position:absolute; top:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .countdown-num {
            font-family:'Cinzel', serif;
            font-size:2.4rem; font-weight:700;
            color:var(--gold);
            display:block; line-height:1;
            text-shadow:0 0 20px rgba(201,162,39,.3);
        }
        .countdown-label {
            font-size:.7rem; letter-spacing:.15em; color:var(--muted);
            text-transform:uppercase; margin-top:.4rem; display:block;
        }

        /* ─── DETAILS ─── */
        .details-grid {
            display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr));
            gap:1.5rem;
        }
        .detail-card {
            background:var(--bg3);
            border:1px solid var(--border);
            border-radius:8px; padding:1.75rem 1.5rem;
            display:flex; gap:1.25rem; align-items:flex-start;
            transition:border-color .3s, box-shadow .3s;
        }
        .detail-card:hover {
            border-color:var(--gold);
            box-shadow:0 0 20px rgba(201,162,39,.1);
        }
        .detail-icon {
            font-size:1.75rem; flex-shrink:0;
            filter:sepia(1) saturate(3) hue-rotate(5deg);
        }
        .detail-label { font-size:.75rem; color:var(--muted); letter-spacing:.1em; text-transform:uppercase; margin-bottom:.25rem; }
        .detail-value { font-size:1rem; color:var(--text); font-weight:500; line-height:1.5; }
        .detail-link  { color:var(--gold); text-decoration:none; font-size:.85rem; display:inline-block; margin-top:.4rem; }
        .detail-link:hover { text-decoration:underline; }

        /* ─── GALLERY ─── */
        .gallery-carousel-wrap {
            display:flex; align-items:center; gap:.75rem;
        }
        .gallery-viewport {
            flex:1; overflow:hidden; border-radius:8px;
        }
        .gallery-track {
            display:flex; gap:.6rem;
            transition:transform .5s cubic-bezier(.4,0,.2,1);
        }
        .gallery-card {
            flex-shrink:0; border-radius:6px; overflow:hidden;
            cursor:pointer; position:relative;
            border:1px solid var(--border);
        }
        .gallery-card img {
            width:100%; aspect-ratio:1; object-fit:cover;
            display:block; transition:transform .4s ease;
        }
        .gallery-card:hover img { transform:scale(1.05); }
        .gallery-btn {
            flex-shrink:0; width:44px; height:44px; border-radius:50%;
            border:1px solid var(--border);
            background:var(--bg3);
            color:var(--gold); font-size:1.1rem;
            cursor:pointer; transition:all .2s;
            display:flex; align-items:center; justify-content:center;
        }
        .gallery-btn:hover { background:var(--gold); color:var(--bg); border-color:var(--gold); }
        .gallery-btn:disabled { pointer-events:none; opacity:.3; }
        .gallery-dots {
            display:flex; justify-content:center; gap:.5rem; margin-top:1.25rem;
        }
        .gallery-dot {
            width:6px; height:6px; border-radius:50%;
            background:var(--border); cursor:pointer;
            transition:all .3s;
        }
        .gallery-dot.active { background:var(--gold); transform:scale(1.4); }

        /* ─── LIGHTBOX ─── */
        .lightbox {
            position:fixed; inset:0; background:rgba(0,0,0,.95);
            display:flex; align-items:center; justify-content:center;
            z-index:9999; opacity:0; pointer-events:none;
            transition:opacity .3s;
        }
        .lightbox.open { opacity:1; pointer-events:all; }
        .lightbox img { max-width:90vw; max-height:90vh; border-radius:6px; border:1px solid var(--border); }
        .lb-close, .lb-prev, .lb-next {
            position:absolute; background:transparent; border:1px solid var(--border);
            color:var(--gold); cursor:pointer; border-radius:50%;
            width:44px; height:44px; display:flex; align-items:center; justify-content:center;
            font-size:1.1rem; transition:all .2s;
        }
        .lb-close:hover, .lb-prev:hover, .lb-next:hover { background:var(--gold); color:var(--bg); }
        .lb-close { top:1.5rem; right:1.5rem; }
        .lb-prev  { left:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-next  { right:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-counter { position:absolute; bottom:1.5rem; left:50%; transform:translateX(-50%); color:var(--muted); font-size:.85rem; }

        /* ─── WISHES / GUESTBOOK ─── */
        .wish-item {
            background:var(--bg3);
            border:1px solid var(--border);
            border-radius:8px; padding:1.5rem;
            margin-bottom:1rem;
            position:relative;
        }
        .wish-item::before {
            content:'"';
            position:absolute; top:.75rem; right:1.25rem;
            font-family:'Cinzel', serif; font-size:3rem;
            color:var(--gold-dim); line-height:1; opacity:.4;
        }
        .wish-text  { font-size:1rem; line-height:1.8; color:var(--text); margin-bottom:.75rem; }
        .wish-name  { font-size:.8rem; color:var(--gold); font-weight:600; }
        .wish-time  { font-size:.75rem; color:var(--muted); margin-right:.75rem; }
        .wishes-form textarea, .wishes-form input[type="text"] {
            width:100%; padding:.85rem 1rem;
            background:var(--bg3); border:1px solid var(--border);
            border-radius:6px; color:var(--text); font-family:inherit; font-size:.95rem;
            transition:border-color .2s;
            resize:vertical;
        }
        .wishes-form textarea:focus, .wishes-form input:focus {
            outline:none; border-color:var(--gold);
        }

        /* ─── RSVP ─── */
        .rsvp-form input, .rsvp-form select {
            width:100%; padding:.85rem 1rem;
            background:var(--bg3); border:1px solid var(--border);
            border-radius:6px; color:var(--text); font-family:inherit; font-size:.95rem;
            transition:border-color .2s; appearance:none;
        }
        .rsvp-form input:focus, .rsvp-form select:focus {
            outline:none; border-color:var(--gold);
        }
        .rsvp-form select option { background:var(--bg2); }
        .rsvp-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }

        /* ─── BUTTON ─── */
        .btn-gold {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.85rem 2.5rem; border-radius:4px;
            background:linear-gradient(135deg, var(--gold-dim), var(--gold));
            color:var(--bg); font-weight:700; font-size:.95rem;
            border:none; cursor:pointer; transition:all .25s;
            font-family:inherit; letter-spacing:.05em;
        }
        .btn-gold:hover {
            background:linear-gradient(135deg, var(--gold), var(--gold-light));
            box-shadow:0 0 30px rgba(201,162,39,.4);
        }
        .btn-outline-gold {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.7rem 2rem; border-radius:4px;
            border:1px solid var(--border); color:var(--gold);
            background:transparent; font-weight:600;
            cursor:pointer; transition:all .25s; font-family:inherit;
        }
        .btn-outline-gold:hover { border-color:var(--gold); background:rgba(201,162,39,.08); }

        .form-label-g { display:block; font-size:.8rem; letter-spacing:.1em; color:var(--muted); text-transform:uppercase; margin-bottom:.4rem; }
        .form-error-g { color:#ff6b6b; font-size:.8rem; margin-top:.3rem; }
        .form-group-g { margin-bottom:1rem; }

        /* ─── FOOTER ─── */
        footer {
            background:var(--bg);
            border-top:1px solid var(--border);
            text-align:center; padding:3rem 2rem;
            color:var(--muted); font-size:.875rem;
        }
        footer .footer-name {
            font-family:'Cinzel', serif; font-size:1.4rem;
            color:var(--gold); margin-bottom:.75rem;
            display:block;
        }

        @media (max-width:640px) {
            .countdown-grid { grid-template-columns:repeat(2,1fr); }
            .rsvp-grid { grid-template-columns:1fr; }
            .hero-age { font-size:4rem; }
        }
    </style>
</head>
<body>

{{-- ─── Progress Bar ─── --}}
<div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ─── Hero Section ─── --}}
<section class="hero" id="hero">
    <div class="sparkles" id="sparklesContainer"></div>

    <p class="hero-label">دعوة عيد ميلاد</p>

    <div class="hero-ring">
        <span class="hero-age">🎂</span>
    </div>

    <h1 class="hero-name">{{ $event->groom_name }}</h1>

    <p class="hero-subtitle">يحتفل بعيد ميلاده / ها</p>

    <span class="hero-date">
        {{ $event->event_date->translatedFormat('d / m / Y') }}
        @if($event->event_time)
            &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
        @endif
    </span>
</section>

{{-- ─── Countdown Section ─── --}}
<section id="countdown" style="background:var(--bg2); text-align:center;">
    <div class="section-inner">
        <span class="section-badge">العد التنازلي</span>
        <h2 class="section-title">متبقي على الاحتفال</h2>

        <div class="countdown-grid" id="countdown">
            <div class="countdown-card">
                <span class="countdown-num" id="cd-days">00</span>
                <span class="countdown-label">يوم</span>
            </div>
            <div class="countdown-card">
                <span class="countdown-num" id="cd-hours">00</span>
                <span class="countdown-label">ساعة</span>
            </div>
            <div class="countdown-card">
                <span class="countdown-num" id="cd-mins">00</span>
                <span class="countdown-label">دقيقة</span>
            </div>
            <div class="countdown-card">
                <span class="countdown-num" id="cd-secs">00</span>
                <span class="countdown-label">ثانية</span>
            </div>
        </div>
    </div>
</section>

{{-- ─── Details Section ─── --}}
<section id="details">
    <div class="section-inner" style="text-align:center;">
        <span class="section-badge">تفاصيل الحفل</span>
        <h2 class="section-title">معلومات المناسبة</h2>
        <div class="gold-divider"><span>✦</span></div>

        <div class="details-grid">
            <div class="detail-card">
                <span class="detail-icon">📅</span>
                <div>
                    <p class="detail-label">التاريخ</p>
                    <p class="detail-value">{{ $event->event_date->translatedFormat('l، d F Y') }}</p>
                </div>
            </div>

            @if($event->event_time)
            <div class="detail-card">
                <span class="detail-icon">⏰</span>
                <div>
                    <p class="detail-label">الوقت</p>
                    <p class="detail-value">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</p>
                </div>
            </div>
            @endif

            <div class="detail-card">
                <span class="detail-icon">📍</span>
                <div>
                    <p class="detail-label">المكان</p>
                    <p class="detail-value">{{ $event->venue_name }}</p>
                    @if($event->venue_address)
                        <p style="font-size:.85rem; color:var(--muted); margin-top:.25rem;">{{ $event->venue_address }}</p>
                    @endif
                    @if($event->venue_map_link)
                        <a href="{{ $event->venue_map_link }}" target="_blank" class="detail-link">🗺 اعرض على الخريطة ←</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Gallery Section ─── --}}
@if($event->gallery->isNotEmpty())
<section id="gallery" style="background:var(--bg2);">
    <div class="section-inner" style="text-align:center;">
        <span class="section-badge">الصور</span>
        <h2 class="section-title">معرض الصور</h2>
        <div class="gold-divider"><span>✦</span></div>

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
{{-- ─── Guestbook / Wishes ─── --}}
<section id="wishes">
    <div class="section-inner" style="text-align:center;">
        <span class="section-badge">كتاب التهاني</span>
        <h2 class="section-title">اكتب تهنئتك</h2>
        <div class="gold-divider"><span>✦</span></div>

        @if($event->approvedWishes->isNotEmpty())
            <div style="margin-bottom:2.5rem; text-align:right;">
                @foreach($event->approvedWishes as $wish)
                    <div class="wish-item">
                        <p class="wish-text">{{ $wish->message }}</p>
                        <div style="display:flex; align-items:center;">
                            <span class="wish-time">{{ $wish->created_at->diffForHumans() }}</span>
                            <span class="wish-name">— {{ $wish->guest_name }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.wishes', $event) }}" method="POST"
              style="max-width:560px; margin:0 auto; text-align:right;"
              class="wishes-form">
            @csrf
            @if(session('wish_success'))
                <div style="background:rgba(201,162,39,.15); border:1px solid var(--border); color:var(--gold); padding:1rem; border-radius:6px; margin-bottom:1rem;">
                    🎂 شكراً على تهنئتك! ستظهر بعد المراجعة.
                </div>
            @endif
            <div class="form-group-g">
                <label class="form-label-g">اسمك</label>
                <input type="text" name="guest_name" value="{{ old('guest_name') }}" required placeholder="أدخل اسمك">
                @error('guest_name') <p class="form-error-g">{{ $message }}</p> @enderror
            </div>
            <div class="form-group-g">
                <label class="form-label-g">رسالتك</label>
                <textarea name="message" rows="4" required placeholder="اكتب تهنئتك هنا...">{{ old('message') }}</textarea>
                @error('message') <p class="form-error-g">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-gold" style="width:100%;">✨ أرسل التهنئة</button>
        </form>
        @endif
    </div>
</section>

{{-- ─── RSVP Section ─── --}}
<section id="rsvp" style="background:var(--bg2);">
    <div class="section-inner" style="text-align:center;">
        <span class="section-badge">تأكيد الحضور</span>
        <h2 class="section-title">هل ستحضر؟</h2>
        <div class="gold-divider"><span>✦</span></div>

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.rsvp', $event) }}" method="POST"
              style="max-width:560px; margin:0 auto; text-align:right;"
              class="rsvp-form">
            @csrf
            @if(session('rsvp_success'))
                <div style="background:rgba(201,162,39,.15); border:1px solid var(--border); color:var(--gold); padding:1rem; border-radius:6px; margin-bottom:1rem;">
                    🎉 تم تسجيل ردك بنجاح، شكراً!
                </div>
            @endif
            <div class="rsvp-grid">
                <div class="form-group-g">
                    <label class="form-label-g">الاسم</label>
                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" required placeholder="اسمك الكريم">
                    @error('guest_name') <p class="form-error-g">{{ $message }}</p> @enderror
                </div>
                <div class="form-group-g">
                    <label class="form-label-g">رقم الهاتف</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="اختياري">
                </div>
            </div>
            <div class="rsvp-grid">
                <div class="form-group-g">
                    <label class="form-label-g">الحضور</label>
                    <select name="attending">
                        <option value="yes" {{ old('attending')=='yes'?'selected':'' }}>✅ سأحضر</option>
                        <option value="no"  {{ old('attending')=='no'?'selected':'' }}>❌ لن أتمكن</option>
                        <option value="maybe" {{ old('attending')=='maybe'?'selected':'' }}>🤔 ربما</option>
                    </select>
                </div>
                <div class="form-group-g">
                    <label class="form-label-g">عدد المرافقين</label>
                    <input type="number" name="guests_count" value="{{ old('guests_count', 1) }}" min="1" max="20">
                </div>

                <div class="form-group">
                    <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn-gold" style="width:100%;">🎊 تأكيد الحضور</button>
        </form>
        @else
            <p style="color:var(--muted); font-size:.9rem;">نموذج الحضور معطّل في وضع المعاينة.</p>
        @endif
    </div>
</section>

{{-- ─── Footer ─── --}}
<footer>
    <span class="footer-name">{{ $event->groom_name }}</span>
    <div class="gold-divider" style="margin:1rem auto;"><span>✦</span></div>
    <p>{{ $event->event_date->translatedFormat('d F Y') }}</p>
    @if($event->venue_name)
        <p style="margin-top:.4rem;">{{ $event->venue_name }}</p>
    @endif
    <p style="margin-top:1.5rem; font-size:.75rem; opacity:.4;">Powered by Farahna</p>
</footer>

{{-- ─── Lightbox ─── --}}
<div class="lightbox" id="lb">
    <button class="lb-close" onclick="document.getElementById('lb').classList.remove('open'); document.body.style.overflow=''">✕</button>
    <button class="lb-prev" onclick="lbNav(-1)">←</button>
    <img id="lbImg" src="" alt="">
    <button class="lb-next" onclick="lbNav(1)">→</button>
    <span class="lb-counter"><span id="lbCur">1</span> / <span id="lbTotal">1</span></span>
</div>

<script>
// ─── Progress bar ───
(function(){
    var fill = document.getElementById('progressFill');
    if(!fill) return;
    function update(){
        var h = document.documentElement;
        var pct = h.scrollTop / (h.scrollHeight - h.clientHeight) * 100;
        fill.style.width = Math.min(100, pct) + '%';
    }
    window.addEventListener('scroll', update, {passive:true});
})();

// ─── Sparkles ───
(function(){
    var container = document.getElementById('sparklesContainer');
    if(!container) return;
    for(var i=0; i<30; i++){
        var el = document.createElement('span');
        el.className = (Math.random() > .5) ? 'sparkle' : 'star';
        el.style.left = Math.random()*100 + '%';
        el.style.top  = (20 + Math.random()*60) + '%';
        el.style.setProperty('--dur', (3 + Math.random()*6) + 's');
        el.style.setProperty('--delay', (Math.random()*5) + 's');
        if(el.className === 'star'){
            el.textContent = '✦';
            el.style.setProperty('--size', (8+Math.random()*14) + 'px');
        }
        container.appendChild(el);
    }
})();

// ─── Countdown ───
(function(){
    var target = new Date('{{ $event->event_date->format("Y-m-d") }}T{{ $event->event_time ?? "20:00:00" }}');
    function tick(){
        var diff = target - new Date();
        if(diff <= 0){ return; }
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
    tick();
    setInterval(tick, 1000);
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
        track.style.transform = 'translateX(-' + (page*(cardW+GAP)) + 'px)';
        var btnP = document.getElementById('gPrev');
        var btnN = document.getElementById('gNext');
        if(btnP) btnP.disabled = (page===0);
        if(btnN) btnN.disabled = (page>=maxPage());
        if(!dotsEl) return;
        var pages = Math.ceil(total/perPg);
        dotsEl.innerHTML = '';
        for(var p=0; p<pages; p++){
            var d = document.createElement('span');
            d.className = 'gallery-dot' + (p===Math.floor(page/perPg) ? ' active' : '');
            (function(target){ d.onclick = function(){ go(target*perPg); }; })(p);
            dotsEl.appendChild(d);
        }
    }
    function go(p){
        page = Math.max(0, Math.min(p, maxPage()));
        render();
        clearInterval(timer);
        timer = setInterval(autoNext, 3200);
    }
    function autoNext(){ page = (page>=maxPage()) ? 0 : page+1; render(); }
    function setup(){
        var vw = track.parentElement.offsetWidth;
        perPg = vw<420 ? 2 : vw<640 ? 3 : 4;
        cardW = (vw - GAP*(perPg-1)) / perPg;
        cards.forEach(function(c){ c.style.width = cardW+'px'; });
        page = Math.min(page, maxPage());
        render();
    }
    window.gShift = function(dir){ go(page+dir); };
    setup();
    if(total > perPg) timer = setInterval(autoNext, 3200);
    window.addEventListener('resize', setup);
    var sx=0;
    track.addEventListener('touchstart', function(e){ sx=e.touches[0].clientX; },{passive:true});
    track.addEventListener('touchend', function(e){
        var dx = e.changedTouches[0].clientX - sx;
        if(Math.abs(dx)>40) window.gShift(dx<0?1:-1);
    });
})();

// ─── Lightbox ───
function lbOpen(i){
    if(!window._lbImgs || !window._lbImgs.length) return;
    window._lbIdx = i;
    document.getElementById('lbImg').src = window._lbImgs[i];
    document.getElementById('lbCur').textContent = i+1;
    document.getElementById('lb').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function lbNav(dir){
    if(!window._lbImgs) return;
    window._lbIdx = (window._lbIdx + dir + window._lbImgs.length) % window._lbImgs.length;
    document.getElementById('lbImg').src = window._lbImgs[window._lbIdx];
    document.getElementById('lbCur').textContent = window._lbIdx+1;
}
document.getElementById('lb').addEventListener('click', function(e){
    if(e.target === this){ this.classList.remove('open'); document.body.style.overflow=''; }
});
</script>

@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
