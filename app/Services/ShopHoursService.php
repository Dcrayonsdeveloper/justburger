<?php

namespace App\Services;

use App\Models\Setting;
use Carbon\Carbon;

/**
 * Knows the shop's opening hours and answers "is the shop open right now?".
 *
 * Hours default to the values below and can be overridden by an `opening_hours`
 * setting (same shape, JSON-encoded): keyed by ISO-8601 weekday (1=Mon … 7=Sun),
 * each value a [open, close] pair in 24-hour "HH:MM" UK local time.
 */
class ShopHoursService
{
    private const TZ = 'Europe/London';

    private const DEFAULT_HOURS = [
        1 => ['12:00', '22:00'], // Mon
        2 => ['12:00', '22:00'], // Tue
        3 => ['12:00', '22:30'], // Wed
        4 => ['12:00', '22:30'], // Thu
        5 => ['11:45', '23:00'], // Fri
        6 => ['11:45', '23:00'], // Sat
        7 => ['16:00', '22:00'], // Sun
    ];

    /** @return array<int, array{0:string,1:string}> */
    private function hours(): array
    {
        $raw = Setting::get('opening_hours');
        if ($raw) {
            $decoded = is_array($raw) ? $raw : json_decode($raw, true);
            if (is_array($decoded) && $decoded) {
                $normalised = [];
                foreach ($decoded as $day => $window) {
                    if (is_array($window) && count($window) === 2) {
                        $normalised[(int) $day] = [(string) $window[0], (string) $window[1]];
                    }
                }
                if ($normalised) {
                    return $normalised;
                }
            }
        }

        return self::DEFAULT_HOURS;
    }

    public function now(): Carbon
    {
        return Carbon::now(self::TZ);
    }

    /** Is the shop open at the given moment (default: now, UK time)? */
    public function isOpen(?Carbon $at = null): bool
    {
        $at = $at ? $at->copy()->setTimezone(self::TZ) : $this->now();
        $hours = $this->hours();
        $dow = (int) $at->isoWeekday();

        if (empty($hours[$dow])) {
            return false;
        }

        [$open, $close] = $hours[$dow];
        $openAt  = $at->copy()->setTimeFromTimeString($open);
        $closeAt = $at->copy()->setTimeFromTimeString($close);

        return $at->betweenIncluded($openAt, $closeAt);
    }

    /** The next moment the shop opens, searching up to a week ahead. */
    public function nextOpening(?Carbon $from = null): ?Carbon
    {
        $from = $from ? $from->copy()->setTimezone(self::TZ) : $this->now();
        $hours = $this->hours();

        for ($i = 0; $i < 8; $i++) {
            $day = $from->copy()->addDays($i)->startOfDay();
            $dow = (int) $day->isoWeekday();
            if (empty($hours[$dow])) {
                continue;
            }
            $openAt = $day->copy()->setTimeFromTimeString($hours[$dow][0]);
            if ($openAt->greaterThan($from)) {
                return $openAt;
            }
        }

        return null;
    }

    /** Customer-facing message shown when ordering is attempted while closed. */
    public function closedMessage(): string
    {
        $base = "Sorry, we're closed right now, so we can't take your order.";
        $next = $this->nextOpening();

        if (!$next) {
            return $base;
        }

        $now = $this->now();
        if ($next->isSameDay($now)) {
            $when = 'today at ' . $next->format('g:i A');
        } elseif ($next->isSameDay($now->copy()->addDay())) {
            $when = 'tomorrow at ' . $next->format('g:i A');
        } else {
            $when = 'on ' . $next->format('l') . ' at ' . $next->format('g:i A');
        }

        return "{$base} Online ordering opens {$when}.";
    }
}
