<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'القوالب – فرحنا' : 'Templates – Farahna' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root { --rose:#e11d48; --gold:#b45309; --dark:#1c1917; --muted:#78716c; --border:#e7e5e4; }
        body { font-family:'Tajawal',sans-serif; background:#faf9f7; color:var(--dark); }

        .nav { position:sticky; top:0; z-index:50; background:rgba(255,255,255,.95); backdrop-filter:blur(10px); border-bottom:1px solid var(--border); padding:0 2rem; height:64px; display:flex; align-items:center; justify-content:space-between; }
        .nav-brand { font-family:'Playfair Display',serif; font-size:1.5rem; color:var(--rose); text-decoration:none; }
        .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1.25rem; border-radius:8px; font-size:.9rem; font-family:inherit; cursor:pointer; text-decoration:none; transition:all .2s; border:none; font-weight:500; }
        .btn-primary { background:var(--rose); color:#fff; }
        .btn-primary:hover { background:#be123c; }
        .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--dark); }
        .btn-outline:hover { border-color:var(--rose); color:var(--rose); }

        .page-header { background:linear-gradient(135deg,#fff1f2,#fdf8f0); padding:4rem 2rem 2.5rem; text-align:center; border-bottom:1px solid var(--border); }
        .page-title  { font-family:'Playfair Display',serif; font-size:clamp(1.8rem,4vw,2.5rem); margin-bottom:.75rem; }
        .page-desc   { color:var(--muted); max-width:480px; margin:0 auto 2rem; }

        /* ── Category Filter ── */
        .filters { display:flex; gap:.5rem; justify-content:center; flex-wrap:wrap; }
        .filter-btn {
            display:inline-flex; align-items:center; gap:.35rem;
            padding:.4rem 1.1rem; border-radius:999px;
            border:1.5px solid var(--border); background:#fff;
            color:var(--muted); font-family:inherit; font-size:.85rem;
            cursor:pointer; transition:all .2s;
        }
        .filter-btn.active, .filter-btn:hover { border-color:var(--rose); color:var(--rose); background:#fff1f2; }

        /* ── Grid ── */
        .container { max-width:1200px; margin:0 auto; padding:3rem 2rem; }
        .templates-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:1.5rem; }

        /* ── Card ── */
        .template-card { border:1.5px solid var(--border); border-radius:16px; overflow:hidden; background:#fff; transition:transform .3s, box-shadow .3s; }
        .template-card:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(0,0,0,.1); border-color:#fecdd3; }

        .template-thumb {
            height:220px; position:relative; overflow:hidden;
            display:flex; align-items:center; justify-content:center;
        }
        .template-thumb img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
        .template-card:hover .template-thumb img { transform:scale(1.05); }
        .template-placeholder { font-size:5rem; }

        /* Theme gradients per category/template */
        .thumb-wedding    { background:linear-gradient(135deg,#fff1f2,#fce7f3); }
        .thumb-birthday   { background:linear-gradient(135deg,#0a0a0a,#1a1500); }
        .thumb-engagement { background:linear-gradient(135deg,#fdf0f3,#f9d7e2); }
        .thumb-graduation { background:linear-gradient(135deg,#0a1628,#1e4976); }
        .thumb-corporate  { background:linear-gradient(135deg,#f0f4ff,#e8eaf6); }
        .thumb-galaxy     { background:linear-gradient(135deg,#050914,#1a0a2e); }
        .thumb-confetti   { background:linear-gradient(135deg,#fff9c4,#fce4ec); }
        .thumb-loveletter { background:linear-gradient(135deg,#f5ede0,#e8d0b0); }
        .thumb-neon       { background:linear-gradient(135deg,#06000e,#2a003a); }

        .plan-badge { position:absolute; top:.75rem; right:.75rem; border-radius:999px; padding:.2rem .7rem; font-size:.7rem; font-weight:600; }
        .plan-badge.free    { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
        .plan-badge.premium { background:#fef9c3; color:#854d0e; border:1px solid #fef08a; }
        .plan-badge.vip     { background:#f3e8ff; color:#7e22ce; border:1px solid #e9d5ff; }

        .cat-badge { position:absolute; bottom:.75rem; left:.75rem; background:rgba(0,0,0,.55); color:#fff; border-radius:6px; padding:.2rem .55rem; font-size:.7rem; backdrop-filter:blur(4px); }

        .template-body { padding:1.25rem; }
        .template-name { font-weight:700; font-size:1.05rem; margin-bottom:.25rem; }
        .template-plan { font-size:.8rem; color:var(--muted); margin-bottom:1rem; }
        .template-actions { display:flex; gap:.5rem; }
        .template-actions .btn { flex:1; justify-content:center; padding:.5rem; font-size:.85rem; }

        /* Template style preview chips */
        .style-chips { display:flex; gap:.35rem; flex-wrap:wrap; margin-bottom:.75rem; }
        .chip { font-size:.7rem; padding:.15rem .6rem; border-radius:999px; background:#f5f5f4; color:var(--muted); border:1px solid var(--border); }
        .chip.dark   { background:#1c1917; color:#d6d3d1; border-color:#292524; }
        .chip.gold   { background:#fef9c3; color:#854d0e; border-color:#fde68a; }
        .chip.pink   { background:#fff1f2; color:#be123c; border-color:#fecdd3; }
        .chip.cosmic { background:#1e1b4b; color:#a5b4fc; border-color:#3730a3; }
        .chip.fun    { background:#ecfdf5; color:#065f46; border-color:#6ee7b7; }
        .chip.blush  { background:#fdf0f3; color:#9d174d; border-color:#fbcfe8; }
    </style>
</head>
<body x-data="{ cat: 'all', type: 'all' }">

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-brand">{{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }} ♥</a>
    <div style="display:flex;gap:1rem;align-items:center;">
        @if(app()->isLocale('ar'))
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="btn btn-outline" style="padding:.4rem .9rem;font-size:.8rem;">🌐 EN</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="btn btn-outline" style="padding:.4rem .9rem;font-size:.8rem;">🌐 عربي</a>
        @endif
        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">{{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}</a>
        @else
            <a href="{{ route('login') }}" style="color:var(--muted);text-decoration:none;font-size:.9rem;">{{ app()->isLocale('ar') ? 'دخول' : 'Login' }}</a>
            <a href="{{ route('register') }}" class="btn btn-primary">{{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started Free' }} →</a>
        @endauth
    </div>
</nav>

<div class="page-header">
    <h1 class="page-title">{{ app()->isLocale('ar') ? '✨ استعرض قوالبنا' : '✨ Browse Our Templates' }}</h1>
    <p class="page-desc">{{ app()->isLocale('ar') ? 'قوالب مميزة لكل مناسبة — شاهد معاينة حية قبل البدء' : 'Beautiful templates for every occasion — preview before you start' }}</p>

    {{-- Category Filter --}}
    <div class="filters">
        <button class="filter-btn" :class="{active:cat==='all'}" @click="cat='all'">{{ app()->isLocale('ar') ? '🔮 الكل' : '🔮 All' }}</button>
        <button class="filter-btn" :class="{active:cat==='wedding'}"    @click="cat='wedding'">💍 {{ app()->isLocale('ar') ? 'فرح' : 'Wedding' }}</button>
        <button class="filter-btn" :class="{active:cat==='birthday'}"   @click="cat='birthday'">🎂 {{ app()->isLocale('ar') ? 'عيد ميلاد' : 'Birthday' }}</button>
        <button class="filter-btn" :class="{active:cat==='engagement'}" @click="cat='engagement'">💎 {{ app()->isLocale('ar') ? 'خطوبة' : 'Engagement' }}</button>
        <button class="filter-btn" :class="{active:cat==='graduation'}" @click="cat='graduation'">🎓 {{ app()->isLocale('ar') ? 'تخرج' : 'Graduation' }}</button>
        <button class="filter-btn" :class="{active:cat==='static'}"     @click="cat='static'">🖼 {{ app()->isLocale('ar') ? 'دعوات ثابتة' : 'Static Cards' }}</button>
    </div>
</div>

<div class="container">
    <div class="templates-grid">
        @forelse($templates as $template)
            @php
                $catVal  = $template->category?->value ?? 'wedding';
                $planKey = strtolower($template->plan->name);
                // Determine thumb class
                $thumbClass = match($template->slug) {
                    'birthday-luxury'  => 'thumb-birthday',
                    'galaxy-night'     => 'thumb-galaxy',
                    'confetti-pop'     => 'thumb-confetti',
                    'petal-blush'      => 'thumb-engagement',
                    'desert-sand'      => 'thumb-wedding',
                    'wedding-modern'   => 'thumb-wedding',
                    'love-letter'      => 'thumb-loveletter',
                    'neon-night'       => 'thumb-neon',
                    default            => 'thumb-' . $catVal,
                };
                $typeVal = $template->isStatic() ? 'static' : $catVal;
            @endphp
            <div class="template-card"
                 x-show="cat==='all' || cat==='{{ $typeVal }}'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">

                <div class="template-thumb {{ $thumbClass }}">
                    @if($template->thumbnail)
                        <img src="{{ Storage::url($template->thumbnail) }}" alt="{{ $template->name }}">
                    @else
                        @php
                            $thumbIcon = match($template->slug) {
                                'birthday-luxury' => '🎂',
                                'galaxy-night'    => '🌌',
                                'confetti-pop'    => '🎉',
                                'petal-blush'     => '🌸',
                                'desert-sand'     => '🏜',
                                'wedding-modern'  => '💍',
                                'love-letter'     => '💌',
                                'neon-night'      => '⚡',
                                default           => $template->isWebsite() ? '🌐' : '💌',
                            };
                        @endphp
                        <div class="template-placeholder">{{ $thumbIcon }}</div>
                    @endif
                    <span class="plan-badge {{ $planKey }}">
                        {{ $template->plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : $template->plan->name }}
                    </span>
                    <span class="cat-badge">
                        {{ $template->category?->icon() ?? '💌' }} {{ $template->category?->label() ?? '' }}
                        @if($template->isStatic()) · 🖼 @endif
                    </span>
                </div>

                <div class="template-body">
                    <p class="template-name">{{ $template->name }}</p>

                    @php
                        $chips = match($template->slug) {
                            'romantic-scroll'  => [['label'=>'روسة كلاسيك','class'=>'pink'],['label'=>'أنيميشن','class'=>''],['label'=>'RSVP','class'=>'']],
                            'wedding-modern'   => [['label'=>'مودرن','class'=>''],['label'=>'مينيمال','class'=>'gold'],['label'=>'شيك','class'=>'']],
                            'birthday-luxury'  => [['label'=>'فاخر','class'=>'dark'],['label'=>'ذهبي','class'=>'gold'],['label'=>'داكن','class'=>'dark']],
                            'galaxy-night'     => [['label'=>'كوني','class'=>'cosmic'],['label'=>'نجوم','class'=>'cosmic'],['label'=>'روشه','class'=>'']],
                            'confetti-pop'     => [['label'=>'ملون','class'=>'fun'],['label'=>'كونفيتي','class'=>'fun'],['label'=>'مرح','class'=>'']],
                            'petal-blush'      => [['label'=>'ناعم','class'=>'blush'],['label'=>'وردي','class'=>'blush'],['label'=>'رومانسي','class'=>'']],
                            'love-letter'      => [['label'=>'خطاب','class'=>'pink'],['label'=>'ختم شمع','class'=>'gold'],['label'=>'رومانسي','class'=>'']],
                            'neon-night'       => [['label'=>'نيون','class'=>'cosmic'],['label'=>'نايتكلاب','class'=>'dark'],['label'=>'روشه','class'=>'dark']],
                            'elegant-gold'     => [['label'=>'كلاسيك','class'=>'gold'],['label'=>'ذهبي','class'=>'gold'],['label'=>'A4','class'=>'']],
                            default            => [],
                        };
                    @endphp
                    @if($chips)
                    <div class="style-chips">
                        @foreach($chips as $chip)
                            <span class="chip {{ $chip['class'] }}">{{ $chip['label'] }}</span>
                        @endforeach
                    </div>
                    @endif

                    <p class="template-plan">
                        {{ $template->plan->name }} —
                        {{ $template->plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : number_format($template->plan->price).(app()->isLocale('ar') ? ' ج.م' : ' EGP') }}
                    </p>
                    <div class="template-actions">
                        <a href="{{ route('templates.preview', $template) }}" class="btn btn-outline">
                            👁 {{ app()->isLocale('ar') ? 'معاينة' : 'Preview' }}
                        </a>
                        @auth
                            <a href="{{ route('customer.events.create') }}?template={{ $template->id }}" class="btn btn-primary">
                                {{ app()->isLocale('ar') ? 'ابدأ الآن' : 'Use Template' }} →
                            </a>
                        @else
                            <a href="{{ route('login') }}?template={{ $template->id }}" class="btn btn-primary">
                                {{ app()->isLocale('ar') ? 'ابدأ الآن' : 'Use Template' }} →
                            </a>
                        @endauth
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
