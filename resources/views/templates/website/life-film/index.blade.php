{{--
  life-film — Cinematic Wedding / Any Event template
  Vibe: movie credits, dramatic, fullscreen, cinematic grandeur
  Colors: #0c0c0c bg, Pure white, Gold #d4af37, Cinema red #8b0000
  Fonts: Bebas Neue (bold cinematic) + Tajawal
--}}
<!DOCTYPE html>
<html lang="{{ app()->isLocale('ar') ? 'ar' : 'en' }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->coupleName() }} – فيلم الحياة</title>
@include('partials.og-meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --black:  #0c0c0c;
    --dark:   #1a1a1a;
    --dark2:  #222;
    --gold:   #d4af37;
    --gold-l: #e8c84a;
    --gold-d: #b8942a;
    --red:    #8b0000;
    --red-l:  #a50000;
    --white:  #f0ece4;
    --muted:  #888;
    --pb-accent:   #d4af37;
    --pb-btn-text: #0c0c0c;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Tajawal', sans-serif;
    background: var(--black);
    color: var(--white);
    overflow-x: hidden;
}

/* ─── Film grain overlay ─── */
body::before {
    content: '';
    position: fixed; inset: 0; pointer-events: none; z-index: 9998;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
    opacity: .025;
}

/* ─── Opening Credits / Hero ─── */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    background:
        linear-gradient(to bottom, rgba(0,0,0,.4) 0%, rgba(0,0,0,.1) 40%, rgba(0,0,0,.6) 100%),
        radial-gradient(ellipse at center, #1a1a1a 0%, #0c0c0c 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 6rem 2rem 5rem; overflow: hidden;
}
/* Vertical film perforations */
.film-perf {
    position: absolute; top: 0; bottom: 0; width: 36px;
    display: flex; flex-direction: column; justify-content: space-around;
    padding: 1rem 0; opacity: .15;
}
.film-perf.left  { left: 0; background: rgba(255,255,255,.03); }
.film-perf.right { right: 0; background: rgba(255,255,255,.03); }
.perf-hole {
    width: 20px; height: 14px; margin: 0 auto;
    border: 1.5px solid rgba(255,255,255,.4); border-radius: 2px;
}

.hero-studio {
    font-family: 'Bebas Neue', cursive;
    font-size: .85rem; letter-spacing: .5rem; color: var(--gold);
    opacity: .6; margin-bottom: 2rem;
}
.hero-presents {
    font-size: .8rem; color: rgba(255,255,255,.4);
    letter-spacing: .2rem; margin-bottom: 1.5rem;
}
.hero-title {
    font-family: 'Bebas Neue', cursive;
    font-size: clamp(3rem, 9vw, 7rem);
    color: var(--white); line-height: .95;
    letter-spacing: .05em;
    text-shadow: 0 0 60px rgba(212,175,55,.15);
}
.hero-title .name-gold { color: var(--gold); }
.hero-title .name-and {
    font-size: .35em; color: rgba(255,255,255,.4);
    letter-spacing: .2em; display: block; line-height: 2;
}
.hero-rule { width: 80px; height: 1px; background: var(--gold); margin: 1.5rem auto; opacity: .5; }
.hero-subtitle {
    font-size: .85rem; letter-spacing: .15rem; color: rgba(255,255,255,.5);
    text-transform: uppercase; margin-bottom: 2.5rem;
}
.hero-date-badge {
    display: inline-flex; align-items: center; gap: .8rem;
    background: rgba(212,175,55,.08); border: 1px solid rgba(212,175,55,.25);
    border-radius: 4px; padding: .6rem 1.4rem;
    font-family: 'Bebas Neue', cursive; font-size: 1.1rem; letter-spacing: .1em; color: var(--gold);
}

/* Countdown */
.countdown-wrap { display: flex; gap: 1rem; justify-content: center; margin-top: 2.5rem; flex-wrap: wrap; }
.cd-box {
    background: rgba(255,255,255,.04); border: 1px solid rgba(212,175,55,.15);
    border-radius: 6px; padding: .8rem 1.1rem; min-width: 72px; text-align: center;
}
.cd-num { font-family: 'Bebas Neue', cursive; font-size: 2.2rem; color: var(--gold); line-height: 1; }
.cd-lbl { font-size: .65rem; color: var(--muted); margin-top: .25rem; letter-spacing: .06em; }

