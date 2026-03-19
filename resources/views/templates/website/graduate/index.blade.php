{{--
  graduate — Graduation Celebration template
  Vibe: achievement, optimism, academic milestone, future-forward
  Colors: Royal blue #1e3a8a, Gold #d4af37, White, Champagne #f5e6c8
  Fonts: Playfair Display + Tajawal
--}}
<!DOCTYPE html>
<html lang="{{ app()->isLocale('ar') ? 'ar' : 'en' }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->groom_name }} – تخرج مبارك 🎓</title>
@include('partials.og-meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --blue:      #1e3a8a;
    --blue-m:    #2548b0;
    --blue-l:    #3b5fc7;
    --blue-d:    #152d6e;
    --gold:      #d4af37;
    --gold-l:    #e8c84a;
    --gold-d:    #b8942a;
    --champagne: #f5e6c8;
    --champ-d:   #e8d0a8;
    --white:     #fdfaf4;
    --dark:      #1a1a2e;
    --muted:     #6b7280;
    --pb-accent:   #d4af37;
    --pb-btn-text: #1e3a8a;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Tajawal', sans-serif;
    background: var(--white);
    color: var(--dark);
    overflow-x: hidden;
}

/* ─── Hero ─── */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    background: linear-gradient(155deg, var(--blue) 0%, var(--blue-d) 55%, #0f2059 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 6rem 2rem 5rem;
    overflow: hidden;
}
/* Diploma corner ornaments */
.hero::before, .hero::after {
    content: '';
    position: absolute;
    width: 120px; height: 120px;
    border: 2px solid rgba(212,175,55,.25);
}
.hero::before { top: 1.5rem; left: 1.5rem; border-right: none; border-bottom: none; }
.hero::after  { bottom: 1.5rem; right: 1.5rem; border-left: none; border-top: none; }

.hero-cap { font-size: 4rem; margin-bottom: 1.2rem; filter: drop-shadow(0 4px 20px rgba(212,175,55,.4)); }
.hero-tag {
    font-family: 'Playfair Display', serif; font-style: italic;
    font-size: 1rem; color: rgba(212,175,55,.8);
    letter-spacing: .06em; margin-bottom: 1rem;
}
.hero-name {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 8vw, 5.5rem);
    font-weight: 700; color: #fff;
    line-height: 1.1; letter-spacing: .02em;
}
.hero-degree {
    margin-top: 1rem;
    font-family: 'Playfair Display', serif; font-style: italic;
    font-size: clamp(1rem, 2.5vw, 1.4rem);
    color: var(--gold); letter-spacing: .04em;
}
.hero-divider {
    width: 100px; height: 1px; margin: 1.8rem auto;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
}
.hero-date {
    font-size: .95rem; color: rgba(255,255,255,.6); letter-spacing: .04em;
}
.hero-venue { font-size: .9rem; color: rgba(255,255,255,.45); margin-top: .3rem; }

/* Stars/particles */
.hero-stars {
    position: absolute; inset: 0; pointer-events: none;
}
.hero-star {
    position: absolute; width: 3px; height: 3px; border-radius: 50%; background: rgba(212,175,55,.6);
    animation: starTwinkle ease-in-out infinite;
}
@@keyframes starTwinkle {
    0%, 100% { opacity: .2; transform: scale(1); }
    50%       { opacity: 1; transform: scale(1.5); }
}

/* Countdown */
.countdown-wrap { display: flex; gap: 1rem; justify-content: center; margin-top: 2.5rem; flex-wrap: wrap; }
.cd-box {
    background: rgba(255,255,255,.08); border: 1px solid rgba(212,175,55,.2);
    border-radius: 10px; padding: .9rem 1.2rem; min-width: 75px; text-align: center;
    backdrop-filter: blur(6px);
}
.cd-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--gold); line-height: 1; }
.cd-lbl { font-size: .65rem; color: rgba(255,255,255,.4); margin-top: .3rem; letter-spacing: .04em; }

