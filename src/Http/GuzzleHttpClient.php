<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\unwrap;
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

    /** @var ClientInterface|null HTTP client. */
    protected ?ClientInterface $client = null;

    /** @var array Guzzle Config */
    protected array $config = [
        RequestOptions::TIMEOUT => 60,
        RequestOptions::CONNECT_TIMEOUT => 10,
    ];

    /**
     * Unwrap Promises.
     *
     * @throws Throwable
     */
    public function __destruct()
    {
        unwrap(self::$promises);
    }

    /**
     * Get the HTTP client.
     */
    public function getClient(): ClientInterface
    {
        return $this->client ??= new Client($this->config);
    }

    /**
     * Set the HTTP client.
     */
    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get Guzzle Config.
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set Guzzle Config.
     *
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
        $options[RequestOptions::SYNCHRONOUS] = ! $isAsyncRequest;

        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (! $response instanceof ResponseInterface) {
                throw new TelegramSDKException($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }
}
