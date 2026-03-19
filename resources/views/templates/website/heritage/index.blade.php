{{--
  heritage — Traditional Arabic Wedding template
  Vibe: Islamic heritage, geometric patterns, oriental elegance
  Colors: Emerald #1a3a2a, Gold #c5a028, Ivory #f7f3e8, Crimson #8b1a1a
  Fonts: Scheherazade New (Arabic heritage) + Tajawal
--}}
<!DOCTYPE html>
<html lang="{{ app()->isLocale('ar') ? 'ar' : 'en' }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->coupleName() }} – تراث</title>
@include('partials.og-meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --emerald:   #1a3a2a;
    --emerald-m: #254d38;
    --emerald-l: #2f6347;
    --gold:      #c5a028;
    --gold-l:    #dab840;
    --gold-d:    #a88520;
    --ivory:     #f7f3e8;
    --ivory-d:   #ede8d5;
    --crimson:   #8b1a1a;
    --crimson-l: #a52020;
    --dark:      #1a1208;
    --muted:     #6b5a3a;
    --pb-accent:   #c5a028;
    --pb-btn-text: #1a3a2a;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Tajawal', sans-serif;
    background: var(--ivory);
    color: var(--dark);
    overflow-x: hidden;
}

/* ─── Geometric Pattern Background ─── */
.geo-bg {
    position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .04;
    background-image:
        repeating-linear-gradient(45deg, var(--gold) 0, var(--gold) 1px, transparent 0, transparent 50%),
        repeating-linear-gradient(-45deg, var(--gold) 0, var(--gold) 1px, transparent 0, transparent 50%);
    background-size: 30px 30px;
}

