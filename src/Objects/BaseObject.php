<?php

namespace Telegram\Bot\Objects;

use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class BaseObject.
 */
abstract class BaseObject implements ArrayAccess, Countable
{
    /** @var object The fields contained in the object. */
    protected object $fields;

    /**
     * Create a new object.
     *
     * @param mixed $fields
     */
    public function __construct($fields = [])
    {
        $data = $this->getRawResult($fields);

        if (is_array($data)) {
            $data = json_decode(json_encode($fields));
        }

        $this->fields = $data;
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
     * Make a collection out of the given data.
     *
     * @return Collection
     */
    public function collect(): Collection
    {
        return collect($this->fields);
    }

    /**
     * Get all fields.
     *
     * @return object
     */
    public function all(): object
    {
        return $this->fields;
    }

    /**
     * Returns raw result.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getRawResult($data)
    {
        return data_get($data, 'result', $data);
    }

    /**
     * Get Status of request.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return data_get($this->fields, 'ok', false);
    }

    /**
     * Determine if a field exists.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * Get a field.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Set the field with given value.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Forget a field.
     *
     * @param mixed $key
     */
    public function forget($key): void
    {
        $this->offsetUnset($key);
    }

    /**
     * Count the number of fields in the object.
     *
     * @return int
     */
    public function count(): int
    {
        return count((array)$this->fields);
    }

    /**
     * Determine if a field exists at an offset.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return isset($this->fields->{Str::snake($key)});
    }

    /**
     * Get a field at a given offset.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return data_get($this->fields, Str::snake($key));
    }

    /**
     * Set the field at a given offset.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value): void
    {
        data_set($this->fields, Str::snake($key), $value);
    }

    /**
     * Unset the field at a given offset.
     *
     * @param string $key
     */
    public function offsetUnset($key): void
    {
        unset($this->fields->{Str::snake($key)});
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
        return json_encode($this->all(), $options);
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

    /**
     * Magically access collection data.
     *
     * @param $field
     *
     * @return mixed
     */
    public function __get($field)
    {
        if (!$this->has($field)) {
            return null;
        }

        return $this->get($field);
    }

    /**
     * @param $field
     * @param $value
     *
     * @throws TelegramSDKException
     */
    public function __set($field, $value)
    {
        if (!$this->has($field)) {
            throw new TelegramSDKException("Property [{$field}] does not exist on this object instance.");
        }

        $this->set($field, $value);
    }

    public function __isset($field)
    {
        return $this->has($field);
    }

    public function __unset($field)
    {
        $this->forget($field);
    }

    /**
     * Magic method to get properties dynamically.
     *
     * @param $method
     * @param $arguments
     *
     * @throws $method
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $collect = $this->collect();

        if (method_exists($this->collect(), $method)) {
            return $collect->{$method}(...$arguments);
        }

        throw new \BadMethodCallException("Method [$method] does not exist.");
    }
}
