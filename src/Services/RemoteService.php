<?php

namespace Helldar\BlacklistClient\Services;

use Exception;
use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Contracts\ClientServiceContract;
use Helldar\BlacklistCore\Exceptions\BlacklistDetectedException;
use Helldar\BlacklistCore\Facades\HttpClient;
use Helldar\BlacklistCore\Traits\Validator;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

use function compact;
use function config;

class RemoteService extends BaseService implements ClientServiceContract
{
    use Validator;

    /**
     * @param string $value
     * @param string $type
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     *
     * @return mixed|null
     */
    public function store(string $value, string $type)
    {
        if ($this->isDisabled()) {
            return null;
        }

        $this->validate(compact('value', 'type'));

        $response = $this->send('POST', compact('value', 'type'));

        $code = Arr::get($response, 'code');
        $msg  = Arr::get($response, 'msg');

        if ($code === 200) {
            return $msg;
        }

        throw new Exception($msg, $code ?: 400);
    }

    /**
     * @param string $value
     *
     * @throws BlacklistDetectedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check(string $value)
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->validate(compact('value'), false);

        $response = $this->send('GET', compact('value'));

        $code = Arr::get($response, 'code');
        $msg  = Arr::get($response, 'msg');

        if ($code !== 200) {
            throw new BlacklistDetectedException($msg);
        }
    }

    /**
     * @param string $value
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return bool
     */
    public function exists(string $value): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        $this->validate(compact('value'), false);

        $response = $this->send('GET', compact('value'), '/exists');

        $code = Arr::get($response, 'code');

        return $code !== 200;
    }

    /**
     * @param string $method
     * @param array $data
     * @param string|null $url_suffix
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return array
     */
    private function send(string $method, array $data, string $url_suffix = null): array
    {
        $base_uri = config('blacklist_client.server_url') ?: Server::BASE_URL;
        $timeout  = config('blacklist_client.server_timeout') ?: 0;
        $verify   = config('blacklist_client.verify_ssl') ?: true;
        $headers  = config('blacklist_client.headers') ?: [];

        /** @var ResponseInterface $response */
        $response = HttpClient::setBaseUri($base_uri)
            ->setUriSuffix($url_suffix)
            ->setTimeout($timeout)
            ->setVerify($verify)
            ->setHeaders($headers)
            ->send($method, $data);

        return [
            'code' => $response->getStatusCode(),
            'msg'  => json_decode($response->getBody()->getContents()),
        ];
    }
}
