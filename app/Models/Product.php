<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        // Remove legacy base-only name/description from forms, but keep fillable for compatibility
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'price',
        'sale_price',
        'stock',
        'category_id',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' && !empty($this->name_ar)) return $this->name_ar;
        if ($locale === 'en' && !empty($this->name_en)) return $this->name_en;
        return $this->name_ar ?? $this->name_en ?? '';
    }

    public function getDisplayDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' && !empty($this->description_ar)) return $this->description_ar;
        if ($locale === 'en' && !empty($this->description_en)) return $this->description_en;
        return $this->description_ar ?? $this->description_en ?? '';
    }

    public function getImageAttribute()
    {
        $images = $this->images;
        return $images && count($images) > 0 ? $images[0] : 'default-product.jpg';
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= $this->low_stock_threshold) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
