<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\ResponseObject;

final class CommandNotFoundEvent
{
    final public const NAME = 'command.notfound';

    public function __construct(public string $command, public Bot $bot, public ?ResponseObject $update = null)
    {
    }
}
