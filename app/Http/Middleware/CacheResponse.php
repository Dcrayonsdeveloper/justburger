<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    public function handle(Request $request, Closure $next, int $minutes = 5): Response
    {
        // Only cache GET requests for unauthenticated users
        if ($request->method() !== 'GET' || auth()->check()) {
            return $next($request);
        }

        // Never serve or store a cached copy when there's flashed feedback in the
        // session (a form success message or validation errors). Otherwise the
        // message would be stripped from the redirected page — or worse, a cached
        // copy carrying one visitor's message could be shown to everyone else.
        if ($request->session()->has('errors')
            || $request->session()->has('success')
            || $request->session()->has('error')) {
            return $next($request);
        }

        $key = 'response_cache.v' . \App\Support\PageCache::version() . '.' . md5($request->fullUrl());

        if (Cache::has($key)) {
            $cached = Cache::get($key);
            return response($cached['content'], $cached['status'])
                ->withHeaders($cached['headers'])
                ->header('X-Cache', 'HIT');
        }

        $response = $next($request);

        if ($response->getStatusCode() === 200) {
            Cache::put($key, [
                'content' => $response->getContent(),
                'status' => $response->getStatusCode(),
                'headers' => array_map(fn ($h) => $h[0] ?? $h, $response->headers->all()),
            ], now()->addMinutes($minutes));

            $response->header('X-Cache', 'MISS');
        }

        return $response;
    }
}
