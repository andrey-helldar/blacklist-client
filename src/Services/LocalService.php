<?php

namespace Helldar\BlacklistClient\Services;

use function compact;
use Helldar\BlacklistCore\Contracts\ClientServiceContract;
use Helldar\BlacklistCore\Facades\Validator;
use Helldar\BlacklistServer\Facades\Blacklist;

use Helldar\BlacklistServer\Models\Blacklist as BlacklistModel;

class LocalService extends BaseService implements ClientServiceContract
{
    public function store(string $value, string $type): ?BlacklistModel
    {
        if ($this->isEnabled()) {
            return Blacklist::store(compact('value', 'type'));
        }

        return null;
    }

    /**
     * @param string $value
     *
     * @throws \Helldar\BlacklistCore\Exceptions\BlacklistDetectedException
     */
    public function check(string $value): void
    {
        if ($this->isEnabled()) {
            Blacklist::check($value);
        }
    }

    public function exists(string $value): bool
    {
        if ($this->isEnabled()) {
            Validator::validate(compact('value'));

            return Blacklist::exists($value);
        }

        return false;
    }
}
