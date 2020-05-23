<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Contracts\HttpClientInterface;
use Telegram\Bot\Http\TelegramClient;
use Telegram\Bot\Http\TelegramResponse;

/**
 * Http.
 *
 * @method self setHttpClientHandler(HttpClientInterface $httpClientHandler) Set Http Client Handler.
 *
 * @method string getAccessToken() Get the bot access token.
 * @method self setAccessToken(string $accessToken) Set the bot access token.
 *
 * @method bool isAsyncRequest() Check if this is an asynchronous request (non-blocking).
 * @method self setAsyncRequest(bool $isAsyncRequest) Make this request asynchronous (non-blocking).
 *
 * @method TelegramResponse get(string $endpoint, array $params = []) Sends a GET request to Telegram Bot API and returns the result.
 * @method TelegramResponse post(string $endpoint, array $params = []) Sends a POST request to Telegram Bot API and returns the result.
 * @method TelegramResponse uploadFile(string $endpoint, array $params, array $jsonEncode = []) Sends a multipart/form-data request to Telegram Bot API and returns the result.
 *
 * @method TelegramResponse|null getLastResponse() getLastResponse() Returns the last response returned from API request.
 */
trait Http
{
    /** @var TelegramClient The Telegram client service. */
    protected ?TelegramClient $client = null;

    /**
     * Returns the TelegramClient service.
     *
     * @return TelegramClient
     */
    public function getClient(): TelegramClient
    {
        return $this->client ??= (new TelegramClient())->setAccessToken($this->getAccessToken());
    }

    /**
     * Set HTTP Client Config.
     *
     * @param array $config
     *
     * @return $this
     */
    public function setHttpClientConfig(array $config): self
    {
        $this->getClient()->setConfig($config);

        return $this;
    }
}
