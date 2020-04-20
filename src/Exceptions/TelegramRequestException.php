<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramRequestException.
 */
class TelegramRequestException extends TelegramSDKException
{
    /**
     * Thrown when bot access token is not provided.
     *
     * @return TelegramRequestException
     */
    public static function botAccessTokenNotProvided(): self
    {
        return new static('You must provide your bot access token to make any API requests.');
    }

    /**
     * Thrown when HTTP method is not specified.
     *
     * @return TelegramRequestException
     */
    public static function httpMethodNotSpecified(): self
    {
        return new static('HTTP method not specified.');
    }

    /**
     * Thrown when HTTP method is invalid.
     *
     * @return TelegramRequestException
     */
    public static function invalidHttpMethod(): self
    {
        return new static('Invalid HTTP method specified. Must be GET or POST');
    }
}
