<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
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

        // Increment view count — skip if the owner is viewing
        if (! Auth::check() || Auth::id() !== $event->user_id) {
            $event->increment('views_count');
        }

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