/* ─── Header / Bismillah ─── */
.bismillah-section {
    position: relative; z-index: 1;
    background: var(--emerald);
    text-align: center; padding: 3.5rem 2rem 2.5rem;
    overflow: hidden;
}
.bismillah-section::before,
.bismillah-section::after {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 4px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.bismillah-section::after { top: auto; bottom: 0; }
.bismillah-geo {
    position: absolute; inset: 0; pointer-events: none;
    background-image: repeating-linear-gradient(60deg, rgba(197,160,40,.06) 0, rgba(197,160,40,.06) 1px, transparent 0, transparent 40px);
}
.bismillah-text {
    font-family: 'Scheherazade New', serif;
    font-size: clamp(2rem, 6vw, 3.5rem);
    color: var(--gold);
    line-height: 1.4; letter-spacing: .03em;
    text-shadow: 0 2px 20px rgba(197,160,40,.3);
}
.bismillah-dua {
    font-family: 'Scheherazade New', serif;
    font-size: clamp(1rem, 2.5vw, 1.3rem);
    color: rgba(197,160,40,.7);
    margin-top: .8rem; line-height: 1.8;
}

/* ─── Hero ─── */
.hero {
    position: relative; z-index: 1;
    background: linear-gradient(170deg, #fff 0%, var(--ivory) 60%, var(--ivory-d) 100%);
    text-align: center; padding: 5rem 2rem 4rem;
    overflow: hidden;
}
.hero-border-top {
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.hero-geo-decor {
    position: absolute; top: 30px; left: 50%; transform: translateX(-50%);
    font-size: 1.4rem; opacity: .25; letter-spacing: 1rem; white-space: nowrap;
}
.hero-tag {
    font-family: 'Scheherazade New', serif;
    font-size: 1.1rem; color: var(--gold-d);
    letter-spacing: .05em; margin-bottom: 1.5rem;
}
.hero-names {
    font-family: 'Scheherazade New', serif;
    font-size: clamp(2.8rem, 8vw, 5.5rem);
    font-weight: 700; color: var(--emerald);
    line-height: 1.2;
}
.hero-and {
    font-family: 'Scheherazade New', serif;
    font-size: clamp(1.2rem, 3vw, 1.8rem);
    color: var(--gold); display: block;
    line-height: 2;
}
/* Islamic star divider */
.star-divider {
    display: flex; align-items: center; justify-content: center;
    gap: 1rem; margin: 1.8rem auto; max-width: 400px;
}
.star-divider::before, .star-divider::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.star-center { font-size: 1.5rem; }

.hero-date {
    font-family: 'Scheherazade New', serif;
    font-size: 1.2rem; color: var(--muted);
}
.hero-venue { font-size: .95rem; color: var(--muted); margin-top: .4rem; }

/* Countdown */
.countdown-wrap {
    display: flex; gap: 1rem; justify-content: center;
    margin-top: 2.5rem; flex-wrap: wrap;
}
.cd-box {
    background: var(--emerald); border-radius: 12px;
    padding: .9rem 1.2rem; min-width: 75px; text-align: center;
    border: 1px solid rgba(197,160,40,.3);
    box-shadow: 0 4px 16px rgba(26,58,42,.2);
}
.cd-num { font-family: 'Scheherazade New', serif; font-size: 2rem; font-weight: 700; color: var(--gold); line-height: 1; }
.cd-lbl { font-size: .65rem; color: rgba(197,160,40,.6); margin-top: .3rem; letter-spacing: .04em; }

/* ─── Geometric Divider SVG ─── */
.geo-divider {
    text-align: center; padding: 2rem 1rem;
    background: var(--emerald);
}
.geo-divider svg { width: 100%; max-width: 600px; height: auto; }

/* ─── Section Base ─── */
.section {
    position: relative; z-index: 1;
    padding: 5rem 1.5rem;
}
.section-header { text-align: center; margin-bottom: 3rem; }
.section-tag {
    font-family: 'Scheherazade New', serif;
    font-size: 1rem; color: var(--gold-d);
    display: block; margin-bottom: .5rem; letter-spacing: .03em;
}
.section-title {
    font-family: 'Scheherazade New', serif;
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--emerald); font-weight: 700;
}
.section-ornament { font-size: 1.5rem; margin-top: .5rem; opacity: .5; }

/* ─── Details ─── */
.details-section { background: #fff; }
.details-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.5rem; max-width: 800px; margin: 0 auto;
}
.detail-card {
    background: linear-gradient(135deg, var(--ivory), #fff);
    border: 1px solid rgba(197,160,40,.2); border-radius: 16px;
    padding: 1.8rem; text-align: center;
    box-shadow: 0 4px 20px rgba(26,58,42,.05);
    position: relative; overflow: hidden;
}
.detail-card::before {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
    background: linear-gradient(90deg, var(--emerald), var(--gold), var(--emerald));
}
.detail-icon { font-size: 2rem; margin-bottom: .6rem; }
.detail-label { font-size: .75rem; color: var(--gold-d); font-weight: 700; letter-spacing: .05em; margin-bottom: .4rem; }
.detail-value { font-family: 'Scheherazade New', serif; font-size: 1.1rem; color: var(--emerald); font-weight: 600; }

/* ─── Family Names ─── */
.families-section { background: var(--emerald); }
.families-section .section-tag { color: rgba(197,160,40,.8); }
.families-section .section-title { color: var(--gold); }
.families-grid {
    display: grid; grid-template-columns: 1fr auto 1fr;
    gap: 2rem; align-items: center; max-width: 700px; margin: 0 auto;
}
@media (max-width: 600px) {
    .families-grid { grid-template-columns: 1fr; }
    .families-divider-v { display: none; }
}
.family-card {
    background: rgba(197,160,40,.08); border: 1px solid rgba(197,160,40,.2);
    border-radius: 16px; padding: 2rem 1.5rem; text-align: center;
}
.family-title { font-family: 'Scheherazade New', serif; font-size: 1rem; color: rgba(197,160,40,.6); margin-bottom: .8rem; }
.family-groom, .family-bride {
    font-family: 'Scheherazade New', serif; font-size: 1.8rem; font-weight: 700; color: var(--gold);
    margin-bottom: .3rem;
}
.family-names-list { font-size: .85rem; color: rgba(247,243,232,.6); line-height: 1.8; }
.families-divider-v {
    text-align: center; color: var(--gold); font-size: 2rem; opacity: .4;
}

/* ─── Gallery ─── */
.gallery-section { background: var(--ivory); }
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem; max-width: 900px; margin: 0 auto;
}
@media (max-width: 640px) { .gallery-grid { grid-template-columns: repeat(2,1fr); } }
.gallery-item {
    border-radius: 10px; overflow: hidden; cursor: pointer;
    aspect-ratio: 1; position: relative;
    box-shadow: 0 4px 16px rgba(26,58,42,.1);
    border: 2px solid rgba(197,160,40,.2);
    transition: transform .3s, box-shadow .3s;
}
.gallery-item:hover { transform: scale(1.03); box-shadow: 0 8px 28px rgba(26,58,42,.2); }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-item-preview {
    background: linear-gradient(135deg, rgba(26,58,42,.15), rgba(197,160,40,.15));
    display: flex; align-items: center; justify-content: center;
    height: 100%; font-size: 2rem;
}

/* ─── Guestbook ─── */
.wishes-section { background: #fff; }
.wishes-list { display: flex; flex-direction: column; gap: 1rem; max-width: 700px; margin: 0 auto 2rem; }
.wish-card {
    background: var(--ivory); border-radius: 14px; padding: 1.4rem 1.6rem;
    border: 1px solid rgba(197,160,40,.15);
    box-shadow: 0 2px 12px rgba(26,58,42,.05);
    position: relative; overflow: hidden;
}
.wish-card::before {
    content: '❝'; position: absolute;
    top: .2rem; right: 1rem;
    font-family: 'Scheherazade New', serif;
    font-size: 3rem; color: rgba(197,160,40,.12); line-height: 1;
}
.wish-name { font-weight: 700; color: var(--emerald); font-size: .9rem; }
.wish-time { font-size: .72rem; color: var(--muted); display: block; margin-bottom: .4rem; }
.wish-text { font-size: .9rem; line-height: 1.7; color: #4a3820; }

.wish-form-wrap {
    max-width: 600px; margin: 0 auto;
    background: var(--ivory); border: 1px solid rgba(197,160,40,.2);
    border-radius: 20px; padding: 2rem;
}
.wish-form-title { font-family: 'Scheherazade New', serif; font-size: 1.4rem; color: var(--emerald); margin-bottom: 1.2rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: .75rem; }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; padding: .7rem 1rem;
    border: 1.5px solid rgba(197,160,40,.25); border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .9rem;
    background: #fff; color: var(--dark);
    transition: border-color .2s; outline: none;
}
.form-input:focus, .form-textarea:focus { border-color: var(--gold); }
.form-textarea { min-height: 90px; resize: vertical; }
.form-submit {
    padding: .75rem 2rem; background: var(--emerald); color: var(--gold);
    border: none; border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 700;
    cursor: pointer; transition: background .2s;
    margin-top: .5rem;
}
.form-submit:hover { background: var(--emerald-m); }

/* ─── RSVP ─── */
.rsvp-section { background: var(--ivory); border-top: 1px solid rgba(197,160,40,.15); }
.rsvp-card {
    max-width: 520px; margin: 0 auto; background: #fff;
    border-radius: 24px; padding: 2.5rem; text-align: center;
    border: 1px solid rgba(197,160,40,.2);
    box-shadow: 0 8px 40px rgba(26,58,42,.06);
}
.rsvp-title { font-family: 'Scheherazade New', serif; font-size: 1.6rem; color: var(--emerald); margin-bottom: .4rem; }
.rsvp-sub { font-size: .9rem; color: var(--muted); margin-bottom: 1.5rem; }
.rsvp-choices { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
.rsvp-btn {
    padding: .7rem 2rem; border: none; border-radius: 99px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 600; cursor: pointer; transition: all .2s;
}
.rsvp-btn.yes { background: var(--emerald); color: var(--gold); }
.rsvp-btn.yes:hover { background: var(--emerald-m); transform: translateY(-2px); }
.rsvp-btn.no  { background: rgba(139,26,26,.08); color: var(--crimson); border: 1.5px solid rgba(139,26,26,.2); }
.rsvp-btn.no:hover  { background: rgba(139,26,26,.15); }

/* ─── Footer ─── */
.footer { background: var(--emerald); color: rgba(247,243,232,.8); text-align: center; padding: 3.5rem 1.5rem; }
.footer-bismillah { font-family: 'Scheherazade New', serif; font-size: 1.5rem; color: var(--gold); margin-bottom: 1.2rem; opacity: .7; }
.footer-names { font-family: 'Scheherazade New', serif; font-size: 1.8rem; color: var(--gold); margin-bottom: .4rem; }
.footer-tag { font-family: 'Scheherazade New', serif; font-size: 1rem; opacity: .6; margin-bottom: 1.5rem; }
.footer-credit { font-size: .75rem; opacity: .4; margin-top: 1.5rem; }

/* Flash */
.flash {
    display: none; position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    background: var(--emerald); color: var(--gold); padding: .75rem 1.8rem;
    border-radius: 99px; font-size: .9rem; font-weight: 600; z-index: 9999;
    border: 1px solid rgba(197,160,40,.4);
}

/* Lightbox */
.lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(10,20,12,.96); align-items: center; justify-content: center; }
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 10px; border: 2px solid rgba(197,160,40,.3); }
.lb-close { position: absolute; top: 1.2rem; right: 1.2rem; background: none; border: none; color: rgba(197,160,40,.7); font-size: 2rem; cursor: pointer; }
.lb-close:hover { color: var(--gold); }
</style>
</head>
<body>
<div class="geo-bg"></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ═══ BISMILLAH ═══ --}}
<div class="bismillah-section">
    <div class="bismillah-geo"></div>
    <div class="bismillah-text">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
    <div class="bismillah-dua">
        {{ app()->isLocale('ar')
            ? '﴿ وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا ﴾'
            : '"And of His signs is that He created for you mates from yourselves"' }}
    </div>
