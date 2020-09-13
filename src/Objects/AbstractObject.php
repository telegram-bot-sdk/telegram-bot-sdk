<?php

namespace Telegram\Bot\Objects;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Telegram\Bot\Contracts\Arrayable;
use Telegram\Bot\Contracts\Jsonable;

/**
 * Class AbstractObject.
 */
abstract class AbstractObject implements Arrayable, IteratorAggregate, Jsonable, JsonSerializable
{
    /** @var object|array The fields contained in the object. */
    protected $fields;

    public function __construct($fields = [])
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
    public static function make($data = []): self
    {
        return new static($data);
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
     * Get the collection of fields as JSON.
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
     * Convert the object into something JSON serializable.
     *
     * @return object|array
     */
    public function jsonSerialize()
    {
        return $this->fields;
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
     * Convert the object to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
