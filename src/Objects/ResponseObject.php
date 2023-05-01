<?php

namespace Telegram\Bot\Objects;

use Countable;
use ArrayAccess;
use Traversable;
use ArrayIterator;
use LogicException;
use JsonSerializable;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class ResponseObject implements Arrayable, ArrayAccess, Countable, IteratorAggregate, Jsonable, JsonSerializable
{
    public function __construct(private array $fields = [])
    {
    }

    public function getCustomData(): ?array
    {
        return $this->fields['custom_data'] ?? null;
    }

    public function addCustomData(mixed $key, mixed $value): static
    {
        if (is_null($key)) {
            $this->fields['custom_data'][] = $value;
        } else {
            $this->fields['custom_data'][$key] = $value;
        }

        return $this;
    }

    public function count(): int
    {
        return count($this->fields);
    }

    public function jsonSerialize(): array
    {
        return $this->collect()->jsonSerialize();
    }

    public function collect(): Collection
    {
        return new Collection($this->fields);
    }

    public function toJson($options = 0): string
    {
        return $this->collect()->toJson($options);
    }

    public function toArray(): array
    {
        return $this->collect()->toArray();
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->fields);
    }

    public function __toString(): string
    {
        return $this->collect()->__toString();
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
        $field = $this->collect()->get($offset);

        return is_array($field) ? new static($field) : $field;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Cannot modify an immutable object. Value cannot be set. Use addCustomData() instead to add extra data.');
    }

    public function __isset(string $name): bool
    {
        return $this->offsetExists($name);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->collect()->has($offset);
    }

    public function __unset(string $name): void
    {
        $this->offsetUnset($name);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Cannot modify an immutable object. Value cannot be unset.');
    }
}