<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WheelSpin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wheel_prize_id',
        'ip_address',
        'user_agent',
        'is_used',
    ];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prize(): BelongsTo
    {
        return $this->belongsTo(WheelPrize::class, 'wheel_prize_id');
    }
}
