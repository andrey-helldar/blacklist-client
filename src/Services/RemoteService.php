<?php

namespace Helldar\BlacklistClient\Services;

use Helldar\BlacklistClient\Contracts\Service;
use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Facades\HttpClient;

class RemoteService implements Service
{
    public function store(string $source = null, string $type = null)
    {
        $response = $this->send('POST', \compact('type', 'source'));

        return $response->getBody()->getContents();
    }

    public function check(string $source = null, string $type = null): bool
    {
        $response = $this->send('GET', \compact('type', 'source'));

        return $response->getBody()->getContents();
    }

    private function send(string $method, array $data)
    {
        $base_uri = \config('blacklist_client.server_url', Server::BASE_URL);
        $timeout  = \config('blacklist_client.server_timeout', 0);
        $verify   = \config('blacklist_client.verify_ssl', true);
        $headers  = \config('blacklist_client.headers', true);

        return HttpClient::setBaseUri($base_uri)
            ->setTimeout($timeout)
            ->setVerify($verify)
            ->setHeaders($headers)
            ->send($method, $data);
    }
}
