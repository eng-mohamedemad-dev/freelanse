<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'price',
        'stock',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function getImageAttribute()
    {
        $images = $this->images;
        return $images && count($images) > 0 ? $images[0] : 'default-product.jpg';
    }

    public function getVariantNameAttribute()
    {
        $parts = [];
        if ($this->size) {
            $parts[] = $this->size->display_name;
        }
        if ($this->color) {
            $parts[] = $this->color->display_name;
        }
        return implode(' - ', $parts) ?: 'Default';
    }
}
