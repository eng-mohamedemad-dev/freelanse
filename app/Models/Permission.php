<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'name_en',
        'slug',
        'description_ar',
        'description_en',
        'category',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدمين
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions')
                    ->withPivot(['is_granted', 'granted_at', 'revoked_at'])
                    ->withTimestamps();
    }

    /**
     * الحصول على الصلاحيات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * الحصول على الصلاحيات حسب الفئة
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
