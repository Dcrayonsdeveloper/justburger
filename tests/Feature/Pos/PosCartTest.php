<?php

namespace Tests\Feature\Pos;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\DiscountRule;
use App\Models\PosRegister;
use App\Models\Product;
use App\Models\Staff;
use App\Models\StaffShift;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosCartTest extends TestCase
{
    use RefreshDatabase;

    private array $posSession;
    private Product $product;
    private Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        $store = Store::create(['name' => 'Test Store', 'code' => 'TS-01', 'is_active' => true]);
        $this->store = $store;
        $register = PosRegister::create(['store_id' => $store->id, 'name' => 'C1', 'device_id' => 'POS-T1', 'status' => 'active']);
        $user = User::factory()->create(['first_name' => 'Cashier', 'role' => 'admin']);
        $staff = Staff::create(['user_id' => $user->id, 'employee_id' => 'E-01', 'role' => 'cashier', 'store_id' => $store->id, 'pin' => bcrypt('1234'), 'is_active' => true]);
        $shift = StaffShift::create(['staff_id' => $staff->id, 'store_id' => $store->id, 'register_id' => $register->id, 'shift_start' => now(), 'opening_cash' => 1000, 'status' => 'open']);

        $category = Category::create(['name' => 'Kids Wear', 'slug' => 'kids-wear', 'is_active' => true]);

        $this->product = Product::create([
            'name' => 'Test T-Shirt',
            'slug' => 'test-t-shirt',
            'sku' => 'TST-001',
            'price' => 499,
            'mrp' => 699,
            'cost_price' => 200,
            'stock_quantity' => 50,
            'category_id' => $category->id,
            'status' => 'approved',
            'is_active' => true,
        ]);

        $this->posSession = [
            'pos_staff_id' => $staff->id,
            'pos_store_id' => $store->id,
            'pos_device_id' => 'POS-T1',
            'pos_register_id' => $register->id,
            'pos_shift_id' => $shift->id,
            'pos_staff_name' => 'Cashier',
            'pos_staff_role' => 'cashier',
        ];
    }

    public function test_add_product_to_cart(): void
    {
        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/add', [
                'product_id' => $this->product->id,
                'quantity' => 1,
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['cart' => ['items', 'subtotal', 'total']]);
    }

    public function test_cannot_add_out_of_stock_product(): void
    {
        $this->product->update(['stock_quantity' => 0]);

        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/add', [
                'product_id' => $this->product->id,
                'quantity' => 1,
            ]);

        $response->assertStatus(422);
    }

    public function test_update_cart_item_quantity(): void
    {
        // Add item first
        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        // Get cart to find item ID
        $cartResponse = $this->withSession($this->posSession)->get('/pos/cart/data');
        $cart = $cartResponse->json('cart');
        $itemId = $cart['items'][0]['cart_item_id'];

        // Update quantity
        $response = $this->withSession($this->posSession)
            ->patch('/pos/cart/' . $itemId, ['quantity' => 3]);

        $response->assertStatus(200);
    }

    public function test_remove_item_from_cart(): void
    {
        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        $cartResponse = $this->withSession($this->posSession)->get('/pos/cart/data');
        $itemId = $cartResponse->json('cart.items.0.cart_item_id');

        $response = $this->withSession($this->posSession)
            ->delete('/pos/cart/' . $itemId);

        $response->assertStatus(200);
        $this->assertCount(0, $response->json('cart.items'));
    }

    public function test_clear_cart(): void
    {
        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 2]);

        $response = $this->withSession($this->posSession)
            ->delete('/pos/cart');

        $response->assertStatus(200);
        $this->assertCount(0, $response->json('cart.items'));
    }

    public function test_get_cart_data(): void
    {
        $response = $this->withSession($this->posSession)
            ->get('/pos/cart/data');

        $response->assertStatus(200);
        $response->assertJsonStructure(['cart' => ['items', 'subtotal', 'discount', 'tax', 'total']]);
    }

    public function test_apply_discount_rule_without_pin(): void
    {
        $rule = DiscountRule::create(['label' => 'Loyalty 10%', 'percent' => 10, 'requires_pin' => false, 'is_active' => true]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/discount', ['type' => 'percentage', 'value' => $rule->percent, 'rule_id' => $rule->id]);

        $response->assertStatus(200);
        $this->assertEquals(49.9, $response->json('cart.discount'));
    }

    public function test_apply_discount_rule_requires_pin_and_rejects_wrong_pin(): void
    {
        Staff::create([
            'user_id' => User::factory()->create()->id,
            'employee_id' => 'MGR-01',
            'role' => 'manager',
            'store_id' => $this->store->id,
            'pin' => bcrypt('9999'),
            'is_active' => true,
        ]);
        $rule = DiscountRule::create(['label' => 'Clearance 20%', 'percent' => 20, 'requires_pin' => true, 'is_active' => true]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/discount', [
                'type' => 'percentage', 'value' => $rule->percent, 'rule_id' => $rule->id, 'manager_pin' => '0000',
            ]);

        $response->assertStatus(401);
    }

    public function test_apply_discount_rule_accepts_correct_manager_pin(): void
    {
        Staff::create([
            'user_id' => User::factory()->create()->id,
            'employee_id' => 'MGR-01',
            'role' => 'manager',
            'store_id' => $this->store->id,
            'pin' => bcrypt('9999'),
            'is_active' => true,
        ]);
        $rule = DiscountRule::create(['label' => 'Clearance 20%', 'percent' => 20, 'requires_pin' => true, 'is_active' => true]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/discount', [
                'type' => 'percentage', 'value' => $rule->percent, 'rule_id' => $rule->id, 'manager_pin' => '9999',
            ]);

        $response->assertStatus(200);
        $this->assertEquals(99.8, $response->json('cart.discount'));
    }

    public function test_discount_rule_rejects_over_max_cart_value(): void
    {
        $rule = DiscountRule::create([
            'label' => 'Small Basket 15%', 'percent' => 15, 'max_cart_value' => 100, 'requires_pin' => false, 'is_active' => true,
        ]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);

        $response = $this->withSession($this->posSession)
            ->post('/pos/cart/discount', ['type' => 'percentage', 'value' => $rule->percent, 'rule_id' => $rule->id]);

        $response->assertStatus(422);
    }

    public function test_remove_manual_discount(): void
    {
        $rule = DiscountRule::create(['label' => 'Loyalty 10%', 'percent' => 10, 'requires_pin' => false, 'is_active' => true]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);
        $this->withSession($this->posSession)
            ->post('/pos/cart/discount', ['type' => 'percentage', 'value' => $rule->percent, 'rule_id' => $rule->id]);

        $response = $this->withSession($this->posSession)
            ->delete('/pos/cart/discount');

        $response->assertStatus(200);
        $this->assertEquals(0, $response->json('cart.discount'));
        $this->assertNull($response->json('cart.manual_discount'));
    }

    public function test_remove_coupon(): void
    {
        Coupon::create(['code' => 'SAVE10', 'name' => 'Save 10%', 'type' => 'percentage', 'value' => 10, 'is_active' => true]);

        $this->withSession($this->posSession)
            ->post('/pos/cart/add', ['product_id' => $this->product->id, 'quantity' => 1]);
        $this->withSession($this->posSession)
            ->post('/pos/cart/coupon', ['code' => 'SAVE10']);

        $response = $this->withSession($this->posSession)
            ->delete('/pos/cart/coupon');

        $response->assertStatus(200);
        $this->assertNull($response->json('cart.coupon'));
        $this->assertEquals(0, $response->json('cart.discount'));
    }
}
