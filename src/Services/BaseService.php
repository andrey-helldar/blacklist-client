<?php

namespace Helldar\BlacklistClient\Services;

abstract class BaseService
{
    protected function isDisabled(): bool
    {
        return \config('blacklist_client.enabled', true);
    }
}
