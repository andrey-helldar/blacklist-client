<?php

namespace Helldar\BlacklistClient\Contracts;

interface Service
{
    public function store(string $value = null, string $type = null);

    public function exists(string $value = null, string $type = null): bool;
}
