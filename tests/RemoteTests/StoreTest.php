<?php

namespace Tests\RemoteTests;

use ArgumentCountError;
use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Exceptions\SelfBlockingDetected;
use Tests\TestCase;

class StoreTest extends TestCase
{
    protected $exists = 'foo@example.com';

    protected $incorrect = 'foo';

    protected $not_exists = 'bar@example.com';

    protected $url = Server::URI;

    public function testSuccess()
    {
        $item = Client::store($this->exists, 'email');

        $this->assertEquals($this->exists, $item->value);
    }

    public function testArgumentCountError()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store($this->exists, 'foo');
    }

    public function testFailValidationException()
    {
        $this->expectException(ArgumentCountError::class);

        Client::store($this->exists);
    }

    public function testFailEmptySource()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);

        Client::store('', '');
    }

    public function testSelfBlockingIp()
    {
        $this->expectException(SelfBlockingDetected::class);
        $this->expectExceptionMessage('You are trying to block yourself! (127.0.0.1)');

        Client::store('127.0.0.1', 'ip');
    }

    public function testSelfBlockingHost()
    {
        $this->expectException(SelfBlockingDetected::class);
        $this->expectExceptionMessage('You are trying to block yourself! (localhost)');

        Client::store('localhost', 'ip');
    }
}
