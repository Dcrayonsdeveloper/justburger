<?php

namespace Tests\Feature\Checkout;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Checkout fataled with "Call to a member function pluck() on null" whenever a
 * cart item had a variant: the code read $item->variant->attributeValues, but
 * that relation is defined on Product, not ProductVariant, so it came back null.
 *
 * Most items here have no variant, which is why it stayed hidden until someone
 * ordered one.
 */
class VariantOrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_variant_has_no_attribute_values_relation(): void
    {
        $this->assertFalse(
            method_exists(ProductVariant::class, 'attributeValues'),
            'ProductVariant must not appear to have attributeValues — the checkout bug came from assuming it did'
        );
    }

    public function test_a_variant_exposes_a_name_to_store_on_the_order_item(): void
    {
        $category = Category::create([
            'name' => 'Variant Test Cat',
            'slug' => 'variant-test-cat',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Chicken Wings',
            'slug' => 'chicken-wings-variant-test',
            'sku' => 'JB-WINGS',
            'price' => 4.99,
            'mrp' => 4.99,
            'cost_price' => 2.00,
            'stock_quantity' => 25,
            'category_id' => $category->id,
            'status' => 'approved',
            'is_active' => true,
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => '10 pieces',
            'sku' => 'JB-WINGS-10',
            'mrp' => 4.99,
            'price' => 4.99,
            'stock_quantity' => 25,
            'is_active' => true,
        ]);

        // What checkout now stores as variant_name.
        $this->assertSame('10 pieces', $variant->name);

        // And the shape that used to crash returns null rather than a collection.
        $this->assertNull($variant->attributeValues);
    }
}
