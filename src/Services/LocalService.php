<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistClient\Contracts\Service;
use Helldar\BlacklistCore\Exceptions\UnknownTypeException;
use Helldar\BlacklistServer\Facades\Email;
use Helldar\BlacklistServer\Facades\Host;
use Helldar\BlacklistServer\Facades\Ip;
use Helldar\BlacklistServer\Facades\Phone;
use Illuminate\Support\Arr;

class LocalService implements Service
{
    private $facades = [
        'email' => Email::class,
        'host'  => Host::class,
        'ip'    => Ip::class,
        'phone' => Phone::class,
    ];

    /**
     * @param string|null $source
     * @param string|null $type
     *
     * @throws \Helldar\BlacklistCore\Exceptions\UnknownTypeException
     * @return mixed
     */
    public function store(string $source = null, string $type = null)
    {
        if ($facade = Arr::get($this->facades, $type)) {
            return $facade->store($source);
        }

        throw new UnknownTypeException($type);
    }

    /**
     * @param string|null $source
     * @param string|null $type
     *
     * @throws \Helldar\BlacklistCore\Exceptions\UnknownTypeException
     * @return bool
     */
    public function check(string $source = null, string $type = null): bool
    {
        if ($facade = Arr::get($this->facades, $type)) {
            return $facade->check($source);
        }

        throw new UnknownTypeException($type);
    }
}
