<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistCore\Contracts\ServiceContract;
use Helldar\BlacklistServer\Facades\Blacklist;

class LocalService extends BaseService implements ServiceContract
{
    public function store(string $type, string $value)
    {
        if ($this->isDisabled()) {
            return true;
        }

        return Blacklist::store($type, $value);
    }

    public function check(string $value): bool
    {
        if ($this->isDisabled()) {
            return true;
        }

        return Blacklist::check($value);
    }

    public function exists(string $value): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        return Blacklist::exists($value);
    }
}
