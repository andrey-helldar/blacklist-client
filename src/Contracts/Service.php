<?php

namespace Helldar\BlacklistClient\Contracts;

interface Service
{
    public function store(string $source = null, string $type = null);

    public function check(string $source = null, string $type = null): bool;
}
