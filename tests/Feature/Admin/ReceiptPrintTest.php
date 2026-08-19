<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiptPrintTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        Admin::create(['user_id' => $this->admin->id, 'role' => 'super_admin', 'is_active' => true]);
    }

    private function makeOrder(array $attributes = []): Order
    {
        // created_at is not fillable, so back-dating has to be forced after the
        // insert — passing it to create() is silently ignored.
        $createdAt = $attributes['created_at'] ?? null;
        unset($attributes['created_at']);

        $order = Order::create(array_merge([
            'status' => Order::STATUS_PREPARING,
            'preparing_at' => now(),
            'receipt_printed_at' => null,
            'payment_status' => 'pending',
            'subtotal' => 7.20, 'discount' => 0, 'tax' => 0,
            'shipping_cost' => 0, 'total' => 7.20, 'paid_amount' => 0,
            'source' => 'web',
        ], $attributes));

        if ($createdAt) {
            $order->forceFill(['created_at' => $createdAt])->save();
        }

        return $order->fresh();
    }

    public function test_an_unprinted_order_is_listed_as_pending(): void
    {
        $order = $this->makeOrder();

        $this->actingAs($this->admin, 'admin')
            ->getJson(route('admin.orders.pending-prints'))
            ->assertOk()
            ->assertJsonPath('orders.0.id', $order->id)
            ->assertJsonPath('orders.0.order_number', $order->order_number);
    }

    public function test_a_printed_order_is_not_listed(): void
    {
        $this->makeOrder(['receipt_printed_at' => now()]);

        $this->actingAs($this->admin, 'admin')
            ->getJson(route('admin.orders.pending-prints'))
            ->assertOk()
            ->assertJsonCount(0, 'orders');
    }

    public function test_cancelled_orders_are_never_printed(): void
    {
        $this->makeOrder(['status' => Order::STATUS_CANCELLED]);

        $this->actingAs($this->admin, 'admin')
            ->getJson(route('admin.orders.pending-prints'))
            ->assertJsonCount(0, 'orders');
    }

    /**
     * Switching the till on must not fire the whole back catalogue at the
     * printer, so anything older than the lookback is ignored.
     */
    public function test_old_orders_are_not_dragged_out(): void
    {
        $this->makeOrder(['created_at' => now()->subHours(5)]);

        $this->actingAs($this->admin, 'admin')
            ->getJson(route('admin.orders.pending-prints'))
            ->assertJsonCount(0, 'orders');
    }

    public function test_the_since_parameter_cannot_reach_further_back_than_the_cap(): void
    {
        $this->makeOrder(['created_at' => now()->subDays(3)]);

        // A client asking for a week of history still only gets the capped window.
        $this->actingAs($this->admin, 'admin')
            ->getJson(route('admin.orders.pending-prints', ['since' => now()->subWeek()->toIso8601String()]))
            ->assertJsonCount(0, 'orders');
    }

    public function test_marking_an_order_printed_records_the_time(): void
    {
        $order = $this->makeOrder();

        $this->actingAs($this->admin, 'admin')
            ->postJson(route('admin.orders.printed', $order))
            ->assertOk();

        $this->assertNotNull($order->fresh()->receipt_printed_at);
    }

    /** Two tills racing, or a retry after a dropped response, must not double-stamp. */
    public function test_marking_printed_is_idempotent(): void
    {
        $order = $this->makeOrder();

        $this->actingAs($this->admin, 'admin')->postJson(route('admin.orders.printed', $order))->assertOk();
        $first = $order->fresh()->receipt_printed_at;

        $this->actingAs($this->admin, 'admin')->postJson(route('admin.orders.printed', $order))->assertOk();

        $this->assertEquals($first, $order->fresh()->receipt_printed_at);
    }

    public function test_the_endpoints_require_an_admin(): void
    {
        $order = $this->makeOrder();

        $this->getJson(route('admin.orders.pending-prints'))->assertUnauthorized();
        $this->postJson(route('admin.orders.printed', $order))->assertUnauthorized();

        $this->assertNull($order->fresh()->receipt_printed_at);
    }
}
