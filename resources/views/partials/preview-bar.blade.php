{{--
  Unified Preview Bar — used by all website templates
  Each template defines in its :root { --pb-accent: #hex; --pb-btn-text: #hex; }
  Variables available: $template (optional), $event
  Hidden automatically when $isFrame = true (phone mockup mode)
--}}
@if(!($isFrame ?? false))
@php
  $tpl     = $template ?? ($event->relationLoaded('template') ? $event->template : null);
  $tplName = $tpl?->name ?? 'معاينة';
  $planLbl = $tpl?->plan?->name ?? '';
  $typeStr = ($tpl && method_exists($tpl,'isWebsite') && $tpl->isWebsite()) ? 'موقع تفاعلي' : 'ثابت';
@endphp
<style>
.__pb {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 9999;
    height: 58px;
    background: #0c0c14;
    border-bottom: 1px solid rgba(255,255,255,.07);
    padding: 0 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    direction: rtl;
    box-shadow: 0 2px 30px rgba(0,0,0,.7);
    font-family: 'Tajawal', sans-serif;
}
.__pb a { text-decoration: none; }

/* Back button */
.__pb .pb-back {
    display: flex; align-items: center; gap: 5px;
    padding: 6px 13px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 7px;
    color: rgba(255,255,255,.65);
    font-size: 13px; font-weight: 500;
    white-space: nowrap;
    transition: all .2s;
    background: transparent;
    cursor: pointer;
}
.__pb .pb-back:hover { border-color: rgba(255,255,255,.4); color: #fff; background: rgba(255,255,255,.05); }
.__pb .pb-back svg { width:14px; height:14px; }

/* Live badge */
.__pb .pb-live {
    display: flex; align-items: center; gap: 6px;
    padding: 4px 10px;
    background: rgba(34,197,94,.1);
    border: 1px solid rgba(34,197,94,.25);
    border-radius: 999px;
    font-size: 12px; color: #4ade80;
    white-space: nowrap;
    flex-shrink: 0;
}
.__pb .pb-live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 6px #22c55e;
    animation: pb-blink 2s ease-in-out infinite;
}
@keyframes pb-blink { 0%,100%{opacity:1} 50%{opacity:.35} }

/* Template info */
.__pb .pb-info { display:flex; flex-direction:column; gap:1px; overflow:hidden; }
.__pb .pb-name { font-size:14px; font-weight:700; color:#fff; white-space:nowrap; line-height:1.2; }
.__pb .pb-meta { font-size:11px; color:rgba(255,255,255,.38); white-space:nowrap; }
.__pb .pb-meta span { color: var(--pb-accent, #a855f7); }

/* Spacer */
.__pb .pb-spacer { flex: 1; }

/* Secondary action (e.g. change template) */
.__pb .pb-outline {
    padding: 7px 14px;
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 7px;
    color: rgba(255,255,255,.6);
    font-size: 13px; font-weight: 500;
    white-space: nowrap;
    transition: all .2s;
    background: transparent;
}
.__pb .pb-outline:hover { border-color: rgba(255,255,255,.4); color: #fff; }

/* Primary CTA */
.__pb .pb-cta {
    padding: 8px 18px;
    border-radius: 7px;
    background: var(--pb-accent, #a855f7);
    color: var(--pb-btn-text, #fff);
    font-size: 13px; font-weight: 700;
    white-space: nowrap;
    border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(0,0,0,.4);
    transition: all .2s;
    display: inline-flex; align-items: center; gap: 5px;
}
.__pb .pb-cta:hover { filter: brightness(1.15); transform: translateY(-1px); }
.__pb .pb-cta svg { width:14px; height:14px; }

/* Separator */
.__pb .pb-sep { width:1px; height:26px; background:rgba(255,255,255,.1); flex-shrink:0; }
</style>

<div class="__pb">
    {{-- Back --}}
    <a href="{{ route('templates.index') }}" class="pb-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        رجوع
    </a>

    {{-- Live badge --}}
    <div class="pb-live">
        <div class="pb-live-dot"></div>
        معاينة حية
    </div>

    <div class="pb-sep"></div>

    {{-- Template info --}}
    <div class="pb-info">
        <div class="pb-name">{{ $tplName }}</div>
        <div class="pb-meta">
            @if($planLbl)<span>{{ $planLbl }}</span> · @endif{{ $typeStr }}
        </div>
    </div>

    <div class="pb-spacer"></div>

    @auth
        {{-- Logged in: change + customize --}}
        <a href="{{ route('templates.index') }}" class="pb-outline">تغيير القالب</a>
        <a href="{{ route('customer.dashboard') }}" class="pb-cta">
            تخصيص
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        </a>
    @else
        {{-- Guest: CTA to register --}}
        <a href="{{ route('register') }}" class="pb-cta">
            ابدأ مجاناً
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
        </a>
    @endauth
</div>
<div style="height:58px"></div>
@endif