</div>

{{-- ═══ HERO ═══ --}}
<section class="hero">
    <div class="hero-border-top"></div>
    <div class="hero-geo-decor">✦ ✦ ✦ ✦ ✦</div>

    <p class="hero-tag" style="margin-top:1rem">
        {{ app()->isLocale('ar') ? 'يُشرّفهم دعوتكم الكريمة' : 'Together with their families' }}
    </p>

    <h1 class="hero-names">
        {{ $event->groom_name }}
        @if($event->bride_name)
            <span class="hero-and">و</span>
            {{ $event->bride_name }}
        @endif
    </h1>

    <div class="star-divider">
        <span class="star-center">✦</span>
    </div>

    <p class="hero-date">📅 {{ $event->event_date->translatedFormat('l، d F Y') }}</p>
    @if($event->venue_name)
    <p class="hero-venue">🕌 {{ $event->venue_name }}</p>
    @endif

    <div class="countdown-wrap">
        <div class="cd-box"><div class="cd-num" id="cd-days">0</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'يوم' : 'Days' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-hours">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ساعة' : 'Hours' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-mins">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'دقيقة' : 'Mins' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-secs">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ثانية' : 'Secs' }}</div></div>
    </div>
</section>

{{-- ═══ GEOMETRIC DIVIDER ═══ --}}
<div class="geo-divider">
    <svg viewBox="0 0 600 60" xmlns="http://www.w3.org/2000/svg">
        <line x1="0" y1="30" x2="600" y2="30" stroke="rgba(197,160,40,.3)" stroke-width="1"/>
        <polygon points="280,10 300,30 280,50 260,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".6"/>
        <polygon points="300,10 320,30 300,50 280,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".4"/>
        <polygon points="320,10 340,30 320,50 300,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".6"/>
        <circle cx="300" cy="30" r="4" fill="#c5a028" opacity=".8"/>
        <circle cx="260" cy="30" r="2.5" fill="#c5a028" opacity=".4"/>
        <circle cx="340" cy="30" r="2.5" fill="#c5a028" opacity=".4"/>
        <circle cx="220" cy="30" r="1.5" fill="#c5a028" opacity=".25"/>
        <circle cx="380" cy="30" r="1.5" fill="#c5a028" opacity=".25"/>
    </svg>
