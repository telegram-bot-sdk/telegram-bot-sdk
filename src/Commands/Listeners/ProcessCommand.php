<?php

namespace Telegram\Bot\Commands\Listeners;

use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Events\UpdateReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessCommand
{
    /**
     * @param UpdateReceived $event
     *
     * @throws TelegramSDKException
     */
    public function handle(UpdateReceived $event): void
    {
        (new CommandHandler($event->bot))->processCommand($event->update);
    }
}
