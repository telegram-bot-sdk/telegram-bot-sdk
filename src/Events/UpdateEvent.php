<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\ResponseObject;

final class UpdateEvent
{
    final public const NAME = 'update';

    public function __construct(public Bot $bot, public ResponseObject $update)
    {
    }
}
