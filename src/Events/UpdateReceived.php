<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasBot;
use Telegram\Bot\Traits\HasUpdate;

class UpdateReceived
{
    use HasBot;
    use HasUpdate;

    public function __construct(Bot $bot, Update $update)
    {
        $this->bot = $bot;
        $this->update = $update;
    }
}
