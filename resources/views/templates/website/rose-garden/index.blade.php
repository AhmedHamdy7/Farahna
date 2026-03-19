{{--
  rose-garden — Engagement / Wedding template
  Vibe: botanical, garden party, soft outdoor, watercolor
  Colors: Sage #87a878, Blush #f2c4ce, Ivory #f9f6f0, Terracotta #d4845a, Warm #e8ded4
  Fonts: Lora (serif headings) + Tajawal (Arabic body)
--}}
<!DOCTYPE html>
<html lang="{{ app()->isLocale('ar') ? 'ar' : 'en' }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->coupleName() }} – حديقة الورد</title>
@include('partials.og-meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --sage:      #87a878;
    --sage-d:    #6a8c5e;
    --blush:     #f2c4ce;
    --blush-d:   #e8a4b4;
    --ivory:     #f9f6f0;
    --terra:     #d4845a;
    --terra-d:   #b86a40;
    --warm:      #e8ded4;
    --dark:      #3d2b1f;
    --muted:     #8a7060;
    --pb-accent:   #87a878;
    --pb-btn-text: #fff;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Tajawal', sans-serif;
    background: var(--ivory);
    color: var(--dark);
    overflow-x: hidden;
}

/* ─── Watercolor SVG Blobs (decorative background) ─── */
.wc-blob {
    position: fixed; pointer-events: none; z-index: 0; opacity: .13;
}
.wc-blob-1 { top: -80px; right: -80px; width: 400px; }
.wc-blob-2 { bottom: 10%; left: -60px; width: 300px; }

/* ─── Hero ─── */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    background: linear-gradient(160deg, #fff 0%, #fdf5f7 40%, #f5ede6 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 6rem 2rem 5rem;
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(circle at 15% 80%, rgba(135,168,120,.12) 0%, transparent 45%),
        radial-gradient(circle at 85% 20%, rgba(242,196,206,.2) 0%, transparent 40%);
    pointer-events: none;
}
.hero-wreath {
    font-size: 2.2rem; line-height: 1; letter-spacing: .3rem; opacity: .55;
    margin-bottom: 1.8rem;
}
.hero-tag {
    font-family: 'Lora', serif; font-style: italic;
    font-size: 1rem; color: var(--terra); letter-spacing: .06em;
    margin-bottom: 1rem;
}
.hero-names {
    font-family: 'Lora', serif;
    font-size: clamp(2.6rem, 7vw, 5rem);
    font-weight: 600; color: var(--dark);
    line-height: 1.15; margin-bottom: .5rem;
}
.hero-names .and {
    font-size: .45em; color: var(--terra); font-style: italic;
    display: block; line-height: 1.8;
}
.hero-divider {
    width: 100px; height: 2px; margin: 1.8rem auto;
    background: linear-gradient(90deg, transparent, var(--sage), var(--blush-d), transparent);
    border: none;
}
.hero-date {
    font-family: 'Lora', serif; font-size: 1.1rem;
    color: var(--muted); letter-spacing: .05em;
}
.hero-venue {
    margin-top: .5rem; font-size: .95rem; color: var(--muted);
}
.hero-flowers {
    position: absolute; pointer-events: none; z-index: 0;
    font-size: 2rem; opacity: .25;
}
.hf-tl { top: 8%; left: 6%; transform: rotate(-25deg); }
.hf-tr { top: 6%; right: 7%; transform: rotate(20deg); }
.hf-bl { bottom: 10%; left: 5%; transform: rotate(15deg); font-size: 1.5rem; }
.hf-br { bottom: 8%; right: 5%; transform: rotate(-18deg); font-size: 1.8rem; }

/* ─── Countdown ─── */
.countdown-wrap {
    display: flex; gap: 1.2rem; justify-content: center; margin-top: 2.5rem; flex-wrap: wrap;
}
.cd-box {
    background: rgba(255,255,255,.8); border: 1px solid rgba(135,168,120,.2);
    border-radius: 16px; padding: 1rem 1.4rem; min-width: 80px;
    text-align: center; backdrop-filter: blur(6px);
    box-shadow: 0 4px 20px rgba(135,168,120,.08);
}
.cd-num { font-family: 'Lora', serif; font-size: 2rem; font-weight: 700; color: var(--sage-d); line-height: 1; }
.cd-lbl { font-size: .7rem; color: var(--muted); margin-top: .3rem; letter-spacing: .04em; }