/* ─── Chapter Divider ─── */
.chapter-bar {
    background: var(--red); padding: .6rem 2rem;
    text-align: center;
}
.chapter-label {
    font-family: 'Bebas Neue', cursive;
    font-size: 1.1rem; letter-spacing: .4rem; color: rgba(255,255,255,.8);
}

/* ─── Chapters Section ─── */
.chapters-section {
    position: relative; z-index: 1;
    background: var(--dark); padding: 5rem 1.5rem;
}
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-tag {
    font-family: 'Bebas Neue', cursive;
    font-size: .85rem; letter-spacing: .4rem; color: var(--gold);
    opacity: .6; display: block; margin-bottom: .5rem;
}
.section-title {
    font-family: 'Bebas Neue', cursive;
    font-size: clamp(2rem, 5vw, 3rem); color: var(--white); letter-spacing: .08em;
}
.section-rule { width: 50px; height: 2px; background: var(--red); margin: 1rem auto 0; }

.chapters-list { max-width: 700px; margin: 0 auto; display: flex; flex-direction: column; gap: 0; }
.chapter-item {
    display: grid; grid-template-columns: 80px 1fr;
    gap: 0; align-items: stretch;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.chapter-item:last-child { border-bottom: none; }
.chapter-num {
    background: rgba(212,175,55,.06); border-right: 2px solid rgba(212,175,55,.2);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 1.5rem .5rem;
}
[dir=ltr] .chapter-num { border-left: 2px solid rgba(212,175,55,.2); border-right: none; }
.chapter-num .ch-label { font-size: .6rem; letter-spacing: .1rem; color: var(--gold); opacity: .5; margin-bottom: .3rem; }
.chapter-num .ch-n { font-family: 'Bebas Neue', cursive; font-size: 2rem; color: var(--gold); line-height: 1; }
.chapter-body { padding: 1.5rem 1.5rem; }
.chapter-title { font-family: 'Bebas Neue', cursive; font-size: 1.3rem; letter-spacing: .06em; color: var(--white); margin-bottom: .4rem; }
.chapter-desc { font-size: .88rem; color: rgba(255,255,255,.5); line-height: 1.7; }
.chapter-badge {
    display: inline-block; margin-top: .6rem;
    background: rgba(139,0,0,.3); border: 1px solid rgba(139,0,0,.4);
    border-radius: 3px; padding: .2rem .6rem;
    font-size: .7rem; letter-spacing: .08rem; color: #ff7070;
}

/* ─── Details ─── */
.details-section { background: var(--black); padding: 5rem 1.5rem; position: relative; z-index: 1; }
.details-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1px; max-width: 800px; margin: 0 auto;
    border: 1px solid rgba(212,175,55,.1); border-radius: 8px; overflow: hidden;
}
.detail-cell {
    background: rgba(255,255,255,.03); padding: 2rem 1.5rem; text-align: center;
    border-right: 1px solid rgba(212,175,55,.08);
    transition: background .2s;
}
.detail-cell:hover { background: rgba(212,175,55,.04); }
.detail-icon { font-size: 1.8rem; margin-bottom: .5rem; }
.detail-label { font-size: .7rem; letter-spacing: .12rem; color: var(--gold); opacity: .6; margin-bottom: .4rem; font-family: 'Bebas Neue', cursive; }
.detail-value { font-size: .95rem; color: var(--white); }

