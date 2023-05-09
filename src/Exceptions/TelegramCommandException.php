<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Collection;
use Throwable;
use Telegram\Bot\Commands\Contracts\CommandContract;

/**
 * Class TelegramCommandException.
 */
final class TelegramCommandException extends TelegramSDKException
{
    /**
     * Thrown when command method doesn't exist.
     */
    public static function commandMethodDoesNotExist(Throwable $e): self
    {
        return new self($e->getMessage(), 0, $e);
    }

    /**
     * Thrown when command class doesn't exist.
     */
    public static function commandClassDoesNotExist(string $commandClass): self
    {
        return new self('Command class ['.$commandClass.'] does not exist.');
    }

    /**
     * Thrown when command class is not a valid instance of CommandContract.
     */
    public static function commandClassNotValid(object $commandClass): self
    {
        return new self(
            sprintf(
                'Command class [%s] should be an instance of [%s]',
                $commandClass::class,
                CommandContract::class
            )
        );
    }

    /**
     * Thrown when command class is not instantiable.
     */
    public static function commandNotInstantiable(string $commandClass, Throwable $e, int $code = 0): self
    {
        return new self('Command class ['.$commandClass.'] is not instantiable.', $code, $e);
    }

    /**
     * Thrown when command's required params are not provided.
     */
    public static function requiredParamsNotProvided(Collection $requiredParamsNotProvided): self
    {
        $params = $requiredParamsNotProvided->implode(', $');

        return new self('Required command params [$'.$params.'] not provided');
    }
}
