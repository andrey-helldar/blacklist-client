<?php

namespace Tests\FacadeTests;

use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistCore\Exceptions\UnknownValueException;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function testSuccess()
    {
        $email = $this->get('first', 'email');

        $item = Client::store($email, 'email');

        $this->assertEquals($email, $item->value);
    }

    public function testArgumentCountError()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store($this->get('first', 'email'), 'foo');
    }

    public function testFailValidationException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store($this->get('first', 'email'));
    }

    public function testFailEmptySource()
    {
        $this->expectException(UnknownValueException::class);
        $this->expectExceptionMessage('The value field is required.');
        $this->expectExceptionCode(400);

        Client::store('', '');
    }

    public function testSelfBlockingIp()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store('127.0.0.1', 'ip');
    }

    public function testSelfBlockingUrl()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store('http://localhost', 'url');
    }
}
