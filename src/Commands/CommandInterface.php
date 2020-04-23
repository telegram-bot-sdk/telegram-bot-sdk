<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Api;
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

    public function getApi(): Api;

    public function setApi(Api $api);

    public function failed(array $arguments, Throwable $exception);
}
