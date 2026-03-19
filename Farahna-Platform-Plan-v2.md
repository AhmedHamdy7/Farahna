<br># ✦ Farahna Platform ✦
## منصة دعوات المناسبات الإلكترونية
### خطة المشروع الكاملة — التصميم والتنفيذ

> **إعداد:** Ahmed — Backend Laravel Engineer
> **التاريخ:** مارس 2026 — **الإصدار:** 2.0
> **وثيقة سرية — للاستخدام الداخلي فقط**

---

## الفهرس

1. [نظرة عامة على المشروع](#١-نظرة-عامة-على-المشروع)
2. [التقنيات المستخدمة (Tech Stack)](#٢-التقنيات-المستخدمة-tech-stack)
3. [هيكل قاعدة البيانات (Database Schema)](#٣-هيكل-قاعدة-البيانات-database-schema)
4. [كتالوج القوالب (Templates Catalog)](#٤-كتالوج-القوالب-templates-catalog)
5. [الوحدات الأساسية (Modules)](#٥-الوحدات-الأساسية-modules)
6. [الحركات والتأثيرات البصرية — تفصيلي (Animations & Visual Effects)](#٦-الحركات-والتأثيرات-البصرية-animations--visual-effects)
7. [هيكل القوالب (Templates Structure)](#٧-هيكل-القوالب-templates-structure)
8. [خطة التنفيذ (Implementation Timeline)](#٨-خطة-التنفيذ-implementation-timeline)
9. [استراتيجية التسعير (Monetization)](#٩-استراتيجية-التسعير-monetization)
10. [أفكار إضافية](#١٠-أفكار-إضافية)
11. [ملاحظات النشر (Deployment)](#١١-ملاحظات-النشر-deployment)

---

## ١. نظرة عامة على المشروع

منصة إلكترونية متكاملة لإنشاء دعوات رقمية لكل المناسبات. المنصة بتوفر للمستخدم إمكانية إنشاء دعوة رقمية سواء كانت **صورة ثابتة (Static Card)** أو **موقع ديناميكي كامل (Dynamic Website)** مع subdomain خاص.

### ◆ الفكرة الأساسية

- الأدمن (صاحب المنصة) بيوفر مجموعة **Templates جاهزة** بتصميمات مودرن ومتنوعة
- العميل بيختار Template و**يعدل عليها ببياناته** بطريقة سهلة زي WordPress
- **نوعين من الدعوات:** صورة ثابتة (Static Card) للمشاركة على السوشيال، أو موقع كامل بـ subdomain
- الموقع الديناميكي فيه **animations مودرن، guest book، RSVP، وحماية بباسورد**

### ◆ أنواع المناسبات المدعومة

المنصة **مش مختصرة على الأفراح بس** — بتغطي كل أنواع المناسبات:

| فرح / زفاف | خطوبة | عيد ميلاد | سبوع | حفلة تخرج | أوتينج |
|:---:|:---:|:---:|:---:|:---:|:---:|
| Wedding | Engagement | Birthday | Baby Shower / Seboua | Graduation | Outing / Gathering |

> **والأدمن يقدر يضيف أنواع مناسبات جديدة في أي وقت من لوحة التحكم بدون تغيير في الكود.**

### ◆ ليه الاستراتيجية دي؟

**▸ Multi-tenancy عن طريق Subdomain**
كل عميل هيبقى عنده موقع خاص بيه زي `ahmed-and-sara.farahna.com`. ده بيدي إحساس إن الموقع مستقل وبيرفع القيمة المحسوسة عند العميل.

**▸ فصل الـ Templates لنوعين**
Static Card + Dynamic Website: مش كل العملاء محتاجين نفس الحاجة. الفصل ده بيخليك تعمل pricing tiers مختلفة وتوسّع شريحة العملاء.

**▸ Password Protection مع Hint System**
بيضيف عنصر حصرية. الناس بتحب تحس إنها مدعوة بشكل خاص، والـ hint بيخلّي التجربة playful مش محبطة.

**▸ طريقة تعديل سهلة زي WordPress**
العميل بيعدل على الـ Template بطريقة بسيطة وسهلة — الأدمن بيحدد `config_schema` لكل template والعميل بيشوف فورم ديناميكية بيملاها ويشوف live preview فوري.

---

## ٢. التقنيات المستخدمة (Tech Stack)

| المكوّن | التقنية | السبب |
|---|---|---|
| **Backend** | Laravel 11 + PHP 8.3 | الأساس الرئيسي للمشروع |
| **Admin Panel** | Filament 3 | سريع في البناء ومتكامل مع Laravel |
| **Frontend (Invitations)** | Alpine.js + GSAP + Tailwind CSS | خفيف وسريع — الضيف بيفتح من الموبايل |
| **Template Engine** | Blade + JSON config_schema | مرونة كاملة في إضافة templates جديدة |
| **Database** | MySQL | موثوق وسهل الإدارة |
| **Image Generation** | Browsershot (Headless Chrome) | دعم الخطوط العربية الزخرفية |
| **Animations** | GSAP 3 + ScrollTrigger + Lottie.js | أقوى مكتبة animations على الويب |
| **Payment** | Paymob / Fawry | بوابات دفع مصرية موثوقة |
| **Caching & Performance** | Redis + Laravel Cache + CDN | سرعة تحميل عالية للدعوات |
| **Background Music** | Howler.js | تحكم كامل في الصوت + cross-browser |

### ◆ ليه Alpine.js مش Vue أو React؟

صفحات الدعوات محتاجة تبقى **خفيفة وسريعة جداً** في التحميل. الضيف بيفتح اللينك من الموبايل وعايز يشوف الدعوة في ثانية. Alpine + GSAP بيدوك animations جامدة من غير JavaScript bundle كبير.

### ◆ مبادئ الكود (Code Quality Principles)

- كود **منظم وقابل للصيانة** — اتباع SOLID Principles
- **Service Layer Pattern** لفصل الـ Business Logic عن الـ Controllers
- **Repository Pattern** للـ Database Queries المعقدة
- **Form Request Validation** لكل endpoint
- **API Resources** للـ response formatting
- **Feature Tests** باستخدام Pest/PHPUnit
- **Caching Strategy** للصفحات الأكثر زيارة (الدعوات)
- **Queued Jobs** للعمليات الثقيلة زي توليد الصور
- **Eager Loading** لتجنب N+1 query problem
- **Database Indexing** على الأعمدة الأكثر استخداماً (subdomain, slug, status)

---

## ٣. هيكل قاعدة البيانات (Database Schema)

### ◆ جدول `users` — المستخدمين

| Column | Type | ملاحظات |
|---|---|---|
| **id** | BIGINT | Primary Key |
| name | VARCHAR | اسم المستخدم |
| email | VARCHAR | فريد |
| phone | VARCHAR | رقم الموبايل |
| plan_id | FK | الخطة الحالية |
| created_at | TIMESTAMP | — |

### ◆ جدول `event_categories` — فئات المناسبات ✨ (جديد)

| Column | Type | ملاحظات |
|---|---|---|
| **id** | BIGINT | Primary Key |
| name | JSON | الاسم (ar/en) — فرح، خطوبة، عيد ميلاد... |
| slug | VARCHAR | فريد — `wedding`, `engagement`, `birthday`... |
| icon | VARCHAR | أيقونة الفئة |
| is_active | BOOLEAN | الأدمن يقدر يفعّل/يعطّل أي فئة |
| config_fields | JSON | الحقول الخاصة بالفئة (زي اسم العريس/العروسة للفرح) |
| sort_order | INT | ترتيب العرض |

### ◆ جدول `templates` — القوالب

| Column | Type | ملاحظات |
|---|---|---|
| **id** | BIGINT | Primary Key |
| category_id | FK | ربط بـ `event_categories` |
| name | VARCHAR | اسم القالب |
| type | ENUM | `static` / `website` |
| style_tag | VARCHAR | `modern` / `chic` / `trendy` / `classic` / `romantic` |
| color_scheme | JSON | الألوان الأساسية للقالب |
| config_schema | JSON | الحقول المطلوبة من العميل |
| thumbnail | VARCHAR | صورة المعاينة |
| preview_url | VARCHAR | رابط الـ live preview |
| is_premium | BOOLEAN | هل القالب premium ولا مجاني |
| is_active | BOOLEAN | تفعيل/تعطيل |

### ◆ جدول `events` — المناسبات

| Column | Type | ملاحظات |
|---|---|---|
| **id** | BIGINT | Primary Key |
| user_id | FK | صاحب المناسبة |
| template_id | FK | القالب المختار |
| category_id | FK | نوع المناسبة |
| subdomain | VARCHAR | فريد — رابط الموقع |
| custom_data | JSON | بيانات العميل حسب القالب |
| password | VARCHAR (nullable) | حماية اختيارية |
| hint | VARCHAR (nullable) | تلميح الباسورد |
| event_date | DATETIME | تاريخ المناسبة |
| status | ENUM | `draft` / `published` / `expired` |
| views_count | INT | عدد الزيارات |
| created_at | TIMESTAMP | — |

### ◆ جدول `plans` — خطط الاشتراك

| Column | Type | ملاحظات |
|---|---|---|
| **id** | BIGINT | Primary Key |
| name | VARCHAR | `Free` / `Premium` / `VIP` |
| price | DECIMAL | السعر |
| features | JSON | المميزات المتاحة |
| is_active | BOOLEAN | — |

### ◆ باقي الجداول

- **`event_gallery`** — صور المناسبة (event_id, image_path, sort_order)
- **`wishes`** — رسائل التمنيات (event_id, guest_name, message, is_approved)
- **`rsvp_responses`** — تأكيد الحضور (event_id, guest_name, status, companions_count)

### ◆ ملاحظات على التصميم

- `custom_data` كـ JSON عشان كل template ممكن يحتاج data مختلفة (countdown / timeline / الخ)
- `config_schema` في templates بيحدد الـ fields اللي العميل هيملاها — بيخليك تضيف templates جديدة من غير تغيير كود
- `event_categories` جديدة عشان الأدمن يقدر يضيف أنواع مناسبات جديدة من الـ Admin Panel
- `style_tag` في templates عشان الفلترة (modern / chic / trendy / classic)
- الـ `subdomain` فريد لكل مناسبة — ده الرابط اللي العميل بيبعته للمعازيم

---

## ٤. كتالوج القوالب (Templates Catalog)

كل فئة مناسبة فيها **5 templates** بأفكار وألوان مختلفة — تنوع بين modern، chic، trendy، classic، romantic.

### ◆ فرح / زفاف (Wedding) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Romantic Scroll** | Romantic | Gold + Cream | موقع بـ parallax scrolling مع قصة حب timeline وحركات ورود متساقطة |
| 2 | **Elegant Affair** | Classic | Navy + Silver | تصميم أنيق بخطوط serif و fade-in sections |
| 3 | **Modern Minimal** | Modern | B&W + Accent | تصميم مينيماليست مع typography قوي و smooth transitions |
| 4 | **Floral Dream** | Chic | Blush + Sage | خلفيات زهور متحركة مع انيميشن day/night زي thedigitalyes |
| 5 | **Neon Vibes** | Trendy | Dark + Neon Pink | تصميم عصري بـ neon glow effects و glitch animations |

### ◆ خطوبة (Engagement) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Ring of Love** | Romantic | Rose Gold + White | انيميشن خاتم بيدور مع sparkle effect و countdown |
| 2 | **Rustic Charm** | Chic | Brown + Green | تصميم بوهو/رستيك بخلفيات خشب وأوراق شجر |
| 3 | **Clean & Classy** | Modern | White + Gold | تصميم نظيف بـ split-screen layout و scroll animations |
| 4 | **Vintage Love** | Classic | Sepia + Burgundy | فلتر صور vintage مع إطارات كلاسيكية متحركة |
| 5 | **Pop Art Ring** | Trendy | Colorful / Multi | تصميم pop art بألوان صارخة و comic-style animations |

### ◆ عيد ميلاد (Birthday) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Confetti Burst** | Trendy | Multi-color | انيميشن confetti بينزل لما الصفحة تفتح مع صوت احتفال |
| 2 | **Elegant Milestone** | Classic | Black + Gold | تصميم أنيق لأعياد الميلاد الكبيرة (30، 40، 50) |
| 3 | **Party Animals** | Trendy | Neon + Purple | تصميم روش بـ party animations و DJ vibes |
| 4 | **Sweet Pastel** | Chic | Pastel Pink + Mint | تصميم ناعم بألوان باستيل مع balloon animations |
| 5 | **Retro Arcade** | Modern | Pixel Green + Blue | تصميم رجعي pixel art بـ 8-bit animations |

### ◆ سبوع (Baby Shower / Seboua) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Little Star** | Chic | Baby Blue + Gold | نجوم متحركة مع twinkle effect و موسيقى هادية |
| 2 | **Baby Bloom** | Romantic | Soft Pink + Cream | زهور وفراشات متحركة مع reveal animation للاسم |
| 3 | **Teddy & Friends** | Classic | Warm Beige + Brown | تصميم كيوت برسومات دبادي متحركة |
| 4 | **Gender Reveal Pop** | Trendy | Pink + Blue split | تصميم gender reveal بـ balloon pop animation |
| 5 | **Cloud Nine** | Modern | Sky Blue + White | سحب متحركة مع parallax و تصميم هادي |

### ◆ حفلة تخرج (Graduation) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Cap Toss** | Trendy | Navy + Gold | انيميشن قبعات تخرج بتترمي في الهواء مع confetti |
| 2 | **Academic Glory** | Classic | Maroon + Cream | تصميم أكاديمي كلاسيكي بخطوط رسمية و إطارات ذهبية |
| 3 | **Future Starts Now** | Modern | White + Electric Blue | تصميم مستقبلي بـ gradient backgrounds و typewriter effect |
| 4 | **Boho Grad** | Chic | Terracotta + Olive | تصميم بوهو بأوراق شجر متحركة و earthy vibes |
| 5 | **Neon Grad Night** | Trendy | Black + Neon Multi | حفلة تخرج روشة بـ neon lights و party mode |

### ◆ أوتينج / تجمع (Outing) — 5 Templates

| # | الاسم | الستايل | الألوان | الفكرة |
|:---:|---|:---:|---|---|
| 1 | **Beach Vibes** | Trendy | Aqua + Sand | تصميم بحري بأمواج متحركة و palm tree animations |
| 2 | **Garden Party** | Chic | Green + Floral | حديقة متحركة بزهور وفراشات و fairy lights |
| 3 | **Adventure Call** | Modern | Orange + Dark Green | تصميم مغامرة بـ compass animation و map reveal |
| 4 | **Chill & Grill** | Trendy | Red + Yellow + Wood | تصميم BBQ/شواء برسومات متحركة و smoke effect |
| 5 | **City Lights** | Classic | Black + Amber | تصميم سهرة/خروجة بأضواء مدينة متحركة |

> **الإجمالي: 30 template (6 فئات × 5 templates) — والأدمن يقدر يضيف أكتر في أي وقت.**

---

## ٥. الوحدات الأساسية (Modules)

### ◆ Module 1: Admin Panel — لوحة تحكم الأدمن (Filament 3)

**▸ إدارة فئات المناسبات (Event Categories)**
- إضافة/تعديل/حذف فئات المناسبات (فرح، خطوبة، عيد ميلاد، سبوع، تخرج، أوتينج)
- تحديد `config_fields` لكل فئة (الحقول الخاصة)
- تفعيل/تعطيل أي فئة
- ترتيب الفئات في العرض

**▸ إدارة القوالب (Templates)**
- رفع template جديد (static أو website) مع ربطه بفئة المناسبة
- تحديد الـ `config_schema` لكل template (إيه الحقول اللي العميل يملاها)
- تحديد `style_tag` و `color_scheme` لكل template
- Preview للـ template قبل التفعيل
- تفعيل / تعطيل templates

**▸ إدارة المناسبات (Events)**
- عرض كل المناسبات المسجلة مع فلترة حسب الفئة والحالة
- موافقة أو رفض (لو محتاج moderation)
- إحصائيات: عدد الزيارات، عدد الرسائل، عدد تأكيدات الحضور

**▸ إدارة الخطط والأسعار (Plans)**
- **Free Tier:** دعوة static واحدة
- **Premium:** موقع + subdomain + guest book + RSVP
- **VIP:** كل حاجة + custom domain + أولوية الدعم

---

### ◆ Module 2: Customer Flow — مسار العميل

**المسار:**
> التسجيل → اختيار الفئة → اختيار الخطة → اختيار القالب → ملء البيانات → معاينة → الدفع → النشر → الحصول على الرابط

**▸ خطوات إنشاء المناسبة (Wizard)**

1. **اختيار نوع المناسبة** (فرح، خطوبة، عيد ميلاد، سبوع، تخرج، أوتينج)
2. **بيانات أساسية حسب الفئة** — الحقول بتيجي ديناميكي من `config_fields`
3. **اختيار القالب** — عرض كل القوالب المتاحة للفئة مع preview وفلترة حسب الـ style
4. **تخصيص** — رفع صور، رسالة ترحيبية، اختيار ألوان (حسب القالب) — **بطريقة سهلة زي WordPress**
5. **إعدادات الخصوصية** — كلمة المرور + التلميح
6. **المعاينة والنشر**

**▸ طريقة التعديل (WordPress-like Editing)**

العميل بيشوف **فورم ديناميكية** بتتولد تلقائي من `config_schema` الخاص بالـ template. كل field ليه نوعه:

| نوع الحقل | الوصف | مثال |
|---|---|---|
| `text` | نص قصير | اسم العريس |
| `textarea` | نص طويل | رسالة الترحيب |
| `image` | رفع صورة | صورة الخطوبة |
| `color` | اختيار لون | اللون الأساسي |
| `date` | تاريخ | تاريخ الفرح |
| `time` | وقت | وقت الحفلة |
| `location` | مكان + خريطة | عنوان القاعة |
| `select` | اختيار من قائمة | نوع الموسيقى |
| `toggle` | تفعيل/تعطيل | إظهار الـ RSVP |

العميل بيملا الفورم و**بيشوف live preview فوري** للتغييرات.

---

### ◆ Module 3: Static Card — الدعوة الثابتة (صورة)

صورة جاهزة بتتولد على السيرفر. الـ template بيبقى HTML/CSS بيتملي بالبيانات وبعدين بيتحول لصورة باستخدام Browsershot (headless Chrome).

- **Browsershot** لتحويل HTML لصورة — بيدعم الخطوط العربية الزخرفية بشكل ممتاز
- **Intervention Image** كبديل للتعديلات البسيطة
- الصورة بتتحفظ وبتبقى جاهزة للتحميل أو المشاركة
- توليد الصور بيتم في **Queued Job** عشان السرعة

---

### ◆ Module 4: Dynamic Website — الموقع الديناميكي

ده الجزء الأهم في المشروع — كل مناسبة بيبقى ليها موقع كامل على subdomain خاص.

**▸ Subdomain Routing**

```php
Route::domain('{subdomain}.farahna.com')
    ->middleware(['web', 'invitation.password'])
    ->group(function () {
        Route::get('/', [InvitationController::class, 'show']);
        Route::post('/wishes', [WishController::class, 'store']);
        Route::post('/rsvp', [RsvpController::class, 'store']);
    });
```

**▸ Password Protection Middleware**

لما حد يفتح الدعوة، لو فيها باسورد بيظهرله صفحة حلوة يكتب فيها الباسورد. لو غلط بيظهرله hint ظريف زي:

> *"مش ده! بس هنقولك سر صغير: الإجابة ليها علاقة بتاريخ أول لقاء 💕"*

وكل غلطة الـ hint بيبقى أوضح شوية — بيخلّي التجربة ممتعة مش محبطة.

**▸ أقسام الموقع الديناميكي (Sections)**

| Section | الوصف | الانيميشن |
|---|---|---|
| **Hero** | الأسماء + countdown timer | Split-text reveal + flip-clock countdown |
| **Story** | timeline لقصة المناسبة (اختياري) | SVG path drawing + staggered cards |
| **Event Details** | التاريخ والوقت والمكان + Google Maps | Typewriter + map drop animation |
| **Gallery** | معرض الصور | Staggered grid + lightbox (GSAP Flip) |
| **RSVP** | تأكيد الحضور | Form slide-up + morphing button |
| **Guest Book** | رسائل التمنيات | Flying cards + hover lift |
| **Footer** | معلومات إضافية + social links | Fade-in |

---

### ◆ Module 5: Guest Interaction — تفاعل المعازيم

**▸ Guest Book (دفتر التمنيات)**
- فورم بسيطة: اسم الضيف + رسالة
- الرسائل بتظهر بـ animation حلوة (cards بتطلع واحدة ورا التانية)
- ممكن يبقى في moderation: العميل لازم يوافق قبل ما الرسالة تظهر

**▸ RSVP (تأكيد الحضور)**
- اسم الضيف + هيحضر ولا لا + عدد المرافقين
- العميل يقدر يشوف dashboard بسيط فيه عدد المؤكدين
- Export لقائمة الحضور كـ CSV

---

## ٦. الحركات والتأثيرات البصرية (Animations & Visual Effects)

> **ده القسم الأهم في المشروع** — الـ animations هي اللي بتفرق المنصة عن أي منافس.
> مستوحاة من أفضل المواقع العالمية (thedigitalyes، invitelove، webgency) ومن أحدث trends في 2026.

---

### ◆ المكتبات المستخدمة

| المكتبة | الاستخدام | ليه؟ |
|---|---|---|
| **GSAP 3 + ScrollTrigger** | الأساسية لكل الأنيميشن | أقوى مكتبة على الويب — hardware-accelerated، 60fps، خفيفة (~50KB) |
| **Lottie.js** | رسومات متحركة (SVG) | قلوب، خواتم، ورود، confetti — بتتصدّر من After Effects |
| **Typed.js** | Typewriter effect | النصوص بتظهر حرف حرف زي الكتابة الحقيقية |
| **Particles.js** | Particle effects | قلوب/نجوم/ورود طايرة في الخلفية |
| **Canvas Confetti** | Confetti/Petals | انفجار confetti عند الأفراح والتخرج |
| **Howler.js** | Background Music | تشغيل موسيقى خلفية بشكل سلس مع تحكم كامل |
| **CSS3 Animations** | تأثيرات بسيطة | hover effects، transitions، keyframe animations |

---

### ◆ المرحلة ١: شاشة التحميل + الدخول (Loading & Entry)

أول حاجة الضيف بيشوفها لما يفتح اللينك. لازم تبقى مبهرة من أول ثانية.

#### 1. Loading Screen الأنيق

- شاشة تحميل بسيطة فيها اسم العروسين/صاحب المناسبة بيظهر بـ **fade-in** مع **progress bar أنيق**
- **Lottie animation** للـ loading (قلب بينبض، خاتم بيدور، بالونات بتطير — حسب الفئة)
- الشاشة بتختفي بـ **curtain reveal** (split screen بيفتح من النص) أو **fade-out** سلس
- الخلفية فيها **gradient متحرك** خفيف

```javascript
// GSAP Loading Screen
gsap.to('.loader', {
  yPercent: -100,
  duration: 0.8,
  ease: 'power4.inOut',
  onComplete: () => initPageAnimations()
});
```

#### 2. Envelope Opening Animation (مستوحى من invitelove "Связаны")

- الدعوة بتظهر كأنها **ظرف حقيقي مقفول** — اليوزر بيضغط "افتح"
- الظرف **بيفتح بـ 3D CSS transform** (الغطا بينقلب لفوق)
- الكارت **بيطلع من جوا الظرف** بـ slide-up + scale animation
- بعد ما الكارت يطلع، **بيعمل expand** ليملا الشاشة ويبدأ الموقع
- **Particles** (confetti/petals/stars) **بتنفجر** لحظة الفتح

```css
/* Envelope 3D Flip */
.envelope-flap {
  transform-origin: top center;
  transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  backface-visibility: hidden;
}
.envelope-flap.open {
  transform: rotateX(180deg);
}

/* Card Rising from Envelope */
.invitation-card {
  transition: transform 1.2s cubic-bezier(0.22, 1, 0.36, 1);
}
.invitation-card.revealed {
  transform: translateY(-120%) scale(1.1);
}
```

#### 3. Password Screen (مستوحى من invitelove + thedigitalyes)

- صفحة باسورد بتصميم حلو — الخلفية فيها **particles خفيفة** (قلوب/نجوم)
- حقل الباسورد بـ **custom styling** مع placeholder animation
- لما يكتب الباسورد صح:
  - الصفحة بتعمل **dissolve/shatter effect** — الشاشة بتتكسر زي الزجاج وبتكشف الدعوة
  - أو **circle expand** — دايرة بتكبر من النص لحد ما تكشف الصفحة
- لما يغلط:
  - **shake animation** للفورم (الفورم بتتهز)
  - الـ hint بيظهر بـ **typewriter effect**
  - كل محاولة غلط الـ hint بيبقى أوضح — تجربة playful مش محبطة

```javascript
// Password Shake on Wrong
gsap.to('.password-form', {
  x: [-10, 10, -8, 8, -5, 5, 0],
  duration: 0.5,
  ease: 'power2.inOut'
});

// Dissolve Effect on Correct
gsap.to('.lock-screen', {
  clipPath: 'circle(150% at 50% 50%)',
  duration: 1.2,
  ease: 'power3.inOut'
});
```

---

### ◆ المرحلة ٢: Hero Section الرئيسي

أول حاجة بعد الدخول — لازم تبقى **cinematic**.

#### 4. انيميشن الأسماء (Names Reveal)

- الأسماء بتظهر بـ **split-text animation** — كل حرف بيظهر لوحده بـ stagger
- أو **fade-in + slide-up** مع **blur-to-clear transition**
- بين الاسمين: رمز (قلب / & / خاتم) بيظهر بـ **scale bounce**
- الخط بيبقى **decorative** وكبير — بيدي إحساس بالفخامة

```javascript
// Split Text Names Reveal
gsap.from('.hero-name', {
  opacity: 0,
  y: 80,
  filter: 'blur(10px)',
  duration: 1.2,
  stagger: 0.3,
  ease: 'power3.out'
});

// Heart Symbol Pop
gsap.from('.heart-symbol', {
  scale: 0,
  rotation: -180,
  duration: 0.8,
  ease: 'back.out(1.7)',
  delay: 0.8
});
```

#### 5. Countdown Timer

3 أنماط مختلفة حسب الـ template:

- **Flip-clock style:** الأرقام بتتقلب زي ساعة المطار (3D flip animation)
- **Circular progress:** دوائر SVG بتتحرك حوالين الأرقام
- **Minimal morphing:** أرقام بتتغير بـ number morphing animation (العدد القديم بيتحول smooth للجديد)

```javascript
// Flip Clock Animation
function flipDigit(element, newValue) {
  gsap.to(element, {
    rotateX: -90,
    duration: 0.3,
    onComplete: () => {
      element.textContent = newValue;
      gsap.fromTo(element,
        { rotateX: 90 },
        { rotateX: 0, duration: 0.3, ease: 'power2.out' }
      );
    }
  });
}
```

#### 6. Floating Particles Background

- حسب الفئة: **قلوب** للفرح، **نجوم** للسبوع، **confetti** للعيد، **قبعات** للتخرج
- Particles.js بتولد particles عشوائية **بتطفو ببطء**
- الـ particles **بتتفاعل مع حركة الماوس** (repel/attract)
- خفيفة على الموبايل — **بتقلل العدد تلقائي** على الشاشات الصغيرة (max 15 بدل 50)

```javascript
// Responsive Particles
const isMobile = window.innerWidth < 768;
particlesJS('particles', {
  particles: {
    number: { value: isMobile ? 15 : 50 },
    shape: { type: 'image', src: '/assets/heart.svg' },
    opacity: { value: 0.6, random: true },
    size: { value: isMobile ? 8 : 15, random: true },
    move: { speed: 1, direction: 'none', random: true }
  },
  interactivity: {
    events: {
      onhover: { enable: !isMobile, mode: 'repulse' }
    }
  }
});
```

---

### ◆ المرحلة ٣: Scroll Animations (الأهم!)

دي الحاجة اللي بتخلي الدعوة تحس إنها **تجربة** مش مجرد صفحة. كل section بيظهر لما اليوزر يوصله.

#### 7. Section Reveal Animations

3 أنماط مختلفة (كل template بيستخدم واحد):

- **Fade-in + Slide-up:** كل section بيظهر من تحت بـ `opacity: 0 → 1` و `y: 60px → 0`
- **Clip-path reveal:** الـ section بيظهر زي ما حد بيكشف ستارة (`circle expand` أو `wipe effect`)
- **Scale + blur:** العنصر بيبدأ صغير و blurry وبيكبر لحجمه الطبيعي وهو بيوضح

```javascript
// ScrollTrigger - Section Reveals
gsap.utils.toArray('.section').forEach(section => {
  gsap.from(section, {
    scrollTrigger: {
      trigger: section,
      start: 'top 85%',
      end: 'top 20%',
      toggleActions: 'play none none reverse'
    },
    opacity: 0,
    y: 60,
    duration: 1,
    ease: 'power2.out'
  });
});

// Clip-path Reveal Variant
gsap.from('.section-clip', {
  scrollTrigger: { trigger: '.section-clip', start: 'top 80%' },
  clipPath: 'circle(0% at 50% 50%)',
  duration: 1.5,
  ease: 'power3.inOut'
});
```

#### 8. Parallax Scrolling (مستوحى من thedigitalyes minimalist)

- الصور الخلفية **بتتحرك أبطأ** من المحتوى الأمامي — بيدي إحساس بالعمق
- العناصر الزخرفية (زهور، أوراق، نجوم) **بتتحرك بسرعات مختلفة**
- **Multi-layer parallax:** 3-4 طبقات بتتحرك بسرعات مختلفة = إحساس سينمائي
- مهم: على الموبايل **بيتقلل الـ parallax** عشان الأداء

```javascript
// Multi-layer Parallax
gsap.utils.toArray('[data-parallax]').forEach(el => {
  const speed = el.dataset.parallax || 0.5;
  gsap.to(el, {
    yPercent: speed * 30,
    ease: 'none',
    scrollTrigger: {
      trigger: el.parentElement,
      start: 'top bottom',
      end: 'bottom top',
      scrub: true
    }
  });
});

// Decorative Elements Float
gsap.to('.floating-flower', {
  y: -100,
  rotation: 15,
  scrollTrigger: {
    trigger: '.hero',
    start: 'top top',
    end: 'bottom top',
    scrub: 1
  }
});
```

#### 9. Staggered Gallery (مستوحى من invitelove "Связаны")

- الصور **بتظهر واحدة ورا التانية** بـ `stagger: 0.15s` لكل صورة
- كل صورة بتظهر بـ `scale(0.8) → scale(1)` + `opacity: 0 → 1`
- لما تضغط على صورة: **lightbox بيفتح بـ GSAP Flip animation** (الصورة بتكبر من مكانها لملء الشاشة)
- **Swipe navigation** جوا الـ lightbox على الموبايل
- Masonry/grid layout responsive

```javascript
// Staggered Gallery Reveal
gsap.from('.gallery-item', {
  scrollTrigger: {
    trigger: '.gallery',
    start: 'top 80%'
  },
  scale: 0.8,
  opacity: 0,
  duration: 0.6,
  stagger: {
    each: 0.15,
    grid: 'auto',
    from: 'start'
  },
  ease: 'power2.out'
});

// Lightbox with GSAP Flip
function openLightbox(img) {
  const state = Flip.getState(img);
  lightbox.appendChild(img);
  Flip.from(state, {
    duration: 0.6,
    ease: 'power2.inOut',
    absolute: true
  });
}
```

#### 10. Timeline/Story Section Animation

- كل حدث في الـ timeline **بيظهر بـ alternating sides** (left/right)
- خط رأسي في النص **بيترسم لما اليوزر بينزل** (SVG path drawing animation)
- كل milestone **بيظهر بـ slide-in** من الجنب + **dot/icon بيعمل pop**
- الصور جوا الـ timeline **بتظهر بـ Ken Burns effect** (زوم بطيء)

```javascript
// SVG Path Drawing
gsap.from('.timeline-line', {
  scrollTrigger: {
    trigger: '.timeline',
    start: 'top 60%',
    end: 'bottom 40%',
    scrub: 1
  },
  strokeDashoffset: 1000,
  ease: 'none'
});

// Alternating Timeline Items
gsap.utils.toArray('.timeline-item').forEach((item, i) => {
  const fromX = i % 2 === 0 ? -80 : 80;
  gsap.from(item, {
    scrollTrigger: { trigger: item, start: 'top 80%' },
    x: fromX,
    opacity: 0,
    duration: 0.8,
    ease: 'power2.out'
  });
});
```

#### 11. Event Timeline اليوم (مستوحى من webgency template2)

- جدول اليوم (reception → ceremony → dinner) كل خطوة **بتظهر بالترتيب**
- كل خطوة فيها **icon متحرك (Lottie)** + وقت + وصف
- خط رأسي **بيترسم تدريجي** بين الخطوات
- الخطوة الحالية **بتبقى highlighted** بـ glow effect

---

### ◆ المرحلة ٤: العناصر التفاعلية (Interactive Elements)

#### 12. RSVP Form Animation

- الفورم **بتظهر بـ slide-up** + الحقول **بتظهر واحد ورا التاني** بـ stagger
- لما يضغط submit: الزرار **بيعمل morphing** لـ checkmark + confetti بسيط
- Radio buttons بـ **custom animation** لما يختار "هحضر" — الخلفية بتتغير لونها بسلاسة
- **Success state:** رسالة شكر بـ **Lottie celebration animation**

```javascript
// Submit Button Morphing
function onSubmit() {
  gsap.to('.submit-btn', {
    width: 50, height: 50, borderRadius: '50%',
    duration: 0.3,
    onComplete: () => {
      document.querySelector('.submit-btn').innerHTML = '✓';
      gsap.from('.submit-btn', { scale: 0, duration: 0.3, ease: 'back.out' });
      confetti({ particleCount: 50, spread: 60 });
    }
  });
}
```

#### 13. Guest Book / Wishes

- الرسائل بتظهر كـ **cards بتطير من تحت** واحدة ورا التانية
- كل card فيها **hover effect:** slight lift + shadow (زي invitelove)
- لما تبعت رسالة جديدة: **الكارت بيظهر بـ pop animation** في الأول
- اختياري: الرسائل بتطير **زي بالونات** (للعيد والسبوع)

#### 14. Map Section

- Google Maps embed **بيظهر بـ slide-in** + المار كر بيعمل **drop animation**
- زرار "افتح في خرائط جوجل" بـ **hover glow effect**
- العنوان **بيظهر بـ typewriter effect**

---

### ◆ المرحلة ٥: تأثيرات خاصة (Special Effects per Category)

#### 15. Day/Night Transition (مستوحى من thedigitalyes daynight)

- الموقع **بيبدأ بنهار** ولما اليوزر ينزل **بيتحول لليل**
- الخلفية بتتحول من **سماء زرقاء → سماء برتقالية (sunset) → سماء غامقة بنجوم**
- العناصر الزخرفية **بتتغير** (شمس → قمر، فراشات → نجوم)
- CSS gradient animation + GSAP ScrollTrigger للتحول التدريجي

```javascript
// Day/Night Scroll Transition
gsap.to('.sky-gradient', {
  scrollTrigger: {
    trigger: '.page-wrapper',
    start: 'top top',
    end: 'bottom bottom',
    scrub: 1
  },
  background: 'linear-gradient(180deg, #0a1628 0%, #1a1a3e 50%, #2d1b4e 100%)',
  ease: 'none'
});

// Sun to Moon Morph
gsap.to('.celestial-body', {
  scrollTrigger: { trigger: '.mid-section', start: 'top center', scrub: 1 },
  morphSVG: '.moon-shape',
  fill: '#f0e68c'
});
```

#### 16. Confetti/Petals Burst

**حسب الفئة:**

| الفئة | التأثير | التفاصيل |
|---|---|---|
| **فرح** | 🌸 ورود بتتساقط | CSS petals falling بـ random rotation + drift |
| **خطوبة** | ✨ Sparkles | نقاط مضيئة بتظهر وبتختفي |
| **عيد ميلاد** | 🎊 Confetti burst | انفجار من أسفل الشاشة بألوان متعددة |
| **سبوع** | 🦋 فراشات + نجوم | فراشات بتطير + نجوم بتلمع |
| **تخرج** | 🎓 قبعات + confetti | قبعات بتترمي في الهواء مع confetti |
| **أوتينج** | 🍃 أوراق شجر | أوراق بتطير مع الريح |

```javascript
// Category-specific Particle Config
const particleConfig = {
  wedding:    { shape: 'petal',     color: ['#ffb6c1', '#fff0f5'], count: 30 },
  engagement: { shape: 'sparkle',   color: ['#ffd700', '#fff8dc'], count: 25 },
  birthday:   { shape: 'confetti',  color: ['#ff6b6b', '#4ecdc4', '#ffd93d'], count: 60 },
  seboua:     { shape: 'butterfly', color: ['#87ceeb', '#ffb6c1'], count: 20 },
  graduation: { shape: 'cap',       color: ['#1a1a2e', '#ffd700'], count: 40 },
  outing:     { shape: 'leaf',      color: ['#2d5016', '#90b77d'], count: 20 }
};
```

#### 17. Background Music System

- زرار play/mute **أنيق ثابت في الزاوية** — بينبض بـ pulse animation لما الموسيقى شغالة
- الموسيقى **بتبدأ بعد أول تفاعل** من اليوزر (عشان autoplay restrictions)
- **Fade-in بطيء** للموسيقى + fade-out لما يضغط mute
- **Howler.js** لتحكم كامل في الصوت و cross-browser support
- الموسيقى **خفيفة** على الـ bandwidth (MP3 128kbps, max 2MB)

```javascript
// Music Controller
const music = new Howl({
  src: ['/audio/romantic-piano.mp3'],
  loop: true,
  volume: 0
});

function playMusic() {
  music.play();
  music.fade(0, 0.5, 2000); // Fade in over 2 seconds
}

function toggleMute() {
  if (music.playing()) {
    music.fade(0.5, 0, 500);
    setTimeout(() => music.pause(), 500);
  } else {
    playMusic();
  }
}
```

#### 18. Neon Glow Effects (للـ templates الـ Trendy)

- CSS `text-shadow` + `box-shadow` بـ **pulsing glow**
- النصوص بتبقى مضيئة زي النيون بـ **flickering animation خفيف**
- الأزرار فيها **glow hover effect**
- مثالي لـ: Neon Vibes (wedding) + Party Animals (birthday) + Neon Grad Night

```css
/* Neon Glow Text */
.neon-text {
  text-shadow:
    0 0 7px #fff,
    0 0 10px #fff,
    0 0 21px #fff,
    0 0 42px #ff00de,
    0 0 82px #ff00de,
    0 0 92px #ff00de;
  animation: neon-flicker 3s infinite alternate;
}

@keyframes neon-flicker {
  0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; }
  20%, 24%, 55% { opacity: 0.8; }
}
```

#### 19. Scroll Progress Indicator

- شريط رفيع في أعلى الصفحة **بيتملا** كل ما اليوزر ينزل
- أو **نقاط navigation** على الجنب (dot navigation) بتوري اليوزر فين هو
- النقطة الحالية بتعمل **scale + glow**
- ممكن يبقى مخفي على الموبايل عشان المساحة

```javascript
// Scroll Progress Bar
gsap.to('.progress-bar', {
  scaleX: 1,
  ease: 'none',
  scrollTrigger: {
    trigger: 'body',
    start: 'top top',
    end: 'bottom bottom',
    scrub: 0.3
  }
});
```

#### 20. Micro-interactions الإضافية

- **Hover effects** على كل العناصر التفاعلية (أزرار، صور، لينكات)
- **Smooth scroll** بين الأقسام (Lenis/GSAP ScrollSmoother)
- **Cursor effects** على الديسكتوب (custom cursor يتغير حسب العنصر)
- **Page transition** لما ينتقل بين أقسام (fade/slide)
- **Loading skeleton** للمحتوى اللي لسه بيحمل

---

### ◆ المرحلة ٦: تحسينات الموبايل (Mobile-First Performance)

> **أغلب الضيوف هيفتحوا الدعوة من الموبايل. الأداء السريع أولوية قصوى.**

| القاعدة | التفاصيل |
|---|---|
| `prefers-reduced-motion` | احترام إعدادات اليوزر — لو فاتح تقليل الحركة، الـ animations بتبقى أبسط |
| **Lazy loading** | الصور مبتحملش غير لما اليوزر يقرب منها |
| **GPU-accelerated only** | `transform` و `opacity` بس — منعملش animate على width/height/margin |
| `will-change` | للعناصر المتحركة عشان البراوزر يجهزها |
| **Particles count** | على الموبايل max 15-20 particle بدل 50+ على الديسكتوب |
| **GSAP matchMedia** | animations مختلفة للموبايل والديسكتوب |
| **IntersectionObserver** | بدل scroll events عشان الأداء |
| **Image optimization** | WebP + srcset لأحجام مختلفة |

---

### ◆ خريطة الـ Animations لكل فئة

| الفئة | Entry Effect | Particles | Special Effect | Music Mood |
|---|---|---|---|---|
| **فرح** | Envelope + Petals | قلوب + ورود | Day/Night transition | Romantic piano |
| **خطوبة** | Ring spin + Sparkle | Sparkles + Stars | Ring reveal animation | Soft acoustic |
| **عيد ميلاد** | Balloon pop + Confetti | Confetti + Balloons | Candle blow animation | Upbeat/party |
| **سبوع** | Cloud reveal | Stars + Butterflies | Gender reveal pop | Lullaby/gentle |
| **تخرج** | Cap toss + Confetti | Caps + Confetti | Diploma unroll | Triumphant/epic |
| **أوتينج** | Map unfold | Leaves + Waves | Compass animation | Chill/beach vibes |

---

### ◆ Performance Budget

| العنصر | الحد الأقصى | ملاحظات |
|---|---|---|
| GSAP Core + ScrollTrigger | ~50KB gzipped | أصغر من React! |
| Lottie animations | ~30KB per animation | Lazy load |
| Particles.js | ~20KB gzipped | Canvas-based |
| Howler.js | ~10KB gzipped | Audio only if enabled |
| **إجمالي JS** | **< 150KB gzipped** | مقارنة بأي فريمورك تاني |
| **First Load (Mobile 3G)** | **< 2 ثانية** | الهدف الرئيسي |
| **Lighthouse Score** | **> 90/100** | Performance + Accessibility |
| **Total Page Weight** | **< 500KB** | First load بدون الصور |

---

## ٧. هيكل القوالب (Templates Structure)

### ◆ Static Templates (صور)

```
resources/templates/static/{category}/{template-name}/
├── template.blade.php    ← HTML/CSS اللي بيتحول لصورة
├── thumbnail.jpg          ← الصورة اللي بتظهر في الاختيار
└── config.json            ← الحقول المطلوبة
```

### ◆ Website Templates (مواقع ديناميكية)

```
resources/templates/website/{category}/{template-name}/
├── index.blade.php        ← الصفحة الرئيسية
├── locked.blade.php       ← صفحة الباسورد
├── sections/              ← أقسام منفصلة (hero, story, gallery...)
│   ├── hero.blade.php
│   ├── story.blade.php
│   ├── details.blade.php
│   ├── gallery.blade.php
│   ├── rsvp.blade.php
│   └── guestbook.blade.php
├── assets/
│   ├── style.css          ← Tailwind + custom styles
│   ├── animations.js      ← GSAP animations
│   └── lottie/            ← Lottie JSON files
├── thumbnail.jpg
└── config.json
```

### ◆ مثال config.json

```json
{
  "name": "Romantic Scroll",
  "category": "wedding",
  "type": "website",
  "style": "romantic",
  "colors": {
    "primary": "#c5943a",
    "secondary": "#fff8f0",
    "accent": "#d4756b",
    "text": "#2e2e2e"
  },
  "fields": [
    { "key": "groom_name", "label": "اسم العريس", "type": "text", "required": true },
    { "key": "bride_name", "label": "اسم العروسة", "type": "text", "required": true },
    { "key": "event_date", "label": "تاريخ الفرح", "type": "date", "required": true },
    { "key": "event_time", "label": "الوقت", "type": "time", "required": true },
    { "key": "venue_name", "label": "اسم القاعة", "type": "text", "required": true },
    { "key": "venue_address", "label": "العنوان", "type": "location", "required": true },
    { "key": "hero_image", "label": "صورة رئيسية", "type": "image", "required": false },
    { "key": "gallery", "label": "صور المعرض", "type": "image_multiple", "max": 10 },
    { "key": "welcome_message", "label": "رسالة الترحيب", "type": "textarea", "required": false },
    { "key": "story_enabled", "label": "قصة الحب", "type": "toggle", "default": false },
    { "key": "music_url", "label": "رابط الموسيقى", "type": "text", "required": false },
    { "key": "primary_color", "label": "اللون الأساسي", "type": "color", "default": "#c5943a" },
    { "key": "enable_rsvp", "label": "تفعيل RSVP", "type": "toggle", "default": true },
    { "key": "enable_guestbook", "label": "تفعيل Guest Book", "type": "toggle", "default": true }
  ],
  "animations": {
    "entry": "envelope",
    "particles": "petals",
    "special": "day_night"
  }
}
```

---

## ٨. خطة التنفيذ (Implementation Timeline)

| الأسبوع | المهمة | التفاصيل |
|:---:|---|---|
| **1-2** | Setup + Database + Auth | Laravel setup, DB schema, multi-tenancy, Filament admin |
| **3-4** | Admin Panel + Categories | إدارة فئات المناسبات + Templates CRUD + Config Schema Builder |
| **5-6** | Customer Wizard + Template Engine | مسار العميل + Dynamic Form Builder + Live Preview |
| **7-8** | Static Cards + Dynamic Websites | Browsershot integration + Subdomain routing + Password system |
| **9-10** | Animations + First 10 Templates | GSAP animations, scroll effects, بناء أول 10 templates (فرح + خطوبة) |
| **11-12** | باقي الـ 20 Template + Testing | إكمال الـ 30 template + Guest interactions + RSVP + Payment |
| **13-14** | Polish + Deploy | Performance optimization, caching, deployment, monitoring |

> **الإجمالي المتوقع: حوالي 14 أسبوع للـ MVP الكامل بكل الـ 30 template.**

---

## ٩. استراتيجية التسعير (Monetization)

| الميزة | Free | Premium | VIP |
|---|:---:|:---:|:---:|
| Static Card | ✓ (واحدة) | ✓ (غير محدود) | ✓ (غير محدود) |
| Dynamic Website | ✗ | ✓ | ✓ |
| Subdomain | ✗ | ✓ | ✓ + Custom Domain |
| Guest Book | ✗ | ✓ | ✓ |
| RSVP | ✗ | ✓ | ✓ |
| Background Music | ✗ | ✓ | ✓ |
| Password Protection | ✗ | ✓ | ✓ |
| Custom Colors | ✗ | ✓ | ✓ |
| Analytics Dashboard | ✗ | Basic | Full |
| أولوية الدعم | ✗ | ✗ | ✓ |

---

## ١٠. أفكار إضافية

### 1. QR Code Generator
لكل دعوة يتولد QR Code تلقائي. العميل يطبعه على كروت ورقية أو يبعته. بيربط الـ offline بالـ online.

### 2. WhatsApp Share مع Preview محسّن
باستخدام Open Graph tags لما حد يبعت لينك الدعوة على WhatsApp يظهر preview حلو بالصورة والأسماء.

### 3. Background Music
العميل يختار موسيقى خفيفة تشتغل في الخلفية (مع زرار mute). بيضيف طبقة عاطفية للتجربة.

### 4. Live Countdown Widget
Widget صغير العميل يعمله embed في أي مكان (Facebook, Instagram bio) بيعرض countdown. بيشتغل كـ marketing tool مجاني.

### 5. Save the Date Reminder
المعازيم يضغطوا زرار فيضيف المناسبة على Google/Apple Calendar تلقائي.

### 6. Multi-language Support ✨
دعم عربي/إنجليزي لكل template — العميل يختار اللغة والاتجاه (RTL/LTR) بيتظبط تلقائي.

### 7. Analytics Dashboard ✨
العميل يشوف إحصائيات: عدد الزيارات، مصدر الزيارات، عدد الـ RSVP، عدد الرسائل.

### 8. Template Preview Marketplace ✨
صفحة عامة فيها كل الـ templates بـ live preview — الزوار يقدروا يتصفحوا ويختاروا قبل التسجيل.

---

## ١١. ملاحظات النشر (Deployment)

| البند | التفاصيل |
|---|---|
| **Wildcard DNS** | ضبط `*.farahna.com` يشاور على السيرفر |
| **SSL** | Let's Encrypt مع wildcard certificate |
| **Server** | VPS على DigitalOcean أو Hetzner — إدارة بـ Laravel Forge |
| **CDN** | Cloudflare لتسريع تحميل الصور والـ assets |
| **Caching** | Redis للـ session + cache + queue |
| **Image Storage** | S3-compatible (DigitalOcean Spaces أو Cloudflare R2) |
| **Backup** | يومي للـ database والصور |
| **Monitoring** | Laravel Telescope للـ dev + Sentry للـ production |
| **CI/CD** | GitHub Actions للـ auto deploy |

---

<p align="center">✦ نهاية الوثيقة ✦</p>
