<?php

namespace Tests\FacadeTests;

use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Tests\TestCase;
use TypeError;

class ExistsTest extends TestCase
{
    public function testSuccessExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(423);

        $email = $this->get('first', 'email');

        Client::store($email, 'email');

        Client::exists($email);
    }

    public function testSuccessNotExists()
    {
        Client::store($this->get('first', 'email'), 'email');

        $result = Client::exists($this->get('second', 'email'));

        $this->assertFalse($result);
    }

    public function testEmptySource()
    {
        $this->expectException(TypeError::class);

        Client::exists([]);
    }
}
