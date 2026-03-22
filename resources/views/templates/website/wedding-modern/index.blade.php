{{--
  Wedding Modern — "Gold Noir" Edition
  Dark cinematic · Gold shimmer names · GSAP envelope · ScrollTrigger
--}}
@php
  $ev        = $event;
  $isFrame   = $isFrame   ?? false;
  $isPreview = $isPreview ?? false;
  $isAr      = app()->isLocale('ar');
  $groom     = $ev->groom_name    ?? ($isAr ? 'أحمد'   : 'James');
  $bride     = $ev->bride_name    ?? ($isAr ? 'سارة'   : 'Emily');
  $evDate    = $ev->event_date instanceof \Carbon\Carbon
               ? $ev->event_date
               : \Carbon\Carbon::parse($ev->event_date ?? now()->addMonths(3));
  $venue     = $ev->venue_name    ?? ($isAr ? 'قاعة الأميرة – فندق الشيراتون' : 'The Grand Ballroom – Sheraton Hotel');
  $addr      = $ev->venue_address ?? ($isAr ? 'القاهرة، مصر الجديدة' : 'Cairo, Egypt');
  $mapLink   = $ev->venue_map_link ?? '#';
  $evTime    = $ev->event_time    ?? '20:00';
  $wishes    = $ev->approvedWishes ?? collect();
  $gallery   = $ev->gallery        ?? collect();
  $hashtag   = $groom . '_و_' . $bride;
  $mono      = mb_substr($groom,0,1) . '&' . mb_substr($bride,0,1);
  $cd        = is_array($ev->custom_data)
               ? $ev->custom_data
               : (json_decode($ev->custom_data ?? '{}', true) ?? []);
  $dressCode        = $cd['dress_code'] ?? ($isAr ? 'أنيق رسمي – ألوان فاتحة' : 'Formal Elegant – Light Colors');
  $shownWishes      = $wishes->take(3);
  $initialMaxWishId = $wishes->max('id') ?? 0;
  $initialMinWishId = $shownWishes->min('id') ?? 0;
  $totalWishes      = $wishes->count();
@endphp
<!DOCTYPE html>
<html lang="{{ $isAr ? 'ar' : 'en' }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $groom }} &amp; {{ $bride }}</title>
@include('partials.og-meta')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Cinzel:wght@400;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Tajawal:wght@300;400;500;700&family=Amiri:ital@0;1&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

<style>
/* ── Reset ─────────────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},sans-serif;
  background:#07050f;color:#e8dfc8;overflow-x:hidden;
}
img{max-width:100%;display:block}
a{text-decoration:none;color:inherit}
button{cursor:pointer;border:none;background:none;font-family:inherit}

/* ── CSS Vars ───────────────────────────────────────────────── */
:root{
  --gold:#c9a84c;--gold-l:#f0d98a;--gold-d:#8a6520;
  --navy:#07050f;--navy-2:#0d0a1a;
  --cream:#f7f3e8;--cream-2:#fdfaf3;
  --dark-text:#1a1208;--muted:#7a6c52;
  --border-g:rgba(201,168,76,.22);
  --pb-accent:#c9a84c;--pb-btn-text:#07050f;
}

/* ════════════════ ENVELOPE SCREEN ════════════════ */
#envScreen{
  position:fixed;inset:0;z-index:9000;
  background:radial-gradient(ellipse 120% 80% at 50% 30%,#1c1335 0%,#07050f 65%);
  display:flex;align-items:center;justify-content:center;
  overflow:hidden;cursor:pointer;
}
/* Ambient top glow */
#envScreen::before{
  content:'';position:absolute;top:-15%;left:50%;transform:translateX(-50%);
  width:800px;height:500px;
  background:radial-gradient(ellipse,rgba(201,168,76,.12) 0%,transparent 70%);
  pointer-events:none;
}
/* Particles */
.ep{position:absolute;border-radius:50%;pointer-events:none;}
@@keyframes epFloat{
  0%{transform:translateY(0) rotate(0deg);opacity:0}
  15%{opacity:1}85%{opacity:.5}
  100%{transform:translateY(-105vh) rotate(400deg);opacity:0}
}
/* Envelope wrapper */
.env-wrap{
  position:relative;
  width:min(460px,90vw);
  display:flex;flex-direction:column;align-items:center;gap:24px;
}
/* Letter peeking from behind */
#envLetter{
  position:absolute;
  top:0;left:50%;transform:translate(-50%,-14px);
  width:86%;
  background:linear-gradient(170deg,#fffef8 0%,#f8f0d8 100%);
  border:1px solid rgba(201,168,76,.35);
  border-radius:3px 3px 0 0;
  padding:30px 22px 22px;
  text-align:center;
  z-index:0;
  box-shadow:0 10px 50px rgba(0,0,0,.6);
  will-change:transform;
}
#envLetter .el-mono{
  font-family:'Great Vibes',cursive;
  font-size:clamp(3rem,11vw,5.5rem);
  color:#7a5a1e;line-height:1;
}
#envLetter .el-names{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(.85rem,2.2vw,1rem);
  letter-spacing:.15em;color:#5a4225;
  margin-top:6px;text-transform:uppercase;
}
#envLetter .el-date{
  font-family:'Cormorant Garamond',serif;
  font-size:.85rem;color:#9a8060;margin-top:10px;font-style:italic;
}
/* Envelope body */
.env-body{
  position:relative;z-index:2;
  width:100%;
  background:linear-gradient(165deg,#1d1535 0%,#110d24 100%);
  border:1px solid rgba(201,168,76,.28);
  border-radius:5px;
  box-shadow:0 24px 90px rgba(0,0,0,.85),inset 0 1px 0 rgba(201,168,76,.18);
  overflow:hidden;
  aspect-ratio:1.42;
  min-height:210px;
}
/* Inside shadow (envelope depth) */
.env-body::after{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 70% 50% at 50% 110%,rgba(0,0,0,.5),transparent);
  pointer-events:none;z-index:1;
}
/* Bottom V fold */
.env-fold-bot{
  position:absolute;bottom:0;left:0;width:100%;height:52%;
  background:linear-gradient(180deg,#17122e 0%,#0f0c1e 100%);
  clip-path:polygon(0 55%,50% 0,100% 55%,100% 100%,0 100%);
}
/* Side folds */
.env-fold-l{
  position:absolute;bottom:0;left:0;width:50%;height:100%;
  background:linear-gradient(135deg,rgba(255,255,255,.03),transparent);
  clip-path:polygon(0 0,100% 45%,0 100%);
}
.env-fold-r{
  position:absolute;bottom:0;right:0;width:50%;height:100%;
  background:linear-gradient(225deg,rgba(255,255,255,.02),transparent);
  clip-path:polygon(0 45%,100% 0,100% 100%);
}
/* Gold edge lines */
.env-edge-t{position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.5),transparent);}
.env-edge-l{position:absolute;top:0;bottom:0;left:0;width:1px;background:linear-gradient(180deg,rgba(201,168,76,.4),rgba(201,168,76,.1),rgba(201,168,76,.3));}
.env-edge-r{position:absolute;top:0;bottom:0;right:0;width:1px;background:linear-gradient(180deg,rgba(201,168,76,.4),rgba(201,168,76,.1),rgba(201,168,76,.3));}
.env-edge-b{position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.3),transparent);}
/* Flap */
#envFlap{
  position:absolute;top:0;left:0;width:100%;height:100%;z-index:3;
  clip-path:polygon(0 0,100% 0,50% 54%);
  background:linear-gradient(185deg,#231940 0%,#1a1132 55%,#130c25 100%);
  will-change:clip-path,opacity;
}
#envFlap::before{
  content:'';position:absolute;bottom:3px;left:10%;right:10%;height:1px;
  background:linear-gradient(90deg,transparent,rgba(201,168,76,.45),transparent);
}
/* Wax seal */
#envSeal{
  position:absolute;top:50%;left:50%;
  transform:translate(-50%,-50%);
  width:68px;height:68px;z-index:5;
  will-change:transform,opacity;
}
.seal-outer{
  width:100%;height:100%;border-radius:50%;
  background:conic-gradient(#c9a84c 0deg,#7a5a1e 90deg,#e8c96a 180deg,#7a5a1e 270deg,#c9a84c 360deg);
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 22px rgba(201,168,76,.55),0 0 55px rgba(201,168,76,.18),inset 0 0 12px rgba(0,0,0,.45);
}
.seal-inner{
  width:56px;height:56px;border-radius:50%;
  background:conic-gradient(#b89240 0deg,#6a4a10 80deg,#d4a83c 160deg,#6a4a10 240deg,#b89240 360deg);
  display:flex;align-items:center;justify-content:center;
  font-family:'Great Vibes',cursive;
  font-size:1.9rem;color:rgba(255,255,255,.85);
  text-shadow:0 1px 3px rgba(0,0,0,.4);
}
/* Hint */
#envHint{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.9rem' : '.72rem' }};
  letter-spacing:{{ $isAr ? '.06em' : '.25em' }};
  font-weight:{{ $isAr ? '300' : '400' }};
  color:rgba(201,168,76,.6);
  text-align:center;
  text-transform:{{ $isAr ? 'none' : 'uppercase' }};
}
@@keyframes hintPulse{0%,100%{opacity:.6;transform:translateY(0)}50%{opacity:1;transform:translateY(-3px)}}
#envHint{animation:hintPulse 2.8s ease-in-out infinite}

/* ════════════════ FLASH OVERLAY ════════════════ */
#flashOverlay{
  position:fixed;inset:0;z-index:8999;
  background:#fff;opacity:0;pointer-events:none;
}

