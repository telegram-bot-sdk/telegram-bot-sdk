<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\Update;

class UpdateEvent
{
    final public const NAME = 'update';

    public function __construct(public Bot $bot, public Update $update)
    {
    }
}
