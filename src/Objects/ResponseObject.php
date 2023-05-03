<?php

namespace Telegram\Bot\Objects;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use IteratorAggregate;
use JsonSerializable;
use LogicException;
use Traversable;

class ResponseObject implements Arrayable, ArrayAccess, Countable, IteratorAggregate, Jsonable, JsonSerializable
{
    protected ?string $updateType = null;

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

    public function updateType(): ?string
    {
        if (!isset($this->fields['update_id'])) {
            return null;
        }

        return $this->updateType ??= $this->collect()
            ->except('update_id')
            ->keys()
            ->first();
    }

    public function getMessage()
    {
        return $this->{$this->updateType()};
    }

    /**
     * Determine the type by given types.
     */
    protected function findType(array $types): ?string
    {
        return $this->collect()
            ->keys()
            ->intersect($types)
            ->pop();
    }

    public function objectType(): ?string
    {
        $types = [
            'text',
            'audio',
            'document',
            'animation',
            'game',
            'photo',
            'sticker',
            'video',
            'voice',
            'video_note',
            'contact',
            'location',
            'venue',
            'poll',
            'dice',
            'new_chat_members',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
            'invoice',
            'successful_payment',
            'passport_data',
            'proximity_alert_triggered',
            'voice_chat_started',
            'voice_chat_ended',
            'voice_chat_participants_invited',
        ];

        return $this->findType($types);
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
