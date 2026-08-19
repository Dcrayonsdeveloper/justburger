<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse|JsonResponse
    {
        // Sign-in takes one box, so the identifier arrives as `email` whatever
        // the visitor typed — the field name is kept for the storefront modal,
        // which posts the same key. New accounts have only a username; older
        // ones may still be reached by email or phone.
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = $this->resolveUser(trim($validated['email']));

        // Authenticate on the primary key once the account is found. Matching on
        // username or email instead would be a trap: both are nullable, and a
        // null lookup becomes `IS NULL`, which matches every account missing
        // that field rather than none of them.
        $credentials = [
            'id' => $user?->getKey(),
            'password' => $validated['password'],
        ];

        if ($user && Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->mergeGuestCart($request);
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json(['success' => true]);
            }

            // Land on the storefront, not the account area — people sign in to
            // order. intended() still wins, so anyone bounced here from checkout
            // is returned there instead.
            return redirect()->intended(route('home'));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Incorrect username or password. Please try again.',
                'errors' => ['email' => ['Incorrect username or password. Please try again.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Incorrect username or password. Please try again.',
        ])->onlyInput('email');
    }

    /**
     * Find the account behind whatever was typed: a username, or — for accounts
     * that predate username sign-in — an email address or phone number.
     */
    private function resolveUser(string $identifier): ?User
    {
        if ($identifier === '') {
            return null;
        }

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return User::where('email', $identifier)->first();
        }

        if ($user = User::where('username', strtolower($identifier))->first()) {
            return $user;
        }

        $digits = preg_replace('/\D/', '', $identifier) ?? '';

        if ($digits === '') {
            return null;
        }

        // Match however the number was stored: with or without spaces, dashes,
        // brackets or a leading +.
        return User::whereRaw(
            "REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', '') LIKE ?",
            ['%' . $digits]
        )->first();
    }

    private function mergeGuestCart(Request $request): void
    {
        $sessionId = $request->session()->getId();
        $guestCart = Cart::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->with('items')
            ->first();

        if (!$guestCart || $guestCart->items->isEmpty()) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => $sessionId, 'subtotal' => 0, 'discount' => 0, 'tax' => 0, 'total' => 0]
        );

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()
                ->where('product_id', $item->product_id)
                ->where('variant_id', $item->variant_id)
                ->first();

            if ($existing) {
                $existing->update(['quantity' => $existing->quantity + $item->quantity]);
            } else {
                $userCart->items()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        }

        $guestCart->items()->delete();
        $guestCart->delete();
        $userCart->recalculate();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