/* ════════════════ INVITATION ════════════════ */
#invitation{display:none}

/* ════════════════ HERO ════════════════ */
#hero{
  position:relative;min-height:100svh;
  background:#07050f;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  overflow:hidden;
}
/* Grid overlay */
#hero::before{
  content:'';position:absolute;inset:0;
  background-image:
    linear-gradient(rgba(201,168,76,.035) 1px,transparent 1px),
    linear-gradient(90deg,rgba(201,168,76,.035) 1px,transparent 1px);
  background-size:64px 64px;
  mask-image:radial-gradient(ellipse 85% 85% at 50% 50%,black 30%,transparent 100%);
  pointer-events:none;
}
/* Floating orbs */
.orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;will-change:transform;transform:translateZ(0);}
.orb-1{width:480px;height:480px;background:rgba(201,168,76,.06);top:-10%;left:-15%}
.orb-2{width:380px;height:380px;background:rgba(100,60,170,.065);bottom:-6%;right:-10%}
.orb-3{width:260px;height:260px;background:rgba(201,168,76,.04);top:40%;right:4%}
/* Animated border frame */
.hero-bdr{position:absolute;pointer-events:none;}
.hero-bdr.top,.hero-bdr.bot{
  left:5%;right:5%;height:1px;
  background:linear-gradient(90deg,transparent,rgba(201,168,76,.6),transparent);
  transform-origin:left center;transform:scaleX(0);
}
.hero-bdr.top{top:5%}
.hero-bdr.bot{bottom:5%;background:linear-gradient(90deg,transparent,rgba(201,168,76,.35),transparent)}
.hero-bdr.left,.hero-bdr.right{
  top:5%;bottom:5%;width:1px;
  background:linear-gradient(180deg,transparent,rgba(201,168,76,.45),transparent);
  transform-origin:top center;transform:scaleY(0);
}
.hero-bdr.left{left:5%}
.hero-bdr.right{right:5%}
/* Corner SVGs */
.hero-corner{position:absolute;width:26px;height:26px;opacity:0;}
.hero-corner.tl{top:calc(5% - 1px);left:calc(5% - 1px)}
.hero-corner.tr{top:calc(5% - 1px);right:calc(5% - 1px)}
.hero-corner.bl{bottom:calc(5% - 1px);left:calc(5% - 1px)}
.hero-corner.br{bottom:calc(5% - 1px);right:calc(5% - 1px)}
/* Floating petals */
.petal{position:absolute;border-radius:60% 0 60% 0;pointer-events:none;}
@@keyframes petalRise{
  0%{transform:translateY(0) rotate(0deg) scale(1);opacity:0}
  12%{opacity:.8}88%{opacity:.3}
  100%{transform:translateY(-100vh) rotate(720deg) scale(.5);opacity:0}
}
/* Hero content */
.hero-inner{
  position:relative;z-index:2;
  text-align:center;padding:2rem 1.5rem 6rem;
  opacity:0;will-change:opacity,transform;
}
.hero-label{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.82rem' : '.68rem' }};
  letter-spacing:{{ $isAr ? '.12em' : '.32em' }};
  font-weight:{{ $isAr ? '300' : '400' }};
  color:rgba(201,168,76,.6);
  margin-bottom:1.5rem;
  text-transform:{{ $isAr ? 'none' : 'uppercase' }};
}
.hero-name{
  display:block;
  font-family:'Alex Brush',cursive;
  font-size:clamp(4.5rem,14vw,11rem);
  line-height:.95;
  background:linear-gradient(90deg,#7a5a1e 0%,#c9a84c 22%,#f0d98a 45%,#ffe8a8 50%,#f0d98a 55%,#c9a84c 78%,#7a5a1e 100%);
  background-size:300% 100%;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  will-change:background-position;
}
@@keyframes nameShimmer{
  0%{background-position:200% 0}
  100%{background-position:-200% 0}
}
.hero-amp{
  display:block;
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(1.6rem,4.5vw,3rem);
  font-style:italic;font-weight:300;
  color:rgba(201,168,76,.4);
  margin:.25rem 0;line-height:1.1;
}
.hero-divider{
  display:flex;align-items:center;justify-content:center;
  gap:18px;margin:2rem auto 1.8rem;
  width:min(420px,82%);
}
.hdl{flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(201,168,76,.35));}
.hdl:last-child{background:linear-gradient(90deg,rgba(201,168,76,.35),transparent);}
.hdg{
  width:12px;height:12px;flex-shrink:0;
  border:1px solid rgba(201,168,76,.5);
  background:rgba(201,168,76,.1);
  transform:rotate(45deg);
}
.hero-date-line{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '1.05rem' : '.88rem' }};
  letter-spacing:{{ $isAr ? '.1em' : '.22em' }};
  color:rgba(240,217,138,.8);
  margin-bottom:.6rem;
}
.hero-venue-line{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.88rem' : '1rem' }};
  font-style:italic;
  color:rgba(232,223,200,.4);
}
/* Scroll indicator */
.hero-scroll{
  position:absolute;bottom:2.2rem;left:50%;transform:translateX(-50%);
  display:flex;flex-direction:column;align-items:center;gap:7px;
  opacity:0;pointer-events:none;
}
.hs-label{
  font-family:'Cinzel',serif;font-size:.6rem;
  letter-spacing:.3em;color:rgba(201,168,76,.45);text-transform:uppercase;
}
.hs-line{width:1px;height:36px;background:linear-gradient(180deg,rgba(201,168,76,.5),transparent);}
@@keyframes scrollBounce{0%,100%{opacity:.5;transform:translateY(0)}50%{opacity:1;transform:translateY(7px)}}
.hero-scroll{animation:scrollBounce 2.4s ease-in-out infinite}

/* ════════════════ QUOTE ════════════════ */
#quote{
  background:linear-gradient(180deg,#0d0a1a 0%,#07050f 100%);
  padding:6rem 1.5rem;text-align:center;position:relative;overflow:hidden;
}
#quote::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 55% 55% at 50% 50%,rgba(201,168,76,.055),transparent);
  pointer-events:none;
}
.q-orn{
  font-family:'Amiri',serif;font-size:6rem;
  color:rgba(201,168,76,.1);line-height:1;margin-bottom:-.5rem;
  position:relative;z-index:1;display:block;
}
.q-text{
  font-family:{{ $isAr ? "'Amiri'" : "'Cormorant Garamond'" }},serif;
  font-size:clamp(1.15rem,3.2vw,1.7rem);
  font-style:italic;line-height:1.8;
  color:rgba(240,217,138,.82);
  max-width:700px;margin:0.5rem auto;
  position:relative;z-index:1;
}
.q-src{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.7rem;letter-spacing:.2em;
  color:rgba(201,168,76,.4);margin-top:1.4rem;
  text-transform:{{ $isAr ? 'none' : 'uppercase' }};
  display:block;
}

