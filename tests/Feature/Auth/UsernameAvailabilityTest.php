<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsernameAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private function check(string $username): \Illuminate\Testing\TestResponse
    {
        return $this->getJson('/auth/username-available?username=' . urlencode($username));
    }

    public function test_a_free_username_is_available(): void
    {
        $this->check('hungry_james')
            ->assertOk()
            ->assertJson(['available' => true]);
    }

    public function test_a_taken_username_is_not_available(): void
    {
        User::factory()->create(['username' => 'hungry_james']);

        $this->check('hungry_james')
            ->assertOk()
            ->assertJson(['available' => false, 'message' => 'Already taken.']);
    }

    public function test_a_reserved_username_is_not_available(): void
    {
        $this->check('admin')->assertJson(['available' => false]);
        $this->check('support')->assertJson(['available' => false]);
    }

    public function test_malformed_usernames_are_not_available(): void
    {
        foreach (['ab', 'Has-Caps', 'has spaces', '9leading', str_repeat('a', 31)] as $bad) {
            $this->check($bad)->assertJson(['available' => false]);
        }
    }

    public function test_an_empty_username_is_not_available_and_says_nothing(): void
    {
        $this->check('')->assertJson(['available' => false, 'message' => null]);
    }

    /**
     * The live check and the registration validator must agree. If this drifts,
     * the field goes green and the form then rejects the same value.
     */
    public function test_the_live_check_agrees_with_registration(): void
    {
        foreach (['ab', 'Has-Caps', '9leading', 'admin', str_repeat('a', 31)] as $bad) {
            $this->check($bad)->assertJson(['available' => false], "live check accepted '{$bad}'");

            $this->post('/register', [
                'username' => $bad,
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ])->assertSessionHasErrors('username', "registration accepted '{$bad}'");
        }

        $this->check('good_name_here')->assertJson(['available' => true]);

        $this->post('/register', [
            'username' => 'good_name_here',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertSessionDoesntHaveErrors('username');
    }
}
