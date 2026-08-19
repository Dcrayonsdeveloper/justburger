<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * One definition of what a username may be.
 *
 * The sign-up form checks availability while the visitor types, and the
 * registration request validates again on submit. If those two disagreed by so
 * much as a character, the field would go green and then be rejected — so both
 * paths read their rules from here.
 */
final class Username
{
    public const MIN = 3;
    public const MAX = 30;

    /** Lowercase, starts with a letter, then letters/numbers/underscores. */
    public const PATTERN = '/^[a-z][a-z0-9_]{2,29}$/';

    /**
     * Names that must not belong to a customer — either because they imply
     * authority or because they collide with a route segment.
     */
    public const RESERVED = [
        'admin', 'administrator', 'root', 'superuser', 'sysadmin', 'system',
        'staff', 'support', 'help', 'helpdesk', 'moderator', 'mod', 'owner',
        'justburgers', 'just_burgers', 'justburger', 'official',
        'api', 'login', 'logout', 'register', 'signup', 'signin', 'account',
        'password', 'settings', 'checkout', 'cart', 'order', 'orders', 'menu',
        'null', 'undefined', 'none', 'anonymous', 'guest', 'user', 'test',
    ];

    /**
     * @return array<int, mixed> Validation rules for a submitted username.
     */
    public static function rules(?int $ignoreUserId = null): array
    {
        $unique = Rule::unique('users', 'username');

        if ($ignoreUserId !== null) {
            $unique->ignore($ignoreUserId);
        }

        return [
            'required',
            'string',
            'lowercase',
            'min:' . self::MIN,
            'max:' . self::MAX,
            'regex:' . self::PATTERN,
            Rule::notIn(self::RESERVED),
            $unique,
        ];
    }

    /**
     * @return array<string, string> Messages that explain the format in words.
     */
    public static function messages(): array
    {
        return [
            'username.required' => 'Please choose a username.',
            'username.lowercase' => 'Usernames are lowercase only.',
            'username.min' => 'Usernames must be at least ' . self::MIN . ' characters.',
            'username.max' => 'Usernames can be at most ' . self::MAX . ' characters.',
            'username.regex' => 'Use lowercase letters, numbers and underscores, starting with a letter.',
            'username.not_in' => 'That username is reserved. Please pick another.',
            'username.unique' => 'That username is already taken.',
        ];
    }

    public static function isReserved(string $username): bool
    {
        return in_array(strtolower($username), self::RESERVED, true);
    }

    public static function isWellFormed(string $username): bool
    {
        return (bool) preg_match(self::PATTERN, $username);
    }

    /**
     * Build a free, well-formed username from arbitrary text. Used to give
     * existing accounts a username without asking them for one.
     */
    public static function generateFrom(string $seed): string
    {
        $base = strtolower(Str::ascii($seed));
        $base = preg_replace('/[^a-z0-9_]/', '', $base) ?? '';
        $base = ltrim($base, '0123456789_');

        if (strlen($base) < self::MIN) {
            $base = 'user' . $base;
        }

        $base = substr($base, 0, self::MAX - 3);
        $candidate = $base;
        $suffix = 1;

        while (self::isReserved($candidate) || User::where('username', $candidate)->exists()) {
            $suffix++;
            $candidate = $base . $suffix;
        }

        return $candidate;
    }
}