/* ─── Section Base ─── */
.section {
    position: relative; z-index: 1;
    padding: 5rem 1.5rem;
}
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-tag {
    font-family: 'Playfair Display', serif; font-style: italic;
    font-size: .9rem; color: var(--gold-d); display: block; margin-bottom: .5rem; letter-spacing: .04em;
}
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.7rem, 4vw, 2.5rem); color: var(--blue); font-weight: 700;
}
.section-line { width: 60px; height: 2px; margin: 1rem auto 0; background: linear-gradient(90deg, var(--blue), var(--gold)); }

/* ─── Academic Timeline ─── */
.timeline-section { background: var(--white); }
.timeline {
    max-width: 700px; margin: 0 auto;
    position: relative;
}
.timeline::before {
    content: '';
    position: absolute; top: 0; bottom: 0;
    right: 50%; transform: translateX(50%);
    width: 2px;
    background: linear-gradient(to bottom, var(--blue), var(--gold), var(--blue));
}
[dir=ltr] .timeline::before { left: 50%; right: auto; }
@media (max-width: 600px) {
    .timeline::before { right: auto; left: 24px; }
    [dir=ltr] .timeline::before { right: auto; left: 24px; }
}
.timeline-item {
    display: flex; align-items: center; gap: 2rem;
    margin-bottom: 2.5rem; position: relative;
}
.timeline-item:nth-child(even) { flex-direction: row-reverse; }
@media (max-width: 600px) {
    .timeline-item, .timeline-item:nth-child(even) { flex-direction: row; padding-right: 0; padding-left: 50px; }
    [dir=ltr] .timeline-item, [dir=ltr] .timeline-item:nth-child(even) { padding-left: 50px; padding-right: 0; }
}
.timeline-dot {
    position: absolute; right: 50%; transform: translate(50%, 0);
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--blue); border: 3px solid var(--gold);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; z-index: 2; flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(30,58,138,.25);
}
[dir=ltr] .timeline-dot { right: auto; left: 50%; transform: translate(-50%, 0); }
@media (max-width: 600px) {
    .timeline-dot, [dir=ltr] .timeline-dot { right: auto; left: 0; transform: none; }
}
.timeline-card {
    background: #fff; border-radius: 14px; padding: 1.4rem 1.6rem;
    border: 1px solid rgba(30,58,138,.08);
    box-shadow: 0 4px 20px rgba(30,58,138,.06);
    width: calc(50% - 40px);
    transition: transform .2s, box-shadow .2s;
}
.timeline-card:hover { transform: translateY(-3px); box-shadow: 0 8px 32px rgba(30,58,138,.1); }
@media (max-width: 600px) { .timeline-card { width: 100%; } }
.timeline-year { font-size: .72rem; font-weight: 700; color: var(--gold-d); letter-spacing: .06em; margin-bottom: .3rem; }
.timeline-stage { font-family: 'Playfair Display', serif; font-size: 1.05rem; color: var(--blue); font-weight: 600; margin-bottom: .3rem; }
.timeline-desc { font-size: .85rem; color: var(--muted); line-height: 1.6; }

/* ─── Details ─── */
.details-section { background: linear-gradient(135deg, var(--blue), var(--blue-d)); }
.details-section .section-title { color: var(--gold); }
.details-section .section-tag { color: rgba(212,175,55,.6); }
.details-section .section-line { background: linear-gradient(90deg, var(--gold), transparent); }
.details-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.5rem; max-width: 800px; margin: 0 auto;
}
.detail-card {
    background: rgba(255,255,255,.07); border: 1px solid rgba(212,175,55,.2);
    border-radius: 14px; padding: 1.8rem; text-align: center;
    transition: background .2s;
}
.detail-card:hover { background: rgba(255,255,255,.1); }
.detail-icon { font-size: 2rem; margin-bottom: .5rem; }
.detail-label { font-size: .7rem; letter-spacing: .08rem; color: var(--gold); opacity: .7; margin-bottom: .4rem; font-weight: 700; }
.detail-value { font-size: .95rem; color: rgba(255,255,255,.85); }

