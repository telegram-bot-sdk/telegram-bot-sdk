<?php

namespace Telegram\Bot\Exceptions;

use Exception;

/**
 * Class TelegramSDKException.
 */
class TelegramSDKException extends Exception
{
    /**
     * Thrown when bot is not configured.
     *
     * @param string $name
     *
     * @return static
     */
    public static function botNotConfigured(string $name): self
    {
        return new static("Bot [$name] not configured.");
    }

    /**
     * Thrown when token is not provided.
     *
     * @param $tokenEnvName
     *
     * @return static
     */
    public static function tokenNotProvided($tokenEnvName): self
    {
        return new static(
            'Required "token" not supplied in config and could not find fallback environment variable ' . $tokenEnvName . ''
        );
    }

    /**
     * Thrown when update object is not found.
     *
     * @return static
     */
    public static function updateObjectNotFound(): self
    {
        return new static('No Update Object Found.');
    }
}
