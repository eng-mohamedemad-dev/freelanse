<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WheelPrize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'probability',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function wheelSpins(): HasMany
    {
        return $this->hasMany(WheelSpin::class);
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'discount' => 'خصم',
            'points' => 'نقاط',
            'free_shipping' => 'شحن مجاني',
            'gift' => 'هدية',
            default => 'غير محدد'
        };
    }
}
