<?php

namespace Helldar\BlacklistCore\Helpers;

use function is_array;

class Arr
{
    public static function add($array, string $key, $value): array
    {
        return $array[$key] = $value;
    }

    /**
     * @param array $array
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public static function get(array $array, string $key, $default = null)
    {
        return $array[$key] ?? $default;
    }

    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function wrap($value)
    {
        if (null === $value) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }
}
