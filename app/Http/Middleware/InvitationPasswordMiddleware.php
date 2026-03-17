<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class InvitationPasswordMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Event $event */
        $event = $request->route('event');

        if (! $event instanceof Event) {
            abort(404);
        }

        if (! $event->is_published) {
            abort(404);
        }

        if ($event->isExpired()) {
            abort(410, 'هذه الدعوة انتهت صلاحيتها.');
        }

        if (! $event->isPasswordProtected()) {
            return $next($request);
        }

        $sessionKey = "invitation_unlocked_{$event->id}";

        if (session($sessionKey)) {
            return $next($request);
        }

        if ($request->isMethod('POST')) {
            $request->validate([
                'password' => ['required', 'string'],
            ]);

            if (Hash::check($request->input('password'), $event->password)) {
                session([$sessionKey => true]);
                return redirect()->back();
            }

            return back()->withErrors([
                'password' => 'كلمة المرور غير صحيحة. حاول مرة أخرى!',
            ]);
        }

        return response()->view('invitation.locked', ['event' => $event]);
    }
}
