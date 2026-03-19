<?php

namespace App\Livewire;

use App\Enums\EventCategory;
use App\Models\Event;
use App\Models\Plan;
use App\Models\Template;
use App\Services\StaticInvitationService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EventWizard extends Component
{
    // ─── Wizard State ────────────────────────────────────────────
    public int    $step       = 1;
    public int    $totalSteps = 5;

    // Step 1 – Category
    public string $selectedCategory = 'wedding';

    // Step 2 – Plan
    public ?int $selectedPlanId = null;

    // Step 3 – Template
    public ?int $selectedTemplateId = null;

    public function mount(): void
    {
        // Pre-select template if coming from landing page
        $templateId = request()->integer('template');

        if ($templateId) {
            $template = Template::find($templateId);
            if ($template?->is_active) {
                $this->selectedTemplateId = $template->id;
                $this->selectedPlanId     = $template->plan_id;
                $this->selectedCategory   = $template->category->value;
                $this->step               = 4; // Skip to details
            }
        }
    }

    // Step 4 – Event Details
    public string $groomName    = '';
    public string $brideName    = '';
    public string $eventDate    = '';
    public string $eventTime    = '';
    public string $venueName    = '';
    public string $venueAddress = '';
    public string $venueMapLink = '';
    public string $musicUrl     = '';

    // Step 5 – Publish Settings
    public string $subdomain     = '';
    public string $password      = '';
    public string $passwordHint  = '';
    public bool   $isPublished   = false;

    // ─── Computed ────────────────────────────────────────────────
    #[Computed]
    public function plans()
    {
        return Plan::where('is_active', true)->orderBy('price')->get();
    }

    #[Computed]
    public function selectedPlan(): ?Plan
    {
        return $this->selectedPlanId ? Plan::find($this->selectedPlanId) : null;
    }

    #[Computed]
    public function templates()
    {
        if (! $this->selectedPlan) {
            return collect();
        }

        return Template::where('is_active', true)
            ->where('plan_id', $this->selectedPlanId)
            ->where('category', $this->selectedCategory)
            ->get();
    }

    #[Computed]
    public function selectedTemplate(): ?Template
    {
        return $this->selectedTemplateId ? Template::find($this->selectedTemplateId) : null;
    }

    // ─── Step Navigation ─────────────────────────────────────────
    public function nextStep(): void
    {
        $this->validateCurrentStep();
        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    // ─── Category / Plan / Template Selection ────────────────────
    public function selectCategory(string $category): void
    {
        $this->selectedCategory   = $category;
        $this->selectedPlanId     = null;
        $this->selectedTemplateId = null;
    }

    public function selectPlan(int $planId): void
    {
        $this->selectedPlanId     = $planId;
        $this->selectedTemplateId = null;
    }

    public function selectTemplate(int $templateId): void
    {
        $this->selectedTemplateId = $templateId;
    }

    // ─── Validation ──────────────────────────────────────────────
    private function validateCurrentStep(): void
    {
        $validCategories = implode(',', array_column(EventCategory::cases(), 'value'));

        match ($this->step) {
            1 => $this->validate([
                'selectedCategory' => ['required', "in:{$validCategories}"],
            ], [
                'selectedCategory.required' => 'يرجى اختيار نوع المناسبة.',
                'selectedCategory.in'       => 'نوع المناسبة غير صالح.',
            ]),

            2 => $this->validate([
                'selectedPlanId' => ['required', 'exists:plans,id'],
            ], [
                'selectedPlanId.required' => 'يرجى اختيار باقة.',
            ]),

            3 => $this->validate([
                'selectedTemplateId' => ['required', 'exists:templates,id'],
            ], [
                'selectedTemplateId.required' => 'يرجى اختيار قالب.',
            ]),

            4 => $this->validateDetails(),

            default => null,
        };
    }

    private function validateDetails(): void
    {
        $cat = EventCategory::from($this->selectedCategory);
        [$primaryLabel] = $cat->nameLabels();

        $rules = [
            'groomName' => ['required', 'string', 'max:255'],
            'eventDate' => ['required', 'date'],
            'venueName' => ['required', 'string', 'max:255'],
        ];

        $messages = [
            'groomName.required' => "يرجى إدخال {$primaryLabel}.",
            'eventDate.required' => 'يرجى تحديد تاريخ المناسبة.',
            'venueName.required' => 'يرجى إدخال اسم المكان.',
        ];

        if ($cat->isCoupleEvent()) {
            $rules['brideName']            = ['required', 'string', 'max:255'];
            $messages['brideName.required'] = 'يرجى إدخال ' . $cat->nameLabels()[1] . '.';
        }

        $this->validate($rules, $messages);
    }

    // ─── Submit ──────────────────────────────────────────────────
    public function submit(): void
    {
        $this->validate([
            'subdomain' => [
                'nullable',
                'alpha_dash',
                'max:100',
                'unique:events,subdomain',
            ],
        ], [
            'subdomain.unique'     => 'هذا الـ subdomain محجوز، جرّب اسماً آخر.',
            'subdomain.alpha_dash' => 'الـ subdomain يقبل فقط حروف وأرقام وشرطات.',
        ]);

        $cat = EventCategory::from($this->selectedCategory);

        $event = Event::create([
            'user_id'        => auth()->id(),
            'template_id'    => $this->selectedTemplateId,
            'category'       => $this->selectedCategory,
            'groom_name'     => $this->groomName,
            'bride_name'     => $cat->isCoupleEvent() ? $this->brideName : null,
            'event_date'     => $this->eventDate,
            'event_time'     => $this->eventTime ?: null,
            'venue_name'     => $this->venueName,
            'venue_address'  => $this->venueAddress ?: null,
            'venue_map_link' => $this->venueMapLink ?: null,
            'custom_data'    => array_filter(['music_url' => $this->musicUrl ?: null]),
            'subdomain'      => $this->subdomain ?: null,
            'password'       => $this->password ? bcrypt($this->password) : null,
            'password_hint'  => $this->passwordHint ?: null,
            'is_published'   => $this->isPublished,
        ]);

        // Generate static invitation if template is static type
        if ($this->selectedTemplate?->isStatic()) {
            app(StaticInvitationService::class)->generate($event);
        }

        $this->redirectRoute('customer.events.show', $event, navigate: true);
    }

    // ─── Render ──────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.event-wizard');
    }
}
