<?php

namespace Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $first = [
        'email' => 'foo@example.com',
    ];

    protected $second = [
        'email' => 'bar@example.com',
    ];

    protected $incorrect = [
        'email' => 'foo',
    ];

    protected function get(string $key, string $type, $default = null): string
    {
        return $this->{$key}[$type] ?? $default;
    }
}