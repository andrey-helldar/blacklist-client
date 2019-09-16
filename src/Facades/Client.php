<?php

namespace Helldar\BlacklistClient\Facades;

use function config;
use Helldar\BlacklistClient\Services\LocalService;
use Helldar\BlacklistClient\Services\RemoteService;

use Illuminate\Support\Facades\Facade;

class Client extends Facade
{
    protected static function getFacadeAccessor()
    {
        return config('blacklist_client.server_url') === 'local'
            ? LocalService::class
            : RemoteService::class;
    }
}
