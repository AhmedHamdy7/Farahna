<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'فرحنا – دعوات رقمية لكل مناسبة' : 'Farahna – Digital Invitations for Every Occasion' }}</title>
    <meta name="description" content="{{ app()->isLocale('ar') ? 'أنشئ دعوتك الرقمية في دقائق — زفاف، عيد ميلاد، خطوبة، تخرج. قوالب احترافية مع RSVP وعد تنازلي.' : 'Create your digital invitation in minutes — weddings, birthdays, engagements, graduations. Professional templates with RSVP and countdown.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Tajawal:wght@300;400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        /* Brand — Midnight Gold */
        --gold:    #c9a84c;
        --gold-d:  #a8863a;
        --gold-l:  #e0c878;
        --gold-bg: #faf7ee;
        --gold-xl: #f0e8c8;
        /* Deep navy */
        --navy:    #0a1628;
        --navy-m:  #162035;
        /* Neutrals */
        --slate:   #12100e;
        --slate-m: #1e2435;
        --slate-l: #3d4a5c;
        --gray:    #6b6358;
        --gray-l:  #9a8f84;
        --border:  #e8e3d8;
        --surface: #faf8f3;
        --white:   #ffffff;
        /* Util */
        --amber:   #d97706;
        --amber-l: #fcd34d;
    }

    html { scroll-behavior: smooth; }
    body {
        font-family: 'Inter', 'Tajawal', sans-serif;
        background: var(--white);
        color: var(--slate);
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }
    html[dir=rtl] body { font-family: 'Tajawal', 'Inter', sans-serif; }

    /* ── ANIMATIONS ── */
    @keyframes float-y    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
    @keyframes slide-l    { from{opacity:0;transform:translateX(-32px)} to{opacity:1;transform:translateX(0)} }
    @keyframes slide-r    { from{opacity:0;transform:translateX(32px)}  to{opacity:1;transform:translateX(0)} }
    @keyframes fade-up    { from{opacity:0;transform:translateY(20px)}  to{opacity:1;transform:translateY(0)} }
    @keyframes pulse-dot  { 0%,100%{box-shadow:0 0 0 0 rgba(201,168,76,.5)} 70%{box-shadow:0 0 0 10px rgba(201,168,76,0)} }
    @keyframes mesh-move  { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
    @keyframes orb-1      { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(40px,-30px) scale(1.08)} 66%{transform:translate(-25px,20px) scale(.95)} }
    @keyframes orb-2      { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(-30px,40px) scale(1.05)} 66%{transform:translate(20px,-25px) scale(.97)} }
    @keyframes orb-3      { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(25px,30px) scale(1.06)} }
    @keyframes particle   { 0%{transform:translateY(0) translateX(0);opacity:0} 10%{opacity:.7} 90%{opacity:.2} 100%{transform:translateY(-120px) translateX(var(--dx,10px));opacity:0} }
    @keyframes shimmer    { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
    @keyframes scan-line  { 0%{top:-100%} 100%{top:110%} }
    @keyframes badge-pop  { 0%{opacity:0;transform:scale(.8) translateY(8px)} 100%{opacity:1;transform:scale(1) translateY(0)} }

    /* ── NAVBAR ── */
    .nav {
        position: fixed; top: 0; width: 100%; z-index: 300;
        background: rgba(255,255,255,.88); backdrop-filter: blur(20px) saturate(1.8);
        border-bottom: 1px solid rgba(226,232,240,.6);
        padding: 0 2rem; height: 62px;
        display: flex; align-items: center; justify-content: space-between;
        transition: box-shadow .3s;
    }
    .nav.scrolled { box-shadow: 0 4px 24px rgba(18,16,14,.07); }
    .nav-brand {
        font-family: 'Playfair Display', serif; font-size: 1.6rem; font-style: italic;
        color: var(--gold-d); text-decoration: none; font-weight: 700;
        letter-spacing: -.3px;
    }
    .nav-links { display: flex; align-items: center; gap: 1.2rem; }
    .nav-link { color: var(--gray); text-decoration: none; font-size: .875rem; font-weight: 500; transition: color .2s; white-space: nowrap; }
    .nav-link:hover { color: var(--slate); }
    .btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .5rem 1.2rem; border-radius: 8px;
        font-size: .875rem; font-family: inherit; cursor: pointer;
        text-decoration: none; transition: all .2s; border: none; font-weight: 600;
        white-space: nowrap;
    }
    .btn-primary  { background: var(--navy); color: var(--gold-l); box-shadow: 0 2px 12px rgba(10,22,40,.3); }
    .btn-primary:hover { background: var(--navy-m); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(10,22,40,.4); }
    .btn-outline  { background: transparent; border: 1.5px solid var(--border); color: var(--slate); }
    .btn-outline:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-bg); }
    .btn-ghost    { background: rgba(255,255,255,.12); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,.25); color: #fff; }
    .btn-ghost:hover { background: rgba(255,255,255,.22); }
    .btn-lg { padding: .75rem 1.8rem; font-size: .95rem; border-radius: 10px; }
    .btn-xl { padding: .9rem 2.2rem; font-size: 1rem; border-radius: 12px; }

    /* ── HERO ── */
    .hero {
        min-height: 100vh; padding-top: 62px;
        position: relative; overflow: hidden;
        display: flex; align-items: center;
        background: var(--white);
    }
    /* Subtle dot grid */
    .hero::before {
        content: ''; position: absolute; inset: 0; pointer-events: none; z-index: 0;
        background-image: radial-gradient(circle, rgba(200,180,140,.16) 1px, transparent 1px);
        background-size: 28px 28px;
    }

    .hero-inner {
        position: relative; z-index: 2;
        max-width: 1220px; margin: 0 auto; padding: 3rem 2rem;
        display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
    }
    .hero-left  { animation: slide-l .8s ease forwards; }
    .hero-right { animation: slide-r .8s ease .1s both; }

    /* Badge */
    .hero-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        background: var(--gold-bg); border: 1px solid var(--gold-xl);
        color: var(--gold-d); border-radius: 999px;
        padding: .35rem 1rem; font-size: .78rem; font-weight: 600;
        letter-spacing: .3px; margin-bottom: 1.5rem;
    }
    .badge-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--gold); animation: pulse-dot 2s infinite; flex-shrink: 0; }

    /* Hero headline */
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.6rem, 5vw, 4rem);
        line-height: 1.12; color: var(--slate); margin-bottom: 1.2rem;
        font-weight: 700; letter-spacing: -.5px;
    }
    .hero-title em { color: var(--gold); font-style: italic; }

    .hero-desc {
        font-size: 1.05rem; color: var(--gray); max-width: 460px;
        line-height: 1.85; margin-bottom: 2.5rem; font-weight: 400;
    }
    .hero-btns { display: flex; gap: .9rem; flex-wrap: wrap; margin-bottom: 3rem; }

    /* Social proof */
    .hero-proof { display: flex; align-items: center; gap: 1.2rem; flex-wrap: wrap; }
    .proof-avatars { display: flex; }
    .proof-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        border: 2.5px solid var(--white);
        margin-left: -9px;
        background: linear-gradient(135deg, var(--gold-xl), #f5e4a8);
        display: flex; align-items: center; justify-content: center; font-size: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }
    .proof-avatar:first-child { margin-left: 0; }
    html[dir=rtl] .proof-avatar { margin-left: 0; margin-right: -9px; }
    html[dir=rtl] .proof-avatar:first-child { margin-right: 0; }
    .proof-text { font-size: .83rem; color: var(--gray); line-height: 1.4; }
    .proof-text strong { color: var(--slate); display: block; font-size: .88rem; }
    .stars { color: #f59e0b; font-size: .85rem; letter-spacing: 1px; margin-bottom: .1rem; }

    /* ── PHONE MOCKUP WRAP ── */
    .phone-scene {
        position: relative;
        display: flex; align-items: center; justify-content: center;
        min-height: 560px;
    }

    /* Animated mesh gradient background — warm gold/cream */
    .phone-bg-mesh {
        position: absolute; inset: -20px;
        border-radius: 32px;
        background: linear-gradient(
            -45deg,
            #f5e8c0, #ede0b0, #f0e8c8, #faf7ee, #e8d9a8
        );
        background-size: 400% 400%;
        animation: mesh-move 12s ease infinite;
        opacity: .65;
        filter: blur(1px);
    }

    /* Animated orbs */
    .orb {
        position: absolute; border-radius: 50%;
        filter: blur(50px); pointer-events: none;
    }
    .orb-1 { width: 260px; height: 260px; background: radial-gradient(circle, rgba(201,168,76,.25), transparent 70%); top: 5%; right: 5%; animation: orb-1 14s ease-in-out infinite; }
    .orb-2 { width: 200px; height: 200px; background: radial-gradient(circle, rgba(10,22,40,.12), transparent 70%); bottom: 10%; left: 5%; animation: orb-2 17s ease-in-out infinite; }
    .orb-3 { width: 150px; height: 150px; background: radial-gradient(circle, rgba(201,168,76,.16), transparent 70%); top: 45%; left: 20%; animation: orb-3 11s ease-in-out infinite; }

    /* Particles */
    .particles { position: absolute; inset: 0; pointer-events: none; overflow: hidden; border-radius: 32px; }
    .particle {
        position: absolute; width: 3px; height: 3px; border-radius: 50%;
        background: var(--gold-l); animation: particle 5s ease-in-out infinite;
    }

    /* Phone device */
    .phone {
        width: 256px; height: 516px;
        background: var(--navy); border-radius: 42px;
        border: 6px solid #162035;
        position: relative; z-index: 2;
        box-shadow:
            0 50px 100px rgba(10,22,40,.4),
            0 0 0 1px rgba(255,255,255,.07),
            inset 0 0 0 1px rgba(255,255,255,.06);
        animation: float-y 5.5s ease-in-out infinite;
        overflow: hidden;
    }
    /* Notch */
    .phone::before {
        content: ''; position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
        width: 76px; height: 22px; background: var(--navy);
        border-radius: 0 0 14px 14px; z-index: 10;
    }
    /* Side button */
    .phone::after {
        content: ''; position: absolute; top: 90px; right: -8px;
        width: 4px; height: 48px; background: #2a3a4e; border-radius: 0 4px 4px 0;
    }

    /* Phone screen */
    .phone-screen {
        width: 100%; height: 100%; overflow: hidden;
        border-radius: 36px; display: flex; flex-direction: column;
        position: relative;
    }

    /* The invitation inside phone */
    .phone-invite {
        flex: 1; position: relative; overflow: hidden;
        background: linear-gradient(165deg, #0d1b3e 0%, #152247 50%, #0a1428 100%);
        display: flex; flex-direction: column; align-items: center;
        text-align: center; padding: 36px 18px 16px; gap: 4px;
    }
    /* Star field */
    .phone-invite::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(212,175,55,.15) 1px, transparent 1px);
        background-size: 18px 18px; pointer-events: none;
    }
    /* Glow center */
    .phone-invite::after {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 50% 55%, rgba(212,175,55,.1), transparent 60%);
    }
    /* Scan line animation */
    .phone-scan {
        position: absolute; left: 0; right: 0; height: 60px;
        background: linear-gradient(to bottom, transparent, rgba(212,175,55,.04), transparent);
        pointer-events: none; z-index: 3;
        animation: scan-line 6s linear infinite;
    }
    .pi-tag {
        font-size: 7.5px; letter-spacing: 3px;
        color: rgba(212,175,55,.65); text-transform: uppercase;
        position: relative; z-index: 2; margin-bottom: 4px;
    }
    .pi-names {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 700; color: #f5d26a;
        line-height: 1.25; position: relative; z-index: 2;
    }
    .pi-and {
        font-size: 13px; color: rgba(212,175,55,.5); display: block; line-height: 1.6;
        font-style: italic;
    }
    .pi-line {
        width: 48px; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212,175,55,.55), transparent);
        margin: 6px auto; position: relative; z-index: 2;
    }
    .pi-date {
        font-size: 8.5px; color: rgba(255,255,255,.5); line-height: 1.9;
        position: relative; z-index: 2;
    }
    .pi-venue {
        font-size: 8px; color: rgba(212,175,55,.5); position: relative; z-index: 2;
        letter-spacing: .5px;
    }
    /* Mini countdown */
    .pi-cd {
        display: flex; gap: 5px; justify-content: center;
        margin-top: 10px; position: relative; z-index: 2;
    }
    .pi-cd-box {
        background: rgba(212,175,55,.12); border: 1px solid rgba(212,175,55,.28);
        border-radius: 5px; width: 38px; height: 38px;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1px;
    }
    .pi-cd-num { font-size: 14px; font-weight: 700; color: #f5d26a; line-height: 1; }
    .pi-cd-lbl { font-size: 5.5px; color: rgba(255,255,255,.38); letter-spacing: .8px; text-transform: uppercase; }
    /* Mini RSVP bar */
    .pi-rsvp {
        margin-top: 10px; position: relative; z-index: 2;
        background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
        border-radius: 6px; padding: 5px 10px;
        font-size: 7.5px; color: rgba(255,255,255,.55);
        display: flex; align-items: center; gap: 4px;
    }
    .pi-rsvp-dot { width: 5px; height: 5px; border-radius: 50%; background: #4ade80; flex-shrink: 0; box-shadow: 0 0 5px #4ade80; }

    /* Phone bottom bar */
    .phone-bottom {
        height: 44px; background: #162035;
        display: flex; align-items: center; justify-content: center;
        border-top: 1px solid rgba(255,255,255,.06);
    }
    .phone-bar { width: 88px; height: 4px; background: rgba(255,255,255,.2); border-radius: 2px; }

    /* Floating badges */
    .float-badge {
        position: absolute; background: rgba(255,255,255,.95);
        border: 1px solid rgba(226,232,240,.8); border-radius: 14px;
        padding: .55rem 1rem; font-size: .78rem; font-weight: 600;
        display: flex; align-items: center; gap: .5rem;
        box-shadow: 0 8px 32px rgba(15,23,42,.12);
        white-space: nowrap; z-index: 5;
        backdrop-filter: blur(8px);
    }
    .fb-1 { right: -10px; top: 16%; animation: float-y 4s ease-in-out infinite; animation-delay: 0s; }
    .fb-2 { left: -20px; bottom: 30%; animation: float-y 5s ease-in-out infinite; animation-delay: 1s; }
    .fb-3 { right: -14px; bottom: 18%; animation: float-y 4.5s ease-in-out infinite; animation-delay: .5s; }
    html[dir=rtl] .fb-1 { right: unset; left: -10px; }
    html[dir=rtl] .fb-2 { left: unset; right: -20px; }
    html[dir=rtl] .fb-3 { right: unset; left: -14px; }

    /* ── STATS STRIP ── */
    .stats-strip {
        background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        padding: 1.4rem 2rem;
    }
    .stats-inner {
        max-width: 1100px; margin: 0 auto;
        display: flex; align-items: center; justify-content: center; gap: 4rem; flex-wrap: wrap;
    }
    .stat-item { text-align: center; }
    .stat-num {
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem; font-weight: 700; color: var(--gold-d); line-height: 1;
        display: block; margin-bottom: .15rem;
    }
    .stat-lbl { font-size: .78rem; color: var(--gray); font-weight: 500; }
    .stat-div { width: 1px; height: 36px; background: var(--border); }

    /* ── SECTION SYSTEM ── */
    .section { padding: 5rem 2rem; }
    .container { max-width: 1100px; margin: 0 auto; }
    .section-head { text-align: center; margin-bottom: 3.5rem; }
    .section-eyebrow {
        display: inline-block; font-size: .72rem; font-weight: 700;
        letter-spacing: 2.5px; text-transform: uppercase;
        color: var(--gold); margin-bottom: .8rem;
    }
    .section-eyebrow::before, .section-eyebrow::after {
        content: '—'; margin: 0 .5rem; opacity: .5;
    }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.7rem, 4vw, 2.4rem);
        color: var(--slate); margin-bottom: .75rem; font-weight: 700;
        letter-spacing: -.3px;
    }
    .section-desc { color: var(--gray); max-width: 500px; margin: 0 auto; line-height: 1.75; }

    /* ── HOW IT WORKS ── */
    .how-bg { background: var(--surface); }
    .steps-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 2rem; position: relative;
    }
    @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }
    .steps-grid::before {
        content: ''; position: absolute; top: 32px; left: 16%; right: 16%; height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), var(--gold), transparent);
    }
    @media (max-width: 768px) { .steps-grid::before { display: none; } }
    .step-card { text-align: center; padding: 2rem 1rem; }
    .step-circle {
        width: 60px; height: 60px; border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), var(--gold-d));
        display: inline-flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: var(--gold-l);
        box-shadow: 0 8px 24px rgba(10,22,40,.3);
        margin-bottom: 1.4rem; position: relative;
    }
    .step-circle::after {
        content: ''; position: absolute; inset: -6px;
        border-radius: 50%; border: 1.5px dashed var(--gold-xl);
    }
    .step-emoji { font-size: 2rem; margin-bottom: .75rem; display: block; }
    .step-title { font-weight: 700; font-size: 1rem; margin-bottom: .5rem; color: var(--slate); }
    .step-desc  { color: var(--gray); font-size: .875rem; line-height: 1.7; }

    /* ── FEATURES ── */
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 1.25rem; }
    .feature-card {
        background: var(--white); border: 1.5px solid var(--border); border-radius: 16px;
        padding: 1.75rem; transition: transform .3s, box-shadow .3s, border-color .3s;
        position: relative; overflow: hidden;
    }
    .feature-card::after {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--navy), var(--gold));
        transform: scaleX(0); transform-origin: left; transition: transform .3s;
    }
    .feature-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(18,16,14,.07); border-color: var(--gold-xl); }
    .feature-card:hover::after { transform: scaleX(1); }
    .feature-icon { font-size: 2rem; margin-bottom: 1rem; display: block; }
    .feature-title { font-weight: 700; font-size: 1rem; margin-bottom: .5rem; color: var(--slate); }
    .feature-desc  { color: var(--gray); font-size: .875rem; line-height: 1.7; }

    /* ── TEMPLATES SHOWCASE ── */
    .templates-bg {
        background: linear-gradient(160deg, var(--surface) 0%, var(--gold-bg) 55%, #f5eedc 100%);
    }

    /* Grid */
    .tpl-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.6rem;
    }
    @media (max-width: 860px) { .tpl-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 520px) { .tpl-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } }

    /* ── PHONE MOCKUP CARDS ── */
    .tpl-card {
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 24px;
        overflow: hidden;
        transition: transform .38s cubic-bezier(.4,0,.2,1), box-shadow .38s, border-color .3s;
        box-shadow: 0 4px 20px rgba(18,16,14,.07);
        cursor: pointer;
        display: flex; flex-direction: column; align-items: center;
    }
    .tpl-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 28px 70px rgba(18,16,14,.16);
        border-color: var(--gold-xl);
    }

    /* Phone wrap — the coloured area at the top */
    .tpl-phone-wrap {
        width: 100%;
        padding: 1.6rem 0 1.2rem;
        display: flex; justify-content: center; align-items: center;
        position: relative;
        /* subtle warm radial glow behind the phone */
        background: radial-gradient(ellipse 80% 90% at 50% 60%, var(--gold-bg), var(--surface));
    }

    /* The actual device bezel */
    .tpl-phone {
        width: 152px; height: 300px;
        background: #0d0d1a;
        border-radius: 30px;
        border: 5px solid #1a1a2e;
        box-shadow:
            0 0 0 1px rgba(255,255,255,.07),
            0 18px 55px rgba(0,0,0,.38),
            inset 0 0 0 1px rgba(255,255,255,.04);
        position: relative; overflow: hidden;
        transition: box-shadow .38s;
    }
    .tpl-card:hover .tpl-phone {
        box-shadow:
            0 0 0 1px rgba(201,168,76,.2),
            0 28px 75px rgba(0,0,0,.5),
            inset 0 0 0 1px rgba(255,255,255,.04);
    }

    /* Notch */
    .tpl-phone::before {
        content: '';
        position: absolute; top: 7px; left: 50%; transform: translateX(-50%);
        width: 48px; height: 13px;
        background: #0d0d1a;
        border-radius: 999px; z-index: 10;
    }

    /* Screen container — clips the scaled iframe */
    .tpl-screen-frame {
        position: absolute; inset: 0;
        border-radius: 25px; overflow: hidden;
        background: #0d0d1a; /* dark fallback while iframe loads */
    }
    /* Phone bottom bar — solid dark strip like iPhone home indicator */
    .tpl-phone-bottom-bar {
        position: absolute; bottom: 0; left: 0; right: 0;
        height: 30px;
        background: #0d0d1a;
        border-radius: 0 0 24px 24px;
        z-index: 22;
        pointer-events: none;
        display: flex; align-items: center; justify-content: center;
    }
    /* Home indicator pill */
    .tpl-phone-bottom-bar::after {
        content: '';
        width: 44px; height: 4px;
        background: rgba(255,255,255,.2);
        border-radius: 999px;
    }
    /* Gradient bridge between content and the bar */
    .tpl-phone-shade {
        position: absolute; bottom: 30px; left: 0; right: 0;
        height: 28px;
        background: linear-gradient(to top,
            rgba(13,13,26,.75) 0%,
            transparent        100%);
        pointer-events: none;
        z-index: 21;
    }

    /* The actual template rendered at 375px, then shrunk to fit 142px wide phone */
    /* scale = 142 / 375 = 0.3787 */
    .tpl-iframe {
        width: 375px;
        height: 800px;
        border: none;
        transform: scale(0.3787);
        transform-origin: top left;
        pointer-events: none;
        display: block;
        overflow: hidden;
    }

    /* Card body below phone */
    .tpl-card-body {
        width: 100%;
        padding: .85rem 1.1rem 1.1rem;
        display: flex; flex-direction: column; align-items: center;
        gap: .3rem; text-align: center;
        border-top: 1px solid var(--border);
    }
    .tpl-plan {
        font-size: .62rem; font-weight: 700; padding: .18rem .65rem;
        border-radius: 999px; letter-spacing: .3px;
    }
    .tpl-plan.free    { background: #dcfce7; color: #166534; }
    .tpl-plan.premium { background: var(--gold-xl); color: var(--gold-d); }
    .tpl-name {
        font-family: 'Playfair Display', serif;
        font-size: .95rem; font-weight: 700; color: var(--slate);
        line-height: 1.2;
    }
    .tpl-meta {
        display: flex; align-items: center; gap: .4rem;
        font-size: .69rem; color: var(--gray);
    }
    .tpl-meta-sep { width: 3px; height: 3px; border-radius: 50%; background: var(--border); flex-shrink: 0; }
    .tpl-actions { display: flex; gap: .5rem; margin-top: .4rem; }

    .tpl-btn {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .45rem 1rem; border-radius: 8px;
        font-size: .78rem; font-weight: 700; cursor: pointer;
        text-decoration: none; border: none; font-family: inherit;
        white-space: nowrap; transition: transform .2s, box-shadow .2s;
    }
    .tpl-btn:hover { transform: translateY(-2px); }
    .tpl-btn-ghost { background: transparent; color: var(--muted); border: 1.5px solid var(--border); }
    .tpl-btn-ghost:hover { border-color: var(--gold); color: var(--gold-d); background: var(--gold-bg); }
    .tpl-btn-gold { background: var(--navy); color: var(--gold-l); box-shadow: 0 4px 14px rgba(10,22,40,.25); }
    .tpl-btn-gold:hover { background: var(--navy-m); box-shadow: 0 6px 20px rgba(10,22,40,.35); }

    /* CTA row below grid */
    .tpl-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 2.5rem; padding-top: 2rem;
        border-top: 1px solid var(--border);
        flex-wrap: wrap; gap: 1rem;
    }
    .tpl-footer-text { font-size: .9rem; color: var(--gray); }
    .tpl-footer-text strong { color: var(--slate); }

    /* ── PRICING ── */
    .pricing-bg { background: var(--surface); }
    .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(255px, 1fr)); gap: 1.5rem; max-width: 920px; margin: 0 auto; }
    .plan-card {
        border: 2px solid var(--border); border-radius: 22px; padding: 2rem;
        background: var(--white); transition: transform .3s, box-shadow .3s; position: relative;
    }
    .plan-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(15,23,42,.08); }
    .plan-card.popular {
        border-color: var(--gold);
        box-shadow: 0 8px 32px rgba(201,168,76,.2);
        background: linear-gradient(160deg, #fff, var(--gold-bg));
    }
    .popular-badge {
        position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
        background: linear-gradient(135deg, var(--navy), var(--gold-d));
        color: var(--gold-l); font-size: .7rem; font-weight: 700;
        padding: .35rem 1.1rem; border-radius: 999px;
        white-space: nowrap; box-shadow: 0 4px 14px rgba(10,22,40,.25);
    }
    .plan-icon  { font-size: 2.2rem; margin-bottom: 1rem; display: block; }
    .plan-name  { font-weight: 700; font-size: 1.05rem; margin-bottom: .5rem; color: var(--slate); }
    .plan-price {
        font-family: 'Playfair Display', serif; font-size: 2.6rem;
        font-weight: 700; color: var(--gold); line-height: 1; margin-bottom: .25rem;
    }
    .plan-price span { font-size: .9rem; color: var(--gray); font-family: inherit; font-weight: 400; }
    .plan-features { list-style: none; margin: 1.5rem 0; }
    .plan-features li { display: flex; align-items: center; gap: .6rem; padding: .4rem 0; font-size: .875rem; border-bottom: 1px solid var(--surface); }
    .plan-features li:last-child { border: none; }

    /* ── TESTIMONIALS ── */
    .testi-bg {
        background: linear-gradient(160deg, var(--gold-bg), #f5eedc 60%, var(--gold-bg));
    }
    .testi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap: 1.5rem; }
    .testi-card {
        background: rgba(255,255,255,.88); backdrop-filter: blur(10px);
        border: 1px solid rgba(232,227,216,.9); border-radius: 20px;
        padding: 1.75rem; position: relative;
        box-shadow: 0 4px 20px rgba(201,168,76,.08);
    }
    .testi-card::before { content: '❝'; position: absolute; top: .8rem; right: 1.1rem; font-size: 3rem; color: var(--gold-xl); line-height: 1; }
    [dir=ltr] .testi-card::before { right: auto; left: 1.1rem; }
    .testi-stars { color: #f59e0b; font-size: .85rem; margin-bottom: .75rem; }
    .testi-text  { color: var(--slate-l); line-height: 1.75; margin-bottom: 1rem; font-size: .9rem; }
    .testi-author { display: flex; align-items: center; gap: .75rem; }
    .testi-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-xl), #f0d898); display:flex;align-items:center;justify-content:center;font-size:1.1rem; flex-shrink: 0; }
    .testi-name  { font-weight: 700; font-size: .875rem; color: var(--slate); }
    .testi-event { font-size: .78rem; color: var(--gray); }

    /* ── FAQ ── */
    .faq-bg { background: var(--white); }
    .faq-wrap { max-width: 680px; margin: 0 auto; }
    .faq-item { border: 1.5px solid var(--border); border-radius: 14px; margin-bottom: .75rem; overflow: hidden; transition: border-color .2s; }
    .faq-item.open { border-color: var(--gold-xl); }
    .faq-q {
        width: 100%; display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.25rem; background: none; border: none; cursor: pointer;
        font-family: inherit; font-size: .93rem; font-weight: 600;
        color: var(--slate); text-align: right; gap: 1rem; transition: background .2s;
    }
    [dir=ltr] .faq-q { text-align: left; }
    .faq-item.open .faq-q { background: var(--gold-bg); color: var(--gold-d); }
    .faq-arrow { flex-shrink: 0; width: 24px; height: 24px; border-radius: 50%; background: var(--border); display: flex; align-items: center; justify-content: center; font-size: 11px; transition: transform .3s, background .2s; }
    .faq-item.open .faq-arrow { transform: rotate(180deg); background: var(--gold-xl); color: var(--gold-d); }
    .faq-a { display: none; padding: 0 1.25rem 1.1rem; color: var(--gray); font-size: .9rem; line-height: 1.75; }
    .faq-item.open .faq-a { display: block; }

    /* ── CTA ── */
    .cta-section {
        position: relative; overflow: hidden; text-align: center; padding: 6rem 2rem;
        background: linear-gradient(135deg, #0a1628 0%, #162035 50%, #0d1b2a 100%);
        color: #fff;
    }
    .cta-section::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(201,168,76,.07) 1px, transparent 1px);
        background-size: 26px 26px;
    }
    .cta-section::after {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .cta-inner { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
    .cta-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3rem); margin-bottom: 1rem; font-weight: 700; letter-spacing: -.3px; }
    .cta-title em { color: var(--gold-l); font-style: italic; }
    .cta-desc  { opacity: .82; font-size: 1.05rem; margin-bottom: 2.5rem; line-height: 1.7; }
    .cta-btns  { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .cta-btn-main {
        background: var(--gold); color: var(--navy);
        padding: .9rem 2.5rem; border-radius: 12px;
        font-size: 1rem; font-weight: 700; text-decoration: none;
        display: inline-block; transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 24px rgba(201,168,76,.4);
    }
    .cta-btn-main:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(201,168,76,.5); background: var(--gold-l); }

    /* ── FOOTER ── */
    .footer { background: var(--navy); color: rgba(224,200,120,.5); padding: 3rem 2rem; }
    .footer-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 3rem; }
    .footer-brand-name { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--gold-l); font-style: italic; margin-bottom: .5rem; display: block; }
    .footer-tagline { font-size: .85rem; line-height: 1.65; max-width: 220px; color: rgba(224,200,120,.45); }
    .footer-col h4 { color: rgba(255,255,255,.65); font-size: .82rem; font-weight: 700; margin-bottom: 1rem; letter-spacing: .5px; text-transform: uppercase; }
    .footer-col a { display: block; color: rgba(224,200,120,.45); text-decoration: none; font-size: .85rem; margin-bottom: .5rem; transition: color .2s; }
    .footer-col a:hover { color: var(--gold-l); }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,.07); margin-top: 2rem; padding-top: 1.5rem; text-align: center; font-size: .78rem; opacity: .35; max-width: 1100px; margin-left: auto; margin-right: auto; }

    /* ── RESPONSIVE ── */
    @media (max-width: 960px) {
        .hero-inner { grid-template-columns: 1fr; gap: 2.5rem; text-align: center; }
        .hero-left  { order: 1; }
        .hero-right { order: 0; }
        .hero-btns, .hero-proof { justify-content: center; }
        .hero-desc { margin-left: auto; margin-right: auto; }
        .fb-1, .fb-2, .fb-3 { display: none; }
        .steps-grid::before { display: none; }
        .footer-inner { grid-template-columns: 1fr; gap: 1.5rem; }
    }
    @media (max-width: 600px) {
        .nav-links .nav-link { display: none; }
        .stat-div { display: none; }
        .stats-inner { gap: 2rem; }
        .hero-title { font-size: 2.4rem; }
    }
    </style>
