<?php

namespace Helldar\BlacklistClient\Facades;

use Helldar\BlacklistClient\Services\ClientService;
use Helldar\BlacklistCore\Facades\Facade;

/**
 * @method array|string store(string $value, string $type)
 * @method void check(string $value, string $type = null)
 * @method bool exists(string $value, string $type = null)
 */
class Client extends Facade
{
    static function getFacadeAccessor()
    {
        return ClientService::class;
    }
}
