<?php

use App\Models\Setting;
use App\Support\Cart;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('money')) {
    function money($amount): string
    {
        return number_format((float) $amount, 2, ',', '.') . ' €';
    }
}

if (! function_exists('agirlik_fiyat')) {
    /**
     * Gramaja göre kademeli fiyat (tüm ürünler için aynı tablo).
     * Ürün tipi fark etmez — ağırlık hangi aralığa düşerse o fiyat (€).
     */
    function agirlik_fiyat(?float $gram): ?float
    {
        if (! $gram) {
            return null;
        }
        return match (true) {
            $gram <= 100 => 39.0,   // 80–100 g
            $gram <= 120 => 49.0,   // 100–120 g
            $gram <= 150 => 59.0,   // 120–150 g
            $gram <= 180 => 69.0,   // 150–180 g
            $gram <= 220 => 79.0,   // 180–220 g
            default      => 89.0,   // 220–250 g +
        };
    }
}

if (! function_exists('tsetting')) {
    /**
     * Dile göre ayar: EN locale'de "{key}_en" varsa onu döndürür, yoksa ana ayarı.
     */
    function tsetting(string $key, $default = null)
    {
        if (app()->getLocale() === 'en') {
            $en = setting($key.'_en');
            if ($en !== null && $en !== '') {
                return $en;
            }
        }
        return setting($key, $default);
    }
}

if (! function_exists('fiyat_goster')) {
    /**
     * Fiyatlar ve online satış açık mı?
     * Ayarlarda 'fiyat_goster' = 1 ise fiyatlar + sepet görünür.
     * Varsayılan KAPALI (katalog modu): fiyat gizli, "Teklif İste" gösterilir.
     */
    function fiyat_goster(): bool
    {
        return (string) setting('fiyat_goster', '0') === '1';
    }
}

if (! function_exists('cart')) {
    function cart(): string
    {
        return Cart::class;
    }
}