/* ─── Calendar Widget ─── */
.cal-section {
    position: relative; z-index: 1;
    background: #fff;
    padding: 5rem 1.5rem;
}
.cal-section::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 4px;
    background: linear-gradient(90deg, var(--blush), var(--sage), var(--terra), var(--blush));
}
.section-header { text-align: center; margin-bottom: 3rem; }
.section-tag {
    font-family: 'Lora', serif; font-style: italic;
    font-size: .9rem; color: var(--terra); letter-spacing: .06em;
    display: block; margin-bottom: .5rem;
}
.section-title {
    font-family: 'Lora', serif; font-size: clamp(1.6rem, 4vw, 2.2rem);
    color: var(--dark); font-weight: 600;
}
.section-line {
    width: 60px; height: 2px; margin: 1rem auto 0;
    background: linear-gradient(90deg, var(--sage), var(--blush-d));
}

.calendar-widget {
    max-width: 380px; margin: 0 auto;
    background: var(--ivory); border-radius: 20px;
    overflow: hidden; box-shadow: 0 8px 40px rgba(61,43,31,.08);
    border: 1px solid rgba(135,168,120,.15);
}
.cal-header {
    background: var(--sage); color: #fff; padding: 1.2rem 1.5rem;
    text-align: center; font-family: 'Lora', serif;
}
.cal-month { font-size: 1.3rem; font-weight: 600; }
.cal-year { font-size: .9rem; opacity: .8; }
.cal-grid {
    display: grid; grid-template-columns: repeat(7,1fr);
    padding: 1rem; gap: 2px;
}
.cal-day-name {
    text-align: center; font-size: .65rem; color: var(--muted);
    padding: .3rem 0; font-weight: 600;
}
.cal-day {
    text-align: center; padding: .45rem .2rem;
    font-size: .8rem; border-radius: 8px;
    cursor: default; color: var(--dark);
    line-height: 1.2;
}
.cal-day.empty { background: transparent; }
.cal-day.today {
    background: var(--sage); color: #fff; font-weight: 700;
    box-shadow: 0 4px 12px rgba(135,168,120,.4);
    transform: scale(1.15);
    font-size: .85rem;
}
.cal-day.today::after {
    content: '🌿'; display: block; font-size: .7rem; line-height: 1;
}
.cal-footer {
    background: rgba(135,168,120,.08); padding: 1rem;
    text-align: center; border-top: 1px solid rgba(135,168,120,.1);
}
.cal-event-label {
    font-family: 'Lora', serif; font-style: italic;
    font-size: .95rem; color: var(--sage-d); font-weight: 600;
}
.cal-time { font-size: .8rem; color: var(--muted); margin-top: .2rem; }

