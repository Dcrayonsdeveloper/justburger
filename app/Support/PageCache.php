<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class PageCache
{
    /**
     * Current version stamp mixed into the full-page cache keys.
     * Every cached page carries this version; bumping it makes all
     * previously-cached pages a cache miss (i.e. re-render fresh).
     */
    public static function version(): int
    {
        return (int) Cache::get('page_cache_version', 1);
    }

    /**
     * Invalidate every cached page at once. Called whenever catalogue or
     * business data changes (product/category/setting) so admin edits show
     * on the storefront immediately instead of after the cache TTL.
     */
    public static function bump(): void
    {
        Cache::forever('page_cache_version', static::version() + 1);
    }
}
