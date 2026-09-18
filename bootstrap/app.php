<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Dil (TR/EN) — tüm web isteklerinde
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        // Güvenlik başlıkları — hata sayfalarına da uygulansın diye GLOBAL.
        // .htaccess'te değil kodda: sunucu/hosting değişince kaybolmasın.
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        // Admin guard alias
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'satis' => \App\Http\Middleware\EnsureSalesEnabled::class,
            'spam'  => \App\Http\Middleware\AntiSpam::class,
        ]);
        // iyzico dış callback'i CSRF'den muaf
        $middleware->validateCsrfTokens(except: [
            'checkout/callback/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