</head>
<body x-data="{ faqOpen: null, toggleFaq(i){ this.faqOpen = this.faqOpen===i ? null : i } }">

{{-- ── NAVBAR ── --}}
<nav class="nav" x-data x-init="window.addEventListener('scroll',()=>$el.classList.toggle('scrolled',scrollY>40))">
    <a href="{{ route('home') }}" class="nav-brand">
        {{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }}
    </a>
    <div class="nav-links">
        <a href="#how"       class="nav-link">{{ app()->isLocale('ar') ? 'كيف يعمل' : 'How it Works' }}</a>
        <a href="#templates" class="nav-link">{{ app()->isLocale('ar') ? 'القوالب'  : 'Templates' }}</a>
        <a href="#pricing"   class="nav-link">{{ app()->isLocale('ar') ? 'الأسعار'  : 'Pricing' }}</a>
        <a href="#faq"       class="nav-link">{{ app()->isLocale('ar') ? 'أسئلة شائعة' : 'FAQ' }}</a>
        @if(app()->isLocale('ar'))
            <a href="{{ request()->fullUrlWithQuery(['lang'=>'en']) }}" class="btn btn-outline" style="padding:.35rem .8rem;font-size:.78rem;">🌐 EN</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['lang'=>'ar']) }}" class="btn btn-outline" style="padding:.35rem .8rem;font-size:.78rem;">🌐 AR</a>
        @endif
        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">{{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}</a>
        @else
            <a href="{{ route('login') }}" class="nav-link">{{ app()->isLocale('ar') ? 'دخول' : 'Login' }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary">{{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started' }}</a>
        @endauth
    </div>
</nav>

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-inner">

        {{-- LEFT: Copy --}}
        <div class="hero-left">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                {{ app()->isLocale('ar') ? '✨ دعوات رقمية لكل مناسبة' : '✨ Digital Invitations for Every Occasion' }}
            </div>

            @if(app()->isLocale('ar'))
            <h1 class="hero-title">اصنع دعوتك<br>بـ<em>لمسة فرح</em></h1>
            <p class="hero-desc">من دعوة زفاف أنيقة لموقع عيد ميلاد تفاعلي — قوالب احترافية بـ RSVP وعد تنازلي وسجل تهاني، تجهّزه في دقيقتين.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-xl">استعرض القوالب 💌</a>
                <a href="#how"       class="btn btn-outline btn-xl">كيف يعمل؟</a>
            </div>
            @else
            <h1 class="hero-title">Create Your<br><em>Perfect Invitation</em></h1>
            <p class="hero-desc">From elegant wedding cards to interactive birthday websites — professional templates with RSVP, countdown & guest book, ready in 2 minutes.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-xl">Browse Templates 💌</a>
                <a href="#how"       class="btn btn-outline btn-xl">How It Works</a>
            </div>
            @endif

            <div class="hero-proof">
                <div class="proof-avatars">
                    @foreach(['💍','🎂','🎓','💐','🎉'] as $e)
                    <div class="proof-avatar">{{ $e }}</div>
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

        {{-- RIGHT: Phone Mockup with animated background --}}
        <div class="hero-right">
            <div class="phone-scene">
                {{-- Animated mesh gradient background --}}
                <div class="phone-bg-mesh"></div>

                {{-- Animated color orbs --}}
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>

                {{-- Particles container (filled by JS) --}}
                <div class="particles" id="particles"></div>

                {{-- Phone device --}}
                <div class="phone">
                    <div class="phone-screen">
                        <div class="phone-invite">
                            <div class="phone-scan"></div>

                            <div class="pi-tag">
                                @if(app()->isLocale('ar'))
                                    دعوة زفاف · {{ now()->addMonths(3)->translatedFormat('Y') }}
                                @else
                                    Wedding Invitation · {{ now()->addMonths(3)->format('Y') }}
                                @endif
                            </div>

                            <div class="pi-names">
                                @if(app()->isLocale('ar'))
                                    أحمد
                                    <span class="pi-and">&amp;</span>
                                    سارة
                                @else
                                    James
                                    <span class="pi-and">&amp;</span>
                                    Emily
                                @endif
                            </div>

                            <div class="pi-line"></div>

                            <div class="pi-date">
                                @if(app()->isLocale('ar'))
                                    {{ now()->addMonths(3)->translatedFormat('l، d F Y') }}<br>
                                    ٨:٠٠ مساءً
                                @else
                                    {{ now()->addMonths(3)->format('l, d F Y') }}<br>
                                    8:00 PM
                                @endif
                            </div>

                            <div class="pi-venue">
                                @if(app()->isLocale('ar'))
                                    🏛 قاعة الأميرة · فندق الشيراتون، القاهرة
                                @else
                                    🏛 The Grand Ballroom · Sheraton Hotel, Cairo
                                @endif
                            </div>

                            <div class="pi-cd">
                                <div class="pi-cd-box">
                                    <div class="pi-cd-num" id="ph-days">--</div>
                                    <div class="pi-cd-lbl">{{ app()->isLocale('ar') ? 'يوم' : 'DAYS' }}</div>
                                </div>
                                <div class="pi-cd-box">
                                    <div class="pi-cd-num" id="ph-hrs">--</div>
                                    <div class="pi-cd-lbl">{{ app()->isLocale('ar') ? 'ساعة' : 'HRS' }}</div>
                                </div>
                                <div class="pi-cd-box">
                                    <div class="pi-cd-num" id="ph-min">--</div>
                                    <div class="pi-cd-lbl">{{ app()->isLocale('ar') ? 'دقيقة' : 'MIN' }}</div>
                                </div>
                            </div>

                            <div class="pi-rsvp">
                                <div class="pi-rsvp-dot"></div>
                                {{ app()->isLocale('ar') ? '١٢ ضيفاً أكّد حضوره' : '12 guests confirmed' }}
                            </div>
                        </div>
                        <div class="phone-bottom"><div class="phone-bar"></div></div>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="float-badge fb-1">✅ {{ app()->isLocale('ar') ? '١٢ ضيف أكد' : '12 confirmed' }}</div>
                <div class="float-badge fb-2">💌 {{ app()->isLocale('ar') ? 'تم الإرسال' : 'Invitation sent' }}</div>
                <div class="float-badge fb-3">⚡ {{ app()->isLocale('ar') ? 'دقيقتان فقط' : '2 min setup' }}</div>
            </div>
        </div>

    </div>
</section>

{{-- ── STATS STRIP ── --}}
<div class="stats-strip">
    <div class="stats-inner">
        <div class="stat-item">
            <span class="stat-num">+500</span>
            <span class="stat-lbl">{{ app()->isLocale('ar') ? 'مناسبة نُظِّمت' : 'Events Created' }}</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat-item">
            <span class="stat-num">4.9</span>
            <span class="stat-lbl">{{ app()->isLocale('ar') ? 'تقييم العملاء / ٥' : 'Customer Rating / 5' }}</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat-item">
            <span class="stat-num">{{ $templates->count() }}</span>
            <span class="stat-lbl">{{ app()->isLocale('ar') ? 'قالب احترافي' : 'Templates' }}</span>
        </div>
        <div class="stat-div"></div>
        <div class="stat-item">
            <span class="stat-num">2{{ app()->isLocale('ar') ? 'د' : 'm' }}</span>
            <span class="stat-lbl">{{ app()->isLocale('ar') ? 'وقت الإعداد' : 'Avg Setup Time' }}</span>
        </div>
    </div>
</div>

{{-- ── HOW IT WORKS ── --}}
<section class="section how-bg" id="how">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'كيف يعمل' : 'How It Works' }}</div>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'ثلاث خطوات وجاهز' : 'Three Steps to Go Live' }}</h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'أسرع طريقة لإنشاء دعوة تليق بمناسبتك' : 'The fastest way to create an invitation worthy of your occasion' }}</p>
        </div>
        <div class="steps-grid">
            @php
            $steps = app()->isLocale('ar') ? [
                ['1','🎨','اختر قالبك',     'تصفّح '.$templates->count().'+ قالب وشاهد معاينة حية قبل الاختيار'],
                ['2','✏️','أضف تفاصيلك',   'الأسم، التاريخ، المكان، الصور، وكل ما يخص مناسبتك'],
                ['3','💌','شارك على الفور', 'رابط خاص جاهز للمشاركة على واتساب وإنستجرام فوراً'],
            ] : [
                ['1','🎨','Pick a Template',  'Browse '.$templates->count().'+ templates with live preview before choosing'],
                ['2','✏️','Add Your Details', 'Names, date, venue, photos, and all your event details'],
                ['3','💌','Share Instantly',  'A private link ready to share on WhatsApp & Instagram'],
            ];
            @endphp
            @foreach($steps as $s)
            <div class="step-card">
                <div class="step-circle">{{ $s[0] }}</div>
                <div class="step-emoji">{{ $s[1] }}</div>
                <h3 class="step-title">{{ $s[2] }}</h3>
                <p class="step-desc">{{ $s[3] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FEATURES ── --}}
