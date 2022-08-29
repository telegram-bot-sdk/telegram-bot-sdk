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
    /**
     * Create a new object.
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        parent::__construct($fields);
    }

    /**
     * Magic method to set properties dynamically.
     *
     * @param $name
     * @param $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $property = Str::snake($name);
        $this->fields[$property] = $arguments[0];

        return $this;
    }
}
