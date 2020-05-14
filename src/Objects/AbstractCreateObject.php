<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Class AbstractCreateObject
 *
 * This base class is used for when the user needs to create
 * an object to be sent TO telegram..
 */
abstract class AbstractCreateObject implements JsonSerializable
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

    /**
     * Make object with given data.
     *
     * @param mixed $data
     *
     * @return static
     */
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
     * Get the object of fields as an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->fields;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->fields;
    }

    /**
     * Get the fields as JSON.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->fields, $options);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
