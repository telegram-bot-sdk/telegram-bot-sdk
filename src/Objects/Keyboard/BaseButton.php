<?php

namespace Telegram\Bot\Objects\Keyboard;

use Illuminate\Support\Str;
use JsonSerializable;

abstract class BaseButton implements JsonSerializable
{
    protected $items;

    /**
     * Create a new object.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->items = $items;
    }

    abstract public static function text(string $text): self;

    /**
     * Dynamically build params.
     *
     * @param string $method
     * @param array  $args
     *
     * @return $this
     */
    public function __call($method, $args)
    {
        $property = Str::snake(substr($method, 3));
        $this->items[$property] = $args[0];

        return $this;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}
