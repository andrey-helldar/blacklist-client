<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistCore\Contracts\ServiceContract;
use Helldar\BlacklistCore\Facades\Validator;
use Helldar\BlacklistServer\Facades\Blacklist;
use Helldar\BlacklistServer\Models\Blacklist as BlacklistModel;
use Illuminate\Http\Request;

use function compact;

class LocalService extends BaseService implements ServiceContract
{
    public function store(Request $request): ?BlacklistModel
    {
        if ($this->isEnabled()) {
            return Blacklist::store($request->all());
        }

        return null;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Helldar\BlacklistCore\Exceptions\BlacklistDetectedException
     */
    public function check(Request $request): void
    {
        if ($this->isEnabled()) {
            Blacklist::check($request->all());
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
