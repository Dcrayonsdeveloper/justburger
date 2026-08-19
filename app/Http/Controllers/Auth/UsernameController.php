<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Username;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    /**
     * Answers "is this username free?" while someone types it into the sign-up
     * form. Format is judged before the database is touched, so a half-typed
     * name never counts as taken.
     *
     * This does confirm whether a given username exists, so the route is rate
     * limited — enumerating the list should be slow enough not to be worth it.
     */
    public function check(Request $request): JsonResponse
    {
        $username = strtolower(trim((string) $request->query('username', '')));

        if ($username === '') {
            return $this->answer(false, null);
        }

        if (strlen($username) < Username::MIN) {
            return $this->answer(false, 'At least ' . Username::MIN . ' characters.');
        }

        if (strlen($username) > Username::MAX) {
            return $this->answer(false, 'At most ' . Username::MAX . ' characters.');
        }

        if (!Username::isWellFormed($username)) {
            return $this->answer(false, 'Lowercase letters, numbers and underscores, starting with a letter.');
        }

        if (Username::isReserved($username)) {
            return $this->answer(false, 'That username is reserved.');
        }

        if (User::where('username', $username)->exists()) {
            return $this->answer(false, 'Already taken.');
        }

        return $this->answer(true, 'Available.');
    }

    private function answer(bool $available, ?string $message): JsonResponse
    {
        return response()->json([
            'available' => $available,
            'message' => $message,
        ]);
    }
}
