<?php

namespace Volistx\Proxies;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TrustProxiesLoader
{
    /**
     * Fetch custom proxies from a URL and cache them.
     *
     * @return array
     */
    public function getVolistxProxies(): array
    {
        $cacheKey = config('proxies.cache');

        return Cache::remember($cacheKey, 3600, function () {
            $url = config('proxies.url');
            $response = Http::get($url);

            if ($response->successful()) {
                // Assuming each proxy is on a new line
                return array_filter(explode("\n", $response->body()));
            }

            // Handle failure (return an empty array or predefined proxies)
            return [];
        });
    }
}