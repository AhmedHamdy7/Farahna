{{--
  Venue Map Section — shared by all website templates
  Variables available: $event (required)
  Renders a full venue section with Google Maps iframe + directions button.
  Each template can override the accent color via CSS var(--map-accent, var(--accent, #a855f7))
--}}
@php
    $venueName    = $event->venue_name ?? '';
    $venueAddress = $event->venue_address ?? '';
    $mapLink      = $event->venue_map_link ?? '';

    // Build the iframe embed src
    if ($mapLink && str_contains($mapLink, '/embed')) {
        // Already an embed URL — use as-is
        $embedSrc = $mapLink;
    } elseif ($venueAddress) {
        // Build embed from address
        $embedSrc = 'https://maps.google.com/maps?q=' . rawurlencode($venueAddress) . '&output=embed&hl=ar';
    } else {
        $embedSrc = null;
    }

    // Directions link — prefer provided map link, fallback to address search
    $directionsHref = $mapLink ?: ($venueAddress ? 'https://maps.google.com/?q=' . rawurlencode($venueAddress) : null);

    // Skip rendering if no location data at all
    $hasLocation = $venueName || $venueAddress || $mapLink;
@endphp

@if($hasLocation)
<section class="venue-map-section scroll-reveal" id="location">
    <style>
    .venue-map-section {
        padding: 80px 20px;
        background: var(--map-bg, #f9f6f0);
        direction: rtl;
        text-align: center;
    }
    .venue-map-section .vms-label {
        font-size: 12px;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--map-accent, var(--accent, #a855f7));
        font-family: 'Tajawal', sans-serif;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .venue-map-section .vms-title {
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        font-weight: 700;
        color: var(--map-text, #1a1a1a);
        margin-bottom: 6px;
        font-family: inherit;
        line-height: 1.2;
    }
    .venue-map-section .vms-address {
        font-size: 15px;
        color: var(--map-muted, #666);
        font-family: 'Tajawal', sans-serif;
        margin-bottom: 32px;
    }
    .venue-map-section .vms-map-wrap {
        max-width: 860px;
        margin: 0 auto 28px;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(0,0,0,.12);
        position: relative;
        background: #e8e8e8;
    }
    .venue-map-section .vms-map-wrap iframe {
        width: 100%;
        height: 360px;
        border: none;
        display: block;
    }
    .venue-map-section .vms-map-placeholder {
        width: 100%;
        height: 360px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: #999;
        font-family: 'Tajawal', sans-serif;
        font-size: 15px;
        background: linear-gradient(135deg,#f0f0f0,#e0e0e0);
    }
    .venue-map-section .vms-map-placeholder svg { width:48px; height:48px; opacity:.4; }
    .venue-map-section .vms-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 28px;
        border-radius: 50px;
        background: var(--map-accent, var(--accent, #a855f7));
        color: var(--map-btn-text, #fff);
        font-family: 'Tajawal', sans-serif;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 4px 18px rgba(0,0,0,.18);
    }
    .venue-map-section .vms-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.25); }
    .venue-map-section .vms-btn svg { width:18px; height:18px; }
    </style>

    <div class="vms-label">موقع الحفل</div>

    @if($venueName)
    <div class="vms-title">{{ $venueName }}</div>
    @endif

    @if($venueAddress)
    <div class="vms-address">{{ $venueAddress }}</div>
    @endif

    <div class="vms-map-wrap">
        @if($embedSrc)
            <iframe
                src="{{ $embedSrc }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
            </iframe>
        @else
            <div class="vms-map-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5"/>
                </svg>
                لم يتم تحديد موقع بعد
            </div>
        @endif
    </div>

    @if($directionsHref)
    <a href="{{ $directionsHref }}" target="_blank" rel="noopener" class="vms-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
        </svg>
        احصل على الاتجاهات
    </a>
    @endif
</section>
@endif
