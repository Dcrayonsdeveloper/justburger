<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'seller_id',
        'product_name',
        'variant_name',
        'sku',
        'mrp',
        'price',
        'quantity',
        'tax',
        'discount',
        'total',
        'product_snapshot',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'mrp' => 'decimal:2',
            'price' => 'decimal:2',
            'tax' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'product_snapshot' => 'array',
        ];
    }

    /**
     * The customer's choices, as frozen into the snapshot at checkout.
     *
     * Shaped like the cart's: ['kept' => [...], 'added' => [...], 'removed' => [...]],
     * each entry carrying a name and a price. Orders placed before the snapshot
     * was recorded simply have none, so every caller must cope with an empty
     * array rather than assume the keys exist.
     */
    public function getToppingsListAttribute(): array
    {
        $toppings = $this->product_snapshot['toppings'] ?? [];

        return is_array($toppings) ? $toppings : [];
    }

    /** Whether this line was customised at all — worth a line on the receipt. */
    public function hasCustomisations(): bool
    {
        $toppings = $this->toppings_list;

        return ! empty($toppings['kept'])
            || ! empty($toppings['added'])
            || ! empty($toppings['removed']);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
