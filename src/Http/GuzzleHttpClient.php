<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Contracts\HttpClientInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /** @var PromiseInterface[] Holds promises. */
    private static array $promises = [];

    /** @var ClientInterface HTTP client. */
    protected ?ClientInterface $client;

    /** @var array Guzzle Config */
    protected array $config = [
        RequestOptions::TIMEOUT         => 60,
        RequestOptions::CONNECT_TIMEOUT => 10,
    ];

    /**
     * Unwrap Promises.
     *
     * @throws Throwable
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * Get the HTTP client.
     *
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client ??= new Client($this->config);
    }

    /**
     * Set the HTTP client.
     *
     * @param ClientInterface $client
     *
     * @return GuzzleHttpClient
     */
    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get Guzzle Config.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set Guzzle Config.
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws TelegramSDKException
     */
    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    ) {
        $options[RequestOptions::HEADERS] = $headers;
        $options[RequestOptions::SYNCHRONOUS] = !$isAsyncRequest;

        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (!$response instanceof ResponseInterface) {
                throw new TelegramSDKException($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }
}
