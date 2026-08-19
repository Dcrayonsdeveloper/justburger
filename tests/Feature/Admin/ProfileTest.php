<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Only some back-office users have a row in `admins`. The profile page used
     * to read $admin->role straight off a null for everyone who did not, which
     * is a 500 rather than a missing badge.
     */
    public function test_profile_loads_for_a_user_without_an_admin_row(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
            'is_active' => true,
        ]);

        $this->assertNull($user->admin);

        $this->actingAs($user, 'admin')
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('Staff');
    }

    public function test_profile_loads_for_a_user_with_an_admin_row(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        Admin::create([
            'user_id' => $user->id,
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->actingAs($user->fresh(), 'admin')
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('Super Admin');
    }

    public function test_an_inactive_user_without_an_admin_row_still_renders(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
            'is_active' => false,
        ]);

        $this->actingAs($user, 'admin')
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('Inactive');
    }
}