</div>

{{-- ═══ DETAILS ═══ --}}
<section class="section details-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'تفاصيل الحفل' : 'Event Details' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'موعد السعادة' : 'The Celebration' }}</h2>
        <div class="section-ornament">✦</div>
    </div>
    <div class="details-grid">
        @if($event->event_date)
        <div class="detail-card">
            <div class="detail-icon">📅</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'التاريخ' : 'Date' }}</div>
            <div class="detail-value">{{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        @endif
        @if($event->event_time)
        <div class="detail-card">
            <div class="detail-icon">🕐</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'الوقت' : 'Time' }}</div>
            <div class="detail-value">{{ $event->event_time }}</div>
        </div>
        @endif
        @if($event->venue_name)
        <div class="detail-card">
            <div class="detail-icon">🕌</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'القاعة' : 'Venue' }}</div>
            <div class="detail-value">{{ $event->venue_name }}</div>
        </div>
        @endif
        @if($event->venue_address)
        <div class="detail-card">
            <div class="detail-icon">📍</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'العنوان' : 'Address' }}</div>
            <div class="detail-value">{{ $event->venue_address }}</div>
        </div>
        @endif
    </div>
    @if($event->message)
    <div style="max-width:600px; margin:2rem auto; text-align:center; font-family:'Scheherazade New',serif; font-size:1.1rem; color:var(--muted); font-style:italic; line-height:1.9;">
        "{{ $event->message }}"
    </div>
    @endif
