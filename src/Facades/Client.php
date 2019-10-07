<?php

namespace Helldar\BlacklistClient\Facades;

use Helldar\BlacklistClient\Services\ClientService;
use Helldar\BlacklistCore\Facades\Facade;

/**
 * @method array|string store(string $value = null, string $type = null)
 * @method void check(string $value = null, string $type = null)
 * @method bool exists(string $value = null, string $type = null)
 */
class Client extends Facade
{
    public static function getFacadeAccessor()
    {
        return ClientService::class;
    }
}
