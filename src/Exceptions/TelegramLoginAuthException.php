<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramLoginAuthException.
 */
class TelegramLoginAuthException extends TelegramSDKException
{
    /**
     * Thrown when hash field is not found in given auth data.
     *
     * @return static
     */
    public static function hashNotFound(): self
    {
        return new static('Missing "hash" field in given auth data');
    }

    /**
     * Thrown when auth data is not from Telegram.
     *
     * @return static
     */
    public static function dataNotFromTelegram(): self
    {
        return new static('Auth Data is NOT from Telegram');
    }

    /**
     * Thrown when auth data is outdated.
     *
     * @return static
     */
    public static function dataOutdated(): self
    {
        return new static('Auth Data is outdated');
    }
}
