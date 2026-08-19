<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsernameLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_their_username(): void
    {
        $user = User::factory()->create([
            'username' => 'hungry_james',
            'email' => null,
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'hungry_james',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_username_login_is_case_insensitive(): void
    {
        $user = User::factory()->create([
            'username' => 'hungry_james',
            'email' => null,
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'HUNGRY_JAMES',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** Accounts that predate username sign-in must keep working. */
    public function test_legacy_user_can_still_login_with_email(): void
    {
        $user = User::factory()->create([
            'username' => 'legacy_user',
            'email' => 'legacy@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'legacy@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Eleven other code paths create users without a username. Authenticating
     * on a nullable column would turn `where(username, null)` into `IS NULL`
     * and match those accounts collectively, so guard the case explicitly.
     */
    public function test_accounts_without_a_username_do_not_collide(): void
    {
        $a = User::factory()->create([
            'username' => null,
            'email' => 'a@example.com',
            'password' => bcrypt('secret-a'),
        ]);

        User::factory()->create([
            'username' => null,
            'email' => 'b@example.com',
            'password' => bcrypt('secret-b'),
        ]);

        // B's password must not open A's account.
        $this->post('/login', ['email' => 'a@example.com', 'password' => 'secret-b']);
        $this->assertGuest();

        $this->post('/login', ['email' => 'a@example.com', 'password' => 'secret-a']);
        $this->assertAuthenticatedAs($a);
    }

    public function test_wrong_password_is_rejected(): void
    {
        User::factory()->create([
            'username' => 'hungry_james',
            'email' => null,
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'hungry_james',
            'password' => 'not-the-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_unknown_username_is_rejected(): void
    {
        $response = $this->post('/login', [
            'email' => 'nobody_here',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
