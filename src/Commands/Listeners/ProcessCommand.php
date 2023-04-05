<?php

namespace Telegram\Bot\Commands\Listeners;

use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessCommand
{
    /**
     * @throws TelegramSDKException
     */
    public function handle(UpdateEvent $event): void
    {
        (new CommandHandler($event->bot))->processCommand($event->update);
    }
}
