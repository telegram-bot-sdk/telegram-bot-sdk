<?php

namespace Telegram\Bot\Http;

use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\InputMedia\AbstractArrayObject;
use Telegram\Bot\Traits\HasAccessToken;

/**
 * Class TelegramRequest.
 *
 * Builds Telegram Bot API Request Entity.
 */
class TelegramRequest
{
    use HasAccessToken;

    /** @var string The HTTP method for this request. */
    protected string $method;

    /** @var string The API endpoint for this request. */
    protected string $endpoint;

    /** @var array The headers to send with this request. */
    protected array $headers = [];

    /** @var array The parameters to send with this request. */
    protected array $params = [];

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected bool $isAsyncRequest = false;

    /**
     * Creates a new Request entity.
     *
     * @param string|null $accessToken
     * @param string|null $method
     * @param string|null $endpoint
     * @param array|null  $params
     * @param bool        $isAsyncRequest
     */
    public function __construct(
        string $accessToken = null,
        string $method = null,
        string $endpoint = null,
        array $params = [],
        bool $isAsyncRequest = false
    ) {
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->setAsyncRequest($isAsyncRequest);
    }

    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the HTTP method for this request.
     *
     * @param string
     *
     * @return TelegramRequest
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return the API Endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint for this request.
     *
     * @param string $endpoint
     *
     * @return TelegramRequest
     */
    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Return the params for this request.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set the params for this request.
     *
     * @param array $params
     *
     * @return TelegramRequest
     */
    public function setParams(array $params): self
    {
        if (isset($params['multipart'])) {
            $params['multipart'] = $this->makeMultipartPayload($params['multipart']);
        }

        $this->params = $params;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param $isAsyncRequest
     *
     * @return TelegramRequest
     */
    public function setAsyncRequest($isAsyncRequest): self
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Return the headers for this request.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return array_merge($this->headers, $this->getDefaultHeaders());
    }

    /**
     * Set the headers for this request.
     *
     * @param array $headers
     *
     * @return TelegramRequest
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * The default headers used with every request.
     *
     * @return array
     */
    public function getDefaultHeaders(): array
    {
        return [
            'User-Agent' => 'Telegram-Bot-SDK/Telegram-Bot-SDK',
        ];
    }

    protected function makeMultipartPayload($params): array
    {
        $params = collect($params);

        $multipart = $params->filter(fn ($param) => $param instanceof AbstractArrayObject)
            ->flatMap(fn ($param) => $param->toMultipart())
            ->all();

        return $params->map(fn ($contents, $name) => $this->generateMultipartData($contents, $name))
            ->concat($multipart)
            ->values()
            ->all();
    }

    /**
     * Generates the multipart data required when sending files to telegram.
     *
     * @param mixed  $contents
     * @param string $name
     *
     * @return array
     */
    protected function generateMultipartData($contents, string $name): array
    {
        if (Validator::isInputFile($contents)) {
            return [
                'name'     => $name,
                'contents' => $contents->getContents(),
                'filename' => $contents->getFilename(),
            ];
        }

        // TODO: Remove after testing all methods, this might not be needed.
        if (Validator::isJsonable($contents)) {
            $contents = $contents->toJson();
        }

        return compact('name', 'contents');
    }
}
