<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramRequestException.
 */
final class TelegramRequestException extends TelegramSDKException
{
    /**
     * Thrown when HTTP method is not specified.
     */
    public static function httpMethodNotSpecified(): self
    {
        return new self('HTTP method not specified.');
    }

    /**
     * Thrown when HTTP method is invalid.
     */
    public static function invalidHttpMethod(): self
    {
        return new self('Invalid HTTP method specified. Must be GET or POST');
    }
}
