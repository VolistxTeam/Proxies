<?php

namespace Volistx\Proxies\Http\Middleware;

use Volistx\Proxies\LaravelVolistx;
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class TrustProxies extends Middleware
{
    /**
     * Sets the trusted proxies on the request to the value of StackPath ips.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function setTrustedProxyIpAddresses(Request $request)
    {
        $cacheKey = Config::get('vproxies.cache');
        $cachedProxies = Cache::get($cacheKey, function () use ($cacheKey) {
            return tap(LaravelVolistx::getProxies(), function ($proxies) use ($cacheKey) {
                Cache::forever($cacheKey, $proxies);
            });
        });

        if (is_array($cachedProxies) && count($cachedProxies) > 0) {
            $this->proxies = array_merge((array) $this->proxies, $cachedProxies);
        }

        parent::setTrustedProxyIpAddresses($request);
    }
}
