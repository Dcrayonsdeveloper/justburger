<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
     * Pre-selected toppings are included with the product at no charge, so a
     * price on one would never be collected. Keep the data honest.
     */
    public function isFree(): bool
    {
        return $this->is_preselected || (float) $this->price <= 0;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
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
