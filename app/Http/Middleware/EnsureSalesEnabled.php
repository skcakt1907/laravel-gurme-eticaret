<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Katalog modu koruması.
 * Ayarlarda 'fiyat_goster' kapalıyken sepet/ödeme sayfaları fiyat gösterdiği için
 * erişime kapatılır; ziyaretçi iletişim (teklif) sayfasına yönlendirilir.
 */
class EnsureSalesEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! fiyat_goster()) {
            return redirect()->route('contact')
                ->with('error', 'Online sales are currently closed. Please contact us for pricing and orders.');
        }

        return $next($request);
    }
}
