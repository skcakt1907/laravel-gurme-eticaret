<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasTranslations;

    protected array $translatable = ['name', 'short_desc', 'description', 'attributes'];
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'brand', 'cover', 'images',
        'short_desc', 'description', 'price', 'sale_price', 'stock',
        'attributes', 'featured', 'sira', 'durum', 'ceviri',
    ];

    protected $casts = [
        'images'     => 'array',
        'attributes' => 'array',
        'featured'   => 'boolean',
        'durum'      => 'boolean',
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
        'ceviri'     => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($q)
    {
        return $q->where('durum', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Geçerli satış fiyatı (indirim varsa indirimli) */
    public function getCurrentPriceAttribute(): float
    {
        return (float) ($this->sale_price ?: $this->price);
    }

    public function getOnSaleAttribute(): bool
    {
        return $this->sale_price !== null && (float) $this->sale_price > 0 && (float) $this->sale_price < (float) $this->price;
    }

    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->cover) {
            return 'https://placehold.co/600x600?text=Gurme+Shop';
        }
        // Tam URL ise olduğu gibi; yerel yol ise public'ten çöz (dev + canlı uyumlu).
        return Str::startsWith($this->cover, ['http://', 'https://'])
            ? $this->cover
            : asset($this->cover);
    }
}
