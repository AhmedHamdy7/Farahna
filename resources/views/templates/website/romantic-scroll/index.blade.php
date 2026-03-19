<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->coupleName() }} – {{ __('invitation.hero_label') }}</title>

    @include('partials.og-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Tajawal:wght@300;400;500;700&family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    {{-- GSAP (scroll animations only — not for initial visibility) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --rose:   #e11d48;
            --gold:   #b45309;
            --cream:  #fdf8f0;
            --dark:   #1c1917;
            --muted:  #78716c;
            --border: #e7e5e4;
            --pb-accent:   #e11d48;
            --pb-btn-text: #fff;
            --map-bg: #fdf8f0; --map-text: #1c1917; --map-accent: #e11d48;
        }

        html { scroll-behavior: smooth; }

        body {
            @if(app()->isLocale('ar'))
            font-family: 'Tajawal', sans-serif;
            @else
            font-family: 'Lato', sans-serif;
            @endif
            background: var(--cream);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ─── PREVIEW BAR SPACER ─── */
        .preview-spacer { height: 60px; }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
            background: linear-gradient(160deg, #fff1f2 0%, #fdf8f0 50%, #fce7f3 100%);
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(225,29,72,.06) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(180,83,9,.06) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Hearts / Petals */
        .hearts-container {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        .heart {
            position: absolute;
            opacity: 0;
            animation: floatHeart linear infinite;
        }
        @@keyframes floatHeart {
            0%   { transform: translateY(110%) rotate(0deg); opacity: .7; }
            100% { transform: translateY(-10%) rotate(360deg); opacity: 0; }
        }

        /* Hero content — always visible, z-index above hearts */
        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-label {
            font-size: .8rem;
            letter-spacing: 4px;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            animation: fadeSlideUp .8s ease both;
        }

        .hero-names {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-style: italic;
            line-height: 1.1;
            color: var(--dark);
            animation: fadeSlideUp 1s .15s ease both;
        }

        .hero-names .amp {
            display: block;
            font-size: .5em;
            color: var(--rose);
            font-style: normal;
            margin: .3rem 0;
        }

        .hero-divider {
            width: 80px;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
            margin: 1.5rem auto;
            animation: expandWidth .8s .3s ease both;
        }
        @@keyframes expandWidth {
            from { transform: scaleX(0); opacity: 0; }
            to   { transform: scaleX(1); opacity: 1; }
        }

        .hero-date {
            font-size: 1rem;
            color: var(--muted);
            animation: fadeSlideUp .8s .4s ease both;
        }

        @@keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── COUNTDOWN ─── */
        .countdown {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
            animation: fadeSlideUp .8s .55s ease both;
        }

        .countdown-unit { text-align: center; min-width: 64px; }

        .countdown-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--rose);
            line-height: 1;
            background: #fff;
            border-radius: 12px;
            padding: .4rem .6rem;
            box-shadow: 0 4px 16px rgba(225,29,72,.12);
        }

        .countdown-label {
            font-size: .68rem;
            color: var(--muted);
            margin-top: .4rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .scroll-hint {
            position: absolute;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            color: var(--muted);
            font-size: .75rem;
            animation: bounce 2s 1.5s infinite both;
        }

        @@keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50%       { transform: translateX(-50%) translateY(8px); }
        }

        /* ─── SECTIONS ─── */
        .section {
            padding: 5rem 1.5rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            text-align: center;
            margin-bottom: .75rem;
            color: var(--dark);
        }

        .section-subtitle {
            text-align: center;
            color: var(--muted);
            font-size: .95rem;
            margin-bottom: 3rem;
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem auto 2.5rem;
            max-width: 300px;
        }
        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
        }

        /* ─── DETAILS ─── */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .detail-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.75rem 1.5rem;
            text-align: center;
            transition: transform .3s, box-shadow .3s;
        }
        .detail-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.08); }

        .detail-icon  { font-size: 2rem; margin-bottom: .75rem; }
        .detail-label { font-size: .7rem; color: var(--muted); letter-spacing: 2px; text-transform: uppercase; margin-bottom: .4rem; }
        .detail-value { font-size: 1.1rem; font-weight: 700; color: var(--dark); }
        .detail-sub   { font-size: .85rem; color: var(--muted); margin-top: .3rem; }

        /* ─── MAP LINK ─── */
        .map-link {
            display: inline-flex; align-items: center; gap: .5rem;
            margin-top: 1rem; padding: .6rem 1.25rem;
            background: var(--rose); color: #fff;
            border-radius: 8px; text-decoration: none;
            font-size: .875rem; font-weight: 500;
            transition: background .2s;
        }
        .map-link:hover { background: #be123c; }

        /* ─── GALLERY CAROUSEL ─── */
        .gallery-bg { background: linear-gradient(180deg, #fff 0%, #fdf8f0 100%); }

        .gallery-carousel-wrap {
            display: flex;
            direction: ltr;
            align-items: center;
            gap: .75rem;
        }

        /* Viewport — clips the sliding track */
        .gallery-viewport {
            flex: 1;
            overflow: hidden;
            border-radius: 16px;
        }

        /* Sliding track — force LTR so translateX works correctly even on RTL pages */
        .gallery-track {
            display: flex;
            direction: ltr;
            gap: .6rem;
            transition: transform .5s cubic-bezier(.4,0,.2,1);
            will-change: transform;
        }

        /* Each card — fixed width calculated by JS */
        .gallery-card {
            flex-shrink: 0;
            border-radius: 14px;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            transition: transform .3s, box-shadow .3s;
        }
        .gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,.15);
        }
        .gallery-card-inner {
            aspect-ratio: 1;
            overflow: hidden;
        }
        .gallery-card img {
            width: 100%; height: 100%;
            object-fit: cover; display: block;
            transition: transform .45s ease;
        }
        .gallery-card:hover img { transform: scale(1.07); }

        /* Rose overlay on hover */
        .gallery-card::after {
            content: '🔍';
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            background: rgba(225,29,72,.12);
            opacity: 0;
            transition: opacity .3s;
        }
        .gallery-card:hover::after { opacity: 1; }

        /* Arrows */
        .gallery-btn {
            flex-shrink: 0;
            width: 44px; height: 44px; border-radius: 50%;
            background: #fff;
            border: 1.5px solid var(--border);
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
            color: var(--dark); font-size: 1.3rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: background .2s, color .2s, transform .2s, box-shadow .2s;
        }
        .gallery-btn:hover {
            background: var(--rose); color: #fff; border-color: var(--rose);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(225,29,72,.3);
        }
        .gallery-btn:disabled { opacity: .25; pointer-events: none; }

        /* Dots */
        .gallery-dots {
            display: flex; justify-content: center; gap: .4rem;
            margin-top: 1rem;
        }
        .gallery-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--border); cursor: pointer;
            transition: background .25s, transform .25s;
        }
        .gallery-dot.active {
            background: var(--rose);
            transform: scale(1.3);
        }

        /* Lightbox */
        .lightbox {
            position: fixed; inset: 0; z-index: 99999;
            background: rgba(0,0,0,.92);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .3s;
        }
        .lightbox.open { opacity: 1; pointer-events: all; }
        .lightbox img {
            max-width: 88vw; max-height: 85vh;
            border-radius: 14px; object-fit: contain;
            box-shadow: 0 24px 80px rgba(0,0,0,.5);
        }
        .lb-close {
            position: absolute; top: 1rem; right: 1rem;
            width: 42px; height: 42px; border-radius: 50%;
            background: rgba(255,255,255,.15); color: #fff;
            font-size: 1.2rem; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s;
        }
        .lb-close:hover { background: rgba(255,255,255,.3); }
        .lb-arr {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 46px; height: 46px; border-radius: 50%;
            background: rgba(255,255,255,.15); color: #fff;
            font-size: 1.4rem; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s, transform .2s;
        }
        .lb-arr:hover { background: rgba(255,255,255,.28); transform: translateY(-50%) scale(1.1); }
        .lb-arr.prev { left: 1rem; }
        .lb-arr.next { right: 1rem; }
        .lb-count {
            position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%);
            color: rgba(255,255,255,.65); font-size: .78rem; letter-spacing: 1px;
        }

        /* ─── RSVP ─── */
        .rsvp-bg { background: linear-gradient(135deg, #fff1f2, #fdf8f0); }

        .rsvp-form {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 560px;
            margin: 0 auto;
            box-shadow: 0 8px 30px rgba(0,0,0,.06);
        }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .875rem; font-weight: 600; margin-bottom: .4rem; color: var(--dark); }

        .form-input, .form-select {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: .95rem;
            background: #fafaf9;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(225,29,72,.1);
            background: #fff;
        }

        .attending-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; margin-top: .4rem; }
        .attend-option { display: none; }
        .attend-label {
            display: flex; flex-direction: column; align-items: center; gap: .4rem;
            padding: .8rem .5rem;
            border: 1.5px solid var(--border); border-radius: 10px;
            cursor: pointer; transition: all .2s; font-size: .85rem; text-align: center;
        }
        .attend-option:checked + .attend-label {
            border-color: var(--rose); background: #fff1f2; color: var(--rose); font-weight: 600;
        }

        .btn-submit {
            width: 100%; padding: .9rem;
            background: var(--rose); color: #fff;
            border: none; border-radius: 12px;
            font-family: inherit; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: background .2s, transform .1s;
        }
        .btn-submit:hover { background: #be123c; }
        .btn-submit:active { transform: scale(.98); }

        .alert-success {
            background: #dcfce7; border: 1px solid #bbf7d0;
            color: #166534; padding: 1rem 1.25rem;
            border-radius: 10px; margin-bottom: 1.5rem;
            font-size: .95rem; text-align: center;
        }
        .form-error { color: #be123c; font-size: .8rem; margin-top: .3rem; }

        /* ─── WISHES ─── */
        .wishes-list { display: grid; gap: 1.25rem; margin-top: 2rem; }

        .wish-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem 1.5rem 1.5rem 3rem;
            position: relative;
            transition: transform .3s;
        }
        .wish-card:hover { transform: translateY(-2px); }

        .wish-card::before {
            content: '❝';
            position: absolute;
            top: 1rem;
            @if(app()->isLocale('ar'))
            right: 1.25rem;
            @else
            left: 1.25rem;
            @endif
            font-size: 2.5rem;
            color: #fce7f3;
            font-family: Georgia, serif;
            line-height: 1;
        }

        .wish-name    { font-weight: 700; font-size: .95rem; color: var(--rose); margin-bottom: .5rem; }
        .wish-message { color: var(--dark); line-height: 1.7; font-size: .95rem; }
        .wish-time    { font-size: .75rem; color: var(--muted); margin-top: .75rem; }

        .wish-form {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            max-width: 560px;
            margin: 0 auto 3rem;
        }

        /* ─── FOOTER ─── */
        .footer {
            text-align: center;
            padding: 3rem 1.5rem;
            background: var(--dark);
            color: #a8a29e;
            font-size: .875rem;
        }
        .footer-names {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-style: italic;
            color: #fff;
            margin-bottom: .75rem;
        }

        /* ─── LANG SWITCHER (live invitation mode) ─── */
        .lang-fab {
            position: fixed;
            @if(app()->isLocale('ar'))
            left: 1.25rem;
            @else
            right: 1.25rem;
            @endif
            bottom: 1.5rem;
            z-index: 9999;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .45rem 1rem;
            font-family: inherit;
            font-size: .8rem;
            font-weight: 600;
            color: var(--dark);
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
            transition: all .2s;
        }
        .lang-fab:hover { border-color: var(--rose); color: var(--rose); }

        /* ─── Scroll animations (enhancement only) ─── */
        .scroll-reveal { transition: opacity .6s, transform .6s; }

        /* ─── Responsive ─── */
        @media (max-width: 600px) {
            .form-row      { grid-template-columns: 1fr; }
            .countdown     { gap: .75rem; }
            .countdown-num { font-size: 1.8rem; }
            .rsvp-form     { padding: 1.5rem; }
        }
    </style>
</head>
<body>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ═══════════════════════════════════════════════
     LANGUAGE SWITCHER (live invitation only)
════════════════════════════════════════════════ --}}
@if(!($isPreview ?? false))
@if(app()->isLocale('ar'))
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="lang-fab">🌐 English</a>
@else
    <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="lang-fab">🌐 عربي</a>