/* ─── Speech Bubbles / Quotes ─── */
.quotes-section { background: var(--champagne); }
.quotes-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem; max-width: 900px; margin: 0 auto;
}
.quote-bubble {
    background: #fff; border-radius: 20px; padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(30,58,138,.07);
    position: relative;
}
/* Speech bubble tail */
.quote-bubble::after {
    content: '';
    position: absolute; bottom: -10px; right: 20px;
    border-width: 10px 10px 0;
    border-style: solid;
    border-color: #fff transparent transparent;
}
[dir=ltr] .quote-bubble::after { right: auto; left: 20px; }
.bubble-text { font-style: italic; font-size: .9rem; color: #4a5568; line-height: 1.7; margin-bottom: 1rem; }
.bubble-person { display: flex; align-items: center; gap: .7rem; margin-top: 1rem; }
.bubble-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), var(--blue-l));
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; color: var(--gold); font-weight: 700; flex-shrink: 0;
}
.bubble-name { font-weight: 700; font-size: .85rem; color: var(--blue); }
.bubble-role { font-size: .72rem; color: var(--muted); }

/* ─── Future Ambitions ─── */
.ambitions-section { background: var(--white); }
.ambitions-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.2rem; max-width: 800px; margin: 0 auto;
}
.ambition-card {
    background: linear-gradient(135deg, var(--blue), var(--blue-m));
    border-radius: 16px; padding: 1.8rem 1.4rem; text-align: center;
    color: #fff; position: relative; overflow: hidden;
    transition: transform .2s;
}
.ambition-card:hover { transform: translateY(-4px); }
.ambition-card::before {
    content: ''; position: absolute; top: -20px; right: -20px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(212,175,55,.1);
}
.ambition-icon { font-size: 2rem; margin-bottom: .7rem; }
.ambition-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; color: var(--gold); margin-bottom: .4rem; }
.ambition-desc { font-size: .8rem; color: rgba(255,255,255,.6); line-height: 1.5; }

/* ─── Gallery ─── */
.gallery-section { background: var(--champagne); }
.gallery-grid {
    display: grid; grid-template-columns: repeat(3,1fr); gap: .75rem;
    max-width: 900px; margin: 0 auto;
}
@media (max-width: 600px) { .gallery-grid { grid-template-columns: repeat(2,1fr); } }
.gallery-item {
    border-radius: 12px; overflow: hidden; cursor: pointer; aspect-ratio: 1;
    box-shadow: 0 4px 16px rgba(30,58,138,.1);
    transition: transform .3s;
}
.gallery-item:hover { transform: scale(1.04); }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-item-preview {
    background: linear-gradient(135deg, rgba(30,58,138,.15), rgba(212,175,55,.15));
    display: flex; align-items: center; justify-content: center; height: 100%; font-size: 2rem;
}

/* ─── Guestbook ─── */
.wishes-section { background: #fff; }
.wishes-list { max-width: 700px; margin: 0 auto 2rem; display: flex; flex-direction: column; gap: 1rem; }
.wish-card {
    background: var(--white); border-radius: 14px; padding: 1.4rem 1.6rem;
    border: 1px solid rgba(30,58,138,.08);
    box-shadow: 0 2px 12px rgba(30,58,138,.05);
    position: relative; overflow: hidden;
}
.wish-card::before { content: '❝'; position: absolute; top: .2rem; right: 1rem; font-size: 3.5rem; color: rgba(30,58,138,.07); font-family: 'Playfair Display', serif; line-height: 1; }
.wish-name { font-weight: 700; color: var(--blue); font-size: .9rem; }
.wish-time { font-size: .72rem; color: var(--muted); display: block; margin-bottom: .4rem; }
.wish-text { font-size: .9rem; line-height: 1.7; color: #4a5568; }
.wish-form-wrap {
    max-width: 600px; margin: 0 auto;
    background: var(--champagne); border: 1px solid rgba(212,175,55,.25);
    border-radius: 20px; padding: 2rem;
}
.wish-form-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--blue); margin-bottom: 1.2rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: .75rem; }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; padding: .7rem 1rem;
    border: 1.5px solid rgba(30,58,138,.15); border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .9rem;
    background: #fff; color: var(--dark); outline: none; transition: border-color .2s;
}
.form-input:focus, .form-textarea:focus { border-color: var(--blue); }
.form-textarea { min-height: 85px; resize: vertical; }
.form-submit {
    padding: .75rem 2rem; background: var(--blue); color: var(--gold);
    border: none; border-radius: 10px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 700;
    cursor: pointer; transition: background .2s; margin-top: .5rem;
}
.form-submit:hover { background: var(--blue-m); }

