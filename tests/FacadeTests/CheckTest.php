<?php

namespace Tests\FacadeTests;

use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistClient\Facades\Config;
use Helldar\BlacklistCore\Exceptions\UnknownValueException;
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

    public function testSelfBlocking()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(422);

        Client::check('http://localhost', 'url');
    }

    public function testSuccessNotExists()
    {
        Client::store($this->get('first', 'email'), 'email');

        Client::check($this->get('second', 'email'));

        $this->assertEquals(true, true);
    }

    public function testArgumentCountError()
    {
        $this->expectException(UnknownValueException::class);
        $this->expectExceptionMessage('The value field is required.');

        Client::check();
    }

    public function testEmptySource()
    {
        $this->expectException(UnknownValueException::class);
        $this->expectExceptionMessage('The value field is required.');

        Client::check('');
    }
}
