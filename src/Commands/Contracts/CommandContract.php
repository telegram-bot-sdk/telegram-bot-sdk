<?php

namespace Telegram\Bot\Commands\Contracts;

use Telegram\Bot\Bot;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Objects\ResponseObject;
use Throwable;

interface CommandContract
{
    public function getName(): string;

    public function setName(string $name): self;

    public function getDescription(): string;

    public function setDescription(string $description): self;

    public function getArguments(): array;

    public function setArguments(array $arguments): self;

    public function getArgumentsNotProvided(): array;

    public function setArgumentsNotProvided(array $arguments): self;

    public function getBot(): ?Bot;

    public function setBot(Bot $bot): self;

    public function getCommandBus(): CommandBus;

    public function setCommandBus(CommandBus $commandBus): self;

    public function failed(array $arguments, Throwable $exception): void;

    public function getUpdate(): ResponseObject;

    public function setUpdate(ResponseObject $update);
}
