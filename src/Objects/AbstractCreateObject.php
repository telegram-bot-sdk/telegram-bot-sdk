<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Str;

/**
 * Class AbstractCreateObject
 *
 * This base class is used for when the user needs to create
 * an object to be sent TO telegram.
 */
abstract class AbstractCreateObject extends AbstractObject
{
    public function __call(string $name, array $arguments)
    {
        $property = Str::snake($name);
        $this->fields[$property] = $arguments[0];

        return $this;
    }
}
