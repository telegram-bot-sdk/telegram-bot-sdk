<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\Objects\BaseCreateObject;

/**
 * Class InputMedia.
 *
 * This object represents the content of a media message to be sent.
 */
abstract class InputMedia extends BaseCreateObject
{
    protected string $type;

    protected function toArray(): array
    {
        return array_merge($this->fields, ['type' => $this->type]);
    }
}
