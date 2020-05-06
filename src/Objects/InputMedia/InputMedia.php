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
    protected static string $type;

    public static function make($data = []): self
    {
        return new static(array_merge($data, ['type' => static::$type]));
    }
}
