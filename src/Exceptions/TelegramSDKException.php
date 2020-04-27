<?php

namespace Telegram\Bot\Exceptions;

use Exception;
use Throwable;

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
     * Thrown when bot token is not provided.
     *
     * @return static
     */
    public static function tokenNotProvided(): self
    {
        return new static(
            'Required "token" not supplied in config'
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

    /**
     * Thrown when command name is not set.
     *
     * @param string|object $command
     *
     * @return static
     */
    public static function commandNameNotSet($command): self
    {
        $command = is_object($command) ? get_class($command) : $command;

        return new static("[$command] command has no name. Add a command name in your config!");
    }

    /**
     * Thrown when http client handler class is not instantiable.
     *
     * @param string    $httpClient
     * @param Throwable $e
     * @param int       $code
     *
     * @return static
     */
    public static function httpClientNotInstantiable(string $httpClient, Throwable $e, int $code = 0): self
    {
        return new static('Http Client class [' . $httpClient . '] is not instantiable.', $code, $e);
    }

    /**
     * Thrown when type of update object is not determinable.
     *
     * @return static
     */
    public static function updateObjectIndeterminable(): self
    {
        return new static('The type of Update Object was not determinable.');
    }
}
