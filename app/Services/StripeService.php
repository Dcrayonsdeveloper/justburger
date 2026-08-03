<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin Stripe API wrapper built on Laravel's HTTP client (no SDK), matching the
 * codebase convention of calling gateways over REST directly.
 *
 * Docs: https://docs.stripe.com/api/checkout/sessions
 */
class StripeService
{
    private const API_BASE = 'https://api.stripe.com/v1';

    /** Signature freshness window in seconds (Stripe default tolerance). */
    private const SIGNATURE_TOLERANCE = 300;

    private function secret(): string
    {
        $secret = config('services.stripe.secret');

        if (empty($secret)) {
            throw new RuntimeException('Stripe secret key is not configured.');
        }

        return $secret;
    }

    /**
     * Create a hosted Checkout Session and return the decoded Stripe response
     * (contains `id` and `url`). Throws on any non-2xx response.
     *
     * @param  array<string,mixed>  $params  Form params (nested arrays are bracket-encoded).
     * @return array<string,mixed>
     */
    public function createCheckoutSession(array $params): array
    {
        $response = Http::asForm()
            ->withToken($this->secret())
            ->timeout(20)
            ->post(self::API_BASE . '/checkout/sessions', $params);

        if (!$response->successful()) {
            throw new RuntimeException('Stripe session creation failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Retrieve a Checkout Session (used as a fallback confirmation on the
     * success page, independent of the webhook).
     *
     * @return array<string,mixed>|null
     */
    public function retrieveSession(string $sessionId): ?array
    {
        $response = Http::withToken($this->secret())
            ->timeout(20)
            ->get(self::API_BASE . '/checkout/sessions/' . $sessionId);

        return $response->successful() ? $response->json() : null;
    }

    /**
     * Verify a Stripe webhook signature against the raw request body.
     *
     * Implements Stripe's `t=...,v1=...` scheme:
     *   expected = HMAC-SHA256( "{t}.{payload}", webhook_secret )
     *
     * @see https://docs.stripe.com/webhooks#verify-manually
     */
    public function verifyWebhookSignature(string $payload, ?string $signatureHeader): bool
    {
        $secret = config('services.stripe.webhook_secret');

        // Fail closed: without a configured secret we cannot trust the payload.
        if (empty($secret) || empty($signatureHeader)) {
            return false;
        }

        $timestamp = null;
        $signatures = [];

        foreach (explode(',', $signatureHeader) as $part) {
            $pair = explode('=', trim($part), 2);
            if (count($pair) !== 2) {
                continue;
            }
            [$key, $value] = $pair;
            if ($key === 't') {
                $timestamp = $value;
            } elseif ($key === 'v1') {
                $signatures[] = $value;
            }
        }

        if ($timestamp === null || $signatures === []) {
            return false;
        }

        // Reject replayed/stale events outside the tolerance window.
        if (abs(time() - (int) $timestamp) > self::SIGNATURE_TOLERANCE) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expected, $signature)) {
                return true;
            }
        }

        return false;
    }
}
