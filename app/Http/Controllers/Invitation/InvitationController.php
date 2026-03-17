<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(Event $event): View
    {
        $event->load([
            'template',
            'gallery',
            'approvedWishes',
            'rsvpResponses',
        ]);

        $templateSlug = $event->template->slug;
        $viewName     = "templates.website.{$templateSlug}.index";

        return view($viewName, compact('event'));
    }
}
