<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->displayTitle() }} – ليلة الكازينو</title>
    @include('partials.og-meta')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        :root {
            --black:   #050505;
            --dark:    #0d0d0d;
            --dark2:   #141414;
            --felt:    #0a1f0a;
            --gold:    #d4af37;
            --gold-l:  #f0d060;
            --gold-d:  #a07820;
            --red:     #c0392b;
            --red-l:   #e74c3c;
            --white:   #f5f0e8;
            --muted:   #6b6050;
            --pb-accent:   #d4af37;
            --pb-btn-text: #050505;
            --map-bg: #0a1f0a; --map-text: #d4af37; --map-accent: #d4af37;
        }

        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; background:var(--black); color:var(--white); overflow-x:hidden; }

        /* ─── FELT PATTERN ─── */
        .felt-bg {
            background-color:var(--felt);
            background-image:
                repeating-linear-gradient(45deg,rgba(255,255,255,.015) 0,rgba(255,255,255,.015) 1px,transparent 0,transparent 50%),
                repeating-linear-gradient(-45deg,rgba(255,255,255,.015) 0,rgba(255,255,255,.015) 1px,transparent 0,transparent 50%);
            background-size:24px 24px;
        }

        /* ─── ANIMATIONS ─── */
        @@keyframes card-shuffle {
            0%   { transform:rotate(-15deg) translateY(60px); opacity:0; }
            100% { transform:rotate(var(--r,0deg)) translateY(0); opacity:1; }
        }
        @@keyframes chip-spin { from{transform:rotateY(0)} to{transform:rotateY(360deg)} }
        @@keyframes neon-flicker {
            0%,19%,21%,23%,25%,54%,56%,100% { opacity:1; text-shadow:0 0 10px var(--gold),0 0 30px var(--gold-d); }
            20%,24%,55% { opacity:.7; text-shadow:none; }
        }
        @@keyframes slot-spin {
            0%   { transform:translateY(0); }
            100% { transform:translateY(-300px); }
        }
        @@keyframes gold-shimmer {
            0%,100% { background-position:0% 50%; }
            50%     { background-position:100% 50%; }
        }
        @@keyframes card-float {
            0%,100% { transform:rotate(var(--r,0deg)) translateY(0); }
            50%     { transform:rotate(var(--r,0deg)) translateY(-10px); }
        }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh; position:relative; overflow:hidden;
            background:var(--black);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:80px 20px;
        }
        /* Green felt table */
        .table-felt {
            position:absolute; inset:0;
            background:radial-gradient(ellipse at 50% 70%,var(--felt) 0%,#060d06 60%,var(--black) 100%);
        }
        /* Table border */
        .table-felt::before {
            content:''; position:absolute; bottom:0; left:0; right:0; height:45%;
            border-top:2px solid rgba(212,175,55,.3);
            border-radius:50% 50% 0 0 / 20% 20% 0 0;
        }
        /* Gold dots pattern */
        .table-felt::after {
            content:''; position:absolute; inset:0;
            background-image:radial-gradient(circle,rgba(212,175,55,.06) 1px,transparent 1px);
            background-size:30px 30px;
        }

        /* Floating playing cards */
        .card-el {
            position:absolute; font-size:var(--fs,40px);
            animation:card-float var(--dur,4s) var(--del,0s) ease-in-out infinite;
            opacity:.15; pointer-events:none; user-select:none;
            --r:var(--rot,0deg);
            transform:rotate(var(--rot,0deg));
        }

        .hero-inner { position:relative; z-index:2; text-align:center; max-width:720px; }

        /* Main card / invite */
        .playing-card-invite {
            background:linear-gradient(145deg,#1a1a1a,#0d0d0d);
            border:1px solid var(--gold-d);
            border-radius:12px; padding:50px 52px;
            position:relative; overflow:hidden;
            box-shadow:0 30px 80px rgba(0,0,0,.8),0 0 0 1px rgba(212,175,55,.1),inset 0 1px 0 rgba(212,175,55,.15);
        }
        /* Gold corner suits */
        .card-suit { position:absolute; font-size:18px; color:var(--gold); opacity:.5; }
        .card-suit:nth-child(1) { top:12px; right:16px; }
        .card-suit:nth-child(2) { top:12px; left:16px; transform:scaleX(-1); }
        .card-suit:nth-child(3) { bottom:12px; right:16px; transform:scaleY(-1); }
        .card-suit:nth-child(4) { bottom:12px; left:16px; transform:scale(-1); }

        /* Neon sign */
        .neon-text {
            font-family:'Bebas Neue',cursive;
            font-size:clamp(14px,2.5vw,16px);
            letter-spacing:10px; color:var(--gold-l);
            text-transform:uppercase;
            animation:neon-flicker 5s infinite;
            display:block; margin-bottom:16px;
        }
        .hero-name {
            font-family:'Bebas Neue',cursive;
            font-size:clamp(40px,9vw,88px);
            background:linear-gradient(135deg,var(--gold-d),var(--gold-l),var(--gold-d));
            background-size:200% 200%; animation:gold-shimmer 3s ease infinite;
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
            line-height:1; letter-spacing:3px;
        }
        .hero-amp { -webkit-text-fill-color:var(--red-l); font-size:.5em; display:inline; }
        .hero-line {
            display:flex; align-items:center; justify-content:center; gap:14px;
            margin:18px 0;
        }
        .hero-line::before,.hero-line::after { content:''; flex:1; max-width:80px; height:1px; background:linear-gradient(90deg,transparent,var(--gold-d)); }
        .hero-line::before { transform:scaleX(-1); }
        .hero-line-icon { font-size:16px; }
        .hero-date { font-size:16px; color:rgba(245,240,232,.65); line-height:2; }
        .hero-date strong { color:var(--gold-l); }

        /* Chips decoration */
        .chips-row { display:flex; justify-content:center; gap:12px; margin-top:20px; }
        .chip {
            width:32px; height:32px; border-radius:50%;
            border:3px solid currentColor; display:inline-flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:700; letter-spacing:-0.5px;
            box-shadow:inset 0 0 0 2px rgba(255,255,255,.15);
        }
        .chip-g { color:var(--gold); background:rgba(212,175,55,.15); }
        .chip-r { color:var(--red-l); background:rgba(192,57,43,.15); }
        .chip-w { color:rgba(255,255,255,.7); background:rgba(255,255,255,.08); }

        /* ─── SLOT MACHINE COUNTDOWN ─── */
        .countdown-section { padding:70px 20px; background:var(--black); border-top:1px solid rgba(212,175,55,.1); }
        .sec-hdr { text-align:center; margin-bottom:50px; }
        .sec-tag { font-size:11px; letter-spacing:6px; color:var(--gold); text-transform:uppercase; display:block; margin-bottom:10px; font-family:'Bebas Neue',cursive; }
        .sec-title { font-family:'Bebas Neue',cursive; font-size:clamp(24px,4vw,40px); color:var(--white); letter-spacing:3px; }
        .sec-line { width:80px; height:1px; background:linear-gradient(90deg,transparent,var(--gold),transparent); margin:14px auto 0; }

        .slot-machine {
            display:flex; justify-content:center; gap:8px;
            background:var(--dark2); border:2px solid var(--gold-d);
            border-radius:8px; padding:16px 24px; max-width:fit-content; margin:0 auto;
            box-shadow:0 0 30px rgba(212,175,55,.1),inset 0 2px 0 rgba(212,175,55,.2);
        }
        .slot-reel {
            text-align:center; min-width:72px;
        }
        .slot-window {
            background:#000; border:1px solid rgba(212,175,55,.3); border-radius:4px;
            height:72px; width:72px; overflow:hidden; display:flex; align-items:center; justify-content:center;
            position:relative;
        }
        .slot-window::before,.slot-window::after {
            content:''; position:absolute; left:0; right:0; height:20px; z-index:2; pointer-events:none;
        }
        .slot-window::before { top:0; background:linear-gradient(#000,transparent); }
        .slot-window::after  { bottom:0; background:linear-gradient(transparent,#000); }
        .slot-val { font-family:'Bebas Neue',cursive; font-size:40px; color:var(--gold-l); line-height:1; }
        .slot-lbl { font-size:10px; letter-spacing:3px; color:var(--muted); margin-top:6px; text-transform:uppercase; }
        .slot-sep { align-self:center; font-family:'Bebas Neue',cursive; font-size:30px; color:var(--gold-d); padding-bottom:20px; }

        /* ─── POKER TABLE DETAILS ─── */
        .details-section { padding:80px 20px; } .details-section { background:var(--felt); background-image:repeating-linear-gradient(45deg,rgba(255,255,255,.012) 0,rgba(255,255,255,.012) 1px,transparent 0,transparent 50%),repeating-linear-gradient(-45deg,rgba(255,255,255,.012) 0,rgba(255,255,255,.012) 1px,transparent 0,transparent 50%); background-size:24px 24px; }
        .poker-table {
            max-width:700px; margin:0 auto;
            background:linear-gradient(145deg,#0f0f0f,#0a0a0a);
            border:1px solid var(--gold-d); border-radius:8px; overflow:hidden;
            box-shadow:0 20px 60px rgba(0,0,0,.6);
        }
        .poker-table-header {
            background:linear-gradient(135deg,#1a1006,#0d0a04);
            border-bottom:1px solid rgba(212,175,55,.2);
            padding:20px 28px; display:flex; align-items:center; gap:12px;
        }
        .poker-table-header .suit { font-size:20px; }
        .poker-table-header .title { font-family:'Bebas Neue',cursive; font-size:20px; color:var(--gold); letter-spacing:2px; }
        .info-row {
            display:flex; align-items:center; gap:16px; padding:18px 28px;
            border-bottom:1px solid rgba(212,175,55,.08);
        }
        .info-row:last-child { border-bottom:none; }
        .info-card {
            width:42px; height:42px; background:var(--dark2);
            border:1px solid rgba(212,175,55,.2); border-radius:6px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; flex-shrink:0;
        }
        .info-text dt { font-size:11px; letter-spacing:3px; color:var(--gold-d); text-transform:uppercase; margin-bottom:3px; }
        .info-text dd { font-size:16px; color:var(--white); font-weight:600; }

        /* ─── GALLERY (polaroid stack) ─── */
        .gallery-section { padding:80px 20px; background:var(--dark); }
        .polaroid-stack { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; }
        .polaroid {
            background:#1a1006; padding:10px 10px 28px;
            border:1px solid rgba(212,175,55,.15); border-radius:2px;
            box-shadow:0 6px 24px rgba(0,0,0,.5);
            transform:rotate(var(--r,0deg)); transition:transform .3s,box-shadow .3s;
        }
        .polaroid:hover { transform:rotate(0deg) scale(1.04); box-shadow:0 12px 40px rgba(0,0,0,.6); }
        .polaroid:nth-child(odd)  { --r:-2deg; }
        .polaroid:nth-child(even) { --r:1.5deg; }
        .polaroid img { width:100%; aspect-ratio:1; object-fit:cover; display:block; }
        .polaroid .p-label { text-align:center; margin-top:10px; font-size:12px; color:rgba(245,240,232,.4); letter-spacing:1px; }

        /* ─── WISHES ─── */
        .wishes-section { padding:80px 20px; background:var(--black); }
        .wishes-grid { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }
        .wish-ticket {
            background:linear-gradient(145deg,#141414,#0d0d0d);
            border:1px solid rgba(212,175,55,.2); border-radius:4px; padding:22px;
            position:relative; overflow:hidden;
        }
        .wish-ticket::before {
            content:''; position:absolute; top:0; bottom:0; right:0; width:3px;
            background:linear-gradient(180deg,var(--gold),var(--red));
        }
        .wish-ticket-text { font-size:14px; color:rgba(245,240,232,.7); line-height:1.8; }
        .wish-ticket-author { font-family:'Bebas Neue',cursive; font-size:14px; color:var(--gold); margin-top:12px; letter-spacing:1px; }
        .wish-form { max-width:500px; margin:40px auto 0; background:var(--dark2); border:1px solid rgba(212,175,55,.2); border-radius:4px; padding:28px; }
        .wf-in { width:100%; padding:12px 14px; margin-bottom:12px; background:rgba(212,175,55,.05); border:1px solid rgba(212,175,55,.2); border-radius:4px; color:var(--white); font-family:'Tajawal',sans-serif; font-size:14px; outline:none; resize:none; transition:border-color .2s; }
        .wf-in:focus { border-color:var(--gold); }
        .wf-in::placeholder { color:rgba(245,240,232,.3); }
        .wf-btn { width:100%; padding:14px; background:var(--gold); color:var(--black); border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:15px; font-weight:700; cursor:pointer; letter-spacing:1px; transition:all .2s; }
        .wf-btn:hover { background:var(--gold-l); }

        /* ─── RSVP TICKET ─── */
        .rsvp-section { padding:80px 20px; background:var(--dark); }
        .rsvp-ticket {
            max-width:560px; margin:0 auto;
            background:linear-gradient(145deg,#141414,#0d0d0d);
            border:1px solid var(--gold-d); border-radius:6px; overflow:hidden;
            box-shadow:0 20px 60px rgba(0,0,0,.6);
        }
        .ticket-header {
            background:linear-gradient(135deg,#1c1006,#0d0a02);
            border-bottom:1px solid rgba(212,175,55,.2);
            padding:28px 32px; text-align:center;
        }
        .ticket-punch-holes { display:flex; justify-content:space-between; padding:0 28px; margin-top:-10px; }
        .punch { width:20px; height:20px; border-radius:50%; background:var(--dark); border:1px solid rgba(212,175,55,.2); }
        .ticket-dashes { border-top:1px dashed rgba(212,175,55,.2); margin:12px 0; }
        .ticket-title { font-family:'Bebas Neue',cursive; font-size:28px; color:var(--gold-l); letter-spacing:3px; }
        .ticket-sub { font-size:13px; color:rgba(245,240,232,.5); margin-top:4px; }
        .ticket-body { padding:28px 32px; }
        .t-label { display:block; font-size:11px; letter-spacing:3px; color:var(--gold-d); margin-bottom:8px; text-transform:uppercase; }
        .t-input { width:100%; padding:12px 14px; margin-bottom:20px; background:rgba(212,175,55,.05); border:1px solid rgba(212,175,55,.2); border-radius:4px; color:var(--white); font-family:'Tajawal',sans-serif; font-size:14px; outline:none; transition:border-color .2s; }
        .t-input:focus { border-color:var(--gold); }
        .t-input::placeholder { color:rgba(245,240,232,.3); }
        .attend-row { display:flex; gap:12px; margin-bottom:20px; }
        .attend-card { flex:1; padding:12px; border:1.5px solid rgba(212,175,55,.2); border-radius:4px; text-align:center; cursor:pointer; background:transparent; color:rgba(245,240,232,.5); font-family:'Tajawal',sans-serif; font-size:13px; font-weight:600; transition:all .2s; }
        .attend-card.active,.attend-card:hover { border-color:var(--gold); color:var(--gold); background:rgba(212,175,55,.08); }
        .t-submit { width:100%; padding:16px; background:linear-gradient(135deg,var(--gold-d),var(--gold)); color:var(--black); border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:16px; font-weight:700; cursor:pointer; letter-spacing:1px; box-shadow:0 6px 20px rgba(212,175,55,.3); transition:all .2s; }
        .t-submit:hover { box-shadow:0 8px 30px rgba(212,175,55,.5); transform:translateY(-1px); }

        /* ─── FOOTER ─── */
        .footer { padding:40px 20px; background:#020202; text-align:center; color:rgba(245,240,232,.3); font-size:13px; border-top:1px solid rgba(212,175,55,.1); }
        .footer-brand { font-family:'Bebas Neue',cursive; font-size:24px; color:var(--gold); letter-spacing:3px; display:block; margin-bottom:10px; }

        @media(max-width:600px){ .playing-card-invite{padding:28px 20px;} .ticket-body{padding:20px;} }
    </style>
</head>
<body x-data="{
    rsvpSent:false, attendance:'',
    days:0, hours:0, mins:0, secs:0,
    initCountdown(t){ const f=()=>{ const d=new Date(t)-new Date(); if(d<=0)return; this.days=Math.floor(d/864e5); this.hours=Math.floor(d%864e5/36e5); this.mins=Math.floor(d%36e5/6e4); this.secs=Math.floor(d%6e4/1e3); }; f(); setInterval(f,1000); }
}" x-init="initCountdown('{{ $event->event_date->format('Y-m-d') }}')">

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ── HERO ── --}}
<section class="hero">
    <div class="table-felt"></div>

    @php
    $cards = [
        ['🂡','5%','15%','44px','5s','0s','-15deg'],
        ['🂮','88%','10%','36px','6s','1s','20deg'],
        ['🃁','3%','70%','32px','4.5s','2s','-8deg'],
        ['🂻','92%','65%','40px','7s','0.5s','15deg'],
        ['🂺','50%','5%','28px','5.5s','3s','0deg'],
        ['🃎','45%','80%','34px','6.5s','1.5s','-20deg'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="card-el" style="left:{{$c[1]}};top:{{$c[2]}};--fs:{{$c[3]}};--dur:{{$c[4]}};--del:{{$c[5]}};--rot:{{$c[6]}}">{{$c[0]}}</div>
    @endforeach

    <div class="hero-inner">
        <div class="playing-card-invite">
            <span class="card-suit">♠</span>
            <span class="card-suit">♦</span>
            <span class="card-suit">♣</span>
            <span class="card-suit">♥</span>

            <div class="neon-text">✦ دعوة ✦</div>

            <div class="hero-name">
                {{ $event->groom_name }}
                @if($event->bride_name)
                <span class="hero-amp"> & </span>
                {{ $event->bride_name }}
                @endif
            </div>

            <div class="hero-line">
                <span class="hero-line-icon">🃏</span>
            </div>

            <div class="hero-date">
                <strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong><br>
                {{ $event->venue_name }}
                @if($event->event_time) · {{ $event->event_time }} @endif
            </div>

            <div class="chips-row">
                <span class="chip chip-g">♠</span>
                <span class="chip chip-r">♥</span>
                <span class="chip chip-w">♣</span>
                <span class="chip chip-r">♦</span>
                <span class="chip chip-g">♠</span>
            </div>
        </div>
    </div>
</section>

{{-- ── SLOT MACHINE COUNTDOWN ── --}}
<section class="countdown-section">
    <div class="sec-hdr">
        <span class="sec-tag">🎰 العد التنازلي</span>
        <div class="sec-title">حتى تدور البكرات</div>
        <div class="sec-line"></div>
    </div>
    <div class="slot-machine">
        <div class="slot-reel">
            <div class="slot-window"><div class="slot-val" x-text="String(days).padStart(2,'0')">00</div></div>
            <div class="slot-lbl">يوم</div>
        </div>
        <span class="slot-sep">:</span>
        <div class="slot-reel">
            <div class="slot-window"><div class="slot-val" x-text="String(hours).padStart(2,'0')">00</div></div>
            <div class="slot-lbl">ساعة</div>
        </div>
        <span class="slot-sep">:</span>
        <div class="slot-reel">
            <div class="slot-window"><div class="slot-val" x-text="String(mins).padStart(2,'0')">00</div></div>
            <div class="slot-lbl">دقيقة</div>
        </div>
        <span class="slot-sep">:</span>
        <div class="slot-reel">
            <div class="slot-window"><div class="slot-val" x-text="String(secs).padStart(2,'0')">00</div></div>
            <div class="slot-lbl">ثانية</div>
        </div>
    </div>
</section>

{{-- ── DETAILS ── --}}
<section class="details-section">
    <div class="sec-hdr">
        <span class="sec-tag">♠ تفاصيل الحفل</span>
        <div class="sec-title">معلومات اللعبة</div>
        <div class="sec-line"></div>
    </div>
    <div class="poker-table">
        <div class="poker-table-header">
            <span class="suit">🃏</span>
            <span class="title">بطاقة دعوة خاصة</span>
        </div>
        <div class="info-row">
            <div class="info-card">📅</div>
            <dl class="info-text">
                <dt>التاريخ</dt>
                <dd>{{ $event->event_date->translatedFormat('l، d F Y') }}
                @if($event->event_time) · {{ $event->event_time }} @endif</dd>
            </dl>
        </div>
        <div class="info-row">
            <div class="info-card">📍</div>
            <dl class="info-text">
                <dt>المكان</dt>
                <dd>{{ $event->venue_name }}
                @if($event->venue_address)<br><small style="font-weight:400;font-size:13px;color:rgba(245,240,232,.45)">{{ $event->venue_address }}</small>@endif</dd>
            </dl>
        </div>
        @if($event->dress_code)
        <div class="info-row">
            <div class="info-card">🎩</div>
            <dl class="info-text">
                <dt>الـ Dress Code</dt>
                <dd>{{ $event->dress_code }}</dd>
            </dl>
        </div>
        @endif
    </div>
</section>

{{-- ── GALLERY (polaroid) ── --}}
@if($event->galleryImages && count($event->galleryImages) > 0)
<section class="gallery-section">
    <div class="sec-hdr">
        <span class="sec-tag" style="color:rgba(212,175,55,.7)">♦ الصور</span>
        <div class="sec-title">لحظات كالورق</div>
        <div class="sec-line"></div>
    </div>
    <div class="polaroid-stack">
        @foreach($event->galleryImages as $img)
        <div class="polaroid">
            <img src="{{ asset('storage/'.$img) }}" alt="صورة">
            <div class="p-label">✦</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── WISHES ── --}}
@if($event->plan?->feature('guest_book'))
<section class="wishes-section">
    <div class="sec-hdr">
        <span class="sec-tag">♣ التهاني</span>
        <div class="sec-title">بطاقات التهنئة</div>
        <div class="sec-line"></div>
    </div>
    <div class="wishes-grid">
        @php $wishes = $event->guestbookEntries ?? []; @endphp
        @forelse($wishes as $w)
        <div class="wish-ticket"><div class="wish-ticket-text">{{ $w->message ?? $w }}</div><div class="wish-ticket-author">— {{ $w->name ?? 'ضيف' }}</div></div>
        @empty
        <div class="wish-ticket"><div class="wish-ticket-text">ألف مبروك! ليلة لا تُنسى وحياة مليانة فرحة وحب ♠</div><div class="wish-ticket-author">— صديق</div></div>
        <div class="wish-ticket"><div class="wish-ticket-text">يا رب يكون كل أيامكم بالفرح والبركة 🃏</div><div class="wish-ticket-author">— قريب</div></div>
        <div class="wish-ticket"><div class="wish-ticket-text">بالتوفيق والسعادة الدايمة ♥</div><div class="wish-ticket-author">— أحد المدعوين</div></div>
        @endforelse
    </div>
    <div class="wish-form" x-data="{sent:false}">
        <template x-if="!sent">
            <div>
                <textarea class="wf-in" rows="3" placeholder="اكتب تهنئتك هنا..."></textarea>
                <input type="text" class="wf-in" placeholder="اسمك">
                <button class="wf-btn" @click="sent=true">🃏 اترك تهنئتك</button>
            </div>
        </template>
        <template x-if="sent">
            <div style="text-align:center;padding:24px;color:var(--gold-l);font-size:18px">تم إرسال التهنئة ✓ ♠</div>
        </template>
    </div>
</section>
@endif

{{-- ── RSVP ── --}}
@if($event->plan?->feature('rsvp'))
<section class="rsvp-section">
    <div class="sec-hdr">
        <span class="sec-tag" style="color:rgba(212,175,55,.7)">♥ RSVP</span>
        <div class="sec-title">هل أنت داخل؟</div>
        <div class="sec-line"></div>
    </div>
    <div class="rsvp-ticket">
        <div class="ticket-header">
            <div class="ticket-title">تذكرة الدخول</div>
            <div class="ticket-sub">{{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        <div class="ticket-punch-holes"><div class="punch"></div><div class="punch"></div></div>
        <div style="padding:0 28px"><div class="ticket-dashes"></div></div>
        <div class="ticket-body">
            <template x-if="!rsvpSent">
                <div>
                    <label class="t-label">اسمك</label>
                    <input type="text" class="t-input" placeholder="أدخل اسمك">
                    <label class="t-label">حضورك مؤكد؟</label>
                    <div class="attend-row">
                        <button type="button" class="attend-card" :class="{active:attendance==='yes'}" @click="attendance='yes'">✓ أنا داخل!</button>
                        <button type="button" class="attend-card" :class="{active:attendance==='no'}"  @click="attendance='no'">للأسف لأ</button>
                    </div>
                    <label class="t-label">عدد الأشخاص</label>
                    <input type="number" min="1" max="10" class="t-input" value="1">

                    <div class="form-group">
                        <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                        <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                    </div>
                    <button class="t-submit" @click="rsvpSent=true">🎰 تأكيد الحضور</button>
                </div>
            </template>
            <template x-if="rsvpSent">
                <div style="text-align:center;padding:50px 20px">
                    <div style="font-size:48px;margin-bottom:16px">🎰</div>
                    <div style="font-family:'Bebas Neue',cursive;font-size:26px;color:var(--gold-l);letter-spacing:3px">تذكرتك محجوزة!</div>
                    <div style="color:rgba(245,240,232,.4);margin-top:10px;font-size:14px">نتطلع لرؤيتك في ليلة لا تُنسى</div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

<footer class="footer">
    <span class="footer-brand">فرحنا ♠</span>
    {{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}<br><br>
    صُنع بكل أناقة · فرحنا للمناسبات
</footer>

@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