/* ════════════════ COUNTDOWN ════════════════ */
#countdown{
  background:var(--cream);padding:5.5rem 1.5rem;text-align:center;
  position:relative;
}
#countdown::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,transparent,var(--gold),transparent);
}
.cd-label{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.82rem' : '.7rem' }};
  letter-spacing:{{ $isAr ? '.12em' : '.22em' }};
  text-transform:{{ $isAr ? 'none' : 'uppercase' }};
  color:var(--muted);margin-bottom:3rem;display:block;
}
.cd-grid{
  display:flex;justify-content:center;align-items:center;
  gap:clamp(10px,2.5vw,30px);flex-wrap:wrap;
}
.cd-box{display:flex;flex-direction:column;align-items:center;gap:10px;min-width:78px;}
.cd-num{
  font-family:'Cormorant Garamond',serif;
  font-size:clamp(3.2rem,9vw,5.5rem);
  font-weight:300;line-height:1;color:var(--dark-text);
  position:relative;
}
.cd-num::after{
  content:'';position:absolute;bottom:-6px;left:15%;right:15%;height:1px;
  background:linear-gradient(90deg,transparent,var(--gold-d),transparent);
}
.cd-unit{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);
}
.cd-sep{
  font-family:'Cormorant Garamond',serif;font-size:3.5rem;
  color:rgba(201,168,76,.3);align-self:flex-start;padding-top:.2rem;line-height:1;
}
.cd-past{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:1.3rem;color:var(--gold-d);font-style:italic;
}

/* ════════════════ SECTION HEADINGS ════════════════ */
.sec-head{text-align:center;margin-bottom:3.5rem;}
.sec-sup{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.68rem;letter-spacing:.28em;text-transform:uppercase;
  color:var(--gold-d);display:block;margin-bottom:.8rem;
}
.sec-title{
  font-family:{{ $isAr ? "'Amiri'" : "'Cormorant Garamond'" }},serif;
  font-size:clamp(2rem,5vw,3.2rem);
  color:var(--dark-text);font-style:italic;
  position:relative;display:inline-block;
}
.sec-title::after{
  content:'';display:block;width:55%;height:1px;
  margin:.7rem auto 0;
  background:linear-gradient(90deg,transparent,var(--gold),transparent);
}
.sec-title.light{color:var(--cream-2)}
.sec-title.light::after{background:linear-gradient(90deg,transparent,var(--gold-d),transparent)}
.sec-sup.light{color:rgba(201,168,76,.6)}

/* ════════════════ DETAILS ════════════════ */
#details{background:var(--cream-2);padding:5.5rem 1.5rem;}
.details-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
  gap:1.5rem;max-width:940px;margin:0 auto;
}
.detail-card{
  background:#fff;border:1px solid rgba(201,168,76,.18);
  border-radius:14px;padding:2rem 1.5rem;text-align:center;
  box-shadow:0 4px 28px rgba(18,10,4,.06);
  position:relative;overflow:hidden;
  transition:transform .35s cubic-bezier(.22,.61,.36,1),box-shadow .35s;
}
.detail-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,transparent,var(--gold),transparent);
}
.detail-card:hover{transform:translateY(-6px);box-shadow:0 16px 48px rgba(18,10,4,.12);}
.dc-icon{font-size:2.2rem;margin-bottom:.9rem;display:block;}
.dc-lbl{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.62rem;letter-spacing:.25em;text-transform:uppercase;
  color:var(--gold-d);margin-bottom:.55rem;
}
.dc-val{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '1rem' : '1.15rem' }};font-style:{{ $isAr ? 'normal' : 'italic' }};
  color:var(--dark-text);line-height:1.55;
}
.dc-sub{font-size:.82rem;color:var(--muted);margin-top:.3rem;}
.dc-map{
  display:inline-flex;align-items:center;gap:5px;
  margin-top:1rem;padding:.4rem 1rem;
  border:1px solid rgba(201,168,76,.38);border-radius:999px;
  font-size:.72rem;color:var(--gold-d);
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  letter-spacing:.1em;transition:all .2s;
}
.dc-map:hover{background:var(--gold-d);color:#fff;border-color:transparent;}

/* ════════════════ GALLERY ════════════════ */
#gallery{background:#07050f;padding:5.5rem 1.5rem;}
.g-grid{
  display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
  gap:4px;max-width:1060px;margin:0 auto;
}
.g-item{
  aspect-ratio:1;overflow:hidden;cursor:pointer;position:relative;
  background:#111;
}
.g-item:first-child{grid-column:span 2;grid-row:span 2;}
.g-item img{
  width:100%;height:100%;object-fit:cover;
  transition:transform .6s cubic-bezier(.22,.61,.36,1);
}
.g-item:hover img{transform:scale(1.08);}
.g-item::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(201,168,76,.1),transparent 60%);
  opacity:0;transition:opacity .3s;
}
.g-item:hover::after{opacity:1;}
/* Placeholder */
.g-ph{
  aspect-ratio:1;
  background:rgba(255,255,255,.028);
  border:1px solid rgba(201,168,76,.08);
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;
}
.g-ph:first-child{grid-column:span 2;grid-row:span 2;}
.g-ph-ico{font-size:2rem;opacity:.25;}
.g-ph-txt{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.6rem;letter-spacing:.15em;color:rgba(201,168,76,.25);text-transform:uppercase;
}
/* Lightbox */
#lb{
  position:fixed;inset:0;z-index:9500;
  background:rgba(0,0,0,.96);
  display:none;align-items:center;justify-content:center;
}
#lb.open{display:flex;}
#lb img{max-width:90vw;max-height:86vh;object-fit:contain;}
#lb-close{
  position:absolute;top:1.5rem;right:1.5rem;color:#fff;
  font-size:1.8rem;cursor:pointer;opacity:.6;transition:opacity .2s;line-height:1;
}
#lb-close:hover{opacity:1;}
#lb-prev,#lb-next{
  position:absolute;top:50%;transform:translateY(-50%);
  color:#fff;font-size:2.2rem;cursor:pointer;opacity:.5;
  transition:opacity .2s;padding:1rem;
}
#lb-prev:hover,#lb-next:hover{opacity:1;}
#lb-prev{left:.5rem}#lb-next{right:.5rem}

