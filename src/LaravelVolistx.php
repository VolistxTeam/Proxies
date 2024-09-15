<?php

namespace Volistx\Proxies;

use Closure;
use Volistx\Proxies\Facades\VolistxProxies;

final class LaravelVolistx
{
    /**
     * The callback that should be used to get the proxies addresses.
     *
     * @var Closure|null
     */
    protected static ?Closure $getProxiesCallback;

    /**
     * Get the proxies addresses.
     *
     * @return array
     */
    public static function getProxies(): array
    {
        if (LaravelVolistx::$getProxiesCallback !== null) {
            return call_user_func(LaravelVolistx::$getProxiesCallback);
        }

        return VolistxProxies::load();
    }

    /**
     * Set a callback that should be used when getting the proxies addresses.
     *
     * @param Closure $callback
     *
     * @return void
     */
    public static function getProxiesUsing(Closure $callback): void
    {
        LaravelVolistx::$getProxiesCallback = $callback;
    }
}
