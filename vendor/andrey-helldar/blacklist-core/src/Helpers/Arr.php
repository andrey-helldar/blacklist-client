<?php

namespace Helldar\BlacklistCore\Helpers;

class Arr
{
    public static function add($array, string $key, $value): array
    {
        return $array[$key] = $value;
    }

    /**
     * @param array $array
     * @param string $key
     * @param null|mixed $default
     *
     * @return mixed|null
     */
    public static function get(array $array, string $key, $default = null)
    {
        return $array[$key] ?? $default;
    }
}