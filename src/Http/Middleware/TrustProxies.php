<?php

namespace Volistx\Proxies\Http\Middleware;

use Monicahq\Cloudflare\Http\Middleware\TrustProxies as BaseTrustProxies;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TrustProxies extends BaseTrustProxies
{
    /**
     * Get the trusted proxies.
     *
     * @return array
     */
    protected function proxies(): array
    {
        // Get the proxies from the parent (Cloudflare proxies)
        $cloudflareProxies = parent::proxies();

        // Get additional proxies from your custom URL
        $customProxies = $this->getVolistxProxies();

        // Merge and return the combined list of proxies
        return array_merge($cloudflareProxies, $customProxies);
    }

    /**
     * Fetch custom proxies from a URL and cache them.
     *
     * @return array
     */
    protected function getVolistxProxies(): array
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
