{{--
  Background Music Player — floating button, bottom-right
  Variables: $event (required)
  Reads music URL from $event->custom_data['music_url']
  Requires Alpine.js (already loaded by all templates)
--}}
@php
    $musicUrl   = $event->custom_data['music_url'] ?? null;
    $isPreview  = $isPreview ?? false;
    $showPlayer = $musicUrl || $isPreview;
@endphp

@if($showPlayer)
<style>
.music-player-float {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 9990;
    /* needed for absolute-positioned children (tooltip, rings) */
}
.music-player-float .mp-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(20,20,30,.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1.5px solid rgba(255,255,255,.18);
    color: #fff;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 18px rgba(0,0,0,.45);
}
.music-player-float .mp-btn:hover { transform: scale(1.08); box-shadow: 0 8px 28px rgba(0,0,0,.6); }
.music-player-float .mp-btn svg { width: 22px; height: 22px; }

/* Pulse rings when playing */
.music-player-float .mp-rings {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    pointer-events: none;
}
.music-player-float .mp-rings::before,
.music-player-float .mp-rings::after {
    content: '';
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.25);
    animation: mp-pulse 2s ease-out infinite;
}
.music-player-float .mp-rings::after { animation-delay: 1s; }
@keyframes mp-pulse {
    0%   { transform: scale(1); opacity: .7; }
    100% { transform: scale(1.7); opacity: 0; }
}

/* Mute mini-button */
.music-player-float .mp-mute {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.25);
    background: rgba(30,30,40,.92);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .15s, transform .15s;
    padding: 0;
}
.music-player-float .mp-mute:hover { background: rgba(60,60,80,.95); transform: scale(1.15); }
.music-player-float .mp-mute svg { width: 12px; height: 12px; }
.music-player-float .mp-muted-line {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 1.5px solid rgba(255,80,80,.6);
    pointer-events: none;
}

@media (max-width: 480px) {
    .music-player-float { bottom: 18px; right: 18px; }
    .music-player-float .mp-btn { width: 44px; height: 44px; }
}
</style>

@if($musicUrl)
{{-- Live mode: real audio player --}}
<div
    class="music-player-float"
    x-data="{
        playing: false,
        muted: false,
        audio: null,
        init() {
            this.audio = this.$refs.audioEl;
            this.audio.volume = 0.5;
        },
        toggle() {
            if (this.playing) {
                this.audio.pause();
            } else {
                this.audio.play().catch(() => {});
            }
            this.playing = !this.playing;
        },
        toggleMute() {
            this.muted = !this.muted;
            this.audio.muted = this.muted;
        }
    }"
>
    <audio x-ref="audioEl" loop preload="none">
        <source src="{{ $musicUrl }}" type="audio/mpeg">
    </audio>

    <button class="mp-btn" @click="toggle()" :title="playing ? 'إيقاف' : 'تشغيل الموسيقى'">
        <div class="mp-rings" x-show="playing && !muted"></div>

        {{-- Music note: stopped --}}
        <svg x-show="!playing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
        </svg>

        {{-- Sound waves: playing --}}
        <svg x-show="playing" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
        </svg>

        {{-- Mute badge (shows when playing) --}}
        <button
            class="mp-mute"
            x-show="playing"
            @click.stop="toggleMute()"
            :title="muted ? 'إلغاء الكتم' : 'كتم الصوت'"
        >
            <div class="mp-muted-line" x-show="muted"></div>
            {{-- Speaker ON --}}
            <svg x-show="!muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
            </svg>
            {{-- Speaker OFF (muted) --}}
            <svg x-show="muted" viewBox="0 0 24 24" fill="none" stroke="rgba(255,100,100,1)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/>
                <line x1="23" y1="9" x2="17" y2="15"/>
                <line x1="17" y1="9" x2="23" y2="15"/>
            </svg>
        </button>
    </button>
</div>
@else
{{-- Preview mode: demo indicator (no audio, just shows how it will look) --}}
<div class="music-player-float" title="موسيقى خلفية — أضف رابط MP3 من إعدادات الحدث">
    <button class="mp-btn" onclick="alert('أضف رابط موسيقى MP3 من صفحة تعديل الحدث لتفعيل هذا الزر')" style="opacity:.65; cursor:help;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
        </svg>
    </button>
    <div style="
        position:absolute; bottom:calc(100% + 8px); right:0;
        background:rgba(10,10,10,.85); color:#fff;
        font-family:'Tajawal',sans-serif; font-size:11px;
        padding:4px 10px; border-radius:6px; white-space:nowrap;
        pointer-events:none;
    ">🎵 معاينة — أضف موسيقى</div>
</div>
@endif
@endif
