<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Güvenlik başlıkları.
 *
 * .htaccess'e DEĞİL koda konuldu: hosting değişse, mod_headers kapalı olsa ya da
 * sunucu nginx'e geçse bile koruma kaybolmasın.
 *
 * CSP notu — sitede şu an ÜÇ dış kaynak kullanılıyor ve politika bunlara göre
 * yazıldı; listede olmayan hiçbir yere istek gidemez:
 *   · cdn.jsdelivr.net        Bootstrap 5.3 + Bootstrap Icons (css/js/font)
 *   · fonts.googleapis.com    yazı tipi tanımları  (+ fonts.gstatic.com dosyaları)
 *   · challenges.cloudflare.com  Turnstile spam korumasi (script + iframe)
 *
 * Bu üçü kendi sunucumuza alınırsa CSP'yi 'self'e kadar daraltmak mümkün; o gün
 * gelene kadar en azından BAŞKA bir yere veri sızması engellenmiş oluyor.
 *
 * Satır içi stil/script kullanılıyor (227 style="", 12 onclick, 4 <script>),
 * bu yüzden 'unsafe-inline' veriliyor. Kaldırmak için önce o kullanımların
 * temizlenmesi gerekir.
 */
class SecurityHeaders
{
    /**
     * HSTS süresi: 6 ay.
     *
     * Bilinçli olarak 1 yıl DEĞİL. Tarayıcı bu süre boyunca siteye HTTP ile
     * bağlanmayı tamamen reddeder; sertifika bir gün yenilenmezse site
     * "erişilemiyor" olur. Altı ay güvenli tarafta kalıp koruma sağlıyor.
     * Her şey oturduktan sonra 31536000 (1 yıl) yapılabilir.
     */
    private const HSTS = 15768000;

    public function handle(Request $request, Closure $next): Response
    {
        // PHP bunu SAPI seviyesinde ekler; Symfony yanıtından silmek yetmez.
        if (! headers_sent()) {
            header_remove('X-Powered-By');
        }

        $response = $next($request);

        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://challenges.cloudflare.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' data: https://cdn.jsdelivr.net https://fonts.gstatic.com",
            // Ürün görselleri panelden dış bir adres olarak da girilebiliyor
            "img-src 'self' data: https:",
            "connect-src 'self'",
            "frame-src https://challenges.cloudflare.com",
            "media-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'self'",
        ];

        $basliklar = [
            'Content-Security-Policy'    => implode('; ', $csp),
            'X-Content-Type-Options'     => 'nosniff',
            'X-Frame-Options'            => 'SAMEORIGIN',
            'Referrer-Policy'            => 'strict-origin-when-cross-origin',
            'Permissions-Policy'         => 'geolocation=(), microphone=(), camera=(), payment=(), usb=()',
            'Cross-Origin-Opener-Policy' => 'same-origin',
        ];

        // HSTS yalnızca gerçekten HTTPS'te — yerelde http ile çalışırken gönderilirse
        // geliştirme ortamı kilitlenir.
        if ($request->secure()) {
            $basliklar['Strict-Transport-Security'] = 'max-age=' . self::HSTS . '; includeSubDomains';
        }

        foreach ($basliklar as $ad => $deger) {
            if (! $response->headers->has($ad)) {
                $response->headers->set($ad, $deger);
            }
        }

        return $response;
    }
}
