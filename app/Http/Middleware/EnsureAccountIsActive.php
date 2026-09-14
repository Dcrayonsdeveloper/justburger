<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Signs out anyone whose account was deactivated or deleted while they were
 * still logged in.
 *
 * Deactivating from the admin already drops the stored sessions, which covers
 * the common case immediately. This is the guarantee behind it: whatever route
 * a live session came in on, it stops at the next request rather than running
 * until the session happens to expire.
 */
class EnsureAccountIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Staff and admins are managed separately and must not be caught here.
        if ($user && $user->role === 'customer' && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = 'This account has been deactivated. Please contact us if you think this is a mistake.';

            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 401);
            }

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
