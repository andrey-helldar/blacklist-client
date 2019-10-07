<?php

namespace Tests\FacadeTests;

use ArgumentCountError;
use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistClient\Facades\Config;
use Tests\TestCase;

class CheckTest extends TestCase
{
    public function testSuccessExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(423);

        $email = $this->get('first', 'email');

        Config::get('foo');

        Client::store($email, 'email');
        Client::check($email);
    }

    public function testSuccessNotExists()
    {
        Client::store($this->get('first', 'email'), 'email');

        Client::check($this->get('second', 'email'));

        $this->assertEquals(true, true);
    }

    public function testArgumentCountError()
    {
        $this->expectException(ArgumentCountError::class);

        Client::check();
    }

    public function testEmptySource()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('{"error":{"code":400,"msg":["The value field is required."]},"request":{"value":null}}');

        Client::check('');
    }
}
