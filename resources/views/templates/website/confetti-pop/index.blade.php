{{--
  confetti-pop — Birthday celebration template
  Vibe: loud, fun, colorful, confetti explosion energy
  Colors: multicolor — coral #ff6b6b, yellow #ffd93d, teal #6bcb77, purple #845ec2, blue #4d8af0
  Fonts: Fredoka One (display) + Tajawal (Arabic)
--}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $event->groom_name }} – عيد ميلاد سعيد 🎉</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

<style>
:root {
    --coral:   #ff6b6b;
    --yellow:  #ffd93d;
    --teal:    #6bcb77;
    --purple:  #845ec2;
    --blue:    #4d8af0;
    --pink:    #ff9ff3;
    --bg:      #fffef9;
    --dark:    #2d2d2d;
    --text:    #3d3d3d;
    --pb-accent:   #ff6b6b;
    --pb-btn-text: #fff;
    --map-bg: #fff5f5; --map-text: #222; --map-accent: #ff6b6b;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
    font-family: 'Tajawal', sans-serif;
    background: var(--bg);
    color: var(--text);
    overflow-x: hidden;
}

/* ─── Confetti Particles ─── */
.confetti-container {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.confetti-piece {
    position: absolute;
    top: -30px;
    width: 10px;
    height: 10px;
    border-radius: 2px;
    animation: confettiFall linear infinite;
}

@keyframes confettiFall {
    0%   { transform: translateY(-30px) rotate(0deg); opacity: 1; }
    100% { transform: translateY(110vh) rotate(720deg); opacity: .3; }
}


/* ─── Hero ─── */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    background: linear-gradient(160deg, #fff9f0 0%, #fff0f5 40%, #f0f9ff 70%, #f5f0ff 100%);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 4rem 1.5rem 3rem;
    overflow: hidden;
}

.hero-balloon {
    font-size: 6rem;
    animation: floatBalloon 3s ease-in-out infinite;
    display: block;
    margin-bottom: 1rem;
    filter: drop-shadow(0 10px 20px rgba(0,0,0,.15));
}
@keyframes floatBalloon {
    0%,100% { transform: translateY(0) rotate(-5deg); }
    50%      { transform: translateY(-20px) rotate(5deg); }
}

.hero-age-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, var(--yellow), var(--coral));
    color: #fff; font-family: 'Fredoka One', cursive;
    font-size: 2.5rem;
    box-shadow: 0 8px 30px rgba(255,107,107,.4);
    margin-bottom: 1.5rem;
    animation: spinBadge 8s linear infinite;
}
@keyframes spinBadge { to { transform: rotate(360deg); } }
.hero-age-inner {
    animation: spinBadge 8s linear infinite reverse;
}

.hero-eyebrow {
    font-size: .95rem; font-weight: 700; color: var(--coral);
    letter-spacing: .15em; text-transform: uppercase;
    margin-bottom: .5rem; opacity: .9;
}

.hero-name {
    font-family: 'Fredoka One', cursive;
    font-size: clamp(3.5rem, 10vw, 6rem);
    line-height: 1;
    background: linear-gradient(135deg, var(--coral), var(--purple), var(--blue));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    margin-bottom: .75rem;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,.1));
}

.hero-subtitle {
    font-size: 1.2rem; font-weight: 600;
    color: var(--purple);
    margin-bottom: 2rem;
}

.hero-date-pill {
    display: inline-flex; align-items: center; gap: .75rem;
    background: #fff;
    border: 2px solid;
    border-image: linear-gradient(90deg, var(--coral), var(--yellow)) 1;
    border-radius: 50px;
    padding: .65rem 1.5rem;
    font-size: .95rem; font-weight: 700; color: var(--dark);
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
}