@endif
@endif

{{-- ═══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ --}}
<section class="hero" id="hero">
    <div class="hearts-container" id="hearts"></div>

    <div class="hero-content">
        <p class="hero-label">{{ __('invitation.hero_label') }}</p>

        <h1 class="hero-names">
            {{ $event->groom_name }}
            <span class="amp">♥</span>
            {{ $event->bride_name }}
        </h1>

        <div class="hero-divider"></div>

        <p class="hero-date">
            @php
                $months_ar = ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
                $months_en = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                $m = $event->event_date->month - 1;
            @endphp
            @if(app()->isLocale('ar'))
                {{ $event->event_date->format('d') }} {{ $months_ar[$m] }} {{ $event->event_date->format('Y') }}
            @else
                {{ $months_en[$m] }} {{ $event->event_date->format('d, Y') }}
            @endif
            @if($event->event_time) · {{ __('invitation.at_time') }} {{ $event->event_time }} @endif
        </p>

        {{-- Countdown --}}
        <div class="countdown"
             x-data="farahnaCountdown('{{ $event->event_date->format('Y-m-d') }}')"
             x-init="start()">
            <div class="countdown-unit">
                <div class="countdown-num" x-text="d">--</div>
                <div class="countdown-label">{{ __('invitation.days') }}</div>
            </div>
            <div class="countdown-unit">
                <div class="countdown-num" x-text="h">--</div>
                <div class="countdown-label">{{ __('invitation.hours') }}</div>
            </div>
            <div class="countdown-unit">
                <div class="countdown-num" x-text="m">--</div>
                <div class="countdown-label">{{ __('invitation.minutes') }}</div>
            </div>
            <div class="countdown-unit">
                <div class="countdown-num" x-text="s">--</div>
                <div class="countdown-label">{{ __('invitation.seconds') }}</div>
            </div>
        </div>
    </div>

    <div class="scroll-hint">
        <span>{{ __('invitation.scroll_down') }}</span>
        <svg width="12" height="16" viewBox="0 0 12 20" fill="none">
            <path d="M6 1v18M1 13l5 6 5-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     EVENT DETAILS
