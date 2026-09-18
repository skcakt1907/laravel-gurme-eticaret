<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Site dilini belirler (TR/EN). Öncelik: session('locale') > ayar('default_locale') > 'tr'.
 * Admin paneli her zaman Türkçe kalır (bu middleware yalnız ön yüzde çalışır).
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['tr', 'en'];
        // Admin paneli her zaman Türkçe
        if ($request->is('yonetim', 'yonetim/*')) {
            App::setLocale('tr');
            return $next($request);
        }
        $default = in_array(setting('default_locale', 'tr'), $supported, true)
            ? setting('default_locale', 'tr') : 'tr';
        $locale = session('locale', $default);
        if (! in_array($locale, $supported, true)) {
            $locale = $default;
        }
        App::setLocale($locale);

        return $next($request);
    }
}
