<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistCore\Facades\CheckBlocking;

use function config;

abstract class BaseService
{
    protected function isEnabled(): bool
    {
        return config('blacklist_client.enabled', true);
    }

    protected function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    protected function checkBlocking(string $value)
    {
        CheckBlocking::selfBlocking($value);
        CheckBlocking::exceptBlocking($value);
    }
}