/* ─── Film Strip Gallery ─── */
.gallery-section { background: var(--dark); padding: 5rem 0; overflow: hidden; position: relative; z-index: 1; }
.gallery-section .section-header { padding: 0 1.5rem; }
.filmstrip-wrap { margin-top: 2.5rem; overflow: hidden; position: relative; }
.filmstrip-track {
    display: flex; gap: 0; animation: filmScroll 30s linear infinite;
    width: max-content;
}
@@keyframes filmScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.filmstrip-track:hover { animation-play-state: paused; }
.film-frame {
    width: 240px; height: 180px; flex-shrink: 0;
    position: relative; overflow: hidden;
    border-left: 3px solid rgba(212,175,55,.1);
    cursor: pointer;
    transition: filter .3s;
}
.film-frame:hover { filter: brightness(1.2); }
.film-frame img { width: 100%; height: 100%; object-fit: cover; display: block; filter: sepia(15%); }
/* Film perforation strips on gallery */
.filmstrip-perfs {
    height: 20px; background: rgba(255,255,255,.04);
    display: flex; align-items: center; gap: 8px; padding: 0 8px;
    border-top: 1px solid rgba(255,255,255,.05);
    border-bottom: 1px solid rgba(255,255,255,.05);
}
.strip-hole { width: 18px; height: 12px; border: 1px solid rgba(255,255,255,.2); border-radius: 2px; flex-shrink: 0; }
.filmstrip-top    { position: absolute; top: 0; left: 0; right: 0; }
.filmstrip-bottom { position: absolute; bottom: 0; left: 0; right: 0; }

.film-frame-preview {
    background: linear-gradient(135deg, #1a1a1a, #222);
    display: flex; align-items: center; justify-content: center;
    height: 100%; font-size: 2.5rem; color: rgba(212,175,55,.3);
}

/* ─── RSVP Ticket ─── */
.rsvp-section { background: var(--black); padding: 5rem 1.5rem; position: relative; z-index: 1; }
.ticket {
    max-width: 520px; margin: 0 auto;
    background: var(--dark2); border-radius: 8px;
    overflow: hidden; position: relative;
    box-shadow: 0 20px 60px rgba(0,0,0,.6), 0 0 0 1px rgba(212,175,55,.15);
}
.ticket-header {
    background: var(--red); padding: 1.5rem 2rem; text-align: center;
    position: relative;
}
.ticket-header::after {
    content: ''; position: absolute; bottom: -12px; left: 0; right: 0;
    height: 12px;
    background: radial-gradient(circle at 10px -6px, var(--dark2) 10px, transparent 0) repeat-x,
                radial-gradient(circle at 10px -6px, var(--dark2) 10px, transparent 0) repeat-x;
    background-size: 20px 12px; background-position: 0 0, 10px 0;
}
.ticket-type { font-family: 'Bebas Neue', cursive; font-size: .8rem; letter-spacing: .4rem; color: rgba(255,255,255,.6); margin-bottom: .3rem; }
.ticket-event { font-family: 'Bebas Neue', cursive; font-size: 1.8rem; letter-spacing: .06em; color: var(--white); }
.ticket-body { padding: 2rem 2rem 1.5rem; margin-top: 12px; }
.ticket-subtitle { font-size: .85rem; color: var(--muted); margin-bottom: 1.5rem; text-align: center; }
.ticket-form input, .ticket-form textarea {
    width: 100%; background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1); border-radius: 6px;
    color: var(--white); font-family: 'Tajawal', sans-serif; font-size: .9rem;
    padding: .75rem 1rem; outline: none; transition: border-color .2s;
    margin-bottom: .75rem;
}
.ticket-form input:focus, .ticket-form textarea:focus { border-color: rgba(212,175,55,.4); }
.ticket-form textarea { min-height: 70px; resize: vertical; }
.ticket-btns { display: flex; gap: 1rem; margin-top: .5rem; }
.ticket-btn {
    flex: 1; padding: .8rem; border: none; border-radius: 6px;
    font-family: 'Bebas Neue', cursive; font-size: 1.1rem; letter-spacing: .08em;
    cursor: pointer; transition: all .2s;
}
.ticket-btn.yes { background: var(--gold); color: var(--black); }
.ticket-btn.yes:hover { background: var(--gold-l); transform: translateY(-2px); }
.ticket-btn.no  { background: rgba(255,255,255,.06); color: rgba(255,255,255,.6); border: 1px solid rgba(255,255,255,.1); }
.ticket-btn.no:hover { background: rgba(255,255,255,.1); }
.ticket-tear { height: 2px; background: repeating-linear-gradient(90deg, transparent, transparent 6px, rgba(255,255,255,.1) 6px, rgba(255,255,255,.1) 7px); margin: .5rem 0; }

