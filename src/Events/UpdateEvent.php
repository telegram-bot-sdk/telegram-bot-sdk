<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\Update;

class UpdateEvent
{
    public const NAME = 'update';

    public Bot $bot;
    public Update $update;

    public function __construct(Bot $bot, Update $update)
    {
        $this->bot = $bot;
        $this->update = $update;
    }
}