/* ════════════════ MONOGRAM DIVIDER ════════════════ */
.mono-div{
  background:var(--cream-2);
  padding:3.5rem 1.5rem;text-align:center;
  position:relative;
}
.mono-div::before,.mono-div::after{
  content:'';position:absolute;left:10%;right:10%;height:1px;
  background:linear-gradient(90deg,transparent,rgba(201,168,76,.2),transparent);
}
.mono-div::before{top:50%;transform:translateY(-50%)}
.mono-div::after{display:none}
.mono-circle{
  display:inline-flex;align-items:center;justify-content:center;
  width:96px;height:96px;border-radius:50%;
  border:1px solid rgba(201,168,76,.28);
  background:linear-gradient(135deg,#fff,var(--cream));
  box-shadow:0 6px 24px rgba(18,10,4,.08),0 0 0 8px rgba(201,168,76,.04);
  font-family:'Great Vibes',cursive;
  font-size:2.4rem;color:var(--gold-d);
  position:relative;z-index:1;
}

/* ════════════════ WISHES ════════════════ */
#wishes{background:var(--cream-2);padding:5.5rem 1.5rem;}
/* Comment list */
.wish-list{max-width:620px;margin:0 auto 1.5rem;display:flex;flex-direction:column;}
.wish-item{
  display:flex;align-items:flex-start;gap:.9rem;
  padding:1.1rem 0;
  border-bottom:1px solid rgba(201,168,76,.1);
}
.wish-item:last-child{border-bottom:none;}
.wi-avatar{
  width:40px;height:40px;border-radius:50%;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  font-family:'Cinzel',serif;font-size:.78rem;font-weight:700;
  color:#fff;letter-spacing:.05em;
  background:var(--gold-d);
}
.wi-body{flex:1;min-width:0;}
.wi-name{
  display:block;
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.7rem;letter-spacing:.1em;color:var(--gold-d);
  text-transform:uppercase;margin-bottom:.3rem;font-weight:700;
}
.wi-msg{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.95rem' : '1.05rem' }};
  color:#3d2e1a;line-height:1.7;font-style:italic;margin:0 0 .3rem;
}
.wi-time{font-size:.68rem;color:#b8a88a;}
/* Load more */
.wish-more{text-align:center;margin:0 auto 2.5rem;max-width:620px;}
.wm-btn{
  background:transparent;border:1px solid rgba(201,168,76,.35);
  color:var(--gold-d);
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.72rem;letter-spacing:.08em;
  padding:.55rem 2rem;border-radius:30px;
  cursor:pointer;transition:all .25s;
}
.wm-btn:hover{background:rgba(201,168,76,.08);border-color:var(--gold-d);}
.wm-btn:disabled{opacity:.5;cursor:default;}
/* Slide-in animation */
@@keyframes wishIn{
  from{opacity:0;transform:translateY(-14px);}
  to{opacity:1;transform:translateY(0);}
}
.wish-item--new{animation:wishIn .4s cubic-bezier(.22,.68,0,1.2) both;}
@@keyframes wishInUp{
  from{opacity:0;transform:translateY(14px);}
  to{opacity:1;transform:translateY(0);}
}
.wish-item--old{animation:wishInUp .4s cubic-bezier(.22,.68,0,1.2) both;}
/* Compact on main page */
.wish-list .wish-item{padding:.55rem 0;}
.wish-list .wi-avatar{width:30px;height:30px;font-size:.62rem;}
.wish-list .wi-msg{font-size:.86rem;line-height:1.55;margin-bottom:.2rem;}
.wish-list .wi-name{font-size:.64rem;margin-bottom:.2rem;}
.wish-list .wi-time{font-size:.62rem;}
/* ─ Wish modal ─ */
.wmodal-overlay{
  position:fixed;inset:0;z-index:8500;
  background:rgba(7,5,15,.6);backdrop-filter:blur(6px);
  display:flex;align-items:center;justify-content:center;
  opacity:0;pointer-events:none;
  transition:opacity .3s;
}
.wmodal-overlay.open{opacity:1;pointer-events:all;}
.wmodal-box{
  background:#faf9f4;
  border:1px solid rgba(201,168,76,.2);
  border-radius:18px;
  width:min(580px,94vw);max-height:82vh;
  display:flex;flex-direction:column;
  box-shadow:0 28px 80px rgba(7,5,15,.4);
  transform:translateY(28px) scale(.97);
  transition:transform .38s cubic-bezier(.22,.68,0,1.2);
}
.wmodal-overlay.open .wmodal-box{transform:translateY(0) scale(1);}
.wmodal-head{
  padding:1rem 1.4rem;
  border-bottom:1px solid rgba(201,168,76,.12);
  display:flex;justify-content:space-between;align-items:center;
  flex-shrink:0;
}
.wmodal-title{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '1rem' : '.78rem' }};
  letter-spacing:{{ $isAr ? '0' : '.15em' }};
  color:var(--gold-d);font-weight:700;
}
.wmodal-close{
  background:none;border:none;cursor:pointer;
  width:30px;height:30px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:1rem;color:#b8a88a;
  transition:background .2s,color .2s;
}
.wmodal-close:hover{background:rgba(201,168,76,.12);color:var(--gold-d);}
.wmodal-body{overflow-y:auto;padding:.6rem 1.4rem 1.4rem;flex:1;}
.wmodal-body .wish-list{max-width:100%;margin:0;}
.wmodal-loader{
  text-align:center;padding:1.2rem;
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.7rem;letter-spacing:.08em;color:#b8a88a;
}
.wmodal-empty{
  text-align:center;padding:3rem 1rem;
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:1.1rem;font-style:italic;color:#c5b8a0;
}
/* Wish form */
.wish-form{
  max-width:560px;margin:0 auto;
  background:#fff;border:1px solid rgba(201,168,76,.18);
  border-radius:16px;padding:2.2rem;
  box-shadow:0 6px 30px rgba(18,10,4,.07);
}
.wf-ttl{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cormorant Garamond'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:1.3rem;color:var(--dark-text);margin-bottom:1.4rem;text-align:center;font-style:italic;
}
.wf-in,.wf-ta{
  width:100%;padding:.65rem .95rem;
  border:1.5px solid rgba(201,168,76,.22);border-radius:9px;
  font-family:inherit;font-size:.9rem;background:var(--cream-2);color:var(--dark-text);
  transition:border-color .2s,box-shadow .2s;resize:vertical;margin-bottom:.9rem;
}
.wf-in:focus,.wf-ta:focus{
  outline:none;border-color:var(--gold);
  box-shadow:0 0 0 3px rgba(201,168,76,.1);
}
.wf-btn{
  width:100%;padding:.78rem;border-radius:9px;
  background:var(--dark-text);color:var(--gold-l);
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.78rem;letter-spacing:.18em;text-transform:uppercase;
  transition:all .2s;cursor:pointer;border:none;
}
.wf-btn:hover{background:var(--gold-d);transform:translateY(-2px);}
.wf-msg{text-align:center;font-size:.85rem;margin-top:.8rem;display:none;}
.wf-msg.ok{color:#166534}.wf-msg.err{color:#be123c}

/* ════════════════ HASHTAG ════════════════ */
#hashtag{
  background:linear-gradient(135deg,#0e0b1c 0%,#07050f 100%);
  padding:5rem 1.5rem;text-align:center;position:relative;overflow:hidden;
}
#hashtag::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 55% 70% at 50% 50%,rgba(201,168,76,.045),transparent);
}
.ht-sub{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.68rem;letter-spacing:.28em;text-transform:uppercase;
  color:rgba(201,168,76,.45);display:block;margin-bottom:1.2rem;
}
.ht-tag{
  font-family:'Great Vibes',cursive;
  font-size:clamp(2.2rem,7.5vw,4.5rem);
  background:linear-gradient(90deg,#7a5a1e 0%,#c9a84c 25%,#f0d98a 50%,#c9a84c 75%,#7a5a1e 100%);
  background-size:300% 100%;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  animation:nameShimmer 5s linear infinite;
  position:relative;z-index:1;
}

/* ════════════════ RSVP ════════════════ */
#rsvp{background:var(--cream);padding:5.5rem 1.5rem;}
.rsvp-wrap{max-width:520px;margin:0 auto;}
.rsvp-form{
  background:#fff;border:1px solid rgba(201,168,76,.18);
  border-radius:16px;padding:2.2rem;
  box-shadow:0 6px 30px rgba(18,10,4,.07);
}
.rf-lbl{font-size:.78rem;font-weight:600;color:var(--dark-text);display:block;margin-bottom:.35rem;}
.rf-in,.rf-sel{
  width:100%;padding:.65rem .95rem;
  border:1.5px solid rgba(201,168,76,.22);border-radius:9px;
  font-family:inherit;font-size:.9rem;background:var(--cream-2);color:var(--dark-text);
  transition:border-color .2s,box-shadow .2s;margin-bottom:.9rem;
}
.rf-in:focus,.rf-sel:focus{
  outline:none;border-color:var(--gold);
  box-shadow:0 0 0 3px rgba(201,168,76,.1);
}
.rf-btn{
  width:100%;padding:.82rem;border-radius:9px;
  background:var(--dark-text);color:var(--gold-l);
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:.78rem;letter-spacing:.18em;text-transform:uppercase;
  transition:all .2s;cursor:pointer;border:none;
}
.rf-btn:hover{background:var(--gold-d);transform:translateY(-2px);}
.rf-msg{text-align:center;font-size:.85rem;margin-top:.8rem;display:none;}
.rf-msg.ok{color:#166534}.rf-msg.err{color:#be123c}

/* ════════════════ FOOTER ════════════════ */
#footer{
  background:#07050f;
  border-top:1px solid rgba(201,168,76,.08);
  padding:3.5rem 1.5rem;text-align:center;
}
.ft-mono{font-family:'Great Vibes',cursive;font-size:3.2rem;color:rgba(201,168,76,.28);margin-bottom:.5rem;}
.ft-names{
  font-family:{{ $isAr ? "'Tajawal'" : "'Cinzel'" }},{{ $isAr ? 'sans-serif' : 'serif' }};
  font-size:{{ $isAr ? '.78rem' : '.65rem' }};
  letter-spacing:{{ $isAr ? '.1em' : '.28em' }};text-transform:uppercase;
  color:rgba(201,168,76,.28);
}
.ft-heart{font-size:1.4rem;margin-top:.5rem;}

/* ════════════════ SCROLL ANIM STATES ════════════════ */
.wm-r{opacity:0;transform:translateY(36px);}
.wm-l{opacity:0;transform:translateX(-36px);}
.wm-s{opacity:0;transform:scale(.9);}

/* ════════════════ LANGUAGE SWITCHER ════════════════ */
.lang-sw{
  position:fixed;bottom:1.5rem;{{ $isAr ? 'left' : 'right' }}:1.2rem;
  z-index:8000;
  display:flex;align-items:center;gap:0;
  background:rgba(13,10,26,.85);
  border:1px solid rgba(201,168,76,.3);
  border-radius:999px;
  overflow:hidden;
  backdrop-filter:blur(10px);
  box-shadow:0 4px 20px rgba(0,0,0,.5);
}
.lang-sw a{
  padding:.42rem .85rem;
  font-family:'Cinzel',serif;font-size:.68rem;letter-spacing:.1em;
  color:rgba(201,168,76,.55);transition:all .2s;
  text-decoration:none;
}
.lang-sw a.active{
  background:rgba(201,168,76,.18);
  color:var(--gold-l);
  font-weight:600;
}
.lang-sw a:hover:not(.active){color:rgba(201,168,76,.85);}
.lang-sw-sep{width:1px;height:16px;background:rgba(201,168,76,.2);flex-shrink:0;}

/* ════════════════ RESPONSIVE ════════════════ */
@@media(max-width:640px){
  .details-grid{grid-template-columns:1fr;}
  .g-item:first-child{grid-column:span 1;grid-row:span 1;}
  .cd-sep{display:none;}
  .cd-grid{gap:8px;}
  .cd-num{font-size:clamp(2.2rem,10vw,3.5rem);}
  .wish-grid{grid-template-columns:1fr;}
  .hero-bdr,.hero-corner{display:none;}
  .hero-inner{padding:1.5rem 1rem 5rem;}
  .hero-label{font-size:.75rem;letter-spacing:.08em;}
  .hero-date-line{font-size:.9rem;letter-spacing:.06em;}
  .hero-venue-line{font-size:.85rem;}
  .hero-divider{margin:1.4rem auto 1.2rem;}
  #quote{padding:3.5rem 1.2rem;}
  .q-text{font-size:1.05rem;}
  .wish-form{padding:1.5rem 1rem;}
  .rsvp-form,.rsvp-wrap .rsvp-form{padding:1.5rem 1rem;}
  .sec-title{font-size:1.8rem;}
  .detail-card{padding:1.4rem 1.1rem;}
}
@@media(max-width:420px){
  .hero-name{font-size:clamp(3.5rem,18vw,5rem);}
  .hero-amp{font-size:1.4rem;}
  .cd-box{min-width:55px;}
}
.wrap{max-width:1080px;margin:0 auto;}
</style>
</head>
<body>

{{-- ── Preview bar ── --}}
@include('partials.preview-bar')

{{-- ── Flash overlay ── --}}
<div id="flashOverlay"></div>

{{-- ════════════ ENVELOPE ════════════ --}}
@if(!$isFrame)
<div id="envScreen">
  {{-- Gold floating particles --}}
  @for($i = 0; $i < 18; $i++)
  @php $sz=rand(2,6);$lft=rand(2,98);$dur=rand(7,20);$del=rand(0,12);$op=rand(18,55)/100; @endphp
  <div class="ep" style="left:{{ $lft }}%;bottom:-8px;width:{{ $sz }}px;height:{{ $sz }}px;background:rgba(201,168,76,{{ $op }});animation:epFloat {{ $dur }}s {{ $del }}s linear infinite;transform:translateZ(0);"></div>
  @endfor

  <div class="env-wrap">
    {{-- Letter rising from behind --}}
    <div id="envLetter">
      <span class="el-mono">{{ mb_substr($groom,0,1) }}&thinsp;&amp;&thinsp;{{ mb_substr($bride,0,1) }}</span>
      <div class="el-names">{{ $groom }} &amp; {{ $bride }}</div>
      <div class="el-date">{{ $evDate->translatedFormat($isAr ? 'j F Y' : 'F j, Y') }}</div>
    </div>

    {{-- Envelope body --}}
    <div class="env-body" id="envBody">
      <div class="env-fold-l"></div>
      <div class="env-fold-r"></div>
      <div class="env-fold-bot"></div>
      <div class="env-edge-t"></div>
      <div class="env-edge-l"></div>
      <div class="env-edge-r"></div>
      <div class="env-edge-b"></div>
      <div id="envFlap"></div>
      <div id="envSeal">
        <div class="seal-outer">
          <div class="seal-inner">♥</div>
        </div>
      </div>
    </div>

    <div id="envHint">
      {{ $isAr ? 'انقر لفتح الدعوة' : 'Click to open your invitation' }}
    </div>
  </div>
</div>
@endif

{{-- ════════════ INVITATION ════════════ --}}
<div id="invitation" @if($isFrame) style="display:block;" @endif>

  {{-- ── HERO ── --}}
  <section id="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    {{-- Animated border frame --}}
    <div class="hero-bdr top"></div>
    <div class="hero-bdr bot"></div>
    <div class="hero-bdr left"></div>
    <div class="hero-bdr right"></div>
    <svg class="hero-corner tl" viewBox="0 0 26 26" fill="none"><path d="M1 26V1h25" stroke="#c9a84c" stroke-width="1.2" opacity=".55"/></svg>
    <svg class="hero-corner tr" viewBox="0 0 26 26" fill="none"><path d="M25 26V1H0"  stroke="#c9a84c" stroke-width="1.2" opacity=".55"/></svg>
    <svg class="hero-corner bl" viewBox="0 0 26 26" fill="none"><path d="M1 0v25h25"  stroke="#c9a84c" stroke-width="1.2" opacity=".55"/></svg>
    <svg class="hero-corner br" viewBox="0 0 26 26" fill="none"><path d="M25 0v25H0"  stroke="#c9a84c" stroke-width="1.2" opacity=".55"/></svg>

    {{-- Petals --}}
    @for($i=0;$i<8;$i++)
    @php $s=rand(4,10);$l=rand(2,98);$d=rand(9,24);$dl=rand(0,16); @endphp
    <div class="petal" style="bottom:-6px;left:{{ $l }}%;width:{{ $s }}px;height:{{ $s }}px;background:rgba(201,168,76,{{ rand(25,55)/100 }});animation:petalRise {{ $d }}s {{ $dl }}s ease-in-out infinite;"></div>
    @endfor

    <div class="hero-inner" id="heroInner">
      <div class="hero-label">{{ $isAr ? 'يسعدنا دعوتكم لحضور حفل زفاف' : 'We joyfully invite you to celebrate the wedding of' }}</div>
      <span class="hero-name" style="animation:nameShimmer 7s linear infinite;">{{ $groom }}</span>
      <span class="hero-amp">&amp;</span>
      <span class="hero-name" style="animation:nameShimmer 7s 1.2s linear infinite;">{{ $bride }}</span>
      <div class="hero-divider">
        <div class="hdl"></div>
        <div class="hdg"></div>
        <div class="hdl"></div>
      </div>
      <div class="hero-date-line">{{ $evDate->translatedFormat($isAr ? 'l، j F Y' : 'l, F j, Y') }} &nbsp;·&nbsp; {{ $evTime }}</div>
      <div class="hero-venue-line">{{ $venue }}</div>
    </div>

    <div class="hero-scroll" id="heroScroll">
      <span class="hs-label">{{ $isAr ? 'اسحب' : 'Scroll' }}</span>
      <div class="hs-line"></div>
    </div>
  </section>

  {{-- ── QUOTE / WELCOME ── --}}
  <section id="quote">
    <span class="q-orn wm-r">♥</span>
    <p class="q-text wm-r">
      @if($isAr)
        يسعدنا أن نشارككم أجمل لحظاتنا في هذا اليوم المميز،
        ونتطلع إلى احتفالنا معاً بذكريات لا تُنسى.
        حضوركم يُضفي على يومنا بهجةً لا توصف.
      @else
        We are overjoyed to share this special day with you
        and look forward to celebrating together and creating
        memories that will last a lifetime. Your presence means the world to us.
      @endif
    </p>
    <span class="q-src wm-r">{{ $isAr ? '— مع أحر التهاني —' : '— With warmest wishes —' }}</span>
  </section>

  {{-- ── COUNTDOWN ── --}}
  <section id="countdown">
    <span class="cd-label">{{ $isAr ? 'العد التنازلي لليوم الكبير' : 'Counting down to the big day' }}</span>
    <div class="cd-grid wm-s" id="cdGrid">
      @if($evDate->isFuture())
        <div class="cd-box"><div class="cd-num" id="cd-d">--</div><div class="cd-unit">{{ $isAr ? 'يوم' : 'Days' }}</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-box"><div class="cd-num" id="cd-h">--</div><div class="cd-unit">{{ $isAr ? 'ساعة' : 'Hours' }}</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-box"><div class="cd-num" id="cd-m">--</div><div class="cd-unit">{{ $isAr ? 'دقيقة' : 'Mins' }}</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-box"><div class="cd-num" id="cd-s">--</div><div class="cd-unit">{{ $isAr ? 'ثانية' : 'Secs' }}</div></div>
      @else
        <div class="cd-past">{{ $isAr ? '🎉 ألف مبروك! حفل الفرح مضى بالسعادة والهناء' : '🎉 Congratulations! The celebration has passed.' }}</div>
      @endif
    </div>
  </section>

  {{-- ── DETAILS ── --}}
  <section id="details">
    <div class="sec-head">
      <span class="sec-sup">{{ $isAr ? 'تفاصيل المناسبة' : 'Event Details' }}</span>
      <h2 class="sec-title wm-r">{{ $isAr ? 'موعدنا الكبير' : 'The Details' }}</h2>
    </div>
    <div class="details-grid wrap">
      <div class="detail-card wm-r">
        <span class="dc-icon">📅</span>
        <div class="dc-lbl">{{ $isAr ? 'التاريخ والوقت' : 'Date & Time' }}</div>
        <div class="dc-val">{{ $evDate->translatedFormat($isAr ? 'j F Y' : 'F j, Y') }}</div>
        <div class="dc-sub">{{ $evTime }}</div>
      </div>
      <div class="detail-card wm-r">
        <span class="dc-icon">📍</span>
        <div class="dc-lbl">{{ $isAr ? 'مكان الحفل' : 'Venue' }}</div>
        <div class="dc-val">{{ $venue }}</div>
        <div class="dc-sub">{{ $addr }}</div>
        @if($mapLink && $mapLink !== '#')
        <a href="{{ $mapLink }}" target="_blank" class="dc-map">
          🗺️ {{ $isAr ? 'افتح الخريطة' : 'Open Map' }}
        </a>
        @endif
      </div>
      <div class="detail-card wm-r">
        <span class="dc-icon">👗</span>
        <div class="dc-lbl">{{ $isAr ? 'كود اللبس' : 'Dress Code' }}</div>
        <div class="dc-val">{{ $dressCode }}</div>
      </div>
    </div>
  </section>

  {{-- ── GALLERY — hidden when no photos ── --}}
  @if($gallery->isNotEmpty())
  <section id="gallery">
    <div class="sec-head">
      <span class="sec-sup light">{{ $isAr ? 'ذكرياتنا' : 'Our Memories' }}</span>
      <h2 class="sec-title light wm-r">{{ $isAr ? 'معرض الصور' : 'Gallery' }}</h2>
    </div>
    <div class="g-grid wrap">
      @foreach($gallery as $i => $photo)
      <div class="g-item wm-r" onclick="lbOpen({{ $i }})">
        <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $isAr ? 'صورة' : 'Photo' }} {{ $i+1 }}" loading="lazy">
      </div>
      @endforeach
    </div>
    <script>var galImgs=[
      @foreach($gallery as $photo)"{{ Storage::url($photo->image_path) }}",@endforeach
    ];</script>
  </section>
  @else
  <script>var galImgs=[];</script>
  @endif

  {{-- Lightbox --}}
  <div id="lb">
    <span id="lb-close" onclick="lbClose()">✕</span>
    <span id="lb-prev" onclick="lbNav(-1)">&#8249;</span>
    <img id="lb-img" src="" alt="">
    <span id="lb-next" onclick="lbNav(1)">&#8250;</span>
  </div>

  {{-- ── MONOGRAM DIVIDER ── --}}
  <div class="mono-div">
    <div class="mono-circle wm-s">{!! $mono !!}</div>
  </div>

  {{-- ── WISHES ── --}}
  <section id="wishes">
    <div class="sec-head">
      <span class="sec-sup">{{ $isAr ? 'كلمات تُسعدنا' : 'Kind Words' }}</span>
      <h2 class="sec-title wm-r">{{ $isAr ? 'أجمل التهاني' : 'Heartfelt Wishes' }}</h2>
    </div>
    <div class="wish-list" id="wish-list">
      @foreach($shownWishes as $w)
      @php
        $wi = mb_strtoupper(collect(preg_split('/\s+/', $w->guest_name))->take(2)->map(fn($p)=>mb_substr($p,0,1))->join(''));
      @endphp
      <div class="wish-item wm-r" data-wish-id="{{ $w->id }}">
        <div class="wi-avatar">{{ $wi ?: '?' }}</div>
        <div class="wi-body">
          <span class="wi-name">{{ $w->guest_name }}</span>
          <p class="wi-msg">{{ $w->message }}</p>
          <span class="wi-time">{{ \Carbon\Carbon::parse($w->created_at)->diffForHumans() }}</span>
        </div>
      </div>
      @endforeach
    </div>

    @if($totalWishes > 3)
    <div class="wish-more" id="wish-more">
      <button class="wm-btn" id="loadMoreBtn">
        💬 {{ $isAr ? 'كل التهاني (' . $totalWishes . ')' : 'All wishes (' . $totalWishes . ')' }}
      </button>
    </div>
    @else
    <div class="wish-more" id="wish-more" style="display:none;"></div>
    @endif

    <div class="wish-form" style="margin-top:2rem;">
      <div class="wf-ttl">{{ $isAr ? 'شاركنا تهانيك ❤️' : 'Leave Your Wishes ❤️' }}</div>
      @if($isPreview)
        <input class="wf-in" type="text" placeholder="{{ $isAr ? 'اسمك الكريم' : 'Your Name' }}" disabled style="opacity:.55;cursor:not-allowed;">
        <textarea class="wf-ta" rows="3" placeholder="{{ $isAr ? 'كلماتك الجميلة...' : 'Your heartfelt message...' }}" disabled style="opacity:.55;cursor:not-allowed;"></textarea>
        <button class="wf-btn" disabled style="opacity:.45;cursor:not-allowed;">{{ $isAr ? 'أرسل تهنئتك' : 'Send Wishes' }}</button>
        <p style="text-align:center;font-size:.78rem;color:#b8a88a;margin-top:.6rem;">{{ $isAr ? '* متاح للضيوف على الدعوة الحقيقية' : '* Available to guests on the real invitation' }}</p>
      @else
        <form id="wishForm">
          @csrf
          <input class="wf-in" type="text" name="guest_name" placeholder="{{ $isAr ? 'اسمك الكريم' : 'Your Name' }}" required>
          <textarea class="wf-ta" name="message" rows="3" placeholder="{{ $isAr ? 'كلماتك الجميلة...' : 'Your heartfelt message...' }}" required></textarea>
          <button type="submit" class="wf-btn">{{ $isAr ? 'أرسل تهنئتك' : 'Send Wishes' }}</button>
        </form>
        <div class="wf-msg" id="wf-msg"></div>
      @endif
    </div>
  </section>

  {{-- ── HASHTAG ── --}}
  <section id="hashtag">
    <span class="ht-sub">{{ $isAr ? 'شارك لحظاتك معنا' : 'Share Your Moments With Us' }}</span>
    <div class="ht-tag">#{{ $hashtag }}</div>
  </section>

  {{-- ── RSVP ── --}}
  <section id="rsvp">
    <div class="sec-head">
      <span class="sec-sup">{{ $isAr ? 'تأكيد الحضور' : 'Attendance' }}</span>
      <h2 class="sec-title wm-r">{{ $isAr ? 'هل ستحضر معنا؟' : 'Will You Join Us?' }}</h2>
    </div>
    <div class="rsvp-wrap">
      @if($isPreview)
        <div class="rsvp-form wm-s" style="opacity:.7;">
          <label class="rf-lbl">{{ $isAr ? 'اسمك الكريم' : 'Your Name' }}</label>
          <input class="rf-in" type="text" placeholder="{{ $isAr ? 'اكتب اسمك' : 'Enter your name' }}" disabled style="cursor:not-allowed;">
          <label class="rf-lbl">{{ $isAr ? 'هل ستحضر؟' : 'Attending?' }}</label>
          <select class="rf-sel" disabled style="cursor:not-allowed;">
            <option>{{ $isAr ? '✅ سأحضر بإذن الله' : '✅ Yes, I will attend' }}</option>
          </select>
          <label class="rf-lbl">{{ $isAr ? 'عدد الأفراد المرافقين' : 'Number of Guests' }}</label>
          <input class="rf-in" type="number" value="1" disabled style="cursor:not-allowed;">
          <button class="rf-btn" disabled style="cursor:not-allowed;">{{ $isAr ? 'تأكيد حضوري' : 'Confirm RSVP' }}</button>
          <p style="text-align:center;font-size:.78rem;color:#b8a88a;margin-top:.6rem;">{{ $isAr ? '* متاح للضيوف على الدعوة الحقيقية' : '* Available to guests on the real invitation' }}</p>
        </div>
      @else
        <form class="rsvp-form wm-s" id="rsvpForm">
          @csrf
          <label class="rf-lbl">{{ $isAr ? 'اسمك الكريم' : 'Your Name' }}</label>
          <input class="rf-in" type="text" name="guest_name" required placeholder="{{ $isAr ? 'اكتب اسمك' : 'Enter your name' }}">
          <label class="rf-lbl">{{ $isAr ? 'هل ستحضر؟' : 'Attending?' }}</label>
          <select class="rf-sel" name="attending">
            <option value="yes">{{ $isAr ? '✅ سأحضر بإذن الله' : '✅ Yes, I will attend' }}</option>
            <option value="no">{{ $isAr ? '❌ آسف، لن أتمكن من الحضور' : '❌ Sorry, I cannot attend' }}</option>
            <option value="maybe">{{ $isAr ? '🤔 ربما' : '🤔 Maybe' }}</option>
          </select>
          <label class="rf-lbl">{{ $isAr ? 'عدد الأفراد المرافقين' : 'Number of Guests' }}</label>
          <input class="rf-in" type="number" name="guests_count" min="0" max="10" value="1">
          <button type="submit" class="rf-btn">{{ $isAr ? 'تأكيد حضوري' : 'Confirm RSVP' }}</button>
          <div class="rf-msg" id="rf-msg"></div>
        </form>
      @endif
    </div>
  </section>

  {{-- ── Language Switcher ── --}}
  <div class="lang-sw" style="{{ $isAr ? 'left' : 'right' }}:1.2rem;">
    @php $currentLang = app()->getLocale(); @endphp
    <a href="?lang=ar" class="{{ $currentLang === 'ar' ? 'active' : '' }}">ع</a>
    <div class="lang-sw-sep"></div>
    <a href="?lang=en" class="{{ $currentLang === 'en' ? 'active' : '' }}">EN</a>
  </div>

  {{-- ── FOOTER ── --}}
  <footer id="footer">
    <div class="ft-mono">{!! $mono !!}</div>
    <div class="ft-names">{{ $groom }} &amp; {{ $bride }}</div>
    <div class="ft-heart">♥</div>
  </footer>

