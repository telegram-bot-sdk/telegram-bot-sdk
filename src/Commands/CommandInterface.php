<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    public function getDescription(): string;

    public function getArguments(): array;
}
