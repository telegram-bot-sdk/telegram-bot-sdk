<?php

namespace Telegram\Bot\Objects;

use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;
use Stringable;
use Telegram\Bot\Helpers\Json;
use Telegram\Bot\Contracts\Arrayable;
use Telegram\Bot\Contracts\Jsonable;

abstract class AbstractObject implements Arrayable, IteratorAggregate, Jsonable, JsonSerializable, Stringable
{
    public function __construct(protected array $fields = [])
    {
    }

    public static function make(array $fields = []): self
    {
        return new static($fields);
    }

    public function toArray(): array
    {
        return Json::decode($this->toJson());
    }

    public function toJson(int $options = 0): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): array|object
    {
        return $this->fields;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->fields);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
