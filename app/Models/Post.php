<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasTranslations;

    protected array $translatable = ['title', 'category', 'summary', 'content'];
    protected $guarded = [];
    protected $casts = ['durum' => 'boolean', 'tarih' => 'date', 'ceviri' => 'array'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }
        // Tam URL ise olduğu gibi; yerel yol ise public'ten çöz (dev + canlı uyumlu).
        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : asset($this->image);
    }

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
