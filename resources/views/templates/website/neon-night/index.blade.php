<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->coupleName() }} – ليل النيون</title>
    <meta property="og:title" content="{{ $event->coupleName() }}">
    <meta property="og:description" content="{{ $event->event_date->format('d F Y') }} · {{ $event->venue_name }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        :root {
            --bg:      #06000e;
            --bg2:     #0a0018;
            --pink:    #ff0080;
            --blue:    #00d4ff;
            --yellow:  #f7ff00;
            --green:   #39ff14;
            --purple:  #bf00ff;
            --text:    #f0e8ff;
            --muted:   #8877aa;
            --pb-accent:   #ff0080;
            --pb-btn-text: #fff;
        }

        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; background:var(--bg); color:var(--text); overflow-x:hidden; }


        /* ─── ANIMATIONS ─── */
        @keyframes flicker {
            0%,18%,22%,25%,53%,57%,100% { opacity:1; }
            19%,24%,55% { opacity:.35; }
        }
        @keyframes flicker2 {
            0%,91%,95%,100% { opacity:1; }
            92%,94% { opacity:.25; }
        }
        @keyframes neon-pulse {
            0%,100% { box-shadow:0 0 8px var(--c),0 0 20px var(--c),0 0 40px var(--c); }
            50%     { box-shadow:0 0 4px var(--c),0 0 10px var(--c),0 0 20px var(--c); }
        }
        @keyframes grid-scroll {
            from { background-position:0 0; }
            to   { background-position:60px 60px; }
        }
        @keyframes scanline {
            from { transform:translateY(-100%); }
            to   { transform:translateY(120vh); }
        }
        @keyframes ticker {
            from { transform:translateX(0); }
            to   { transform:translateX(-50%); }
        }

        /* ─── HERO ─── */
        .hero-section {
            min-height:100vh;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            position:relative; overflow:hidden; background:var(--bg); padding:80px 20px;
        }
        .grid-floor {
            position:absolute; inset:0; pointer-events:none;
            background-image:
                linear-gradient(rgba(255,0,128,.07) 1px,transparent 1px),
                linear-gradient(90deg,rgba(255,0,128,.07) 1px,transparent 1px);
            background-size:60px 60px;
            animation:grid-scroll 5s linear infinite;
        }
        /* Perspective vanish at bottom */
        .grid-floor::after {
            content:''; position:absolute; bottom:0; left:0; right:0; height:50%;
            background:linear-gradient(transparent,var(--bg));
        }
        .scanline {
            position:fixed; left:0; right:0; height:3px; z-index:1; pointer-events:none;
            background:linear-gradient(90deg,transparent,rgba(0,212,255,.25),transparent);
            animation:scanline 4s linear infinite;
        }

        .neon-sign { position:relative; z-index:2; text-align:center; padding:0 20px; }
        .neon-frame {
            border:3px solid var(--blue); border-radius:8px; padding:32px 50px; position:relative;
            box-shadow:0 0 15px var(--blue),0 0 30px var(--blue),inset 0 0 15px rgba(0,212,255,.06);
            animation:neon-pulse 2s ease-in-out infinite; --c:var(--blue);
        }
        .neon-frame::before { content:'◆'; position:absolute; top:-9px; left:-9px; color:var(--yellow); font-size:12px; text-shadow:0 0 10px var(--yellow); }
        .neon-frame::after  { content:'◆'; position:absolute; bottom:-9px; right:-9px; color:var(--yellow); font-size:12px; text-shadow:0 0 10px var(--yellow); }

        .neon-pre {
            font-family:'Bebas Neue',cursive; font-size:clamp(13px,3vw,20px); letter-spacing:8px;
            color:var(--yellow); text-shadow:0 0 10px var(--yellow),0 0 20px var(--yellow);
            margin-bottom:16px; animation:flicker2 7s linear infinite;
        }
        .neon-names {
            font-family:'Bebas Neue',cursive; font-size:clamp(52px,12vw,120px);
            line-height:1; display:flex; align-items:center; justify-content:center; gap:20px; flex-wrap:wrap;
        }
        .nn-1 { color:var(--pink); text-shadow:0 0 10px var(--pink),0 0 30px var(--pink),0 0 60px var(--pink); animation:flicker 8s linear infinite; }
        .nn-amp { color:var(--yellow); font-size:.6em; text-shadow:0 0 10px var(--yellow),0 0 20px var(--yellow); }
        .nn-2 { color:var(--blue); text-shadow:0 0 10px var(--blue),0 0 30px var(--blue),0 0 60px var(--blue); animation:flicker 11s 4s linear infinite; }
        .neon-sub { font-size:clamp(13px,3vw,17px); color:rgba(240,232,255,.55); letter-spacing:4px; text-transform:uppercase; margin-top:20px; }
        .vip-badge {
            display:inline-flex; align-items:center; gap:8px; padding:8px 22px;
            border:1.5px solid var(--yellow); border-radius:2px; color:var(--yellow);
            font-family:'Bebas Neue',cursive; font-size:16px; letter-spacing:4px;
            text-shadow:0 0 10px var(--yellow); box-shadow:0 0 10px rgba(247,255,0,.25); margin-top:24px;
        }

        /* ─── SLOT MACHINE COUNTDOWN ─── */
        .countdown-section {
            padding:80px 20px; background:var(--bg2); text-align:center; position:relative; overflow:hidden;
        }
        .countdown-section::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(ellipse at 50% 100%,rgba(191,0,255,.12) 0%,transparent 60%);
        }
        .sec-neon-title {
            font-family:'Bebas Neue',cursive; font-size:clamp(28px,6vw,54px); letter-spacing:4px; margin-bottom:40px; position:relative; z-index:1;
        }
        .slot-machine { display:inline-flex; gap:16px; flex-wrap:wrap; justify-content:center; position:relative; z-index:1; }
        .slot-unit { display:flex; flex-direction:column; align-items:center; gap:12px; }
        .slot-window {
            width:88px; height:98px; background:#000;
            border:2px solid var(--c,var(--purple)); border-radius:6px; overflow:hidden; position:relative;
            box-shadow:0 0 15px var(--c,var(--purple)),inset 0 0 10px rgba(0,0,0,.8);
        }
        .slot-window::before { content:''; position:absolute; top:0; left:0; right:0; height:25px; background:linear-gradient(#000,transparent); z-index:2; }
        .slot-window::after  { content:''; position:absolute; bottom:0; left:0; right:0; height:25px; background:linear-gradient(transparent,#000); z-index:2; }
        .slot-num {
            width:100%; height:100%; display:flex; align-items:center; justify-content:center;
            font-family:'Bebas Neue',cursive; font-size:50px;
            color:var(--c,var(--purple)); text-shadow:0 0 20px var(--c,var(--purple));
        }
        .slot-lbl { font-family:'Bebas Neue',cursive; font-size:14px; letter-spacing:3px; color:var(--c,var(--purple)); }

        /* ─── BACKSTAGE PASS ─── */
        .details-section { padding:80px 20px; background:var(--bg); }
        .backstage-pass {
            max-width:680px; margin:0 auto; background:#0d0020;
            border:1px solid rgba(255,0,128,.3); border-radius:8px; overflow:hidden;
            box-shadow:0 0 40px rgba(255,0,128,.2); display:flex; flex-wrap:wrap;
        }
        .pass-main { flex:1; min-width:280px; padding:40px 32px; position:relative; }
        .pass-tear {
            width:2px;
            background:repeating-linear-gradient(180deg,rgba(255,0,128,.5) 0 8px,transparent 8px 16px);
            position:relative;
        }
        .pass-tear::before,.pass-tear::after { content:''; position:absolute; left:50%; transform:translateX(-50%); width:16px; height:16px; border-radius:50%; background:var(--bg); border:1px solid rgba(255,0,128,.3); }
        .pass-tear::before { top:-8px; } .pass-tear::after { bottom:-8px; }
        .pass-stub { width:120px; padding:40px 16px; background:rgba(255,0,128,.05); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:16px; }
        .pass-type { font-family:'Bebas Neue',cursive; font-size:11px; letter-spacing:3px; color:var(--pink); text-shadow:0 0 8px var(--pink); margin-bottom:4px; }
        .pass-event-name { font-family:'Bebas Neue',cursive; font-size:clamp(26px,5vw,40px); line-height:1.1; color:var(--pink); text-shadow:0 0 20px var(--pink); }
        .pass-names { font-size:17px; font-weight:700; color:var(--text); margin:12px 0; }
        .pass-row { display:flex; align-items:center; gap:10px; margin:10px 0; font-size:14px; color:rgba(240,232,255,.65); }
        .pass-row strong { color:var(--text); }
        .pass-barcode { margin-top:20px; font-size:34px; letter-spacing:-2px; color:rgba(255,255,255,.25); font-family:monospace; user-select:none; }
        .stub-inner { writing-mode:vertical-lr; text-orientation:mixed; transform:rotate(180deg); display:flex; flex-direction:column; align-items:center; gap:12px; }
        .stub-vip { font-family:'Bebas Neue',cursive; font-size:26px; letter-spacing:6px; color:var(--yellow); text-shadow:0 0 15px var(--yellow); }
        .stub-admit { font-size:11px; letter-spacing:3px; color:var(--muted); }
        .stub-num { font-family:'Bebas Neue',cursive; font-size:17px; color:var(--pink); }

        /* ─── POLAROID GALLERY ─── */
        .gallery-section { padding:80px 20px; background:var(--bg2); position:relative; overflow:hidden; }
        .polaroid-wall { max-width:920px; margin:0 auto; display:flex; flex-wrap:wrap; gap:28px; justify-content:center; align-items:flex-start; padding:20px; }
        .polaroid {
            background:#fff; padding:12px 12px 46px;
            box-shadow:4px 6px 20px rgba(0,0,0,.5),0 0 0 1px rgba(255,255,255,.08);
            transform:rotate(var(--pr,0deg));
            transition:transform .3s,box-shadow .3s,z-index .3s;
            cursor:pointer; position:relative; z-index:1;
        }
        .polaroid:hover { transform:rotate(0deg) scale(1.1); box-shadow:8px 12px 40px rgba(0,0,0,.7),0 0 20px var(--pink); z-index:20; }
        .pol-img { width:180px; height:180px; object-fit:cover; display:block; background:linear-gradient(135deg,#1a0030,#300060); }
        .pol-cap { position:absolute; bottom:12px; left:0; right:0; text-align:center; font-family:'Bebas Neue',cursive; font-size:13px; letter-spacing:2px; color:#333; }
        .polaroid::before { content:''; position:absolute; top:-10px; left:50%; transform:translateX(-50%); width:40px; height:16px; background:rgba(247,255,0,.4); border-radius:2px; }

        /* ─── GUESTBOOK ─── */
        .guest-section { padding:80px 20px; background:var(--bg); }
        .guest-wall { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }
        .guest-msg {
            background:#0d001f; border:1px solid rgba(0,212,255,.2); border-radius:6px; padding:20px;
            box-shadow:0 0 15px rgba(0,212,255,.06);
            transition:box-shadow .2s,border-color .2s;
        }
        .guest-msg:hover { border-color:var(--blue); box-shadow:0 0 20px rgba(0,212,255,.2); }
        .gm-text { font-size:14px; color:rgba(240,232,255,.8); line-height:1.7; }
        .gm-author { font-size:12px; color:var(--blue); margin-top:12px; text-shadow:0 0 6px var(--blue); letter-spacing:1px; }
        .guest-form { max-width:500px; margin:40px auto 0; }
        .gf-input {
            width:100%; padding:12px 16px; margin-bottom:12px;
            background:rgba(0,212,255,.05); border:1px solid rgba(0,212,255,.25); border-radius:4px;
            color:var(--text); font-family:'Tajawal',sans-serif; font-size:14px; outline:none; resize:none;
            transition:border-color .2s,box-shadow .2s;
        }
        .gf-input:focus { border-color:var(--blue); box-shadow:0 0 10px rgba(0,212,255,.25); }
        .gf-btn {
            width:100%; padding:14px; background:linear-gradient(135deg,var(--blue),var(--purple));
            color:#fff; border:none; border-radius:4px; font-family:'Tajawal',sans-serif;
            font-size:15px; font-weight:700; cursor:pointer; letter-spacing:1px;
            box-shadow:0 0 20px rgba(0,212,255,.3); transition:all .2s;
        }
        .gf-btn:hover { box-shadow:0 0 30px rgba(0,212,255,.5); transform:translateY(-2px); }

        /* ─── RSVP CONCERT TICKET ─── */
        .rsvp-section { padding:80px 20px; background:var(--bg2); position:relative; }
        .rsvp-section::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(ellipse at 50% 0%,rgba(0,212,255,.1) 0%,transparent 60%);
        }
        .concert-ticket {
            max-width:680px; margin:0 auto; background:#0a0018;
            border:2px solid var(--blue); border-radius:8px;
            box-shadow:0 0 30px rgba(0,212,255,.25),0 0 60px rgba(0,212,255,.08);
            overflow:hidden; position:relative; z-index:1;
        }
        .ticket-header {
            background:linear-gradient(135deg,rgba(0,212,255,.12),rgba(191,0,255,.12));
            padding:22px 32px; display:flex; justify-content:space-between; align-items:center;
            border-bottom:1px dashed rgba(0,212,255,.25);
        }
        .ticket-h-title { font-family:'Bebas Neue',cursive; font-size:clamp(20px,4vw,32px); color:var(--blue); text-shadow:0 0 15px var(--blue); letter-spacing:3px; }
        .ticket-h-event { font-size:13px; color:var(--muted); text-align:left; }
        .ticket-h-event strong { color:var(--text); }
        .ticket-body { padding:32px; }
        .neon-label { display:block; font-size:11px; letter-spacing:3px; color:var(--blue); margin-bottom:8px; text-transform:uppercase; text-shadow:0 0 8px var(--blue); }
        .neon-input {
            width:100%; padding:12px 16px; margin-bottom:20px;
            background:rgba(0,212,255,.05); border:1px solid rgba(0,212,255,.25); border-radius:4px;
            color:var(--text); font-family:'Tajawal',sans-serif; font-size:14px; outline:none;
            transition:border-color .2s,box-shadow .2s;
        }
        .neon-input:focus { border-color:var(--blue); box-shadow:0 0 10px rgba(0,212,255,.25); }
        .attend-group { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
        .attend-btn {
            flex:1; min-width:140px; padding:14px; background:transparent; border:1.5px solid;
            border-radius:4px; font-family:'Tajawal',sans-serif; font-size:14px; font-weight:700;
            cursor:pointer; transition:all .2s; text-align:center;
        }
        .attend-btn.yes { border-color:var(--green); color:var(--green); }
        .attend-btn.yes:hover,.attend-btn.yes.active { background:rgba(57,255,20,.12); box-shadow:0 0 15px rgba(57,255,20,.25); }
        .attend-btn.no  { border-color:var(--pink); color:var(--pink); }
        .attend-btn.no:hover,.attend-btn.no.active  { background:rgba(255,0,128,.12); box-shadow:0 0 15px rgba(255,0,128,.25); }
        .ticket-submit {
            width:100%; padding:16px; background:linear-gradient(135deg,var(--pink),var(--purple));
            color:#fff; border:none; border-radius:4px; font-family:'Tajawal',sans-serif;
            font-size:16px; font-weight:700; cursor:pointer; letter-spacing:2px;
            box-shadow:0 0 20px rgba(255,0,128,.35); transition:all .2s;
        }
        .ticket-submit:hover { box-shadow:0 0 30px rgba(255,0,128,.6); transform:translateY(-2px); }
        .ticket-success { text-align:center; padding:50px 20px; }

        /* ─── TICKER TAPE ─── */
        .ticker { overflow:hidden; background:#000; border-top:1px solid rgba(255,0,128,.2); border-bottom:1px solid rgba(255,0,128,.2); padding:12px 0; white-space:nowrap; }
        .ticker-inner { display:inline-block; animation:ticker 20s linear infinite; }
        .ticker-inner span { font-family:'Bebas Neue',cursive; font-size:15px; letter-spacing:4px; color:var(--pink); margin-left:60px; text-shadow:0 0 8px var(--pink); }

        /* ─── FOOTER ─── */
        .footer-section { padding:40px 20px; background:#000; text-align:center; border-top:1px solid rgba(255,0,128,.15); }
        .footer-neon { font-family:'Bebas Neue',cursive; font-size:28px; letter-spacing:6px; color:var(--pink); text-shadow:0 0 20px var(--pink); }

        @media (max-width:600px) {
            .backstage-pass { flex-direction:column; }
            .pass-tear { height:2px; width:100%; background:repeating-linear-gradient(90deg,rgba(255,0,128,.5) 0 8px,transparent 8px 16px); }
            .pass-stub { width:100%; flex-direction:row; }
            .stub-inner { writing-mode:horizontal-tb; transform:none; flex-direction:row; }
        }
    </style>
</head>
<body x-data="{
    rsvpSent:false, attendance:'',
    days:0, hours:0, mins:0, secs:0,
    initCountdown(t){ const tick=()=>{ const d=new Date(t)-new Date(); if(d<=0)return; this.days=Math.floor(d/864e5); this.hours=Math.floor(d%864e5/36e5); this.mins=Math.floor(d%36e5/6e4); this.secs=Math.floor(d%6e4/1e3); }; tick(); setInterval(tick,1000); }
}" x-init="initCountdown('{{ $event->event_date->format('Y-m-d') }}')">

<div class="scanline"></div>

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ── HERO ── --}}
<section class="hero-section">
    <div class="grid-floor"></div>
    <div class="neon-sign">
        <div class="neon-pre">✦ YOU ARE CORDIALLY INVITED ✦</div>
        <div class="neon-frame">
            <div class="neon-names">
                <span class="nn-1">{{ $event->groom_name }}</span>
                <span class="nn-amp">&</span>
                <span class="nn-2">{{ $event->bride_name }}</span>
            </div>
        </div>
        <div class="neon-sub">حفل الزفاف · {{ $event->event_date->translatedFormat('d F Y') }}</div>
        <div><span class="vip-badge">⚡ VIP INVITATION ⚡</span></div>
    </div>
</section>

{{-- ── TICKER ── --}}
<div class="ticker">
    <div class="ticker-inner">
        @for($i=0;$i<2;$i++)
        <span>⚡ {{ $event->coupleName() }}</span>
        <span>· {{ $event->event_date->translatedFormat('d F Y') }}</span>
        <span>· {{ $event->venue_name }}</span>
        <span>· VIP WEDDING NIGHT</span>
        <span>· {{ $event->event_time ?? '8:00 PM' }}</span>
        @endfor
    </div>
</div>

{{-- ── SLOT MACHINE COUNTDOWN ── --}}
<section class="countdown-section">
    <div class="sec-neon-title" style="color:var(--yellow);text-shadow:0 0 20px var(--yellow)">⏱ العد التنازلي</div>
    <div class="slot-machine">
        <div class="slot-unit">
            <div class="slot-window" style="--c:var(--yellow)"><div class="slot-num" style="--c:var(--yellow)" x-text="String(days).padStart(2,'0')">00</div></div>
            <div class="slot-lbl" style="--c:var(--yellow)">يوم</div>
        </div>
        <div class="slot-unit">
            <div class="slot-window" style="--c:var(--pink)"><div class="slot-num" style="--c:var(--pink)" x-text="String(hours).padStart(2,'0')">00</div></div>
            <div class="slot-lbl" style="--c:var(--pink)">ساعة</div>
        </div>
        <div class="slot-unit">
            <div class="slot-window" style="--c:var(--blue)"><div class="slot-num" style="--c:var(--blue)" x-text="String(mins).padStart(2,'0')">00</div></div>
            <div class="slot-lbl" style="--c:var(--blue)">دقيقة</div>
        </div>
        <div class="slot-unit">
            <div class="slot-window" style="--c:var(--green)"><div class="slot-num" style="--c:var(--green)" x-text="String(secs).padStart(2,'0')">00</div></div>
            <div class="slot-lbl" style="--c:var(--green)">ثانية</div>
        </div>
    </div>
</section>

{{-- ── BACKSTAGE PASS ── --}}
<section class="details-section">
    <div style="text-align:center;margin-bottom:40px">
        <div class="sec-neon-title" style="color:var(--pink);text-shadow:0 0 20px var(--pink)">🎫 بطاقة VIP</div>
    </div>
    <div class="backstage-pass">
        <div class="pass-main">
            <div class="pass-type">ALL ACCESS · BACKSTAGE PASS</div>
            <div class="pass-event-name">WEDDING<br>NIGHT</div>
            <div class="pass-names">{{ $event->groom_name }} & {{ $event->bride_name }}</div>
            <div class="pass-row"><span>📅</span><span><strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong> · {{ $event->event_time ?? '8:00 PM' }}</span></div>
            <div class="pass-row"><span>📍</span><span><strong>{{ $event->venue_name }}</strong>@if($event->venue_address) · {{ $event->venue_address }}@endif</span></div>
            @if($event->dress_code)<div class="pass-row"><span>👗</span><span><strong>{{ $event->dress_code }}</strong> · Dress Code</span></div>@endif
            <div class="pass-barcode">||||| || ||| |||| | ||||| || ||||</div>
        </div>
        <div class="pass-tear"></div>
        <div class="pass-stub">
            <div class="stub-inner">
                <span class="stub-vip">VIP</span>
                <span class="stub-admit">ADMIT ONE</span>
                <span class="stub-num">#001</span>
            </div>
        </div>
    </div>
</section>

{{-- ── POLAROID GALLERY ── --}}
@if($event->galleryImages && count($event->galleryImages) > 0)
<section class="gallery-section">
    <div style="text-align:center;margin-bottom:40px">
        <div class="sec-neon-title" style="color:var(--blue);text-shadow:0 0 20px var(--blue)">📸 الذكريات</div>
    </div>
    <div class="polaroid-wall">
        @php $polRots = [-8,-4,5,-6,3,-9,7,-3,6,-5]; @endphp
        @foreach($event->galleryImages as $i => $img)
        <div class="polaroid" style="--pr:{{ $polRots[$i % count($polRots)] }}deg">
            <img src="{{ asset('storage/'.$img) }}" alt="صورة" class="pol-img">
            <div class="pol-cap">{{ $i + 1 }}</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── GUESTBOOK ── --}}
@if($event->plan?->feature('guest_book'))
<section class="guest-section">
    <div style="text-align:center;margin-bottom:40px">
        <div class="sec-neon-title" style="color:var(--purple);text-shadow:0 0 20px var(--purple)">💬 الرسائل</div>
    </div>
    <div class="guest-wall">
        @php $wishes = $event->guestbookEntries ?? []; @endphp
        @forelse($wishes as $w)
        <div class="guest-msg">
            <div class="gm-text">{{ $w->message ?? $w }}</div>
            <div class="gm-author">— {{ $w->name ?? 'مجهول' }}</div>
        </div>
        @empty
        @for($i=0;$i<3;$i++)
        <div class="guest-msg">
            <div class="gm-text">ألف مبروك على الزفاف، دمتما بخير وسعادة دائماً ⚡</div>
            <div class="gm-author">— أحد المدعوين</div>
        </div>
        @endfor
        @endforelse
    </div>
    <div class="guest-form" x-data="{sent:false}">
        <template x-if="!sent">
            <div>
                <textarea class="gf-input" rows="3" placeholder="اكتب رسالتك للعروسين..."></textarea>
                <input type="text" class="gf-input" placeholder="اسمك">
                <button class="gf-btn" @click="sent=true">⚡ أرسل الرسالة</button>
            </div>
        </template>
        <template x-if="sent">
            <div style="text-align:center;padding:24px;color:var(--green);font-family:'Bebas Neue',cursive;font-size:22px;letter-spacing:2px;text-shadow:0 0 15px var(--green)">تم الإرسال ✓</div>
        </template>
    </div>
</section>
@endif

{{-- ── RSVP CONCERT TICKET ── --}}
@if($event->plan?->feature('rsvp'))
<section class="rsvp-section">
    <div style="text-align:center;margin-bottom:40px">
        <div class="sec-neon-title" style="color:var(--green);text-shadow:0 0 20px var(--green)">🎟 احجز مكانك</div>
    </div>
    <div class="concert-ticket">
        <div class="ticket-header">
            <div class="ticket-h-title">RSVP</div>
            <div class="ticket-h-event"><strong>{{ $event->coupleName() }}</strong><br>{{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        <div class="ticket-body">
            <template x-if="!rsvpSent">
                <div>
                    <label class="neon-label">اسمك</label>
                    <input type="text" class="neon-input" placeholder="أدخل اسمك الكريم">
                    <label class="neon-label">هل ستحضر؟</label>
                    <div class="attend-group">
                        <button type="button" class="attend-btn yes" :class="{active:attendance==='yes'}" @click="attendance='yes'">✓ سأكون هناك</button>
                        <button type="button" class="attend-btn no"  :class="{active:attendance==='no'}"  @click="attendance='no'">✕ لن أتمكن</button>
                    </div>
                    <label class="neon-label">عدد الحضور</label>
                    <input type="number" min="1" max="10" class="neon-input" value="1">
                    <button class="ticket-submit" @click="rsvpSent=true">⚡ تأكيد الحجز</button>
                </div>
            </template>
            <template x-if="rsvpSent">
                <div class="ticket-success">
                    <div style="font-size:48px;margin-bottom:16px">🎫</div>
                    <div style="font-family:'Bebas Neue',cursive;font-size:28px;color:var(--green);text-shadow:0 0 15px var(--green);letter-spacing:2px">تم تأكيد حجزك!</div>
                    <div style="color:var(--muted);margin-top:10px;font-size:14px">نراك في الليلة الكبيرة ⚡</div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

<footer class="footer-section">
    <div class="footer-neon">فرحنا ⚡</div>
    <div style="color:rgba(240,232,255,.3);font-size:13px;margin-top:8px">{{ $event->coupleName() }} · {{ $event->event_date->translatedFormat('d F Y') }}</div>
</footer>

</body>
</html>
