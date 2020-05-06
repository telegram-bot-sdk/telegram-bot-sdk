<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\BaseCreateObject;

/**
 * The base Inline Object Class
 *
 * To initialise quickly you can use the following array to construct the object:
 */
abstract class InlineBaseObject extends BaseCreateObject
{
    protected string $type;

    protected function toArray(): array
    {
        return array_merge($this->fields, ['type' => $this->type]);
    }
}