<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\Update;
use Throwable;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    public function getDescription(): string;

    public function setDescription(string $description): self;

    public function getArguments(): array;

    public function setArguments(array $arguments): self;

    public function getArgumentsNotProvided(): array;

    public function setArgumentsNotProvided(array $arguments): self;

    public function getBot(): Bot;

    public function setBot(Bot $bot): self;

    public function getCommandBus(): CommandBus;

    public function setCommandBus(CommandBus $commandBus): self;

    public function failed(array $arguments, Throwable $exception);

    public function getUpdate(): Update;

    public function setUpdate(Update $update);
}
