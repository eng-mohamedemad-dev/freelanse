<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
        'status',
        'parent_id',
        'sort_order',
    ];

    public function getDisplayNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' && !empty($this->name_ar)) return $this->name_ar;
        if ($locale === 'en' && !empty($this->name_en)) return $this->name_en;
    }

    public function getDisplayDescriptionAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ar' && !empty($this->description_ar)) return $this->description_ar;
        if ($locale === 'en' && !empty($this->description_en)) return $this->description_en;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
