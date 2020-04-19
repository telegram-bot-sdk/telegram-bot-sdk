<?php

namespace Telegram\Bot\Commands;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    public function getDescription(): string;

    public function getArguments(): array;
}