/* ─── Guestbook ─── */
.wishes-section { background: var(--dark); padding: 5rem 1.5rem; position: relative; z-index: 1; }
.wishes-list { max-width: 700px; margin: 0 auto 2rem; display: flex; flex-direction: column; gap: 1rem; }
.wish-card {
    background: rgba(255,255,255,.04); border-radius: 8px; padding: 1.4rem 1.6rem;
    border: 1px solid rgba(255,255,255,.07);
    position: relative;
}
.wish-card::before { content: '"'; position: absolute; top: .5rem; right: 1rem; font-size: 3rem; color: rgba(212,175,55,.1); font-family: 'Bebas Neue', cursive; line-height: 1; }
.wish-name { font-weight: 700; color: var(--gold); font-size: .9rem; }
.wish-time { font-size: .72rem; color: var(--muted); display: block; margin-bottom: .4rem; }
.wish-text { font-size: .9rem; line-height: 1.7; color: rgba(255,255,255,.6); }
.wish-form-wrap {
    max-width: 600px; margin: 0 auto;
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08);
    border-radius: 8px; padding: 2rem;
}
.wish-form-title { font-family: 'Bebas Neue', cursive; font-size: 1.3rem; letter-spacing: .06em; color: var(--gold); margin-bottom: 1.2rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: .75rem; }
@media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; padding: .7rem 1rem;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
    border-radius: 6px; color: var(--white);
    font-family: 'Tajawal', sans-serif; font-size: .9rem; outline: none;
    transition: border-color .2s;
}
.form-input:focus, .form-textarea:focus { border-color: rgba(212,175,55,.4); }
.form-textarea { min-height: 80px; resize: vertical; }
.form-submit {
    padding: .7rem 2rem; background: var(--gold); color: var(--black);
    border: none; border-radius: 6px;
    font-family: 'Bebas Neue', cursive; font-size: 1rem; letter-spacing: .08em;
    cursor: pointer; transition: background .2s; margin-top: .5rem;
}
.form-submit:hover { background: var(--gold-l); }

/* ─── Footer ─── */
.footer { background: var(--black); text-align: center; padding: 4rem 1.5rem; border-top: 1px solid rgba(212,175,55,.1); }
.footer-credits {
    font-family: 'Bebas Neue', cursive;
    font-size: clamp(2rem, 6vw, 4rem);
    color: var(--white); letter-spacing: .06em; line-height: 1.1;
    margin-bottom: .5rem;
}
.footer-year { font-size: .8rem; letter-spacing: .2rem; color: var(--muted); margin-bottom: 2rem; }
.footer-rule { width: 40px; height: 1px; background: var(--red); margin: 1.5rem auto; opacity: .6; }
.footer-credit { font-size: .75rem; color: rgba(255,255,255,.2); letter-spacing: .05rem; }

/* Flash */
.flash {
    display: none; position: fixed; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    background: var(--gold); color: var(--black); padding: .75rem 1.8rem;
    border-radius: 4px; font-size: .9rem; font-weight: 700; z-index: 9999;
}