<section class="section">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'المميزات' : 'Features' }}</div>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'كل ما تحتاجه في مكان واحد' : 'Everything You Need' }}</h2>
        </div>
        <div class="features-grid">
            @php
            $features = app()->isLocale('ar') ? [
                ['⏳','عد تنازلي حي',     'يعرض الأيام والساعات والدقائق المتبقية للحفل بشكل أنيق ومتحرك'],
                ['💬','سجل التهاني',       'يسمح للمدعوين بترك كلمات تهنئة تظهر مباشرة في الدعوة'],
                ['✅','RSVP ذكي',          'تلقَّ تأكيدات الحضور وتتبع قائمة ضيوفك بلوحة تحكم مخصصة'],
                ['🖼️','معرض الصور',       'أضف صورك الخاصة وتظهر في تصميم أنيق جوا الدعوة'],
                ['📤','مشاركة بنقرة',      'رابط خاص للمشاركة على واتساب وانستجرام وجميع المنصات'],
                ['🎨',$templates->count().'+ قالب','قوالب مصممة باحتراف لكل مناسبة: زفاف، عيد ميلاد، تخرج، خطوبة'],
            ] : [
                ['⏳','Live Countdown',    'Elegant animated countdown showing days, hours, and minutes to the event'],
                ['💬','Guest Book',        'Let guests leave heartfelt messages that appear on the invitation'],
                ['✅','Smart RSVP',        'Collect RSVPs and track your guest list with a dedicated dashboard'],
                ['🖼️','Photo Gallery',    'Add your own photos displayed beautifully inside the invitation'],
                ['📤','One-Click Share',   'Private link ready to share on WhatsApp, Instagram, and all platforms'],
                ['🎨',$templates->count().'+ Templates','Professionally designed for every occasion: wedding, birthday, graduation'],
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

{{-- ── TEMPLATES ── --}}
<section class="section templates-bg" id="templates">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'القوالب' : 'Templates' }}</div>
            <h2 class="section-title">
                @if(app()->isLocale('ar'))اختر <em style="color:var(--gold-d);font-style:italic;">أسلوبك</em>
                @else Choose Your <em style="color:var(--gold-d);font-style:italic;">Style</em>@endif
            </h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'قوالب مصممة باحتراف لكل مناسبة ومزاج' : 'Professionally designed for every occasion and mood' }}</p>
        </div>

        @if($templates->isEmpty())
        <p style="text-align:center;color:var(--gray)">{{ app()->isLocale('ar') ? 'قوالب جديدة قادمة ✨' : 'New templates coming soon ✨' }}</p>
        @else
        <div class="tpl-grid">
            @foreach($templates->take(6) as $tpl)
            @php
                $planCls   = strtolower($tpl->plan->name ?? 'free');
                $catLabel  = $tpl->category?->label() ?? '';
                $typeLabel = $tpl->isWebsite()
                    ? (app()->isLocale('ar') ? '🌐 تفاعلي' : '🌐 Website')
                    : (app()->isLocale('ar') ? '🖼 بطاقة'  : '🖼 Card');
                $isAr = app()->isLocale('ar');
            @endphp
            <div class="tpl-card">

                {{-- Phone mockup area --}}
                <div class="tpl-phone-wrap">
                    <div class="tpl-phone">
                        <div class="tpl-screen-frame">
                            <iframe
                                src="{{ route('templates.preview-frame', $tpl) }}"
                                class="tpl-iframe"
                                loading="lazy"
                                scrolling="no"
                                tabindex="-1"
                                title="{{ $tpl->name }}"
                            ></iframe>
                        </div>
                        {{-- Gradient bridge --}}
                        <div class="tpl-phone-shade"></div>
                        {{-- Solid home-bar strip (completely hides bottom content) --}}
                        <div class="tpl-phone-bottom-bar"></div>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="tpl-card-body">
                    <span class="tpl-plan {{ $planCls }}">{{ $tpl->plan->name ?? 'Free' }}</span>
                    <p class="tpl-name">{{ $tpl->name }}</p>
                    <div class="tpl-meta">
                        <span>{{ $catLabel }}</span>
                        <span class="tpl-meta-sep"></span>
                        <span>{{ $typeLabel }}</span>
                    </div>
                    <div class="tpl-actions">
                        @if($tpl->isWebsite())
                        <a href="{{ route('templates.preview', $tpl) }}" class="tpl-btn tpl-btn-ghost">
                            👁 {{ $isAr ? 'معاينة' : 'Preview' }}
                        </a>
                        @endif
                        @auth
                        <a href="{{ route('customer.events.create') }}?template={{ $tpl->id }}" class="tpl-btn tpl-btn-gold">
                            {{ $isAr ? 'استخدم ✦' : 'Use ✦' }}
                        </a>
                        @else
                        <a href="{{ route('login') }}?template={{ $tpl->id }}" class="tpl-btn tpl-btn-gold">
                            {{ $isAr ? 'ابدأ الآن' : 'Start Now' }}
                        </a>
                        @endauth
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Footer CTA --}}
        <div class="tpl-footer">
            <p class="tpl-footer-text">
                {!! app()->isLocale('ar')
                    ? 'عارض <strong>' . ($templates->count() - 6) . ' قالب</strong> إضافي في مكتبتنا'
                    : 'Discover <strong>' . ($templates->count() - 6) . ' more templates</strong> in our collection'
                !!}
            </p>
            <a href="{{ route('templates.index') }}" class="btn btn-primary btn-lg">
                {{ app()->isLocale('ar') ? 'استعرض كل القوالب' : 'Browse All ' . $templates->count() . ' Templates' }} →
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ── PRICING ── --}}
<section class="section pricing-bg" id="pricing">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'الأسعار' : 'Pricing' }}</div>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'باقة تناسب كل مناسبة' : 'A Plan for Every Occasion' }}</h2>
            <p class="section-desc">{{ app()->isLocale('ar') ? 'ابدأ مجاناً وترقَّ متى أردت — بدون اشتراكات شهرية' : 'Start free and upgrade anytime — no monthly subscriptions' }}</p>
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

