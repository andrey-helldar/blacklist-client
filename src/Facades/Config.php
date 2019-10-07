<?php

namespace Helldar\BlacklistClient\Facades;

use Illuminate\Support\Facades\Config as IlluminateConfig;

class Config
{
    public static function get(string $key, $default = null)
    {
        if (class_exists(IlluminateConfig::class)) {
            return IlluminateConfig::get("blacklist_client.{$key}", $default);
        }

        return static::load($key, $default);
    }

    private static function load(string $key, $default = null)
    {
        $config = require __DIR__ . '/../config/settings.php';

        return $config[$key] ?? $default;
    }
}
