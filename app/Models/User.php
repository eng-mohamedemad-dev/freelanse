<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get user role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'مدير',
            'manager' => 'مدير فرعي',
            'user' => 'مستخدم',
            default => 'غير محدد'
        };
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for manager users
     */
    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    /**
     * Scope for regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * العلاقة مع الصلاحيات
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
                    ->withPivot(['is_granted', 'granted_at', 'revoked_at'])
                    ->withTimestamps();
    }

    /**
     * التحقق من وجود صلاحية معينة
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()
                    ->where('slug', $permissionSlug)
                    ->wherePivot('is_granted', true)
                    ->exists();
    }

    /**
     * منح صلاحية للمستخدم
     */
    public function grantPermission(Permission $permission): void
    {
        $this->permissions()->syncWithoutDetaching([
            $permission->id => [
                'is_granted' => true,
                'granted_at' => now(),
                'revoked_at' => null
            ]
        ]);
    }

    /**
     * إلغاء صلاحية من المستخدم
     */
    public function revokePermission(Permission $permission): void
    {
        $this->permissions()->updateExistingPivot($permission->id, [
            'is_granted' => false,
            'revoked_at' => now()
        ]);
    }
}
