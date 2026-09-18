<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Panelden YAZILABİLİR ayar anahtarları.
     *
     * Liste `resources/views/admin/settings.blade.php` içindeki alanlarla birebir.
     * Formda olmayan bir anahtar buraya EKLENMEZ.
     *
     * Neden var: `update()` eskiden POST edilen HER alanı veritabanına yazıyordu
     * (`$request->except('_token')`). Panele girmiş biri formda hiç bulunmayan
     * anahtarları da (ör. ödeme anahtarları, gizli bayraklar) uydurabiliyor ya da
     * ezebiliyordu. Artık listede olmayan alan sessizce atılır.
     *
     * NOT: Burada olmayan ama veritabanında duran anahtarlar (firma_unvan, vergi_no,
     * mersis_no, kep, havale_hesaplar, site_aciklama_en …) SİLİNMEZ — yalnızca bu
     * formdan düzenlenemez. Zaten panelde bir ekranları yok; gerekirse önce forma
     * eklenmeli, sonra buraya.
     */
    public const ALANLAR = [
        // Genel
        'site_adi', 'site_aciklama', 'yil',

        // İletişim & sosyal
        'telefon', 'whatsapp', 'eposta', 'adres', 'instagram', 'facebook',

        // Spam koruması (Cloudflare Turnstile)
        'turnstile_site_key', 'turnstile_secret',

        // Satış modu (fiyat göster / katalog)
        'fiyat_goster',

        // Kargo — tek ücret; ücretsiz kargo eşiği kaldırıldı
        'kargo_ucreti',

        // Havale / EFT
        'havale_banka', 'havale_hesap_adi', 'havale_iban',

        // Ödeme yöntemleri
        'kapida_aktif', 'iyzico_aktif', 'iyzico_api_key', 'iyzico_secret', 'iyzico_sandbox',
    ];

    public function edit()
    {
        return view('admin.settings', [
            'settings' => Setting::pluck('deger', 'anahtar')->toArray(),
        ]);
    }

    public function update(Request $request)
    {
        $gelen = $request->except('_token');

        $reddedilen = array_diff(array_keys($gelen), self::ALANLAR);

        if ($reddedilen !== []) {
            // Sessizce atmak yeterli ama iz bırakalım: normal kullanımda buraya
            // hiç düşülmez; düşüyorsa ya form değişmiş ya da biri elle POST atıyor.
            Log::warning('Ayarlar: beyaz listede olmayan alan(lar) reddedildi', [
                'alanlar' => array_values($reddedilen),
                'ip'      => $request->ip(),
                'user_id' => auth()->id(),
            ]);
        }

        foreach (self::ALANLAR as $anahtar) {
            if (! array_key_exists($anahtar, $gelen)) {
                continue;
            }

            $deger = $gelen[$anahtar];

            // `site_adi[]=x` gibi dizi gönderip Setting::put'u bozmaya çalışan
            // istekleri geç: bu alanların hepsi tek satırlık metin.
            if (is_array($deger) || is_object($deger)) {
                continue;
            }

            Setting::put($anahtar, is_string($deger) ? trim($deger) : $deger);
        }

        Setting::flush();

        return back()->with('success', 'Ayarlar kaydedildi.');
    }
}
