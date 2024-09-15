<?php

namespace Volistx\Proxies\Commands;

use Cache;
use Illuminate\Console\Command;

class View extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxies:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View list of trust proxies IPs stored in cache.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cacheKey = config('proxies.cache');

        $proxies = array_map(
           function ($proxy) {
              return [$proxy];
           },
           Cache::get($cacheKey, [])
        );

        $this->table(
            ['Address'],
            $proxies
        );
    }
}
