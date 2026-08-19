<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Accounts are moving to username + password so that signing up stores no
     * contact details at all. Two consequences for this table:
     *
     *  - `username` becomes the identifier people log in with.
     *  - `email` has to accept null, because new accounts will not have one.
     *    It stays unique; MySQL permits repeated NULLs in a unique index, so
     *    any number of accounts can sit there without an address.
     *
     * Existing rows keep whatever email and phone they already have and are
     * given a username derived from their first name, so nobody is locked out.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable()->unique()->after('uuid');
        });

        $this->backfillUsernames();

        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        // Rows created after this migration have no email, so restoring the NOT
        // NULL constraint would fail. Give them a placeholder first.
        DB::table('users')
            ->whereNull('email')
            ->update(['email' => DB::raw("CONCAT(username, '@placeholder.invalid')")]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 255)->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }

    /**
     * Deliberately self-contained rather than calling App\Support\Username —
     * a migration has to keep producing the same result years from now, even
     * if the application's rules move on.
     */
    private function backfillUsernames(): void
    {
        $taken = [];

        DB::table('users')->orderBy('id')->select('id', 'first_name', 'email')->each(function ($user) use (&$taken) {
            $seed = $user->first_name ?: Str::before((string) $user->email, '@');

            $base = strtolower(Str::ascii($seed));
            $base = preg_replace('/[^a-z0-9_]/', '', $base) ?? '';
            $base = ltrim($base, '0123456789_');

            if (strlen($base) < 3) {
                $base = 'user' . $user->id;
            }

            $base = substr($base, 0, 27);
            $candidate = $base;
            $suffix = 1;

            while (isset($taken[$candidate]) || DB::table('users')->where('username', $candidate)->exists()) {
                $suffix++;
                $candidate = $base . $suffix;
            }

            $taken[$candidate] = true;

            DB::table('users')->where('id', $user->id)->update(['username' => $candidate]);
        });
    }
};
