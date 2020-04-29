<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\Update;

class UpdateReceived
{
    public const NAME = 'update.received';

    public Bot $bot;
    public Update $update;

    public function __construct(Bot $bot, Update $update)
    {
        $this->bot = $bot;
        $this->update = $update;
    }
}
