<?php

namespace Helldar\BlacklistClient\Services;

use function compact;
use function config;
use Exception;
use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Contracts\ServiceContract;
use Helldar\BlacklistCore\Exceptions\BlacklistDetectedException;
use Helldar\BlacklistCore\Facades\HttpClient;

use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class RemoteService extends BaseService implements ServiceContract
{
    /**
     * @param array $data
     *
     * @throws \Exception
     *
     * @return mixed|null
     */
    public function store(array $data)
    {
        if ($this->isDisabled()) {
            return null;
        }

        $response = $this->send('POST', $data);

        if ($response->getStatusCode() == 200) {
            return $this->decode($response);
        }

        throw new Exception(
            $this->getError($response),
            $response->getStatusCode() ?: 400
        );
    }

    /**
     * @param string $value
     *
     * @throws \Helldar\BlacklistCore\Exceptions\BlacklistDetectedException
     */
    public function check(string $value)
    {
        if ($this->isDisabled()) {
            return;
        }

        $response = $this->send('GET', compact('value'));

        if ($response->getStatusCode() !== 200) {
            throw new BlacklistDetectedException(
                $this->getError($response)
            );
        }
    }

    public function exists(string $value): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        $response = $this->send('GET', compact('value'), '/exists');

        return $response->getStatusCode() !== 200;
    }

    private function send(string $method, array $data, string $url_suffix = null): ResponseInterface
    {
        $base_uri = config('blacklist_client.server_url') ?: Server::BASE_URL;
        $timeout  = config('blacklist_client.server_timeout') ?: 0;
        $verify   = config('blacklist_client.verify_ssl') ?: true;
        $headers  = config('blacklist_client.headers') ?: [];

        return HttpClient::setBaseUri($base_uri)
            ->setUriSuffix($url_suffix)
            ->setTimeout($timeout)
            ->setVerify($verify)
            ->setHeaders($headers)
            ->send($method, $data);
    }

    private function decode(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }

    private function getError(ResponseInterface $response): string
    {
        $errors = Arr::dot($this->decode($response), 'error.msg');

        return Arr::first($errors);
    }
}
