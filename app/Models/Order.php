<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /** The three states a collection order moves through, plus cancelled. */
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_READY = 'ready';
    public const STATUS_CANCELLED = 'cancelled';

    /** What an admin is allowed to set by hand. */
    public const SETTABLE_STATUSES = [
        self::STATUS_PREPARING => 'Preparing',
        self::STATUS_READY => 'Ready',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    protected $fillable = [
        'order_number',
        'user_id',
        'seller_id',
        'shipping_address_id',
        'billing_address_id',
        'coupon_id',
        'affiliate_id',
        'affiliate_referral_code',
        'status',
        'payment_status',
        'subtotal',
        'discount',
        'tax',
        'shipping_cost',
        'total',
        'paid_amount',
        'currency',
        'shipping_address_snapshot',
        'billing_address_snapshot',
        'notes',
        'admin_notes',
        'ip_address',
        'user_agent',
        'source',
        'metadata',
        'confirmed_at',
        'preparing_at',
        'ready_at',
        'packed_at',
        'shipped_at',
        'out_for_delivery_at',
        'delivered_at',
        'cancelled_at',
        'guest_email',
        'guest_name',
        'guest_phone',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'shipping_address_snapshot' => 'array',
            'billing_address_snapshot' => 'array',
            'metadata' => 'array',
            'confirmed_at' => 'datetime',
            'preparing_at' => 'datetime',
            'ready_at' => 'datetime',
            'packed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'out_for_delivery_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));

        return "{$prefix}-{$date}-{$random}";
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'billing_address_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(OrderShipment::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(OrderReturn::class, 'order_id');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    // Helper methods
    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return in_array($this->status, ['confirmed', 'processing', 'shipped', 'delivered']);
    }

    public function isPacked(): bool
    {
        return in_array($this->status, ['packed', 'shipped', 'out_for_delivery', 'delivered']);
    }

    public function isShipped(): bool
    {
        return in_array($this->status, ['shipped', 'out_for_delivery', 'delivered']);
    }

    public function isOutForDelivery(): bool
    {
        return in_array($this->status, ['out_for_delivery', 'delivered']);
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    public function canBeReturned(): bool
    {
        return $this->status === 'delivered'
            && $this->delivered_at
            && $this->delivered_at->addHours(24)->isPast()
            && $this->delivered_at->diffInDays(now()) <= 7;
    }

    public function updateStatus(string $status, ?int $userId = null, ?string $comment = null): void
    {
        $this->update(['status' => $status]);

        $this->statusHistory()->create([
            'status' => $status,
            'comment' => $comment,
            'created_by' => $userId,
        ]);

        // Update timestamps
        match ($status) {
            'confirmed' => $this->update(['confirmed_at' => now()]),
            self::STATUS_PREPARING => $this->update(['preparing_at' => now(), 'ready_at' => null]),
            self::STATUS_READY => $this->update(['ready_at' => now()]),
            'packed' => $this->update(['packed_at' => now()]),
            'shipped' => $this->update(['shipped_at' => now()]),
            'out_for_delivery' => $this->update(['out_for_delivery_at' => now()]),
            'delivered' => $this->update(['delivered_at' => now()]),
            'cancelled' => $this->update(['cancelled_at' => now()]),
            default => null,
        };
    }

    /**
     * An order is placed, made, and then ready to collect. Three steps, and the
     * customer is standing in the shop for the third — anything more is noise.
     *
     * Historical orders still carry delivery-era statuses, so each step reads
     * from collectionStage() rather than matching on the raw value.
     */
    public function getTrackingSteps(): array
    {
        $stage = $this->collectionStage();

        return [
            [
                'key' => 'ordered',
                'label' => 'Ordered',
                'icon' => 'clipboard-check',
                'completed' => true,
                'current' => false,
                'timestamp' => $this->created_at,
            ],
            [
                'key' => self::STATUS_PREPARING,
                'label' => 'Preparing',
                'icon' => 'cube',
                'completed' => $stage === self::STATUS_READY,
                'current' => $stage === self::STATUS_PREPARING,
                'timestamp' => $this->preparing_at,
            ],
            [
                'key' => self::STATUS_READY,
                'label' => 'Ready',
                'icon' => 'check-circle',
                'completed' => $stage === self::STATUS_READY,
                'current' => $stage === self::STATUS_READY,
                'timestamp' => $this->ready_at,
            ],
        ];
    }

    /**
     * Which of the three steps this order sits at, whatever its stored status.
     * Delivery-era values are folded in so old orders still render.
     */
    public function collectionStage(): string
    {
        return self::stageFor((string) $this->status);
    }

    /** The same mapping without needing a model — for grouping query results. */
    public static function stageFor(string $status): string
    {
        return match ($status) {
            self::STATUS_CANCELLED, 'returned' => self::STATUS_CANCELLED,
            self::STATUS_READY, 'packed', 'shipped', 'out_for_delivery', 'delivered' => self::STATUS_READY,
            default => self::STATUS_PREPARING,
        };
    }

    public function isPreparing(): bool
    {
        return $this->collectionStage() === self::STATUS_PREPARING;
    }

    public function isReady(): bool
    {
        return $this->collectionStage() === self::STATUS_READY;
    }

    /** How long the kitchen is given before an order counts as ready. */
    public static function collectionPrepMinutes(): int
    {
        return max(0, (int) Setting::get('collection_prep_minutes', 15));
    }

    /**
     * Move every order that has been preparing for longer than the prep window
     * to ready.
     *
     * This server has no cron (`crontab` is not even installed), so the console
     * command that would normally do this on a schedule cannot be relied on.
     * Calling it when order pages load keeps the stored status honest without
     * any infrastructure; the command still exists for when a scheduler is
     * available, and the two are idempotent.
     *
     * @return int number of orders released
     */
    public static function releaseOrdersDueForCollection(): int
    {
        $cutoff = now()->subMinutes(self::collectionPrepMinutes());

        return static::query()
            ->where('status', self::STATUS_PREPARING)
            ->whereNotNull('preparing_at')
            ->where('preparing_at', '<=', $cutoff)
            ->update([
                'status' => self::STATUS_READY,
                'ready_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, $this->total - $this->paid_amount);
    }
}
