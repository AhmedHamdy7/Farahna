<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'فرحنا – دعوات إلكترونية لكل مناسبة' : 'Farahna – Digital Invitations for Every Occasion' }}</title>
    <meta name="description" content="{{ app()->isLocale('ar') ? 'أنشئ دعوتك الرقمية في دقائق — زفاف، عيد ميلاد، خطوبة، تخرج. قوالب احترافية مع RSVP وعد تنازلي.' : 'Create your digital invitation in minutes — weddings, birthdays, engagements, graduations. Professional templates with RSVP and countdown.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Tajawal:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --rose:       #be123c;
            --rose-l:     #e11d48;
            --rose-xl:    #fecdd3;
            --rose-bg:    #fff1f2;
            --gold:       #92400e;
            --gold-l:     #b45309;
            --champagne:  #f5e6d3;
            --champ-d:    #d4b896;
            --cream:      #fdf9f6;
            --white:      #ffffff;
            --dark:       #1c1917;
            --dark2:      #292524;
            --muted:      #78716c;
            --border:     #e7e5e4;
            --border2:    rgba(190,18,60,.12);
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Tajawal', sans-serif; background: var(--cream); color: var(--dark); overflow-x: hidden; }

        /* ── AURORA KEYFRAMES ── */
        @keyframes aurora {
            0%,100% { transform: translate(0,0) scale(1); }
            33%     { transform: translate(30px,-20px) scale(1.05); }
            66%     { transform: translate(-20px,15px) scale(.97); }
        }
        @keyframes float-y {
            0%,100% { transform: translateY(0); }
            50%     { transform: translateY(-14px); }
        }
        @keyframes shimmer-x {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes count-up { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        @keyframes slide-in-r { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
        @keyframes slide-in-l { from { opacity:0; transform:translateX(-40px); } to { opacity:1; transform:translateX(0); } }
        @keyframes fade-up    { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse-ring { 0%{box-shadow:0 0 0 0 rgba(190,18,60,.4)} 70%{box-shadow:0 0 0 14px rgba(190,18,60,0)} 100%{box-shadow:0 0 0 0 rgba(190,18,60,0)} }

        /* ── NAVBAR ── */
        .nav {
            position: fixed; top: 0; width: 100%; z-index: 200;
            background: rgba(253,249,246,.92); backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212,184,150,.2);
            padding: 0 2rem; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            transition: box-shadow .3s;
        }
        .nav.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,.06); }
        .nav-brand {
            font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-style: italic;
            color: var(--rose); text-decoration: none; font-weight: 600; letter-spacing: .5px;
        }
        .nav-links { display: flex; align-items: center; gap: 1.5rem; }
        .nav-link { color: var(--muted); text-decoration: none; font-size: .875rem; font-weight: 500; transition: color .2s; }
        .nav-link:hover { color: var(--rose); }

        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1.25rem; border-radius: 8px; font-size: .875rem; font-family: inherit; cursor: pointer; text-decoration: none; transition: all .2s; border: none; font-weight: 600; }
        .btn-primary  { background: var(--rose); color: #fff; box-shadow: 0 4px 14px rgba(190,18,60,.3); }
        .btn-primary:hover { background: var(--rose-l); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(190,18,60,.4); }
        .btn-outline  { background: transparent; border: 1.5px solid var(--border); color: var(--dark); }
        .btn-outline:hover { border-color: var(--rose); color: var(--rose); background: var(--rose-bg); }
        .btn-glass    { background: rgba(255,255,255,.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.3); color: #fff; }
        .btn-glass:hover { background: rgba(255,255,255,.25); }
        .btn-lg { padding: .8rem 2rem; font-size: 1rem; border-radius: 10px; }
        .btn-xl { padding: 1rem 2.5rem; font-size: 1.05rem; border-radius: 12px; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh; padding-top: 64px;
            position: relative; overflow: hidden;
            display: flex; align-items: center;
            background: #fdf7f4;
        }

        /* Aurora blobs */
        .aurora { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }
        .aurora-1 { width: 600px; height: 600px; background: radial-gradient(circle, rgba(190,18,60,.18) 0%, transparent 70%); top: -100px; right: -100px; animation: aurora 12s ease-in-out infinite; }
        .aurora-2 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(212,184,150,.25) 0%, transparent 70%); bottom: -50px; left: -80px; animation: aurora 15s ease-in-out infinite reverse; }
        .aurora-3 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(252,205,211,.3) 0%, transparent 70%); top: 40%; right: 25%; animation: aurora 18s ease-in-out infinite 3s; }

        /* Dot grid */
        .hero::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(180,83,9,.08) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .hero-inner {
            position: relative; z-index: 2;
            max-width: 1200px; margin: 0 auto; padding: 3rem 2rem;
            display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;
        }

        .hero-left { animation: slide-in-l .9s ease forwards; }
        .hero-right { animation: slide-in-r .9s ease .1s both; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--rose-bg); border: 1px solid var(--rose-xl);
            color: var(--rose); border-radius: 999px;
            padding: .35rem 1rem; font-size: .78rem; font-weight: 600; letter-spacing: .5px;
            margin-bottom: 1.5rem;
        }
        .hero-badge::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--rose); animation: pulse-ring 2s infinite; flex-shrink: 0; }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem, 5.5vw, 4.2rem);
            line-height: 1.1; color: var(--dark); margin-bottom: 1.25rem; font-weight: 700;
        }
        .hero-title em { color: var(--rose); font-style: italic; }

        .hero-desc { font-size: 1.05rem; color: var(--muted); max-width: 480px; line-height: 1.85; margin-bottom: 2.5rem; }

        .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem; }

        /* Social proof inline */
        .hero-proof { display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap; }
        .proof-avatars { display: flex; }
        .proof-avatar { width: 34px; height: 34px; border-radius: 50%; border: 2px solid var(--white); margin-left: -8px; background: linear-gradient(135deg,var(--rose-xl),var(--champagne)); display:flex;align-items:center;justify-content:center;font-size:14px; }
        .proof-avatar:first-child { margin-left: 0; }
        .proof-text { font-size: .85rem; color: var(--muted); line-height: 1.4; }
        .proof-text strong { color: var(--dark); display: block; }
        .stars { color: #f59e0b; font-size: .9rem; letter-spacing: 1px; }

        /* ── PHONE MOCKUP ── */
        .phone-wrap { display: flex; justify-content: center; position: relative; }
        .phone-glow {
            position: absolute; width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle,rgba(190,18,60,.15),transparent 70%);
            top: 50%; left: 50%; transform: translate(-50%,-50%);
            filter: blur(40px); animation: aurora 8s ease-in-out infinite;
        }
        .phone {
            width: 260px; height: 520px;
            background: #1a1a1a; border-radius: 40px;
            border: 6px solid #2a2a2a; position: relative;
            box-shadow: 0 40px 80px rgba(0,0,0,.35), 0 0 0 1px rgba(255,255,255,.06), inset 0 0 0 1px rgba(255,255,255,.08);
            animation: float-y 5s ease-in-out infinite;
            overflow: hidden;
        }
        /* Notch */
        .phone::before {
            content: ''; position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
            width: 80px; height: 22px; background: #1a1a1a; border-radius: 0 0 14px 14px; z-index: 10;
        }
        /* Side button */
        .phone::after { content: ''; position: absolute; top: 90px; right: -8px; width: 4px; height: 50px; background: #2a2a2a; border-radius: 0 4px 4px 0; }

        .phone-screen {
            width: 100%; height: 100%; background: var(--cream); border-radius: 34px; overflow: hidden;
            display: flex; flex-direction: column;
        }

        /* Mini invitation inside phone */
        .phone-invite {
            flex: 1; display: flex; flex-direction: column;
            background: linear-gradient(160deg,#0d1b3e,#152247,#0a1428);
            position: relative; overflow: hidden; padding: 32px 16px 16px;
            align-items: center; text-align: center;
        }
        .phone-invite::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(circle,rgba(212,168,67,.12) 1px,transparent 1px);
            background-size: 20px 20px;
        }
        .phone-invite::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 50% 60%,rgba(212,168,67,.08),transparent 60%);
        }
        .pi-tag { font-size: 8px; letter-spacing: 3px; color: rgba(212,168,67,.7); text-transform: uppercase; margin-bottom: 8px; position: relative; z-index: 1; }
        .pi-names { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 700; color: #f0c96a; line-height: 1.2; position: relative; z-index: 1; }
        .pi-divider { width: 50px; height: 1px; background: linear-gradient(90deg,transparent,rgba(212,168,67,.6),transparent); margin: 8px auto; position: relative; z-index: 1; }
        .pi-date { font-size: 9px; color: rgba(255,255,255,.55); line-height: 1.8; position: relative; z-index: 1; }
        .pi-cd { display: flex; gap: 6px; justify-content: center; margin-top: 12px; position: relative; z-index: 1; }
        .pi-cd-box { background: rgba(212,168,67,.15); border: 1px solid rgba(212,168,67,.3); border-radius: 4px; width: 36px; height: 36px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1px; }
        .pi-cd-num { font-size: 14px; font-weight: 700; color: #f0c96a; line-height: 1; }
        .pi-cd-lbl { font-size: 6px; color: rgba(255,255,255,.4); letter-spacing: 1px; }
        .phone-bottom { height: 50px; background: var(--white); display: flex; align-items: center; justify-content: center; border-top: 1px solid var(--border); }
        .phone-bar { width: 90px; height: 4px; background: var(--dark); border-radius: 2px; opacity: .2; }

        /* Floating badges around phone */
        .float-badge {
            position: absolute; background: var(--white);
            border: 1px solid var(--border); border-radius: 12px;
            padding: .5rem .9rem; font-size: .78rem; font-weight: 600;
            display: flex; align-items: center; gap: .5rem;
            box-shadow: 0 8px 24px rgba(0,0,0,.1);
            white-space: nowrap;
        }
        .fb-1 { right: -10px; top: 18%; animation: float-y 4s ease-in-out infinite; }
        .fb-2 { left: -20px; bottom: 28%; animation: float-y 5s ease-in-out infinite 1s; }
        .fb-3 { right: -15px; bottom: 20%; animation: float-y 4.5s ease-in-out infinite .5s; }

        /* ── SOCIAL PROOF STRIP ── */
        .proof-strip {
            background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
            padding: 1.25rem 2rem;
        }
        .proof-strip-inner {
            max-width: 1100px; margin: 0 auto;
            display: flex; align-items: center; justify-content: center; gap: 3rem; flex-wrap: wrap;
        }
        .ps-item { display: flex; align-items: center; gap: .6rem; font-size: .85rem; }
        .ps-icon { font-size: 1.2rem; }
        .ps-num { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 700; color: var(--rose); line-height: 1; }
        .ps-lbl { color: var(--muted); font-size: .78rem; }
        .ps-divider { width: 1px; height: 30px; background: var(--border); }

        /* ── SECTION SYSTEM ── */
        .section { padding: 5.5rem 2rem; }
        .container { max-width: 1100px; margin: 0 auto; }
        .section-head { text-align: center; margin-bottom: 3.5rem; }
        .section-tag {
            display: inline-block; background: var(--rose-bg); color: var(--rose);
            font-size: .72rem; font-weight: 700; letter-spacing: 3px; text-transform: uppercase;
            padding: .35rem 1rem; border-radius: 999px; margin-bottom: 1rem;
        }
        .section-title { font-family: 'Cormorant Garamond', serif; font-size: clamp(1.8rem,4vw,2.6rem); color: var(--dark); margin-bottom: .75rem; font-weight: 700; }
        .section-desc  { color: var(--muted); max-width: 500px; margin: 0 auto; line-height: 1.75; }

        /* ── HOW IT WORKS ── */
        .how-bg { background: var(--white); }
        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 0; position: relative; }
        .steps-grid::before {
            content: ''; position: absolute; top: 52px; left: 15%; right: 15%; height: 1px;
            background: linear-gradient(90deg,transparent,var(--rose-xl),var(--rose-xl),transparent);
        }
        .step-card {
            text-align: center; padding: 2rem 1.5rem;
            position: relative;
        }
        .step-num-wrap { position: relative; display: inline-flex; margin-bottom: 1.25rem; }
        .step-num {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--rose), var(--rose-l));
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 700; color: #fff;
            box-shadow: 0 6px 20px rgba(190,18,60,.3);
            position: relative; z-index: 1;
        }
        .step-icon-bg {
            position: absolute; inset: -8px;
            border-radius: 50%; background: var(--rose-bg); border: 1.5px dashed var(--rose-xl);
        }
        .step-icon  { font-size: 2.2rem; margin-bottom: .75rem; }
        .step-title { font-weight: 700; font-size: 1rem; margin-bottom: .5rem; color: var(--dark); }
        .step-desc  { color: var(--muted); font-size: .875rem; line-height: 1.65; }

        /* ── FEATURE HIGHLIGHTS ── */
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap: 1.5rem; }
        .feature-card {
            background: var(--white); border: 1px solid var(--border); border-radius: 16px;
            padding: 1.75rem; transition: transform .3s, box-shadow .3s, border-color .3s;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--rose), var(--rose-l));
            transform: scaleX(0); transform-origin: left; transition: transform .3s;
        }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.08); border-color: var(--rose-xl); }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon { font-size: 2.2rem; margin-bottom: 1rem; display: block; }
        .feature-title { font-weight: 700; font-size: 1rem; margin-bottom: .5rem; color: var(--dark); }
        .feature-desc  { color: var(--muted); font-size: .875rem; line-height: 1.65; }

        /* ── TEMPLATES ── */
        .templates-bg { background: linear-gradient(160deg,#fdf7f4,var(--champagne) 60%,#fdf7f4); }
        .templates-scroll {
            display: flex; gap: 1.25rem; overflow-x: auto; padding: .5rem .5rem 1.5rem;
            scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
            scrollbar-width: thin; scrollbar-color: var(--rose-xl) transparent;
        }
        .templates-scroll::-webkit-scrollbar { height: 4px; }
        .templates-scroll::-webkit-scrollbar-track { background: transparent; }
        .templates-scroll::-webkit-scrollbar-thumb { background: var(--rose-xl); border-radius: 2px; }
        .template-card {
            flex: 0 0 280px; scroll-snap-align: start;
            border: 1.5px solid rgba(212,184,150,.3); border-radius: 18px;
            overflow: hidden; background: var(--white);
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            transition: transform .3s, box-shadow .3s;
        }
        .template-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 20px 50px rgba(0,0,0,.12); }
        .template-thumb {
            height: 200px; position: relative; overflow: hidden;
            background: linear-gradient(135deg,#fdf3d6,#e8c99a);
            display: flex; align-items: center; justify-content: center;
        }
        .template-thumb-emoji { font-size: 4rem; opacity: .6; }
        .thumb-gradient {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .thumb-wedding   { background: linear-gradient(135deg,#fdf3d6,#e8c99a,#c4a06a); }
        .thumb-birthday  { background: linear-gradient(135deg,#fce4ec,#f48fb1,#e91e63); }
        .thumb-galaxy    { background: linear-gradient(135deg,#050914,#7c3aed,#06b6d4); }
        .thumb-neon      { background: linear-gradient(135deg,#06000e,#ff0080,#00d4ff); }
        .thumb-love      { background: linear-gradient(135deg,#faf6f0,#6b1a2e,#c9943a); }
        .thumb-desert    { background: linear-gradient(135deg,#e8c99a,#c4622d,#5c3d6e); }
        .thumb-casino    { background: linear-gradient(135deg,#050505,#d4af37,#c0392b); }
        .thumb-grad      { background: linear-gradient(135deg,#0d1b3e,#d4a843,#fef9ec); }
        .thumb-petal     { background: linear-gradient(135deg,#f7e8ee,#c9748a,#8b3d5a); }
        .thumb-confetti  { background: linear-gradient(135deg,#ff6b6b,#ffd93d,#6bcb77); }
        .thumb-default   { background: linear-gradient(135deg,var(--rose-bg),var(--champagne)); }

        /* Preview overlay */
        .template-thumb .preview-overlay {
            position: absolute; inset: 0; background: rgba(0,0,0,.55);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity .25s;
        }
        .template-card:hover .preview-overlay { opacity: 1; }
        .preview-overlay-btn {
            background: rgba(255,255,255,.95); color: var(--dark);
            padding: .5rem 1.25rem; border-radius: 8px; font-size: .85rem;
            font-weight: 700; text-decoration: none; transition: transform .2s;
        }
        .preview-overlay-btn:hover { transform: scale(1.05); }

        .cat-badge {
            position: absolute; top: .75rem; right: .75rem;
            background: rgba(0,0,0,.6); color: #fff; font-size: .68rem;
            font-weight: 600; padding: .2rem .65rem; border-radius: 999px;
            backdrop-filter: blur(4px);
        }
        .plan-badge {
            position: absolute; top: .75rem; left: .75rem; font-size: .68rem; font-weight: 700;
            padding: .2rem .65rem; border-radius: 999px;
        }
        .plan-badge.free    { background: #dcfce7; color: #166534; }
        .plan-badge.premium { background: #fef9c3; color: #854d0e; }
        .plan-badge.vip     { background: #f3e8ff; color: #7e22ce; }

        .template-body { padding: 1.25rem; }
        .template-name { font-weight: 700; font-size: 1rem; margin-bottom: .25rem; color: var(--dark); }
        .template-sub  { font-size: .8rem; color: var(--muted); margin-bottom: 1rem; }
        .template-actions { display: flex; gap: .5rem; }
        .template-actions .btn { flex: 1; justify-content: center; font-size: .82rem; padding: .5rem; }

        /* ── PRICING ── */
        .pricing-bg { background: var(--white); }
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap: 1.5rem; max-width: 920px; margin: 0 auto; }
        .plan-card {
            border: 2px solid var(--border); border-radius: 20px; padding: 2rem;
            background: var(--white); transition: transform .3s, box-shadow .3s;
            position: relative;
        }
        .plan-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.08); }
        .plan-card.popular {
            border-color: var(--rose);
            box-shadow: 0 8px 30px rgba(190,18,60,.15);
            background: linear-gradient(160deg,#fff,var(--rose-bg));
        }
        .popular-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg,var(--rose),var(--rose-l)); color: #fff;
            font-size: .72rem; font-weight: 700; padding: .35rem 1.1rem;
            border-radius: 999px; white-space: nowrap; box-shadow: 0 4px 12px rgba(190,18,60,.3);
        }
        .plan-icon  { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .plan-name  { font-weight: 700; font-size: 1.1rem; margin-bottom: .5rem; }
        .plan-price {
            font-family: 'Cormorant Garamond', serif; font-size: 2.8rem;
            font-weight: 700; color: var(--rose); line-height: 1; margin-bottom: .25rem;
        }
        .plan-price span { font-size: .95rem; color: var(--muted); font-family: 'Tajawal', sans-serif; font-weight: 400; }
        .plan-features { list-style: none; margin: 1.5rem 0; }
        .plan-features li { display: flex; align-items: center; gap: .6rem; padding: .4rem 0; font-size: .875rem; border-bottom: 1px solid #f5f5f4; }
        .plan-features li:last-child { border: none; }

        /* ── TESTIMONIALS ── */
        .testi-bg { background: linear-gradient(160deg,var(--rose-bg),var(--champagne) 60%,var(--rose-bg)); }
        .testi-grid { display: grid; grid-template-columns: repeat(auto-fill,minmax(280px,1fr)); gap: 1.5rem; }
        .testi-card {
            background: rgba(255,255,255,.8); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.9); border-radius: 18px;
            padding: 1.75rem; position: relative;
            box-shadow: 0 4px 20px rgba(190,18,60,.06);
        }
        .testi-card::before { content: '❝'; position: absolute; top: 1rem; right: 1.25rem; font-size: 3rem; color: var(--rose-xl); font-family: Georgia,serif; line-height: 1; }
        .testi-stars { color: #f59e0b; font-size: .85rem; margin-bottom: .75rem; }
        .testi-text  { color: var(--dark2); line-height: 1.75; margin-bottom: 1rem; font-size: .9rem; }
        .testi-author { display: flex; align-items: center; gap: .75rem; }
        .testi-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,var(--rose-xl),var(--champagne)); display:flex;align-items:center;justify-content:center;font-size:1.1rem; }
        .testi-name  { font-weight: 700; font-size: .875rem; }
        .testi-event { font-size: .78rem; color: var(--muted); }

        /* ── FAQ ── */
        .faq-bg { background: var(--white); }
        .faq-wrap { max-width: 680px; margin: 0 auto; }
        .faq-item { border: 1.5px solid var(--border); border-radius: 12px; margin-bottom: .75rem; overflow: hidden; transition: border-color .2s; }
        .faq-item.open { border-color: var(--rose-xl); }
        .faq-q {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 1.25rem; background: none; border: none; cursor: pointer;
            font-family: 'Tajawal', sans-serif; font-size: .95rem; font-weight: 600;
            color: var(--dark); text-align: right; gap: 1rem;
            transition: background .2s;
        }
        .faq-item.open .faq-q { background: var(--rose-bg); color: var(--rose); }
        .faq-arrow { flex-shrink: 0; width: 22px; height: 22px; border-radius: 50%; background: var(--border); display: flex; align-items: center; justify-content: center; font-size: 11px; transition: transform .3s, background .2s; }
        .faq-item.open .faq-arrow { transform: rotate(180deg); background: var(--rose-xl); color: var(--rose); }
        .faq-a { display: none; padding: 0 1.25rem 1.1rem; color: var(--muted); font-size: .9rem; line-height: 1.75; }
        .faq-item.open .faq-a { display: block; }

        /* ── CTA ── */
        .cta-section {
            position: relative; overflow: hidden; text-align: center; padding: 5rem 2rem;
            background: linear-gradient(135deg, #7f1d1d 0%, var(--rose) 40%, var(--rose-l) 100%);
            color: #fff;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px);
            background-size: 28px 28px;
        }
        .cta-inner { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
        .cta-title { font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem,5vw,3.2rem); margin-bottom: 1rem; font-weight: 700; }
        .cta-desc  { opacity: .85; font-size: 1.05rem; margin-bottom: 2.5rem; line-height: 1.7; }
        .cta-btns  { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .cta-btn-main { background: #fff; color: var(--rose); padding: .9rem 2.5rem; border-radius: 12px; font-size: 1.05rem; font-weight: 700; text-decoration: none; display: inline-block; transition: transform .2s, box-shadow .2s; box-shadow: 0 4px 20px rgba(0,0,0,.2); }
        .cta-btn-main:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.25); }

        /* ── FOOTER ── */
        .footer { background: var(--dark); color: rgba(168,162,158,.8); padding: 3rem 2rem; }
        .footer-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 3rem; }
        .footer-brand { font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: #fff; font-style: italic; margin-bottom: .5rem; display: block; }
        .footer-tagline { font-size: .85rem; line-height: 1.6; max-width: 240px; }
        .footer-col h4 { color: #fff; font-size: .875rem; font-weight: 700; margin-bottom: 1rem; letter-spacing: .5px; }
        .footer-col a { display: block; color: rgba(168,162,158,.7); text-decoration: none; font-size: .85rem; margin-bottom: .5rem; transition: color .2s; }
        .footer-col a:hover { color: var(--rose-xl); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.08); margin-top: 2rem; padding-top: 1.5rem; text-align: center; font-size: .78rem; opacity: .5; max-width: 1100px; margin-left: auto; margin-right: auto; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .hero-inner { grid-template-columns: 1fr; gap: 2rem; text-align: center; }
            .hero-left  { order: 1; }
            .hero-right { order: 0; }
            .hero-btns, .hero-proof { justify-content: center; }
            .hero-desc { margin-left: auto; margin-right: auto; }
            .phone-wrap .fb-1, .phone-wrap .fb-2, .phone-wrap .fb-3 { display: none; }
            .steps-grid::before { display: none; }
            .footer-inner { grid-template-columns: 1fr; gap: 1.5rem; }
        }
        @media (max-width: 600px) {
            .nav-links .nav-link { display: none; }
            .ps-divider { display: none; }
        }
    </style>
</head>
<body x-data="{
    faqOpen: null,
    toggleFaq(i){ this.faqOpen = this.faqOpen===i ? null : i; }
}">

{{-- ─── NAVBAR ─── --}}
<nav class="nav" x-data x-init="window.addEventListener('scroll',()=>$el.classList.toggle('scrolled',window.scrollY>40))">
    <a href="{{ route('home') }}" class="nav-brand">
        {{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }}
    </a>
    <div class="nav-links">
        <a href="#how"       class="nav-link">{{ app()->isLocale('ar') ? 'كيف يعمل' : 'How it Works' }}</a>
        <a href="#templates" class="nav-link">{{ app()->isLocale('ar') ? 'القوالب'  : 'Templates' }}</a>
        <a href="#pricing"   class="nav-link">{{ app()->isLocale('ar') ? 'الأسعار'  : 'Pricing' }}</a>
        <a href="#faq"       class="nav-link">{{ app()->isLocale('ar') ? 'الأسئلة'  : 'FAQ' }}</a>
        @if(app()->isLocale('ar'))
            <a href="{{ request()->fullUrlWithQuery(['lang'=>'en']) }}" class="btn btn-outline" style="padding:.38rem .85rem;font-size:.78rem;">🌐 EN</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['lang'=>'ar']) }}" class="btn btn-outline" style="padding:.38rem .85rem;font-size:.78rem;">🌐 AR</a>
        @endif
        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">{{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">{{ app()->isLocale('ar') ? 'دخول' : 'Login' }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary">{{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started Free' }}</a>
        @endauth
    </div>
</nav>

{{-- ─── HERO ─── --}}
<section class="hero">
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>
    <div class="aurora aurora-3"></div>

    <div class="hero-inner">
        {{-- LEFT: Copy --}}
        <div class="hero-left">
            <div class="hero-badge">
                {{ app()->isLocale('ar') ? '✨ دعوات رقمية لكل مناسبة' : '✨ Digital Invitations for Every Occasion' }}
            </div>

            @if(app()->isLocale('ar'))
            <h1 class="hero-title">اصنع دعوتك<br>بـ<em>لمسة فرح</em></h1>
            <p class="hero-desc">من دعوة زفاف أنيقة لموقع عيد ميلاد تفاعلي — قوالب احترافية بـ RSVP وعد تنازلي وسجل تهاني، في دقائق.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-xl">استعرض القوالب 💌</a>
                <a href="#how"       class="btn btn-outline btn-xl">كيف يعمل؟</a>
            </div>
            @else
            <h1 class="hero-title">Create Your<br><em>Perfect Invitation</em></h1>
            <p class="hero-desc">From elegant wedding cards to interactive birthday websites — professional templates with RSVP, countdown & guest book, ready in minutes.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-xl">Browse Templates 💌</a>
                <a href="#how"       class="btn btn-outline btn-xl">How It Works</a>
            </div>
            @endif

            <div class="hero-proof">
                <div class="proof-avatars">
                    @foreach(['💍','🎂','🎓','💐','🎉'] as $e)
                    <div class="proof-avatar">{{$e}}</div>
                    @endforeach
                </div>
                <div>
                    <div class="stars">★★★★★</div>
                    <div class="proof-text">
                        <strong>{{ app()->isLocale('ar') ? '+٥٠٠ مناسبة' : '500+ Events' }}</strong>
                        {{ app()->isLocale('ar') ? '٤.٩/٥ تقييم العملاء' : '4.9/5 customer rating' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Phone Mockup --}}
        <div class="hero-right">
            <div class="phone-wrap">
                <div class="phone-glow"></div>

                <div class="phone">
                    <div class="phone-screen">
                        <div class="phone-invite">
                            <div class="pi-tag">دعوة زفاف</div>
                            <div class="pi-names">محمد<br>&amp; سارة</div>
                            <div class="pi-divider"></div>
                            <div class="pi-date">
                                الجمعة، ١٩ يونيو ٢٠٢٦<br>
                                فندق شيراتون · ٨ مساءً
                            </div>
                            <div class="pi-cd">
                                <div class="pi-cd-box"><div class="pi-cd-num">47</div><div class="pi-cd-lbl">يوم</div></div>
                                <div class="pi-cd-box"><div class="pi-cd-num">12</div><div class="pi-cd-lbl">ساعة</div></div>
                                <div class="pi-cd-box"><div class="pi-cd-num">30</div><div class="pi-cd-lbl">دقيقة</div></div>
                            </div>
                        </div>
                        <div class="phone-bottom"><div class="phone-bar"></div></div>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="float-badge fb-1">✅ {{ app()->isLocale('ar') ? '١٢ ضيف أكد' : '12 confirmed' }}</div>
                <div class="float-badge fb-2">💌 {{ app()->isLocale('ar') ? 'تم الإرسال' : 'Invitation sent' }}</div>
                <div class="float-badge fb-3">⏱️ {{ app()->isLocale('ar') ? 'دقيقتان فقط' : '2 min setup' }}</div>
            </div>
        </div>
    </div>
</section>

{{-- ─── SOCIAL PROOF STRIP ─── --}}
<div class="proof-strip">
    <div class="proof-strip-inner">
        <div class="ps-item">
            <span class="ps-icon">🎉</span>
            <div>
                <div class="ps-num">+500</div>
                <div class="ps-lbl">{{ app()->isLocale('ar') ? 'مناسبة نُظِّمت' : 'Events Created' }}</div>
            </div>
        </div>
        <div class="ps-divider"></div>
        <div class="ps-item">
            <span class="ps-icon">⭐</span>
            <div>
                <div class="ps-num">4.9</div>
                <div class="ps-lbl">{{ app()->isLocale('ar') ? 'تقييم العملاء' : 'Customer Rating' }}</div>
            </div>
        </div>
        <div class="ps-divider"></div>
        <div class="ps-item">
            <span class="ps-icon">🎨</span>
            <div>
                <div class="ps-num">{{ $templates->count() }}</div>
                <div class="ps-lbl">{{ app()->isLocale('ar') ? 'قالب احترافي' : 'Templates' }}</div>
            </div>
        </div>
        <div class="ps-divider"></div>
        <div class="ps-item">
            <span class="ps-icon">⚡</span>
            <div>
                <div class="ps-num">2{{ app()->isLocale('ar') ? 'د' : 'm' }}</div>
                <div class="ps-lbl">{{ app()->isLocale('ar') ? 'وقت الإعداد' : 'Setup Time' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ─── HOW IT WORKS ─── --}}
<section class="section how-bg" id="how">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'كيف يعمل؟' : 'How It Works' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'ثلاث خطوات وجاهز' : 'Three Steps to Go Live' }}</h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'أسرع طريقة لإنشاء دعوة تليق بمناسبتك الخاصة' : 'The fastest way to create an invitation worthy of your special occasion' }}</p>
        </div>
        <div class="steps-grid">
            @php
            $steps = app()->isLocale('ar') ? [
                ['1','🎨','اختر قالبك','تصفّح أكثر من '.$templates->count().' قالب وشاهد preview حي قبل الاختيار'],
                ['2','✏️','أضف تفاصيلك','الأسم، التاريخ، المكان، الصور، وكل تفاصيل مناسبتك'],
                ['3','💌','شارك على الفور','رابط خاص جاهز للمشاركة على واتساب وانستجرام فوراً'],
            ] : [
                ['1','🎨','Pick a Template','Browse '.$templates->count().'+ templates with live preview before choosing'],
                ['2','✏️','Add Your Details','Names, date, venue, photos, and all event details'],
                ['3','💌','Share Instantly','A private link ready to share on WhatsApp & Instagram'],
            ];
            @endphp
            @foreach($steps as $s)
            <div class="step-card">
                <div class="step-num-wrap">
                    <div class="step-icon-bg"></div>
                    <div class="step-num">{{ $s[0] }}</div>
                </div>
                <div class="step-icon">{{ $s[1] }}</div>
                <h3 class="step-title">{{ $s[2] }}</h3>
                <p class="step-desc">{{ $s[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── FEATURES ─── --}}
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'المميزات' : 'Features' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'كل ما تحتاجه في مكان واحد' : 'Everything You Need' }}</h2>
        </div>
        <div class="features-grid">
            @php
            $features = app()->isLocale('ar') ? [
                ['⏳','عد تنازلي حي','يعرض الأيام والساعات والدقائق المتبقية للحفل بشكل أنيق ومتحرك'],
                ['💬','سجل التهاني','يسمح للمدعوين بترك كلمات تهنئة تظهر مباشرة في الدعوة'],
                ['✅','RSVP ذكي','تلقَّ تأكيدات الحضور وتتبع قائمة ضيوفك بلوحة تحكم مخصصة'],
                ['🖼️','معرض الصور','أضف صورك الخاصة وتظهر في تصميم أنيق جوا الدعوة'],
                ['📤','مشاركة بنقرة','رابط خاص للمشاركة على واتساب وانستجرام وجميع المنصات'],
                ['🎨',app()->isLocale('ar') ? '+١٢ قالب' : '12+ Templates','قوالب مصممة باحتراف لكل مناسبة: زفاف، عيد ميلاد، تخرج، خطوبة'],
            ] : [
                ['⏳','Live Countdown','Elegant animated countdown showing days, hours, and minutes to the event'],
                ['💬','Guest Book','Let guests leave heartfelt messages that appear directly on the invitation'],
                ['✅','Smart RSVP','Collect RSVPs and track your guest list with a dedicated dashboard'],
                ['🖼️','Photo Gallery','Add your own photos displayed beautifully inside the invitation'],
                ['📤','One-Click Share','Private link ready to share on WhatsApp, Instagram, and all platforms'],
                ['🎨','12+ Templates','Professionally designed for every occasion: wedding, birthday, graduation, engagement'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="feature-card">
                <span class="feature-icon">{{ $f[0] }}</span>
                <h3 class="feature-title">{{ $f[1] }}</h3>
                <p class="feature-desc">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── TEMPLATES ─── --}}
<section class="section templates-bg" id="templates">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'القوالب' : 'Templates' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'اختر أسلوبك' : 'Choose Your Style' }}</h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'قوالب مصممة باحتراف لكل مناسبة ومزاج' : 'Professionally designed templates for every occasion and vibe' }}</p>
        </div>

        @if($templates->isEmpty())
            <p style="text-align:center;color:var(--muted)">{{ app()->isLocale('ar') ? 'قوالب جديدة قادمة ✨' : 'New templates coming soon ✨' }}</p>
        @else
            @php
            $thumbMap = [
                'elegant-gold'   => 'thumb-wedding',
                'romantic-scroll'=> 'thumb-wedding',
                'wedding-modern' => 'thumb-wedding',
                'love-letter'    => 'thumb-love',
                'galaxy-night'   => 'thumb-galaxy',
                'neon-night'     => 'thumb-neon',
                'desert-sunset'  => 'thumb-desert',
                'casino-night'   => 'thumb-casino',
                'golden-cap'     => 'thumb-grad',
                'birthday-luxury'=> 'thumb-birthday',
                'confetti-pop'   => 'thumb-confetti',
                'petal-blush'    => 'thumb-petal',
            ];
            $emojiMap = [
                'elegant-gold'=>'📜','romantic-scroll'=>'🌹','wedding-modern'=>'💍',
                'love-letter'=>'💌','galaxy-night'=>'🌌','neon-night'=>'⚡',
                'desert-sunset'=>'🌅','casino-night'=>'🃏','golden-cap'=>'🎓',
                'birthday-luxury'=>'🎂','confetti-pop'=>'🎉','petal-blush'=>'🌸',
            ];
            @endphp
            <div class="templates-scroll">
                @foreach($templates as $tpl)
                @php
                    $thumbCls = $thumbMap[$tpl->slug] ?? 'thumb-default';
                    $emoji    = $emojiMap[$tpl->slug] ?? '💌';
                    $planCls  = strtolower($tpl->plan->name);
                @endphp
                <div class="template-card">
                    <div class="template-thumb">
                        <div class="thumb-gradient {{ $thumbCls }}" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:3.5rem;opacity:.35">{{ $emoji }}</span>
                        </div>
                        <span class="cat-badge">{{ $tpl->category?->label() ?? '' }}</span>
                        <span class="plan-badge {{ $planCls }}">{{ $tpl->plan->name }}</span>
                        @if($tpl->isWebsite())
                        <div class="preview-overlay">
                            <a href="{{ route('templates.preview', $tpl) }}" class="preview-overlay-btn">
                                👁 {{ app()->isLocale('ar') ? 'معاينة حية' : 'Live Preview' }}
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="template-body">
                        <p class="template-name">{{ $tpl->name }}</p>
                        <p class="template-sub">{{ $tpl->isWebsite() ? (app()->isLocale('ar') ? '🌐 موقع تفاعلي' : '🌐 Interactive Website') : (app()->isLocale('ar') ? '🖼️ دعوة ثابتة' : '🖼️ Static Card') }}</p>
                        <div class="template-actions">
                            @if($tpl->isWebsite())
                                <a href="{{ route('templates.preview', $tpl) }}" class="btn btn-outline">{{ app()->isLocale('ar') ? 'معاينة' : 'Preview' }}</a>
                            @endif
                            @auth
                                <a href="{{ route('customer.events.create') }}?template={{ $tpl->id }}" class="btn btn-primary">{{ app()->isLocale('ar') ? 'استخدم' : 'Use' }}</a>
                            @else
                                <a href="{{ route('login') }}?template={{ $tpl->id }}" class="btn btn-primary">{{ app()->isLocale('ar') ? 'استخدم' : 'Use' }}</a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="text-align:center;margin-top:2rem">
                <a href="{{ route('templates.index') }}" class="btn btn-outline btn-lg">
                    {{ app()->isLocale('ar') ? 'استعرض كل القوالب ←' : 'Browse All Templates →' }}
                </a>
            </div>
        @endif
    </div>
</section>

{{-- ─── PRICING ─── --}}
<section class="section pricing-bg" id="pricing">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'الأسعار' : 'Pricing' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'باقة تناسب كل مناسبة' : 'A Plan for Every Occasion' }}</h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'ابدأ مجاناً وترقَّ متى أردت بدون قيود' : 'Start free and upgrade anytime — no restrictions' }}</p>
        </div>
        <div class="pricing-grid">
            @foreach($plans as $plan)
            <div class="plan-card {{ $plan->name==='Premium' ? 'popular' : '' }}">
                @if($plan->name==='Premium')
                <div class="popular-badge">{{ app()->isLocale('ar') ? '⭐ الأكثر طلباً' : '⭐ Most Popular' }}</div>
                @endif
                <span class="plan-icon">{{ $plan->isFree() ? '🆓' : ($plan->price<=200 ? '⭐' : '👑') }}</span>
                <p class="plan-name">{{ $plan->name }}</p>
                <div class="plan-price">
                    {{ $plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : number_format($plan->price) }}
                    @if(!$plan->isFree()) <span>{{ app()->isLocale('ar') ? 'ج.م' : 'EGP' }}</span> @endif
                </div>
                @if($plan->features)
                <ul class="plan-features">
                    @foreach($plan->features as $key => $val)
                    <li>
                        <span>{{ $val==='true' ? '✅' : '❌' }}</span>
                        {{ app()->isLocale('ar') ? match($key){
                            'static_invitation'=>'دعوة ثابتة','watermark'=>'علامة مائية',
                            'subdomain'=>'رابط خاص','guest_book'=>'سجل تهاني',
                            'rsvp'=>'تأكيد حضور','gallery'=>'معرض صور',
                            'custom_domain'=>'دومين مخصص','no_watermark'=>'بدون علامة مائية',
                            'priority_support'=>'دعم أولوية',
                            'everything_in_premium'=>'كل مميزات Premium',
                            'templates_count'=>'عدد القوالب: '.$val,
                            default=>str_replace('_',' ',$key)
                        } : match($key){
                            'static_invitation'=>'Static Invitation','watermark'=>'Watermark',
                            'subdomain'=>'Custom Link','guest_book'=>'Guest Book',
                            'rsvp'=>'RSVP Form','gallery'=>'Photo Gallery',
                            'custom_domain'=>'Custom Domain','no_watermark'=>'No Watermark',
                            'priority_support'=>'Priority Support',
                            'everything_in_premium'=>'Everything in Premium',
                            'templates_count'=>$val.' Templates',
                            default=>str_replace('_',' ',$key)
                        } }}
                    </li>
                    @endforeach
                </ul>
                @endif
                @auth
                    <a href="{{ route('customer.events.create') }}" class="btn {{ $plan->name==='Premium' ? 'btn-primary' : 'btn-outline' }}" style="width:100%;justify-content:center;padding:.75rem;">
                        {{ app()->isLocale('ar') ? 'إنشاء حدث' : 'Create Event' }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn {{ $plan->name==='Premium' ? 'btn-primary' : 'btn-outline' }}" style="width:100%;justify-content:center;padding:.75rem;">
                        {{ $plan->isFree() ? (app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Start for Free') : (app()->isLocale('ar') ? 'اختر هذه الباقة' : 'Choose This Plan') }}
                    </a>
                @endauth
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── TESTIMONIALS ─── --}}
<section class="section testi-bg">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'آراء العملاء' : 'Testimonials' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'قالوا عن فرحنا' : 'What People Say' }}</h2>
        </div>
        <div class="testi-grid">
            @foreach(app()->isLocale('ar') ? [
                ['أحمد ومنى','قاهرة – أبريل ٢٠٢٥','ما توقعناش يبقى سهل كده! في أقل من دقيقتين كانت الدعوة جاهزة وكلهم بيقولوا إنها أجمل دعوة شافوها 💕'],
                ['كريم وسارة','الإسكندرية – يونيو ٢٠٢٥','الموقع الديناميكي كان مذهل! الأهل والأصدقاء استمتعوا بالعد التنازلي للحفل كتير. شكراً فرحنا! 🎉'],
                ['يوسف ومريم','الجيزة – سبتمبر ٢٠٢٥','سهولة الاستخدام والتصميم الأنيق خلى الدعوة تعكس شخصيتنا بالظبط. أنصح بيها بشدة ❤️'],
            ] : [
                ['Ahmed & Mona','Cairo – April 2025','We didn\'t expect it to be this easy! In less than 2 minutes the invitation was ready and everyone said it was the most beautiful invitation they\'d ever seen 💕'],
                ['Karim & Sara','Alexandria – June 2025','The dynamic website was incredible! Family and friends loved the countdown to the celebration. Thank you Farahna! 🎉'],
                ['Yousef & Mariam','Giza – September 2025','The ease of use and elegant design made the invitation perfectly reflect our personalities. Highly recommend ❤️'],
            ] as $t)
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"{{ $t[2] }}"</p>
                <div class="testi-author">
                    <div class="testi-avatar">💍</div>
                    <div>
                        <p class="testi-name">{{ $t[0] }}</p>
                        <p class="testi-event">{{ $t[1] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── FAQ ─── --}}
<section class="section faq-bg" id="faq">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">{{ app()->isLocale('ar') ? 'الأسئلة الشائعة' : 'FAQ' }}</span>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'كل ما تريد معرفته' : 'Everything You Need to Know' }}</h2>
        </div>
        <div class="faq-wrap">
            @php
            $faqs = app()->isLocale('ar') ? [
                ['ما الفرق بين الدعوة الثابتة والموقع التفاعلي؟','الدعوة الثابتة صورة جميلة تشاركها مباشرة. الموقع التفاعلي رابط كامل يحتوي على عد تنازلي، RSVP، معرض صور، وسجل تهاني — كل ده في موقع خاص بمناسبتك.'],
                ['هل أقدر أعدّل التفاصيل بعد النشر؟','نعم! تقدر تعدّل الاسم، التاريخ، المكان، الصور، وأي تفاصيل في أي وقت من لوحة التحكم الخاصة بك.'],
                ['كيف يصل الضيوف للدعوة؟','بعد إنشاء الدعوة، بتاخد رابط خاص تشاركه على واتساب، انستجرام، أو أي منصة — بنقرة واحدة.'],
                ['هل يمكن استخدامه لمناسبات غير الزفاف؟','بالتأكيد! فرحنا يدعم أي مناسبة: زفاف، عيد ميلاد، خطوبة، حفل تخرج، واحتفالات أخرى كثيرة.'],
                ['هل هناك رسوم مخفية؟','لا على الإطلاق. الباقة المجانية مجانية للأبد، والباقة المدفوعة دفعة واحدة بدون اشتراكات شهرية مفاجأة.'],
            ] : [
                ['What\'s the difference between static and interactive templates?','A static invitation is a beautiful image you share directly. An interactive website is a full link with countdown, RSVP, photo gallery, and guest book — all in a site dedicated to your event.'],
                ['Can I edit details after publishing?','Yes! You can edit names, dates, venue, photos, and any details anytime from your personal dashboard.'],
                ['How do guests access the invitation?','After creating your invitation, you get a private link to share on WhatsApp, Instagram, or any platform — with one click.'],
                ['Can I use it for non-wedding events?','Absolutely! Farahna supports any occasion: weddings, birthdays, engagements, graduations, and many more.'],
                ['Are there hidden fees?','None whatsoever. The free plan is free forever, and paid plans are one-time payments with no surprise monthly subscriptions.'],
            ];
            @endphp
            @foreach($faqs as $i => $faq)
            <div class="faq-item" :class="{ open: faqOpen === {{ $i }} }">
                <button class="faq-q" @click="toggleFaq({{ $i }})">
                    {{ $faq[0] }}
                    <span class="faq-arrow">▼</span>
                </button>
                <div class="faq-a">{{ $faq[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="cta-section">
    <div class="cta-inner">
        @if(app()->isLocale('ar'))
        <h2 class="cta-title">ابدأ رحلتك اليوم ♥</h2>
        <p class="cta-desc">أنشئ دعوتك الأولى مجاناً — لا حاجة لبطاقة ائتمان</p>
        <div class="cta-btns">
            @auth
                <a href="{{ route('customer.events.create') }}" class="cta-btn-main">ابدأ إنشاء حدث</a>
            @else
                <a href="{{ route('register') }}" class="cta-btn-main">ابدأ مجاناً الآن</a>
            @endauth
            <a href="{{ route('templates.index') }}" class="btn btn-glass btn-lg">استعرض القوالب</a>
        </div>
        @else
        <h2 class="cta-title">Start Your Journey Today ♥</h2>
        <p class="cta-desc">Create your first invitation for free — no credit card needed</p>
        <div class="cta-btns">
            @auth
                <a href="{{ route('customer.events.create') }}" class="cta-btn-main">Create an Event</a>
            @else
                <a href="{{ route('register') }}" class="cta-btn-main">Get Started Free</a>
            @endauth
            <a href="{{ route('templates.index') }}" class="btn btn-glass btn-lg">Browse Templates</a>
        </div>
        @endif
    </div>
</section>

{{-- ─── FOOTER ─── --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            <a class="footer-brand">{{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }}</a>
            <p class="footer-tagline">{{ app()->isLocale('ar') ? 'دعوات رقمية أنيقة لكل مناسبة — من القلب لقلبهم' : 'Elegant digital invitations for every occasion — from the heart to theirs' }}</p>
        </div>
        <div class="footer-col">
            <h4>{{ app()->isLocale('ar') ? 'روابط' : 'Links' }}</h4>
            <a href="#how">{{ app()->isLocale('ar') ? 'كيف يعمل' : 'How It Works' }}</a>
            <a href="#templates">{{ app()->isLocale('ar') ? 'القوالب' : 'Templates' }}</a>
            <a href="#pricing">{{ app()->isLocale('ar') ? 'الأسعار' : 'Pricing' }}</a>
            <a href="#faq">{{ app()->isLocale('ar') ? 'الأسئلة الشائعة' : 'FAQ' }}</a>
        </div>
        <div class="footer-col">
            <h4>{{ app()->isLocale('ar') ? 'الباقات' : 'Plans' }}</h4>
            @foreach($plans as $plan)
            <a href="#pricing">{{ $plan->name }} — {{ $plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : number_format($plan->price).' EGP' }}</a>
            @endforeach
            @auth
                <a href="{{ route('customer.dashboard') }}">{{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}</a>
            @else
                <a href="{{ route('register') }}">{{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started Free' }}</a>
            @endauth
        </div>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} Farahna. {{ app()->isLocale('ar') ? 'جميع الحقوق محفوظة' : 'All rights reserved' }}.</div>
</footer>

</body>
</html>
