<?php

namespace App\Models;

use App\Models\Concerns\NormalisesToppings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use NormalisesToppings;

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'total',
        'attributes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'total' => 'decimal:2',
            'attributes' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function ($item) {
            $toppingsTotal = $item->toppings_total;
            $item->total = ($item->price + $toppingsTotal) * $item->quantity;
        });

        static::saved(function ($item) {
            $item->cart->recalculate();
        });

        static::deleted(function ($item) {
            $item->cart->recalculate();
        });
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getToppingsTotalAttribute(): float
    {
        $attrs = $this->attributes['attributes'] ?? null;
        $decoded = is_string($attrs) ? json_decode($attrs, true) : $attrs;
        $added = $decoded['toppings']['added'] ?? [];

        return array_sum(array_column($added, 'price'));
    }

    /** What the customer typed for this line, if the product allows a note. */
    public function getItemNoteAttribute(): string
    {
        $attrs = $this->attributes['attributes'] ?? null;
        $decoded = is_string($attrs) ? json_decode($attrs, true) : $attrs;

        return trim((string) ($decoded['item_note'] ?? ''));
    }

    public function getToppingsListAttribute(): array
    {
        $attrs = $this->attributes['attributes'] ?? null;
        $decoded = is_string($attrs) ? json_decode($attrs, true) : $attrs;
        $toppings = $decoded['toppings'] ?? [];

        return is_array($toppings) ? $this->withoutDuplicatedKeeps($toppings) : [];
    }

    public function updateQuantity(int $quantity): void
    {
        $this->update(['quantity' => $quantity]);
    }
}
