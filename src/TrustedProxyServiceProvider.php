<?php

namespace Volistx\Proxies;

use Illuminate\Support\ServiceProvider;

class TrustedProxyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/vproxies.php' => config_path('vproxies.php'),
            ], 'vproxies-config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/vproxies.php',
            'vproxies'
        );
        $this->app->singleton(\Cryental\StackPath\Facades\StackPathProxies::class, \Cryental\StackPath\StackPathProxies::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Reload::class,
                Commands\View::class,
            ]);
        }
    }
}
