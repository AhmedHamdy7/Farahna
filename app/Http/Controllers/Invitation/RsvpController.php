<?php

namespace App\Http\Controllers\Invitation;

use App\Enums\RsvpStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'guest_name'   => ['required', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'attending'    => ['required', 'in:yes,no,maybe'],
            'guests_count' => ['required', 'integer', 'min:1', 'max:20'],
        ], [
            'guest_name.required' => 'يرجى إدخال اسمك.',
            'attending.required'  => 'يرجى تحديد حضورك.',
        ]);

        $event->rsvpResponses()->create([
            'guest_name'   => $request->guest_name,
            'phone'        => $request->phone,
            'attending'    => RsvpStatus::from($request->attending),
            'guests_count' => $request->guests_count,
        ]);

        $message = match(RsvpStatus::from($request->attending)) {
            RsvpStatus::Yes   => 'يسعدنا حضورك! سنسعد بتشريفنا. 🎉',
            RsvpStatus::No    => 'شكراً على إخبارنا. سنشتاق لكم! 💙',
            RsvpStatus::Maybe => 'شكراً! نتمنى تأكيد حضورك قريباً. 🙏',
        };

        return back()->with('rsvp_sent', $message);
    }
}