</section>

{{-- ═══ FAMILIES ═══ --}}
<section class="section families-section">
    <div class="section-header">
        <span class="section-tag" style="color:rgba(197,160,40,.7)">{{ app()->isLocale('ar') ? 'العائلتان الكريمتان' : 'The Families' }}</span>
        <h2 class="section-title" style="color:var(--gold)">{{ app()->isLocale('ar') ? 'أهل العريس وأهل العروسة' : 'Groom & Bride Families' }}</h2>
        <div class="section-ornament" style="color:var(--gold); opacity:.4">✦ ✦ ✦</div>
    </div>
    <div class="families-grid">
        <div class="family-card">
            <div class="family-title">{{ app()->isLocale('ar') ? 'أسرة العريس' : 'Groom\'s Family' }}</div>
            <div class="family-groom">{{ $event->groom_name }}</div>
            @if($event->groom_father_name ?? false)
            <div class="family-names-list">{{ app()->isLocale('ar') ? 'نجل' : 'Son of' }} {{ $event->groom_father_name }}</div>
            @endif
        </div>
        <div class="families-divider-v">✦</div>
        <div class="family-card">
            <div class="family-title">{{ app()->isLocale('ar') ? 'أسرة العروسة' : 'Bride\'s Family' }}</div>
            <div class="family-bride">{{ $event->bride_name ?? '—' }}</div>
            @if($event->bride_father_name ?? false)
            <div class="family-names-list">{{ app()->isLocale('ar') ? 'كريمة' : 'Daughter of' }} {{ $event->bride_father_name }}</div>
            @endif
        </div>
    </div>
</section>

{{-- ═══ GEOMETRIC DIVIDER ═══ --}}
<div class="geo-divider">
    <svg viewBox="0 0 600 60" xmlns="http://www.w3.org/2000/svg">
        <line x1="0" y1="30" x2="600" y2="30" stroke="rgba(197,160,40,.3)" stroke-width="1"/>
        <polygon points="280,10 300,30 280,50 260,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".6"/>
        <polygon points="300,10 320,30 300,50 280,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".4"/>
        <polygon points="320,10 340,30 320,50 300,30" fill="none" stroke="#c5a028" stroke-width="1.5" opacity=".6"/>
        <circle cx="300" cy="30" r="4" fill="#c5a028" opacity=".8"/>
    </svg>
