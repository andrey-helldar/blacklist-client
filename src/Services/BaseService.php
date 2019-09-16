<?php

namespace Helldar\BlacklistClient\Services;

use function config;

abstract class BaseService
{
    protected function isDisabled(): bool
    {
        return config('blacklist_client.enabled', true);
    }
}
