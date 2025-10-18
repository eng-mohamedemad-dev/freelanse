<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'code',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'image',
        'status',
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

    protected $casts = [
        'starts_at' => 'date',
        'expires_at' => 'date',
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeValid($query)
    {
        $now = now()->toDateString();
        return $query->where('status', 'active')
                    ->where(function($q) use ($now) {
                        $q->whereNull('starts_at')
                          ->orWhere('starts_at', '<=', $now);
                    })
                    ->where(function($q) use ($now) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>=', $now);
                    });
    }

    public function scopeAvailable($query)
    {
        return $query->valid()->where(function($q) {
            $q->whereNull('usage_limit')
              ->orWhereRaw('used_count < usage_limit');
        });
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'fixed' => 'مبلغ ثابت',
            'percentage' => 'نسبة مئوية',
            default => 'غير محدد'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            default => 'غير محدد'
        };
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now()->toDateString();
    }

    public function getIsStartedAttribute()
    {
        return !$this->starts_at || $this->starts_at <= now()->toDateString();
    }

    public function getIsAvailableAttribute()
    {
        return $this->status === 'active' 
               && $this->is_started 
               && !$this->is_expired 
               && (!$this->usage_limit || $this->used_count < $this->usage_limit);
    }

    public function getUsagePercentageAttribute()
    {
        if (!$this->usage_limit) {
            return 0;
        }
        
        return round(($this->used_count / $this->usage_limit) * 100, 2);
    }

    // Methods
    public function calculateDiscount($amount)
    {
        if (!$this->is_available || $amount < $this->minimum_amount) {
            return 0;
        }

        $discount = 0;
        
        if ($this->type === 'fixed') {
            $discount = $this->value;
        } elseif ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            
            // تطبيق الحد الأقصى للخصم
            if ($this->maximum_discount && $discount > $this->maximum_discount) {
                $discount = $this->maximum_discount;
            }
        }

        return min($discount, $amount); // لا يمكن أن يكون الخصم أكبر من المبلغ
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    public function canBeUsed()
    {
        return $this->is_available;
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isStarted()
    {
        return !$this->starts_at || $this->starts_at <= now();
    }
}