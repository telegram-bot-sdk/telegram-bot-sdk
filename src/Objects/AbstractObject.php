<?php

namespace Telegram\Bot\Objects;

use Stringable;
use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Telegram\Bot\Contracts\Arrayable;
use Telegram\Bot\Contracts\Jsonable;

/**
 * Class AbstractObject.
 */
abstract class AbstractObject implements Arrayable, IteratorAggregate, Jsonable, JsonSerializable, Stringable
{
    /**
     * @param object|mixed[] $fields
     */
    public function __construct(
        /** @var object|array The fields contained in the object. */
        protected $fields = []
    )
    {
    }
    /**
     * Make object with given data.
     *
     *
     * @return static
     */
    public static function make(mixed $data = []): self
    {
        return new static($data);
    }
    /**
     * Get the object of fields as an associative array.
     */
    public function toArray(): array
    {
        return json_decode($this->toJson(), true, 512, JSON_THROW_ON_ERROR);
    }
    /**
     * Get the collection of fields as JSON.
     *
     * @param int $options
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
    public function jsonSerialize(): mixed
    {
        return $this->fields;
    }
    /**
     * Get an iterator for the items.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->fields);
    }
    /**
     * Convert the object to its string representation.
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
