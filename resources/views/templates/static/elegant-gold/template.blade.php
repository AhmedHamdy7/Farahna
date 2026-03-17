<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Tajawal:wght@300;400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            width: 800px;
            height: 1131px; /* A4 ratio */
            background: #fdf8f0;
            font-family: {{ app()->isLocale('ar') ? "'Tajawal', sans-serif" : "'Cormorant Garamond', serif" }};
            overflow: hidden;
        }

        .invitation {
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 70px 90px;
            background: #fdf8f0;
        }

        /* ─── Multi-layer Border Decoration ─── */
        .border-1 { position: absolute; inset: 18px; border: 2px solid #b45309; pointer-events: none; }
        .border-2 { position: absolute; inset: 26px; border: 1px solid rgba(180,83,9,.4); pointer-events: none; }
        .border-3 { position: absolute; inset: 34px; border: 1px solid rgba(180,83,9,.2); pointer-events: none; }

        /* ─── Corner Ornaments ─── */
        .corner {
            position: absolute;
            pointer-events: none;
        }
        .corner svg { display: block; }
        .corner-tl { top: 14px;    {{ app()->isLocale('ar') ? 'right' : 'left' }}: 14px; }
        .corner-tr { top: 14px;    {{ app()->isLocale('ar') ? 'left' : 'right' }}: 14px;  transform: scaleX(-1); }
        .corner-bl { bottom: 14px; {{ app()->isLocale('ar') ? 'right' : 'left' }}: 14px;  transform: scaleY(-1); }
        .corner-br { bottom: 14px; {{ app()->isLocale('ar') ? 'left' : 'right' }}: 14px;  transform: scale(-1);  }

        /* ─── Background Pattern ─── */
        .bg-pattern {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(180,83,9,.04) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(180,83,9,.04) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(225,29,72,.02) 0%, transparent 60%);
            pointer-events: none;
        }

        /* ─── Content ─── */
        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 100%;
        }

        .label-top {
            font-size: .75rem;
            letter-spacing: 6px;
            color: #b45309;
            text-transform: uppercase;
            margin-bottom: 1.75rem;
            font-family: {{ app()->isLocale('ar') ? "'Tajawal', sans-serif" : "'Cormorant Garamond', serif" }};
            font-style: italic;
        }

        .couple-names {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-style: italic;
            color: #1c1917;
            line-height: 1.15;
        }

        .ampersand {
            font-size: 2.2rem;
            color: #b45309;
            display: block;
            margin: .3rem 0;
            font-style: normal;
        }

        /* Gold divider with center diamond */
        .divider-gold {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.6rem auto;
            max-width: 420px;
        }
        .divider-gold-line {
            flex: 1;
            height: 1.5px;
            background: linear-gradient(to right, transparent, #b45309 40%, #b45309 60%, transparent);
        }
        .divider-gold-center {
            color: #b45309;
            font-size: 1rem;
            line-height: 1;
        }

        .invite-text {
            font-size: {{ app()->isLocale('ar') ? '1rem' : '.95rem' }};
            color: #78716c;
            margin-bottom: 1.75rem;
            line-height: 1.9;
            font-style: italic;
        }

        /* ─── Date Badge ─── */
        .date-badge {
            position: relative;
            display: inline-block;
            margin-bottom: 1.75rem;
        }
        .date-badge-inner {
            background: linear-gradient(135deg, #92400e, #b45309);
            color: #fef9c3;
            padding: 1rem 3rem;
            border-radius: 4px;
            position: relative;
        }
        .date-badge-inner::before,
        .date-badge-inner::after {
            content: '';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 8px; height: 8px;
            background: #fef9c3;
            border-radius: 50%;
        }
        .date-badge-inner::before { {{ app()->isLocale('ar') ? 'right' : 'left' }}: 1rem; }
        .date-badge-inner::after  { {{ app()->isLocale('ar') ? 'left' : 'right' }}: 1rem; }

        .date-badge-label { font-size: .65rem; letter-spacing: 4px; text-transform: uppercase; opacity: .8; margin-bottom: .25rem; }
        .date-badge-value { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 600; line-height: 1.1; }
        .date-badge-time  { font-size: .85rem; opacity: .85; margin-top: .2rem; }

        /* ─── Venue ─── */
        .venue-block { margin-bottom: .75rem; }
        .venue-name {
            font-size: 1.35rem;
            font-weight: {{ app()->isLocale('ar') ? '700' : '600' }};
            color: #1c1917;
            margin-bottom: .3rem;
            font-family: {{ app()->isLocale('ar') ? "'Tajawal', sans-serif" : "'Playfair Display', serif" }};
        }
        .venue-address { font-size: .9rem; color: #78716c; font-style: italic; }

        .footer-ornament {
            margin-top: 1.75rem;
            color: #b45309;
            letter-spacing: .6rem;
            font-size: 1.2rem;
        }

        /* ─── Watermark ─── */
        .watermark {
            position: absolute;
            bottom: 38px;
            left: 50%;
            transform: translateX(-50%);
            font-size: .65rem;
            color: #d6d3d1;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>
<body>
<div class="invitation">
    <div class="bg-pattern"></div>
    <div class="border-1"></div>
    <div class="border-2"></div>
    <div class="border-3"></div>

    {{-- SVG Corner Ornaments --}}
    <div class="corner corner-tl">
        <svg width="54" height="54" viewBox="0 0 54 54" fill="none">
            <path d="M4 4 L4 24 M4 4 L24 4" stroke="#b45309" stroke-width="1.5" fill="none"/>
            <path d="M10 10 L10 20 M10 10 L20 10" stroke="#b45309" stroke-width="1" fill="none" opacity=".5"/>
            <circle cx="4" cy="4" r="2" fill="#b45309"/>
            <path d="M14 4 Q20 4 20 10 Q20 4 26 4" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
            <path d="M4 14 Q4 20 10 20 Q4 20 4 26" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
        </svg>
    </div>
    <div class="corner corner-tr">
        <svg width="54" height="54" viewBox="0 0 54 54" fill="none">
            <path d="M4 4 L4 24 M4 4 L24 4" stroke="#b45309" stroke-width="1.5" fill="none"/>
            <path d="M10 10 L10 20 M10 10 L20 10" stroke="#b45309" stroke-width="1" fill="none" opacity=".5"/>
            <circle cx="4" cy="4" r="2" fill="#b45309"/>
            <path d="M14 4 Q20 4 20 10 Q20 4 26 4" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
            <path d="M4 14 Q4 20 10 20 Q4 20 4 26" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
        </svg>
    </div>
    <div class="corner corner-bl">
        <svg width="54" height="54" viewBox="0 0 54 54" fill="none">
            <path d="M4 4 L4 24 M4 4 L24 4" stroke="#b45309" stroke-width="1.5" fill="none"/>
            <path d="M10 10 L10 20 M10 10 L20 10" stroke="#b45309" stroke-width="1" fill="none" opacity=".5"/>
            <circle cx="4" cy="4" r="2" fill="#b45309"/>
            <path d="M14 4 Q20 4 20 10 Q20 4 26 4" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
            <path d="M4 14 Q4 20 10 20 Q4 20 4 26" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
        </svg>
    </div>
    <div class="corner corner-br">
        <svg width="54" height="54" viewBox="0 0 54 54" fill="none">
            <path d="M4 4 L4 24 M4 4 L24 4" stroke="#b45309" stroke-width="1.5" fill="none"/>
            <path d="M10 10 L10 20 M10 10 L20 10" stroke="#b45309" stroke-width="1" fill="none" opacity=".5"/>
            <circle cx="4" cy="4" r="2" fill="#b45309"/>
            <path d="M14 4 Q20 4 20 10 Q20 4 26 4" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
            <path d="M4 14 Q4 20 10 20 Q4 20 4 26" stroke="#b45309" stroke-width=".8" fill="none" opacity=".6"/>
        </svg>
    </div>

    <div class="content">
        @if(app()->isLocale('ar'))
            <p class="label-top">دعوة زفاف</p>
        @else
            <p class="label-top">Wedding Invitation</p>
        @endif

        <div class="couple-names">
            {{ $event->groom_name }}
            <span class="ampersand">&amp;</span>
            {{ $event->bride_name }}
        </div>

        <div class="divider-gold">
            <div class="divider-gold-line"></div>
            <span class="divider-gold-center">◆</span>
            <div class="divider-gold-line"></div>
        </div>

        <p class="invite-text">
            @if(app()->isLocale('ar'))
                يسعدنا دعوتكم لحضور حفل زفافنا<br>ونسعد بتشريفكم إيّانا في هذا اليوم الجميل
            @else
                Together with their families<br>joyfully invite you to celebrate their marriage
            @endif
        </p>

        <div class="date-badge">
            <div class="date-badge-inner">
                @if(app()->isLocale('ar'))
                    <div class="date-badge-label">التاريخ</div>
                @else
                    <div class="date-badge-label">Date</div>
                @endif
                <div class="date-badge-value">{{ $event->event_date->format('d / m / Y') }}</div>
                @if($event->event_time)
                    <div class="date-badge-time">
                        {{ app()->isLocale('ar') ? 'الساعة' : 'at' }} {{ $event->event_time }}
                    </div>
                @endif
            </div>
        </div>

        <div class="divider-gold">
            <div class="divider-gold-line"></div>
            <span class="divider-gold-center">✦</span>
            <div class="divider-gold-line"></div>
        </div>

        <div class="venue-block">
            <p class="venue-name">{{ $event->venue_name }}</p>
            @if($event->venue_address)
                <p class="venue-address">{{ $event->venue_address }}</p>
            @endif
        </div>

        <p class="footer-ornament">~ ~ ~ ~ ~</p>
    </div>

    @if($watermark ?? true)
        <div class="watermark">Farahna · فرحنا</div>
    @endif
</div>
</body>
</html>
