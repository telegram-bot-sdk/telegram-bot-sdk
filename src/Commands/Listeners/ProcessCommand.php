<?php

namespace Telegram\Bot\Commands\Listeners;

use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Events\UpdateReceived;

class ProcessCommand
{
    protected CommandHandler $handler;

    public function __construct(CommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(UpdateReceived $event): void
    {
        $this->handler->processCommand($event->update);
    }
}