════════════════════════════════════════════════ --}}
<section style="background:#fff;">
    <div class="section">
        <h2 class="section-title scroll-reveal">{{ __('invitation.details_title') }}</h2>
        <div class="section-divider scroll-reveal">✦</div>

        <div class="details-grid">
            <div class="detail-card scroll-reveal">
                <div class="detail-icon">📅</div>
                <div class="detail-label">{{ __('invitation.date_label') }}</div>
                <div class="detail-value">{{ $event->event_date->format('d / m / Y') }}</div>
                @if($event->event_time)
                    <div class="detail-sub">{{ __('invitation.at_time') }} {{ $event->event_time }}</div>
                @endif
            </div>

            <div class="detail-card scroll-reveal">
                <div class="detail-icon">📍</div>
                <div class="detail-label">{{ __('invitation.venue_label') }}</div>
                <div class="detail-value">{{ $event->venue_name }}</div>
                @if($event->venue_address)
                    <div class="detail-sub">{{ $event->venue_address }}</div>
                @endif
            </div>

            @if($event->venue_map_link)
                <div class="detail-card scroll-reveal" style="grid-column:1/-1; display:flex; flex-direction:column; align-items:center;">
                    <div class="detail-icon">🗺️</div>
                    <div class="detail-label">{{ __('invitation.address_label') }}</div>
                    <a href="{{ $event->venue_map_link }}" target="_blank" class="map-link">
                        {{ __('invitation.map_link') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     GALLERY
════════════════════════════════════════════════ --}}
@if($event->gallery->isNotEmpty())
<section class="gallery-bg">
    <div class="section">
        <h2 class="section-title scroll-reveal">{{ __('invitation.gallery_title') }}</h2>
        <div class="section-divider scroll-reveal">✦</div>

        <div class="gallery-carousel-wrap scroll-reveal">
            <button class="gallery-btn gallery-btn-prev" id="gPrev" onclick="gShift(-1)">&#8249;</button>
            <div class="gallery-viewport">
                <div class="gallery-track" id="gTrack">
                    @foreach($event->gallery as $i => $photo)
                    <div class="gallery-card" onclick="lbOpen({{ $i }})">
                        <div class="gallery-card-inner">
                            <img src="{{ Storage::url($photo->image_path) }}" alt="" loading="lazy">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button class="gallery-btn gallery-btn-next" id="gNext" onclick="gShift(1)">&#8250;</button>
        </div>

        <div class="gallery-dots" id="gDots"></div>
    </div>
