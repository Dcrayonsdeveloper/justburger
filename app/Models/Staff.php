<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'employee_id',
        'role',
        'store_id',
        'pin',
        'permissions',
        'is_active',
        'commission_rate',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
            'is_active' => 'boolean',
            'commission_rate' => 'decimal:2',
            'joined_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(StaffShift::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(PosSale::class);
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Find an active staff member at the given store whose PIN matches,
     * optionally restricted to specific roles (e.g. manager/supervisor
     * authorization checks).
     */
    public static function findByPin(int $storeId, string $pin, ?array $roles = null): ?self
    {
        $query = static::query()
            ->where('store_id', $storeId)
            ->where('is_active', true)
            ->whereNotNull('pin');

        if ($roles) {
            $query->whereIn('role', $roles);
        }

        return $query->get()->first(fn (self $staff) => Hash::check($pin, $staff->pin));
    }
}
