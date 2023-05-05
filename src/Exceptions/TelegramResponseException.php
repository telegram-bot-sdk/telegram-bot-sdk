<?php

namespace Telegram\Bot\Exceptions;

use Exception;
use Telegram\Bot\Http\TelegramResponse;
use Telegram\Bot\Objects\ResponseObject;

/**
 * Class TelegramResponseException.
 */
final class TelegramResponseException extends TelegramSDKException
{
    /** @var object Decoded response. */
    private readonly object $responseData;

    public function __construct(protected TelegramResponse $response, ?TelegramSDKException $previousException = null)
    {
        $this->responseData = $response->getDecodedBody();

        $errorMessage = $this->get('description', 'Unknown error from API Response.');
        $errorCode = $this->get('error_code', -1);

        parent::__construct($errorMessage, $errorCode, $previousException);
    }

    private function get(string $key, mixed $default = null): mixed
    {
        return data_get($this->responseData, $key, $default);
    }

    public static function create(TelegramResponse $response, ?Exception $previousException = null): self
    {
        return new self($response, new TelegramOtherException($previousException?->getMessage(), $previousException?->getCode(), $previousException));
    }

    public function getHttpStatusCode(): ?int
    {
        return $this->response->getHttpStatusCode();
    }

    public function getErrorType(): string
    {
        return $this->get('type', '');
    }

    public function getRawResponse(): string
    {
        return $this->response->getBody();
    }

    public function getResponseData(): ResponseObject
    {
        return $this->responseData;
    }

    public function getResponse(): TelegramResponse
    {
        return $this->response;
    }

    public function getParameters()
    {
        return $this->get('parameters');
    }
}
