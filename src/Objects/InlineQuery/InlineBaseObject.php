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
    protected static string $type;

    public static function make($data = []): self
    {
        return new static(array_merge($data, ['type' => static::$type]));
    }

}