{{-- ── TESTIMONIALS ── --}}
<section class="section testi-bg">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'آراء العملاء' : 'Testimonials' }}</div>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'قالوا عن فرحنا' : 'What People Say' }}</h2>
        </div>
        <div class="testi-grid">
            @foreach(app()->isLocale('ar') ? [
                ['أحمد ومنى',   'القاهرة – أبريل ٢٠٢٥', '💍', 'ما توقعناش يبقى سهل كده! في أقل من دقيقتين كانت الدعوة جاهزة وكلهم بيقولوا إنها أجمل دعوة شافوها 💕'],
                ['كريم وسارة',  'الإسكندرية – يونيو ٢٠٢٥', '🎉', 'الموقع الديناميكي كان مذهل! الأهل والأصدقاء استمتعوا بالعد التنازلي للحفل كتير. شكراً فرحنا!'],
                ['يوسف ومريم', 'الجيزة – سبتمبر ٢٠٢٥', '❤️', 'سهولة الاستخدام والتصميم الأنيق خلى الدعوة تعكس شخصيتنا بالظبط. أنصح بيها بشدة'],
            ] : [
                ['Ahmed & Mona',    'Cairo – April 2025',     '💍', 'We didn\'t expect it to be this easy! In under 2 minutes the invitation was ready and everyone loved it 💕'],
                ['Karim & Sara',    'Alexandria – June 2025', '🎉', 'The interactive website was incredible! Family and friends loved the countdown. Thank you Farahna!'],
                ['Yousef & Mariam', 'Giza – September 2025',  '❤️', 'Ease of use and elegant design made the invitation perfectly reflect our personalities. Highly recommend'],
            ] as $t)
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"{{ $t[3] }}"</p>
                <div class="testi-author">
                    <div class="testi-avatar">{{ $t[2] }}</div>
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

