<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistClient\Contracts\Service;
use Helldar\BlacklistCore\Exceptions\UnknownTypeException;
use Helldar\BlacklistServer\Facades\Email;
use Helldar\BlacklistServer\Facades\Host;
use Helldar\BlacklistServer\Facades\Ip;
use Helldar\BlacklistServer\Facades\Phone;
use Illuminate\Support\Arr;

class LocalService extends BaseService implements Service
{
    private $facades = [
        'email' => Email::class,
        'host'  => Host::class,
        'ip'    => Ip::class,
        'phone' => Phone::class,
    ];

    /**
     * @param string|null $value
     * @param string|null $type
     *
     * @throws \Helldar\BlacklistCore\Exceptions\UnknownTypeException
     *
     * @return mixed
     */
    public function store(string $value = null, string $type = null)
    {
        if ($this->isDisabled()) {
            return true;
        }

        if ($facade = Arr::get($this->facades, $type)) {
            return $facade->store($value);
        }

        throw new UnknownTypeException($type);
    }

    /**
     * @param string|null $value
     * @param string|null $type
     *
     * @return bool
     */
    public function exists(string $value = null, string $type = null): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        if ($facade = Arr::get($this->facades, $type)) {
            return $facade::exists($value);
        }

        return false;
    }
}
