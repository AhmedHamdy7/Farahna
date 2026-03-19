{{--
  petal-blush — Engagement celebration template
  Vibe: soft, feminine, romantic, dreamy
  Colors: dusty rose #c9748a, mauve #a85b7a, blush #f7e8ee, sage #8aab9b, champagne #e8d5c4
  Fonts: Cormorant Garamond (headings) + Tajawal (body)
--}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->groom_name }} & {{ $event->bride_name }} – خطوبة مباركة 💍</title>
@include('partials.og-meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --rose:      #c9748a;
    --mauve:     #a85b7a;
    --deeprose:  #8b3d5a;
    --blush:     #f7e8ee;
    --blush2:    #f0dae4;
    --sage:      #8aab9b;
    --champagne: #e8d5c4;
    --warm:      #f9f5f1;
    --dark:      #3b2535;
    --muted:     #8a7080;
    --pb-accent:   #c9748a;
    --pb-btn-text: #fff;
    --map-bg: #fff5f7; --map-text: #3d2235; --map-accent: #c9748a;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Tajawal', sans-serif;
    background: var(--warm);
    color: var(--dark);
    overflow-x: hidden;
}

/* ─── Floating Petals ─── */
.petals-bg {
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none; z-index: 0;
    overflow: hidden;
}
.petal {
    position: absolute;
    top: -60px;
    opacity: 0;
    animation: petalFall ease-in-out infinite;
}
.petal::before {
    content: '';
    display: block;
    border-radius: 50% 0 50% 0;
    background: linear-gradient(135deg, rgba(201,116,138,.5), rgba(240,218,228,.6));
}
@@keyframes petalFall {
    0%   { transform: translateY(0) rotate(0deg) translateX(0); opacity: 0; }
    10%  { opacity: .8; }
    90%  { opacity: .4; }
    100% { transform: translateY(110vh) rotate(200deg) translateX(40px); opacity: 0; }
}


/* ─── Hero ─── */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    background: linear-gradient(170deg, #fff5f8 0%, var(--blush) 40%, #fdf0f8 70%, #f5ede8 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 5rem 1.5rem 4rem;
    overflow: hidden;
}

/* Decorative watercolor rings */
.hero-ring {
    position: absolute;
    border-radius: 50%;
    border: 1px solid rgba(201,116,138,.15);
    animation: expandRing 5s ease-out infinite;
}
.hero-ring:nth-child(1) { width: 300px; height: 300px; animation-delay: 0s; }
.hero-ring:nth-child(2) { width: 480px; height: 480px; animation-delay: 1s; }
.hero-ring:nth-child(3) { width: 660px; height: 660px; animation-delay: 2s; }
@@keyframes expandRing {
    0%   { opacity: .6; transform: scale(.9); }
    100% { opacity: 0;  transform: scale(1.1); }
}

.hero-diamond {
    font-size: 4.5rem;
    margin-bottom: 1.5rem;
    animation: twinkle 3s ease-in-out infinite;
    filter: drop-shadow(0 8px 20px rgba(201,116,138,.4));
    position: relative; z-index: 2;
}
@@keyframes twinkle {
    0%,100% { transform: scale(1) rotate(-5deg); }
    50%      { transform: scale(1.1) rotate(5deg); }
}

.hero-label {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic; font-size: 1.1rem;
    color: var(--rose); letter-spacing: .12em;
    margin-bottom: 1.25rem;
    position: relative; z-index: 2;
}

.hero-names {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: center;
    gap: 1.5rem; flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.hero-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(3rem, 8vw, 5.5rem);
    font-weight: 300; color: var(--deeprose);
    line-height: 1; letter-spacing: -.01em;
}
.hero-and {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic; font-size: 2rem; font-weight: 300;
    color: var(--rose); opacity: .8;
}

.hero-tagline {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic; font-size: 1.35rem; font-weight: 300;
    color: var(--muted); margin-bottom: 2rem;
    position: relative; z-index: 2;
}

.hero-date-wrap {
    position: relative; z-index: 2;
    display: inline-flex; align-items: center; gap: .75rem;
    border: 1px solid rgba(201,116,138,.4);
    border-radius: 50px; padding: .7rem 2rem;
    background: rgba(255,255,255,.7);
    backdrop-filter: blur(4px);
    font-size: .95rem; color: var(--dark); font-weight: 500;
}

