<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->coupleName() }} – رسالة حب</title>
    <meta property="og:title" content="{{ $event->coupleName() }}">
    <meta property="og:description" content="{{ $event->event_date->format('d F Y') }} · {{ $event->venue_name }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Dancing+Script:wght@600;700&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        :root {
            --cream:  #faf6f0;
            --paper:  #f5ede0;
            --paper2: #ede0cc;
            --wine:   #6b1a2e;
            --wine-l: #9b2a42;
            --gold:   #c9943a;
            --gold-l: #e8b96a;
            --text:   #2c1810;
            --muted:  #7a5c4a;
            --ink:    #1a0f08;
            --pb-accent:   #6b1a2e;
            --pb-btn-text: #fff;
            --map-bg: #fdf5e6; --map-text: #3d2b1f; --map-accent: #9b2335;
        }

        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; background:var(--cream); color:var(--text); overflow-x:hidden; }


        /* ─── ENVELOPE HERO ─── */
        .envelope-section {
            min-height:100vh;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            background:linear-gradient(160deg,#f0e8d8,#e8d8c5 50%,#dcc8aa);
            position:relative; overflow:hidden; padding:80px 20px 60px;
        }
        .envelope-section::before {
            content:'';
            position:absolute; inset:0;
            background-image:repeating-linear-gradient(0deg,transparent,transparent 28px,rgba(107,26,46,.06) 28px,rgba(107,26,46,.06) 29px);
            pointer-events:none;
        }

        .rose-deco {
            position:absolute; pointer-events:none; user-select:none;
            opacity:.18; font-size:var(--s,30px);
            top:var(--t,10%); left:var(--l,10%);
            transform:rotate(var(--r,0deg));
        }

        .envelope-wrap { position:relative; z-index:2; display:flex; flex-direction:column; align-items:center; }

        .envelope {
            width:min(500px,90vw); position:relative; cursor:pointer;
            filter:drop-shadow(0 20px 60px rgba(107,26,46,.3));
        }
        .env-body {
            width:100%; padding-top:65%;
            background:linear-gradient(145deg,#f5ede0,#ede0cc);
            border-radius:4px 4px 8px 8px; position:relative;
            border:1.5px solid #c8a882;
        }
        /* V-fold lines */
        .env-body::before {
            content:''; position:absolute; inset:0;
            background:
                linear-gradient(135deg,transparent 49.8%,#d4b896 50%,#d4b896 50.3%,transparent 50.5%) 0 0,
                linear-gradient(225deg,transparent 49.8%,#d4b896 50%,#d4b896 50.3%,transparent 50.5%) 0 0;
            background-size:50% 100%; background-repeat:no-repeat;
        }
        /* Flap */
        .env-flap {
            position:absolute; top:0; left:0; right:0; height:55%;
            transform-origin:top center; transform:rotateX(0deg);
            transition:transform .8s cubic-bezier(.4,0,.2,1); z-index:3;
        }
        .env-flap::before {
            content:''; position:absolute; inset:0;
            background:linear-gradient(160deg,#ede0cc,#e0ccb4);
            clip-path:polygon(0 0,50% 100%,100% 0);
            border-bottom:1.5px solid #c8a882;
        }
        .envelope.opened .env-flap { transform:rotateX(-180deg); }

        /* Wax seal */
        .wax-seal {
            position:absolute; top:calc(55% - 28px); left:50%; transform:translateX(-50%);
            width:56px; height:56px; z-index:4;
            transition:opacity .3s, transform .3s;
        }
        .envelope.opened .wax-seal { opacity:0; transform:translateX(-50%) scale(.5); pointer-events:none; }
        .wax-circle {
            width:100%; height:100%; border-radius:50%;
            background:radial-gradient(circle at 35% 35%,var(--wine-l),var(--wine) 60%,#3d0f1a);
            display:flex; align-items:center; justify-content:center; font-size:20px;
            box-shadow:0 4px 15px rgba(107,26,46,.5),inset 0 -2px 6px rgba(0,0,0,.3);
        }

        /* Letter card */
        .letter-card {
            width:min(460px,85vw);
            background:linear-gradient(165deg,#fffdf8,#faf4ec);
            border:1px solid #d4b896; border-radius:3px;
            padding:40px 32px; position:relative; text-align:center;
            box-shadow:0 30px 80px rgba(107,26,46,.2);
            margin-top:-20px; z-index:1;
            transform:translateY(40px); opacity:0;
            transition:transform .9s .3s cubic-bezier(.4,0,.2,1), opacity .9s .3s;
        }
        .letter-card.visible { transform:translateY(0); opacity:1; }
        .letter-card::before {
            content:''; position:absolute; inset:60px 24px;
            background-image:repeating-linear-gradient(0deg,transparent,transparent 27px,rgba(107,26,46,.08) 27px,rgba(107,26,46,.08) 28px);
            pointer-events:none;
        }
        .stamp {
            position:absolute; top:24px; left:24px;
            width:52px; height:66px; border:2px solid var(--gold); border-radius:3px;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            font-size:20px; gap:4px; background:rgba(201,148,58,.08);
        }
        .stamp span { font-size:9px; color:var(--gold); font-weight:700; letter-spacing:1px; }
        .lc-greeting { font-family:'Dancing Script',cursive; font-size:clamp(16px,4vw,22px); color:var(--wine); margin-bottom:12px; position:relative; z-index:1; }
        .lc-names { font-family:'Playfair Display',serif; font-size:clamp(28px,7vw,52px); color:var(--ink); line-height:1.2; margin:12px 0; position:relative; z-index:1; }
        .lc-names .amp { color:var(--wine); font-style:italic; font-size:.8em; }
        .lc-divider { width:100px; height:1px; background:linear-gradient(90deg,transparent,var(--gold),transparent); margin:20px auto; position:relative; }
        .lc-divider::before { content:'💍'; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-size:16px; background:linear-gradient(165deg,#fffdf8,#faf4ec); padding:0 8px; }
        .lc-date { font-size:15px; color:var(--muted); line-height:1.8; position:relative; z-index:1; }
        .lc-date strong { color:var(--wine); font-weight:700; }
        .lc-ps { font-family:'Dancing Script',cursive; font-size:15px; color:var(--gold); margin-top:20px; position:relative; z-index:1; }

        .open-btn {
            margin-top:32px; padding:14px 36px; background:var(--wine); color:#fff;
            border:none; border-radius:4px; font-family:'Tajawal',sans-serif;
            font-size:16px; font-weight:700; cursor:pointer;
            box-shadow:0 6px 25px rgba(107,26,46,.4); transition:all .2s;
            position:relative; z-index:10;
        }
        .open-btn:hover { background:var(--wine-l); transform:translateY(-2px); }
        .open-btn[style*="none"] { display:none; }

        /* ─── COUNTDOWN ─── */
        .countdown-section { padding:60px 20px; background:var(--paper); text-align:center; }
        .section-header { text-align:center; margin-bottom:60px; position:relative; }
        .sec-badge { display:inline-block; font-family:'Dancing Script',cursive; font-size:13px; color:var(--wine); letter-spacing:3px; text-transform:uppercase; margin-bottom:12px; }
        .sec-title { font-family:'Playfair Display',serif; font-size:clamp(26px,5vw,40px); color:var(--ink); }
        .sec-line { width:80px; height:2px; background:linear-gradient(90deg,transparent,var(--wine),transparent); margin:16px auto 0; }
        .cd-wrap { display:flex; justify-content:center; gap:clamp(16px,4vw,40px); flex-wrap:wrap; }
        .cd-box { display:flex; flex-direction:column; align-items:center; }
        .cd-num {
            width:80px; height:80px; background:var(--wine); color:#fff;
            font-family:'Playfair Display',serif; font-size:32px; font-weight:700;
            display:flex; align-items:center; justify-content:center;
            border-radius:4px; box-shadow:0 6px 20px rgba(107,26,46,.3),inset 0 -3px 0 rgba(0,0,0,.2);
            position:relative;
        }
        .cd-num::after { content:''; position:absolute; top:50%; left:0; right:0; height:1px; background:rgba(0,0,0,.2); }
        .cd-lbl { font-size:12px; color:var(--muted); margin-top:8px; letter-spacing:2px; }

        /* ─── LOVE STORY TIMELINE ─── */
        .timeline-section { padding:80px 20px; background:var(--paper); position:relative; overflow:hidden; }
        .timeline-section::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(circle at 20% 20%,rgba(107,26,46,.04) 0%,transparent 50%),
                        radial-gradient(circle at 80% 80%,rgba(201,148,58,.04) 0%,transparent 50%);
        }
        .timeline { max-width:700px; margin:0 auto; position:relative; }
        .timeline::before {
            content:''; position:absolute; left:50%; top:0; bottom:0; width:2px;
            background:linear-gradient(180deg,transparent,var(--gold) 10%,var(--gold) 90%,transparent);
            transform:translateX(-50%);
        }
        .tl-item { display:flex; margin-bottom:50px; position:relative; }
        .tl-item:nth-child(even) { flex-direction:row-reverse; }
        .tl-content {
            width:calc(50% - 30px);
            background:linear-gradient(135deg,#fffdf8,#faf4ec);
            border:1px solid #d4b896; border-radius:4px;
            padding:20px 22px; position:relative;
            box-shadow:0 4px 20px rgba(107,26,46,.1);
        }
        .tl-item:nth-child(even) .tl-content { margin-left:auto; }
        .tl-content::after { content:''; position:absolute; top:20px; width:0; height:0; }
        .tl-item:nth-child(odd) .tl-content::after  { right:-9px; border-top:9px solid transparent; border-bottom:9px solid transparent; border-left:9px solid #d4b896; }
        .tl-item:nth-child(even) .tl-content::after { left:-9px;  border-top:9px solid transparent; border-bottom:9px solid transparent; border-right:9px solid #d4b896; }
        .tl-dot {
            position:absolute; left:50%; top:20px; transform:translateX(-50%);
            width:22px; height:22px; border-radius:50%; background:var(--wine);
            border:3px solid #faf6f0; box-shadow:0 0 0 2px var(--wine); z-index:2;
            display:flex; align-items:center; justify-content:center; font-size:10px;
        }
        .tl-year { font-family:'Dancing Script',cursive; font-size:13px; color:var(--gold); font-weight:700; margin-bottom:6px; }
        .tl-name { font-family:'Playfair Display',serif; font-size:16px; color:var(--ink); margin-bottom:6px; }
        .tl-desc { font-size:13px; color:var(--muted); line-height:1.6; }

        /* ─── DETAILS (LETTER PAPER) ─── */
        .details-section { padding:80px 20px; background:linear-gradient(160deg,#f0e8d8,#e8d8c5); }
        .letter-paper {
            max-width:650px; margin:0 auto;
            background:linear-gradient(165deg,#fffdf8,#faf4ec);
            border:1px solid #d4b896; border-radius:4px; padding:50px 48px;
            position:relative;
            box-shadow:0 20px 70px rgba(107,26,46,.15),2px 2px 0 #d4b896,4px 4px 0 #c8a882;
        }
        .hole { position:absolute; width:18px; height:18px; border-radius:50%; background:#e8d8c5; border:1px solid #c8a882; left:24px; box-shadow:inset 0 1px 3px rgba(0,0,0,.15); }
        .hole:nth-child(1) { top:50px; } .hole:nth-child(2) { top:calc(50% - 9px); } .hole:nth-child(3) { bottom:50px; }
        .lp-content { padding-right:16px; }
        .lp-greeting { font-family:'Dancing Script',cursive; font-size:20px; color:var(--wine); margin-bottom:24px; }
        .lp-body { font-size:15px; color:var(--text); line-height:2.2; }
        .lp-body strong { color:var(--wine); font-weight:700; }
        .lp-row {
            display:flex; align-items:baseline; gap:12px; margin:16px 0;
            padding:12px 16px; background:rgba(107,26,46,.04);
            border-right:3px solid var(--wine); border-radius:0 4px 4px 0;
        }
        .lp-row-icon { font-size:18px; flex-shrink:0; }
        .lp-row-text { font-size:15px; }
        .lp-row-text span { color:var(--muted); font-size:13px; display:block; }
        .lp-sig { font-family:'Dancing Script',cursive; font-size:22px; color:var(--wine); text-align:left; margin-top:32px; }

        /* ─── GALLERY (photos on paper) ─── */
        .gallery-section { padding:80px 20px; background:var(--cream); }
        .photo-strip { max-width:1000px; margin:0 auto; display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
        .photo-item {
            width:200px; background:#fff; padding:12px 12px 36px;
            box-shadow:3px 5px 20px rgba(0,0,0,.15);
            transform:rotate(var(--rot,0deg));
            transition:transform .2s,box-shadow .2s; cursor:pointer; position:relative;
        }
        .photo-item:hover { transform:rotate(0deg) scale(1.08); box-shadow:8px 12px 30px rgba(0,0,0,.25); z-index:10; }
        .photo-img { width:100%; aspect-ratio:1; object-fit:cover; display:block; background:linear-gradient(135deg,#e8d8c5,#d4b896); }
        .photo-cap { position:absolute; bottom:8px; left:0; right:0; text-align:center; font-family:'Dancing Script',cursive; font-size:13px; color:var(--muted); }

        /* ─── STICKY NOTES GUESTBOOK ─── */
        .sticky-section { padding:80px 20px; background:var(--paper2); position:relative; overflow:hidden; }
        .sticky-section::before {
            content:''; position:absolute; inset:0;
            background:repeating-linear-gradient(-45deg,transparent 0 10px,rgba(107,26,46,.015) 10px 11px);
        }
        .sticky-grid { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:24px; padding:20px 0; }
        .sticky-note {
            background:var(--sn-clr,#fef3c7); padding:24px 20px 32px; border-radius:2px;
            box-shadow:3px 3px 12px rgba(0,0,0,.15);
            transform:rotate(var(--sn-rot,-2deg));
            transition:transform .2s,box-shadow .2s;
            font-family:'Dancing Script',cursive; position:relative;
        }
        .sticky-note:hover { transform:rotate(0deg) scale(1.05); box-shadow:6px 6px 20px rgba(0,0,0,.2); z-index:10; }
        .sticky-note::before { content:''; position:absolute; top:-10px; left:50%; transform:translateX(-50%); width:50px; height:18px; background:rgba(255,255,255,.6); border-radius:2px; }
        .sn-text { font-size:15px; color:var(--ink); line-height:1.7; }
        .sn-author { font-size:13px; color:var(--muted); margin-top:12px; font-style:italic; }

        /* ─── RSVP ─── */
        .rsvp-section { padding:80px 20px; background:linear-gradient(160deg,#3d0f1a,#6b1a2e); }
        .rsvp-card {
            max-width:580px; margin:0 auto;
            background:linear-gradient(165deg,#fffdf8,#faf4ec);
            border-radius:4px; padding:50px 48px; position:relative;
            box-shadow:0 30px 80px rgba(0,0,0,.4);
        }
        .rsvp-card::before { content:'↩ الرجاء الرد قبل ' attr(data-d); position:absolute; top:16px; right:24px; font-size:11px; color:var(--muted); letter-spacing:1px; }
        .rsvp-title { font-family:'Playfair Display',serif; font-size:28px; color:var(--wine); text-align:center; margin-bottom:32px; }
        .rsvp-field { margin-bottom:20px; }
        .rsvp-label { display:block; font-size:13px; color:var(--muted); margin-bottom:6px; font-weight:600; letter-spacing:1px; }
        .rsvp-input { width:100%; padding:12px 14px; border:1px solid #d4b896; border-radius:3px; background:rgba(255,255,255,.8); font-family:'Tajawal',sans-serif; font-size:14px; color:var(--text); outline:none; transition:border-color .2s; }
        .rsvp-input:focus { border-color:var(--wine); }
        .rsvp-radios { display:flex; gap:16px; flex-wrap:wrap; }
        .rsvp-radio { display:flex; align-items:center; gap:8px; padding:10px 18px; border:1.5px solid #d4b896; border-radius:3px; cursor:pointer; font-size:14px; transition:all .2s; }
        .rsvp-radio:has(input:checked) { border-color:var(--wine); background:rgba(107,26,46,.06); color:var(--wine); }
        .rsvp-radio input { accent-color:var(--wine); }
        .rsvp-btn { width:100%; padding:16px; background:var(--wine); color:#fff; border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:16px; font-weight:700; cursor:pointer; margin-top:10px; box-shadow:0 6px 25px rgba(107,26,46,.4); transition:all .2s; }
        .rsvp-btn:hover { background:var(--wine-l); transform:translateY(-2px); }

        /* ─── FOOTER ─── */
        .footer-section { padding:50px 20px; background:var(--ink); text-align:center; color:rgba(255,255,255,.5); font-size:13px; }
        .footer-logo { font-family:'Dancing Script',cursive; font-size:24px; color:var(--gold); margin-bottom:12px; display:block; }

        @media (max-width:600px) {
            .timeline::before,.tl-dot { display:none; }
            .tl-item, .tl-item:nth-child(even) { flex-direction:column; }
            .tl-content { width:100%; }
            .tl-item:nth-child(even) .tl-content { margin-left:0; }
            .tl-content::after { display:none; }
            .letter-paper { padding:32px 20px; }
            .rsvp-card { padding:32px 20px; }
        }
    </style>
</head>
<body x-data="{
    opened:false, rsvpSent:false,
    days:0, hours:0, mins:0, secs:0,
    initCountdown(t){ setInterval(()=>{ const d=new Date(t)-new Date(); if(d<=0)return; this.days=Math.floor(d/864e5); this.hours=Math.floor(d%864e5/36e5); this.mins=Math.floor(d%36e5/6e4); this.secs=Math.floor(d%6e4/1e3); },1000); }
}" x-init="initCountdown('{{ $event->event_date->format('Y-m-d') }}')">

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ── ENVELOPE HERO ── --}}
<section class="envelope-section">
    @php $roseData = [[15,8,-20,35],[75,5,30,40],[5,70,-30,28],[85,65,25,45],[45,90,-15,32],[20,40,40,25],[70,30,-35,38],[55,15,20,30]]; @endphp
    @foreach($roseData as $r)
    <span class="rose-deco" style="--t:{{$r[0]}}%;--l:{{$r[1]}}%;--r:{{$r[2]}}deg;--s:{{$r[3]}}px">🌹</span>
    @endforeach

    <div class="envelope-wrap">
        {{-- Envelope --}}
        <div class="envelope" :class="{ opened: opened }" @click="if(!opened){ opened=true }">
            <div class="env-body">
                <div class="env-flap"></div>
            </div>
            <div class="wax-seal">
                <div class="wax-circle">💍</div>
            </div>
        </div>

        {{-- Letter slides out --}}
        <div class="letter-card" :class="{ visible: opened }">
            <div class="stamp">✉️<span>LOVE</span></div>
            <div class="lc-greeting">إلى أعزّ الناس على قلبينا،</div>
            <div class="lc-names">
                {{ $event->groom_name }}
                <span class="amp"> & </span>
                {{ $event->bride_name }}
            </div>
            <div class="lc-divider"></div>
            <div class="lc-date">
                يسعدان بدعوتكم لمشاركتهما فرحة زفافهما<br>
                <strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong><br>
                {{ $event->event_time ?? '7:00 مساءً' }} · <strong>{{ $event->venue_name }}</strong>
            </div>
            <div class="lc-ps">حضوركم أسعد اللحظات ✨</div>
        </div>

        <button class="open-btn" x-show="!opened" @click="opened=true">افتح الخطاب 💌</button>
    </div>
</section>

{{-- ── COUNTDOWN ── --}}
<section class="countdown-section">
    <div class="section-header">
        <div class="sec-badge">⏳ العد التنازلي</div>
        <div class="sec-title">لحظة انتظرناها طويلاً</div>
    </div>
    <div class="cd-wrap">
        <div class="cd-box"><div class="cd-num" x-text="String(days).padStart(2,'0')">00</div><div class="cd-lbl">يوم</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(hours).padStart(2,'0')">00</div><div class="cd-lbl">ساعة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(mins).padStart(2,'0')">00</div><div class="cd-lbl">دقيقة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(secs).padStart(2,'0')">00</div><div class="cd-lbl">ثانية</div></div>
    </div>
</section>

{{-- ── LOVE STORY TIMELINE ── --}}
<section class="timeline-section">
    <div class="section-header">
        <div class="sec-badge">قصة حبنا</div>
        <div class="sec-title">كان يا ما كان…</div>
        <div class="sec-line"></div>
    </div>
    <div class="timeline">
        @php
        $milestones = [
            ['year'=>'البداية','icon'=>'👀','title'=>'أول لقاء','desc'=>'نظرة غيّرت كل شيء، وابتسامة لم تُنسَ حتى اليوم'],
            ['year'=>'اللحظة الذهبية','icon'=>'🌟','title'=>'حين عرفنا','desc'=>'أدركنا أن ما نشعر به أكبر من مجرد صدفة جميلة'],
            ['year'=>'خطوة جديدة','icon'=>'💍','title'=>'الخطبة','desc'=>'سؤال واحد غيّر مسار الحياة إلى الأبد'],
            ['year'=>'اليوم الكبير','icon'=>'🎊','title'=>'حفل الزفاف','desc'=> $event->event_date->translatedFormat('d F Y').' · '.$event->venue_name],
        ];
        @endphp
        @foreach($milestones as $m)
        <div class="tl-item">
            <div class="tl-dot">{{ $m['icon'] }}</div>
            <div class="tl-content">
                <div class="tl-year">{{ $m['year'] }}</div>
                <div class="tl-name">{{ $m['title'] }}</div>
                <div class="tl-desc">{{ $m['desc'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── DETAILS ON LETTER PAPER ── --}}
<section class="details-section">
    <div class="section-header" style="margin-bottom:40px">
        <div class="sec-badge">تفاصيل الحفل</div>
        <div class="sec-title">كل ما تحتاج معرفته</div>
        <div class="sec-line"></div>
    </div>
    <div class="letter-paper">
        <div class="hole"></div><div class="hole"></div><div class="hole"></div>
        <div class="lp-content">
            <div class="lp-greeting">أعزّاؤنا،</div>
            <div class="lp-body">
                <p>يسعدنا أن ندعوكم بكل محبة وتقدير لحضور حفل زفافنا، الذي سيُقام في أجواء من الفرح والبهجة.</p>
                <br>
                <div class="lp-row">
                    <span class="lp-row-icon">📅</span>
                    <div class="lp-row-text"><strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong><span>{{ $event->event_time ?? '7:00 مساءً' }}</span></div>
                </div>
                <div class="lp-row">
                    <span class="lp-row-icon">📍</span>
                    <div class="lp-row-text"><strong>{{ $event->venue_name }}</strong>@if($event->venue_address)<span>{{ $event->venue_address }}</span>@endif</div>
                </div>
                @if($event->dress_code)
                <div class="lp-row">
                    <span class="lp-row-icon">👗</span>
                    <div class="lp-row-text"><strong>{{ $event->dress_code }}</strong><span>كود اللبس</span></div>
                </div>
                @endif
                <br>
                <p>نتطلع إلى رؤيتكم في هذه الليلة الخاصة.</p>
            </div>
            <div class="lp-sig">{{ $event->groom_name }} & {{ $event->bride_name }} 💕</div>
        </div>
    </div>
</section>

{{-- ── GALLERY (polaroid photos) ── --}}
@if($event->galleryImages && count($event->galleryImages) > 0)
<section class="gallery-section">
    <div class="section-header">
        <div class="sec-badge">ذكريات</div>
        <div class="sec-title">لحظاتنا المميزة</div>
        <div class="sec-line"></div>
    </div>
    <div class="photo-strip">
        @php $rots = [-3,-1,2,-2,1,-3,2,0,-1,3]; @endphp
        @foreach($event->galleryImages as $i => $img)
        <div class="photo-item" style="--rot:{{ $rots[$i % count($rots)] }}deg">
            <img src="{{ asset('storage/'.$img) }}" alt="صورة" class="photo-img">
            <div class="photo-cap">ذكرى جميلة 📷</div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── STICKY NOTES GUESTBOOK ── --}}
@if($event->plan?->feature('guest_book'))
<section class="sticky-section">
    <div class="section-header">
        <div class="sec-badge">✏️ بطاقات التهنئة</div>
        <div class="sec-title">اكتب تهنئتك</div>
        <div class="sec-line"></div>
    </div>
    @php
    $stickyClrs = ['#fef3c7','#fce7f3','#dbeafe','#dcfce7','#fef9c3','#f3e8ff'];
    $stickyRots = [-3,-1,2,-2,1,3,-2,0];
    $wishes = $event->guestbookEntries ?? [];
    @endphp
    <div class="sticky-grid">
        @forelse($wishes as $i => $w)
        <div class="sticky-note" style="--sn-clr:{{ $stickyClrs[$i%count($stickyClrs)] }};--sn-rot:{{ $stickyRots[$i%count($stickyRots)] }}deg">
            <div class="sn-text">{{ $w->message ?? $w }}</div>
            <div class="sn-author">— {{ $w->name ?? 'مجهول' }}</div>
        </div>
        @empty
        @for($i=0;$i<4;$i++)
        <div class="sticky-note" style="--sn-clr:{{ $stickyClrs[$i] }};--sn-rot:{{ $stickyRots[$i] }}deg">
            <div class="sn-text">ألف مبروك للعروسين، دام فرحكما وزاد 💕</div>
            <div class="sn-author">— أحد المدعوين</div>
        </div>
        @endfor
        @endforelse
    </div>
    <div style="max-width:400px;margin:40px auto 0;text-align:center">
        <div class="sticky-note" style="--sn-clr:#fff9c4;--sn-rot:0deg;display:block;max-width:100%">
            <form x-data="{sent:false}" @submit.prevent="sent=true">
                <textarea x-show="!sent" style="width:100%;background:transparent;border:none;outline:none;font-family:'Dancing Script',cursive;font-size:16px;color:#2c1810;resize:none;min-height:80px" placeholder="اكتب تهنئتك هنا..."></textarea>
                <input x-show="!sent" style="width:100%;background:transparent;border:none;border-top:1px dashed #c8a882;outline:none;font-family:'Tajawal',sans-serif;font-size:13px;color:#7a5c4a;padding:8px 0" placeholder="اسمك">
                <button x-show="!sent" type="submit" style="margin-top:10px;padding:8px 20px;background:var(--wine);color:#fff;border:none;border-radius:3px;font-family:'Tajawal',sans-serif;cursor:pointer">الصق الملاحظة 📌</button>
                <div x-show="sent" style="padding:16px;color:var(--wine);font-size:16px">تم إرسال تهنئتك ✓</div>
            </form>
        </div>
    </div>
</section>
@endif

{{-- ── RSVP ── --}}
@if($event->plan?->feature('rsvp'))
<section class="rsvp-section">
    <div class="section-header" style="margin-bottom:40px">
        <div class="sec-badge" style="color:var(--gold-l)">💌 رد الدعوة</div>
        <div class="sec-title" style="color:#fff">نتشوق لحضوركم</div>
        <div class="sec-line" style="background:linear-gradient(90deg,transparent,var(--gold),transparent)"></div>
    </div>
    <div class="rsvp-card" data-d="{{ $event->event_date->format('d/m/Y') }}">
        <div class="rsvp-title">بطاقة الرد</div>
        <template x-if="!rsvpSent">
            <form @submit.prevent="rsvpSent=true">
                <div class="rsvp-field"><label class="rsvp-label">الاسم الكريم</label><input type="text" class="rsvp-input" placeholder="أدخل اسمك" required></div>
                <div class="rsvp-field">
                    <label class="rsvp-label">الحضور</label>
                    <div class="rsvp-radios">
                        <label class="rsvp-radio"><input type="radio" name="att" value="yes"> سأحضر بكل سرور ✓</label>
                        <label class="rsvp-radio"><input type="radio" name="att" value="no"> آسف، لن أتمكن من الحضور</label>
                    </div>
                </div>
                <div class="rsvp-field"><label class="rsvp-label">عدد الأفراد</label><input type="number" min="1" max="10" class="rsvp-input" value="1"></div>

                <div class="form-group">
                    <label class="form-label">ملاحظات <span style="opacity:.6; font-size:.85em;">(اختياري)</span></label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="مثال: حساسية من المكسرات، قادمون من خارج المدينة..." style="resize:vertical; min-height:70px;">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="rsvp-btn">أرسل بطاقة الرد 💌</button>
            </form>
        </template>
        <template x-if="rsvpSent">
            <div style="text-align:center;padding:40px 0">
                <div style="font-size:50px;margin-bottom:16px">💕</div>
                <div style="font-family:'Playfair Display',serif;font-size:22px;color:var(--wine);margin-bottom:10px">شكراً على ردكم الجميل</div>
                <div style="color:var(--muted);font-size:14px">نتطلع لرؤيتكم في يوم الفرح</div>
            </div>
        </template>
    </div>
</section>
@endif

<footer class="footer-section">
    <span class="footer-logo">فرحنا 💕</span>
    {{ $event->coupleName() }} · {{ $event->event_date->translatedFormat('d F Y') }}<br><br>
    صُنع بكل محبة · فرحنا لإدارة المناسبات
</footer>

@include('partials.venue-map')
@include('partials.whatsapp-share')
@include('partials.music-player')
</body>
</html>
