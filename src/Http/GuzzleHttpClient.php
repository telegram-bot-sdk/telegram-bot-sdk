<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
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
    protected ClientInterface $client;

    /** @var int Timeout of the request in seconds. */
    protected int $timeout = 30;

    /** @var int Connection timeout of the request in seconds. */
    protected int $connectTimeout = 10;

    /**
     * GuzzleHttpClient constructor.
     *
     * @param ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->setClient($client ?? new Client());
    }

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
        return $this->client;
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
     * {@inheritdoc}
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeout($timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    /**
     * {@inheritdoc}
     */
    public function setConnectTimeout($connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws TelegramSDKException
     */
    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    ) {
        $body = $options['body'] ?? null;
        $options = $this->getOptions($headers, $body, $options, $isAsyncRequest);

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

    /**
     * Prepares and returns request options.
     *
     * @param array $headers
     * @param mixed $body
     * @param array $options
     * @param bool  $isAsyncRequest
     *
     * @return array
     */
    private function getOptions(array $headers, $body, array $options, bool $isAsyncRequest = false): array
    {
        return array_merge([
            RequestOptions::HEADERS         => $headers,
            RequestOptions::BODY            => $body,
            RequestOptions::TIMEOUT         => $this->timeout,
            RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
            RequestOptions::SYNCHRONOUS     => !$isAsyncRequest,
        ], $options);
    }
}
