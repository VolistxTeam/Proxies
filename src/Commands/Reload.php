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
     * Create a new command instance.
     *
     * @param CacheFactory $cache
     * @param Repository $config
     */
    public function __construct(private CacheFactory $cache, private Repository $config)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $proxies = LaravelVolistx::getProxies();

        $this->cache->store()->forever($this->config->get('vproxies.cache'), $proxies);

        $this->info('Volistx\'s IP blocks have been reloaded.');
    }
}