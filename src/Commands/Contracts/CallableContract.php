<?php

namespace Telegram\Bot\Commands\Contracts;

interface CallableContract
{
    public function onFailure(string|array|callable $callback): self;

    public function getCommandHandler(): string|array|callable;

    public function setCommandHandler(string|array|callable $handler): self;
}
