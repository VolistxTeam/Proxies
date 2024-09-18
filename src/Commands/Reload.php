<?php

namespace Volistx\Proxies\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Volistx\Proxies\TrustProxiesLoader;

class Reload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxies:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload trust proxies IPs and store in cache.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cacheKey = config('proxies.cache');
        Cache::put(
            $cacheKey,
            (new TrustProxiesLoader())->getVolistxProxies(),
            3600
        );
    }
}
