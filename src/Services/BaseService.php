<?php

namespace Helldar\BlacklistClient\Services;

use function config;

abstract class BaseService
{
    protected function isEnabled(): bool
    {
        return config('blacklist_client.enabled', true);
    }

    protected function isDisabled(): bool
    {
        return !$this->isEnabled();
    }
}
