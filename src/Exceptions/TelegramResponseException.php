<?php

namespace Telegram\Bot\Exceptions;

use Telegram\Bot\Http\TelegramResponse;
use Telegram\Bot\Objects\ResponseParameters;

/**
 * Class TelegramResponseException.
 */
class TelegramResponseException extends TelegramSDKException
{
    /** @var TelegramResponse The response that threw the exception. */
    protected TelegramResponse $response;

    /** @var object Decoded response. */
    protected object $responseData;

    /**
     * Creates a TelegramResponseException.
     *
     * @param TelegramResponse     $response          The response that threw the exception.
     * @param TelegramSDKException $previousException The more detailed exception.
     */
    public function __construct(TelegramResponse $response, TelegramSDKException $previousException = null)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodedBody();

        $errorMessage = $this->get('description', 'Unknown error from API Response.');
        $errorCode = $this->get('error_code', -1);

        parent::__construct($errorMessage, $errorCode, $previousException);
    }

    /**
     * Checks isset and returns that or a default value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function get(string $key, $default = null)
    {
        return data_get($this->responseData, $key, $default);
    }

    /**
     * A factory for creating the appropriate exception based on the response from Telegram.
     *
     * @param TelegramResponse $response The response that threw the exception.
     *
     * @return static
     */
    public static function create(TelegramResponse $response): self
    {
        $data = $response->getDecodedBody();

        $code = null;
        $message = null;
        if (isset($data->ok, $data->error_code) && $data->ok === false) {
            $code = $data->error_code;
            $message = $data->description ?? 'Unknown error from API.';
        }

        // Others
        return new static($response, new TelegramOtherException($message, $code));
    }

    /**
     * Returns the HTTP status code.
     *
     * @return int|null
     */
    public function getHttpStatusCode(): ?int
    {
        return $this->response->getHttpStatusCode();
    }

    /**
     * Returns the error type.
     *
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->get('type', '');
    }

    /**
     * Returns the raw response used to create the exception.
     *
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->response->getBody();
    }

    /**
     * Returns the decoded response used to create the exception.
     *
     * @return object
     */
    public function getResponseData(): object
    {
        return $this->responseData;
    }

    /**
     * Returns the response entity used to create the exception.
     *
     * @return TelegramResponse
     */
    public function getResponse(): TelegramResponse
    {
        return $this->response;
    }

    /**
     * Get Response Parameters.
     *
     * @return ResponseParameters
     */
    public function getParameters(): ResponseParameters
    {
        return ResponseParameters::make($this->get('parameters'));
    }
}