/* ─── RSVP ─── */
.rsvp-section { background: var(--champagne); border-top: 1px solid rgba(212,175,55,.15); }
.rsvp-card {
    max-width: 520px; margin: 0 auto; background: #fff; border-radius: 24px;
    padding: 2.5rem; text-align: center;
    border: 1px solid rgba(30,58,138,.1);
    box-shadow: 0 8px 40px rgba(30,58,138,.08);
}
.rsvp-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--blue); margin-bottom: .4rem; }
.rsvp-sub { font-size: .9rem; color: var(--muted); margin-bottom: 1.5rem; }
.rsvp-choices { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
.rsvp-btn {
    padding: .7rem 2rem; border: none; border-radius: 99px;
    font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 600; cursor: pointer; transition: all .2s;
}
.rsvp-btn.yes { background: var(--blue); color: var(--gold); }
.rsvp-btn.yes:hover { background: var(--blue-m); transform: translateY(-2px); }
.rsvp-btn.no  { background: rgba(30,58,138,.07); color: var(--blue); border: 1.5px solid rgba(30,58,138,.2); }
.rsvp-btn.no:hover { background: rgba(30,58,138,.12); }

/* ─── Footer ─── */
.footer {
    background: linear-gradient(135deg, var(--blue-d), var(--blue));
    color: rgba(255,255,255,.8); text-align: center; padding: 4rem 1.5rem;
}
.footer-cap { font-size: 3rem; margin-bottom: .8rem; }
.footer-name { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--gold); margin-bottom: .3rem; }
.footer-tag { font-style: italic; opacity: .6; font-size: .95rem; margin-bottom: 1.5rem; }
.footer-credit { font-size: .75rem; opacity: .3; margin-top: 2rem; }

/* Flash */
.flash {
    display: none; position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    background: var(--blue); color: var(--gold); padding: .75rem 1.8rem;
    border-radius: 99px; font-size: .9rem; font-weight: 600; z-index: 9999;
    border: 1px solid rgba(212,175,55,.3);
}

/* Lightbox */
.lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15,15,30,.95); align-items: center; justify-content: center; }
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 10px; }
.lb-close { position: absolute; top: 1.2rem; right: 1.2rem; background: none; border: none; color: rgba(212,175,55,.7); font-size: 2rem; cursor: pointer; }
.lb-close:hover { color: var(--gold); }
</style>
</head>
<body>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ═══ HERO ═══ --}}
<section class="hero">
    {{-- Twinkling stars --}}
    <div class="hero-stars" id="heroStars"></div>

    {{-- Diploma corner ornaments done via CSS ::before/::after --}}
    <div class="hero-cap">🎓</div>
    <p class="hero-tag">{{ app()->isLocale('ar') ? 'تشرّف بدعوتكم' : 'Cordially invites you to celebrate' }}</p>
    <h1 class="hero-name">{{ $event->groom_name }}</h1>
    <div class="hero-degree">
        {{ app()->isLocale('ar') ? 'بمناسبة التخرج' : 'Graduation Celebration' }}
    </div>
    <div class="hero-divider"></div>
    <p class="hero-date">🎓 {{ $event->event_date->translatedFormat('d F Y') }}</p>
    @if($event->venue_name)
    <p class="hero-venue">📍 {{ $event->venue_name }}</p>
    @endif

    <div class="countdown-wrap">
        <div class="cd-box"><div class="cd-num" id="cd-days">0</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'يوم' : 'Days' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-hours">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ساعة' : 'Hours' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-mins">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'دقيقة' : 'Mins' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-secs">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ثانية' : 'Secs' }}</div></div>
    </div>
