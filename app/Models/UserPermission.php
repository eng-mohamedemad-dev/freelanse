<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'permission_id',
        'is_granted',
        'granted_at',
        'revoked_at'
    ];

    protected $casts = [
        'is_granted' => 'boolean',
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع الصلاحية
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * منح الصلاحية
     */
    public function grant()
    {
        $this->update([
            'is_granted' => true,
            'granted_at' => now(),
            'revoked_at' => null
        ]);
    }

    /**
     * إلغاء الصلاحية
     */
    public function revoke()
    {
        $this->update([
            'is_granted' => false,
            'revoked_at' => now()
        ]);
    }
}