.hero-floral {
    position: absolute; font-size: 3rem; opacity: .2;
    animation: sway 6s ease-in-out infinite;
    user-select: none; pointer-events: none;
}
@@keyframes sway {
    0%,100% { transform: rotate(-10deg); }
    50%      { transform: rotate(10deg); }
}
.hf1 { top: 5%; right: 3%; animation-duration: 7s; }
.hf2 { top: 10%; left: 4%; animation-direction: reverse; animation-duration: 9s; font-size: 2.5rem; }
.hf3 { bottom: 15%; right: 5%; animation-duration: 11s; }
.hf4 { bottom: 8%; left: 6%; animation-direction: reverse; font-size: 2rem; }

/* ─── Divider ─── */
.floral-divider {
    text-align: center; padding: 1.5rem;
    color: var(--rose); font-size: 1.5rem;
    letter-spacing: 1rem; opacity: .5;
    position: relative; z-index: 1;
}

/* ─── Section ─── */
.section { position: relative; z-index: 1; padding: 5rem 1.5rem; }
.section-inner { max-width: 840px; margin: 0 auto; }
.section-header { text-align: center; margin-bottom: 3rem; }
.section-tag {
    display: inline-block;
    font-family: 'Cormorant Garamond', serif;
    font-style: italic; font-size: .9rem;
    color: var(--rose); letter-spacing: .12em;
    margin-bottom: .4rem;
}
.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 4vw, 2.4rem);
    font-weight: 400; color: var(--deeprose);
    margin-bottom: .5rem;
}
.section-line {
    width: 60px; height: 1px; margin: 0 auto;
    background: linear-gradient(90deg, transparent, var(--rose), transparent);
}

/* ─── Countdown ─── */
.countdown-bg {
    background: linear-gradient(135deg, var(--deeprose) 0%, var(--mauve) 100%);
    color: #fff;
}
.countdown-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; max-width: 560px; margin: 0 auto; }
.count-box {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 12px; padding: 1.5rem .5rem;
    text-align: center;
}
.count-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.8rem; line-height: 1;
    display: block;
}
.count-label { font-size: .72rem; font-weight: 300; opacity: .7; margin-top: .2rem; letter-spacing: .08em; }

/* ─── Details ─── */
.details-box {
    background: #fff;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 8px 30px rgba(59,37,53,.06);
    border: 1px solid rgba(201,116,138,.15);
    position: relative; overflow: hidden;
}
.details-box::before {
    content: '💍';
    position: absolute; top: -20px; left: 50%;
    transform: translateX(-50%);
    font-size: 3rem; opacity: .06;
}
.detail-item {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(201,116,138,.1);
}
.detail-item:last-child { border-bottom: none; }
.detail-icon {
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--blush); display: flex; align-items: center;
    justify-content: center; font-size: 1.15rem; flex-shrink: 0;
}
.detail-lbl { font-size: .78rem; color: var(--muted); margin-bottom: .15rem; letter-spacing: .04em; }
.detail-val { font-size: 1rem; font-weight: 600; color: var(--dark); }

/* ─── Gallery ─── */
.gallery-section { background: linear-gradient(160deg, var(--blush), #fdf5f5); }
.gallery-carousel { position: relative; }
.gallery-track-wrap { overflow: hidden; border-radius: 20px; box-shadow: 0 12px 40px rgba(59,37,53,.12); }
.gallery-track { display: flex; transition: transform .6s cubic-bezier(.77,0,.175,1); }
.gallery-slide {
    min-width: 100%; aspect-ratio: 16/9;
    background: var(--blush); overflow: hidden; cursor: zoom-in;
}
.gallery-slide img { width: 100%; height: 100%; object-fit: cover; }
.gallery-placeholder {
    width: 100%; height: 100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    font-size: 3.5rem; gap: .5rem;
    background: linear-gradient(135deg, var(--blush), var(--blush2));
}
.gallery-placeholder span { font-size: .85rem; color: var(--muted); font-weight: 500; }
.carousel-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.92); border: 1.5px solid rgba(201,116,138,.3);
    color: var(--rose); font-size: 1.2rem; cursor: pointer; z-index: 10;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; box-shadow: 0 4px 16px rgba(0,0,0,.1);
}
.carousel-btn:hover { background: var(--rose); color: #fff; border-color: var(--rose); }
.carousel-btn.prev { right: -16px; }
.carousel-btn.next { left: -16px; }
.carousel-dots { display: flex; justify-content: center; gap: .5rem; margin-top: 1rem; }
.carousel-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(201,116,138,.25); cursor: pointer; transition: all .3s; }
.carousel-dot.active { background: var(--rose); transform: scale(1.4); }