</section>

{{-- ═══ ACADEMIC TIMELINE ═══ --}}
<section class="section timeline-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'رحلتي' : 'My Journey' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'المسيرة الأكاديمية' : 'Academic Journey' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="timeline">
        <div class="timeline-item">
            <div class="timeline-dot">📚</div>
            <div class="timeline-card">
                <div class="timeline-year">{{ app()->isLocale('ar') ? 'البداية' : 'Primary' }}</div>
                <div class="timeline-stage">{{ app()->isLocale('ar') ? 'المرحلة الابتدائية' : 'Primary School' }}</div>
                <div class="timeline-desc">{{ app()->isLocale('ar') ? 'أولى الخطوات نحو المعرفة والتعلم' : 'The first steps on the path of knowledge' }}</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">📝</div>
            <div class="timeline-card">
                <div class="timeline-year">{{ app()->isLocale('ar') ? 'النمو' : 'Middle' }}</div>
                <div class="timeline-stage">{{ app()->isLocale('ar') ? 'المرحلة الإعدادية' : 'Middle School' }}</div>
                <div class="timeline-desc">{{ app()->isLocale('ar') ? 'بناء شخصية متكاملة وصقل المواهب' : 'Building character and discovering talents' }}</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">🏫</div>
            <div class="timeline-card">
                <div class="timeline-year">{{ app()->isLocale('ar') ? 'التميز' : 'High School' }}</div>
                <div class="timeline-stage">{{ app()->isLocale('ar') ? 'المرحلة الثانوية' : 'High School' }}</div>
                <div class="timeline-desc">{{ app()->isLocale('ar') ? 'إثبات الذات والتفوق على الأقران' : 'Proving excellence and dedication' }}</div>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">🎓</div>
            <div class="timeline-card" style="border:2px solid rgba(212,175,55,.3); background:linear-gradient(135deg,#fff,var(--champagne));">
                <div class="timeline-year" style="color:var(--blue)">{{ $event->event_date->format('Y') }} 🌟</div>
                <div class="timeline-stage" style="color:var(--blue)">{{ app()->isLocale('ar') ? 'التخرج الجامعي' : 'University Graduation' }}</div>
                <div class="timeline-desc">{{ app()->isLocale('ar') ? 'تحقيق الحلم وفتح أبواب المستقبل المشرق' : 'Dream achieved, the bright future begins' }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ DETAILS ═══ --}}
<section class="section details-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'تفاصيل الحفل' : 'Celebration Details' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'موعد الاحتفال' : 'The Celebration' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="details-grid">
        @if($event->event_date)
        <div class="detail-card">
            <div class="detail-icon">📅</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'التاريخ' : 'DATE' }}</div>
            <div class="detail-value">{{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        @endif
        @if($event->event_time)
        <div class="detail-card">
            <div class="detail-icon">🕐</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'الوقت' : 'TIME' }}</div>
            <div class="detail-value">{{ $event->event_time }}</div>
        </div>
        @endif
        @if($event->venue_name)
        <div class="detail-card">
            <div class="detail-icon">🎓</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'المكان' : 'VENUE' }}</div>
            <div class="detail-value">{{ $event->venue_name }}</div>
        </div>
        @endif
        @if($event->venue_address)
        <div class="detail-card">
            <div class="detail-icon">📍</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'العنوان' : 'ADDRESS' }}</div>
            <div class="detail-value">{{ $event->venue_address }}</div>
        </div>
        @endif
    </div>
    @if($event->message)
    <div style="max-width:600px; margin:2.5rem auto; text-align:center; font-family:'Playfair Display',serif; font-style:italic; font-size:1.05rem; color:rgba(212,175,55,.8); line-height:1.9;">
        "{{ $event->message }}"
    </div>
    @endif
</section>

