<div>
    {{-- ─── Wizard Header ─── --}}
    <div style="background:#fff; border-bottom:1px solid #e7e5e4; padding:1.5rem;">
        <div style="max-width:700px; margin:0 auto;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem;">
                <h1 style="font-family:'Playfair Display',serif; font-size:1.4rem; color:#e11d48;">إنشاء دعوتك ♥</h1>
                <span style="color:#78716c; font-size:.875rem;">الخطوة {{ $step }} من {{ $totalSteps }}</span>
            </div>

            {{-- Progress Steps --}}
            <div style="display:flex; gap:.5rem; align-items:center;">
                @foreach (['نوع المناسبة', 'اختر الباقة', 'اختر القالب', 'تفاصيل المناسبة', 'النشر'] as $i => $label)
                    @php $num = $i + 1; @endphp
                    <div wire:click="goToStep({{ $num }})"
                         style="display:flex; align-items:center; gap:.4rem; cursor:{{ $num < $step ? 'pointer' : 'default' }}; flex:1;">
                        <div style="
                            width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center;
                            font-size:.8rem; font-weight:600; flex-shrink:0;
                            background:{{ $step > $num ? '#e11d48' : ($step === $num ? '#fff1f2' : '#f5f5f4') }};
                            color:{{ $step > $num ? '#fff' : ($step === $num ? '#e11d48' : '#a8a29e') }};
                            border:2px solid {{ $step >= $num ? '#e11d48' : '#e7e5e4' }};
                        ">
                            @if($step > $num) ✓ @else {{ $num }} @endif
                        </div>
                        <span style="font-size:.75rem; color:{{ $step === $num ? '#e11d48' : '#78716c' }}; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:60px;">
                            {{ $label }}
                        </span>
                        @if($i < 4)
                            <div style="flex:1; height:2px; background:{{ $step > $num ? '#e11d48' : '#e7e5e4' }}; margin:0 .25rem;"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ─── Step Content ─── --}}
    <div style="max-width:700px; margin:2rem auto; padding:0 1.5rem;">

        {{-- STEP 1: Choose Category --}}
        @if($step === 1)
            <h2 style="font-size:1.2rem; font-weight:700; margin-bottom:.5rem;">ما نوع مناسبتك؟</h2>
            <p style="color:#78716c; font-size:.9rem; margin-bottom:1.5rem;">اختر النوع وسنعرض لك القوالب المناسبة</p>

            @error('selectedCategory')
                <div style="background:#fff1f2; border:1px solid #fda4af; color:#be123c; padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:.875rem;">{{ $message }}</div>
            @enderror

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px,1fr)); gap:1rem;">
                @foreach(\App\Enums\EventCategory::cases() as $cat)
                    <div wire:click="selectCategory('{{ $cat->value }}')"
                         style="
                            padding:1.75rem 1rem; border-radius:14px; cursor:pointer;
                            text-align:center; transition:all .2s;
                            border:2px solid {{ $selectedCategory === $cat->value ? '#e11d48' : '#e7e5e4' }};
                            background:{{ $selectedCategory === $cat->value ? '#fff1f2' : '#fff' }};
                            box-shadow:{{ $selectedCategory === $cat->value ? '0 4px 12px rgba(225,29,72,.15)' : '0 1px 3px rgba(0,0,0,.05)' }};
                            transform:{{ $selectedCategory === $cat->value ? 'translateY(-2px)' : 'none' }};
                         ">
                        <div style="font-size:2.5rem; margin-bottom:.6rem; line-height:1;">{{ $cat->icon() }}</div>
                        <p style="font-weight:700; font-size:.9rem; color:{{ $selectedCategory === $cat->value ? '#e11d48' : '#1c1917' }};">
                            {{ $cat->label() }}
                        </p>
                    </div>
                @endforeach
            </div>

        {{-- STEP 2: Choose Plan --}}
        @elseif($step === 2)
            <h2 style="font-size:1.2rem; font-weight:700; margin-bottom:1.5rem;">اختر الباقة المناسبة</h2>

            @error('selectedPlanId')
                <div style="background:#fff1f2; border:1px solid #fda4af; color:#be123c; padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:.875rem;">{{ $message }}</div>
            @enderror

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:1rem;">
                @foreach($this->plans as $plan)
                    <div wire:click="selectPlan({{ $plan->id }})"
                         style="
                            padding:1.5rem; border-radius:12px; cursor:pointer; transition:all .2s;
                            border:2px solid {{ $selectedPlanId === $plan->id ? '#e11d48' : '#e7e5e4' }};
                            background:{{ $selectedPlanId === $plan->id ? '#fff1f2' : '#fff' }};
                         ">
                        <div style="font-size:1.5rem; margin-bottom:.75rem;">
                            {{ $plan->isFree() ? '🆓' : ($plan->price <= 200 ? '⭐' : '👑') }}
                        </div>
                        <h3 style="font-weight:700; margin-bottom:.25rem;">{{ $plan->name }}</h3>
                        <p style="font-size:1.2rem; color:#e11d48; font-weight:700; margin-bottom:.75rem;">
                            {{ $plan->isFree() ? 'مجاني' : number_format($plan->price) . ' ج.م' }}
                        </p>
                        @if($plan->features)
                            <ul style="list-style:none; font-size:.8rem; color:#78716c; line-height:1.8;">
                                @foreach($plan->features as $key => $val)
                                    <li>{{ $val === 'true' ? '✓' : '✗' }} {{ str_replace('_', ' ', $key) }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>

        {{-- STEP 3: Choose Template --}}
        @elseif($step === 3)
            <h2 style="font-size:1.2rem; font-weight:700; margin-bottom:1.5rem;">اختر القالب</h2>

            @error('selectedTemplateId')
                <div style="background:#fff1f2; border:1px solid #fda4af; color:#be123c; padding:.75rem 1rem; border-radius:8px; margin-bottom:1rem; font-size:.875rem;">{{ $message }}</div>
            @enderror

            @if($this->templates->isEmpty())
                <div style="text-align:center; padding:3rem; color:#78716c;">
                    <div style="font-size:3rem; margin-bottom:1rem;">🎨</div>
                    <p>لا توجد قوالب متاحة لهذه الباقة حتى الآن.</p>
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:1rem;">
                    @foreach($this->templates as $template)
                        <div wire:click="selectTemplate({{ $template->id }})"
                             style="
                                border-radius:12px; overflow:hidden; cursor:pointer; transition:all .2s;
                                border:3px solid {{ $selectedTemplateId === $template->id ? '#e11d48' : '#e7e5e4' }};
                             ">
                            <div style="height:140px; background:linear-gradient(135deg,#fff1f2,#fce7f3); display:flex; align-items:center; justify-content:center;">
                                @if($template->thumbnail)
                                    <img src="{{ Storage::url($template->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size:3rem;">💌</span>
                                @endif
                            </div>
                            <div style="padding:.75rem; background:#fff;">
                                <p style="font-weight:600; font-size:.9rem;">{{ $template->name }}</p>
                                <span style="font-size:.75rem; color:#78716c;">{{ $template->type->label() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        {{-- STEP 4: Event Details --}}
        @elseif($step === 4)
            @php
                $cat = \App\Enums\EventCategory::from($selectedCategory);
                [$primaryLabel, $secondaryLabel] = $cat->nameLabels();
            @endphp
            <h2 style="font-size:1.2rem; font-weight:700; margin-bottom:1.5rem;">تفاصيل المناسبة</h2>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group" style="{{ $cat->isCoupleEvent() ? '' : 'grid-column:1/-1;' }}">
                    <label class="form-label">{{ $primaryLabel }}</label>
                    <input type="text" class="form-input" wire:model="groomName" placeholder="{{ $cat->primaryPlaceholder() }}">
                    @error('groomName') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                @if($cat->isCoupleEvent())
                <div class="form-group">
                    <label class="form-label">{{ $secondaryLabel }}</label>
                    <input type="text" class="form-input" wire:model="brideName" placeholder="مثال: سارة">
                    @error('brideName') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">تاريخ المناسبة</label>
                    <input type="date" class="form-input" wire:model="eventDate">
                    @error('eventDate') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">الوقت <span style="color:#a8a29e;">(اختياري)</span></label>
                    <input type="time" class="form-input" wire:model="eventTime">
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">اسم المكان / القاعة</label>
                    <input type="text" class="form-input" wire:model="venueName" placeholder="مثال: قاعة الأميرة - فندق الشيراتون">
                    @error('venueName') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">العنوان <span style="color:#a8a29e;">(اختياري)</span></label>
                    <input type="text" class="form-input" wire:model="venueAddress" placeholder="العنوان التفصيلي">
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">رابط الخريطة <span style="color:#a8a29e;">(اختياري)</span></label>
                    <input type="url" class="form-input" wire:model="venueMapLink" placeholder="https://maps.google.com/...">
                </div>

                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">🎵 موسيقى خلفية <span style="color:#a8a29e;">(اختياري — رابط MP3)</span></label>
                    <input type="url" class="form-input" wire:model="musicUrl" placeholder="https://example.com/song.mp3">
                    <p style="font-size:12px; color:#a8a29e; margin-top:4px;">سيظهر زر تشغيل عائم في الدعوة الإلكترونية</p>
                </div>
            </div>

        {{-- STEP 5: Publish Settings --}}
        @elseif($step === 5)
            <h2 style="font-size:1.2rem; font-weight:700; margin-bottom:1.5rem;">إعدادات النشر</h2>

            <div class="card" style="margin-bottom:1rem;">
                <h3 style="font-weight:600; margin-bottom:1rem; color:#44403c;">الرابط</h3>
                <div class="form-group">
                    <label class="form-label">
                        Subdomain
                        <span style="color:#a8a29e; font-size:.8rem;">(فقط للباقات المدفوعة)</span>
                    </label>
                    <div style="display:flex; align-items:center; gap:.5rem;">
                        <input type="text" class="form-input" wire:model.live="subdomain"
                               placeholder="ahmed-and-sara"
                               style="flex:1;"
                               {{ $this->selectedPlan?->isFree() ? 'disabled' : '' }}>
                        <span style="color:#78716c; font-size:.875rem; white-space:nowrap;">.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</span>
                    </div>
                    @error('subdomain') <p class="form-error">{{ $message }}</p> @enderror
                    @if($subdomain)
                        <p style="margin-top:.4rem; font-size:.8rem; color:#16a34a;">
                            ✓ سيكون رابطك: <strong>{{ $subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="card" style="margin-bottom:1rem;">
                <h3 style="font-weight:600; margin-bottom:1rem; color:#44403c;">حماية بكلمة مرور</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label class="form-label">كلمة المرور <span style="color:#a8a29e;">(اختياري)</span></label>
                        <input type="password" class="form-input" wire:model="password" placeholder="اتركها فارغة إذا لا تريد">
                    </div>
                    <div class="form-group">
                        <label class="form-label">تلميح</label>
                        <input type="text" class="form-input" wire:model="passwordHint" placeholder="مثال: اسم قاعة الحفل">
                    </div>
                </div>
            </div>

            <div class="card">
                <label style="display:flex; align-items:center; gap:.75rem; cursor:pointer;">
                    <input type="checkbox" wire:model="isPublished" style="width:18px; height:18px;">
                    <div>
                        <p style="font-weight:600;">نشر الدعوة الآن</p>
                        <p style="font-size:.8rem; color:#78716c;">اتركها غير محددة إذا أردت المراجعة أولاً</p>
                    </div>
                </label>
            </div>
        @endif

        {{-- ─── Navigation Buttons ─── --}}
        <div style="display:flex; justify-content:space-between; margin-top:2rem; padding-top:1.5rem; border-top:1px solid #e7e5e4;">
            @if($step > 1)
                <button wire:click="prevStep" class="btn btn-outline">
                    → رجوع
                </button>
            @else
                <div></div>
            @endif

            @if($step < $totalSteps)
                <button wire:click="nextStep" class="btn btn-primary">
                    التالي ←
                </button>
            @else
                <button wire:click="submit" class="btn btn-primary">
                    💌 إنشاء الدعوة
                </button>
            @endif
        </div>

    </div>
</div>
