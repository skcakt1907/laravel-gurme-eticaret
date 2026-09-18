<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslations;

    protected array $translatable = ['title', 'summary', 'content'];
    protected $guarded = [];
    protected $casts = ['durum' => 'boolean', 'ceviri' => 'array'];

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
