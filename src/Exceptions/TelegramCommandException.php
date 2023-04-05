<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Collection;
use Telegram\Bot\Commands\CommandInterface;
use Throwable;

/**
 * Class TelegramCommandException.
 */
class TelegramCommandException extends TelegramSDKException
{
    /**
     * Thrown when command method doesn't exist.
     *
     *
     * @return static
     */
    public static function commandMethodDoesNotExist(Throwable $e): self
    {
        return new static($e->getMessage(), 0, $e);
    }

    /**
     * Thrown when command class doesn't exist.
     *
     *
     * @return static
     */
    public static function commandClassDoesNotExist(string $commandClass): self
    {
        return new static('Command class ['.$commandClass.'] does not exist.');
    }

    /**
     * Thrown when command class is not a valid instance of CommandInterface.
     *
     *
     * @return static
     */
    public static function commandClassNotValid(object $commandClass): self
    {
        return new static(
            sprintf(
                'Command class [%s] should be an instance of [%s]',
                $commandClass::class,
                CommandInterface::class
            )
        );
    }

    /**
     * Thrown when command class is not instantiable.
     *
     *
     * @return static
     */
    public static function commandNotInstantiable(string $commandClass, Throwable $e, int $code = 0): self
    {
        return new static('Command class ['.$commandClass.'] is not instantiable.', $code, $e);
    }

    /**
     * Thrown when command's required params are not provided.
     *
     *
     * @return static
     */
    public static function requiredParamsNotProvided(Collection $requiredParamsNotProvided): self
    {
        $params = $requiredParamsNotProvided->implode(', $');

        return new static('Required command params [$'.$params.'] not provided');
    }
}
