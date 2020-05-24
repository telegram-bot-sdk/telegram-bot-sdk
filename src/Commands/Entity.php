<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Objects\Update;

class Entity
{
    protected string $field;
    protected Update $update;

    public static function from(Update $update): self
    {
        return new static($update);
    }

    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    public function entities(): ?array
    {
        return $this->update->getMessage()->{$this->field()};
    }

    public function commandEntities(): Collection
    {
        return collect($this->entities())->filter(fn (MessageEntity $entity) => $entity->type === 'bot_command');
    }

    /**
     * Return the relevant text/string that the entities in the update are referencing.
     *
     * @return string|null
     */
    public function text(): ?string
    {
        if (!$this->field()) {
            return null;
        }

        if ($this->field() === 'entities') {
            return $this->update->getMessage()->text;
        }

        return $this->update->getMessage()->{Str::before($this->field(), '_')};
    }

    protected function field(): ?string
    {
        return $this->field ??= $this->update->getMessage()
            ->collect()
            ->keys()
            ->first(fn ($key) => Str::contains($key, 'entities'));
    }
}