/* Details card */
.details-card {
    max-width: 600px; margin: 3rem auto 0;
    background: linear-gradient(135deg, #fff, var(--ivory));
    border: 1px solid rgba(212,132,90,.15);
    border-radius: 20px; padding: 2rem 2.5rem;
    box-shadow: 0 4px 24px rgba(61,43,31,.06);
}
.details-row {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: .8rem 0; border-bottom: 1px solid rgba(135,168,120,.1);
}
.details-row:last-child { border-bottom: none; }
.details-icon { font-size: 1.3rem; flex-shrink: 0; margin-top: .1rem; }
.details-label { font-size: .75rem; color: var(--terra); font-weight: 700; letter-spacing: .04em; margin-bottom: .15rem; }
.details-value { font-size: .95rem; color: var(--dark); line-height: 1.5; }

/* ─── Map Section ─── */
.map-section {
    position: relative; z-index: 1;
    background: var(--ivory); padding: 5rem 1.5rem;
}
.map-embed-wrap {
    max-width: 700px; margin: 2rem auto;
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 8px 32px rgba(61,43,31,.1);
    border: 3px solid #fff;
    aspect-ratio: 16/7;
    background: var(--warm);
    display: flex; align-items: center; justify-content: center;
}
.map-placeholder {
    text-align: center; color: var(--muted);
    font-family: 'Lora', serif; font-style: italic;
}
.map-placeholder .map-icon { font-size: 3rem; display: block; margin-bottom: .7rem; }
.map-address-badge {
    max-width: 500px; margin: 1.5rem auto 0;
    background: #fff; border-radius: 12px;
    padding: 1rem 1.5rem; text-align: center;
    border: 1px solid rgba(135,168,120,.15);
    box-shadow: 0 2px 12px rgba(61,43,31,.05);
}
.map-venue { font-family: 'Lora', serif; font-size: 1rem; font-weight: 600; color: var(--sage-d); }
.map-addr  { font-size: .85rem; color: var(--muted); margin-top: .3rem; }
.map-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    margin-top: 1rem; padding: .6rem 1.4rem;
    background: var(--sage); color: #fff;
    border-radius: 99px; font-size: .85rem; font-weight: 600;
    text-decoration: none; transition: background .2s;
}
.map-btn:hover { background: var(--sage-d); }

/* ─── Watercolor Divider ─── */
.wc-divider {
    text-align: center; font-size: 1.4rem; letter-spacing: .6rem;
    padding: 1.5rem 0; opacity: .5; color: var(--sage-d);
}

/* ─── Masonry Gallery ─── */
.gallery-section {
    position: relative; z-index: 1;
    background: #fff; padding: 5rem 1.5rem;
}
.masonry-grid {
    column-count: 3; column-gap: 1rem;
    max-width: 900px; margin: 2rem auto;
}
@media (max-width: 640px) { .masonry-grid { column-count: 2; } }
@media (max-width: 420px) { .masonry-grid { column-count: 1; } }
.masonry-item {
    break-inside: avoid; margin-bottom: 1rem;
    border-radius: 12px; overflow: hidden;
    cursor: pointer; position: relative;
    box-shadow: 0 4px 16px rgba(61,43,31,.1);
    transition: transform .3s, box-shadow .3s;
}
.masonry-item:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(61,43,31,.15); }
.masonry-item img { width: 100%; display: block; }
.masonry-item::after {
    content: '🌹';
    position: absolute; bottom: 8px; right: 8px;
    font-size: 1.2rem; opacity: 0;
    transition: opacity .2s;
}
.masonry-item:hover::after { opacity: 1; }

