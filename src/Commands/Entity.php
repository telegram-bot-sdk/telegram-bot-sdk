<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Helpers\Update;
use Telegram\Bot\Objects\ResponseObject;

/**
 * Class Entity
 */
class Entity
{
    protected string $field;

    public static function from(ResponseObject $update): self
    {
        return new static($update);
    }

    public function __construct(protected ResponseObject $update)
    {
    }

    public function entities(): ?ResponseObject
    {
        return $this->message()->{$this->field()};
    }

    public function commandEntities(): Collection
    {
        return $this->entities()?->collect()->filter(fn ($entity): bool => $entity['type'] === 'bot_command');
    }

    /**
     * Return the relevant text/string that the entities in the update are referencing.
     */
    public function text(): ?string
    {
        if ($this->field() === '') {
            return null;
        }

        $message = $this->message();

        if ($message->offsetExists('text')) {
            return $message->offsetGet('text');
        }

        return $message->{Str::before($this->field(), '_')};
    }

    protected function field(): string
    {
        return $this->field ??= $this->message()
            ->collect()
            ->keys()
            ->first(fn ($key): bool => Str::contains($key, 'entities'), '');
    }

    protected function message(): ResponseObject
    {
        return Update::find($this->update)->message();
    }
}
