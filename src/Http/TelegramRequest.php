<?php

namespace Telegram\Bot\Http;

use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\InputMedia\AbstractArrayObject;
use Telegram\Bot\Traits\HasToken;

/**
 * Class TelegramRequest.
 *
 * Builds Telegram Bot API Request Entity.
 */
final class TelegramRequest
{
    use HasToken;

    /** @var string The HTTP method for this request. */
    private string $method;

    /** @var string The API endpoint for this request. */
    private string $endpoint;

    /** @var array The headers to send with this request. */
    private array $headers = [];

    /** @var array The parameters to send with this request. */
    private array $params = [];

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    private bool $isAsyncRequest = false;

    public function __construct(
        string $token = null,
        string $method = null,
        string $endpoint = null,
        array $params = [],
        bool $isAsyncRequest = false
    ) {
        $this->setToken($token);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->setAsyncRequest($isAsyncRequest);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);

        return $this;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        if (isset($params['multipart'])) {
            $params['multipart'] = $this->makeMultipartPayload($params['multipart']);
        }

        $this->params = $params;

        return $this;
    }

    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    public function setAsyncRequest(bool $isAsyncRequest): self
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    public function getHeaders(): array
    {
        return array_merge($this->headers, $this->getDefaultHeaders());
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getDefaultHeaders(): array
    {
        return [
            'User-Agent' => 'Telegram-Bot-SDK/Telegram-Bot-SDK',
        ];
    }

    private function makeMultipartPayload($params): array
    {
        $params = collect($params);

        $multipart = $params->filter(fn ($param): bool => $param instanceof AbstractArrayObject)
            ->flatMap(fn ($param) => $param->toMultipart())
            ->all();

        return $params->map(fn ($contents, $name): array => $this->generateMultipartData($contents, $name))
            ->concat($multipart)
            ->values()
            ->all();
    }

    private function generateMultipartData(mixed $contents, string $name): array
    {
        if (Validator::isInputFile($contents)) {
            return [
                'name' => $name,
                'contents' => $contents->getContents(),
                'filename' => $contents->getFilename(),
            ];
        }

        // TODO: Remove after testing all methods, this might not be needed.
        if (Validator::isJsonable($contents)) {
            $contents = $contents->toJson();
        }

        return ['name' => $name, 'contents' => $contents];
    }
}