/* ─── Guestbook ─── */
.wishes-section {
    position: relative; z-index: 1;
    background: var(--ivory); padding: 5rem 1.5rem;
}
.wishes-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem; max-width: 900px; margin: 2rem auto;
}
.wish-card {
    background: #fff; border-radius: 16px; padding: 1.5rem;
    border: 1px solid rgba(135,168,120,.12);
    box-shadow: 0 4px 16px rgba(61,43,31,.05);
    position: relative; overflow: hidden;
}
.wish-card::before {
    content: '❝'; position: absolute; top: .3rem; right: 1rem;
    font-size: 3.5rem; color: rgba(135,168,120,.1);
    font-family: 'Lora', serif; line-height: 1;
}
.wish-name { font-weight: 700; color: var(--sage-d); font-size: .9rem; }
.wish-time { font-size: .72rem; color: var(--muted); display: block; margin-bottom: .5rem; }
.wish-text { font-size: .88rem; line-height: 1.65; color: #5a4538; }

.wish-form-wrap {
    max-width: 600px; margin: 2rem auto 0;
    background: linear-gradient(135deg, #fff, #fdf5f0);
    border: 1px solid rgba(212,132,90,.2);
    border-radius: 20px; padding: 2rem;
}
.wish-form-title { font-family: 'Lora', serif; font-size: 1.3rem; color: var(--terra); margin-bottom: 1.2rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: .75rem; }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; padding: .7rem 1rem;
    border: 1.5px solid rgba(135,168,120,.25); border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .9rem;
    background: rgba(249,246,240,.6); color: var(--dark);
    transition: border-color .2s, box-shadow .2s; outline: none;
}
.form-input:focus, .form-textarea:focus {
    border-color: var(--sage); box-shadow: 0 0 0 3px rgba(135,168,120,.15);
}
.form-textarea { min-height: 90px; resize: vertical; }
.form-submit {
    display: inline-block; padding: .75rem 2rem;
    background: var(--sage); color: #fff; border: none; border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 600;
    cursor: pointer; transition: background .2s;
    margin-top: .5rem;
}
.form-submit:hover { background: var(--sage-d); }

/* ─── RSVP ─── */
.rsvp-section {
    position: relative; z-index: 1;
    background: linear-gradient(135deg, #fff, var(--ivory));
    padding: 5rem 1.5rem;
    border-top: 1px solid rgba(135,168,120,.1);
}
.rsvp-card {
    max-width: 520px; margin: 0 auto;
    background: #fff; border-radius: 24px;
    padding: 2.5rem; text-align: center;
    border: 1px solid rgba(135,168,120,.15);
    box-shadow: 0 8px 40px rgba(61,43,31,.08);
}
.rsvp-title { font-family: 'Lora', serif; font-size: 1.5rem; color: var(--dark); margin-bottom: .4rem; }
.rsvp-sub { font-size: .9rem; color: var(--muted); margin-bottom: 1.5rem; }
.rsvp-choices { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
.rsvp-btn {
    padding: .7rem 2rem; border: none; border-radius: 99px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 600;
    cursor: pointer; transition: all .2s;
}
.rsvp-btn.yes { background: var(--sage); color: #fff; }
.rsvp-btn.yes:hover { background: var(--sage-d); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(135,168,120,.3); }
.rsvp-btn.no  { background: rgba(212,132,90,.1); color: var(--terra-d); border: 1.5px solid rgba(212,132,90,.3); }
.rsvp-btn.no:hover  { background: rgba(212,132,90,.2); }

/* ─── Footer ─── */
.footer {
    background: var(--sage-d); color: rgba(255,255,255,.85);
    text-align: center; padding: 3rem 1.5rem;
}
.footer-names { font-family: 'Lora', serif; font-size: 1.5rem; color: #fff; margin-bottom: .3rem; }
.footer-tag { font-style: italic; opacity: .7; font-size: .9rem; margin-bottom: 1rem; }
.footer-flowers { font-size: 1.5rem; margin: 1rem 0; opacity: .6; letter-spacing: .5rem; }
.footer-credit { font-size: .78rem; opacity: .45; margin-top: 1.5rem; }

/* ─── Flash ─── */
.flash {
    display: none; position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    background: var(--sage); color: #fff; padding: .75rem 1.8rem;
    border-radius: 99px; font-size: .9rem; font-weight: 600;
    z-index: 9999; box-shadow: 0 4px 20px rgba(135,168,120,.4);
}

/* ─── Lightbox ─── */
.lightbox {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(30,15,5,.95); align-items: center; justify-content: center;
}
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 10px; }
.lb-close {
    position: absolute; top: 1.2rem; right: 1.2rem;
    background: none; border: none; color: rgba(255,255,255,.7);
    font-size: 2rem; cursor: pointer;
}
.lb-close:hover { color: #fff; }
</style>
</head>
<body>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- Watercolor blobs --}}
<svg class="wc-blob wc-blob-1" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="200" cy="200" rx="180" ry="150" fill="#87a878" transform="rotate(-20 200 200)"/>
    <ellipse cx="170" cy="180" rx="120" ry="100" fill="#f2c4ce" transform="rotate(10 170 180)"/>
</svg>
<svg class="wc-blob wc-blob-2" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="150" cy="150" rx="130" ry="100" fill="#d4845a" transform="rotate(30 150 150)"/>
</svg>

{{-- ═══ HERO ═══ --}}
<section class="hero">
    <div class="hero-flowers hf-tl">🌹</div>
    <div class="hero-flowers hf-tr">🌸</div>
    <div class="hero-flowers hf-bl">🌿</div>
    <div class="hero-flowers hf-br">🌺</div>

    <div class="hero-wreath">🌿 ✿ 🌿</div>
    <p class="hero-tag">{{ app()->isLocale('ar') ? 'يسعدكم حضوركم' : 'You are cordially invited' }}</p>

    <h1 class="hero-names">
        {{ $event->groom_name }}
        @if($event->bride_name)
            <span class="and">&amp;</span>
            {{ $event->bride_name }}
        @endif
    </h1>

    <hr class="hero-divider">

    <p class="hero-date">
        🌿 {{ $event->event_date->translatedFormat('d F Y') }}
    </p>
    @if($event->venue_name)
    <p class="hero-venue">{{ $event->venue_name }}</p>
    @endif

    {{-- Countdown --}}
    <div class="countdown-wrap">
        <div class="cd-box"><div class="cd-num" id="cd-days">0</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'يوم' : 'Days' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-hours">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ساعة' : 'Hours' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-mins">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'دقيقة' : 'Mins' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-secs">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ثانية' : 'Secs' }}</div></div>
    </div>
</section>

{{-- ═══ CALENDAR + DETAILS ═══ --}}
@php
    $eventDate = $event->event_date;
    $daysInMonth = $eventDate->daysInMonth;
    $firstDayOfWeek = \Carbon\Carbon::create($eventDate->year, $eventDate->month, 1)->dayOfWeek; // 0=Sun
    $eventDay = $eventDate->day;
    $dayNames = app()->isLocale('ar')
        ? ['أح','إث','ثل','أر','خم','جم','سب']
        : ['Su','Mo','Tu','We','Th','Fr','Sa'];
    $monthName = app()->isLocale('ar')
        ? $eventDate->translatedFormat('F')
        : $eventDate->format('F');
@endphp
<section class="cal-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'موعدنا' : 'Save the Date' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'يوم الفرح' : 'The Big Day' }}</h2>
        <div class="section-line"></div>
    </div>

    <div class="calendar-widget">
        <div class="cal-header">
            <div class="cal-month">{{ $monthName }}</div>
            <div class="cal-year">{{ $eventDate->year }}</div>
        </div>
        <div class="cal-grid">
            @foreach($dayNames as $dn)
                <div class="cal-day-name">{{ $dn }}</div>
            @endforeach
            @for($i = 0; $i < $firstDayOfWeek; $i++)
                <div class="cal-day empty"></div>
            @endfor
            @for($d = 1; $d <= $daysInMonth; $d++)
                <div class="cal-day {{ $d === $eventDay ? 'today' : '' }}">{{ $d }}</div>
            @endfor
        </div>
        <div class="cal-footer">
            <div class="cal-event-label">🌹 {{ $event->coupleName() }}</div>
            @if($event->event_time)
            <div class="cal-time">🕐 {{ $event->event_time }}</div>
            @endif
        </div>
    </div>

    {{-- Details card --}}
    <div class="details-card">
        @if($event->event_date)
        <div class="details-row">
            <span class="details-icon">📅</span>
            <div>
                <div class="details-label">{{ app()->isLocale('ar') ? 'التاريخ' : 'Date' }}</div>
                <div class="details-value">{{ $event->event_date->translatedFormat('l، d F Y') }}</div>
            </div>
        </div>
        @endif
        @if($event->event_time)
        <div class="details-row">
            <span class="details-icon">🕐</span>
            <div>
                <div class="details-label">{{ app()->isLocale('ar') ? 'الوقت' : 'Time' }}</div>
                <div class="details-value">{{ $event->event_time }}</div>
            </div>
        </div>
        @endif
        @if($event->venue_name)
        <div class="details-row">
            <span class="details-icon">🌿</span>
            <div>
                <div class="details-label">{{ app()->isLocale('ar') ? 'المكان' : 'Venue' }}</div>
                <div class="details-value">{{ $event->venue_name }}</div>
            </div>
        </div>
        @endif
        @if($event->venue_address)
        <div class="details-row">
            <span class="details-icon">📍</span>
            <div>
                <div class="details-label">{{ app()->isLocale('ar') ? 'العنوان' : 'Address' }}</div>
                <div class="details-value">{{ $event->venue_address }}</div>
            </div>
        </div>
        @endif
        @if($event->message)
        <div class="details-row">
            <span class="details-icon">💌</span>
            <div>
                <div class="details-label">{{ app()->isLocale('ar') ? 'رسالة' : 'Message' }}</div>
                <div class="details-value">{{ $event->message }}</div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ═══ MAP ═══ --}}
@if($event->venue_address || $event->venue_name)
<section class="map-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'طريق الوصول' : 'Getting Here' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'موقع الحفل' : 'Venue Location' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="map-embed-wrap">
        <div class="map-placeholder">
            <span class="map-icon">🗺️</span>
            @if($event->venue_name)
                <strong>{{ $event->venue_name }}</strong><br>
            @endif
            @if($event->venue_address)
                <span style="font-size:.85rem; color:var(--muted)">{{ $event->venue_address }}</span>
            @endif
        </div>
    </div>
    <div class="map-address-badge">
        @if($event->venue_name)
        <div class="map-venue">🌹 {{ $event->venue_name }}</div>
        @endif
        @if($event->venue_address)
        <div class="map-addr">{{ $event->venue_address }}</div>
        @endif
        @if($event->venue_address)
        <a href="https://maps.google.com/?q={{ urlencode($event->venue_name . ' ' . $event->venue_address) }}"
           target="_blank" class="map-btn">
            🗺️ {{ app()->isLocale('ar') ? 'افتح الخريطة' : 'Open Map' }}
        </a>
        @endif
    </div>
</section>
@endif

{{-- ═══ MASONRY GALLERY ═══ --}}
@php $gallery = $event->gallery ?? collect(); @endphp
@if($gallery->count() > 0 || (isset($isPreview) && $isPreview))
<section class="gallery-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'لحظاتنا' : 'Our Moments' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'معرض الصور' : 'Gallery' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="masonry-grid">
        @foreach($gallery as $img)
        <div class="masonry-item" onclick="openLightbox('{{ asset('storage/' . $img) }}')">
            <img src="{{ asset('storage/' . $img) }}" alt="صورة" loading="lazy">
        </div>
        @endforeach
        @if(($isPreview ?? false) && $gallery->count() === 0)
            @for($i = 0; $i < 6; $i++)
            <div class="masonry-item" style="background:linear-gradient(135deg,rgba(135,168,120,.2),rgba(242,196,206,.3));height:{{ 120 + ($i % 3) * 60 }}px; display:flex; align-items:center; justify-content:center; font-size:2rem; cursor:default;">🌹</div>
            @endfor
        @endif
    </div>
</section>
@endif

<div class="wc-divider">🌿 · 🌸 · 🌿</div>

{{-- ═══ GUESTBOOK ═══ --}}
<section class="wishes-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'دفتر التهاني' : 'Guestbook' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'كلمات من القلب' : 'Words from the Heart' }}</h2>
        <div class="section-line"></div>
    </div>

    @php $wishes = $event->approvedWishes ?? collect(); @endphp
    @if($wishes->count() > 0)
    <div class="wishes-grid">
        @foreach($wishes as $wish)
        <div class="wish-card">
            <span class="wish-name">🌹 {{ $wish->guest_name }}</span>
            <span class="wish-time">
                @php try { echo \Carbon\Carbon::parse($wish->created_at)->diffForHumans(); } catch(\Exception $e) {} @endphp
            </span>
            <p class="wish-text">{{ $wish->message }}</p>
        </div>
        @endforeach
    </div>
    @endif

    @if(!isset($isPreview) || !$isPreview)
    <div class="wish-form-wrap">
        <p class="wish-form-title">✍️ {{ app()->isLocale('ar') ? 'اترك تهنئتك' : 'Leave a Wish' }}</p>
        <form method="POST" action="{{ route('invitation.wishes', $event) }}">
            @csrf
            <div class="form-row">
                <input type="text" name="guest_name" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'اسمك' : 'Your name' }}" required>
                <input type="text" name="guest_phone" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'رقمك (اختياري)' : 'Phone (optional)' }}">
            </div>
            <textarea name="message" class="form-textarea" placeholder="{{ app()->isLocale('ar') ? 'اكتب كلمة حلوة 🌹' : 'Write a sweet message 🌹' }}" required></textarea>
            <div style="margin-top:.75rem">
                <button type="submit" class="form-submit">{{ app()->isLocale('ar') ? 'إرسال التهنئة 🌸' : 'Send Wish 🌸' }}</button>
            </div>
        </form>
    </div>
    @endif
