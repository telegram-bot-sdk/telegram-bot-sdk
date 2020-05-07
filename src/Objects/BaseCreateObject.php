<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Class BaseCreateObject
 *
 * This base class is used for when the user needs to create
 * an object to be sent TO telegram..
 */
abstract class BaseCreateObject implements JsonSerializable
{
    protected array $fields;

    /**
     * Create a new object.
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    public static function make(array $data = []): self
    {
        return new static($data);
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

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Get the object of fields as an associative array.
     *
     * @return array
     */
    protected function toArray(): array
    {
        return $this->fields;
    }
}