</div>{{-- /invitation --}}

{{-- ── WISH MODAL (must be before the script tag) ── --}}
@if(!$isPreview)
<div class="wmodal-overlay" id="wishModal" role="dialog" aria-modal="true">
  <div class="wmodal-box">
    <div class="wmodal-head">
      <span class="wmodal-title">{{ $isAr ? '💌 كل التهاني' : '💌 All Wishes' }}</span>
      <button class="wmodal-close" id="wishModalClose" aria-label="close">✕</button>
    </div>
    <div class="wmodal-body" id="wishModalBody">
      <div class="wish-list" id="wishModalList"></div>
      <div class="wmodal-loader" id="wishModalLoader">
        {{ $isAr ? 'جاري التحميل...' : 'Loading...' }}
      </div>
    </div>
  </div>
</div>
@endif

<script>
gsap.registerPlugin(ScrollTrigger);

/* ── Lightbox ────────────────────────────────────── */
var lbIdx = 0;
function lbOpen(i){
  if(!galImgs||!galImgs.length)return;
  lbIdx=i;
  document.getElementById('lb-img').src=galImgs[i];
  document.getElementById('lb').classList.add('open');
  document.body.style.overflow='hidden';
}
function lbClose(){
  document.getElementById('lb').classList.remove('open');
  document.body.style.overflow='';
}
function lbNav(dir){
  if(!galImgs||!galImgs.length)return;
  lbIdx=(lbIdx+dir+galImgs.length)%galImgs.length;
  document.getElementById('lb-img').src=galImgs[lbIdx];
}
document.getElementById('lb').addEventListener('click',function(e){if(e.target===this)lbClose();});

