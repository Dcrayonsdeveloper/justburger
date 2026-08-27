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

    /** Short status line for the checkout banner. */
    public function statusMessage(): string
    {
        if ($this->isOpen()) {
            $close = $this->closeTimeToday();
            return $close
                ? "Open now — ordering until {$close->format('g:i A')}."
                : 'We are open now.';
        }

        return $this->closedMessage();
    }

    private function closeTimeToday(): ?Carbon
    {
        $now = $this->now();
        $hours = $this->hours();
        $dow = (int) $now->isoWeekday();

        return empty($hours[$dow])
            ? null
            : $now->copy()->setTimeFromTimeString($hours[$dow][1]);
    }

    /**
     * Weekly opening hours grouped for display, e.g.
     * [['Mon & Tue','12:00 PM – 10:00 PM'], ['Sunday','4:00 PM – 10:00 PM'], …].
     *
     * @return array<int, array{0:string,1:string}>
     */
    public function weekly(): array
    {
        $hours = $this->hours();
        $short = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
        $full  = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];

        $label = static fn (string $t): string => Carbon::createFromFormat('H:i', $t)->format('g:i A');
        $windowFor = static fn (?array $w): string => $w ? $label($w[0]) . ' – ' . $label($w[1]) : 'Closed';

        $rows = [];
        $d = 1;
        while ($d <= 7) {
            $window = $hours[$d] ?? null;
            $e = $d;
            while ($e < 7 && ($hours[$e + 1] ?? null) == $window) {
                $e++;
            }
            $name = $e > $d ? "{$short[$d]} & {$short[$e]}" : $full[$d];
            $rows[] = [$name, $windowFor($window)];
            $d = $e + 1;
        }

        return $rows;
    }
}
