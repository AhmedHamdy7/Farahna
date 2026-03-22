<?php

namespace App\Http\Controllers\Invitation;

use App\Enums\RsvpStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'guest_name'   => ['required', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'attending'    => ['required', 'in:yes,no,maybe'],
            'guests_count' => ['required', 'integer', 'min:0', 'max:20'],
            'notes'        => ['nullable', 'string', 'max:500'],
        ], [
            'guest_name.required' => 'يرجى إدخال اسمك.',
            'attending.required'  => 'يرجى تحديد حضورك.',
        ]);

        $event->rsvpResponses()->create([
            'guest_name'   => $request->guest_name,
            'phone'        => $request->phone,
            'attending'    => RsvpStatus::from($request->attending),
            'guests_count' => $request->guests_count,
            'notes'        => $request->notes ?: null,
        ]);

        $message = match(RsvpStatus::from($request->attending)) {
            RsvpStatus::Yes   => 'يسعدنا حضورك! سنسعد بتشريفنا. 🎉',
            RsvpStatus::No    => 'شكراً على إخبارنا. سنشتاق لكم! 💙',
            RsvpStatus::Maybe => 'شكراً! نتمنى تأكيد حضورك قريباً. 🙏',
        };

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('rsvp_sent', $message);
    }
}
