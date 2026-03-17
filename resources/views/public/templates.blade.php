<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'القوالب – فرحنا' : 'Templates – Farahna' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --rose:#e11d48; --gold:#b45309; --dark:#1c1917; --muted:#78716c; --border:#e7e5e4; }
        body { font-family: 'Tajawal',sans-serif; background: #faf9f7; color: var(--dark); }

        .nav { position:sticky; top:0; z-index:50; background:rgba(255,255,255,.95); backdrop-filter:blur(10px); border-bottom:1px solid var(--border); padding:0 2rem; height:64px; display:flex; align-items:center; justify-content:space-between; }
        .nav-brand { font-family:'Playfair Display',serif; font-size:1.5rem; color:var(--rose); text-decoration:none; }
        .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1.25rem; border-radius:8px; font-size:.9rem; font-family:inherit; cursor:pointer; text-decoration:none; transition:all .2s; border:none; font-weight:500; }
        .btn-primary { background:var(--rose); color:#fff; }
        .btn-primary:hover { background:#be123c; }
        .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--dark); }
        .btn-outline:hover { border-color:var(--rose); color:var(--rose); }

        .page-header { background:linear-gradient(135deg,#fff1f2,#fdf8f0); padding:4rem 2rem; text-align:center; border-bottom:1px solid var(--border); }
        .page-title  { font-family:'Playfair Display',serif; font-size:clamp(1.8rem,4vw,2.5rem); margin-bottom:.75rem; }
        .page-desc   { color:var(--muted); max-width:480px; margin:0 auto 2rem; }

        /* Filters */
        .filters { display:flex; gap:.5rem; justify-content:center; flex-wrap:wrap; }
        .filter-btn { padding:.4rem 1.1rem; border-radius:999px; border:1.5px solid var(--border); background:#fff; color:var(--muted); font-family:inherit; font-size:.85rem; cursor:pointer; transition:all .2s; }
        .filter-btn.active, .filter-btn:hover { border-color:var(--rose); color:var(--rose); background:#fff1f2; }

        .container { max-width:1100px; margin:0 auto; padding:3rem 2rem; }

        .templates-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1.5rem; }

        .template-card  { border:1.5px solid var(--border); border-radius:16px; overflow:hidden; background:#fff; transition:transform .3s, box-shadow .3s; }
        .template-card:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(0,0,0,.1); border-color:#fecdd3; }
        .template-thumb { height:220px; position:relative; overflow:hidden; background:linear-gradient(135deg,#fff1f2,#fce7f3); display:flex; align-items:center; justify-content:center; }
        .template-thumb img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
        .template-card:hover .template-thumb img { transform:scale(1.05); }
        .template-placeholder { font-size:5rem; }
        .template-badge { position:absolute; top:.75rem; right:.75rem; background:#fff; border:1px solid var(--border); border-radius:999px; padding:.2rem .7rem; font-size:.7rem; font-weight:600; color:var(--muted); }
        .template-badge.free    { background:#dcfce7; color:#166534; border-color:#bbf7d0; }
        .template-badge.premium { background:#fef9c3; color:#854d0e; border-color:#fef08a; }
        .template-badge.vip     { background:#f3e8ff; color:#7e22ce; border-color:#e9d5ff; }
        .type-badge { position:absolute; bottom:.75rem; left:.75rem; background:rgba(0,0,0,.6); color:#fff; border-radius:6px; padding:.2rem .6rem; font-size:.7rem; }

        .template-body { padding:1.25rem; }
        .template-name { font-weight:700; font-size:1.05rem; margin-bottom:.3rem; }
        .template-plan { font-size:.8rem; color:var(--muted); margin-bottom:1rem; }
        .template-actions { display:flex; gap:.5rem; }
        .template-actions .btn { flex:1; justify-content:center; padding:.5rem; font-size:.85rem; }
    </style>
</head>
<body x-data="{ filter: 'all' }">

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-brand">{{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }} ♥</a>
    <div style="display:flex;gap:1rem;align-items:center;">
        @if(app()->isLocale('ar'))
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="btn btn-outline" style="padding:.4rem .9rem;font-size:.8rem;">🌐 EN</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="btn btn-outline" style="padding:.4rem .9rem;font-size:.8rem;">🌐 AR</a>
        @endif
        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">
                {{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}
            </a>
        @else
            <a href="{{ route('login') }}" style="color:var(--muted);text-decoration:none;font-size:.9rem;">
                {{ app()->isLocale('ar') ? 'دخول' : 'Login' }}
            </a>
            <a href="{{ route('register') }}" class="btn btn-primary">
                {{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started Free' }}
            </a>
        @endauth
    </div>
</nav>

<div class="page-header">
    <h1 class="page-title">{{ app()->isLocale('ar') ? 'استعرض قوالبنا' : 'Browse Our Templates' }}</h1>
    <p class="page-desc">{{ app()->isLocale('ar') ? 'اختر القالب المناسب وشاهد معاينة حية قبل البدء' : 'Choose your design and see a live preview before you start' }}</p>
    <div class="filters">
        <button class="filter-btn" :class="{active:filter==='all'}"     @click="filter='all'">{{ app()->isLocale('ar') ? 'الكل' : 'All' }}</button>
        <button class="filter-btn" :class="{active:filter==='website'}" @click="filter='website'">🌐 {{ app()->isLocale('ar') ? 'مواقع تفاعلية' : 'Interactive Websites' }}</button>
        <button class="filter-btn" :class="{active:filter==='static'}"  @click="filter='static'">🖼 {{ app()->isLocale('ar') ? 'دعوات ثابتة' : 'Static Cards' }}</button>
    </div>
</div>

<div class="container">
    <div class="templates-grid">
        @forelse($templates->flatten() as $template)
            <div class="template-card"
                 x-show="filter==='all' || filter==='{{ $template->type->value }}'"
                 x-transition>
                <div class="template-thumb">
                    @if($template->thumbnail)
                        <img src="{{ Storage::url($template->thumbnail) }}" alt="{{ $template->name }}">
                    @else
                        <div class="template-placeholder">{{ $template->isWebsite() ? '🌐' : '💌' }}</div>
                    @endif
                    <span class="template-badge {{ strtolower($template->plan->name) }}">
                        {{ $template->plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : $template->plan->name }}
                    </span>
                    <span class="type-badge">
                        {{ $template->isWebsite() ? (app()->isLocale('ar') ? '🌐 تفاعلي' : '🌐 Interactive') : (app()->isLocale('ar') ? '🖼 ثابت' : '🖼 Static') }}
                    </span>
                </div>
                <div class="template-body">
                    <p class="template-name">{{ $template->name }}</p>
                    <p class="template-plan">
                        {{ $template->plan->name }} —
                        {{ $template->plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : number_format($template->plan->price).(app()->isLocale('ar') ? ' ج.م' : ' EGP') }}
                    </p>
                    <div class="template-actions">
                        @if($template->isWebsite())
                            <a href="{{ route('templates.preview', $template) }}" class="btn btn-outline">
                                {{ app()->isLocale('ar') ? '👁 معاينة' : '👁 Preview' }}
                            </a>
                        @endif
                        <a href="{{ route('register') }}?template={{ $template->id }}" class="btn btn-primary">
                            {{ app()->isLocale('ar') ? 'ابدأ بهذا القالب' : 'Use This Template' }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1; text-align:center; color:var(--muted); padding:4rem;">
                قوالب جديدة قادمة قريباً ✨
            </div>
        @endforelse
    </div>
</div>

</body>
</html>
