<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->isLocale('ar') ? 'فرحنا – دعوات زفاف إلكترونية' : 'Farahna – Elegant Digital Wedding Invitations' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.10/cdn.min.js" defer></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --rose: #e11d48; --rose-light: #fff1f2; --gold: #b45309;
            --dark: #1c1917; --muted: #78716c; --border: #e7e5e4; --white: #fff;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Tajawal', sans-serif; background: #faf9f7; color: var(--dark); }

        /* ─── NAVBAR ─── */
        .nav {
            position: fixed; top: 0; width: 100%; z-index: 100;
            background: rgba(255,255,255,.95); backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-brand { font-family: 'Playfair Display',serif; font-size: 1.5rem; color: var(--rose); text-decoration: none; }
        .nav-links  { display: flex; align-items: center; gap: 1.5rem; }
        .nav-link   { color: var(--muted); text-decoration: none; font-size: .9rem; transition: color .2s; }
        .nav-link:hover { color: var(--rose); }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1.25rem; border-radius: 8px; font-size: .9rem; font-family: inherit; cursor: pointer; text-decoration: none; transition: all .2s; border: none; font-weight: 500; }
        .btn-primary  { background: var(--rose); color: #fff; }
        .btn-primary:hover { background: #be123c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(225,29,72,.3); }
        .btn-outline  { background: transparent; border: 1.5px solid var(--border); color: var(--dark); }
        .btn-outline:hover { border-color: var(--rose); color: var(--rose); }
        .btn-gold     { background: var(--gold); color: #fff; }
        .btn-gold:hover { background: #92400e; transform: translateY(-1px); }
        .btn-lg { padding: .8rem 2rem; font-size: 1rem; border-radius: 10px; }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh; padding-top: 64px;
            display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 64px 2rem 4rem;
            background: linear-gradient(160deg, #fff1f2 0%, #fdf8f0 50%, #fce7f3 100%);
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                radial-gradient(circle at 15% 30%, rgba(225,29,72,.07) 0%, transparent 50%),
                radial-gradient(circle at 85% 70%, rgba(180,83,9,.07) 0%, transparent 50%);
        }
        .hero-content { position: relative; max-width: 800px; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--rose-light); border: 1px solid #fecdd3;
            color: var(--rose); border-radius: 999px;
            padding: .35rem 1rem; font-size: .8rem; font-weight: 500;
            margin-bottom: 1.5rem;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 6vw, 4rem);
            line-height: 1.15; color: var(--dark); margin-bottom: 1.25rem;
        }
        .hero-title span { color: var(--rose); font-style: italic; }
        .hero-desc { font-size: 1.1rem; color: var(--muted); max-width: 520px; margin: 0 auto 2.5rem; line-height: 1.8; }
        .hero-btns  { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 3rem; }
        .hero-stats { display: flex; gap: 3rem; justify-content: center; flex-wrap: wrap; }
        .stat-item  { text-align: center; }
        .stat-num   { font-family: 'Playfair Display',serif; font-size: 2rem; font-weight: 700; color: var(--rose); }
        .stat-lbl   { font-size: .8rem; color: var(--muted); }

        /* ─── SECTION ─── */
        .section { padding: 5rem 2rem; }
        .container { max-width: 1100px; margin: 0 auto; }
        .section-head { text-align: center; margin-bottom: 3.5rem; }
        .section-tag  { display: inline-block; background: var(--rose-light); color: var(--rose); font-size: .75rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; padding: .35rem .9rem; border-radius: 999px; margin-bottom: 1rem; }
        .section-title { font-family: 'Playfair Display',serif; font-size: clamp(1.6rem,4vw,2.2rem); color: var(--dark); margin-bottom: .75rem; }
        .section-desc  { color: var(--muted); max-width: 520px; margin: 0 auto; line-height: 1.7; }

        /* ─── HOW IT WORKS ─── */
        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap: 2rem; }
        .step-card  { text-align: center; padding: 2rem 1.5rem; background: var(--white); border: 1px solid var(--border); border-radius: 20px; transition: transform .3s, box-shadow .3s; }
        .step-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.08); }
        .step-num   { width: 48px; height: 48px; background: var(--rose-light); border: 2px solid #fecdd3; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:var(--rose); margin: 0 auto 1.25rem; }
        .step-icon  { font-size: 2rem; margin-bottom: .75rem; }
        .step-title { font-weight: 700; margin-bottom: .5rem; font-size: 1rem; }
        .step-desc  { color: var(--muted); font-size: .875rem; line-height: 1.6; }

        /* ─── TEMPLATES ─── */
        .templates-bg { background: var(--white); }
        .templates-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap: 1.5rem; }
        .template-card  { border: 1.5px solid var(--border); border-radius: 16px; overflow: hidden; transition: transform .3s, box-shadow .3s; background: var(--white); }
        .template-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.1); border-color: #fecdd3; }
        .template-thumb {
            height: 200px; position: relative; overflow: hidden;
            background: linear-gradient(135deg, #fff1f2, #fce7f3);
            display: flex; align-items: center; justify-content: center;
        }
        .template-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .template-card:hover .template-thumb img { transform: scale(1.05); }
        .template-thumb-placeholder { font-size: 4rem; }
        .template-badge {
            position: absolute; top: .75rem; right: .75rem;
            background: var(--white); border: 1px solid var(--border);
            border-radius: 999px; padding: .2rem .7rem;
            font-size: .7rem; font-weight: 600; color: var(--muted);
        }
        .template-badge.free    { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
        .template-badge.premium { background: #fef9c3; color: #854d0e; border-color: #fef08a; }
        .template-badge.vip     { background: #f3e8ff; color: #7e22ce; border-color: #e9d5ff; }
        .template-body { padding: 1.25rem; }
        .template-name { font-weight: 700; font-size: 1rem; margin-bottom: .3rem; }
        .template-type { font-size: .8rem; color: var(--muted); margin-bottom: 1rem; }
        .template-actions { display: flex; gap: .5rem; }
        .template-actions .btn { flex: 1; justify-content: center; font-size: .85rem; padding: .5rem; }

        /* ─── PRICING ─── */
        .pricing-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap: 1.5rem; max-width: 900px; margin: 0 auto; }
        .plan-card {
            border: 2px solid var(--border); border-radius: 20px;
            padding: 2rem; background: var(--white);
            transition: transform .3s, box-shadow .3s;
            position: relative;
        }
        .plan-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.08); }
        .plan-card.popular { border-color: var(--rose); box-shadow: 0 8px 30px rgba(225,29,72,.15); }
        .popular-badge {
            position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
            background: var(--rose); color: #fff; font-size: .75rem; font-weight: 700;
            padding: .3rem 1rem; border-radius: 999px; white-space: nowrap;
        }
        .plan-icon  { font-size: 2.5rem; margin-bottom: 1rem; }
        .plan-name  { font-weight: 700; font-size: 1.1rem; margin-bottom: .5rem; }
        .plan-price { font-family:'Playfair Display',serif; font-size: 2.5rem; font-weight: 700; color: var(--rose); line-height: 1; margin-bottom: .25rem; }
        .plan-price span { font-size: 1rem; color: var(--muted); font-family:'Tajawal',sans-serif; }
        .plan-features { list-style: none; margin: 1.5rem 0; }
        .plan-features li { display: flex; align-items: center; gap: .6rem; padding: .4rem 0; font-size: .9rem; border-bottom: 1px solid #f5f5f4; }
        .plan-features li:last-child { border: none; }
        .feat-icon { font-size: .9rem; flex-shrink: 0; }

        /* ─── TESTIMONIALS ─── */
        .testimonials-bg { background: linear-gradient(135deg, #fff1f2, #fdf8f0); }
        .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap: 1.5rem; }
        .testimonial-card { background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; position: relative; }
        .testimonial-card::before { content:'❝'; position:absolute; top:.75rem; right:1.25rem; font-size:2.5rem; color:#fce7f3; font-family:Georgia,serif; line-height:1; }
        .testi-text   { color: var(--dark); line-height: 1.7; margin-bottom: 1rem; font-size: .95rem; }
        .testi-author { display: flex; align-items: center; gap: .75rem; }
        .testi-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg,var(--rose-light),#fce7f3); display:flex;align-items:center;justify-content:center;font-size:1.2rem; }
        .testi-name   { font-weight: 600; font-size: .9rem; }
        .testi-event  { font-size: .8rem; color: var(--muted); }

        /* ─── CTA ─── */
        .cta-section { background: linear-gradient(135deg, var(--rose), #be123c); text-align: center; padding: 5rem 2rem; color: #fff; }
        .cta-title { font-family:'Playfair Display',serif; font-size: clamp(1.8rem,4vw,2.8rem); margin-bottom: 1rem; }
        .cta-desc  { opacity: .85; font-size: 1.05rem; margin-bottom: 2.5rem; }
        .cta-btn   { background: #fff; color: var(--rose); padding: .9rem 2.5rem; border-radius: 12px; font-size: 1.05rem; font-weight: 700; text-decoration: none; display: inline-block; transition: transform .2s, box-shadow .2s; }
        .cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.2); }

        /* ─── FOOTER ─── */
        .footer { background: var(--dark); color: #a8a29e; padding: 3rem 2rem; text-align: center; font-size: .875rem; }
        .footer-brand { font-family:'Playfair Display',serif; font-size: 1.8rem; color: #fff; margin-bottom: .5rem; }
    </style>
</head>
<body>

{{-- ─── NAVBAR ─── --}}
<nav class="nav">
    <a href="{{ route('home') }}" class="nav-brand">
        {{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }} ♥
    </a>
    <div class="nav-links">
        <a href="#templates" class="nav-link">{{ app()->isLocale('ar') ? 'القوالب'  : 'Templates' }}</a>
        <a href="#pricing"   class="nav-link">{{ app()->isLocale('ar') ? 'الأسعار'  : 'Pricing'   }}</a>
        <a href="#how"       class="nav-link">{{ app()->isLocale('ar') ? 'كيف يعمل' : 'How it Works' }}</a>

        {{-- Language Switcher --}}
        @if(app()->isLocale('ar'))
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" class="btn btn-outline" style="padding:.4rem .9rem; font-size:.8rem;">🌐 EN</a>
        @else
            <a href="{{ request()->fullUrlWithQuery(['lang' => 'ar']) }}" class="btn btn-outline" style="padding:.4rem .9rem; font-size:.8rem;">🌐 AR</a>
        @endif

        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">
                {{ app()->isLocale('ar') ? 'لوحة التحكم' : 'Dashboard' }}
            </a>
        @else
            <a href="{{ route('login') }}" class="nav-link">
                {{ app()->isLocale('ar') ? 'دخول' : 'Login' }}
            </a>
            <a href="{{ route('register') }}" class="btn btn-primary">
                {{ app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Get Started Free' }}
            </a>
        @endauth
    </div>
</nav>

{{-- ─── HERO ─── --}}
<section class="hero">
    <div class="hero-content">
        @if(app()->isLocale('ar'))
            <div class="hero-badge">✨ دعوات زفاف رقمية أنيقة</div>
            <h1 class="hero-title">اصنع دعوتك<br><span>بلمسة فرح</span></h1>
            <p class="hero-desc">من دعوة ثابتة أنيقة إلى موقع زفاف تفاعلي كامل — كل ما تحتاجه لتشارك يوم زفافك مع من تحب.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-lg">استعرض القوالب 💌</a>
                <a href="#pricing"   class="btn btn-outline btn-lg">الأسعار</a>
            </div>
            <div class="hero-stats">
                <div class="stat-item"><div class="stat-num">+500</div><div class="stat-lbl">زفاف سعيد</div></div>
                <div class="stat-item"><div class="stat-num">{{ $templates->count() }}</div><div class="stat-lbl">قالب متاح</div></div>
                <div class="stat-item"><div class="stat-num">100%</div><div class="stat-lbl">رضا العملاء</div></div>
            </div>
        @else
            <div class="hero-badge">✨ Elegant Digital Wedding Invitations</div>
            <h1 class="hero-title">Create Your<br><span>Dream Invitation</span></h1>
            <p class="hero-desc">From elegant static cards to fully interactive wedding websites — everything you need to share your special day with loved ones.</p>
            <div class="hero-btns">
                <a href="#templates" class="btn btn-primary btn-lg">Browse Templates 💌</a>
                <a href="#pricing"   class="btn btn-outline btn-lg">View Pricing</a>
            </div>
            <div class="hero-stats">
                <div class="stat-item"><div class="stat-num">500+</div><div class="stat-lbl">Happy Couples</div></div>
                <div class="stat-item"><div class="stat-num">{{ $templates->count() }}</div><div class="stat-lbl">Templates</div></div>
                <div class="stat-item"><div class="stat-num">100%</div><div class="stat-lbl">Satisfaction</div></div>
            </div>
        @endif
    </div>
</section>

{{-- ─── HOW IT WORKS ─── --}}
<section class="section" id="how">
    <div class="container">
        @if(app()->isLocale('ar'))
            <div class="section-head">
                <span class="section-tag">كيف يعمل؟</span>
                <h2 class="section-title">ثلاث خطوات وجاهز</h2>
                <p class="section-desc">أبسط طريقة لإنشاء دعوة زفاف تليق بيومك المميز</p>
            </div>
            <div class="steps-grid">
                <div class="step-card"><div class="step-num">1</div><div class="step-icon">🎨</div><h3 class="step-title">اختر قالبك</h3><p class="step-desc">تصفّح قوالبنا وشاهد preview حي لكل قالب قبل الاختيار</p></div>
                <div class="step-card"><div class="step-num">2</div><div class="step-icon">✏️</div><h3 class="step-title">أضف تفاصيلك</h3><p class="step-desc">أسماء العروسين، التاريخ، المكان، وكل تفاصيل حفلتك</p></div>
                <div class="step-card"><div class="step-num">3</div><div class="step-icon">💌</div><h3 class="step-title">شارك مع أحبائك</h3><p class="step-desc">احصل على رابط خاص أو صورة جاهزة للمشاركة فوراً</p></div>
            </div>
        @else
            <div class="section-head">
                <span class="section-tag">How It Works</span>
                <h2 class="section-title">Three Simple Steps</h2>
                <p class="section-desc">The easiest way to create a wedding invitation worthy of your special day</p>
            </div>
            <div class="steps-grid">
                <div class="step-card"><div class="step-num">1</div><div class="step-icon">🎨</div><h3 class="step-title">Pick a Template</h3><p class="step-desc">Browse our gallery and see a live preview of each design before choosing</p></div>
                <div class="step-card"><div class="step-num">2</div><div class="step-icon">✏️</div><h3 class="step-title">Add Your Details</h3><p class="step-desc">Names, date, venue, and everything else about your celebration</p></div>
                <div class="step-card"><div class="step-num">3</div><div class="step-icon">💌</div><h3 class="step-title">Share with Loved Ones</h3><p class="step-desc">Get a private link or a ready-to-share image instantly</p></div>
            </div>
        @endif
    </div>
</section>

{{-- ─── TEMPLATES ─── --}}
<section class="section templates-bg" id="templates">
    <div class="container">
        <div class="section-head">
            @if(app()->isLocale('ar'))
                <span class="section-tag">القوالب</span>
                <h2 class="section-title">اختر أسلوبك</h2>
                <p class="section-desc">قوالب مصممة باحتراف لتعكس روح يومك الخاص</p>
            @else
                <span class="section-tag">Templates</span>
                <h2 class="section-title">Choose Your Style</h2>
                <p class="section-desc">Professionally designed templates to reflect the spirit of your special day</p>
            @endif
        </div>

        @if($templates->isEmpty())
            <p style="text-align:center; color:var(--muted);">قوالب جديدة قادمة قريباً ✨</p>
        @else
            <div class="templates-grid">
                @foreach($templates as $template)
                    <div class="template-card">
                        <div class="template-thumb">
                            @if($template->thumbnail)
                                <img src="{{ Storage::url($template->thumbnail) }}" alt="{{ $template->name }}">
                            @else
                                <div class="template-thumb-placeholder">
                                    {{ $template->isWebsite() ? '🌐' : '💌' }}
                                </div>
                            @endif
                            <span class="template-badge {{ strtolower($template->plan->name) }}">
                                {{ $template->plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : $template->plan->name }}
                            </span>
                        </div>
                        <div class="template-body">
                            <p class="template-name">{{ $template->name }}</p>
                            <p class="template-type">
                                {{ $template->isWebsite() ? (app()->isLocale('ar') ? '🌐 موقع تفاعلي' : '🌐 Interactive Website') : (app()->isLocale('ar') ? '🖼️ دعوة ثابتة' : '🖼️ Static Card') }}
                            </p>
                            <div class="template-actions">
                                @if($template->isWebsite())
                                    <a href="{{ route('templates.preview', $template) }}"
                                       class="btn btn-outline">{{ app()->isLocale('ar') ? '👁 معاينة' : '👁 Preview' }}</a>
                                @endif
                                <a href="{{ route('register') }}?template={{ $template->id }}"
                                   class="btn btn-primary">{{ app()->isLocale('ar') ? 'ابدأ بهذا القالب' : 'Use This Template' }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align:center; margin-top:2.5rem;">
                <a href="{{ route('templates.index') }}" class="btn btn-outline btn-lg">
                    {{ app()->isLocale('ar') ? 'استعرض كل القوالب ←' : 'Browse All Templates →' }}
                </a>
            </div>
        @endif
    </div>
</section>

{{-- ─── PRICING ─── --}}
<section class="section" id="pricing">
    <div class="container">
        <div class="section-head">
            @if(app()->isLocale('ar'))
                <span class="section-tag">الأسعار</span>
                <h2 class="section-title">باقة تناسب كل زفاف</h2>
                <p class="section-desc">ابدأ مجاناً وترقّى متى أردت</p>
            @else
                <span class="section-tag">Pricing</span>
                <h2 class="section-title">A Plan for Every Wedding</h2>
                <p class="section-desc">Start free and upgrade whenever you're ready</p>
            @endif
        </div>

        <div class="pricing-grid">
            @foreach($plans as $plan)
                <div class="plan-card {{ $plan->name === 'Premium' ? 'popular' : '' }}">
                    @if($plan->name === 'Premium')
                        <div class="popular-badge">{{ app()->isLocale('ar') ? '⭐ الأكثر طلباً' : '⭐ Most Popular' }}</div>
                    @endif

                    <div class="plan-icon">
                        {{ $plan->isFree() ? '🆓' : ($plan->price <= 200 ? '⭐' : '👑') }}
                    </div>
                    <p class="plan-name">{{ $plan->name }}</p>
                    <div class="plan-price">
                        {{ $plan->isFree() ? (app()->isLocale('ar') ? 'مجاني' : 'Free') : number_format($plan->price) }}
                        @if(!$plan->isFree()) <span>{{ app()->isLocale('ar') ? 'ج.م' : 'EGP' }}</span> @endif
                    </div>

                    @if($plan->features)
                        <ul class="plan-features">
                            @foreach($plan->features as $key => $val)
                                <li>
                                    <span class="feat-icon">{{ $val === 'true' ? '✅' : '❌' }}</span>
                                    @if(app()->isLocale('ar'))
                                        {{ match($key) {
                                            'static_invitation'    => 'دعوة ثابتة',
                                            'watermark'            => 'علامة مائية',
                                            'subdomain'            => 'رابط خاص',
                                            'guest_book'           => 'سجل تهاني',
                                            'rsvp'                 => 'تأكيد حضور',
                                            'gallery'              => 'معرض صور',
                                            'custom_domain'        => 'دومين مخصص',
                                            'no_watermark'         => 'بدون علامة مائية',
                                            'priority_support'     => 'دعم أولوية',
                                            'everything_in_premium'=> 'كل مميزات Premium',
                                            default                => str_replace('_',' ',$key),
                                        } }}
                                    @else
                                        {{ match($key) {
                                            'static_invitation'    => 'Static Invitation',
                                            'watermark'            => 'Watermark',
                                            'subdomain'            => 'Custom Link',
                                            'guest_book'           => 'Guest Book',
                                            'rsvp'                 => 'RSVP Form',
                                            'gallery'              => 'Photo Gallery',
                                            'custom_domain'        => 'Custom Domain',
                                            'no_watermark'         => 'No Watermark',
                                            'priority_support'     => 'Priority Support',
                                            'everything_in_premium'=> 'Everything in Premium',
                                            default                => str_replace('_',' ',$key),
                                        } }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <a href="{{ route('register') }}" class="btn {{ $plan->name === 'Premium' ? 'btn-primary' : 'btn-outline' }}" style="width:100%; justify-content:center; padding:.75rem;">
                        {{ $plan->isFree() ? (app()->isLocale('ar') ? 'ابدأ مجاناً' : 'Start for Free') : (app()->isLocale('ar') ? 'اختر هذه الباقة' : 'Choose This Plan') }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── TESTIMONIALS ─── --}}
<section class="section testimonials-bg">
    <div class="container">
        <div class="section-head">
            <span class="section-tag">آراء العرسان</span>
            <h2 class="section-title">قالوا عن فرحنا</h2>
        </div>
        <div class="testimonials-grid">
            @foreach([
                ['name'=>'أحمد ومنى','event'=>'قاهرة، أبريل 2025','text'=>'ما توقعناش يبقى سهل كده! في أقل من 10 دقائق كانت الدعوة جاهزة وكلهم بيقولوا إنها أجمل دعوة شافوها 💕'],
                ['name'=>'كريم وسارة','event'=>'الإسكندرية، يونيو 2025','text'=>'الموقع الديناميكي كان مذهل! الأهل والأصدقاء استمتعوا بالعد التنازلي للحفل كتير. شكراً فرحنا! 🎉'],
                ['name'=>'يوسف ومريم','event'=>'الجيزة، سبتمبر 2025','text'=>'سهولة الاستخدام والتصميم الأنيق خلى الدعوة تعكس شخصيتنا بالظبط. أنصح بيها بشدة ❤️'],
            ] as $t)
                <div class="testimonial-card">
                    <p class="testi-text">"{{ $t['text'] }}"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">💍</div>
                        <div>
                            <p class="testi-name">{{ $t['name'] }}</p>
                            <p class="testi-event">{{ $t['event'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="cta-section">
    @if(app()->isLocale('ar'))
        <h2 class="cta-title">ابدأ رحلتك اليوم ♥</h2>
        <p class="cta-desc">أنشئ دعوتك الأولى مجاناً — لا حاجة لبطاقة ائتمان</p>
        <a href="{{ route('register') }}" class="cta-btn">ابدأ الآن مجاناً</a>
    @else
        <h2 class="cta-title">Start Your Journey Today ♥</h2>
        <p class="cta-desc">Create your first invitation for free — no credit card needed</p>
        <a href="{{ route('register') }}" class="cta-btn">Get Started Free</a>
    @endif
</section>

{{-- ─── FOOTER ─── --}}
<footer class="footer">
    <p class="footer-brand">{{ app()->isLocale('ar') ? 'فرحنا' : 'Farahna' }} ♥</p>
    <p>{{ app()->isLocale('ar') ? 'دعوات زفاف رقمية أنيقة لأجمل يوم في حياتك' : 'Elegant digital wedding invitations for the most beautiful day of your life' }}</p>
    <p style="margin-top:1rem; opacity:.4; font-size:.75rem;">© {{ date('Y') }} Farahna. All rights reserved.</p>
</footer>

</body>
</html>
