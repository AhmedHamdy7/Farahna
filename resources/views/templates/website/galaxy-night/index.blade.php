<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->coupleName() }} – ليلة الأحلام</title>
    <meta property="og:title" content="{{ $event->coupleName() }}">
    <meta property="og:description" content="{{ $event->event_date->format('d F Y') }} · {{ $event->venue_name }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

        :root {
            --bg:      #050914;
            --bg2:     #08101e;
            --bg3:     #0d1828;
            --violet:  #7c3aed;
            --violet-l:#a78bfa;
            --teal:    #06b6d4;
            --teal-l:  #67e8f9;
            --champagne:#e8c78b;
            --champ-l: #f5e4bc;
            --text:    #e8e4f0;
            --muted:   #64748b;
            --border:  rgba(124,58,237,.2);
            --pb-accent:   #7c3aed;
            --pb-btn-text: #fff;
        }

        html { scroll-behavior:smooth; }
        body {
            font-family:'Tajawal', sans-serif;
            background:var(--bg);
            color:var(--text);
            overflow-x:hidden;
        }

        .preview-spacer { height:60px; }

        /* ─── STARFIELD ─── */
        .starfield {
            position:fixed; inset:0; z-index:0;
            pointer-events:none; overflow:hidden;
        }
        .star-dot {
            position:absolute; border-radius:50%;
            background:#fff;
            animation:twinkle var(--t,3s) var(--d,0s) infinite;
        }
        @keyframes twinkle {
            0%,100% { opacity:var(--min,.1); transform:scale(1); }
            50%      { opacity:1; transform:scale(1.3); }
        }
        .nebula {
            position:fixed; border-radius:50%; filter:blur(80px);
            pointer-events:none; z-index:0;
        }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh; position:relative; z-index:1;
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            text-align:center; padding:3rem 2rem;
        }
        .hero-eyebrow {
            font-family:'Cinzel', serif;
            font-size:.72rem; letter-spacing:.8em; text-transform:uppercase;
            color:var(--teal); margin-bottom:2.5rem;
            animation:fadeIn .8s .3s both;
        }
        .hero-orbit {
            position:relative; width:200px; height:200px;
            margin:0 auto 2.5rem;
            animation:fadeIn .8s .5s both;
        }
        .hero-orbit-ring {
            position:absolute; inset:0; border-radius:50%;
            border:1px solid rgba(124,58,237,.3);
            animation:orbit-spin 8s linear infinite;
        }
        .hero-orbit-ring::before {
            content:'✦'; position:absolute; top:-8px; left:50%; transform:translateX(-50%);
            color:var(--violet-l); font-size:.75rem;
        }
        .hero-orbit-ring2 {
            position:absolute; inset:20px; border-radius:50%;
            border:1px solid rgba(6,182,212,.2);
            animation:orbit-spin 12s linear infinite reverse;
        }
        .hero-orbit-ring2::before {
            content:'◆'; position:absolute; bottom:-6px; left:50%; transform:translateX(-50%);
            color:var(--teal); font-size:.6rem;
        }
        .hero-orbit-center {
            position:absolute; inset:35px; border-radius:50%;
            background:radial-gradient(circle, rgba(124,58,237,.15) 0%, transparent 70%);
            border:1px solid rgba(232,199,139,.15);
            display:flex; align-items:center; justify-content:center;
            font-size:2.5rem;
        }
        @keyframes orbit-spin { to { transform:rotate(360deg); } }

        .hero-names {
            font-family:'Cinzel', serif;
            font-size:clamp(2rem, 6vw, 4rem); font-weight:700;
            line-height:1.15; margin-bottom:1.25rem;
            background:linear-gradient(135deg, var(--champagne), var(--champ-l), var(--champagne));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text;
            animation:fadeIn .8s .7s both;
        }
        .hero-amp {
            display:block; font-style:italic;
            font-size:.5em; color:var(--violet-l); margin:.3rem 0;
            -webkit-text-fill-color:var(--violet-l);
        }
        .hero-date-row {
            display:inline-flex; align-items:center; gap:1rem;
            margin-top:2rem; padding:.75rem 2rem;
            border:1px solid var(--border); border-radius:2px;
            font-size:.82rem; letter-spacing:.25em;
            color:var(--teal); text-transform:uppercase;
            font-family:'Cinzel', serif;
            animation:fadeIn .8s 1s both;
        }
        .hero-date-row .sep { color:var(--violet-l); }

        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:none; } }

        /* ─── DIVIDER ─── */
        .cosmic-divider {
            display:flex; align-items:center; gap:1rem;
            margin:2.5rem auto; max-width:360px;
        }
        .cosmic-divider::before, .cosmic-divider::after {
            content:''; flex:1; height:1px;
            background:linear-gradient(90deg, transparent, var(--border), transparent);
        }
        .cosmic-divider span { color:var(--violet-l); font-size:1rem; }

        /* ─── SECTIONS ─── */
        section { padding:5rem 2rem; position:relative; z-index:1; }
        .section-inner { max-width:860px; margin:0 auto; }
        .section-eyebrow {
            font-family:'Cinzel', serif; font-size:.68rem;
            letter-spacing:.6em; text-transform:uppercase;
            color:var(--teal); display:block; margin-bottom:1rem;
        }
        .section-title {
            font-family:'Cinzel', serif;
            font-size:clamp(1.6rem, 3.5vw, 2.2rem);
            font-weight:600; color:var(--text); line-height:1.25;
        }
        section:nth-child(even) { background:linear-gradient(180deg, var(--bg2), var(--bg2)); }

        /* ─── COUNTDOWN ─── */
        .cd-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; max-width:580px; margin:3rem auto 0; }
        .cd-cell {
            text-align:center; padding:2rem .5rem;
            border:1px solid var(--border); border-radius:4px;
            background:rgba(124,58,237,.05);
            position:relative; overflow:hidden;
        }
        .cd-cell::after {
            content:''; position:absolute; bottom:0; left:0; right:0; height:1px;
            background:linear-gradient(90deg, transparent, var(--violet-l), transparent);
        }
        .cd-num {
            font-family:'Cinzel', serif; font-size:2.6rem; font-weight:700;
            color:var(--champagne); display:block; line-height:1;
            text-shadow:0 0 20px rgba(232,199,139,.4);
        }
        .cd-lbl { font-size:.65rem; letter-spacing:.2em; text-transform:uppercase; color:var(--muted); margin-top:.4rem; display:block; }

        /* ─── DETAILS ─── */
        .details-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.25rem; margin-top:2.5rem; }
        .detail-card {
            background:rgba(124,58,237,.06); border:1px solid var(--border);
            border-radius:6px; padding:1.5rem 1.25rem;
            display:flex; gap:1rem; align-items:flex-start;
            transition:border-color .3s, box-shadow .3s;
        }
        .detail-card:hover { border-color:var(--violet-l); box-shadow:0 0 20px rgba(124,58,237,.15); }
        .d-icon  { font-size:1.6rem; flex-shrink:0; }
        .d-label { font-size:.7rem; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); margin-bottom:.25rem; }
        .d-value { font-size:.95rem; color:var(--text); line-height:1.5; }
        .d-link  { color:var(--teal); text-decoration:none; font-size:.85rem; display:inline-block; margin-top:.3rem; }
        .d-link:hover { text-decoration:underline; }

        /* ─── GALLERY ─── */
        .gallery-carousel-wrap { display:flex; align-items:center; gap:.75rem; }
        .gallery-viewport { flex:1; overflow:hidden; border-radius:6px; }
        .gallery-track { display:flex; gap:.6rem; transition:transform .5s cubic-bezier(.4,0,.2,1); }
        .gallery-card { flex-shrink:0; border-radius:4px; overflow:hidden; cursor:pointer; border:1px solid var(--border); }
        .gallery-card img { width:100%; aspect-ratio:1; object-fit:cover; display:block; transition:transform .4s; }
        .gallery-card:hover img { transform:scale(1.05); }
        .gallery-btn {
            flex-shrink:0; width:44px; height:44px; border-radius:50%;
            border:1px solid var(--border); background:rgba(124,58,237,.1);
            color:var(--violet-l); cursor:pointer; transition:all .2s;
            display:flex; align-items:center; justify-content:center; font-size:1rem;
        }
        .gallery-btn:hover { background:var(--violet); color:#fff; border-color:var(--violet); }
        .gallery-btn:disabled { opacity:.3; pointer-events:none; }
        .gallery-dots { display:flex; justify-content:center; gap:.5rem; margin-top:1.25rem; }
        .gallery-dot { width:5px; height:5px; border-radius:50%; background:var(--border); cursor:pointer; transition:all .3s; }
        .gallery-dot.active { background:var(--violet-l); transform:scale(1.5); }

        /* ─── LIGHTBOX ─── */
        .lightbox { position:fixed; inset:0; background:rgba(0,0,0,.95); display:flex; align-items:center; justify-content:center; z-index:9999; opacity:0; pointer-events:none; transition:opacity .3s; }
        .lightbox.open { opacity:1; pointer-events:all; }
        .lightbox img { max-width:90vw; max-height:90vh; border-radius:4px; border:1px solid var(--border); }
        .lb-btn { position:absolute; background:rgba(124,58,237,.15); border:1px solid var(--border); color:var(--violet-l); cursor:pointer; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-size:1rem; transition:all .2s; }
        .lb-btn:hover { background:var(--violet); color:#fff; }
        .lb-close { top:1.5rem; right:1.5rem; }
        .lb-prev  { left:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-next  { right:1.5rem; top:50%; transform:translateY(-50%); }
        .lb-counter { position:absolute; bottom:1.5rem; left:50%; transform:translateX(-50%); color:var(--muted); font-size:.8rem; }

        /* ─── FORMS ─── */
        .f-label { display:block; font-size:.72rem; letter-spacing:.15em; text-transform:uppercase; color:var(--muted); margin-bottom:.4rem; }
        .f-input, .f-select, .f-textarea {
            width:100%; padding:.8rem 1rem;
            background:rgba(124,58,237,.06); border:1px solid var(--border);
            border-radius:4px; color:var(--text); font-family:inherit;
            font-size:.95rem; transition:border-color .2s; appearance:none; resize:vertical;
        }
        .f-input:focus, .f-select:focus, .f-textarea:focus { outline:none; border-color:var(--violet-l); }
        .f-select option { background:var(--bg2); }
        .f-error { color:#f87171; font-size:.8rem; margin-top:.3rem; }
        .f-group { margin-bottom:1.1rem; }
        .f-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }

        /* ─── WISHES ─── */
        .wish-card { background:rgba(124,58,237,.05); border:1px solid var(--border); border-radius:6px; padding:1.5rem; margin-bottom:1rem; }
        .wish-text { font-family:'Cinzel', serif; font-style:italic; font-size:.95rem; line-height:1.9; color:var(--text); margin-bottom:.75rem; }
        .wish-name { font-size:.8rem; color:var(--teal); font-weight:600; }
        .wish-time { font-size:.75rem; color:var(--muted); margin-inline-start:.75rem; }

        /* ─── BUTTON ─── */
        .btn-cosmic {
            display:inline-flex; align-items:center; justify-content:center; gap:.5rem;
            padding:.85rem 2.5rem; border-radius:4px; font-family:inherit;
            background:linear-gradient(135deg, var(--violet), #6d28d9);
            color:#fff; border:none; cursor:pointer; font-size:.9rem; font-weight:600;
            letter-spacing:.05em; transition:all .25s; width:100%;
        }
        .btn-cosmic:hover { background:linear-gradient(135deg, #8b5cf6, var(--violet)); box-shadow:0 0 30px rgba(124,58,237,.4); }

        /* ─── FOOTER ─── */
        footer { background:var(--bg); border-top:1px solid var(--border); text-align:center; padding:4rem 2rem; z-index:1; position:relative; }
        .footer-names { font-family:'Cinzel', serif; font-size:1.6rem; font-weight:600; color:var(--champagne); display:block; margin-bottom:.75rem; }

        @media (max-width:640px) {
            .cd-grid { grid-template-columns:repeat(2,1fr); }
            .f-grid2 { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

{{-- ─── Starfield BG ─── --}}
<div class="starfield" id="starfield"></div>
<div class="nebula" style="width:600px;height:600px;background:radial-gradient(circle,rgba(124,58,237,.08),transparent);top:-200px;left:-100px;"></div>
<div class="nebula" style="width:500px;height:500px;background:radial-gradient(circle,rgba(6,182,212,.06),transparent);bottom:-100px;right:-100px;"></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ─── HERO ─── --}}
<section class="hero">
    <p class="hero-eyebrow">دعوة زفاف ✦ Wedding Invitation</p>

    <div class="hero-orbit">
        <div class="hero-orbit-ring"></div>
        <div class="hero-orbit-ring2"></div>
        <div class="hero-orbit-center">💫</div>
    </div>

    <h1 class="hero-names">
        {{ $event->groom_name }}
        <span class="hero-amp">&</span>
        {{ $event->bride_name }}
    </h1>

    <div class="hero-date-row">
        <span>{{ $event->event_date->translatedFormat('d F') }}</span>
        <span class="sep">◆</span>
        <span>{{ $event->event_date->format('Y') }}</span>
        @if($event->event_time)
            <span class="sep">◆</span>
            <span>{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
        @endif
    </div>
</section>

{{-- ─── Countdown ─── --}}
<section style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">العد التنازلي</span>
        <h2 class="section-title">الوقت المتبقي</h2>
        <div class="cosmic-divider"><span>✦</span></div>

        <div class="cd-grid">
            <div class="cd-cell"><span class="cd-num" id="cd-days">00</span><span class="cd-lbl">يوم</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-hours">00</span><span class="cd-lbl">ساعة</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-mins">00</span><span class="cd-lbl">دقيقة</span></div>
            <div class="cd-cell"><span class="cd-num" id="cd-secs">00</span><span class="cd-lbl">ثانية</span></div>
        </div>
    </div>
</section>

{{-- ─── Details ─── --}}
<section style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">تفاصيل الحفل</span>
        <h2 class="section-title">معلومات المناسبة</h2>
        <div class="cosmic-divider"><span>✦</span></div>

        <div class="details-grid">
            <div class="detail-card">
                <span class="d-icon">📅</span>
                <div>
                    <p class="d-label">التاريخ</p>
                    <p class="d-value">{{ $event->event_date->translatedFormat('l، d F Y') }}</p>
                </div>
            </div>
            @if($event->event_time)
            <div class="detail-card">
                <span class="d-icon">⏰</span>
                <div>
                    <p class="d-label">الوقت</p>
                    <p class="d-value">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</p>
                </div>
            </div>
            @endif
            <div class="detail-card">
                <span class="d-icon">📍</span>
                <div>
                    <p class="d-label">المكان</p>
                    <p class="d-value">{{ $event->venue_name }}</p>
                    @if($event->venue_address)<p style="font-size:.82rem;color:var(--muted);margin-top:.2rem;">{{ $event->venue_address }}</p>@endif
                    @if($event->venue_map_link)<a href="{{ $event->venue_map_link }}" target="_blank" class="d-link">🗺 اعرض على الخريطة ←</a>@endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Gallery ─── --}}
@if($event->gallery->isNotEmpty())
<section style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">الصور</span>
        <h2 class="section-title">معرض الصور</h2>
        <div class="cosmic-divider"><span>✦</span></div>
        <div class="gallery-carousel-wrap">
            <button class="gallery-btn" id="gPrev" onclick="gShift(-1)">←</button>
            <div class="gallery-viewport"><div class="gallery-track" id="gTrack">
                @foreach($event->gallery as $i => $photo)
                    <div class="gallery-card" onclick="lbOpen({{ $i }})"><img src="{{ Storage::url($photo->image_path) }}" alt=""></div>
                @endforeach
            </div></div>
            <button class="gallery-btn" id="gNext" onclick="gShift(1)">→</button>
        </div>
        <div class="gallery-dots" id="gDots"></div>
    </div>
</section>
@endif

{{-- ─── Wishes ─── --}}
<section style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">كتاب التهاني</span>
        <h2 class="section-title">اكتب تهنئتك</h2>
        <div class="cosmic-divider"><span>✦</span></div>

        @if($event->approvedWishes->isNotEmpty())
        <div style="margin-bottom:2.5rem;text-align:right;max-width:620px;margin-left:auto;margin-right:auto;">
            @foreach($event->approvedWishes as $wish)
            <div class="wish-card">
                <p class="wish-text">{{ $wish->message }}</p>
                <div><span class="wish-time">{{ $wish->created_at->diffForHumans() }}</span><span class="wish-name">— {{ $wish->guest_name }}</span></div>
            </div>
            @endforeach
        </div>
        @endif

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.wishes', $event) }}" method="POST" style="max-width:560px;margin:0 auto;text-align:right;">
            @csrf
            @if(session('wish_success'))<div style="background:rgba(124,58,237,.15);border:1px solid var(--border);color:var(--violet-l);padding:1rem;border-radius:4px;margin-bottom:1rem;">✓ شكراً على تهنئتك!</div>@endif
            <div class="f-group"><label class="f-label">اسمك</label><input type="text" name="guest_name" class="f-input" value="{{ old('guest_name') }}" required></div>
            <div class="f-group"><label class="f-label">رسالتك</label><textarea name="message" class="f-textarea" rows="4" required></textarea></div>
            <button type="submit" class="btn-cosmic">💫 أرسل التهنئة</button>
        </form>
        @endif
    </div>
</section>

{{-- ─── RSVP ─── --}}
<section style="text-align:center;">
    <div class="section-inner">
        <span class="section-eyebrow">تأكيد الحضور</span>
        <h2 class="section-title">هل ستحضر؟</h2>
        <div class="cosmic-divider"><span>✦</span></div>

        @if(!($isPreview ?? false))
        <form action="{{ route('invitation.rsvp', $event) }}" method="POST" style="max-width:560px;margin:0 auto;text-align:right;">
            @csrf
            @if(session('rsvp_success'))<div style="background:rgba(6,182,212,.1);border:1px solid rgba(6,182,212,.3);color:var(--teal-l);padding:1rem;border-radius:4px;margin-bottom:1rem;">✓ تم تسجيل ردك بنجاح!</div>@endif
            <div class="f-grid2">
                <div class="f-group"><label class="f-label">الاسم</label><input type="text" name="guest_name" class="f-input" value="{{ old('guest_name') }}" required></div>
                <div class="f-group"><label class="f-label">الهاتف</label><input type="tel" name="phone" class="f-input" value="{{ old('phone') }}"></div>
            </div>
            <div class="f-grid2">
                <div class="f-group"><label class="f-label">الحضور</label>
                    <select name="attending" class="f-select">
                        <option value="yes">✅ سأحضر</option>
                        <option value="no">❌ لن أتمكن</option>
                        <option value="maybe">🤔 ربما</option>
                    </select>
                </div>
                <div class="f-group"><label class="f-label">المرافقين</label><input type="number" name="guests_count" class="f-input" value="{{ old('guests_count',1) }}" min="1" max="20"></div>
            </div>
            <button type="submit" class="btn-cosmic">🌌 تأكيد الحضور</button>
        </form>
        @else
        <p style="color:var(--muted);">نموذج الحضور معطّل في وضع المعاينة.</p>
        @endif
    </div>
</section>

{{-- ─── Footer ─── --}}
<footer>
    <span class="footer-names">{{ $event->coupleName() }}</span>
    <div class="cosmic-divider" style="margin:1.25rem auto;"><span>✦</span></div>
    <p style="font-size:.75rem;letter-spacing:.3em;text-transform:uppercase;color:var(--muted);">{{ $event->event_date->translatedFormat('d F Y') }}</p>
    @if($event->venue_name)<p style="margin-top:.5rem;font-size:.75rem;color:var(--muted);">{{ $event->venue_name }}</p>@endif
    <p style="margin-top:2rem;font-size:.7rem;opacity:.2;">Powered by Farahna</p>
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
// Starfield
(function(){
    var sf = document.getElementById('starfield');
    if(!sf) return;
    for(var i=0;i<120;i++){
        var s = document.createElement('div');
        s.className = 'star-dot';
        var size = Math.random()*2.5+.5;
        s.style.cssText = 'width:'+size+'px;height:'+size+'px;left:'+Math.random()*100+'%;top:'+Math.random()*100+'%;';
        s.style.setProperty('--t', (2+Math.random()*5)+'s');
        s.style.setProperty('--d', (Math.random()*6)+'s');
        s.style.setProperty('--min', (Math.random()*.15+.05)+'');
        sf.appendChild(s);
    }
})();

// Countdown
(function(){
    var t = new Date('{{ $event->event_date->format("Y-m-d") }}T{{ $event->event_time ?? "20:00:00" }}');
    function tick(){
        var diff = t - new Date(); if(diff<=0) return;
        function fmt(n){return String(n).padStart(2,'0');}
        document.getElementById('cd-days').textContent  = fmt(Math.floor(diff/86400000));
        document.getElementById('cd-hours').textContent = fmt(Math.floor(diff/3600000%24));
        document.getElementById('cd-mins').textContent  = fmt(Math.floor(diff/60000%60));
        document.getElementById('cd-secs').textContent  = fmt(Math.floor(diff/1000%60));
    }
    tick(); setInterval(tick,1000);
})();

// Gallery
(function(){
    var track=document.getElementById('gTrack'); if(!track) return;
    var dotsEl=document.getElementById('gDots'),GAP=10,page=0,perPg=4,cardW=0,timer=null;
    var cards=track.querySelectorAll('.gallery-card'),total=cards.length;
    window._lbImgs=Array.from(cards).map(function(c){return c.querySelector('img').src;});
    window._lbIdx=0; document.getElementById('lbTotal').textContent=total;
    function maxPage(){return Math.max(0,total-perPg);}
    function render(){
        track.style.transform='translateX(-'+(page*(cardW+GAP))+'px)';
        var p=document.getElementById('gPrev'),n=document.getElementById('gNext');
        if(p)p.disabled=(page===0); if(n)n.disabled=(page>=maxPage());
        if(!dotsEl)return; var pages=Math.ceil(total/perPg); dotsEl.innerHTML='';
        for(var i=0;i<pages;i++){var d=document.createElement('span');d.className='gallery-dot'+(i===Math.floor(page/perPg)?' active':'');(function(t){d.onclick=function(){go(t*perPg);};})(i);dotsEl.appendChild(d);}
    }
    function go(p){page=Math.max(0,Math.min(p,maxPage()));render();clearInterval(timer);timer=setInterval(autoNext,3200);}
    function autoNext(){page=(page>=maxPage())?0:page+1;render();}
    function setup(){var vw=track.parentElement.offsetWidth;perPg=vw<420?2:vw<640?3:4;cardW=(vw-GAP*(perPg-1))/perPg;cards.forEach(function(c){c.style.width=cardW+'px';});page=Math.min(page,maxPage());render();}
    window.gShift=function(dir){go(page+dir);};
    setup(); if(total>perPg)timer=setInterval(autoNext,3200);
    window.addEventListener('resize',setup);
    var sx=0;
    track.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;},{passive:true});
    track.addEventListener('touchend',function(e){var dx=e.changedTouches[0].clientX-sx;if(Math.abs(dx)>40)window.gShift(dx<0?1:-1);});
})();

function lbOpen(i){if(!window._lbImgs||!window._lbImgs.length)return;window._lbIdx=i;document.getElementById('lbImg').src=window._lbImgs[i];document.getElementById('lbCur').textContent=i+1;document.getElementById('lb').classList.add('open');document.body.style.overflow='hidden';}
function lbNav(dir){if(!window._lbImgs)return;window._lbIdx=(window._lbIdx+dir+window._lbImgs.length)%window._lbImgs.length;document.getElementById('lbImg').src=window._lbImgs[window._lbIdx];document.getElementById('lbCur').textContent=window._lbIdx+1;}
document.getElementById('lb').addEventListener('click',function(e){if(e.target===this){this.classList.remove('open');document.body.style.overflow='';}});
</script>
</body>
</html>