</section>

{{-- ═══ RSVP ═══ --}}
@if(!isset($isPreview) || !$isPreview)
<section class="rsvp-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'حضورك يسعدنا' : 'Your Presence' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'تأكيد المشاركة' : 'RSVP' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="rsvp-card">
        <h3 class="rsvp-title">{{ app()->isLocale('ar') ? 'هل ستحضر؟' : 'Will you attend?' }}</h3>
        <p class="rsvp-sub">{{ app()->isLocale('ar') ? 'أخبرنا حتى نستعد لاستقبالك' : 'Let us know so we can prepare' }}</p>
        <form method="POST" action="{{ route('invitation.rsvp', $event) }}">
            @csrf
            <input type="text" name="guest_name" class="form-input" style="margin-bottom:.75rem" placeholder="{{ app()->isLocale('ar') ? 'اسمك' : 'Your name' }}" required>
            <div class="rsvp-choices">
                <button type="submit" name="status" value="attending" class="rsvp-btn yes">✅ {{ app()->isLocale('ar') ? 'بالتأكيد' : 'Attending' }}</button>
                <button type="submit" name="status" value="declined" class="rsvp-btn no">🙏 {{ app()->isLocale('ar') ? 'معذرة' : 'Declined' }}</button>
            </div>
            <div style="margin-top:1rem">
                <textarea name="notes" class="form-textarea" rows="2" placeholder="{{ app()->isLocale('ar') ? 'ملاحظات (اختياري)' : 'Notes (optional)' }}" style="min-height:60px"></textarea>
            </div>
        </form>
    </div>
