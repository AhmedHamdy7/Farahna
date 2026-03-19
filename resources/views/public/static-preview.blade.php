<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }} – معاينة</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        body {
            font-family:'Tajawal', sans-serif;
            background:#f0ece4;
            min-height:100vh;
            display:flex; flex-direction:column;
        }

        /* ─── Preview Bar (gold/cream theme matching elegant-gold) ─── */
        .preview-bar {
            position:sticky; top:0; z-index:100;
            background:#1c1510;
            border-bottom:1px solid rgba(180,83,9,.4);
            height:56px;
            display:flex; align-items:center; justify-content:space-between;
            padding:0 1.5rem; gap:1rem;
        }
        .preview-left  { display:flex; align-items:center; gap:1rem; }
        .preview-right { display:flex; align-items:center; gap:.75rem; }
        .back-btn {
            display:inline-flex; align-items:center; gap:.4rem;
            color:rgba(255,255,255,.6); text-decoration:none; font-size:.85rem;
            transition:color .2s;
        }
        .back-btn:hover { color:#fff; }
        .live-dot { display:inline-flex; align-items:center; gap:.35rem; background:rgba(180,83,9,.3); border:1px solid rgba(180,83,9,.5); color:#f59e0b; border-radius:999px; padding:.2rem .75rem; font-size:.75rem; font-weight:600; }
        .live-dot::before { content:''; width:6px; height:6px; border-radius:50%; background:#f59e0b; animation:blink 1.4s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
        .template-info { color:#fff; font-weight:600; font-size:.9rem; }
        .template-plan { color:rgba(255,255,255,.4); font-size:.75rem; }
        .use-btn {
            display:inline-flex; align-items:center; gap:.4rem;
            background:linear-gradient(135deg,#92400e,#b45309);
            color:#fef9c3; padding:.45rem 1.25rem; border-radius:8px;
            text-decoration:none; font-size:.85rem; font-weight:600;
            transition:all .2s; white-space:nowrap;
        }
        .use-btn:hover { background:linear-gradient(135deg,#b45309,#d97706); }

        /* ─── Card Container ─── */
        .card-stage {
            flex:1;
            display:flex; align-items:flex-start; justify-content:center;
            padding:3rem 1.5rem;
            overflow:auto;
        }
        .card-scaler {
            /* Scale the 800px card to fit viewport */
            transform-origin: top center;
            transform: scale(var(--scale, 1));
            width:800px;
            flex-shrink:0;
        }
        .card-shadow {
            box-shadow:0 30px 80px rgba(0,0,0,.3), 0 4px 16px rgba(0,0,0,.15);
            border-radius:2px;
        }
    </style>
</head>
<body>

<div class="preview-bar">
    <div class="preview-left">
        <a href="{{ route('templates.index') }}" class="back-btn">← رجوع</a>
        <span class="live-dot">معاينة</span>
        <div>
            <p class="template-info">{{ $template->name }}</p>
            <p class="template-plan">{{ $template->plan->name }} · {{ $template->type->label() }}</p>
        </div>
    </div>
    <div class="preview-right">
        <a href="{{ route('register') }}?template={{ $template->id }}" class="use-btn">
            استخدم هذا القالب →
        </a>
    </div>
</div>

<div class="card-stage" id="cardStage">
    <div class="card-scaler card-shadow" id="cardScaler">
        @include("templates.static.{$template->slug}.template", ['event' => $event, 'watermark' => false])
    </div>
</div>

<script>
(function(){
    function rescale(){
        var stage = document.getElementById('cardStage');
        var scaler = document.getElementById('cardScaler');
        var stageW = stage.clientWidth - 48; // 24px padding each side
        var scale = Math.min(1, stageW / 800);
        scaler.style.transform = 'scale(' + scale + ')';
        // Adjust container height to actual rendered height
        scaler.parentElement.style.height = (1131 * scale + 48) + 'px';
    }
    rescale();
    window.addEventListener('resize', rescale);
})();
</script>

</body>
</html>