{{-- ── FAQ ── --}}
<section class="section faq-bg" id="faq">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">{{ app()->isLocale('ar') ? 'أسئلة شائعة' : 'FAQ' }}</div>
            <h2 class="section-title">{{ app()->isLocale('ar') ? 'كل ما تريد معرفته' : 'Everything You Need to Know' }}</h2>
        </div>
        <div class="faq-wrap">
            @php
            $faqs = app()->isLocale('ar') ? [
                ['ما الفرق بين الدعوة الثابتة والموقع التفاعلي؟','الدعوة الثابتة صورة جميلة تشاركها مباشرة. الموقع التفاعلي رابط كامل مع عد تنازلي وRSVP ومعرض صور وسجل تهاني — كل ده في موقع خاص بمناسبتك.'],
                ['هل أقدر أعدّل التفاصيل بعد النشر؟','نعم! تقدر تعدّل الاسم والتاريخ والمكان والصور وأي تفاصيل في أي وقت من لوحة التحكم.'],
                ['كيف يصل الضيوف للدعوة؟','بعد إنشاء الدعوة، بتاخد رابط خاص تشاركه على واتساب أو انستجرام — بنقرة واحدة.'],
                ['هل يمكن استخدامه لمناسبات غير الزفاف؟','بالتأكيد! فرحنا يدعم الزفاف وعيد الميلاد والخطوبة وحفل التخرج وغيرها كثير.'],
                ['هل هناك رسوم مخفية؟','لا على الإطلاق. الباقة المجانية مجانية للأبد، والباقة المدفوعة دفعة واحدة بدون اشتراكات شهرية.'],
            ] : [
                ['What\'s the difference between static and interactive?','A static invitation is a beautiful image you share directly. An interactive site includes countdown, RSVP, photo gallery, and guest book — all in a dedicated URL for your event.'],
                ['Can I edit details after publishing?','Yes! You can edit names, dates, venue, photos, and any detail anytime from your dashboard.'],
                ['How do guests access the invitation?','After creating, you get a private link to share on WhatsApp, Instagram, or any platform — one tap.'],
                ['Can I use it for non-wedding events?','Absolutely! Farahna supports weddings, birthdays, engagements, graduations, and many more.'],
                ['Are there hidden fees?','None. The free plan is free forever; paid plans are one-time payments with no surprise subscriptions.'],
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

{{-- ── CTA ── --}}
<section class="cta-section">
    <div class="cta-inner">
        <h2 class="cta-title">
            @if(app()->isLocale('ar'))ابدأ رحلتك <em>اليوم</em> ♥
            @else Start Your <em>Journey</em> Today ♥@endif
        </h2>
        <p class="cta-desc">{{ app()->isLocale('ar') ? 'أنشئ دعوتك الأولى مجاناً — لا حاجة لبطاقة ائتمان' : 'Create your first invitation for free — no credit card needed' }}</p>
        <div class="cta-btns">
            @auth
            <a href="{{ route('customer.events.create') }}" class="cta-btn-main">{{ app()->isLocale('ar') ? 'ابدأ إنشاء حدث' : 'Create an Event' }}</a>
            @else
            <a href="{{ route('register') }}" class="cta-btn-main">{{ app()->isLocale('ar') ? 'ابدأ مجاناً الآن' : 'Get Started Free' }}</a>
            @endauth
            <a href="{{ route('templates.index') }}" class="btn btn-ghost btn-lg">{{ app()->isLocale('ar') ? 'استعرض القوالب' : 'Browse Templates' }}</a>
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            <span class="footer-brand-name">{{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }}</span>
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

<script>
(function () {
    // ── Phone countdown (counts to 3 months from now) ──
    var target = new Date('{{ now()->addMonths(3)->toDateString() }} 20:00:00');
    function tick() {
        var diff = target - new Date();
        if (diff <= 0) return;
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var el;
        if ((el = document.getElementById('ph-days'))) el.textContent = d;
        if ((el = document.getElementById('ph-hrs')))  el.textContent = String(h).padStart(2,'0');
        if ((el = document.getElementById('ph-min')))  el.textContent = String(m).padStart(2,'0');
    }
    tick(); setInterval(tick, 60000);

    // ── Particles ──
    var container = document.getElementById('particles');
    if (container) {
        var colors = ['#e0c878','#c9a84c','#f0e8c8','#d4b060','#ede0b0'];
        for (var i = 0; i < 18; i++) {
            var p = document.createElement('div');
            p.className = 'particle';
            var dx = (Math.random() - .5) * 60;
            p.style.cssText = [
                'left:' + (5 + Math.random() * 90) + '%',
                'bottom:' + (Math.random() * 30) + '%',
                'background:' + colors[Math.floor(Math.random() * colors.length)],
                'width:' + (2 + Math.random() * 3) + 'px',
                'height:' + (2 + Math.random() * 3) + 'px',
                'animation-delay:' + (Math.random() * 5) + 's',
                'animation-duration:' + (4 + Math.random() * 4) + 's',
                '--dx:' + dx + 'px',
            ].join(';');
            container.appendChild(p);
        }
    }
})();
</script>
</body>
</html>
