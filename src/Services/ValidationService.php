<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistClient\Facades\Config;
use Helldar\BlacklistCore\Exceptions\ExcludedBlockingDetectedException;
use Helldar\BlacklistCore\Exceptions\UnknownValueException;

use function in_array;

class ValidationService
{
    /**
     * @param array $data
     *
     * @throws ExcludedBlockingDetectedException
     * @throws UnknownValueException
     */
    public function validate(array $data)
    {
        $except = Config::get('except', []);
        $value  = $this->valueOrFail($data, 'value');

        if (in_array($value, $except)) {
            throw new ExcludedBlockingDetectedException();
        }
    }

    /**
     * @param array $data
     * @param string $key
     *
     * @throws UnknownValueException
     *
     * @return mixed
     */
    private function valueOrFail(array $data, string $key)
    {
        if (isset($data[$key]) && $data[$key]) {
            return $data[$key];
        }

        throw new UnknownValueException();
    }
}
