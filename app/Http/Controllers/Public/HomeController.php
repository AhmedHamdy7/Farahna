<?php

namespace App\Http\Controllers\Public;

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
            ->get()
            ->groupBy(fn ($t) => $t->type->value);

        return view('public.templates', compact('templates'));
    }

    public function preview(Template $template): View
    {
        $isAr = app()->isLocale('ar');

        $dummyEvent = new \App\Models\Event([
            'groom_name'    => $isAr ? 'أحمد'                              : 'James',
            'bride_name'    => $isAr ? 'سارة'                              : 'Emily',
            'event_date'    => now()->addMonths(3),
            'event_time'    => '20:00',
            'venue_name'    => $isAr ? 'قاعة الأميرة – فندق الشيراتون'    : 'The Grand Ballroom – Sheraton Hotel',
            'venue_address' => $isAr ? 'القاهرة، مصر الجديدة'             : 'Cairo, Egypt',
            'venue_map_link'=> 'https://maps.google.com',
            'subdomain'     => null,
            'is_published'  => true,
            'custom_data'   => null,
        ]);

        $dummyEvent->setRelation('template', $template);
        $dummyEvent->setRelation('gallery', collect());
        $dummyEvent->setRelation('approvedWishes', collect($isAr ? [
            (object)['guest_name' => 'محمد علي',      'message' => 'ألف مبروك! ربنا يتمم عليكم بالسعادة والهنا 💕',         'created_at' => now()->subHours(2)],
            (object)['guest_name' => 'فاطمة أحمد',    'message' => 'يارب يكون زواجكم مبارك وتعيشوا في سعادة دايمة 🌸',     'created_at' => now()->subHours(5)],
            (object)['guest_name' => 'كريم وسارة',    'message' => 'أجمل التهاني لأجمل عروسين! ربنا يسعدكم دايماً ❤️',     'created_at' => now()->subHours(12)],
        ] : [
            (object)['guest_name' => 'Sarah & Tom',   'message' => 'Wishing you a lifetime of love and happiness! 💕',      'created_at' => now()->subHours(2)],
            (object)['guest_name' => 'The Johnsons',  'message' => 'So happy for you both! Congrats on this beautiful day 🌸', 'created_at' => now()->subHours(5)],
            (object)['guest_name' => 'Emily Watson',  'message' => 'May your love grow stronger with every passing year ❤️', 'created_at' => now()->subHours(12)],
        ]));
        $dummyEvent->setRelation('rsvpResponses', collect());

        // Render the template directly (no iframe needed)
        return view("templates.website.{$template->slug}.index", [
            'event'     => $dummyEvent,
            'isPreview' => true,
            'template'  => $template,
        ]);
    }
}
