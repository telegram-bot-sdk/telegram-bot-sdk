<?php

namespace Telegram\Bot\Objects;

use ArrayIterator;
use Illuminate\Support\Str;
use JsonSerializable;
use Telegram\Bot\Contracts\Jsonable;
use IteratorAggregate;

/**
 * Class AbstractCreateObject
 *
 * This base class is used for when the user needs to create
 * an object to be sent TO telegram..
 */
abstract class AbstractCreateObject implements IteratorAggregate, Jsonable, JsonSerializable
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
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->fields);
    }

    /**
     * Get the object of fields as an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
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
        return json_encode($this->jsonSerialize(), $options);
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