/* Lightbox */
.lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.97); align-items: center; justify-content: center; }
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 6px; border: 1px solid rgba(212,175,55,.2); }
.lb-close { position: absolute; top: 1.2rem; right: 1.2rem; background: none; border: none; color: rgba(212,175,55,.7); font-size: 2rem; cursor: pointer; }
.lb-close:hover { color: var(--gold); }
</style>
</head>
<body>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ═══ HERO / OPENING CREDITS ═══ --}}
<section class="hero">
    {{-- Film perforations --}}
    <div class="film-perf left">
        @for($i=0;$i<18;$i++)<div class="perf-hole"></div>@endfor
    </div>
    <div class="film-perf right">
        @for($i=0;$i<18;$i++)<div class="perf-hole"></div>@endfor
    </div>

    <div class="hero-studio">فرحنا · FARAHNA FILMS</div>
    <div class="hero-presents">{{ app()->isLocale('ar') ? 'يقدّم لكم' : 'PRESENTS' }}</div>

    <h1 class="hero-title">
        <span class="name-gold">{{ $event->groom_name }}</span>
        @if($event->bride_name)
            <span class="name-and">&amp;</span>
            {{ $event->bride_name }}
        @endif
    </h1>

    <div class="hero-rule"></div>
    <div class="hero-subtitle">
        {{ app()->isLocale('ar') ? 'قصة حب · فيلم الحياة' : 'A LOVE STORY · THE FILM OF LIFE' }}
    </div>

    <div class="hero-date-badge">
        🎬 {{ $event->event_date->translatedFormat('d F Y') }}
        @if($event->event_time) · {{ $event->event_time }} @endif
    </div>

    <div class="countdown-wrap">
        <div class="cd-box"><div class="cd-num" id="cd-days">0</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'يوم' : 'DAYS' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-hours">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ساعة' : 'HRS' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-mins">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'دقيقة' : 'MINS' }}</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-secs">00</div><div class="cd-lbl">{{ app()->isLocale('ar') ? 'ثانية' : 'SECS' }}</div></div>
    </div>
</section>

{{-- ═══ CHAPTERS ═══ --}}
<div class="chapter-bar">
    <div class="chapter-label">{{ app()->isLocale('ar') ? '— الفصـول —' : '— THE CHAPTERS —' }}</div>
</div>

<section class="chapters-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'فيلم الحياة' : 'THE FILM' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'فصول القصة' : 'OUR STORY' }}</h2>
        <div class="section-rule"></div>
    </div>
    <div class="chapters-list">
        <div class="chapter-item">
            <div class="chapter-num">
                <span class="ch-label">{{ app()->isLocale('ar') ? 'الفصل' : 'ACT' }}</span>
                <span class="ch-n">I</span>
            </div>
            <div class="chapter-body">
                <div class="chapter-title">{{ app()->isLocale('ar') ? 'البداية' : 'THE BEGINNING' }}</div>
                <p class="chapter-desc">{{ app()->isLocale('ar') ? 'حين التقت الأرواح في أول لقاء، وكان لكل شيء معنى خاص...' : 'When souls first met, and everything felt written in the stars...' }}</p>
            </div>
        </div>
        <div class="chapter-item">
            <div class="chapter-num">
                <span class="ch-label">{{ app()->isLocale('ar') ? 'الفصل' : 'ACT' }}</span>
                <span class="ch-n">II</span>
            </div>
            <div class="chapter-body">
                <div class="chapter-title">{{ app()->isLocale('ar') ? 'الوعد' : 'THE PROMISE' }}</div>
                <p class="chapter-desc">{{ app()->isLocale('ar') ? 'قلب يعد قلباً بالعمر كله، وكلمة لا تُنسى...' : 'A heart that promised a lifetime, a word never forgotten...' }}</p>
            </div>
        </div>
        <div class="chapter-item">
            <div class="chapter-num">
                <span class="ch-label">{{ app()->isLocale('ar') ? 'الفصل' : 'ACT' }}</span>
                <span class="ch-n">III</span>
            </div>
            <div class="chapter-body">
                <div class="chapter-title">
                    @if($event->bride_name)
                        {{ $event->groom_name }} &amp; {{ $event->bride_name }}
                    @else
                        {{ $event->groom_name }}
                    @endif
                </div>
                <p class="chapter-desc">
                    📅 {{ $event->event_date->translatedFormat('d F Y') }}
                    @if($event->event_time) · {{ $event->event_time }} @endif
                    @if($event->venue_name) · {{ $event->venue_name }} @endif
                </p>
                <span class="chapter-badge">{{ app()->isLocale('ar') ? 'قريباً' : 'COMING SOON' }}</span>
            </div>
        </div>
    </div>
</section>