/* ── Hero entrance ───────────────────────────────── */
function runHeroIn(){
  var tl=gsap.timeline({defaults:{ease:'power3.out'}});
  tl.to(['.hero-bdr.top','.hero-bdr.bot'],{scaleX:1,duration:1.5,ease:'power2.inOut',stagger:.12});
  tl.to(['.hero-bdr.left','.hero-bdr.right'],{scaleY:1,duration:1.1,ease:'power2.inOut',stagger:.08},'-=.9');
  tl.to('.hero-corner',{opacity:1,duration:.55,stagger:.07},'-=.5');
  tl.to('#heroInner',{opacity:1,y:0,duration:1,ease:'power3.out'},'-=.6');
  tl.to('#heroScroll',{opacity:1,duration:.8},'-=.3');
}

/* ── Scroll animations ───────────────────────────── */
function initScrollAnims(){
  gsap.utils.toArray('.wm-r').forEach(function(el){
    gsap.to(el,{opacity:1,y:0,duration:.9,ease:'power3.out',
      scrollTrigger:{trigger:el,start:'top 88%',once:true}});
  });
  gsap.utils.toArray('.wm-l').forEach(function(el){
    gsap.to(el,{opacity:1,x:0,duration:.9,ease:'power3.out',
      scrollTrigger:{trigger:el,start:'top 88%',once:true}});
  });
  gsap.utils.toArray('.wm-s').forEach(function(el){
    gsap.to(el,{opacity:1,scale:1,duration:.9,ease:'back.out(1.5)',
      scrollTrigger:{trigger:el,start:'top 88%',once:true}});
  });
  /* Orb parallax */
  gsap.to('.orb-1',{y:-90,ease:'none',
    scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:1.8}});
  gsap.to('.orb-2',{y:-60,ease:'none',
    scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:2.5}});
}

