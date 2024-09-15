<?php

namespace Volistx\Proxies\Facades;

use Illuminate\Support\Facades\Facade;

class VolistxProxies extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Volistx\Proxies\VolistxProxies::class;
    }
}