.hero-deco {
    position: absolute;
    font-size: 3rem; opacity: .35;
    animation: spin 10s linear infinite;
    user-select: none; pointer-events: none;
}
@keyframes spin { to { transform: rotate(360deg); } }
.hero-deco.d1 { top: 8%; left: 5%; animation-duration: 12s; font-size: 2.5rem; }
.hero-deco.d2 { top: 15%; right: 8%; animation-direction: reverse; animation-duration: 9s; }
.hero-deco.d3 { bottom: 20%; left: 10%; animation-duration: 15s; font-size: 2rem; }
.hero-deco.d4 { bottom: 10%; right: 6%; animation-direction: reverse; }
.hero-deco.d5 { top: 40%; left: 2%; font-size: 1.8rem; animation-duration: 7s; }

/* ─── Section Wrapper ─── */
.section { position: relative; z-index: 1; padding: 5rem 1.5rem; }
.section-inner { max-width: 860px; margin: 0 auto; }

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}
.section-icon {
    font-size: 2.5rem; display: block; margin-bottom: .5rem;
    animation: bounce 2s ease-in-out infinite;
}
@keyframes bounce {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
}
.section-title {
    font-family: 'Fredoka One', cursive;
    font-size: 2rem; color: var(--dark);
    position: relative; display: inline-block;
}
.section-title::after {
    content: '';
    position: absolute; bottom: -6px; right: 0; left: 0;
    height: 4px; border-radius: 99px;
    background: linear-gradient(90deg, var(--coral), var(--yellow), var(--teal));
}

/* ─── Countdown ─── */
.countdown-bg {
    background: linear-gradient(135deg, var(--purple), #6c3eb4);
    color: #fff;
}
.countdown-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
    max-width: 600px; margin: 0 auto;
}
.count-box {
    background: rgba(255,255,255,.15);
    border: 2px solid rgba(255,255,255,.3);
    border-radius: 16px; padding: 1.5rem .75rem;
    text-align: center;
    backdrop-filter: blur(4px);
    transition: transform .3s;
}
.count-box:hover { transform: scale(1.05); }
.count-num {
    font-family: 'Fredoka One', cursive;
    font-size: 2.8rem; line-height: 1;
    display: block;
}
.count-label {
    font-size: .75rem; font-weight: 600;
    opacity: .75; margin-top: .25rem;
    letter-spacing: .05em;
}

