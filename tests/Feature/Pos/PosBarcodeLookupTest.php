<?php

namespace Tests\Feature\Pos;

use App\Models\Barcode;
use App\Models\Category;
use App\Models\PosRegister;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Staff;
use App\Models\StaffShift;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosBarcodeLookupTest extends TestCase
{
    use RefreshDatabase;

    private array $posSession;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $store = Store::create(['name' => 'Test Store', 'code' => 'TS-01', 'is_active' => true]);
        $register = PosRegister::create(['store_id' => $store->id, 'name' => 'C1', 'device_id' => 'POS-T1', 'status' => 'active']);
        $user = User::factory()->create(['first_name' => 'Cashier', 'role' => 'admin']);
        $staff = Staff::create(['user_id' => $user->id, 'employee_id' => 'E-01', 'role' => 'cashier', 'store_id' => $store->id, 'pin' => bcrypt('1234'), 'is_active' => true]);
        $shift = StaffShift::create(['staff_id' => $staff->id, 'store_id' => $store->id, 'register_id' => $register->id, 'shift_start' => now(), 'opening_cash' => 1000, 'status' => 'open']);

        $category = Category::create(['name' => 'Kids Wear', 'slug' => 'kids-wear', 'is_active' => true]);

        $this->product = Product::create([
            'name' => 'Test T-Shirt',
            'slug' => 'test-t-shirt',
            'sku' => 'TST-001',
            'marg_code' => 'MARG-777',
            'price' => 499,
            'mrp' => 699,
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

    public function test_lookup_by_product_sku(): void
    {
        $response = $this->withSession($this->posSession)->get('/pos/products/barcode/TST-001');

        $response->assertStatus(200);
        $response->assertJson(['found' => true]);
        $this->assertEquals($this->product->id, $response->json('product.id'));
    }

    public function test_lookup_by_variant_sku(): void
    {
        $variant = ProductVariant::create([
            'product_id' => $this->product->id,
            'name' => 'Large',
            'sku' => 'TST-001-L',
            'stock_quantity' => 10,
            'is_active' => true,
        ]);

        $response = $this->withSession($this->posSession)->get('/pos/products/barcode/TST-001-L');

        $response->assertStatus(200);
        $response->assertJson(['found' => true, 'variant_id' => $variant->id]);
    }

    public function test_lookup_by_barcodes_table_entry(): void
    {
        Barcode::create(['product_id' => $this->product->id, 'barcode' => 'ALT-CODE-1', 'type' => 'code128']);

        $response = $this->withSession($this->posSession)->get('/pos/products/barcode/ALT-CODE-1');

        $response->assertStatus(200);
        $response->assertJson(['found' => true]);
        $this->assertEquals($this->product->id, $response->json('product.id'));
    }

    public function test_lookup_by_marg_code(): void
    {
        $response = $this->withSession($this->posSession)->get('/pos/products/barcode/MARG-777');

        $response->assertStatus(200);
        $response->assertJson(['found' => true]);
        $this->assertEquals($this->product->id, $response->json('product.id'));
    }

    public function test_lookup_returns_404_when_not_found(): void
    {
        $response = $this->withSession($this->posSession)->get('/pos/products/barcode/NOPE-DOES-NOT-EXIST');

        $response->assertStatus(404);
        $response->assertJson(['found' => false]);
    }
}
