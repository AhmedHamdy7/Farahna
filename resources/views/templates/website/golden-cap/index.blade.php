<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->displayTitle() }} – حفل التخرج</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        :root {
            --navy:    #0d1b3e;
            --navy2:   #152247;
            --navy3:   #1c2d5a;
            --gold:    #d4a843;
            --gold-l:  #f0c96a;
            --gold-d:  #a07828;
            --cream:   #fef9ec;
            --text:    #1a1a2e;
            --muted:   #6b7a99;
            --pb-accent:   #d4a843;
            --pb-btn-text: #0d1b3e;
        }

        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; background:var(--cream); color:var(--text); overflow-x:hidden; }


        /* ─── ANIMATIONS ─── */
        @keyframes cap-fly {
            0%   { transform:translate(var(--sx,0),110vh) rotate(var(--r,0deg)); opacity:1; }
            80%  { opacity:1; }
            100% { transform:translate(var(--ex,20px),-10vh) rotate(var(--r2,360deg)); opacity:0; }
        }
        @keyframes diploma-unfurl {
            from { transform:scaleY(0) translateY(-30px); opacity:0; }
            to   { transform:scaleY(1) translateY(0); opacity:1; }
        }
        @keyframes gold-shimmer {
            0%,100% { background-position:0% 50%; }
            50%     { background-position:100% 50%; }
        }
        @keyframes float-slow {
            0%,100% { transform:translateY(0); }
            50%     { transform:translateY(-12px); }
        }
        @keyframes star-pop {
            0%   { transform:scale(0) rotate(-30deg); opacity:0; }
            60%  { transform:scale(1.2) rotate(10deg); opacity:1; }
            100% { transform:scale(1) rotate(0deg); opacity:1; }
        }

        /* ─── HERO ─── */
        .hero-section {
            min-height:100vh; position:relative; overflow:hidden;
            background:linear-gradient(160deg,var(--navy) 0%,var(--navy2) 50%,#0a1428 100%);
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:80px 20px 60px;
        }
        .hero-section::before {
            content:''; position:absolute; inset:0; pointer-events:none;
            background-image:radial-gradient(circle,rgba(212,168,67,.15) 1px,transparent 1px);
            background-size:40px 40px;
        }
        .hero-section::after {
            content:''; position:absolute; inset:0; pointer-events:none;
            background:radial-gradient(ellipse at 50% 60%,rgba(212,168,67,.12) 0%,transparent 60%);
        }
        .cap-particle {
            position:absolute; font-size:var(--fs,28px);
            animation:cap-fly var(--dur,4s) var(--delay,0s) ease-out infinite;
            left:var(--lx,50%); pointer-events:none; z-index:1;
        }
        .hero-wrap { position:relative; z-index:2; display:flex; flex-direction:column; align-items:center; }

        /* ── ENVELOPE ── */
        .envelope {
            width:min(480px,88vw); position:relative; cursor:pointer;
            filter:drop-shadow(0 24px 60px rgba(0,0,0,.7));
            perspective:1000px;
        }
        /* Envelope body */
        .env-body {
            width:100%; padding-top:65%;
            background:linear-gradient(145deg,var(--navy2),var(--navy3));
            border-radius:4px 4px 8px 8px; position:relative;
            border:1.5px solid var(--gold-d);
        }
        /* V-fold lines gold */
        .env-body::before {
            content:''; position:absolute; inset:0;
            background:
                linear-gradient(135deg,transparent 49.8%,rgba(212,168,67,.25) 50%,rgba(212,168,67,.25) 50.3%,transparent 50.5%) 0 0,
                linear-gradient(225deg,transparent 49.8%,rgba(212,168,67,.25) 50%,rgba(212,168,67,.25) 50.3%,transparent 50.5%) 0 0;
            background-size:50% 100%; background-repeat:no-repeat;
        }
        /* Flap */
        .env-flap {
            position:absolute; top:0; left:0; right:0; height:55%;
            transform-origin:top center; transform:rotateX(0deg);
            transition:transform .85s cubic-bezier(.4,0,.2,1); z-index:3;
        }
        .env-flap::before {
            content:''; position:absolute; inset:0;
            background:linear-gradient(160deg,var(--navy3),#0a1428);
            clip-path:polygon(0 0,50% 100%,100% 0);
            border-bottom:1.5px solid var(--gold-d);
        }
        .envelope.opened .env-flap { transform:rotateX(-185deg); }

        /* Wax seal 🎓 */
        .wax-seal {
            position:absolute; top:calc(55% - 30px); left:50%; transform:translateX(-50%);
            width:60px; height:60px; z-index:4;
            transition:opacity .3s .1s, transform .3s .1s;
        }
        .envelope.opened .wax-seal { opacity:0; transform:translateX(-50%) scale(.4); pointer-events:none; }
        .wax-circle {
            width:100%; height:100%; border-radius:50%;
            background:radial-gradient(circle at 35% 35%,var(--gold-l),var(--gold) 50%,var(--gold-d));
            display:flex; align-items:center; justify-content:center; font-size:24px;
            box-shadow:0 4px 16px rgba(0,0,0,.6),inset 0 -2px 6px rgba(0,0,0,.3);
            border:2px solid rgba(255,255,255,.15);
        }

        /* Tap hint */
        .tap-hint {
            margin-top:18px; font-family:'Cinzel',serif; font-size:12px;
            letter-spacing:4px; color:rgba(212,168,67,.7); text-transform:uppercase;
            animation:float-slow 2s ease-in-out infinite;
            transition:opacity .3s;
        }

        /* ── DIPLOMA (rises from envelope) ── */
        .diploma-card {
            width:min(460px,85vw);
            background:linear-gradient(165deg,#fef9ec,#fdf3d6);
            border:2px solid var(--gold-d); border-radius:4px;
            padding:0; position:relative; text-align:center;
            box-shadow:0 30px 80px rgba(0,0,0,.6);
            margin-top:-16px; z-index:1;
            transform:translateY(60px); opacity:0;
            transition:transform 1s .25s cubic-bezier(.4,0,.2,1), opacity 1s .25s;
            overflow:visible;
        }
        .diploma-card.visible { transform:translateY(0); opacity:1; }

        /* Gold scroll rods top/bottom */
        .diploma-card::before,.diploma-card::after {
            content:''; position:absolute; left:-6px; right:-6px; height:20px;
            background:linear-gradient(90deg,var(--gold-d),var(--gold-l) 30%,var(--gold) 50%,var(--gold-l) 70%,var(--gold-d));
            border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.3);
            z-index:5;
        }
        .diploma-card::before { top:-10px; }
        .diploma-card::after  { bottom:-10px; }

        /* Inner border */
        .diploma-inner {
            border:1px solid rgba(212,168,67,.4); margin:28px 24px;
            padding:24px 20px; position:relative;
        }
        .diploma-inner::before,.diploma-inner::after {
            content:'✦'; position:absolute; color:var(--gold); font-size:14px;
        }
        .diploma-inner::before { top:8px; right:8px; }
        .diploma-inner::after  { bottom:8px; left:8px; }

        .hero-sub { font-family:'Cinzel',serif; font-size:clamp(10px,2vw,12px); letter-spacing:5px; color:var(--gold-d); margin-bottom:16px; text-transform:uppercase; }
        .hero-name {
            font-family:'Cinzel',serif; font-size:clamp(28px,7vw,60px);
            background:linear-gradient(135deg,var(--gold-d),var(--gold-l),var(--gold-d));
            background-size:200% 200%;
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text; animation:gold-shimmer 3s ease infinite;
            line-height:1.2; margin:10px 0;
        }
        .hero-divider { width:100px; height:2px; background:linear-gradient(90deg,transparent,var(--gold),transparent); margin:16px auto; position:relative; }
        .hero-divider::before { content:'🎓'; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-size:18px; background:linear-gradient(165deg,#fef9ec,#fdf3d6); padding:0 8px; }
        .hero-event { font-size:clamp(13px,3vw,16px); color:var(--muted); line-height:2; margin-top:8px; }
        .hero-event strong { color:var(--text); font-weight:700; }
        .hero-stamp { animation:float-slow 3s ease-in-out infinite; display:inline-block; margin-top:16px; }
        .stamp-circle {
            width:72px; height:72px; border-radius:50%; margin:0 auto;
            border:3px solid var(--gold); display:flex; flex-direction:column;
            align-items:center; justify-content:center; gap:2px;
            background:rgba(212,168,67,.1);
        }
        .stamp-year { font-family:'Cinzel',serif; font-size:16px; font-weight:700; color:var(--gold); line-height:1; }
        .stamp-text { font-size:8px; letter-spacing:2px; color:var(--muted); }

        /* ─── COUNTDOWN ─── */
        .countdown-section { padding:70px 20px; background:var(--navy); }
        .sec-hdr { text-align:center; margin-bottom:50px; }
        .sec-badge { font-family:'Cinzel',serif; font-size:11px; letter-spacing:5px; color:var(--gold); text-transform:uppercase; display:block; margin-bottom:10px; }
        .sec-title { font-family:'Cinzel',serif; font-size:clamp(22px,4vw,36px); color:#fff; }
        .sec-line  { width:80px; height:1px; background:linear-gradient(90deg,transparent,var(--gold),transparent); margin:16px auto 0; }

        .cd-wrap { display:flex; justify-content:center; gap:clamp(16px,4vw,40px); flex-wrap:wrap; }
        .cd-box { text-align:center; }
        .cd-num {
            width:88px; height:88px;
            background:linear-gradient(145deg,var(--navy3),var(--navy));
            border:2px solid var(--gold-d); border-radius:6px;
            font-family:'Cinzel',serif; font-size:36px; font-weight:700; color:var(--gold-l);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 0 20px rgba(212,168,67,.2),inset 0 1px 0 rgba(212,168,67,.2);
        }
        .cd-lbl { font-size:11px; letter-spacing:3px; color:var(--muted); margin-top:8px; text-transform:uppercase; }

        /* ─── ACHIEVEMENT TIMELINE ─── */
        .timeline-section { padding:80px 20px; background:var(--cream); position:relative; overflow:hidden; }
        .timeline-section::before {
            content:''; position:absolute; inset:0;
            background:radial-gradient(circle at 90% 10%,rgba(212,168,67,.06) 0%,transparent 50%);
        }
        .timeline { max-width:650px; margin:0 auto; position:relative; }
        .timeline::before {
            content:''; position:absolute; right:20px; top:0; bottom:0; width:2px;
            background:linear-gradient(180deg,transparent,var(--gold) 10%,var(--gold) 90%,transparent);
        }
        .tl-item { padding-right:56px; margin-bottom:44px; position:relative; }
        .tl-dot {
            position:absolute; right:9px; top:4px;
            width:24px; height:24px; border-radius:50%;
            background:var(--gold); border:3px solid var(--cream);
            box-shadow:0 0 0 2px var(--gold-d),0 4px 10px rgba(212,168,67,.4);
            display:flex; align-items:center; justify-content:center; font-size:11px;
        }
        .tl-card {
            background:#fff; border:1px solid rgba(212,168,67,.25); border-radius:8px;
            padding:20px 22px; box-shadow:0 4px 16px rgba(0,0,0,.06);
        }
        .tl-year { font-family:'Cinzel',serif; font-size:12px; color:var(--gold); letter-spacing:2px; margin-bottom:4px; }
        .tl-title { font-family:'Cinzel',serif; font-size:17px; color:var(--text); margin-bottom:6px; }
        .tl-desc  { font-size:14px; color:var(--muted); line-height:1.7; }

        /* ─── CERTIFICATE DETAILS ─── */
        .cert-section { padding:80px 20px; background:var(--navy); }
        .certificate {
            max-width:680px; margin:0 auto;
            background:linear-gradient(145deg,#fef9ec,#fdf3d6);
            border:3px solid var(--gold-d); border-radius:4px; padding:50px 48px;
            position:relative; text-align:center;
            box-shadow:0 30px 80px rgba(0,0,0,.5),inset 0 0 40px rgba(212,168,67,.04);
        }
        /* Outer border */
        .certificate::before {
            content:''; position:absolute; inset:8px;
            border:1px solid rgba(212,168,67,.4); border-radius:2px; pointer-events:none;
        }
        .cert-corner { position:absolute; font-size:20px; color:var(--gold); }
        .cert-corner:nth-child(1) { top:16px; right:16px; }
        .cert-corner:nth-child(2) { top:16px; left:16px; }
        .cert-corner:nth-child(3) { bottom:16px; right:16px; }
        .cert-corner:nth-child(4) { bottom:16px; left:16px; }
        .cert-top { font-family:'Cinzel',serif; font-size:11px; letter-spacing:6px; color:var(--gold-d); text-transform:uppercase; margin-bottom:16px; }
        .cert-title { font-family:'Cinzel',serif; font-size:clamp(22px,4vw,36px); color:var(--text); margin-bottom:8px; }
        .cert-name-big { font-family:'Cinzel',serif; font-size:clamp(26px,5vw,44px); background:linear-gradient(135deg,var(--gold-d),var(--gold-l)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin:16px 0; }
        .cert-divider { width:100px; height:1px; background:linear-gradient(90deg,transparent,var(--gold-d),transparent); margin:20px auto; }
        .cert-details { font-size:15px; color:var(--muted); line-height:2; }
        .cert-details strong { color:var(--text); font-weight:700; }
        .cert-seal {
            width:80px; height:80px; border-radius:50%; border:2px solid var(--gold-d);
            margin:24px auto 0; background:rgba(212,168,67,.08);
            display:flex; flex-direction:column; align-items:center; justify-content:center; gap:3px;
        }
        .cert-seal-inner { font-size:24px; } .cert-seal-text { font-size:9px; letter-spacing:2px; color:var(--gold-d); }

        /* ─── GALLERY ─── */
        .gallery-section { padding:80px 20px; background:var(--cream); }
        .gallery-grid { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:16px; }
        .gallery-item { position:relative; border-radius:6px; overflow:hidden; aspect-ratio:1; background:linear-gradient(135deg,#1c2d5a,#0d1b3e); cursor:pointer; box-shadow:0 4px 16px rgba(0,0,0,.1); transition:transform .2s,box-shadow .2s; }
        .gallery-item:hover { transform:scale(1.04); box-shadow:0 8px 30px rgba(212,168,67,.2); }
        .gallery-item img { width:100%; height:100%; object-fit:cover; display:block; }
        .gallery-item::after { content:''; position:absolute; inset:0; border:2px solid transparent; border-radius:6px; transition:border-color .2s; }
        .gallery-item:hover::after { border-color:var(--gold); }

        /* ─── WISHES ─── */
        .wishes-section { padding:80px 20px; background:var(--navy2); }
        .wishes-grid { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }
        .wish-card { background:var(--navy3); border:1px solid rgba(212,168,67,.2); border-radius:8px; padding:22px; }
        .wish-card:hover { border-color:var(--gold); box-shadow:0 0 20px rgba(212,168,67,.1); transition:all .2s; }
        .wish-text { font-size:14px; color:rgba(255,255,255,.75); line-height:1.8; }
        .wish-author { font-family:'Cinzel',serif; font-size:12px; color:var(--gold); margin-top:12px; letter-spacing:1px; }
        .wish-form-wrap { max-width:500px; margin:40px auto 0; background:var(--navy3); border:1px solid rgba(212,168,67,.2); border-radius:8px; padding:28px; }
        .wf-input { width:100%; padding:12px 14px; margin-bottom:12px; background:rgba(212,168,67,.05); border:1px solid rgba(212,168,67,.25); border-radius:4px; color:#fff; font-family:'Tajawal',sans-serif; font-size:14px; outline:none; resize:none; transition:border-color .2s; }
        .wf-input:focus { border-color:var(--gold); }
        .wf-input::placeholder { color:rgba(255,255,255,.35); }
        .wf-btn { width:100%; padding:14px; background:var(--gold); color:var(--navy); border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:15px; font-weight:700; cursor:pointer; letter-spacing:1px; transition:all .2s; }
        .wf-btn:hover { background:var(--gold-l); }

        /* ─── RSVP ─── */
        .rsvp-section { padding:80px 20px; background:var(--cream); }
        .rsvp-card { max-width:560px; margin:0 auto; background:var(--navy); border:2px solid var(--gold-d); border-radius:6px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.2); }
        .rsvp-head { background:linear-gradient(135deg,var(--navy3),var(--navy)); padding:28px 32px; text-align:center; border-bottom:1px solid rgba(212,168,67,.2); }
        .rsvp-head-title { font-family:'Cinzel',serif; font-size:22px; color:var(--gold-l); letter-spacing:2px; }
        .rsvp-head-sub { font-size:13px; color:rgba(255,255,255,.5); margin-top:6px; }
        .rsvp-body { padding:32px; }
        .rsvp-label { display:block; font-size:12px; letter-spacing:2px; color:var(--gold); margin-bottom:8px; }
        .rsvp-input { width:100%; padding:12px 14px; margin-bottom:20px; background:rgba(212,168,67,.05); border:1px solid rgba(212,168,67,.2); border-radius:4px; color:#fff; font-family:'Tajawal',sans-serif; font-size:14px; outline:none; transition:border-color .2s; }
        .rsvp-input:focus { border-color:var(--gold); }
        .rsvp-input::placeholder { color:rgba(255,255,255,.3); }
        .rsvp-radios { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
        .rsvp-radio-btn { flex:1; min-width:130px; padding:12px; border:1.5px solid rgba(212,168,67,.3); border-radius:4px; color:rgba(255,255,255,.6); font-family:'Tajawal',sans-serif; font-size:13px; font-weight:600; cursor:pointer; text-align:center; transition:all .2s; background:transparent; }
        .rsvp-radio-btn.active,.rsvp-radio-btn:hover { border-color:var(--gold); color:var(--gold); background:rgba(212,168,67,.08); }
        .rsvp-submit { width:100%; padding:16px; background:linear-gradient(135deg,var(--gold-d),var(--gold)); color:var(--navy); border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:16px; font-weight:700; cursor:pointer; letter-spacing:1px; box-shadow:0 6px 20px rgba(212,168,67,.3); transition:all .2s; }
        .rsvp-submit:hover { box-shadow:0 8px 30px rgba(212,168,67,.5); transform:translateY(-2px); }
        .rsvp-success { text-align:center; padding:50px 20px; }

        /* ─── FOOTER ─── */
        .footer-section { padding:40px 20px; background:#080e20; text-align:center; color:rgba(255,255,255,.4); font-size:13px; }
        .footer-logo { font-family:'Cinzel',serif; font-size:22px; color:var(--gold); margin-bottom:10px; display:block; }

        @media (max-width:600px) {
            .diploma-wrap { padding:24px 20px; }
            .certificate { padding:32px 20px; }
            .rsvp-body { padding:20px; }
        }
    </style>
</head>
<body x-data="{
    opened:false, rsvpSent:false, attendance:'',
    days:0, hours:0, mins:0, secs:0,
    initCountdown(t){ const f=()=>{ const d=new Date(t)-new Date(); if(d<=0)return; this.days=Math.floor(d/864e5); this.hours=Math.floor(d%864e5/36e5); this.mins=Math.floor(d%36e5/6e4); this.secs=Math.floor(d%6e4/1e3); }; f(); setInterval(f,1000); }
}" x-init="initCountdown('{{ $event->event_date->format('Y-m-d') }}')">

@if($isPreview ?? false)
@include('partials.preview-bar')
@endif

{{-- ── HERO ── --}}
<section class="hero-section">
    @php
    $caps = [
        ['lx'=>'5%','fs'=>'32px','dur'=>'5s','delay'=>'0s','sx'=>'0','ex'=>'10px','r'=>'-15deg','r2'=>'200deg'],
        ['lx'=>'15%','fs'=>'24px','dur'=>'6.5s','delay'=>'1s','sx'=>'5px','ex'=>'-20px','r'=>'20deg','r2'=>'-180deg'],
        ['lx'=>'30%','fs'=>'36px','dur'=>'4.5s','delay'=>'2s','sx'=>'-10px','ex'=>'30px','r'=>'-5deg','r2'=>'270deg'],
        ['lx'=>'55%','fs'=>'28px','dur'=>'7s','delay'=>'0.5s','sx'=>'8px','ex'=>'-15px','r'=>'30deg','r2'=>'-200deg'],
        ['lx'=>'70%','fs'=>'40px','dur'=>'5.5s','delay'=>'1.5s','sx'=>'-5px','ex'=>'20px','r'=>'-20deg','r2'=>'180deg'],
        ['lx'=>'85%','fs'=>'26px','dur'=>'6s','delay'=>'3s','sx'=>'12px','ex'=>'-8px','r'=>'10deg','r2'=>'-270deg'],
        ['lx'=>'92%','fs'=>'30px','dur'=>'4s','delay'=>'2.5s','sx'=>'-8px','ex'=>'5px','r'=>'-25deg','r2'=>'220deg'],
    ];
    @endphp
    @foreach($caps as $c)
    <div class="cap-particle" style="--lx:{{$c['lx']}};--fs:{{$c['fs']}};--dur:{{$c['dur']}};--delay:{{$c['delay']}};--sx:{{$c['sx']}};--ex:{{$c['ex']}};--r:{{$c['r']}};--r2:{{$c['r2']}}">🎓</div>
    @endforeach

    <div class="hero-wrap">

        {{-- ─ Envelope ─ --}}
        <div class="envelope" :class="{ opened: opened }" @click="if(!opened){ opened=true }">
            <div class="env-body">
                <div class="env-flap"></div>
            </div>
            <div class="wax-seal">
                <div class="wax-circle">🎓</div>
            </div>
        </div>

        {{-- Tap hint --}}
        <div class="tap-hint" x-show="!opened">انقر لفتح الدعوة ✦</div>

        {{-- ─ Diploma rises out ─ --}}
        <div class="diploma-card" :class="{ visible: opened }">
            <div class="diploma-inner">
                <div class="hero-sub">تشرف بدعوتكم لحضور</div>
                <div class="hero-name">{{ $event->groom_name }}</div>
                <div class="hero-divider"></div>
                <div class="hero-event">
                    في حفل تخرجه من<br>
                    <strong>{{ $event->venue_name }}</strong><br>
                    <strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong>
                    @if($event->event_time) · {{ $event->event_time }} @endif
                </div>
                <div class="hero-stamp">
                    <div class="stamp-circle">
                        <span class="stamp-year">{{ $event->event_date->year }}</span>
                        <span class="stamp-text">مبروك</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ── COUNTDOWN ── --}}
<section class="countdown-section">
    <div class="sec-hdr">
        <span class="sec-badge">⏳ العد التنازلي</span>
        <div class="sec-title">حتى اللحظة الكبيرة</div>
        <div class="sec-line"></div>
    </div>
    <div class="cd-wrap">
        <div class="cd-box"><div class="cd-num" x-text="String(days).padStart(2,'0')">00</div><div class="cd-lbl">يوم</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(hours).padStart(2,'0')">00</div><div class="cd-lbl">ساعة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(mins).padStart(2,'0')">00</div><div class="cd-lbl">دقيقة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(secs).padStart(2,'0')">00</div><div class="cd-lbl">ثانية</div></div>
    </div>
</section>

{{-- ── ACHIEVEMENT TIMELINE ── --}}
<section class="timeline-section">
    <div class="sec-hdr">
        <span class="sec-badge" style="color:var(--gold-d)">رحلة النجاح</span>
        <div class="sec-title" style="color:var(--text)">من البداية للقمة</div>
        <div class="sec-line" style="background:linear-gradient(90deg,transparent,var(--gold-d),transparent)"></div>
    </div>
    <div class="timeline">
        @php
        $milestones = [
            ['year'=>'البداية','icon'=>'📚','title'=>'أول يوم دراسة','desc'=>'رحلة ألف ميل تبدأ بخطوة واحدة'],
            ['year'=>'النضج','icon'=>'💡','title'=>'اكتشاف الشغف','desc'=>'حين وجد طريقه ورسم خارطة نجاحه'],
            ['year'=>'التميز','icon'=>'🏆','title'=>'الإنجازات والتكريم','desc'=>'تعب لم يضيع، وجهد لم يذهب سدى'],
            ['year'=>$event->event_date->year,'icon'=>'🎓','title'=>'يوم التتويج','desc'=>$event->event_date->translatedFormat('d F Y').' · '.$event->venue_name],
        ];
        @endphp
        @foreach($milestones as $m)
        <div class="tl-item">
            <div class="tl-dot">{{ $m['icon'] }}</div>
            <div class="tl-card">
                <div class="tl-year">{{ $m['year'] }}</div>
                <div class="tl-title">{{ $m['title'] }}</div>
                <div class="tl-desc">{{ $m['desc'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── CERTIFICATE DETAILS ── --}}
<section class="cert-section">
    <div class="sec-hdr" style="margin-bottom:40px">
        <span class="sec-badge">تفاصيل الحفل</span>
        <div class="sec-title" style="color:#fff">شهادة الدعوة</div>
        <div class="sec-line"></div>
    </div>
    <div class="certificate">
        <span class="cert-corner">✦</span><span class="cert-corner">✦</span>
        <span class="cert-corner">✦</span><span class="cert-corner">✦</span>
        <div class="cert-top">حفل تخرج رسمي</div>
        <div class="cert-title">يُشرف بحضوركم</div>
        <div class="cert-name-big">{{ $event->groom_name }}</div>
        <div class="cert-divider"></div>
        <div class="cert-details">
            📅 <strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong>
            @if($event->event_time) · {{ $event->event_time }} @endif<br>
            📍 <strong>{{ $event->venue_name }}</strong>
            @if($event->venue_address)<br><small>{{ $event->venue_address }}</small>@endif
            @if($event->dress_code)<br>👗 <strong>{{ $event->dress_code }}</strong>@endif
        </div>
        <div class="cert-seal">
            <div class="cert-seal-inner">🎓</div>
            <div class="cert-seal-text">GRAD · {{ $event->event_date->year }}</div>
        </div>
    </div>
</section>

{{-- ── GALLERY ── --}}
@if($event->galleryImages && count($event->galleryImages) > 0)
<section class="gallery-section">
    <div class="sec-hdr">
        <span class="sec-badge" style="color:var(--gold-d)">ذكريات الرحلة</span>
        <div class="sec-title" style="color:var(--text)">أجمل اللحظات</div>
        <div class="sec-line" style="background:linear-gradient(90deg,transparent,var(--gold-d),transparent)"></div>
    </div>
    <div class="gallery-grid">
        @foreach($event->galleryImages as $img)
        <div class="gallery-item">
            <img src="{{ asset('storage/'.$img) }}" alt="صورة">
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── WISHES ── --}}
@if($event->plan?->feature('guest_book'))
<section class="wishes-section">
    <div class="sec-hdr" style="margin-bottom:40px">
        <span class="sec-badge">كلمات التهنئة</span>
        <div class="sec-title" style="color:#fff">ألف مبروك يا نجم</div>
        <div class="sec-line"></div>
    </div>
    <div class="wishes-grid">
        @php $wishes = $event->guestbookEntries ?? []; @endphp
        @forelse($wishes as $w)
        <div class="wish-card"><div class="wish-text">{{ $w->message ?? $w }}</div><div class="wish-author">— {{ $w->name ?? 'مجهول' }}</div></div>
        @empty
        @for($i=0;$i<3;$i++)
        <div class="wish-card"><div class="wish-text">ألف مبروك يا بطل! تعبك ما راح وجهدك ثمر. الله يكمل عليك بالتوفيق 🎓</div><div class="wish-author">— أحد المهنئين</div></div>
        @endfor
        @endforelse
    </div>
    <div class="wish-form-wrap" x-data="{sent:false}">
        <template x-if="!sent">
            <div>
                <textarea class="wf-input" rows="3" placeholder="اكتب تهنئتك للخريج..."></textarea>
                <input type="text" class="wf-input" placeholder="اسمك">
                <button class="wf-btn" @click="sent=true">🎓 أرسل تهنئتك</button>
            </div>
        </template>
        <template x-if="sent">
            <div style="text-align:center;padding:24px;color:var(--gold-l);font-size:18px">تم إرسال التهنئة ✓ 🎓</div>
        </template>
    </div>
</section>
@endif

{{-- ── RSVP ── --}}
@if($event->plan?->feature('rsvp'))
<section class="rsvp-section">
    <div class="sec-hdr" style="margin-bottom:40px">
        <span class="sec-badge" style="color:var(--gold-d)">تأكيد الحضور</span>
        <div class="sec-title" style="color:var(--text)">هل ستحضر الحفل؟</div>
        <div class="sec-line" style="background:linear-gradient(90deg,transparent,var(--gold-d),transparent)"></div>
    </div>
    <div class="rsvp-card">
        <div class="rsvp-head">
            <div class="rsvp-head-title">RSVP</div>
            <div class="rsvp-head-sub">{{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        <div class="rsvp-body">
            <template x-if="!rsvpSent">
                <div>
                    <label class="rsvp-label">اسمك</label>
                    <input type="text" class="rsvp-input" placeholder="أدخل اسمك الكريم">
                    <label class="rsvp-label">هل ستحضر؟</label>
                    <div class="rsvp-radios">
                        <button type="button" class="rsvp-radio-btn" :class="{active:attendance==='yes'}" @click="attendance='yes'">✓ سأحضر بالتأكيد</button>
                        <button type="button" class="rsvp-radio-btn" :class="{active:attendance==='no'}"  @click="attendance='no'">آسف، لن أتمكن</button>
                    </div>
                    <label class="rsvp-label">عدد الأفراد</label>
                    <input type="number" min="1" max="10" class="rsvp-input" value="1">
                    <button class="rsvp-submit" @click="rsvpSent=true">🎓 تأكيد الحضور</button>
                </div>
            </template>
            <template x-if="rsvpSent">
                <div class="rsvp-success">
                    <div style="font-size:48px;margin-bottom:16px">🎓</div>
                    <div style="font-family:'Cinzel',serif;font-size:22px;color:var(--gold-l)">شكراً لتأكيد حضوركم</div>
                    <div style="color:rgba(255,255,255,.5);margin-top:10px;font-size:14px">نتطلع لرؤيتكم في هذا اليوم المميز</div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

<footer class="footer-section">
    <span class="footer-logo">فرحنا 🎓</span>
    {{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}<br><br>
    صُنع بكل فخر واعتزاز · فرحنا لإدارة المناسبات
</footer>

</body>
</html>
