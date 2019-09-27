<?php

namespace Tests\RemoteTests;

use ArgumentCountError;
use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistCore\Constants\Server;
use Tests\TestCase;
use TypeError;

class ExistsTest extends TestCase
{
    protected $exists = 'foo@example.com';

    protected $incorrect = 'foo';

    protected $not_exists = 'bar@example.com';

    protected $url = Server::URI . '/exists';

    public function testSuccessExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(423);
        $this->expectExceptionMessage(json_encode([
            'error' => [
                'code' => 423,
                'msg'  => ["Checked {$this->exists} was found in our database."],
            ],
        ]));

        Client::store([
            'type'  => 'email',
            'value' => $this->exists,
        ]);

        Client::exists($this->exists);
    }

    public function testSuccessNotExists()
    {
        Client::store([
            'type'  => 'email',
            'value' => $this->exists,
        ]);

        $result = Client::exists($this->not_exists);

        $this->assertEquals(false, $result);
    }

    public function testArgumentCountError()
    {
        $this->expectException(ArgumentCountError::class);

        Client::exists();
    }

    public function testEmptySource()
    {
        $this->expectException(TypeError::class);

        Client::exists([]);
    }
}
