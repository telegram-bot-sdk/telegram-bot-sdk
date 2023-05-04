<?php

namespace Telegram\Bot\Objects;

use Countable;
use ArrayAccess;
use LogicException;
use Illuminate\Support\Collection;

class ResponseObject extends AbstractObject implements ArrayAccess, Countable
{
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

    public function getCustomData(): array
    {
        return $this->fields->get('custom_data', []);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Cannot modify an immutable object. Value cannot be set. Use addCustomData() instead to add extra data.');
    }

    public function count(): int
    {
        return $this->fields->count();
    }

    public function collect(): Collection
    {
        return $this->fields;
    }

    public function findType(array $types): ?string
    {
        return $this->collect()
            ->keys()
            ->intersect($types)
            ->pop();
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
}