/* ─── Lightbox ─── */
.lightbox {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(30,10,20,.93);
    align-items: center; justify-content: center;
}
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 8px; }
.lb-close {
    position: absolute; top: 1.25rem; right: 1.25rem;
    background: none; border: none; color: rgba(255,255,255,.7);
    font-size: 1.8rem; cursor: pointer; transition: color .2s;
}
.lb-close:hover { color: #fff; }

/* ─── Wishes ─── */
.wishes-list { display: flex; flex-direction: column; gap: 1rem; }
.wish-card {
    background: #fff; border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(201,116,138,.15);
    position: relative; overflow: hidden;
    transition: box-shadow .2s;
}
.wish-card::before {
    content: '❝'; position: absolute; top: .5rem; left: 1rem;
    font-size: 3rem; color: rgba(201,116,138,.1);
    font-family: 'Cormorant Garamond', serif; line-height: 1;
}
.wish-card:hover { box-shadow: 0 8px 24px rgba(59,37,53,.08); }
.wish-meta { display: flex; justify-content: space-between; margin-bottom: .4rem; }
.wish-name { font-weight: 700; font-size: .9rem; color: var(--deeprose); }
.wish-time { font-size: .72rem; color: var(--muted); }
.wish-text { font-size: .9rem; line-height: 1.65; color: #5a4550; }

.wish-form-card {
    background: linear-gradient(160deg, #fff, var(--blush));
    border: 1px solid rgba(201,116,138,.25);
    border-radius: 20px; padding: 2rem;
    margin-top: 2rem;
}
.wish-form-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; color: var(--deeprose); margin-bottom: 1.25rem;
}
.form-row { display: grid; gap: 1rem; grid-template-columns: 1fr 1fr; margin-bottom: 1rem; }
@media(max-width:600px){ .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; border: 1.5px solid rgba(201,116,138,.25); border-radius: 10px;
    padding: .75rem 1rem; font-family: 'Tajawal', sans-serif;
    font-size: .9rem; background: rgba(255,255,255,.8); color: var(--dark);
    transition: border-color .2s;
}
.form-input:focus, .form-textarea:focus {
    outline: none; border-color: var(--rose);
    box-shadow: 0 0 0 3px rgba(201,116,138,.12);
}
.form-textarea { resize: vertical; min-height: 90px; }
.form-submit {
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    color: #fff; border: none; border-radius: 10px;
    padding: .8rem 2rem; font-family: 'Tajawal', sans-serif;
    font-size: .95rem; font-weight: 600; cursor: pointer;
    transition: all .2s; box-shadow: 0 4px 15px rgba(201,116,138,.3);
}
.form-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(201,116,138,.45); }

/* ─── RSVP ─── */
.rsvp-section { background: linear-gradient(160deg, #fdf5ef, var(--blush)); }
.rsvp-card {
    background: #fff; border-radius: 20px;
    padding: 2.5rem; text-align: center;
    box-shadow: 0 10px 36px rgba(59,37,53,.08);
    border: 1px solid rgba(201,116,138,.15);
    max-width: 500px; margin: 0 auto;
}
.rsvp-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 400; color: var(--deeprose); margin-bottom: .4rem;
}
.rsvp-sub { color: var(--muted); font-size: .88rem; margin-bottom: 2rem; }
.rsvp-choices { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }
.rsvp-choice {
    border: 1.5px solid rgba(201,116,138,.3); border-radius: 10px;
    padding: .85rem; font-family: 'Tajawal', sans-serif;
    font-size: .9rem; font-weight: 600; cursor: pointer; background: #fff;
    color: var(--muted); transition: all .2s;
}
.rsvp-choice.yes:hover { background: linear-gradient(135deg,var(--rose),var(--mauve)); color:#fff; border-color:var(--rose); }
.rsvp-choice.no:hover  { background: #f5f5f5; color: #888; border-color: #ccc; }

/* ─── Footer ─── */
.footer {
    background: var(--deeprose);
    color: rgba(255,255,255,.85); text-align: center;
    padding: 4rem 1.5rem 3rem;
    position: relative; overflow: hidden;
}
.footer::before {
    content: '💍';
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    font-size: 14rem; opacity: .04;
    pointer-events: none;
}
.footer-names {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.2rem; font-weight: 300;
    margin-bottom: .5rem; position: relative;
}
.footer-tag {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic; font-size: 1.1rem;
    color: rgba(255,255,255,.6); margin-bottom: 2rem; position: relative;
}
.footer-credit { font-size: .7rem; color: rgba(255,255,255,.2); position: relative; }

/* ─── Flash ─── */
.flash { display:none; position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
    background:#fff; border-right:4px solid var(--rose); border-radius:12px;
    padding:.85rem 1.5rem; box-shadow:0 8px 30px rgba(0,0,0,.1);
    font-weight:600; font-size:.9rem; color:var(--dark);
    animation: slideIn .4s ease;
}
@@keyframes slideIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:none} }

@media(max-width:640px){
    .countdown-grid { grid-template-columns: repeat(2,1fr); }
    .hero-names { gap: .75rem; }
    .hero-name { font-size: 3rem; }
    .carousel-btn.prev { right: -8px; }
    .carousel-btn.next { left: -8px; }
}
</style>
</head>
<body>

<!-- Floating petals -->
<div class="petals-bg" id="petalsBg"></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

<!-- ─── HERO ─── -->
<section class="hero">
    <div class="hero-ring"></div>
    <div class="hero-ring"></div>
    <div class="hero-ring"></div>

    <div class="hero-floral hf1">🌸</div>
    <div class="hero-floral hf2">🌺</div>
    <div class="hero-floral hf3">🌹</div>
    <div class="hero-floral hf4">💐</div>

    <div class="hero-diamond">💍</div>

    <p class="hero-label">— دعوة خطوبة —</p>

    <div class="hero-names">
        <span class="hero-name">{{ $event->groom_name }}</span>
        <span class="hero-and">&amp;</span>
        <span class="hero-name">{{ $event->bride_name }}</span>
    </div>

    <p class="hero-tagline">بدأت قصتنا... ويسعدنا أن تكونوا معنا في هذه اللحظة الجميلة</p>

    <div class="hero-date-wrap">
        🌸
        @php
            try { echo \Carbon\Carbon::parse($event->event_date)->locale('ar')->isoFormat('dddd، D MMMM YYYY'); }
            catch(\Exception $e) { echo $event->event_date; }
        @endphp
    </div>
</section>

<div class="floral-divider">✿ · ✿ · ✿</div>

<!-- ─── COUNTDOWN ─── -->
<section class="section countdown-bg">
    <div class="section-inner">
        <div class="section-header">
            <p class="section-tag" style="color:rgba(255,255,255,.6);">يوم الخطوبة</p>
            <h2 class="section-title" style="color:#fff;font-family:'Cormorant Garamond',serif;font-weight:300;">العد التنازلي</h2>
        </div>
        <div class="countdown-grid">
            <div class="count-box"><span class="count-num" id="cd-days">--</span><div class="count-label">يوم</div></div>
            <div class="count-box"><span class="count-num" id="cd-hours">--</span><div class="count-label">ساعة</div></div>
            <div class="count-box"><span class="count-num" id="cd-mins">--</span><div class="count-label">دقيقة</div></div>
            <div class="count-box"><span class="count-num" id="cd-secs">--</span><div class="count-label">ثانية</div></div>
        </div>
    </div>
</section>

<div class="floral-divider">✿ · ✿ · ✿</div>

<!-- ─── DETAILS ─── -->
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <p class="section-tag">تفاصيل الاحتفال</p>
            <h2 class="section-title">موعد الفرحة</h2>
            <div class="section-line"></div>
        </div>
        <div class="details-box">
            <div class="detail-item">
                <div class="detail-icon">📅</div>
                <div>
                    <p class="detail-lbl">التاريخ</p>
                    <p class="detail-val">
                        @php
                            try { echo \Carbon\Carbon::parse($event->event_date)->locale('ar')->isoFormat('dddd، D MMMM YYYY'); }
                            catch(\Exception $e) { echo $event->event_date; }
                        @endphp
                    </p>
                </div>
            </div>
            @if($event->event_time)
            <div class="detail-item">
                <div class="detail-icon">🕐</div>
                <div>
                    <p class="detail-lbl">الوقت</p>
                    <p class="detail-val">{{ $event->event_time }}</p>
                </div>
            </div>
            @endif
            @if($event->venue_name)
            <div class="detail-item">
                <div class="detail-icon">📍</div>
                <div>
                    <p class="detail-lbl">المكان</p>
                    <p class="detail-val">{{ $event->venue_name }}</p>
                    @if($event->venue_address)<p style="font-size:.82rem;color:var(--muted);margin-top:.15rem;">{{ $event->venue_address }}</p>@endif
                </div>
            </div>
            @endif
            @if($event->venue_map_link)
            <div class="detail-item">
                <div class="detail-icon">🗺</div>
                <div>
                    <p class="detail-lbl">الموقع على الخريطة</p>
                    <a href="{{ $event->venue_map_link }}" target="_blank"
                       style="color:var(--rose);text-decoration:none;font-weight:600;font-size:.95rem;">
                        فتح الخريطة ↗
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- ─── GALLERY ─── -->
@php $gallery = $event->gallery ?? collect(); @endphp
@if($gallery->count() > 0 || (isset($isPreview) && $isPreview))
<section class="section gallery-section">
    <div class="section-inner">
        <div class="section-header">
            <p class="section-tag">ذكريات جميلة</p>
            <h2 class="section-title">صورنا معاً</h2>
            <div class="section-line"></div>
        </div>
        <div class="gallery-carousel">
            <div class="gallery-track-wrap">
                <div class="gallery-track" id="gTrack">
                    @if($gallery->count() > 0)
                        @foreach($gallery as $img)
                        <div class="gallery-slide">
                            <img src="{{ Storage::url($img->path) }}" alt="صورة {{ $loop->iteration }}"
                                 onclick="window.openLightbox(this.src)">
                        </div>
                        @endforeach
                    @else
                        <div class="gallery-slide"><div class="gallery-placeholder">🌸<span>لحظاتنا معاً</span></div></div>
                        <div class="gallery-slide"><div class="gallery-placeholder">💍<span>بداية قصتنا</span></div></div>
                        <div class="gallery-slide"><div class="gallery-placeholder">💕<span>ذكريات لا تُنسى</span></div></div>
                    @endif
                </div>
            </div>
            <button class="carousel-btn prev" onclick="window.gShift(-1)">›</button>
            <button class="carousel-btn next" onclick="window.gShift(1)">‹</button>
            <div class="carousel-dots" id="gDots"></div>
        </div>
    </div>
</section>
@endif

<div class="floral-divider">✿ · ✿ · ✿</div>

<!-- ─── GUESTBOOK ─── -->
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <p class="section-tag">دفتر التهاني</p>
            <h2 class="section-title">كلمات من القلب</h2>
            <div class="section-line"></div>
        </div>

        @php $wishes = $event->approvedWishes ?? collect(); @endphp
        @if($wishes->count() > 0)
        <div class="wishes-list">
            @foreach($wishes as $wish)
            <div class="wish-card">
                <div class="wish-meta">
                    <span class="wish-name">🌸 {{ $wish->guest_name }}</span>
                    <span class="wish-time">
                        @php try { echo \Carbon\Carbon::parse($wish->created_at)->diffForHumans(); } catch(\Exception $e) {} @endphp
                    </span>
                </div>
                <p class="wish-text">{{ $wish->message }}</p>
            </div>
            @endforeach
        </div>
        @endif

        @if(!isset($isPreview) || !$isPreview)
        <div class="wish-form-card">
            <p class="wish-form-title">✍️ اترك تهنئتك</p>
            <form method="POST" action="{{ route('invitation.wishes', $event) }}" id="wishForm">
                @csrf
                <div class="form-row">
                    <input type="text" name="guest_name" class="form-input" placeholder="اسمك" required>
                    <input type="text" name="guest_phone" class="form-input" placeholder="رقمك (اختياري)">
                </div>
                <textarea name="message" class="form-textarea" placeholder="اكتب كلمة حلوة 💕" required></textarea>
                <div style="margin-top:1rem;">
                    <button type="submit" class="form-submit">إرسال التهنئة 💍</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</section>

<!-- ─── RSVP ─── -->
@if(!isset($isPreview) || !$isPreview)
<section class="section rsvp-section">
    <div class="section-inner">
        <div class="section-header">
            <p class="section-tag">حضورك يسعدنا</p>
            <h2 class="section-title">تأكيد المشاركة</h2>
            <div class="section-line"></div>
        </div>
        <div class="rsvp-card">
            <h3 class="rsvp-title">هل ستحضر؟</h3>
            <p class="rsvp-sub">أخبرنا حتى نستعد لاستقبالك</p>
            <form method="POST" action="{{ route('invitation.rsvp', $event) }}" id="rsvpForm">
                @csrf
                <input type="text" name="guest_name" class="form-input" style="margin-bottom:1rem;" placeholder="اسمك" required>
                <div class="rsvp-choices">
                    <button type="submit" name="status" value="attending" class="rsvp-choice yes">✅ بالتأكيد</button>
                    <button type="submit" name="status" value="declined" class="rsvp-choice no">🙏 معذرة</button>
                </div>

                <div class="form-group">
                    <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                </div>
            </form>
        </div>
    </div>
</section>
@endif

<!-- ─── FOOTER ─── -->
<footer class="footer">
    <div class="footer-names">{{ $event->groom_name }} &amp; {{ $event->bride_name }}</div>
    <p class="footer-tag">يبدأ الحلم...</p>
    <div style="font-size:1.8rem;margin:1.5rem auto;opacity:.6;">🌸 💍 🌸</div>
    <p class="footer-credit">Farahna © {{ date('Y') }}</p>
</footer>

<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <button class="lb-close" onclick="document.getElementById('lightbox').classList.remove('open')">✕</button>
    <img id="lbImg" src="" alt="">
</div>

<!-- Flash -->
<div class="flash" id="flash"></div>

<script>
(function () {
    // ── Floating Petals ────────────────────────────────────────────────────
    var bg = document.getElementById('petalsBg');
    for (var i = 0; i < 25; i++) {
        var el = document.createElement('div');
        el.className = 'petal';
        var sz = 8 + Math.random() * 14;
        el.style.cssText = 'left:' + Math.random()*100 + '%;animation-delay:' + Math.random()*12 + 's;animation-duration:' + (7+Math.random()*8) + 's;';
        el.innerHTML = '<div style="width:'+sz+'px;height:'+(sz*.7)+'px;background:linear-gradient(135deg,rgba(201,116,138,'+(0.3+Math.random()*.3)+'),rgba(247,232,238,'+(0.4+Math.random()*.4)+'));border-radius:50% 0 50% 0;transform:rotate('+Math.random()*360+'deg);"></div>';
        bg.appendChild(el);
    }

    // ── Countdown ──────────────────────────────────────────────────────────
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

    // ── Gallery Carousel ──────────────────────────────────────────────────
    var track  = document.getElementById('gTrack');
    var dotsEl = document.getElementById('gDots');
    if (track) {
        var slides = track.children.length, cur = 0;
        for (var d = 0; d < slides; d++) {
            var dot = document.createElement('div');
            dot.className = 'carousel-dot' + (d===0 ? ' active' : '');
            dot.setAttribute('data-i', d);
            dot.onclick = function(){ window.gShift(parseInt(this.getAttribute('data-i')) - cur); };
            dotsEl && dotsEl.appendChild(dot);
        }
        window.gShift = function(by) {
            cur = (cur + by + slides) % slides;
            track.style.transform = 'translateX(' + (cur * 100) + '%)';
            (dotsEl ? dotsEl.querySelectorAll('.carousel-dot') : [])
                .forEach(function(d,i){ d.classList.toggle('active', i === cur); });
        };
        if (slides > 1) setInterval(function(){ window.gShift(1); }, 4500);
    }

    // ── Lightbox ─────────────────────────────────────────────────────────
    window.openLightbox = function(src) {
        document.getElementById('lbImg').src = src;
        document.getElementById('lightbox').classList.add('open');
    };
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') document.getElementById('lightbox').classList.remove('open');
    });

    // ── Flash ─────────────────────────────────────────────────────────────
    @if(session('wish_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك 💍';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
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
