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
        if (method_exists($this->fields, $name)) {
            return parent::__call($name, $arguments);
        }

        $value = $arguments[0];
        if ($value instanceof AbstractObject) {
            $value = $value->toArray();
        }

        $this->fields->offsetSet(Str::snake($name), $value);

        return $this;
    }
}
