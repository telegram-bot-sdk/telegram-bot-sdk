<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramLoginAuthException.
 */
final class TelegramLoginAuthException extends TelegramSDKException
{
    /**
     * Thrown when hash field is not found in given auth data.
     */
    public static function hashNotFound(): self
    {
        return new self('Missing "hash" field in given auth data');
    }

    /**
     * Thrown when auth data is not from Telegram.
     */
    public static function dataNotFromTelegram(): self
    {
        return new self('Auth Data is NOT from Telegram');
    }

    /**
     * Thrown when auth data is outdated.
     */
    public static function dataOutdated(): self
    {
        return new self('Auth Data is outdated');
    }
}
