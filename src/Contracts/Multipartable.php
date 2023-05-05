<?php

namespace Telegram\Bot\Contracts;

interface Multipartable
{
    /**
     * Convert the object to a multipart format array.
     */
    public function __toMultipart(): array;
}