/* ── Countdown ───────────────────────────────────── */
function initCountdown(){
  var target=new Date('{{ $evDate->toIso8601String() }}');
  var dEl=document.getElementById('cd-d'),hEl=document.getElementById('cd-h'),
      mEl=document.getElementById('cd-m'),sEl=document.getElementById('cd-s');
  if(!dEl)return;
  function tick(){
    var now=new Date(),diff=target-now;
    if(diff<=0){clearInterval(timer);return;}
    var d=Math.floor(diff/86400000),
        h=Math.floor((diff%86400000)/3600000),
        m=Math.floor((diff%3600000)/60000),
        s=Math.floor((diff%60000)/1000);
    dEl.textContent=String(d).padStart(2,'0');
    hEl.textContent=String(h).padStart(2,'0');
    mEl.textContent=String(m).padStart(2,'0');
    sEl.textContent=String(s).padStart(2,'0');
  }
  tick();var timer=setInterval(tick,1000);
}

/* ── Envelope open ───────────────────────────────── */
function openEnvelope(screen,overlay,inv){
  var flap  =document.getElementById('envFlap');
  var seal  =document.getElementById('envSeal');
  var hint  =document.getElementById('envHint');
  var letter=document.getElementById('envLetter');
  var tl=gsap.timeline();
  tl.to(hint,  {opacity:0,y:12,duration:.3,ease:'power1.in'});
  tl.to(seal,  {scale:0,rotation:35,opacity:0,duration:.55,ease:'back.in(2.8)'},'-=.05');
  tl.to(flap,  {clipPath:'polygon(0 0,100% 0,50% -130%)',opacity:0,duration:.85,ease:'power2.inOut'},'+=.08');
  tl.to(letter,{y:'-80%',duration:1,ease:'power2.out'},'-=.5');
  tl.to(screen,{opacity:0,y:'-5%',duration:.75,ease:'power2.inOut'},'+=.2');
  tl.to(overlay,{opacity:1,duration:.28,ease:'power1.in',
    onComplete:function(){screen.style.display='none';inv.style.display='block';}},'-=.18');
  tl.to(overlay,{opacity:0,duration:.55,ease:'power2.out',
    onComplete:function(){runHeroIn();initScrollAnims();initCountdown();}});
}

