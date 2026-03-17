<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['ar', 'en'];

        // 1. Explicit ?lang= query param → store in session
        if ($request->has('lang') && in_array($request->query('lang'), $supported)) {
            Session::put('locale', $request->query('lang'));
        }

        $locale = Session::get('locale', config('app.locale', 'ar'));

        if (! in_array($locale, $supported)) {
            $locale = 'ar';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
