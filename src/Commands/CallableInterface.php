<?php

namespace Telegram\Bot\Commands;

interface CallableInterface
{
    public function getCommandHandler(): string|array|callable;

    public function setCommandHandler(string|array|callable $handler): self;
}
