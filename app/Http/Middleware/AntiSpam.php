<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Form spam koruması — üç katman:
 *  1) Honeypot: insanın göremediği alan doluysa bot demektir.
 *  2) Süre kontrolü: form açılışından itibaren 3 saniyeden hızlı gönderim bot demektir.
 *     (Zaman damgası şifreli gider, bot değiştiremez.)
 *  3) Cloudflare Turnstile: ayarlarda anahtar girilmişse sunucu tarafında doğrulanır.
 */
class AntiSpam
{
    /** Formun en az bu kadar saniye açık kalması beklenir. */
    protected const MIN_SECONDS = 3;

    public function handle(Request $request, Closure $next): Response
    {
        // 1) Honeypot
        if (filled($request->input('website'))) {
            return $this->reddet($request, 'honeypot');
        }

        // 2) Süre kontrolü
        if ($ts = $request->input('_ts')) {
            try {
                $acilis = (int) decrypt($ts);
                if (time() - $acilis < self::MIN_SECONDS) {
                    return $this->reddet($request, 'cok-hizli');
                }
            } catch (\Throwable $e) {
                return $this->reddet($request, 'gecersiz-zaman');
            }
        }

        // 3) Turnstile (anahtar girilmişse)
        $secret = setting('turnstile_secret');
        if (filled($secret)) {
            $token = $request->input('cf-turnstile-response');

            if (blank($token)) {
                return $this->reddet($request, 'dogrulama-bos');
            }

            try {
                $cevap = Http::asForm()->timeout(10)->post(
                    'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                    ['secret' => $secret, 'response' => $token, 'remoteip' => $request->ip()]
                );

                if (! ($cevap->json('success') === true)) {
                    return $this->reddet($request, 'turnstile-basarisiz');
                }
            } catch (\Throwable $e) {
                // Cloudflare'a ulaşılamıyorsa formu kilitleme — sadece logla.
                Log::warning('Turnstile dogrulanamadi: '.$e->getMessage());
            }
        }

        return $next($request);
    }

    protected function reddet(Request $request, string $sebep): Response
    {
        Log::info('AntiSpam engelledi', ['sebep' => $sebep, 'ip' => $request->ip(), 'yol' => $request->path()]);

        return back()
            ->withInput($request->except(['password', 'password_confirmation']))
            ->withErrors(['spam' => __('Your submission could not be verified. Please try again.')]);
    }
}
