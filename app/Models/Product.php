<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'shopee_url',
        'is_featured',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path && file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }

        return 'https://placehold.co/600x400/111111/f59e0b?text=' . urlencode($this->name);
    }

    /**
     * Get all image URLs for this product (main image + additional images).
     * Returns an array of URL strings.
     */
    public function getAllImageUrlsAttribute(): array
    {
        $urls = [];

        // Main image first
        if ($this->image_path && file_exists(public_path('storage/' . $this->image_path))) {
            $urls[] = asset('storage/' . $this->image_path);
        }

        // Additional images from product_images table
        foreach ($this->images as $image) {
            $url = $image->image_url;
            if (!in_array($url, $urls)) {
                $urls[] = $url;
            }
        }

        // Fallback if no images at all
        if (empty($urls)) {
            $urls[] = 'https://placehold.co/600x400/111111/f59e0b?text=' . urlencode($this->name);
        }

        return $urls;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getWhatsappUrlAttribute(): string
    {
        $phone = env('WHATSAPP_NUMBER', '6281234567890');
        $message = "Hi, I'm interested in *{$this->name}* (Rp " . number_format($this->price, 0, ',', '.') . "). Is it still available?";
        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
