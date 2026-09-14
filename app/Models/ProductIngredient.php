<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One thing an item is made of — "Lettuce", "Burger sauce".
 *
 * Ingredients belong to the product rather than to a shared library, because
 * what is in a burger is not a menu-wide list. They carry no price: they are
 * already part of the item, so the popup shows them ticked and "Included", and
 * the only thing a customer can do is take one off.
 */
class ProductIngredient extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'position',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
