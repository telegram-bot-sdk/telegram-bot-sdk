<?php

namespace Telegram\Bot\Http;

use JsonException;
use Telegram\Bot\Helpers\Json;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramJsonException;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\ResponseObject;

/**
 * Class TelegramResponse.
 *
 * Handles the response from Telegram API.
 */
class TelegramResponse
{
    /** @var null|int The HTTP status code response from API. */
    protected ?int $httpStatusCode = null;

    /** @var array The headers returned from API request. */
    protected array $headers;

    /** @var string The raw body of the response from API request. */
    protected string $body;

    /** @var null|ResponseObject The decoded body of the API response. */
    protected ?ResponseObject $decodedBody = null;

    /** @var null|TelegramSDKException The exception thrown by this request. */
    protected ?TelegramSDKException $thrownException;

    public function __construct(protected TelegramRequest $request, PromiseInterface|ResponseInterface $response)
    {
        if ($response instanceof ResponseInterface) {
            $this->httpStatusCode = $response->getStatusCode();
            $this->body = $response->getBody();
            $this->headers = $response->getHeaders();

            $this->decodeBody();
        } else {
            $this->httpStatusCode = null;
        }
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody(): void
    {
        try {
            $this->decodedBody = new ResponseObject(Json::decode($this->body));
        } catch (TelegramJsonException $e) {
            $this->thrownException = TelegramResponseException::create($this, $e);
        }

        if ($this->isError()) {
            $this->makeException();
        }
    }

    /**
     * Checks if response is an error.
     */
    public function isError(): bool
    {
        return $this->decodedBody?->offsetGet('ok') === false;
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException(): void
    {
        $this->thrownException ??= TelegramResponseException::create($this);
    }

    /**
     * Return the original request that returned this response.
     */
    public function getRequest(): TelegramRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code.
     * Returns NULL if the request was asynchronous since we are not waiting for the response.
     */
    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the Request Endpoint used to get the response.
     */
    public function getEndpoint(): string
    {
        return $this->request->getEndpoint();
    }

    /**
     * Return the bot token that was used for this request.
     *
     * @throws TelegramSDKException
     */
    public function getToken(): ?string
    {
        return $this->request->getToken();
    }

    /**
     * Return the HTTP headers for this response.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Return the raw body response.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Return the decoded body response.
     */
    public function getDecodedBody(): ResponseObject
    {
        return $this->decodedBody ?? new ResponseObject();
    }

    /**
     * Helper function to return the payload of a successful response.
     *
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->decodedBody?->offsetGet('result') ?? new ResponseObject();
    }

    /**
     * Throws the exception.
     *
     * @throws TelegramSDKException
     */
    public function throwException(): never
    {
        throw $this->thrownException;
    }

    /**
     * Returns the exception that was thrown for this request.
     */
    public function getThrownException(): ?TelegramSDKException
    {
        return $this->thrownException;
    }
}
