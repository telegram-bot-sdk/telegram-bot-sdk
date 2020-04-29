<?php

namespace Telegram\Bot\Listeners;

use Telegram\Bot\Events\UpdateReceived;

class ProcessUpdate
{
    public function handle(UpdateReceived $event): void
    {
        // Dispatch the update again with an event name that contains the update type.
        $event->bot->getEventFactory()->dispatch(
            $event->update->getEventName(),
            $event,
        );
    }
}
