<?php

namespace Telegram\Bot\Commands\Events;

use Telegram\Bot\Bot;
use Telegram\Bot\Objects\ResponseObject;
use Throwable;

final class AttributeCommandFailed
{
    final public const NAME = 'command.attribute.failed';

    public function __construct(
        public string $command,
        public $handler,
        public Throwable $exception,
        public Bot $bot,
        public ?ResponseObject $update = null
    ) {
    }
}
