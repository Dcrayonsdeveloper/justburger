<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = [
        'label',
        'percent',
        'max_cart_value',
        'requires_pin',
        'is_active',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'percent' => 'decimal:2',
            'max_cart_value' => 'decimal:2',
            'requires_pin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Whether this rule can currently be applied to a cart with the given subtotal.
     */
    public function isApplicable(float $subtotal): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->max_cart_value !== null && $subtotal > (float) $this->max_cart_value) {
            return false;
        }

        return true;
    }
}
