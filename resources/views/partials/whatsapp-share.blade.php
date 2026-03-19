{{--
  WhatsApp Share Floating Button
  Variables: $event (required), $isPreview (optional)
--}}
@php
    $shareUrl  = request()->url();
    $eventName = isset($event) ? ($event->coupleName() ?? '') : '';
    $waText    = 'أنت مدعو! 🎉' . "\n" . 'تفضل بمشاهدة دعوتي الإلكترونية' . ($eventName ? ' لـ ' . $eventName : '') . ':' . "\n" . $shareUrl;
    $waHref    = 'https://wa.me/?text=' . rawurlencode($waText);
@endphp

<style>
.wa-float {
    position: fixed;
    bottom: 28px;
    left: 28px;
    z-index: 9990;
}
.wa-float .wa-btn {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #25d366;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border: 2.5px solid rgba(255,255,255,.3);
    box-shadow: 0 4px 20px rgba(37,211,102,.5);
    transition: transform .2s, box-shadow .2s;
    position: relative;
}
.wa-float .wa-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 32px rgba(37,211,102,.65);
}
.wa-float .wa-btn svg {
    width: 30px;
    height: 30px;
}

/* Tooltip above button */
.wa-float .wa-tip {
    position: absolute;
    bottom: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%);
    background: rgba(10,10,10,.88);
    color: #fff;
    font-family: 'Tajawal', sans-serif;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    padding: 5px 12px;
    border-radius: 20px;
    pointer-events: none;
    opacity: 0;
    transition: opacity .2s;
    direction: rtl;
}
.wa-float .wa-tip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: rgba(10,10,10,.88);
}
.wa-float .wa-btn:hover .wa-tip { opacity: 1; }

@media (max-width: 480px) {
    .wa-float { bottom: 18px; left: 18px; }
    .wa-float .wa-btn { width: 46px; height: 46px; }
}
</style>

<a href="{{ $waHref }}" target="_blank" rel="noopener" class="wa-float">
    <div class="wa-btn">
        <span class="wa-tip">شارك الدعوة</span>
        <svg viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.004 2.667C8.64 2.667 2.667 8.64 2.667 16c0 2.347.637 4.64 1.84 6.64L2.667 29.333l6.88-1.8A13.28 13.28 0 0 0 16.004 29.333C23.36 29.333 29.333 23.36 29.333 16S23.36 2.667 16.004 2.667zm0 2.4c5.933 0 10.929 4.8 10.929 10.933 0 6.134-4.996 10.934-10.93 10.934a10.88 10.88 0 0 1-5.546-1.52l-.4-.24-4.08 1.067 1.093-3.947-.267-.413A10.88 10.88 0 0 1 5.075 16c0-6.133 4.997-10.933 10.93-10.933zm-3.32 5.44c-.267 0-.693.107-.96.373-.28.294-1.04 1.013-1.04 2.48s1.066 2.88 1.213 3.08c.16.2 2.054 3.2 5.04 4.36.706.293 1.253.454 1.68.587.706.213 1.346.186 1.853.106.56-.093 1.733-.706 1.973-1.386.24-.68.24-1.266.16-1.387-.08-.12-.267-.2-.56-.333-.293-.147-1.733-.853-2-.96-.267-.106-.453-.16-.64.16-.186.32-.72.96-.88 1.147-.16.186-.32.213-.613.08-.293-.147-1.24-.453-2.36-1.44-.867-.773-1.453-1.72-1.626-2.013-.16-.293-.013-.44.12-.587.133-.12.293-.32.44-.48.146-.16.186-.266.28-.453.093-.186.04-.36-.027-.493-.066-.12-.64-1.547-.88-2.107-.226-.533-.453-.44-.626-.44z"/>
        </svg>
    </div>
</a>
