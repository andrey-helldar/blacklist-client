<?php

namespace Tests\RemoteTests;

use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistCore\Constants\Server;
use Tests\TestCase;

class StoreTest extends TestCase
{
    protected $exists = 'foo@example.com';

    protected $incorrect = 'foo';

    protected $not_exists = 'bar@example.com';

    protected $url = Server::URI;

    public function testSuccess()
    {
        $item = Client::store([
            'type'  => 'email',
            'value' => $this->exists,
        ]);

        $this->assertEquals($this->exists, $item->value);
    }

    public function testFailValidationException()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('{"error":{"code":400,"msg":["The type must be one of email, host, phone or ip, null given."]}}');

        Client::store([
            'value' => $this->exists,
        ]);
    }

    public function testFailEmptySource()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('{"error":{"code":400,"msg":["The type must be one of email, host, phone or ip, null given."]}}');

        Client::store([]);
    }
}
