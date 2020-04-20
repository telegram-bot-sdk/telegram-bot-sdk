<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Api;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    public function getDescription(): string;

    public function getArguments(): array;

    public function setTelegram(Api $telegram);
}
