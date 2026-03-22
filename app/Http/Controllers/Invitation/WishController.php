<?php

namespace App\Http\Controllers\Invitation;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, Event $event)
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

        if ($request->expectsJson()) {
            return response()->json(['message' => 'ok']);
        }

        return back()->with('wish_sent', 'تم إرسال تهنئتك! ستظهر بعد مراجعتها. 💌');
    }

    public function latest(Request $request, Event $event): JsonResponse
    {
        $limit = min((int) $request->get('limit', 20), 20);

        if ($request->has('before')) {
            // Older wishes — for modal infinite scroll / load more
            $before = (int) $request->get('before');
            $wishes = $event->approvedWishes()
                ->where('id', '<', $before)
                ->limit($limit)
                ->get(['id', 'guest_name', 'message', 'created_at']);
        } elseif ($request->has('after')) {
            // Newer wishes — for real-time polling
            $after  = (int) $request->get('after');
            $wishes = $event->approvedWishes()
                ->where('id', '>', $after)
                ->get(['id', 'guest_name', 'message', 'created_at']);
        } else {
            // Latest N — for modal initial open
            $wishes = $event->approvedWishes()
                ->limit($limit)
                ->get(['id', 'guest_name', 'message', 'created_at']);
        }

        return response()->json([
            'wishes' => $wishes->map(fn($w) => [
                'id'         => $w->id,
                'guest_name' => $w->guest_name,
                'message'    => $w->message,
                'time_ago'   => $w->created_at->diffForHumans(),
            ]),
            'total'  => $event->approvedWishes()->count(),
        ]);
    }
}
