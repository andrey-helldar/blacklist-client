<?php

namespace Helldar\BlacklistClient\Facades;

use Helldar\BlacklistClient\Services\ValidationService;
use Helldar\BlacklistCore\Exceptions\ExcludedBlockingDetectedException;
use Helldar\BlacklistCore\Exceptions\UnknownValueException;
use Helldar\BlacklistCore\Facades\Facade;

/**
 * @method void validate(array $data)
 *
 * @throws ExcludedBlockingDetectedException
 * @throws UnknownValueException
 */
class Validation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidationService::class;
    }
}