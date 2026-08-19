<?php

namespace Tests\Feature\Account;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderReceiptTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create(['role' => 'customer']);

        $category = Category::create([
            'name' => 'Receipt Test Cat',
            'slug' => 'receipt-test-cat',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'MEXICAN with Fries',
            'slug' => 'mexican-with-fries-receipt',
            'sku' => 'JB-005',
            'price' => 7.20,
            'mrp' => 7.20,
            'cost_price' => 3.00,
            'stock_quantity' => 50,
            'category_id' => $category->id,
            'status' => 'approved',
            'is_active' => true,
        ]);

        $this->order = Order::create([
            'user_id' => $this->owner->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => 7.20,
            'discount' => 0,
            'tax' => 0,
            'shipping_cost' => 0,
            'total' => 7.20,
            'paid_amount' => 0,
            'source' => 'web',
        ]);

        OrderItem::create([
            'order_id' => $this->order->id,
            'product_id' => $product->id,
            'product_name' => 'MEXICAN with Fries',
            'sku' => 'JB-005',
            'mrp' => 7.20,
            'price' => 7.20,
            'quantity' => 1,
            'total' => 7.20,
        ]);
    }

    public function test_the_owner_can_view_their_receipt(): void
    {
        $this->actingAs($this->owner)
            ->get(route('account.orders.receipt', $this->order))
            ->assertOk()
            ->assertSee($this->order->order_number)
            ->assertSee('MEXICAN with Fries');
    }

    /** The receipt exposes order contents, so ownership is the whole guard. */
    public function test_another_customer_cannot_view_someone_elses_receipt(): void
    {
        $stranger = User::factory()->create(['role' => 'customer']);

        $this->actingAs($stranger)
            ->get(route('account.orders.receipt', $this->order))
            ->assertForbidden();
    }

    public function test_a_guest_is_sent_to_sign_in(): void
    {
        $this->get(route('account.orders.receipt', $this->order))
            ->assertRedirect(route('login'));
    }

    /** The view is shared with the admin route; each supplies its own Back link. */
    public function test_the_receipt_links_back_to_the_order(): void
    {
        $this->actingAs($this->owner)
            ->get(route('account.orders.receipt', $this->order))
            ->assertOk()
            ->assertSee(route('account.orders.show', $this->order), false);
    }
}
