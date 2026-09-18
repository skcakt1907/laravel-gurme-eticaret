<?php

namespace App\Models\Concerns;

/**
 * Basit çift dil. Ana kolonlar = TR (varsayılan dil).
 * İkincil dil (EN) çevirileri `ceviri` JSON kolonunda: {"en": {"name": "...", ...}}.
 * Modelde: protected array $translatable = ['name', ...]; ve casts'ta 'ceviri' => 'array'.
 */
trait HasTranslations
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        $locale = app()->getLocale();
        if ($locale !== 'tr'
            && property_exists($this, 'translatable')
            && in_array($key, $this->translatable, true)) {
            $ceviri = parent::getAttribute('ceviri');
            if (is_array($ceviri) && isset($ceviri[$locale][$key]) && $ceviri[$locale][$key] !== '' && $ceviri[$locale][$key] !== null) {
                return $ceviri[$locale][$key];
            }
        }

        return $value;
    }
}
