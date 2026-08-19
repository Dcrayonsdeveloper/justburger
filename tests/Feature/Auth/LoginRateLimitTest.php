<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginRateLimitTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('');
        $this->app['cache']->flush();
    }

    /**
     * Viewing the sign-in page used to count against the same limit as trying
     * to sign in, so twenty page loads returned 429 and there was no way back
     * to the form.
     */
    public function test_the_login_page_can_be_loaded_repeatedly(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $this->get('/login')->assertOk();
        }
    }

    public function test_the_register_page_can_be_loaded_repeatedly(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $this->get('/register')->assertRedirect(route('login', ['mode' => 'register']));
        }
    }

    public function test_the_password_reset_page_can_be_loaded_repeatedly(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $this->get('/password/reset')->assertOk();
        }
    }

    /** Submissions are still limited — that is what brute force uses. */
    public function test_repeated_login_attempts_are_still_throttled(): void
    {
        User::factory()->create([
            'username' => 'throttle_target',
            'password' => bcrypt('password'),
        ]);

        $throttled = false;

        for ($i = 0; $i < 15; $i++) {
            $response = $this->post('/login', [
                'email' => 'throttle_target',
                'password' => 'wrong-password',
            ]);

            if ($response->getStatusCode() === 429) {
                $throttled = true;
                break;
            }
        }

        $this->assertTrue($throttled, 'repeated failed sign-ins should eventually be rate limited');
    }

    /** A visitor locked out of submitting must still be able to reach the form. */
    public function test_the_page_still_loads_after_submissions_are_throttled(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->post('/login', ['email' => 'nobody', 'password' => 'wrong']);
        }

        $this->get('/login')->assertOk();
    }
}
