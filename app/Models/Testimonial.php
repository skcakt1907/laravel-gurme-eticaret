<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasTranslations;

    protected array $translatable = ['title', 'comment'];
    protected $guarded = [];
    protected $casts = ['durum' => 'boolean', 'ceviri' => 'array'];

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }
}
