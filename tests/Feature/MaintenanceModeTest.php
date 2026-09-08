<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Tests\TestCase;

/**
 * A maintenance window must not swallow payment callbacks. Stripe posts
 * server-to-server, so it cannot carry the bypass cookie — if it is blocked, a
 * customer gets charged and the order is never confirmed.
 */
class MaintenanceModeTest extends TestCase
{
    /**
     * bootstrap/app.php registers these through
     * PreventRequestsDuringMaintenance::except(), which stores them in a static
     * — not on the instance — so read them from there.
     */
    private function exceptions(): array
    {
        $property = new \ReflectionProperty(PreventRequestsDuringMaintenance::class, 'neverPrevent');
        $property->setAccessible(true);

        return $property->getValue();
    }

    public function test_payment_webhooks_are_exempt_from_maintenance_mode(): void
    {
        $except = $this->exceptions();

        $this->assertContains('api/webhook/*', $except, 'the Stripe endpoint must stay reachable while the site is down');
        $this->assertContains('webhook/*', $except);
    }

    /**
     * The shop still has to feed the kitchen while the site is closed, so the
     * till's front door, the orders screen it lands on and the login it needs
     * stay open. All of it is still behind the admin guard — this exempts a
     * till, not the panel.
     */
    public function test_the_till_stays_reachable_during_maintenance(): void
    {
        $except = $this->exceptions();

        $this->assertContains('jb-till-2026', $except, 'the shop opens the till by this address');
        $this->assertContains('admin/login', $except, 'staff cannot reach the till if they cannot sign in');
        $this->assertContains('admin/orders', $except, 'the till is the orders screen');
        $this->assertContains('admin/orders/*', $except, 'it polls, prints and marks printed through these paths');
    }

    /** The exemption must be narrow — the storefront still has to close. */
    public function test_the_storefront_is_not_exempt(): void
    {
        $except = $this->exceptions();

        foreach (['/', '*', 'menu', 'checkout', 'admin/*'] as $shouldNotBeExempt) {
            $this->assertNotContains(
                $shouldNotBeExempt,
                $except,
                "'{$shouldNotBeExempt}' must NOT bypass maintenance mode"
            );
        }
    }
}