/* ─── Details Card ─── */
.details-card {
    background: #fff;
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 10px 40px rgba(0,0,0,.08);
    border: 2px solid #f0f0f0;
}
.detail-row {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1.25rem 0;
    border-bottom: 1.5px dashed #f0f0f0;
}
.detail-row:last-child { border-bottom: none; }
.detail-icon-wrap {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.di-pink   { background: #fff0f5; }
.di-yellow { background: #fffbeb; }
.di-teal   { background: #f0fdf4; }
.di-purple { background: #faf5ff; }
.detail-label { font-size: .78rem; font-weight: 600; color: #aaa; margin-bottom: .2rem; }
.detail-value { font-size: 1rem; font-weight: 700; color: var(--dark); }

/* ─── Gallery ─── */
.gallery-section { background: linear-gradient(160deg, #fff9f0, #f0f9ff); }
.gallery-carousel { position: relative; }
.gallery-track-wrap { overflow: hidden; border-radius: 20px; }
.gallery-track { display: flex; transition: transform .5s cubic-bezier(.77,0,.175,1); will-change: transform; }
.gallery-slide {
    min-width: 100%; aspect-ratio: 16/9;
    background: #f5f5f5; position: relative; cursor: zoom-in;
    overflow: hidden;
}
.gallery-slide img { width: 100%; height: 100%; object-fit: cover; border-radius: 20px; }
.gallery-placeholder {
    width: 100%; height: 100%; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    font-size: 3.5rem; gap: .5rem; background: linear-gradient(135deg, #fff9f0, #fff0f5);
}
.gallery-placeholder span { font-size: .9rem; font-weight: 600; color: #bbb; }
.carousel-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 42px; height: 42px; border-radius: 50%;
    background: rgba(255,255,255,.95); border: 2px solid rgba(255,107,107,.3);
    color: var(--coral); font-size: 1.2rem; cursor: pointer; z-index: 10;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s; box-shadow: 0 4px 15px rgba(0,0,0,.15);
}
.carousel-btn:hover { background: var(--coral); color: #fff; border-color: var(--coral); }
.carousel-btn.prev { right: -16px; }
.carousel-btn.next { left: -16px; }
.carousel-dots { display: flex; justify-content: center; gap: .5rem; margin-top: 1rem; }
.carousel-dot { width: 10px; height: 10px; border-radius: 50%; background: #e5e7eb; cursor: pointer; transition: all .3s; }
.carousel-dot.active { background: var(--coral); transform: scale(1.3); }

/* ─── Lightbox ─── */
.lightbox {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.92); align-items: center; justify-content: center;
}
.lightbox.open { display: flex; }
.lightbox img { max-width: 92vw; max-height: 92vh; border-radius: 12px; }
.lb-close {
    position: absolute; top: 1.25rem; right: 1.25rem;
    background: none; border: none; color: #fff; font-size: 1.8rem; cursor: pointer;
}

/* ─── Guestbook ─── */
.wishes-list { display: flex; flex-direction: column; gap: 1rem; }
.wish-card {
    background: #fff; border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border-right: 4px solid;
    box-shadow: 0 4px 16px rgba(0,0,0,.06);
    transition: transform .2s;
}
.wish-card:hover { transform: translateX(-4px); }
.wish-card:nth-child(1) { border-color: var(--coral); }
.wish-card:nth-child(2) { border-color: var(--teal); }
.wish-card:nth-child(3) { border-color: var(--yellow); border-right-color: var(--yellow); }
.wish-card:nth-child(4n) { border-color: var(--purple); }
.wish-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: .5rem; }
.wish-name { font-weight: 800; font-size: .95rem; color: var(--dark); }
.wish-time { font-size: .75rem; color: #bbb; }
.wish-text { font-size: .9rem; line-height: 1.6; color: #555; }

/* Wish form */
.wish-form-card {
    background: linear-gradient(135deg, #fff9f0, #fff0f9);
    border: 2px dashed var(--coral);
    border-radius: 20px; padding: 2rem;
    margin-top: 2rem;
}
.wish-form-title { font-family: 'Fredoka One', cursive; font-size: 1.3rem; color: var(--dark); margin-bottom: 1.25rem; }
.form-row { display: grid; gap: 1rem; grid-template-columns: 1fr 1fr; margin-bottom: 1rem; }
@media(max-width:600px){ .form-row { grid-template-columns: 1fr; } }
.form-input, .form-textarea {
    width: 100%; border: 2px solid #e5e7eb; border-radius: 12px;
    padding: .75rem 1rem; font-family: 'Tajawal', sans-serif;
    font-size: .95rem; background: #fff; color: var(--dark);
    transition: border-color .2s;
}
.form-input:focus, .form-textarea:focus {
    outline: none; border-color: var(--coral);
    box-shadow: 0 0 0 3px rgba(255,107,107,.15);
}
.form-textarea { resize: vertical; min-height: 100px; }
.form-submit {
    background: linear-gradient(135deg, var(--coral), #ff4757);
    color: #fff; border: none; border-radius: 12px;
    padding: .85rem 2rem; font-family: 'Tajawal', sans-serif;
    font-size: 1rem; font-weight: 700; cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 15px rgba(255,107,107,.35);
}
.form-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,107,107,.5); }

/* ─── RSVP ─── */
.rsvp-section {
    background: linear-gradient(135deg, #ffd93d22, #6bcb7722, #ff6b6b22);
}
.rsvp-card {
    background: #fff; border-radius: 24px;
    padding: 2.5rem; text-align: center;
    box-shadow: 0 12px 40px rgba(0,0,0,.1);
    max-width: 540px; margin: 0 auto;
    border: 2px solid #f0f0f0;
}
.rsvp-title { font-family: 'Fredoka One', cursive; font-size: 1.8rem; margin-bottom: .5rem; color: var(--dark); }
.rsvp-sub { color: #888; font-size: .9rem; margin-bottom: 2rem; }
.rsvp-form .form-row { grid-template-columns: 1fr; }
.rsvp-choices { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }
.rsvp-choice {
    border: 2px solid #e5e7eb; border-radius: 12px;
    padding: .85rem; font-family: 'Tajawal', sans-serif;
    font-size: .9rem; font-weight: 600; cursor: pointer; background: #fff;
    color: var(--text); transition: all .2s;
}
.rsvp-choice:hover { border-color: var(--teal); color: var(--teal); background: #f0fdf4; }
.rsvp-choice.attending-btn:hover { border-color: var(--teal); color: var(--teal); }
.rsvp-choice.decline-btn:hover { border-color: var(--coral); color: var(--coral); background: #fff5f5; }

/* ─── Footer ─── */
.footer {
    background: var(--dark);
    color: #fff; text-align: center;
    padding: 3rem 1.5rem;
}
.footer-balloons { font-size: 2rem; margin-bottom: 1rem; letter-spacing: .5rem; }
.footer-name { font-family: 'Fredoka One', cursive; font-size: 1.8rem; margin-bottom: .35rem;
    background: linear-gradient(90deg, var(--coral), var(--yellow), var(--teal));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.footer-msg { color: rgba(255,255,255,.5); font-size: .85rem; }

/* ─── Flash alert ─── */
.flash { display:none; position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
    background:#fff; border-right:4px solid var(--teal); border-radius:12px;
    padding:.85rem 1.5rem; box-shadow:0 8px 30px rgba(0,0,0,.12);
    font-weight:600; font-size:.9rem; color:var(--dark);
    animation:slideIn .4s ease;
}
@keyframes slideIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:none} }

@media(max-width:640px){
    .countdown-grid { grid-template-columns: repeat(2, 1fr); }
    .hero-name { font-size: 3.5rem; }
    .carousel-btn.prev { right: -8px; }
    .carousel-btn.next { left: -8px; }
}
</style>
</head>
<body>

<!-- Confetti -->
<div class="confetti-container" id="confettiContainer"></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

<!-- ─── HERO ─── -->
<section class="hero">
    <div class="hero-deco d1">🎊</div>
    <div class="hero-deco d2">⭐</div>
    <div class="hero-deco d3">🎈</div>
    <div class="hero-deco d4">✨</div>
    <div class="hero-deco d5">🎁</div>

    <span class="hero-balloon">🎂</span>

    <p class="hero-eyebrow">Happy Birthday!</p>
    <h1 class="hero-name">{{ $event->groom_name }}</h1>
    <p class="hero-subtitle">🎉 يحتفل بعيد ميلاده 🎉</p>

    <div class="hero-date-pill">
        📅 &nbsp;
        @php
            try { echo \Carbon\Carbon::parse($event->event_date)->locale('ar')->isoFormat('dddd، D MMMM YYYY'); }
            catch(\Exception $e) { echo $event->event_date; }
        @endphp
    </div>
</section>

<!-- ─── COUNTDOWN ─── -->
<section class="section countdown-bg">
    <div class="section-inner">
        <div class="section-header">
            <span class="section-icon">⏰</span>
            <h2 class="section-title" style="color:#fff;">العد التنازلي للاحتفال</h2>
        </div>
        <div class="countdown-grid" id="countdownGrid">
            <div class="count-box"><span class="count-num" id="cd-days">--</span><div class="count-label">يوم</div></div>
            <div class="count-box"><span class="count-num" id="cd-hours">--</span><div class="count-label">ساعة</div></div>
            <div class="count-box"><span class="count-num" id="cd-mins">--</span><div class="count-label">دقيقة</div></div>
            <div class="count-box"><span class="count-num" id="cd-secs">--</span><div class="count-label">ثانية</div></div>
        </div>
    </div>
</section>

<!-- ─── DETAILS ─── -->
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <span class="section-icon">🎈</span>
            <h2 class="section-title">تفاصيل الحفل</h2>
        </div>
        <div class="details-card">
            <div class="detail-row">
                <div class="detail-icon-wrap di-yellow">📅</div>
                <div>
                    <p class="detail-label">التاريخ</p>
                    <p class="detail-value">
                        @php
                            try { echo \Carbon\Carbon::parse($event->event_date)->locale('ar')->isoFormat('dddd، D MMMM YYYY'); }
                            catch(\Exception $e) { echo $event->event_date; }
                        @endphp
                    </p>
                </div>
            </div>
            @if($event->event_time)
            <div class="detail-row">
                <div class="detail-icon-wrap di-pink">🕐</div>
                <div>
                    <p class="detail-label">الوقت</p>
                    <p class="detail-value">{{ $event->event_time }}</p>
                </div>
            </div>
            @endif
            @if($event->venue_name)
            <div class="detail-row">
                <div class="detail-icon-wrap di-teal">📍</div>
                <div>
                    <p class="detail-label">المكان</p>
                    <p class="detail-value">{{ $event->venue_name }}</p>
                    @if($event->venue_address)<p style="font-size:.85rem;color:#888;margin-top:.2rem;">{{ $event->venue_address }}</p>@endif
                </div>
            </div>
            @endif
            @if($event->venue_map_link)
            <div class="detail-row">
                <div class="detail-icon-wrap di-purple">🗺</div>
                <div>
                    <p class="detail-label">الموقع</p>
                    <a href="{{ $event->venue_map_link }}" target="_blank" class="detail-value"
                       style="color:var(--purple);text-decoration:none;">افتح على الخريطة ↗</a>
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
            <span class="section-icon">📸</span>
            <h2 class="section-title">الذكريات</h2>
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
                        <div class="gallery-slide"><div class="gallery-placeholder">🎉<span>ذكريات لا تُنسى</span></div></div>
                        <div class="gallery-slide"><div class="gallery-placeholder">🎂<span>لحظات سعيدة</span></div></div>
                        <div class="gallery-slide"><div class="gallery-placeholder">🎈<span>يوم خاص</span></div></div>
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

<!-- ─── GUESTBOOK ─── -->
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <span class="section-icon">💬</span>
            <h2 class="section-title">تهاني الأصدقاء</h2>
        </div>

        @php $wishes = $event->approvedWishes ?? collect(); @endphp
        @if($wishes->count() > 0)
        <div class="wishes-list">
            @foreach($wishes as $wish)
            <div class="wish-card">
                <div class="wish-meta">
                    <span class="wish-name">🎉 {{ $wish->guest_name }}</span>
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
            <p class="wish-form-title">🎊 اترك تهنئتك</p>
            <form method="POST" action="{{ route('invitation.wishes', $event) }}" id="wishForm">
                @csrf
                <div class="form-row">
                    <input type="text" name="guest_name" class="form-input" placeholder="اسمك" required>
                    <input type="text" name="guest_phone" class="form-input" placeholder="رقم هاتفك (اختياري)">
                </div>
                <textarea name="message" class="form-textarea" placeholder="اكتب تهنئتك هنا 🎂" required></textarea>
                <div style="margin-top:1rem;">
                    <button type="submit" class="form-submit">إرسال التهنئة 🎉</button>
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
            <span class="section-icon">✉️</span>
            <h2 class="section-title">هتيجي؟ 🎈</h2>
        </div>
        <div class="rsvp-card">
            <h3 class="rsvp-title">تأكيد الحضور</h3>
            <p class="rsvp-sub">عشان نتجهز صح، قولنا رأيك</p>
            <form method="POST" action="{{ route('invitation.rsvp', $event) }}" id="rsvpForm">
                @csrf
                <input type="text" name="guest_name" class="form-input" style="margin-bottom:1rem;" placeholder="اسمك" required>
                <div class="rsvp-choices">
                    <button type="submit" name="status" value="attending" class="rsvp-choice attending-btn">✅ هحضر</button>
                    <button type="submit" name="status" value="declined" class="rsvp-choice decline-btn">❌ معنديش</button>
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
    <div class="footer-balloons">🎈 🎊 🎉 🎂 🎁</div>
    <p class="footer-name">{{ $event->groom_name }}</p>
    <p class="footer-msg">يحتفل بعيد ميلاده بصحبتكم ❤️</p>
    <p style="margin-top:2rem;font-size:.7rem;color:rgba(255,255,255,.2);">Farahna © {{ date('Y') }}</p>
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
    // ── Confetti Generator ──────────────────────────────────────────────────
    var colors = ['#ff6b6b','#ffd93d','#6bcb77','#845ec2','#4d8af0','#ff9ff3','#ff9f43','#00d2d3'];
    var container = document.getElementById('confettiContainer');
    for (var i = 0; i < 60; i++) {
        var el = document.createElement('div');
        el.className = 'confetti-piece';
        var sz = 6 + Math.random() * 10;
        el.style.cssText = [
            'left:' + Math.random()*100 + '%',
            'width:' + sz + 'px',
            'height:' + sz + 'px',
            'background:' + colors[Math.floor(Math.random()*colors.length)],
            'border-radius:' + (Math.random() > .5 ? '50%' : '2px'),
            'animation-delay:' + (Math.random()*8) + 's',
            'animation-duration:' + (4 + Math.random()*6) + 's',
            'opacity:' + (.4 + Math.random()*.6)
        ].join(';');
        container.appendChild(el);
    }

    // ── Countdown ──────────────────────────────────────────────────────────
    var targetDate = new Date('{{ \Carbon\Carbon::parse($event->event_date)->toDateString() }} {{ $event->event_time ?? "20:00" }}');
    function updateCountdown() {
        var now = new Date(), diff = targetDate - now;
        if (diff <= 0) { ['days','hours','mins','secs'].forEach(function(k){ var el=document.getElementById('cd-'+k); if(el) el.textContent='0'; }); return; }
        var d = Math.floor(diff/86400000), h = Math.floor((diff%86400000)/3600000),
            m = Math.floor((diff%3600000)/60000), s = Math.floor((diff%60000)/1000);
        var el;
        if((el=document.getElementById('cd-days')))  el.textContent = d;
        if((el=document.getElementById('cd-hours'))) el.textContent = String(h).padStart(2,'0');
        if((el=document.getElementById('cd-mins')))  el.textContent = String(m).padStart(2,'0');
        if((el=document.getElementById('cd-secs')))  el.textContent = String(s).padStart(2,'0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // ── Gallery Carousel ──────────────────────────────────────────────────
    var track  = document.getElementById('gTrack');
    var dotsEl = document.getElementById('gDots');
    if (track) {
        var slides = track.children.length, cur = 0;
        for (var d = 0; d < slides; d++) {
            var dot = document.createElement('div');
            dot.className = 'carousel-dot' + (d === 0 ? ' active' : '');
            dot.setAttribute('data-i', d);
            dot.onclick = function(){ window.gShift(parseInt(this.getAttribute('data-i')) - cur); };
            dotsEl && dotsEl.appendChild(dot);
        }
        window.gShift = function(by) {
            cur = (cur + by + slides) % slides;
            track.style.transform = 'translateX(' + (cur * 100) + '%)';
            var dots = dotsEl ? dotsEl.querySelectorAll('.carousel-dot') : [];
            dots.forEach(function(d,i){ d.classList.toggle('active', i === cur); });
        };
        if (slides > 1) setInterval(function(){ window.gShift(1); }, 4000);
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
    (function(){var f=document.getElementById('flash');f.textContent='تم إرسال تهنئتك 🎉';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
    @if(session('rsvp_sent'))
    (function(){var f=document.getElementById('flash');f.textContent='تم تسجيل ردك 🎊';f.style.display='block';setTimeout(function(){f.style.display='none';},4000);})();
    @endif
})();
</script>
@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
