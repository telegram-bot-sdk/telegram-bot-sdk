<?php

namespace Telegram\Bot\Objects;

use BadMethodCallException;
use ArrayAccess;
use Countable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Exceptions\TelegramSDKException;

abstract class AbstractResponseObject extends AbstractObject implements ArrayAccess, Countable
{
    /**
     * Create a new object.
     *
     * @param mixed $fields
     */
    public function __construct($fields = [])
    {
        $data = $this->getRawResult($fields);

        if (is_array($data)) {
            $data = json_decode(json_encode($fields, JSON_THROW_ON_ERROR), null, 512, JSON_THROW_ON_ERROR);
        }

        parent::__construct($data);
    }

    /**
     * Make a collection of fields.
     */
    public function collect(): Collection
    {
        return collect($this->fields);
    }

    /**
     * Field relations.
     */
    public function relations(): array
    {
        return [];
    }

    /**
     * Get all fields.
     *
     * @return object|array
     */
    public function all()
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
     *
     */
    public function has(mixed $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * Get field from the object by key.
     *
     *
     * @return mixed
     */
    public function get(mixed $key, mixed $default = null)
    {
        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        return value($default);
    }

    /**
     * Put a field in the object by key.
     *
     *
     * @return static
     */
    public function put(mixed $key, mixed $value): self
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Remove a field from the object by key.
     *
     * @param string|array $keys
     *
     * @return $this
     */
    public function forget($keys): self
    {
        foreach ((array)$keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * Count the number of fields in the object.
     */
    public function count(): int
    {
        return count((array)$this->fields);
    }

    /**
     * Detect type based on fields.
     */
    public function objectType(): ?string
    {
        return null;
    }

    /**
     * Determine if the object is of given type.
     *
     *
     */
    public function isType(string $type): bool
    {
        if ($this->offsetExists($type)) {
            return true;
        }

        return $this->objectType() === $type;
    }

    /**
     * Determine the type by given types.
     *
     *
     */
    protected function findType(array $types): ?string
    {
        return $this->collect()
            ->keys()
            ->intersect($types)
            ->pop();
    }

    /**
     * Determine if a field exists at an offset.
     *
     *
     */
    public function offsetExists(mixed $key): bool
    {
        return isset($this->fields->{$key});
    }

    /**
     * Get a field at a given offset.
     *
     *
     */
    public function offsetGet(mixed $key): mixed
    {
        return data_get($this->fields, $key);
    }

    /**
     * Set the field at a given offset.
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        data_set($this->fields, $key, $value);
    }

    /**
     * Unset the field at a given offset.
     *
     * @param string $key
     */
    public function offsetUnset($key): void
    {
        unset($this->fields->{$key});
    }

    /**
     * Magically access object data.
     *
     * @param $field
     *
     * @return mixed
     */
    public function __get($field)
    {
        if (! $this->offsetExists($field)) {
            return null;
        }

        $value = $this->offsetGet($field);

        $relations = $this->relations();
        if (isset($relations[$field])) {
            if (is_array($value)) {
                return collect($value)->mapInto($relations[$field])->all();
            }

            return $relations[$field]::make($value);
        }

        $class = 'Telegram\Bot\Objects\\' . Str::studly($field);

        if (class_exists($class)) {
            /** @var AbstractResponseObject $class */
            return $class::make($value);
        }

        if (is_array($value)) {
            return TelegramObject::make($value);
        }

        return $value;
    }

    /**
     * Set value of a field.
     *
     * @param $field
     * @param $value
     *
     * @throws TelegramSDKException
     */
    public function __set($field, $value)
    {
        if (! $this->offsetExists($field)) {
            throw new TelegramSDKException("Property [{$field}] does not exist on this object instance.");
        }

        $this->offsetSet($field, $value);
    }

    /**
     * Determine if the field exists.
     *
     * @param $field
     *
     * @return bool
     */
    public function __isset($field)
    {
        return $this->offsetExists($field);
    }

    /**
     * Unset field.
     *
     * @param $field
     */
    public function __unset($field)
    {
        $this->offsetUnset($field);
    }

    /**
     * Magic method to get properties dynamically.
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($collect = $this->collect(), $method)) {
            return $collect->{$method}(...$arguments);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
