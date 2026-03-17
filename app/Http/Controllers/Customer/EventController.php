<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EventController extends Controller
{
    public function create(): View
    {
        return view('customer.events.create');
    }

    public function show(Event $event): View
    {
        $this->authorizeEvent($event);

        $event->load(['template', 'gallery', 'wishes', 'rsvpResponses']);

        return view('customer.events.show', compact('event'));
    }

    public function approveWish(Event $event, Wish $wish): RedirectResponse
    {
        $this->authorizeEvent($event);
        abort_if($wish->event_id !== $event->id, 403);

        $wish->update(['is_approved' => !$wish->is_approved]);

        return back();
    }

    public function deleteWish(Event $event, Wish $wish): RedirectResponse
    {
        $this->authorizeEvent($event);
        abort_if($wish->event_id !== $event->id, 403);

        $wish->delete();

        return back();
    }

    private function authorizeEvent(Event $event): void
    {
        abort_if($event->user_id !== auth()->id(), 403);
    }
}
