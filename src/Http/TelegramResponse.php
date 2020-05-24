<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Promise\PromiseInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class TelegramResponse.
 *
 * Handles the response from Telegram API.
 */
class TelegramResponse
{
    /** @var null|int The HTTP status code response from API. */
    protected ?int $httpStatusCode;

    /** @var array The headers returned from API request. */
    protected array $headers;

    /** @var string The raw body of the response from API request. */
    protected string $body;

    /** @var object The decoded body of the API response. */
    protected object $decodedBody;

    /** @var TelegramRequest The original request that returned this response. */
    protected TelegramRequest $request;

    /** @var TelegramSDKException The exception thrown by this request. */
    protected TelegramSDKException $thrownException;

    /**
     * Gets the relevant data from the Http client.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     */
    public function __construct(TelegramRequest $request, $response)
    {
        if ($response instanceof ResponseInterface) {
            $this->httpStatusCode = $response->getStatusCode();
            $this->body = $response->getBody();
            $this->headers = $response->getHeaders();

            $this->decodeBody();
        } elseif ($response instanceof PromiseInterface) {
            $this->httpStatusCode = null;
        } else {
            throw new InvalidArgumentException(
                'Second constructor argument "response" must be instance of ResponseInterface or PromiseInterface'
            );
        }

        $this->request = $request;
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody(): void
    {
        $this->decodedBody = json_decode($this->body);

        if (!is_object($this->decodedBody)) {
            $this->decodedBody = new \stdClass();
        }

        if ($this->isError()) {
            $this->makeException();
        }
    }

    /**
     * Checks if response is an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return isset($this->decodedBody->ok) && ($this->decodedBody->ok === false);
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException(): void
    {
        $this->thrownException = TelegramResponseException::create($this);
    }

    /**
     * Return the original request that returned this response.
     *
     * @return TelegramRequest
     */
    public function getRequest(): TelegramRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code.
     * Returns NULL if the request was asynchronous since we are not waiting for the response.
     *
     * @return null|int
     */
    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the Request Endpoint used to get the response.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->request->getEndpoint();
    }

    /**
     * Return the bot access token that was used for this request.
     *
     * @throws TelegramSDKException
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->request->getAccessToken();
    }

    /**
     * Return the HTTP headers for this response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Return the decoded body response.
     *
     * @return object
     */
    public function getDecodedBody(): object
    {
        return $this->decodedBody ?? new \stdClass();
    }

    /**
     * Helper function to return the payload of a successful response.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->decodedBody->result ?? new \stdClass();
    }

    /**
     * Throws the exception.
     *
     * @throws TelegramSDKException
     */
    public function throwException(): TelegramSDKException
    {
        throw $this->thrownException;
    }

    /**
     * Returns the exception that was thrown for this request.
     *
     * @return TelegramSDKException
     */
    public function getThrownException(): TelegramSDKException
    {
        return $this->thrownException;
    }
}