{{-- ═══ DETAILS ═══ --}}
<section class="details-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'المعلومات' : 'DETAILS' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'موعد العرض' : 'SCREENING DETAILS' }}</h2>
        <div class="section-rule"></div>
    </div>
    <div class="details-grid">
        @if($event->event_date)
        <div class="detail-cell">
            <div class="detail-icon">📅</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'التاريخ' : 'DATE' }}</div>
            <div class="detail-value">{{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        @endif
        @if($event->event_time)
        <div class="detail-cell">
            <div class="detail-icon">🕐</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'الوقت' : 'TIME' }}</div>
            <div class="detail-value">{{ $event->event_time }}</div>
        </div>
        @endif
        @if($event->venue_name)
        <div class="detail-cell">
            <div class="detail-icon">🎬</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'المكان' : 'VENUE' }}</div>
            <div class="detail-value">{{ $event->venue_name }}</div>
        </div>
        @endif
        @if($event->venue_address)
        <div class="detail-cell">
            <div class="detail-icon">📍</div>
            <div class="detail-label">{{ app()->isLocale('ar') ? 'العنوان' : 'ADDRESS' }}</div>
            <div class="detail-value">{{ $event->venue_address }}</div>
        </div>
        @endif
    </div>
    @if($event->message)
    <div style="max-width:600px; margin:2.5rem auto; text-align:center; font-style:italic; color:rgba(240,236,228,.5); font-size:.95rem; line-height:1.8; border-top:1px solid rgba(255,255,255,.06); padding-top:2rem">
        "{{ $event->message }}"
    </div>
    @endif
</section>

{{-- ═══ FILM STRIP GALLERY ═══ --}}
@php $gallery = $event->gallery ?? collect(); @endphp
@if($gallery->count() > 0 || (isset($isPreview) && $isPreview))
<section class="gallery-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'الأرشيف' : 'THE ARCHIVE' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'لحظاتنا' : 'OUR MOMENTS' }}</h2>
        <div class="section-rule"></div>
    </div>
    <div class="filmstrip-wrap">
        {{-- Top perforation strip --}}
        <div style="display:flex;gap:8px;padding:4px 8px;background:rgba(255,255,255,.03);border-top:1px solid rgba(255,255,255,.05);border-bottom:1px solid rgba(255,255,255,.05);overflow:hidden;">
            @for($i=0;$i<60;$i++)<div class="strip-hole"></div>@endfor
        </div>
        <div class="filmstrip-track" id="filmTrack">
            @foreach($gallery as $img)
            <div class="film-frame" onclick="openLightbox('{{ asset('storage/' . $img) }}')">
                <img src="{{ asset('storage/' . $img) }}" alt="" loading="lazy">
            </div>
            @endforeach
            @if(($isPreview ?? false) && $gallery->count() === 0)
                @for($i=0;$i<8;$i++)
                <div class="film-frame"><div class="film-frame-preview">🎬</div></div>
                @endfor
            @endif
            {{-- Duplicate for seamless loop --}}
            @foreach($gallery as $img)
            <div class="film-frame">
                <img src="{{ asset('storage/' . $img) }}" alt="" loading="lazy">
            </div>
            @endforeach
            @if(($isPreview ?? false) && $gallery->count() === 0)
                @for($i=0;$i<8;$i++)
                <div class="film-frame"><div class="film-frame-preview">🎬</div></div>
                @endfor
            @endif
        </div>
        {{-- Bottom perforation strip --}}
        <div style="display:flex;gap:8px;padding:4px 8px;background:rgba(255,255,255,.03);border-top:1px solid rgba(255,255,255,.05);border-bottom:1px solid rgba(255,255,255,.05);overflow:hidden;">
            @for($i=0;$i<60;$i++)<div class="strip-hole"></div>@endfor
        </div>
    </div>
</section>
@endif

