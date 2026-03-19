<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->displayTitle() }} – غروب الصحراء</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        :root {
            --terra:   #c4622d;
            --terra-l: #e07a45;
            --sand:    #e8c99a;
            --sand-l:  #f5e6cc;
            --rust:    #9b3d12;
            --sage:    #7a9e7e;
            --dusk:    #5c3d6e;
            --dusk-l:  #9b6db5;
            --sky:     #f7b733;
            --cream:   #fdf6ec;
            --dark:    #2a1506;
            --muted:   #8a6a50;
            --pb-accent:   #c4622d;
            --pb-btn-text: #fff;
        }

        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body { font-family:'Tajawal',sans-serif; background:var(--cream); color:var(--dark); overflow-x:hidden; }

        /* ─── ANIMATIONS ─── */
        @keyframes drift {
            0%   { transform:translateX(0) translateY(0); }
            50%  { transform:translateX(20px) translateY(-8px); }
            100% { transform:translateX(0) translateY(0); }
        }
        @keyframes sun-pulse {
            0%,100% { box-shadow:0 0 40px rgba(247,183,51,.3),0 0 80px rgba(196,98,45,.2); }
            50%     { box-shadow:0 0 70px rgba(247,183,51,.6),0 0 140px rgba(196,98,45,.4); }
        }
        @keyframes float-in {
            from { transform:translateY(40px); opacity:0; }
            to   { transform:translateY(0); opacity:1; }
        }
        @keyframes dust-float {
            0%   { transform:translate(0,0) rotate(0deg); opacity:0; }
            10%  { opacity:.6; }
            90%  { opacity:.3; }
            100% { transform:translate(var(--dx,30px),var(--dy,-60px)) rotate(180deg); opacity:0; }
        }
        @keyframes shimmer-h {
            0%,100% { background-position:0% 50%; }
            50%     { background-position:100% 50%; }
        }

        /* ─── HERO ─── */
        .hero {
            min-height:100vh; position:relative; overflow:hidden;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:80px 20px;
        }

        /* Sky gradient layers */
        .sky-bg {
            position:absolute; inset:0;
            background:linear-gradient(
                180deg,
                #2b1055 0%,
                #7b3f98 15%,
                #c4622d 35%,
                #e07a45 50%,
                #f7b733 62%,
                #f9d47c 72%,
                #fce8b2 80%,
                #fdf6ec 100%
            );
        }
        /* Sun orb */
        .sun {
            position:absolute; bottom:28%; left:50%; transform:translateX(-50%);
            width:120px; height:120px; border-radius:50%;
            background:radial-gradient(circle,#fff9e6 0%,#f7b733 40%,#e07a45 80%,transparent 100%);
            animation:sun-pulse 4s ease-in-out infinite;
        }
        /* Sun rays */
        .sun::before,.sun::after {
            content:''; position:absolute; inset:-30px; border-radius:50%;
            background:radial-gradient(circle,rgba(247,183,51,.25) 0%,transparent 70%);
        }
        .sun::after { inset:-60px; background:radial-gradient(circle,rgba(247,183,51,.1) 0%,transparent 70%); }

        /* Desert dunes silhouette */
        .dunes {
            position:absolute; bottom:0; left:0; right:0; height:35%;
            pointer-events:none;
        }
        .dunes svg { width:100%; height:100%; }

        /* Dust particles */
        .dust-particle {
            position:absolute; border-radius:50%;
            width:var(--s,4px); height:var(--s,4px);
            background:rgba(232,201,154,.6);
            animation:dust-float var(--dur,8s) var(--del,0s) ease-out infinite;
            left:var(--lx,50%); bottom:var(--ly,20%);
        }

        .hero-content { position:relative; z-index:2; text-align:center; max-width:680px; animation:float-in .9s ease forwards; }

        /* Boho frame */
        .boho-frame {
            background:rgba(253,246,236,.88);
            border:1.5px solid rgba(196,98,45,.3);
            border-radius:2px; padding:44px 48px;
            position:relative;
            box-shadow:0 20px 60px rgba(42,21,6,.25),0 4px 20px rgba(196,98,45,.15);
            backdrop-filter:blur(4px);
        }
        /* Rope border top/bottom */
        .boho-frame::before,.boho-frame::after {
            content:''; position:absolute; left:0; right:0; height:6px;
            background:repeating-linear-gradient(90deg,var(--terra) 0,var(--terra) 6px,var(--sand) 6px,var(--sand) 12px);
            opacity:.5;
        }
        .boho-frame::before { top:0; border-radius:2px 2px 0 0; }
        .boho-frame::after  { bottom:0; border-radius:0 0 2px 2px; }

        /* Feather ornaments */
        .feather { font-size:28px; opacity:.7; display:inline-block; }
        .feather.left  { transform:rotate(-30deg); }
        .feather.right { transform:rotate(30deg); }

        .hero-eyebrow { font-size:12px; letter-spacing:5px; color:var(--terra); margin-bottom:16px; text-transform:uppercase; display:flex; align-items:center; justify-content:center; gap:12px; }
        .hero-eyebrow::before,.hero-eyebrow::after { content:''; display:inline-block; width:30px; height:1px; background:linear-gradient(90deg,transparent,var(--terra)); }
        .hero-eyebrow::before { transform:scaleX(-1); }

        .hero-names {
            font-family:'Playfair Display',serif;
            font-size:clamp(30px,7vw,62px);
            background:linear-gradient(135deg,var(--rust),var(--terra-l),var(--sky));
            background-size:200% 200%; animation:shimmer-h 4s ease infinite;
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
            line-height:1.1; margin:8px 0;
        }
        .hero-amp { font-style:italic; font-size:.7em; -webkit-text-fill-color:var(--terra); }
        .hero-divider { margin:20px auto; display:flex; align-items:center; justify-content:center; gap:12px; }
        .hero-divider span { font-size:18px; }
        .hero-divider::before,.hero-divider::after { content:''; flex:1; max-width:80px; height:1px; background:linear-gradient(90deg,transparent,rgba(196,98,45,.4)); }
        .hero-divider::before { transform:scaleX(-1); }
        .hero-date { font-size:16px; color:var(--muted); line-height:2; }
        .hero-date strong { color:var(--dark); font-weight:700; }

        /* ─── SECTION HEADERS ─── */
        .sec-hdr { text-align:center; margin-bottom:50px; }
        .sec-tag  { font-size:11px; letter-spacing:5px; color:var(--terra); text-transform:uppercase; display:block; margin-bottom:10px; }
        .sec-title { font-family:'Playfair Display',serif; font-size:clamp(22px,4vw,34px); color:var(--dark); }
        .sec-ornament { display:flex; align-items:center; justify-content:center; gap:10px; margin-top:14px; }
        .sec-ornament::before,.sec-ornament::after { content:''; flex:1; max-width:60px; height:1px; background:linear-gradient(90deg,transparent,rgba(196,98,45,.35)); }
        .sec-ornament::before { transform:scaleX(-1); }
        .sec-ornament span { font-size:14px; }

        /* ─── COUNTDOWN ─── */
        .countdown-section { padding:70px 20px; background:var(--dark); }
        .cd-wrap { display:flex; justify-content:center; gap:clamp(16px,4vw,40px); flex-wrap:wrap; }
        .cd-box { text-align:center; }
        .cd-num {
            width:90px; height:90px; border-radius:8px;
            background:linear-gradient(145deg,rgba(196,98,45,.3),rgba(42,21,6,.6));
            border:1px solid rgba(232,201,154,.25);
            font-family:'Playfair Display',serif; font-size:38px; color:var(--sand-l);
            display:flex; align-items:center; justify-content:center;
            box-shadow:inset 0 1px 0 rgba(232,201,154,.2),0 4px 20px rgba(0,0,0,.3);
        }
        .cd-lbl { font-size:11px; letter-spacing:3px; color:var(--muted); margin-top:8px; text-transform:uppercase; }

        /* ─── DETAILS ─── */
        .details-section { padding:80px 20px; background:var(--cream); }
        .details-card {
            max-width:680px; margin:0 auto;
            background:#fff; border:1px solid rgba(196,98,45,.15);
            border-radius:4px; overflow:hidden;
            box-shadow:0 8px 40px rgba(42,21,6,.08);
        }
        .details-banner {
            height:12px;
            background:linear-gradient(90deg,var(--terra),var(--sky),var(--dusk-l),var(--terra));
            background-size:300% 100%; animation:shimmer-h 5s ease infinite;
        }
        .details-body { padding:40px 40px 36px; }
        .details-row { display:flex; align-items:flex-start; gap:16px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(196,98,45,.1); }
        .details-row:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }
        .details-icon { width:44px; height:44px; border-radius:50%; background:rgba(196,98,45,.1); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .details-info dt { font-size:12px; letter-spacing:2px; color:var(--terra); text-transform:uppercase; margin-bottom:4px; }
        .details-info dd { font-size:16px; color:var(--dark); font-weight:600; }

        /* ─── GALLERY ─── */
        .gallery-section { padding:80px 20px; background:var(--dark); }
        .gallery-masonry { max-width:900px; margin:0 auto; columns:3 200px; gap:14px; }
        .gallery-item { break-inside:avoid; margin-bottom:14px; border-radius:4px; overflow:hidden; background:rgba(196,98,45,.15); }
        .gallery-item img { width:100%; display:block; transition:transform .3s; }
        .gallery-item:hover img { transform:scale(1.05); }

        /* ─── WISHES (STICKY NOTES) ─── */
        .wishes-section { padding:80px 20px; background:#fef9f3; }
        .sticky-grid { max-width:900px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; }
        .sticky {
            padding:20px; border-radius:2px;
            box-shadow:2px 4px 12px rgba(0,0,0,.12),0 1px 0 rgba(255,255,255,.8) inset;
            transform:rotate(var(--r,-2deg));
            transition:transform .2s,box-shadow .2s; cursor:default;
            position:relative;
        }
        .sticky:hover { transform:rotate(0deg) scale(1.04); box-shadow:4px 8px 24px rgba(0,0,0,.18); }
        .sticky::before { content:''; position:absolute; top:0; left:50%; transform:translateX(-50%); width:40px; height:6px; background:rgba(0,0,0,.1); border-radius:0 0 4px 4px; }
        .sticky:nth-child(1) { background:#ffd93d; --r:1.5deg; }
        .sticky:nth-child(2) { background:#ffc0cb; --r:-2deg; }
        .sticky:nth-child(3) { background:#b5ead7; --r:2.5deg; }
        .sticky:nth-child(4) { background:#c7ceea; --r:-1deg; }
        .sticky:nth-child(5) { background:#ffdab9; --r:1deg; }
        .sticky:nth-child(6) { background:#ffe4e1; --r:-2.5deg; }
        .sticky-text { font-size:14px; color:#333; line-height:1.7; font-family:'Tajawal',sans-serif; }
        .sticky-author { font-size:12px; color:#666; margin-top:10px; font-style:italic; }
        .sticky-form-wrap { max-width:500px; margin:40px auto 0; background:#fff; border:1px solid rgba(196,98,45,.15); border-radius:4px; padding:28px; }
        .sf-input { width:100%; padding:11px 14px; margin-bottom:12px; border:1px solid rgba(196,98,45,.2); border-radius:4px; font-family:'Tajawal',sans-serif; font-size:14px; outline:none; resize:none; transition:border-color .2s; background:#fdf9f4; color:var(--dark); }
        .sf-input:focus { border-color:var(--terra); }
        .sf-input::placeholder { color:var(--muted); }
        .sf-btn { width:100%; padding:13px; background:var(--terra); color:#fff; border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:15px; font-weight:700; cursor:pointer; transition:all .2s; }
        .sf-btn:hover { background:var(--terra-l); }

        /* ─── RSVP ─── */
        .rsvp-section { padding:80px 20px; background:var(--cream); }
        .rsvp-invite {
            max-width:580px; margin:0 auto;
            background:#fff; border:1.5px solid rgba(196,98,45,.25);
            border-radius:4px; overflow:hidden;
            box-shadow:0 12px 40px rgba(42,21,6,.1);
        }
        .rsvp-header {
            background:linear-gradient(135deg,var(--rust),var(--terra));
            padding:30px 32px; text-align:center; color:#fff;
        }
        .rsvp-header-title { font-family:'Playfair Display',serif; font-size:24px; }
        .rsvp-header-sub { font-size:13px; opacity:.75; margin-top:6px; }
        .rsvp-body { padding:32px; }
        .rsvp-label { display:block; font-size:12px; letter-spacing:2px; color:var(--terra); margin-bottom:8px; text-transform:uppercase; }
        .rsvp-input { width:100%; padding:12px 14px; margin-bottom:20px; border:1px solid rgba(196,98,45,.2); border-radius:4px; font-family:'Tajawal',sans-serif; font-size:14px; outline:none; background:#fdf9f4; color:var(--dark); transition:border-color .2s; }
        .rsvp-input:focus { border-color:var(--terra); }
        .rsvp-input::placeholder { color:var(--muted); }
        .attend-btns { display:flex; gap:12px; margin-bottom:20px; }
        .attend-btn { flex:1; padding:12px; border:1.5px solid rgba(196,98,45,.25); border-radius:4px; background:transparent; color:var(--muted); font-family:'Tajawal',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all .2s; }
        .attend-btn.active,.attend-btn:hover { border-color:var(--terra); color:var(--terra); background:rgba(196,98,45,.05); }
        .rsvp-submit { width:100%; padding:15px; background:linear-gradient(135deg,var(--rust),var(--terra)); color:#fff; border:none; border-radius:4px; font-family:'Tajawal',sans-serif; font-size:16px; font-weight:700; cursor:pointer; letter-spacing:.5px; transition:all .2s; box-shadow:0 6px 20px rgba(196,98,45,.3); }
        .rsvp-submit:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(196,98,45,.45); }

        /* ─── FOOTER ─── */
        .footer-section { padding:40px 20px; background:var(--dark); text-align:center; color:var(--muted); font-size:13px; }
        .footer-brand { font-family:'Playfair Display',serif; font-size:22px; color:var(--sand); margin-bottom:10px; display:block; }

        @media(max-width:600px){
            .boho-frame { padding:28px 20px; }
            .gallery-masonry { columns:2 160px; }
        }
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
    <div class="sky-bg"></div>
    <div class="sun"></div>

    {{-- Dunes SVG --}}
    <div class="dunes">
        <svg viewBox="0 0 1440 200" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,80 C200,20 400,140 600,80 C800,20 1000,100 1200,60 C1300,40 1380,80 1440,60 L1440,200 L0,200 Z" fill="#e8c99a" opacity="0.7"/>
            <path d="M0,120 C180,60 360,150 560,100 C720,60 900,140 1100,90 C1260,55 1380,110 1440,90 L1440,200 L0,200 Z" fill="#c4622d" opacity="0.5"/>
            <path d="M0,150 C200,110 400,160 650,130 C850,105 1050,155 1250,125 C1350,110 1420,140 1440,130 L1440,200 L0,200 Z" fill="#7a4020"/>
        </svg>
    </div>

    @php $dusts = [[5,10,'6px','6s','0s','20px','-50px'],[15,25,'4px','7s','1s','30px','-60px'],[30,15,'5px','8s','2s','-20px','-70px'],[70,20,'3px','6.5s','0.5s','25px','-55px'],[80,12,'5px','7.5s','1.5s','-30px','-65px'],[55,30,'4px','9s','3s','15px','-45px']]; @endphp
    @foreach($dusts as $d)
    <div class="dust-particle" style="--s:{{$d[2]}};--dur:{{$d[3]}};--del:{{$d[4]}};--dx:{{$d[5]}};--dy:{{$d[6]}};--lx:{{$d[0]}}%;--ly:{{$d[1]}}%"></div>
    @endforeach

    <div class="hero-content">
        <div class="boho-frame">
            <div class="hero-eyebrow">
                <span class="feather left">🪶</span>
                دعوة زفاف
                <span class="feather right">🪶</span>
            </div>

            <div class="hero-names">
                {{ $event->groom_name }}
                @if($event->bride_name)
                <span class="hero-amp"> & </span>
                {{ $event->bride_name }}
                @endif
            </div>

            <div class="hero-divider">
                <span>🌅</span>
            </div>

            <div class="hero-date">
                <strong>{{ $event->event_date->translatedFormat('l، d F Y') }}</strong><br>
                {{ $event->venue_name }}
                @if($event->event_time) · {{ $event->event_time }}@endif
            </div>
        </div>
    </div>
</section>

{{-- ── COUNTDOWN ── --}}
<section class="countdown-section">
    <div class="sec-hdr">
        <span class="sec-tag" style="color:var(--sand)">⏳ العد التنازلي</span>
        <div class="sec-title" style="color:var(--sand-l)">حتى نلتقي</div>
        <div class="sec-ornament" style="margin-top:14px">
            <div style="flex:1;max-width:60px;height:1px;background:linear-gradient(90deg,transparent,rgba(232,201,154,.3));transform:scaleX(-1)"></div>
            <span>🌅</span>
            <div style="flex:1;max-width:60px;height:1px;background:linear-gradient(90deg,transparent,rgba(232,201,154,.3))"></div>
        </div>
    </div>
    <div class="cd-wrap">
        <div class="cd-box"><div class="cd-num" x-text="String(days).padStart(2,'0')">00</div><div class="cd-lbl">يوم</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(hours).padStart(2,'0')">00</div><div class="cd-lbl">ساعة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(mins).padStart(2,'0')">00</div><div class="cd-lbl">دقيقة</div></div>
        <div class="cd-box"><div class="cd-num" x-text="String(secs).padStart(2,'0')">00</div><div class="cd-lbl">ثانية</div></div>
    </div>
</section>

{{-- ── DETAILS ── --}}
<section class="details-section">
    <div class="sec-hdr">
        <span class="sec-tag">تفاصيل الحفل</span>
        <div class="sec-title">كل ما تحتاج معرفته</div>
        <div class="sec-ornament"><span>🪶</span></div>
    </div>
    <div class="details-card">
        <div class="details-banner"></div>
        <div class="details-body">
            <div class="details-row">
                <div class="details-icon">📅</div>
                <dl class="details-info">
                    <dt>التاريخ</dt>
                    <dd>{{ $event->event_date->translatedFormat('l، d F Y') }}
                    @if($event->event_time) · {{ $event->event_time }} @endif</dd>
                </dl>
            </div>
            <div class="details-row">
                <div class="details-icon">📍</div>
                <dl class="details-info">
                    <dt>المكان</dt>
                    <dd>{{ $event->venue_name }}
                    @if($event->venue_address)<br><small style="font-weight:400;font-size:14px;color:var(--muted)">{{ $event->venue_address }}</small>@endif</dd>
                </dl>
            </div>
            @if($event->dress_code)
            <div class="details-row">
                <div class="details-icon">👗</div>
                <dl class="details-info">
                    <dt>كود اللباس</dt>
                    <dd>{{ $event->dress_code }}</dd>
                </dl>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ── GALLERY ── --}}
@if($event->galleryImages && count($event->galleryImages) > 0)
<section class="gallery-section">
    <div class="sec-hdr">
        <span class="sec-tag" style="color:var(--sand)">الذكريات</span>
        <div class="sec-title" style="color:var(--sand-l)">لحظات لا تُنسى</div>
        <div class="sec-ornament"><span>🌅</span></div>
    </div>
    <div class="gallery-masonry">
        @foreach($event->galleryImages as $img)
        <div class="gallery-item">
            <img src="{{ asset('storage/'.$img) }}" alt="صورة">
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── WISHES (sticky notes) ── --}}
@if($event->plan?->feature('guest_book'))
<section class="wishes-section">
    <div class="sec-hdr">
        <span class="sec-tag">رسائل المحبة</span>
        <div class="sec-title">اكتب كلمة تبقى</div>
        <div class="sec-ornament"><span>🪶</span></div>
    </div>
    <div class="sticky-grid">
        @php $wishes = $event->guestbookEntries ?? []; @endphp
        @forelse($wishes as $w)
        <div class="sticky"><div class="sticky-text">{{ $w->message ?? $w }}</div><div class="sticky-author">— {{ $w->name ?? 'ضيف' }}</div></div>
        @empty
        <div class="sticky"><div class="sticky-text">كل السعادة والبركة ليكم في هذا اليوم الجميل 🧡</div><div class="sticky-author">— صديق</div></div>
        <div class="sticky"><div class="sticky-text">ألف مبروك، ربنا يكمل عليكم بالخير دائمًا 🌸</div><div class="sticky-author">— أحد المدعوين</div></div>
        <div class="sticky"><div class="sticky-text">يا رب تبقى حياتكم زي غروب الشمس — دافية ومليانة ألوان 🌅</div><div class="sticky-author">— قريب</div></div>
        @endforelse
    </div>
    <div class="sticky-form-wrap" x-data="{sent:false}">
        <template x-if="!sent">
            <div>
                <textarea class="sf-input" rows="3" placeholder="اكتب رسالتك هنا..."></textarea>
                <input type="text" class="sf-input" placeholder="اسمك">
                <button class="sf-btn" @click="sent=true">🪶 اترك رسالة</button>
            </div>
        </template>
        <template x-if="sent">
            <div style="text-align:center;padding:24px;color:var(--terra);font-size:18px">تم إرسال رسالتك ✓ 🌅</div>
        </template>
    </div>
</section>
@endif

{{-- ── RSVP ── --}}
@if($event->plan?->feature('rsvp'))
<section class="rsvp-section">
    <div class="sec-hdr">
        <span class="sec-tag">تأكيد الحضور</span>
        <div class="sec-title">سنكون سعداء برؤيتك</div>
        <div class="sec-ornament"><span>🌅</span></div>
    </div>
    <div class="rsvp-invite">
        <div class="rsvp-header">
            <div class="rsvp-header-title">هل ستحضر؟</div>
            <div class="rsvp-header-sub">{{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}</div>
        </div>
        <div class="rsvp-body">
            <template x-if="!rsvpSent">
                <div>
                    <label class="rsvp-label">اسمك الكريم</label>
                    <input type="text" class="rsvp-input" placeholder="أدخل اسمك">
                    <label class="rsvp-label">هل ستحضر الحفل؟</label>
                    <div class="attend-btns">
                        <button type="button" class="attend-btn" :class="{active:attendance==='yes'}" @click="attendance='yes'">✓ نعم، سأحضر</button>
                        <button type="button" class="attend-btn" :class="{active:attendance==='no'}"  @click="attendance='no'">آسف، لن أستطيع</button>
                    </div>
                    <label class="rsvp-label">عدد الأشخاص</label>
                    <input type="number" min="1" max="10" class="rsvp-input" value="1">
                    <button class="rsvp-submit" @click="rsvpSent=true">🌅 تأكيد الحضور</button>
                </div>
            </template>
            <template x-if="rsvpSent">
                <div style="text-align:center;padding:50px 20px">
                    <div style="font-size:48px;margin-bottom:16px">🌅</div>
                    <div style="font-family:'Playfair Display',serif;font-size:22px;color:var(--terra)">شكراً لتأكيد حضوركم</div>
                    <div style="color:var(--muted);margin-top:10px;font-size:14px">نتطلع لمشاركتكم هذا اليوم المميز</div>
                </div>
            </template>
        </div>
    </div>
</section>
@endif

<footer class="footer-section">
    <span class="footer-brand">فرحنا 🌅</span>
    {{ $event->displayTitle() }} · {{ $event->event_date->translatedFormat('d F Y') }}<br><br>
    صُنع بحب · فرحنا للمناسبات
</footer>

</body>
</html>
