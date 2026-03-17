<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Plan;
use App\Models\Template;
use App\Services\StaticInvitationService;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EventWizard extends Component
{
    // ─── Wizard State ────────────────────────────────────────────
    public int    $step       = 1;
    public int    $totalSteps = 4;

    // Step 1 – Plan
    public ?int $selectedPlanId = null;

    // Step 2 – Template
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
                $this->step               = 3; // Skip to details
            }
        }
    }

    // Step 3 – Event Details
    public string $groomName    = '';
    public string $brideName    = '';
    public string $eventDate    = '';
    public string $eventTime    = '';
    public string $venueName    = '';
    public string $venueAddress = '';
    public string $venueMapLink = '';

    // Step 4 – Publish Settings
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

    // ─── Plan / Template Selection ───────────────────────────────
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
        match ($this->step) {
            1 => $this->validate([
                'selectedPlanId' => ['required', 'exists:plans,id'],
            ], [
                'selectedPlanId.required' => 'يرجى اختيار باقة.',
            ]),

            2 => $this->validate([
                'selectedTemplateId' => ['required', 'exists:templates,id'],
            ], [
                'selectedTemplateId.required' => 'يرجى اختيار قالب.',
            ]),

            3 => $this->validate([
                'groomName'  => ['required', 'string', 'max:255'],
                'brideName'  => ['required', 'string', 'max:255'],
                'eventDate'  => ['required', 'date'],
                'venueName'  => ['required', 'string', 'max:255'],
            ], [
                'groomName.required' => 'يرجى إدخال اسم العريس.',
                'brideName.required' => 'يرجى إدخال اسم العروسة.',
                'eventDate.required' => 'يرجى تحديد تاريخ الحفل.',
                'venueName.required' => 'يرجى إدخال اسم القاعة.',
            ]),

            default => null,
        };
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

        $event = Event::create([
            'user_id'        => auth()->id(),
            'template_id'    => $this->selectedTemplateId,
            'groom_name'     => $this->groomName,
            'bride_name'     => $this->brideName,
            'event_date'     => $this->eventDate,
            'event_time'     => $this->eventTime ?: null,
            'venue_name'     => $this->venueName,
            'venue_address'  => $this->venueAddress ?: null,
            'venue_map_link' => $this->venueMapLink ?: null,
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