{{-- ═══ GUESTBOOK ═══ --}}
<section class="wishes-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'الجمهور يقول' : 'AUDIENCE REVIEWS' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'كلمات من القلب' : 'WORDS FROM THE HEART' }}</h2>
        <div class="section-rule"></div>
    </div>
    @php $wishes = $event->approvedWishes ?? collect(); @endphp
    @if($wishes->count() > 0)
    <div class="wishes-list">
        @foreach($wishes as $wish)
        <div class="wish-card">
            <span class="wish-name">🎬 {{ $wish->guest_name }}</span>
            <span class="wish-time">@php try { echo \Carbon\Carbon::parse($wish->created_at)->diffForHumans(); } catch(\Exception $e) {} @endphp</span>
            <p class="wish-text">{{ $wish->message }}</p>
        </div>
        @endforeach
    </div>
    @endif
    @if(!isset($isPreview) || !$isPreview)
    <div class="wish-form-wrap">
        <p class="wish-form-title">✍️ {{ app()->isLocale('ar') ? 'اترك تهنئتك' : 'LEAVE A REVIEW' }}</p>
        <form method="POST" action="{{ route('invitation.wishes', $event) }}">
            @csrf
            <div class="form-row">
                <input type="text" name="guest_name" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'اسمك' : 'Your name' }}" required>
                <input type="text" name="guest_phone" class="form-input" placeholder="{{ app()->isLocale('ar') ? 'رقمك (اختياري)' : 'Phone (optional)' }}">
            </div>
            <textarea name="message" class="form-textarea" placeholder="{{ app()->isLocale('ar') ? 'اكتب كلمة حلوة 🎬' : 'Write your review 🎬' }}" required></textarea>
            <button type="submit" class="form-submit" style="margin-top:.75rem">{{ app()->isLocale('ar') ? 'إرسال 🎬' : 'SUBMIT 🎬' }}</button>
        </form>
    </div>
    @endif
</section>

{{-- ═══ RSVP TICKET ═══ --}}
@if(!isset($isPreview) || !$isPreview)
<section class="rsvp-section">
    <div class="section-header">
        <span class="section-tag">{{ app()->isLocale('ar') ? 'احجز مقعدك' : 'RESERVE YOUR SEAT' }}</span>
        <h2 class="section-title">{{ app()->isLocale('ar') ? 'تذكرة الدخول' : 'YOUR TICKET' }}</h2>
        <div class="section-rule"></div>
    </div>
    <div class="ticket">
        <div class="ticket-header">
            <div class="ticket-type">{{ app()->isLocale('ar') ? 'دعوة حضور · تأكيد الحجز' : 'INVITATION · RSVP' }}</div>
            <div class="ticket-event">
                @if($event->bride_name)
                    {{ $event->groom_name }} &amp; {{ $event->bride_name }}
                @else
                    {{ $event->groom_name }}
                @endif
            </div>
        </div>
        <div class="ticket-body">
            <div class="ticket-tear"></div>
            <p class="ticket-subtitle">{{ app()->isLocale('ar') ? 'احجز مقعدك الآن' : 'Reserve your seat now' }}</p>
            <form method="POST" action="{{ route('invitation.rsvp', $event) }}" class="ticket-form">
                @csrf
                <input type="text" name="guest_name" placeholder="{{ app()->isLocale('ar') ? 'اسمك الكريم' : 'Your full name' }}" required>
                <textarea name="notes" rows="2" placeholder="{{ app()->isLocale('ar') ? 'ملاحظات (اختياري)' : 'Notes (optional)' }}" style="min-height:60px"></textarea>
                <div class="ticket-btns">
                    <button type="submit" name="status" value="attending" class="ticket-btn yes">✅ {{ app()->isLocale('ar') ? 'حاضر' : 'ATTENDING' }}</button>
                    <button type="submit" name="status" value="declined" class="ticket-btn no">🙏 {{ app()->isLocale('ar') ? 'معذرة' : 'DECLINED' }}</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endif

{{-- ═══ FOOTER ═══ --}}
<footer class="footer">
    <div class="footer-credits">
        {{ $event->groom_name }}
        @if($event->bride_name) &amp; {{ $event->bride_name }} @endif
    </div>
    <div class="footer-year">{{ $event->event_date->format('Y') }}</div>
    <div class="footer-rule"></div>
    <p class="footer-credit">Farahna © {{ date('Y') }} · {{ app()->isLocale('ar') ? 'فيلم الحياة' : 'The Film of Life' }}</p>
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
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك 🎬';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
    @if(session('rsvp_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم تسجيل ردك 🎫';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
})();
</script>
@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
