<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Objects\Update;

/**
 * Class Entity
 */
class Entity
{
    protected string $field;

    public static function from(Update $update): self
    {
        return new static($update);
    }

    public function __construct(protected Update $update)
    {
    }

    public function entities(): ?array
    {
        return $this->update->getMessage()->{$this->field()};
    }

    public function commandEntities(): Collection
    {
        return collect($this->entities())->filter(fn (MessageEntity $entity): bool => $entity->type === 'bot_command');
    }

    /**
     * Return the relevant text/string that the entities in the update are referencing.
     */
    public function text(): ?string
    {
        if ($this->field() === '' || $this->field() === '0') {
            return null;
        }

        if ($this->update->getMessage()->isType('text')) {
            return $this->update->getMessage()->text;
        }

        return $this->update->getMessage()->{Str::before($this->field(), '_')};
    }

    protected function field(): string
    {
        return $this->field ??= $this->update->getMessage()
            ->collect()
            ->keys()
            ->first(fn ($key): bool => Str::contains($key, 'entities'), '');
    }
}
