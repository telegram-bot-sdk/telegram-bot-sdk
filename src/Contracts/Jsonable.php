<?php

namespace Telegram\Bot\Contracts;

interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     */
    public function __toJson(int $options = 0): string;
}
