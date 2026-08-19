<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_form_is_displayed(): void
    {
        $response = $this->get('/register');

        $response->assertRedirect(route('login', ['mode' => 'register']));
    }

    public function test_new_user_can_register_with_username_and_password(): void
    {
        $response = $this->post('/register', [
            'username' => 'hungry_james',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'username' => 'hungry_james',
            'first_name' => 'hungry_james',
            'role' => 'customer',
        ]);
    }

    /** Storing no contact details is the entire point of the change. */
    public function test_registration_stores_no_email_or_phone(): void
    {
        $this->post('/register', [
            'username' => 'quiet_customer',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $user = User::where('username', 'quiet_customer')->first();

        $this->assertNotNull($user);
        $this->assertNull($user->email);
        $this->assertNull($user->phone);
    }

    public function test_registration_fails_with_missing_required_fields(): void
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['username', 'password']);
    }

    public function test_registration_rejects_a_malformed_username(): void
    {
        foreach (['ab', 'Has-Caps', 'has spaces', '9starts_with_digit', str_repeat('a', 31)] as $bad) {
            $response = $this->post('/register', [
                'username' => $bad,
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ]);

            $response->assertSessionHasErrors('username', "expected '{$bad}' to be rejected");
        }
    }

    public function test_registration_rejects_a_reserved_username(): void
    {
        $response = $this->post('/register', [
            'username' => 'admin',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertDatabaseMissing('users', ['username' => 'admin']);
    }

    public function test_registration_fails_with_duplicate_username(): void
    {
        User::factory()->create(['username' => 'taken_name']);

        $response = $this->post('/register', [
            'username' => 'taken_name',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_registration_fails_with_password_mismatch(): void
    {
        $response = $this->post('/register', [
            'username' => 'mismatch_user',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword!',
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}
