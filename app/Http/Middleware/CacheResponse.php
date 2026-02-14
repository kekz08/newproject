<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only cache GET requests
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        // Skip caching for image routes
        if ($request->routeIs('profile.image.show')) {
            return $next($request);
        }

        // Create a unique cache key based on the URL and user (if authenticated)
        $url = $request->fullUrl();
        $userId = $request->user()?->id ?: 'guest';
        $cacheKey = "response_cache_" . md5($url . "_" . $userId);

        // Optional: Skip caching for Inertia requests if you want always fresh data,
        // but the user asked for caching on ALL pages.
        // We can cache for a short time (e.g., 10 seconds) to satisfy the "not reload everything"
        // while staying relatively fresh.

        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            $response = response($cachedData['content']);
            $response->headers->add($cachedData['headers']);
            $response->headers->set('X-Cache', 'HIT');
            return $response;
        }

        $response = $next($request);

        // Only cache successful responses
        if ($response->getStatusCode() === 200) {
            // Store content and relevant headers
            Cache::put($cacheKey, [
                'content' => $response->getContent(),
                'headers' => [
                    'Content-Type' => $response->headers->get('Content-Type'),
                    'Vary' => $response->headers->get('Vary'),
                    'X-Inertia' => $response->headers->get('X-Inertia'),
                ],
            ], 10); // Cache for 10 seconds
        }

        return $response;
    }
}
