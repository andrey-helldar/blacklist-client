<?php

namespace Helldar\BlacklistClient\Services;

use GuzzleHttp\Client;
use Helldar\BlacklistClient\Contracts\Service;
use Helldar\BlacklistCore\Constants\Server;

class RemoteService implements Service
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $source
     * @param string|null $type
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return string
     */
    public function store(string $source = null, string $type = null)
    {
        $response = $this->send('POST', \compact('type', 'source'));

        return $response->getBody()->getContents();
    }

    /**
     * @param string|null $source
     * @param string|null $type
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return bool
     */
    public function check(string $source = null, string $type = null): bool
    {
        $response = $this->send('GET', \compact('type', 'source'));

        return $response->getBody()->getContents();
    }

    /**
     * @param string $method
     * @param array $form_params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function send(string $method, array $form_params)
    {
        $base_uri = \config('blacklist_client.server_url', Server::BASE_URL);
        $verify   = \config('blacklist_client.verify_ssl', true);
        $timeout  = \config('blacklist_client.server_timeout', 0);
        $headers  = Server::HEADERS;

        return $this->client
            ->request($method, \compact('base_uri', 'verify', 'timeout', 'headers', 'form_params'));
    }
}
