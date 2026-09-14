<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Topping extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'topping_group_id',
        'group',
        'is_preselected',
        'is_active',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_preselected' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * A topping with no price is shown as "Included" rather than "+£0.00".
     * Pre-select is now a per-product decision (product_topping.is_default),
     * so it no longer has any bearing on what a topping costs.
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Deliberately not named group() — the legacy `group` string column is
     * still on the table, so that name would resolve to the column, not here.
     */
    public function toppingGroup(): BelongsTo
    {
        return $this->belongsTo(ToppingGroup::class, 'topping_group_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_topping')
            ->withPivot('is_default');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }
}
