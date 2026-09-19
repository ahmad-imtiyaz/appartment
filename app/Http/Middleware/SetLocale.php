<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $available = config('app.available_locales', ['id', 'en']);
        $locale = session('locale', config('app.locale'));

        if (in_array($locale, $available, true)) {
            App::setLocale($locale);
            Carbon::setLocale($locale); // supaya diffForHumans() / translatedFormat() ikut berubah
        }

        return $next($request);
    }
}
