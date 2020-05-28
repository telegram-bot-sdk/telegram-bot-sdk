<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Contracts\HttpClientInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Http\TelegramClient;
use Telegram\Bot\Http\TelegramResponse;
use Telegram\Bot\Objects\File;

/**
 * Http.
 *
 * @method self setHttpClientHandler(HttpClientInterface $httpClientHandler) Set Http Client Handler.
 *
 * @method string getToken() Get the bot token.
 * @method self setToken(string $token) Set the bot token.
 *
 * @method string getBaseApiUrl() Get the Base API URL.
 * @method self setBaseApiUrl(string $baseApiUrl) Set the Base API URL.
 *
 * @method string getFileUrl(string $path = null) Get File URL.
 *
 * @method bool isAsyncRequest() Check if this is an asynchronous request (non-blocking).
 * @method self setAsyncRequest(bool $isAsyncRequest) Make this request asynchronous (non-blocking).
 *
 * @method TelegramResponse get(string $endpoint, array $params = []) Sends a GET request to Telegram Bot API and returns the result.
 * @method TelegramResponse post(string $endpoint, array $params = []) Sends a POST request to Telegram Bot API and returns the result.
 * @method TelegramResponse uploadFile(string $endpoint, array $params, array $jsonEncode = []) Sends a multipart/form-data request to Telegram Bot API and returns the result.
 *
 * @method TelegramResponse|null getLastResponse() Returns the last response returned from API request.
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
        return $this->client ??= (new TelegramClient())->setToken($this->getToken());
    }

    /**
     * Get HTTP Client Config.
     *
     * @return array
     */
    public function getHttpClientConfig(): array
    {
        return $this->getClient()->getConfig();
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

    /**
     * Download a file from Telegram server by file ID.
     *
     * @param File|string $file         Telegram File Instance or File ID.
     * @param string      $downloadPath Download path to save file.
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function downloadFile($file, string $downloadPath): bool
    {
        if (!$file instanceof File) {
            $file = $this->getFile(['file_id' => $file]);
        }

        return $this->getClient()->download($file->file_path, $downloadPath);
    }
}
