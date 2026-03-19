<?php

namespace App\Http\Controllers\Public;

use App\Enums\EventCategory;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Template;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $plans     = Plan::where('is_active', true)->orderBy('price')->get();
        $templates = Template::where('is_active', true)->with('plan')->get();

        return view('public.home', compact('plans', 'templates'));
    }

    public function templates(): View
    {
        $templates = Template::where('is_active', true)
            ->with('plan')
            ->get();

        return view('public.templates', compact('templates'));
    }

    public function preview(Template $template): View
    {
        $dummyEvent = $this->makeDummyEvent($template);

        // Static template: render in a centered wrapper page
        if ($template->isStatic()) {
            return view('public.static-preview', [
                'template'  => $template,
                'event'     => $dummyEvent,
                'isPreview' => true,
            ]);
        }

        return view("templates.website.{$template->slug}.index", [
            'event'     => $dummyEvent,
            'isPreview' => true,
            'template'  => $template,
        ]);
    }

    public function previewFrame(Template $template): View
    {
        $dummyEvent = $this->makeDummyEvent($template);

        if ($template->isStatic()) {
            return view("templates.static.{$template->slug}.template", [
                'event'     => $dummyEvent,
                'watermark' => false,
            ]);
        }

        return view("templates.website.{$template->slug}.index", [
            'event'     => $dummyEvent,
            'isPreview' => true,
            'isFrame'   => true,
        ]);
    }

    private function makeDummyEvent(Template $template): \App\Models\Event
    {
        $isAr = app()->isLocale('ar');
        $cat  = $template->category instanceof EventCategory
            ? $template->category
            : EventCategory::Wedding;

        // Choose locale-aware names per category
        $names = match($cat) {
            EventCategory::Birthday   => [$isAr ? 'سارة' : 'Sarah', null],
            EventCategory::Graduation => [$isAr ? 'محمد' : 'Mohamed', null],
            EventCategory::Corporate  => [$isAr ? 'شركة النجاح' : 'Success Corp', null],
            default                   => [$isAr ? 'أحمد' : 'James', $isAr ? 'سارة' : 'Emily'],
        };

        $dummyEvent = new \App\Models\Event([
            'category'      => $cat->value,
            'groom_name'    => $names[0],
            'bride_name'    => $names[1],
            'event_date'    => now()->addMonths(3),
            'event_time'    => '20:00',
            'venue_name'    => $isAr ? 'قاعة الأميرة – فندق الشيراتون' : 'The Grand Ballroom – Sheraton Hotel',
            'venue_address' => $isAr ? 'القاهرة، مصر الجديدة' : 'Cairo, Egypt',
            'venue_map_link'=> 'https://maps.google.com',
            'subdomain'     => null,
            'is_published'  => true,
            'custom_data'   => null,
        ]);

        $dummyEvent->setRelation('template', $template);
        $dummyEvent->setRelation('gallery', collect());

        $wishes = $isAr ? [
            (object)['guest_name' => 'محمد علي',   'message' => 'ألف مبروك! ربنا يتمم عليكم بالسعادة والهنا 💕', 'created_at' => now()->subHours(2)],
            (object)['guest_name' => 'فاطمة أحمد', 'message' => 'يارب يكون مبارك وتعيشوا في سعادة دايمة 🌸',    'created_at' => now()->subHours(5)],
            (object)['guest_name' => 'كريم وسارة', 'message' => 'أجمل التهاني! ربنا يسعدكم دايماً ❤️',           'created_at' => now()->subHours(12)],
        ] : [
            (object)['guest_name' => 'Sarah & Tom',  'message' => 'Wishing you a lifetime of love and happiness! 💕',      'created_at' => now()->subHours(2)],
            (object)['guest_name' => 'The Johnsons', 'message' => 'So happy for you both! Congrats on this beautiful day 🌸', 'created_at' => now()->subHours(5)],
            (object)['guest_name' => 'Emily Watson', 'message' => 'May your love grow stronger every year ❤️',               'created_at' => now()->subHours(12)],
        ];

        $dummyEvent->setRelation('approvedWishes', collect($wishes));
        $dummyEvent->setRelation('rsvpResponses', collect());

        return $dummyEvent;
    }
}
