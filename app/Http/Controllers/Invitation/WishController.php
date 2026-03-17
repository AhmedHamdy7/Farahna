<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'message'    => ['required', 'string', 'max:1000'],
        ], [
            'guest_name.required' => 'يرجى إدخال اسمك.',
            'message.required'    => 'يرجى كتابة رسالتك.',
            'message.max'         => 'الرسالة طويلة جداً (1000 حرف كحد أقصى).',
        ]);

        $event->wishes()->create([
            'guest_name'  => $request->guest_name,
            'message'     => $request->message,
            'is_approved' => true,
        ]);

        return back()->with('wish_sent', 'تم إرسال تهنئتك! ستظهر بعد مراجعتها. 💌');
    }
}
