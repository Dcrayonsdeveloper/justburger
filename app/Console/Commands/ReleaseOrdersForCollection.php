<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ReleaseOrdersForCollection extends Command
{
    protected $signature = 'orders:release-ready';

    protected $description = 'Mark orders as ready once they have been preparing for the collection prep window';

    /**
     * The order pages already call Order::releaseOrdersDueForCollection() on
     * load, because this host has no cron. This command exists so the same work
     * happens on a schedule wherever one is available — the two are idempotent,
     * so running both changes nothing.
     */
    public function handle(): int
    {
        $released = Order::releaseOrdersDueForCollection();

        $this->info($released === 0
            ? 'No orders were due for collection.'
            : "Marked {$released} order(s) ready for collection.");

        return self::SUCCESS;
    }
}
