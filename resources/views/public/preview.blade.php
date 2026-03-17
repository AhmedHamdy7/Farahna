<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'معاينة: '.$template->name.' – فرحنا' : 'Preview: '.$template->name.' – Farahna' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bar-h: 60px;
            --bg: #0f0e0d;
            --bar-bg: #1a1917;
            --border: rgba(255,255,255,.08);
            --muted: #78716c;
            --gold: #fde68a;
            --rose: #e11d48;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: {{ app()->isLocale('ar') ? "'Tajawal', sans-serif" : "'Inter', sans-serif" }};
            background: var(--bg);
            color: #fff;
        }

        /* ══════════════════════════════════════
           TOP BAR
        ══════════════════════════════════════ */
        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--bar-h);
            background: var(--bar-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            z-index: 9999;
            gap: 1rem;
        }

        .bar-left  { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .bar-center { display: flex; align-items: center; gap: .5rem; }
        .bar-right { display: flex; align-items: center; gap: .6rem; flex-shrink: 0; }

        /* Back */
        .btn-back {
            display: inline-flex; align-items: center; gap: .4rem;
            color: var(--muted); text-decoration: none; font-size: .82rem;
            padding: .4rem .7rem; border-radius: 7px;
            transition: all .2s;
        }
        .btn-back:hover { color: #fff; background: rgba(255,255,255,.06); }

        /* Separator */
        .bar-sep { width: 1px; height: 24px; background: var(--border); flex-shrink: 0; }

        /* Template info */
        .template-info .t-name { font-size: .88rem; font-weight: 600; color: #fff; }
        .template-info .t-plan { font-size: .72rem; color: var(--muted); margin-top: .1rem; }

        /* Live badge */
        .live-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            background: rgba(225,29,72,.15); border: 1px solid rgba(225,29,72,.3);
            color: #fca5a5; border-radius: 999px;
            padding: .25rem .75rem; font-size: .72rem; font-weight: 500;
        }
        .live-dot { width: 6px; height: 6px; border-radius: 50%; background: #e11d48; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

        /* Device switcher */
        .device-group {
            display: flex; gap: .3rem;
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border);
            border-radius: 8px; padding: .3rem;
        }
        .dev-btn {
            width: 34px; height: 30px; border-radius: 6px;
            border: none; background: transparent;
            color: var(--muted); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; transition: all .2s;
        }
        .dev-btn.active {
            background: rgba(255,255,255,.12);
            color: #fff;
        }
        .dev-btn:hover:not(.active) { color: #d4d4d4; }

        /* Lang switcher */
        .lang-btn {
            display: inline-flex; align-items: center; gap: .3rem;
            color: var(--muted); text-decoration: none; font-size: .78rem; font-weight: 500;
            padding: .35rem .7rem; border: 1px solid var(--border); border-radius: 7px;
            transition: all .2s;
        }
        .lang-btn:hover { color: #fff; border-color: rgba(255,255,255,.2); }

        /* CTA button */
        .btn-cta {
            background: var(--rose); color: #fff;
            border: none; border-radius: 8px;
            padding: .5rem 1.1rem; font-size: .85rem;
            font-family: inherit; font-weight: 600; cursor: pointer;
            text-decoration: none; white-space: nowrap;
            display: inline-flex; align-items: center; gap: .4rem;
            transition: background .2s, transform .15s;
        }
        .btn-cta:hover { background: #be123c; transform: translateY(-1px); }

        /* ══════════════════════════════════════
           VIEWPORT AREA
        ══════════════════════════════════════ */
        .viewport {
            position: fixed;
            top: var(--bar-h);
            left: 0; right: 0; bottom: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(225,29,72,.07) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 100%, rgba(180,83,9,.06) 0%, transparent 60%),
                        #0f0e0d;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            padding: 1.5rem 1rem 2rem;
            transition: padding .3s;
        }

        /* ══════════════════════════════════════
           DEVICE FRAMES
        ══════════════════════════════════════ */

        /* Desktop — no frame, full-width shadow */
        .device-shell.desktop {
            width: 100%;
            max-width: 1280px;
            border-radius: 12px;
            box-shadow: 0 0 0 1px rgba(255,255,255,.06), 0 20px 60px rgba(0,0,0,.6);
            overflow: hidden;
        }

        /* Tablet — iPad-like chrome */
        .device-shell.tablet {
            width: 768px;
            border-radius: 28px;
            background: #1e1b18;
            box-shadow: 0 0 0 10px #1e1b18, 0 0 0 12px rgba(255,255,255,.08), 0 30px 80px rgba(0,0,0,.7);
            padding: 28px 18px;
        }
        .device-shell.tablet .device-inner {
            border-radius: 12px;
            overflow: hidden;
        }
        .device-shell.tablet::before {
            content: '';
            display: block;
            width: 60px; height: 6px;
            background: rgba(255,255,255,.1);
            border-radius: 999px;
            margin: 0 auto 16px;
        }
        .device-shell.tablet::after {
            content: '';
            display: block;
            width: 44px; height: 44px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
            margin: 16px auto 0;
        }

        /* Mobile — iPhone-like chrome */
        .device-shell.mobile {
            width: 393px;
            border-radius: 44px;
            background: #1a1917;
            box-shadow: 0 0 0 10px #1a1917, 0 0 0 12px rgba(255,255,255,.1), 0 30px 80px rgba(0,0,0,.7);
            padding: 52px 12px 48px;
            position: relative;
        }
        .device-shell.mobile::before {
            content: '';
            position: absolute;
            top: 18px; left: 50%; transform: translateX(-50%);
            width: 120px; height: 30px;
            background: #1a1917;
            border-radius: 999px;
            z-index: 2;
            box-shadow: 0 0 0 2px rgba(255,255,255,.08);
        }
        .device-shell.mobile::after {
            content: '';
            position: absolute;
            bottom: 18px; left: 50%; transform: translateX(-50%);
            width: 120px; height: 4px;
            background: rgba(255,255,255,.15);
            border-radius: 999px;
        }
        .device-shell.mobile .device-inner {
            border-radius: 32px;
            overflow: hidden;
        }

        /* Shared inner */
        .device-inner {
            width: 100%;
            background: #fff;
        }

        .device-inner iframe {
            width: 100%;
            border: none;
            display: block;
            min-height: 800px;
        }

        /* ══════════════════════════════════════
           TRANSITIONS
        ══════════════════════════════════════ */
        .device-shell { transition: all .35s cubic-bezier(.4,0,.2,1); }

        /* ══════════════════════════════════════
           BOTTOM CTA TOAST (guests only)
        ══════════════════════════════════════ */
        .cta-toast {
            position: fixed;
            bottom: 1.5rem;
            left: 50%; transform: translateX(-50%);
            background: rgba(15,14,13,.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 16px;
            padding: .9rem 1.25rem;
            display: flex; align-items: center; gap: 1.25rem;
            box-shadow: 0 12px 40px rgba(0,0,0,.5);
            z-index: 9998;
            white-space: nowrap;
        }
        .cta-toast p { font-size: .875rem; color: #d4d4d4; }
        .cta-toast span { color: var(--gold); font-weight: 600; }

        /* ══════════════════════════════════════
           SCROLLBAR STYLE
        ══════════════════════════════════════ */
        .viewport::-webkit-scrollbar { width: 6px; }
        .viewport::-webkit-scrollbar-track { background: transparent; }
        .viewport::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 999px; }
        .viewport::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,.2); }
    </style>
</head>
<body x-data="previewApp()" x-init="init()">

    {{-- ══════════════════════════════════════
         TOP BAR
    ══════════════════════════════════════ --}}
    <div class="top-bar">

        {{-- Left: back + info --}}
        <div class="bar-left">
            <a href="{{ route('templates.index') }}" class="btn-back">
                {{ app()->isLocale('ar') ? '← رجوع' : '← Back' }}
            </a>
            <div class="bar-sep"></div>
            <div class="live-badge">
                <span class="live-dot"></span>
                {{ app()->isLocale('ar') ? 'معاينة حية' : 'Live Preview' }}
            </div>
            <div class="template-info">
                <p class="t-name">{{ $template->name }}</p>
                <p class="t-plan">{{ $template->plan->name }} · {{ $template->type->label() }}</p>
            </div>
        </div>

        {{-- Center: device switcher --}}
        <div class="bar-center">
            <div class="device-group">
                <button class="dev-btn" :class="{ active: device === 'desktop' }"
                        @click="setDevice('desktop')" title="Desktop">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
                    </svg>
                </button>
                <button class="dev-btn" :class="{ active: device === 'tablet' }"
                        @click="setDevice('tablet')" title="Tablet">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="2" width="16" height="20" rx="2"/><circle cx="12" cy="18" r="1" fill="currentColor"/>
                    </svg>
                </button>
                <button class="dev-btn" :class="{ active: device === 'mobile' }"
                        @click="setDevice('mobile')" title="Mobile">
                    <svg width="14" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="18" r="1" fill="currentColor"/>
                    </svg>
                </button>
            </div>

            {{-- Width label --}}
            <span style="font-size:.7rem; color: var(--muted); min-width:48px; text-align:center;"
                  x-text="widthLabel"></span>
        </div>

        {{-- Right: lang + CTA --}}
        <div class="bar-right">
            @if(app()->isLocale('ar'))
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="lang-btn">🌐 EN</a>
            @else
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="lang-btn">🌐 عربي</a>
            @endif

            @auth
                <a href="{{ route('customer.events.create') }}?template={{ $template->id }}" class="btn-cta">
                    {{ app()->isLocale('ar') ? 'استخدم هذا القالب ←' : 'Use This Template →' }}
                </a>
            @else
                <a href="{{ route('register') }}?template={{ $template->id }}" class="btn-cta">
                    {{ app()->isLocale('ar') ? 'ابدأ مجاناً ←' : 'Get Started Free →' }}
                </a>
            @endauth
        </div>
    </div>

    {{-- ══════════════════════════════════════
         MAIN VIEWPORT
    ══════════════════════════════════════ --}}
    <div class="viewport" id="viewport">
        <div class="device-shell" :class="device">
            <div class="device-inner">
                <iframe
                    id="preview-iframe"
                    src="{{ route('templates.preview-frame', $template) }}"
                    scrolling="yes"
                    @load="onIframeLoad">
                </iframe>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         BOTTOM TOAST (guests)
    ══════════════════════════════════════ --}}
    @guest
    <div class="cta-toast">
        @if(app()->isLocale('ar'))
            <p>أعجبك؟ <span>جرّبه مجاناً</span> وخصّصه بأسمائكم وتفاصيلكم</p>
            <a href="{{ route('register') }}?template={{ $template->id }}" class="btn-cta">
                💌 ابدأ الآن
            </a>
        @else
            <p>Like it? <span>Try it free</span> and personalize it with your details</p>
            <a href="{{ route('register') }}?template={{ $template->id }}" class="btn-cta">
                💌 Start Free
            </a>
        @endif
    </div>
    @endguest

    <script>
        function previewApp() {
            return {
                device: 'desktop',
                widthLabel: 'Full',

                init() {
                    this.updateLabel();
                    // Listen for height message from iframe template
                    window.addEventListener('message', (e) => {
                        if (e.data && e.data.type === 'farahna-height') {
                            this.setIframeHeight(e.data.h);
                        }
                    });
                },

                setDevice(d) {
                    this.device = d;
                    this.updateLabel();
                    // Re-trigger iframe height after transition
                    setTimeout(() => this.recalcHeight(), 400);
                },

                updateLabel() {
                    const map = { desktop: 'Full', tablet: '768px', mobile: '393px' };
                    this.widthLabel = map[this.device] || '';
                },

                onIframeLoad() {
                    this.recalcHeight();
                },

                recalcHeight() {
                    const iframe = document.getElementById('preview-iframe');
                    if (!iframe) return;
                    try {
                        const h = iframe.contentWindow.document.documentElement.scrollHeight;
                        if (h > 200) this.setIframeHeight(h);
                    } catch(e) {}
                    // Poll for GSAP-animated content to settle
                    let i = 0;
                    const poll = setInterval(() => {
                        try {
                            const h = iframe.contentWindow.document.documentElement.scrollHeight;
                            if (h > 200) this.setIframeHeight(h);
                        } catch(e) {}
                        if (++i >= 12) clearInterval(poll);
                    }, 400);
                },

                setIframeHeight(h) {
                    const iframe = document.getElementById('preview-iframe');
                    if (iframe && h > 200) iframe.style.height = h + 'px';
                }
            };
        }
    </script>

</body>
</html>
