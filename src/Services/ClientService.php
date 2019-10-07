<?php

namespace Helldar\BlacklistClient\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Helldar\BlacklistClient\Facades\Config;
use Helldar\BlacklistClient\Facades\Validation;
use Helldar\BlacklistCore\Constants\Server;
use Helldar\BlacklistCore\Contracts\ServiceContract;
use Helldar\BlacklistCore\Exceptions\BlacklistDetectedException;
use Helldar\BlacklistCore\Facades\HttpClient;
use Helldar\BlacklistCore\Helpers\Arr;
use Psr\Http\Message\ResponseInterface;

use function compact;

class ClientService implements ServiceContract
{
    /**
     * @param string|null $value
     * @param string|null $type
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Helldar\BlacklistCore\Exceptions\IncorrectValueException
     * @throws \Exception
     *
     * @return mixed|null
     */
    public function store(string $value = null, string $type = null)
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
     * @param string|null $value
     * @param string|null $type
     *
     * @throws BlacklistDetectedException
     * @throws GuzzleException
     * @throws \Helldar\BlacklistCore\Exceptions\IncorrectValueException
     */
    public function check(string $value = null, string $type = null)
    {
        if ($this->isDisabled()) {
            return;
        }

        $this->validate(compact('value', 'type'));

        $response = $this->send('GET', compact('value', 'type'));

        $code = Arr::get($response, 'code');
        $msg  = Arr::get($response, 'msg');

        if ($code !== 200) {
            throw new BlacklistDetectedException($msg);
        }
    }

    /**
     * @param string|null $value
     * @param string|null $type
     *
     * @throws GuzzleException
     * @throws \Helldar\BlacklistCore\Exceptions\IncorrectValueException
     *
     * @return bool
     */
    public function exists(string $value = null, string $type = null): bool
    {
        if ($this->isDisabled()) {
            return false;
        }

        $this->validate(compact('value', 'type'));

        $response = $this->send('GET', compact('value', 'type'), '/exists');

        $code = Arr::get($response, 'code');

        return $code !== 200;
    }

    /**
     * @param string $method
     * @param array $data
     * @param string|null $url_suffix
     *
     * @throws GuzzleException
     * @throws \Helldar\BlacklistCore\Exceptions\IncorrectValueException
     *
     * @return array
     */
    private function send(string $method, array $data, string $url_suffix = null): array
    {
        $base_uri = Config::get('server_url') ?: Server::BASE_URL;
        $timeout  = Config::get('server_timeout') ?: 0;
        $verify   = Config::get('verify_ssl') ?: false;
        $headers  = Config::get('headers') ?: [];

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

    private function isDisabled(): bool
    {
        return ! Config::get('enabled', true);
    }

    private function validate(array $data)
    {
        Validation::validate($data);
    }
}
