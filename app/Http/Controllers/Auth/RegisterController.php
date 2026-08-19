<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AnalyticsService;
use App\Support\Username;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm(): RedirectResponse
    {
        return redirect()->route('login', ['mode' => 'register']);
    }

    /**
     * Sign-up asks for a username and a password and nothing else — no email,
     * no phone. Nothing here can identify a person, which is the point.
     *
     * The trade-off is that a forgotten password cannot be reset: there is no
     * channel to reach the account holder. That is a deliberate choice.
     */
    public function register(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'username' => Username::rules(),
            'password' => ['required', 'confirmed', Password::defaults()],
        ], Username::messages());

        $username = strtolower($validated['username']);

        $user = User::create([
            'uuid' => Str::uuid(),
            'username' => $username,
            // first_name is NOT NULL and shown around the account area. With no
            // real name collected, the username stands in for it; checkout asks
            // separately for the name to put on the order.
            'first_name' => $username,
            'last_name' => '',
            'email' => null,
            'phone' => null,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Registered() fans out to the email-verification listener, which has
        // nothing to send to. Skip it rather than rely on the catch below.
        if ($user->email) {
            try {
                event(new Registered($user));
            } catch (\Throwable $e) {
                Log::warning('Registration verification email/event failed: ' . $e->getMessage());
            }
        }

        try {
            app(AnalyticsService::class)->trackCompleteRegistration($user, $request);
        } catch (\Throwable $e) {
            Log::warning('trackCompleteRegistration failed: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('login')->with('success', 'Account created. Please sign in to continue.');
    }
}