</section>

{{-- Lightbox --}}
<div class="lightbox" id="lb" onclick="if(event.target===this)lbClose()">
    <button class="lb-close" onclick="lbClose()">✕</button>
    <button class="lb-arr prev" onclick="lbShift(-1)">&#8249;</button>
    <img id="lbImg" src="" alt="">
    <button class="lb-arr next" onclick="lbShift(1)">&#8250;</button>
    <div class="lb-count"><span id="lbCur">1</span> / {{ $event->gallery->count() }}</div>
</div>
@endif

{{-- ═══════════════════════════════════════════════
     RSVP
════════════════════════════════════════════════ --}}
<section class="rsvp-bg">
    <div class="section">
        <h2 class="section-title scroll-reveal">{{ __('invitation.rsvp_title') }}</h2>
        <div class="section-divider scroll-reveal">✦</div>
        <p class="section-subtitle scroll-reveal">{{ __('invitation.rsvp_subtitle') }}</p>

        <div class="rsvp-form scroll-reveal">
            @if(session('rsvp_sent'))
                <div class="alert-success">{{ session('rsvp_sent') }}</div>
            @endif

            <form action="{{ ($isPreview ?? false) ? '#' : route('invitation.rsvp', $event) }}"
                  method="POST"
                  @if($isPreview ?? false) onsubmit="return false" @endif>
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('invitation.guest_name') }} *</label>
                        <input type="text" name="guest_name" class="form-input"
                               value="{{ old('guest_name') }}" required
                               placeholder="{{ __('invitation.name_ph') }}">
                        @error('guest_name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('invitation.phone') }}</label>
                        <input type="tel" name="phone" class="form-input"
                               value="{{ old('phone') }}"
                               placeholder="{{ __('invitation.phone_ph') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('invitation.attending') }} *</label>
                    <div class="attending-options">
                        <div>
                            <input type="radio" name="attending" value="yes" id="att-yes" class="attend-option"
                                   {{ old('attending') === 'yes' ? 'checked' : '' }}>
                            <label for="att-yes" class="attend-label"><span>🎉</span>{{ __('invitation.attend_yes') }}</label>
                        </div>
                        <div>
                            <input type="radio" name="attending" value="no" id="att-no" class="attend-option"
                                   {{ old('attending') === 'no' ? 'checked' : '' }}>
                            <label for="att-no" class="attend-label"><span>😢</span>{{ __('invitation.attend_no') }}</label>
                        </div>
                        <div>
                            <input type="radio" name="attending" value="maybe" id="att-maybe" class="attend-option"
                                   {{ old('attending') === 'maybe' ? 'checked' : '' }}>
                            <label for="att-maybe" class="attend-label"><span>🤔</span>{{ __('invitation.attend_maybe') }}</label>
                        </div>
                    </div>
                    @error('attending')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('invitation.guests_count') }}</label>
                    <select name="guests_count" class="form-select">
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('guests_count', 1) == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? __('invitation.person') : __('invitation.persons') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-submit">
                    {{ __('invitation.rsvp_submit') }}
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     GUEST BOOK
════════════════════════════════════════════════ --}}
<section style="background:var(--cream);">
    <div class="section">
        <h2 class="section-title scroll-reveal">{{ __('invitation.wishes_title') }}</h2>
        <div class="section-divider scroll-reveal">✦</div>
        <p class="section-subtitle scroll-reveal">{{ __('invitation.wishes_subtitle') }}</p>

        <div class="wish-form scroll-reveal">
            @if(session('wish_sent'))
                <div class="alert-success">{{ session('wish_sent') }}</div>
            @endif

            <form action="{{ ($isPreview ?? false) ? '#' : route('invitation.wishes', $event) }}"
                  method="POST"
                  @if($isPreview ?? false) onsubmit="return false" @endif>
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ __('invitation.your_name') }}</label>
                    <input type="text" name="guest_name" class="form-input"
                           value="{{ old('guest_name') }}" required
                           placeholder="{{ __('invitation.name_ph') }}">
                    @error('guest_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('invitation.your_message') }}</label>
                    <textarea name="message" class="form-input" rows="3"
                              required placeholder="{{ __('invitation.message_ph') }}">{{ old('message') }}</textarea>
                    @error('message')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-submit">
                    {{ __('invitation.wishes_submit') }}
                </button>
            </form>
        </div>

        @if($event->approvedWishes->isNotEmpty())
            <div class="wishes-list">
                @foreach($event->approvedWishes as $wish)
                    <div class="wish-card scroll-reveal">
                        <p class="wish-name">{{ $wish->guest_name }}</p>
                        <p class="wish-message">{{ $wish->message }}</p>
                        <p class="wish-time">{{ $wish->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align:center;color:var(--muted);margin-top:1rem;">
                {{ __('invitation.wishes_empty') }}
            </p>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════ --}}
<footer class="footer">
    <p class="footer-names">{{ $event->groom_name }} & {{ $event->bride_name }}</p>
    <p>{{ $event->event_date->format('d · m · Y') }}</p>
    <p style="margin-top:1.5rem;font-size:.75rem;opacity:.4;">
        {{ __('invitation.made_with') }} Farahna
    </p>
</footer>

{{-- ═══════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════ --}}
<script>
    // ── Countdown (Alpine) ──
    function farahnaCountdown(dateStr) {
        return {
            d: '--', h: '--', m: '--', s: '--',
            start() { this.tick(); setInterval(() => this.tick(), 1000); },
            tick() {
                const diff = new Date(dateStr) - new Date();
                if (diff <= 0) { this.d = this.h = this.m = this.s = '00'; return; }
                this.d = String(Math.floor(diff / 86400000)).padStart(2, '0');
                this.h = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
                this.m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                this.s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            }
        };
    }

    // ── Floating Petals ──
    (function spawnPetals() {
        const c = document.getElementById('hearts');
        if (!c) return;
        const e = ['♥','💕','🌸','✦','🌹','💍'];
        for (let i = 0; i < 14; i++) {
            const s = document.createElement('span');
            s.className = 'heart';
            s.textContent = e[Math.floor(Math.random() * e.length)];
            s.style.cssText = `left:${Math.random()*100}%;font-size:${.5+Math.random()*.7}rem;`
                + `animation-duration:${8+Math.random()*8}s;animation-delay:${Math.random()*6}s;`
                + `color:${ ['#e11d48','#f43f5e','#b45309','#ec4899','#fda4af'][Math.floor(Math.random()*5)] };`;
            c.appendChild(s);
        }
    })();

    // ── Gallery Carousel + Lightbox ──
    // Script is at bottom of body — DOM is already available, no need for DOMContentLoaded
    (function() {
        var track  = document.getElementById('gTrack');
        var dotsEl = document.getElementById('gDots');
        if (!track) return; // no gallery

        var GAP    = 10;
        var page   = 0;
        var perPg  = 4;
        var cardW  = 0;
        var timer  = null;
        var cards  = track.querySelectorAll('.gallery-card');
        var total  = cards.length;

        // collect image srcs for lightbox
        window._lbImgs = Array.from(cards).map(function(c){ return c.querySelector('img').src; });
        window._lbIdx  = 0;

        function maxPage() { return Math.max(0, total - perPg); }

        function render() {
            track.style.transform = 'translateX(-' + (page * (cardW + GAP)) + 'px)';
            var btnP = document.getElementById('gPrev');
            var btnN = document.getElementById('gNext');
            if (btnP) btnP.disabled = (page === 0);
            if (btnN) btnN.disabled = (page >= maxPage());

            if (!dotsEl) return;
            var pages = Math.ceil(total / perPg);
            var curDotPage = Math.floor(page / perPg);
            dotsEl.innerHTML = '';
            for (var p = 0; p < pages; p++) {
                var d = document.createElement('span');
                d.className = 'gallery-dot' + (p === curDotPage ? ' active' : '');
                (function(target){ d.onclick = function(){ go(target * perPg); }; })(p);
                dotsEl.appendChild(d);
            }
        }

        function go(p) {
            page = Math.max(0, Math.min(p, maxPage()));
            render();
            clearInterval(timer);
            timer = setInterval(autoNext, 3200);
        }

        function autoNext() {
            page = (page >= maxPage()) ? 0 : page + 1;
            render();
        }

        function setup() {
            var vw = track.parentElement.offsetWidth;
            perPg  = vw < 420 ? 2 : vw < 640 ? 3 : 4;
            cardW  = (vw - GAP * (perPg - 1)) / perPg;
            cards.forEach(function(c){ c.style.width = cardW + 'px'; });
            page = Math.min(page, maxPage());
            render();
        }

        // Expose arrow function globally
        window.gShift = function(dir) { go(page + dir); };

        setup();
        if (total > perPg) timer = setInterval(autoNext, 3200);
        window.addEventListener('resize', setup);

        // Touch swipe on track
        var sx = 0;
        track.addEventListener('touchstart', function(e){ sx = e.touches[0].clientX; }, {passive:true});
        track.addEventListener('touchend',   function(e){
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 40) window.gShift(dx < 0 ? 1 : -1);
        });
    })();

    // Lightbox
    function lbOpen(i) {
        if (!window._lbImgs || !window._lbImgs.length) return;
        window._lbIdx = i;
        document.getElementById('lbImg').src = window._lbImgs[i];
        document.getElementById('lbCur').textContent = i + 1;
        document.getElementById('lb').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function lbClose() {
        document.getElementById('lb').classList.remove('open');
        document.body.style.overflow = '';
    }
    function lbShift(dir) {
        lbOpen((_lb.idx + dir + _lb.imgs.length) % _lb.imgs.length);
    }
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lb').classList.contains('open')) {
            if (e.key === 'Escape')     lbClose();
            if (e.key === 'ArrowRight') lbShift(1);
            if (e.key === 'ArrowLeft')  lbShift(-1);
        }
    });

    // ── GSAP scroll-triggered reveals (enhancement only) ──
    window.addEventListener('load', function() {
        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
        gsap.registerPlugin(ScrollTrigger);
        document.querySelectorAll('.scroll-reveal').forEach(function(el) {
            gsap.fromTo(el,
                { opacity: 0, y: 40 },
                { opacity: 1, y: 0, duration: .8, ease: 'power2.out',
                  scrollTrigger: { trigger: el, start: 'top 88%' } }
            );
        });
    });
</script>

@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
