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
