<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Contracts\ServiceContract;
use Helldar\BlacklistCore\Facades\HttpClient;
use Psr\Http\Message\ResponseInterface;

use function compact;
use function config;

class RemoteService extends BaseService implements ServiceContract
{
    public function store(string $type, string $value)
    {
        if ($this->isDisabled()) {
            return true;
        }

        $response = $this->send('POST', compact('type', 'value'));

        return $response->getBody()->getContents();
    }

    public function check(string $value = null, string $type = null): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        $response = $this->send('GET', compact('type', 'value'));

        return $response->getStatusCode() !== 200;
    }

    private function send(string $method, array $data): ResponseInterface
    {
        $base_uri = config('blacklist_client.server_url') ?: Server::BASE_URL;
        $timeout  = config('blacklist_client.server_timeout') ?: 0;
        $verify   = config('blacklist_client.verify_ssl') ?: true;
        $headers  = config('blacklist_client.headers') ?: [];

        return HttpClient::setBaseUri($base_uri)
            ->setTimeout($timeout)
            ->setVerify($verify)
            ->setHeaders($headers)
            ->send($method, $data);
    }
}