</div>

{{-- ═══ GALLERY ═══ --}}
@php $gallery = $event->gallery ?? collect(); @endphp
@if($gallery->count() > 0 || (isset($isPreview) && $isPreview))
<section class="section gallery-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'لحظاتنا' : 'Our Moments' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'معرض الصور' : 'Gallery' }}</h2>
        <div class="section-ornament">✦</div>
    </div>
    <div class="gallery-grid">
        @foreach($gallery as $img)
        <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $img) }}')">
            <img src="{{ asset('storage/' . $img) }}" alt="صورة" loading="lazy">
        </div>
        @endforeach
        @if(($isPreview ?? false) && $gallery->count() === 0)
            @for($i = 0; $i < 6; $i++)
            <div class="gallery-item"><div class="gallery-item-preview">✦</div></div>
            @endfor
        @endif
    </div>
</section>
@endif

{{-- ═══ GUESTBOOK ═══ --}}
<section class="section wishes-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'دفتر التهاني' : 'Guestbook' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'كلمات من القلب' : 'Words from the Heart' }}</h2>
        <div class="section-ornament">✦</div>
    </div>
    @php $wishes = $event->approvedWishes ?? collect(); @endphp
    @if($wishes->count() > 0)
    <div class="wishes-list">
        @foreach($wishes as $wish)
        <div class="wish-card">
            <span class="wish-name">✦ {{ $wish->guest_name }}</span>
            <span class="wish-time">@php try { echo \Carbon\Carbon::parse($wish->created_at)->diffForHumans(); } catch(\Exception $e) {} @endphp</span>
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
            <textarea name="message" class="form-textarea" placeholder="{{ app()->isLocale('ar') ? 'اكتب كلمة طيبة ✦' : 'Write a kind word ✦' }}" required></textarea>
            <button type="submit" class="form-submit" style="margin-top:.75rem">{{ app()->isLocale('ar') ? 'إرسال التهنئة ✦' : 'Send Wish ✦' }}</button>
        </form>
    </div>
    @endif
</section>

{{-- ═══ RSVP ═══ --}}
@if(!isset($isPreview) || !$isPreview)
<section class="section rsvp-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'حضورك يسعدنا' : 'Your Presence' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'تأكيد المشاركة' : 'RSVP' }}</h2>
        <div class="section-ornament">✦</div>
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
    <div class="footer-bismillah">﷽</div>
    <div class="footer-names">{{ $event->coupleName() }}</div>
    <p class="footer-tag">{{ app()->isLocale('ar') ? 'على بركة الله...' : 'Blessed be the union...' }}</p>
    <div style="font-size:1.2rem; opacity:.3; letter-spacing:.8rem; margin:.8rem 0">✦ ✦ ✦</div>
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
        var d = Math.floor(diff/86400000), h = Math.floor((diff%86400000)/3600000),
            m = Math.floor((diff%3600000)/60000), s = Math.floor((diff%60000)/1000);
        var el;
        if((el=document.getElementById('cd-days')))  el.textContent = d;
        if((el=document.getElementById('cd-hours'))) el.textContent = String(h).padStart(2,'0');
        if((el=document.getElementById('cd-mins')))  el.textContent = String(m).padStart(2,'0');
        if((el=document.getElementById('cd-secs')))  el.textContent = String(s).padStart(2,'0');
    }
    tick(); setInterval(tick, 1000);

    window.openLightbox = function(src) {
        document.getElementById('lbImg').src = src;
        document.getElementById('lightbox').classList.add('open');
    };
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') document.getElementById('lightbox').classList.remove('open');
    });

    @if(session('wish_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك ✦';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
    @if(session('rsvp_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم تسجيل ردك ✦';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
})();
</script>
@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