</section>
@endif

{{-- ═══ FOOTER ═══ --}}
<footer class="footer">
    <div class="footer-names">{{ $event->coupleName() }}</div>
    <p class="footer-tag">{{ app()->isLocale('ar') ? 'يبدأ الحلم في حديقة الورد...' : 'Love blooms in the rose garden...' }}</p>
    <div class="footer-flowers">🌹 🌸 🌿</div>
    <p class="footer-credit">Farahna © {{ date('Y') }}</p>
</footer>

<div class="lightbox" id="lightbox">
    <button class="lb-close" onclick="document.getElementById('lightbox').classList.remove('open')">✕</button>
    <img id="lbImg" src="" alt="">
</div>
<div class="flash" id="flash"></div>

<script>
(function () {
    // Countdown
    var targetDate = new Date('{{ \Carbon\Carbon::parse($event->event_date)->toDateString() }} {{ $event->event_time ?? "20:00" }}');
    function tick() {
        var diff = targetDate - new Date();
        if (diff <= 0) return;
        var d = Math.floor(diff/86400000),
            h = Math.floor((diff%86400000)/3600000),
            m = Math.floor((diff%3600000)/60000),
            s = Math.floor((diff%60000)/1000);
        var el;
        if((el=document.getElementById('cd-days')))  el.textContent = d;
        if((el=document.getElementById('cd-hours'))) el.textContent = String(h).padStart(2,'0');
        if((el=document.getElementById('cd-mins')))  el.textContent = String(m).padStart(2,'0');
        if((el=document.getElementById('cd-secs')))  el.textContent = String(s).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);

    // Lightbox
    window.openLightbox = function(src) {
        document.getElementById('lbImg').src = src;
        document.getElementById('lightbox').classList.add('open');
    };
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') document.getElementById('lightbox').classList.remove('open');
    });

    // Flash
    @if(session('wish_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك 🌹';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
    @if(session('rsvp_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم تسجيل ردك 🌸';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
})();
</script>
@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
