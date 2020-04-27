<?php

namespace Telegram\Bot\Listeners;

use Telegram\Bot\Events\UpdateReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessUpdate
{
    /**
     * @param UpdateReceived $event
     *
     * @throws TelegramSDKException
     */
    public function handle(UpdateReceived $event)
    {
        // Dispatch the update again with an event name that contains the update type.
        $event->getBot()->getEventFactory()->dispatch(
            $event->getUpdate()->getEventName(),
            $event,
        );
    }
}
