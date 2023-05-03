<?php

namespace Telegram\Bot\Objects;

use Countable;
use Stringable;
use ArrayAccess;
use Traversable;
use LogicException;
use CachingIterator;
use JsonSerializable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Telegram\Bot\Contracts\Jsonable;
use Telegram\Bot\Contracts\Arrayable;

class ResponseObject implements Arrayable, ArrayAccess, Countable, IteratorAggregate, Jsonable, JsonSerializable, Stringable
{
    private Collection $fields;

    public function __construct(array $fields = [])
    {
        $this->fields = new Collection($fields);
    }

    public function getCustomData(): array
    {
        return $this->fields->get('custom_data', []);
    }

    public function withCustomData(mixed $key, mixed $value): static
    {
        $data = $this->getCustomData();
        if (is_null($key)) {
            $data[] = $value;
        } else {
            $data[$key] = $value;
        }

        $this->fields->offsetSet('custom_data', $data);

        return $this;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Cannot modify an immutable object. Value cannot be set. Use addCustomData() instead to add extra data.');
    }

    public function count(): int
    {
        return $this->fields->count();
    }

    public function jsonSerialize(): array
    {
        return $this->fields->jsonSerialize();
    }

    public function collect(): Collection
    {
        return $this->fields;
    }

    public function toJson(int $options = 0): string
    {
        return $this->fields->toJson($options);
    }

    public function getIterator(): Traversable
    {
        return $this->fields->getIterator();
    }

    public function getCachingIterator(int $flags = CachingIterator::CALL_TOSTRING): CachingIterator
    {
        return $this->fields->getCachingIterator($flags);
    }

    public function __toString(): string
    {
        return $this->fields->__toString();
    }

    public function __get(string $name): mixed
    {
        return $this->offsetGet($name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->offsetSet($name, $value);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $field = $this->fields->get($offset);

        return is_array($field) ? new static($field) : $field;
    }

    public function __isset(string $name): bool
    {
        return $this->offsetExists($name);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->fields->has($offset);
    }

    public function __unset(string $name): void
    {
        $this->offsetUnset($name);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Cannot modify an immutable object. Value cannot be unset.');
    }

    public function __debugInfo()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->fields->toArray();
    }
}
