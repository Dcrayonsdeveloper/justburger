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
     * Sign-up asks for a name, a username and a password — no email, no phone.
     * Nothing here can identify a person, which is the point.
     *
     * The name and the username do different jobs. The name is what the shop
     * reads on a receipt and what the customer sees in their account, and two
     * customers called John Smith are free to both use it. The username is only
     * the thing typed to sign in, so it has to stay unique.
     *
     * The trade-off is that a forgotten password cannot be reset: there is no
     * channel to reach the account holder. That is a deliberate choice.
     */
    public function register(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => Username::rules(),
            'password' => ['required', 'confirmed', Password::defaults()],
        ], Username::messages());

        $username = strtolower($validated['username']);

        // Split on the first space so "John Smith" fills both columns, and a
        // single word simply leaves the surname empty.
        $name = trim(preg_replace('/\s+/', ' ', $validated['name']));
        [$firstName, $lastName] = array_pad(explode(' ', $name, 2), 2, '');

        $user = User::create([
            'uuid' => Str::uuid(),
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
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
