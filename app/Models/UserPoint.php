<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'points',
        'type',
        'description',
        'order_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'earned' => 'نقاط مكتسبة',
            'redeemed' => 'نقاط مستخدمة',
            'bonus' => 'نقاط مكافأة',
            'wheel_prize' => 'جائزة العجلة',
            default => 'غير محدد'
        };
    }
}
