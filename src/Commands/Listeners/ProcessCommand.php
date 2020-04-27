<?php

namespace Telegram\Bot\Commands\Listeners;

use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Events\UpdateReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessCommand
{
    protected CommandHandler $handler;

    public function __construct(CommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param UpdateReceived $event
     *
     * @throws TelegramSDKException
     */
    public function handle(UpdateReceived $event)
    {
        $this->handler->processCommand($event->getUpdate());
    }
}
