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
        // The sign-in form asks for "email or phone number" in one box, so the
        // identifier arrives here as `email` whichever it is. Decide which
        // column to authenticate against rather than assuming an address.
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($validated['email']);
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if ($field === 'phone') {
            // Match however the number was stored: with or without spaces,
            // dashes or a leading +.
            $digits = preg_replace('/\D/', '', $identifier);
            $user = User::whereRaw(
                "REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', '') LIKE ?",
                ['%' . $digits]
            )->first();

            $identifier = $user?->email ?? $identifier;
        }

        $credentials = ['email' => $identifier, 'password' => $validated['password']];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->mergeGuestCart($request);
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->intended(route('account.dashboard'));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
                'errors' => ['email' => ['The provided credentials do not match our records.']],
            ], 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
