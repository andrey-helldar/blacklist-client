<?php

namespace Helldar\BlacklistClient;

use function config;
use function config_path;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/settings.php' => config_path('blacklist_client.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/settings.php', 'blacklist_client');
    }
}
