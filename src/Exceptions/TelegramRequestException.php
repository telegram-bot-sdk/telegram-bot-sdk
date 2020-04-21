<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramRequestException.
 */
class TelegramRequestException extends TelegramSDKException
{
    /**
     * Thrown when HTTP method is not specified.
     *
     * @return static
     */
    public static function httpMethodNotSpecified(): self
    {
        return new static('HTTP method not specified.');
    }

    /**
     * Thrown when HTTP method is invalid.
     *
     * @return static
     */
    public static function invalidHttpMethod(): self
    {
        return new static('Invalid HTTP method specified. Must be GET or POST');
    }
}
