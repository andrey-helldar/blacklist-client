<?php

namespace Tests\RemoteTests;

use ArgumentCountError;
use GuzzleHttp\Exception\ClientException;
use Helldar\BlacklistClient\Facades\Client;
use Helldar\BlacklistCore\Constants\Server;
use Tests\TestCase;

class CheckTest extends TestCase
{
    protected $exists = 'foo@example.com';

    protected $incorrect = 'foo';

    protected $not_exists = 'bar@example.com';

    protected $url = Server::URI;

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

        Client::store($this->exists, 'email');

        Client::check($this->exists);
    }

    public function testSuccessNotExists()
    {
        Client::store($this->exists, 'email');

        $result = Client::check($this->not_exists);

        $this->assertEquals(false, $result);
    }

    public function testArgumentCountError()
    {
        $this->expectException(ArgumentCountError::class);

        Client::check();
    }

    public function testEmptySource()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('{"error":{"code":400,"msg":["The value field is required."]}}');

        Client::check('');
    }
}
