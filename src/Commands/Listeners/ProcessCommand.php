<?php

namespace Telegram\Bot\Commands\Listeners;

use Telegram\Bot\Events\UpdateEvent;

final class ProcessCommand
{
    public function handle(UpdateEvent $event): void
    {
        $event->bot->getCommandHandler()->processCommand($event->update);
    }
}
