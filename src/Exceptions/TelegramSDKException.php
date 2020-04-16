<?php

namespace Telegram\Bot\Exceptions;

use Exception;
use Telegram\Bot\Commands\CommandInterface;

/**
 * Class TelegramSDKException.
 */
class TelegramSDKException extends Exception
{
    /**
     * Thrown when token is not provided.
     *
     * @param $tokenEnvName
     *
     * @return TelegramSDKException
     */
    public static function tokenNotProvided($tokenEnvName): self
    {
        return new static(
            'Required "token" not supplied in config and could not find fallback environment variable ' . $tokenEnvName . ''
        );
    }

    /**
     * Thrown when command class doesn't exist.
     *
     * @param string $commandClass
     *
     * @return TelegramSDKException
     */
    public static function commandClassDoesNotExist(string $commandClass): self
    {
        return new static('Command class [' . $commandClass . '] does not exist.');
    }

    /**
     * Thrown when command class is not a valid instance of CommandInterface.
     *
     * @param object $commandClass
     *
     * @return TelegramSDKException
     */
    public static function commandClassNotValid(object $commandClass): self
    {
        return new static(
            sprintf(
                'Command class "%s" should be an instance of "%s"',
                get_class($commandClass),
                CommandInterface::class
            )
        );
    }
}