{{-- ═══ SPEECH BUBBLES ═══ --}}
<section class="section quotes-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'يقولون عنك' : 'They Say About You' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'من أحبابك' : 'Words from Loved Ones' }}</h2>
        <div class="section-line"></div>
    </div>
    @php $wishes = $event->approvedWishes ?? collect(); @endphp
    @if($wishes->count() > 0)
    <div class="quotes-grid" style="max-width:900px;margin:0 auto;">
        @foreach($wishes->take(6) as $wish)
        <div class="quote-bubble">
            <p class="bubble-text">"{{ $wish->message }}"</p>
            <div class="bubble-person" style="margin-top:1rem; padding-top:.8rem; border-top:1px solid rgba(30,58,138,.08);">
                <div class="bubble-avatar">{{ mb_substr($wish->guest_name, 0, 1) }}</div>
                <div>
                    <div class="bubble-name">{{ $wish->guest_name }}</div>
                    <div class="bubble-role">{{ app()->isLocale('ar') ? 'مهنئ' : 'Well-wisher' }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="quotes-grid" style="max-width:900px;margin:0 auto;">
        @php $sampleQuotes = app()->isLocale('ar')
            ? ['تفوقت وأبهرتنا دائماً، نفخر بك', 'درب النجاح أمامك، سر باثقة', 'ما وصلت لهنا إلا بجدّك وصبرك']
            : ['You always amazed us, we are so proud', 'The road to success is ahead of you', 'Your dedication brought you this far'];
        $sampleNames = app()->isLocale('ar') ? ['الأم', 'الأب', 'الأخت'] : ['Mother', 'Father', 'Sister'];
        @endphp
        @foreach($sampleQuotes as $i => $q)
        <div class="quote-bubble" style="opacity:.5">
            <p class="bubble-text">"{{ $q }}"</p>
            <div class="bubble-person" style="margin-top:1rem; padding-top:.8rem; border-top:1px solid rgba(30,58,138,.08);">
                <div class="bubble-avatar">{{ mb_substr($sampleNames[$i], 0, 1) }}</div>
                <div>
                    <div class="bubble-name">{{ $sampleNames[$i] }}</div>
                    <div class="bubble-role">{{ app()->isLocale('ar') ? 'مهنئ' : 'Well-wisher' }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    {{-- Wish form (always visible) --}}
    @if(!isset($isPreview) || !$isPreview)
    <div class="wish-form-wrap" style="max-width:600px;margin:2.5rem auto 0;background:var(--champagne);border:1px solid rgba(212,175,55,.25);border-radius:20px;padding:2rem;">
        <p class="wish-form-title" style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--blue);margin-bottom:1.2rem;">✍️ {{ app()->isLocale('ar') ? 'اترك تهنئتك' : 'Leave a Wish' }}</p>
        <form method="POST" action="{{ route('invitation.wishes', $event) }}">
            @csrf
            <div class="form-row">
                <input type="text" name="guest_name" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'اسمك' : 'Your name' }}" required>
                <input type="text" name="guest_phone" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'رقمك (اختياري)' : 'Phone (optional)' }}">
            </div>
            <textarea name="message" class="form-textarea" placeholder="{{ app()->isLocale('ar') ? 'اكتب كلمة تهنئة 🎓' : 'Write a congratulations 🎓' }}" required></textarea>
            <button type="submit" class="form-submit" style="margin-top:.75rem">{{ app()->isLocale('ar') ? 'إرسال التهنئة 🎓' : 'Send Wish 🎓' }}</button>
        </form>
    </div>
    @endif
</section>

