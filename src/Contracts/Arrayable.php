<?php

namespace Telegram\Bot\Contracts;

interface Arrayable
{
    /**
     * Get the instance as an array.
     */
    public function __toArray(): array;
}
