<?php

namespace Helldar\BlacklistClient\Facades;

use Helldar\BlacklistClient\Services\LocalService;
use Helldar\BlacklistClient\Services\RemoteService;
use Illuminate\Support\Facades\Facade;

use function config;

/**
 * @method string|array store(string $value, string $type)
 * @method void check(string $value)
 * @method bool exists(string $value)
 */
class Client extends Facade
{
    protected static function getFacadeAccessor()
    {
        return config('blacklist_client.server_url') === 'local'
            ? LocalService::class
            : RemoteService::class;
    }
}
