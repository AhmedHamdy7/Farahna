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

        $template     = $event->template;
        $templateSlug = $template->slug;

        if ($template->isStatic()) {
            $viewName = "templates.static.{$templateSlug}.template";
            return view($viewName, [
                'event'     => $event,
                'watermark' => ! $template->plan->isFree(),
            ]);
        }

        $viewName = "templates.website.{$templateSlug}.index";

        return view($viewName, compact('event'));
    }
}