/* ── Init based on mode ──────────────────────────── */
@if($isFrame)
(function(){
  runHeroIn(); initScrollAnims(); initCountdown();
})();
@elseif($isPreview)
(function(){
  var screen =document.getElementById('envScreen');
  var overlay=document.getElementById('flashOverlay');
  var inv    =document.getElementById('invitation');
  if(!screen){runHeroIn();initScrollAnims();initCountdown();return;}
  screen.style.cursor='pointer';
  screen.addEventListener('click',function(){openEnvelope(screen,overlay,inv);},{once:true});
})();
@else
(function(){
  var screen =document.getElementById('envScreen');
  var overlay=document.getElementById('flashOverlay');
  var inv    =document.getElementById('invitation');
  if(!screen){runHeroIn();initScrollAnims();initCountdown();return;}
  screen.addEventListener('click',function(){openEnvelope(screen,overlay,inv);},{once:true});
})();
@endif

/* ── Wishes: real-time poll + modal ─────────────── */
@if(!$isPreview && isset($event->id))
(function(){
  var isAr    = {{ $isAr ? 'true' : 'false' }};
  var pollUrl = '{{ route("invitation.wishes.latest", $event) }}';
  var list    = document.getElementById('wish-list');
  var moreBtn = document.getElementById('loadMoreBtn');

  /* ── shared helpers ── */
  function esc(s){ var d=document.createElement('div'); d.textContent=s; return d.innerHTML; }
  function initials(name){
    return name.trim().split(/\s+/).slice(0,2).map(function(w){ return w.charAt(0).toUpperCase(); }).join('') || '?';
  }
  function makeItem(w, cls){
    var el = document.createElement('div');
    el.className = 'wish-item' + (isAr?' wm-r':'') + (cls?' '+cls:'');
    el.setAttribute('data-wish-id', w.id);
    el.innerHTML =
      '<div class="wi-avatar">'+esc(initials(w.guest_name))+'</div>'+
      '<div class="wi-body">'+
        '<span class="wi-name">'+esc(w.guest_name)+'</span>'+
        '<p class="wi-msg">'+esc(w.message)+'</p>'+
        '<span class="wi-time">'+esc(w.time_ago)+'</span>'+
      '</div>';
    return el;
  }

  /* ── real-time polling (page list) ── */
  var maxId   = {{ $initialMaxWishId }};
  var seenIds = new Set();
  var polling = false;
  list && list.querySelectorAll('[data-wish-id]').forEach(function(el){
    seenIds.add(+el.getAttribute('data-wish-id'));
  });

  function poll(){
    if(polling || !list) return;
    polling = true;
    fetch(pollUrl+'?after='+maxId, {headers:{'Accept':'application/json'}})
      .then(function(r){ return r.ok ? r.json() : null; })
      .then(function(data){
        if(!data || !data.wishes.length) return;
        data.wishes.forEach(function(w){
          if(seenIds.has(w.id)) return;
          seenIds.add(w.id); if(w.id>maxId) maxId=w.id;
          list.insertBefore(makeItem(w,'wish-item--new'), list.firstChild);
          /* update modal button count */
          if(moreBtn) moreBtn.textContent = '💬 '+(isAr?'كل التهاني':'All wishes')+' ('+seenIds.size+')';
          if(moreBtn && seenIds.size>3) document.getElementById('wish-more').style.display='';
        });
      })
      .catch(function(){})
      .finally(function(){ polling=false; });
  }
  setTimeout(function(){ poll(); setInterval(poll, 2000); }, 1000);

  /* ── Modal ── */
  var modal      = document.getElementById('wishModal');
  var modalList  = document.getElementById('wishModalList');
  var modalLoader= document.getElementById('wishModalLoader');
  if(!modal) return; /* preview mode — no modal */

  var modalMinId    = null;
  var modalLoading  = false;
  var modalDone     = false;

  function openModal(){
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    if(!modalList.querySelector('[data-wish-id]')) loadModalBatch();
  }
  function closeModal(){
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  function loadModalBatch(){
    if(modalLoading || modalDone) return;
    modalLoading = true;
    modalLoader.style.display = '';
    var url = modalMinId ? pollUrl+'?before='+modalMinId+'&limit=15' : pollUrl+'?limit=15';
    fetch(url, {headers:{'Accept':'application/json'}})
      .then(function(r){ return r.ok ? r.json() : null; })
      .then(function(data){
        if(!data || !data.wishes.length){ modalDone=true; modalLoader.style.display='none'; return; }
        data.wishes.forEach(function(w){
          if(!modalMinId || w.id < modalMinId) modalMinId = w.id;
          modalList.appendChild(makeItem(w,'wish-item--old'));
        });
        if(data.wishes.length < 15){ modalDone=true; modalLoader.style.display='none'; }
      })
      .catch(function(){ modalLoader.style.display='none'; })
      .finally(function(){ modalLoading=false; });
  }

  /* infinite scroll inside modal */
  document.getElementById('wishModalBody').addEventListener('scroll', function(){
    var b = this;
    if(b.scrollTop + b.clientHeight >= b.scrollHeight - 120) loadModalBatch();
  });

  /* open / close */
  if(moreBtn) moreBtn.addEventListener('click', openModal);
  document.getElementById('wishModalClose').addEventListener('click', closeModal);
  modal.addEventListener('click', function(e){ if(e.target===modal) closeModal(); });
  document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeModal(); });

  /* ── wish form submit ── */
  var form = document.getElementById('wishForm');
  if(form){
    form.addEventListener('submit',function(e){
      e.preventDefault();
      var btn=form.querySelector('.wf-btn'); btn.disabled=true;
      var msg=document.getElementById('wf-msg');
      fetch('{{ route("invitation.wishes", $event) }}',
        {method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:new FormData(form)})
        .then(function(r){ return r.json(); })
        .then(function(){
          msg.className='wf-msg ok';
          msg.textContent='{{ $isAr ? "شكراً! تم إرسال تهنئتك 💖" : "Thank you! Your wish was sent 💖" }}';
          msg.style.display='block'; form.reset(); btn.disabled=false;
        }).catch(function(){
          msg.className='wf-msg err';
          msg.textContent='{{ $isAr ? "حدث خطأ، حاول مرة أخرى" : "Something went wrong, please try again" }}';
          msg.style.display='block'; btn.disabled=false;
        });
    });
  }
})();
@endif

/* ── RSVP form ───────────────────────────────────── */
@if(!$isPreview && isset($event->id))
(function(){
  var form=document.getElementById('rsvpForm');
  if(!form)return;
  form.addEventListener('submit',function(e){
    e.preventDefault();
    var btn=form.querySelector('.rf-btn');
    btn.disabled=true;
    var msg=document.getElementById('rf-msg');
    fetch('{{ route("invitation.rsvp", $event) }}',
      {method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'},body:new FormData(form)})
      .then(r=>r.json())
      .then(function(){
        msg.className='rf-msg ok';
        msg.textContent='{{ $isAr ? "تم تأكيد حضورك! نراك قريباً 🎉" : "RSVP confirmed! See you soon 🎉" }}';
        msg.style.display='block';form.reset();btn.disabled=false;
      }).catch(function(){
        msg.className='rf-msg err';
        msg.textContent='{{ $isAr ? "حدث خطأ، حاول مرة أخرى" : "Something went wrong, please try again" }}';
        msg.style.display='block';btn.disabled=false;
      });
  });
})();
@endif
</script>


</body>
</html>
