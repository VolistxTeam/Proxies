<?php

namespace Volistx\Proxies\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Config\Repository;
use Volistx\Proxies\LaravelVolistx;

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
     * @param Factory    $cache
     * @param Repository $config
     *
     * @return void
     */
    public function handle(CacheFactory $cache, Repository $config)
    {
        $proxies = LaravelVolistx::getProxies();

        $cache->store()->forever($config->get('vproxies.cache'), $proxies);

        $this->info('Volistx\'s IP blocks have been reloaded.');
    }
}