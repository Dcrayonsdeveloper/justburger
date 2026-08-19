<?php

namespace Tests\Feature\Order;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionStatusTest extends TestCase
{
    use RefreshDatabase;

    private function makeOrder(array $attributes = []): Order
    {
        return Order::create(array_merge([
            'status' => Order::STATUS_PREPARING,
            'preparing_at' => now(),
            'payment_status' => 'pending',
            'subtotal' => 7.20,
            'discount' => 0,
            'tax' => 0,
            'shipping_cost' => 0,
            'total' => 7.20,
            'paid_amount' => 0,
            'source' => 'web',
        ], $attributes));
    }

    public function test_an_order_shows_exactly_three_steps(): void
    {
        $steps = $this->makeOrder()->getTrackingSteps();

        $this->assertCount(3, $steps);
        $this->assertSame(['Ordered', 'Preparing', 'Ready'], array_column($steps, 'label'));
    }

    public function test_a_new_order_is_preparing(): void
    {
        $order = $this->makeOrder();

        $this->assertTrue($order->isPreparing());
        $this->assertFalse($order->isReady());
        $this->assertSame(Order::STATUS_PREPARING, $order->collectionStage());
    }

    public function test_an_order_inside_the_prep_window_is_left_alone(): void
    {
        Setting::set('collection_prep_minutes', '15', 'integer');

        $order = $this->makeOrder(['preparing_at' => now()->subMinutes(14)]);

        $this->assertSame(0, Order::releaseOrdersDueForCollection());
        $this->assertSame(Order::STATUS_PREPARING, $order->fresh()->status);
    }

    public function test_an_order_past_the_prep_window_becomes_ready(): void
    {
        Setting::set('collection_prep_minutes', '15', 'integer');

        $order = $this->makeOrder(['preparing_at' => now()->subMinutes(16)]);

        $this->assertSame(1, Order::releaseOrdersDueForCollection());

        $order->refresh();
        $this->assertSame(Order::STATUS_READY, $order->status);
        $this->assertNotNull($order->ready_at);
        $this->assertTrue($order->isReady());
    }

    /** The window is a setting, not a hardcoded 15. */
    public function test_the_prep_window_follows_the_setting(): void
    {
        Setting::set('collection_prep_minutes', '40', 'integer');

        $order = $this->makeOrder(['preparing_at' => now()->subMinutes(20)]);

        $this->assertSame(0, Order::releaseOrdersDueForCollection(), '20 minutes should not be due when the window is 40');
        $this->assertSame(Order::STATUS_PREPARING, $order->fresh()->status);
    }

    public function test_releasing_is_idempotent(): void
    {
        Setting::set('collection_prep_minutes', '15', 'integer');

        $this->makeOrder(['preparing_at' => now()->subMinutes(30)]);

        $this->assertSame(1, Order::releaseOrdersDueForCollection());
        $this->assertSame(0, Order::releaseOrdersDueForCollection());
    }

    public function test_cancelled_orders_are_never_released(): void
    {
        Setting::set('collection_prep_minutes', '15', 'integer');

        $order = $this->makeOrder([
            'status' => Order::STATUS_CANCELLED,
            'preparing_at' => now()->subHours(3),
        ]);

        $this->assertSame(0, Order::releaseOrdersDueForCollection());
        $this->assertSame(Order::STATUS_CANCELLED, $order->fresh()->status);
    }

    /** Historical orders still hold delivery-era statuses and must still render. */
    public function test_legacy_statuses_fold_onto_the_three_stages(): void
    {
        $expected = [
            'pending' => Order::STATUS_PREPARING,
            'confirmed' => Order::STATUS_PREPARING,
            'processing' => Order::STATUS_PREPARING,
            'packed' => Order::STATUS_READY,
            'shipped' => Order::STATUS_READY,
            'out_for_delivery' => Order::STATUS_READY,
            'delivered' => Order::STATUS_READY,
            'cancelled' => Order::STATUS_CANCELLED,
            'returned' => Order::STATUS_CANCELLED,
        ];

        foreach ($expected as $status => $stage) {
            $this->assertSame($stage, Order::stageFor($status), "'{$status}' should map to '{$stage}'");
        }
    }

    public function test_the_console_command_releases_due_orders(): void
    {
        Setting::set('collection_prep_minutes', '15', 'integer');

        $order = $this->makeOrder(['preparing_at' => now()->subMinutes(20)]);

        $this->artisan('orders:release-ready')->assertSuccessful();

        $this->assertSame(Order::STATUS_READY, $order->fresh()->status);
    }

    public function test_admin_can_only_set_the_three_statuses(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Admin::create(['user_id' => $admin->id, 'role' => 'super_admin', 'is_active' => true]);

        $order = $this->makeOrder();

        // A delivery-era status is no longer settable.
        $this->actingAs($admin, 'admin')
            ->put(route('admin.orders.status', $order), ['status' => 'shipped'])
            ->assertSessionHasErrors('status');

        $this->assertSame(Order::STATUS_PREPARING, $order->fresh()->status);

        $this->actingAs($admin, 'admin')
            ->put(route('admin.orders.status', $order), ['status' => Order::STATUS_READY])
            ->assertSessionHasNoErrors();

        $this->assertSame(Order::STATUS_READY, $order->fresh()->status);
    }
}