{{-- ═══ FUTURE AMBITIONS ═══ --}}
<section class="section ambitions-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'ما بعد التخرج' : 'What\'s Next' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'طموحاتي القادمة' : 'Future Ambitions' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="ambitions-grid">
        <div class="ambition-card">
            <div class="ambition-icon">💼</div>
            <div class="ambition-title">{{ app()->isLocale('ar') ? 'المسيرة المهنية' : 'Career' }}</div>
            <div class="ambition-desc">{{ app()->isLocale('ar') ? 'بناء مسيرة مهنية تُحدث فرقاً حقيقياً' : 'Build a career that makes a real difference' }}</div>
        </div>
        <div class="ambition-card" style="background:linear-gradient(135deg,var(--gold-d),var(--gold));">
            <div class="ambition-icon">🌍</div>
            <div class="ambition-title" style="color:var(--blue)">{{ app()->isLocale('ar') ? 'استكشاف العالم' : 'Explore' }}</div>
            <div class="ambition-desc" style="color:rgba(30,58,138,.7)">{{ app()->isLocale('ar') ? 'السفر والتعلم من الثقافات المختلفة' : 'Travel and learn from different cultures' }}</div>
        </div>
        <div class="ambition-card">
            <div class="ambition-icon">📚</div>
            <div class="ambition-title">{{ app()->isLocale('ar') ? 'التعلم المستمر' : 'Lifelong Learning' }}</div>
            <div class="ambition-desc">{{ app()->isLocale('ar') ? 'لن تتوقف الرحلة، بل تبدأ مرحلة جديدة' : 'The journey never stops, a new chapter begins' }}</div>
        </div>
        <div class="ambition-card" style="background:linear-gradient(135deg,#0f2059,var(--blue));">
            <div class="ambition-icon">⭐</div>
            <div class="ambition-title">{{ app()->isLocale('ar') ? 'العطاء' : 'Giving Back' }}</div>
            <div class="ambition-desc">{{ app()->isLocale('ar') ? 'الإسهام في بناء مجتمع أفضل' : 'Contributing to a better community' }}</div>
        </div>
    </div>
</section>

{{-- ═══ GALLERY ═══ --}}
@php $gallery = $event->gallery ?? collect(); @endphp
@if($gallery->count() > 0 || (isset($isPreview) && $isPreview))
<section class="section gallery-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'لحظاتنا' : 'Our Moments' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'معرض الصور' : 'Gallery' }}</h2>
        <div class="section-line"></div>
    </div>
    <div class="gallery-grid">
        @foreach($gallery as $img)
        <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $img) }}')">
            <img src="{{ asset('storage/' . $img) }}" alt="صورة" loading="lazy">
        </div>
        @endforeach
        @if(($isPreview ?? false) && $gallery->count() === 0)
            @for($i=0;$i<6;$i++)
            <div class="gallery-item"><div class="gallery-item-preview">🎓</div></div>
            @endfor
        @endif
    </div>
</section>
@endif

{{-- ═══ RSVP ═══ --}}
@if(!isset($isPreview) || !$isPreview)
<section class="section rsvp-section">
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
    <div class="footer-cap">🎓</div>
    <div class="footer-name">{{ $event->groom_name }}</div>
    <p class="footer-tag">{{ app()->isLocale('ar') ? 'رحلة النجاح تبدأ الآن...' : 'The journey of success begins now...' }}</p>
    <div style="font-size:1.2rem;opacity:.3;letter-spacing:.8rem;margin:.8rem 0">⭐ ⭐ ⭐</div>
    <p class="footer-credit">Farahna © {{ date('Y') }}</p>
</footer>

<div class="lightbox" id="lightbox">
    <button class="lb-close" onclick="document.getElementById('lightbox').classList.remove('open')">✕</button>
    <img id="lbImg" src="" alt="">
</div>
<div class="flash" id="flash"></div>

<script>
(function () {
    // Twinkling stars
    var starsEl = document.getElementById('heroStars');
    if (starsEl) {
        for (var i = 0; i < 40; i++) {
            var s = document.createElement('div');
            s.className = 'hero-star';
            s.style.cssText = 'top:' + Math.random()*100 + '%;left:' + Math.random()*100 + '%;animation-delay:' + (Math.random()*4) + 's;animation-duration:' + (1.5+Math.random()*2) + 's;width:' + (1+Math.random()*3) + 'px;height:' + (1+Math.random()*3) + 'px;';
            starsEl.appendChild(s);
        }
    }

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
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك 🎓';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
    @if(session('rsvp_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم تسجيل ردك ⭐';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
})();
</script>
@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
