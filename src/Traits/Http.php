<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Exceptions\CouldNotUploadInputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Http\HttpClientInterface;
use Telegram\Bot\Http\TelegramClient;
use Telegram\Bot\Http\TelegramResponse;

/**
 * Http.
 *
 * @method $this setHttpClientHandler() setHttpClientHandler(HttpClientInterface $httpClientHandler) Set Http Client Handler.
 *
 * @method string getAccessToken() getAccessToken() Get the bot access token.
 * @method self setAccessToken() setAccessToken(string $accessToken) Set the bot access token.
 *
 * @method int getConnectTimeout() getConnectTimeout() Connection timeout of the request in seconds.
 * @method self setConnectTimeout() setConnectTimeout(int $connectTimeout) Connection timeout of the request in seconds.
 *
 * @method int getTimeout() getTimeout() Timeout of the request in seconds.
 * @method self setTimeout() setTimeout(int $timeout) Timeout of the request in seconds.
 *
 * @method bool isAsyncRequest() isAsyncRequest() Check if this is an asynchronous request (non-blocking).
 * @method self setAsyncRequest() setAsyncRequest(bool $isAsyncRequest) Make this request asynchronous (non-blocking).
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
    protected function getClient(): TelegramClient
    {
        return $this->client ??= (new TelegramClient())->setAccessToken($this->getAccessToken());
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function get(string $endpoint, array $params = []): TelegramResponse
    {
        return $this->getClient()->get($endpoint, $params);
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     * @param bool   $fileUpload Set true if a file is being uploaded.
     * @param array  $jsonEncode
     *
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function post(string $endpoint, array $params = [], bool $fileUpload = false, array $jsonEncode = []): TelegramResponse
    {
        return $this->getClient()->post($endpoint, $params, $fileUpload, $jsonEncode);
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $inputFileField
     * @param array  $jsonEncode
     *
     * @throws CouldNotUploadInputFile
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function uploadFile(string $endpoint, array $params, string $inputFileField, array $jsonEncode = []): TelegramResponse
    {
        return $this->getClient()->uploadFile($endpoint, $params, $inputFileField, $jsonEncode);
    }
}
