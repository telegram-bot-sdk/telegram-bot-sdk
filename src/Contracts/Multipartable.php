<?php

namespace Telegram\Bot\Contracts;

interface Multipartable
{
    /**
     * Convert the object to a multipart format array.
     *
     * @return array
     */
    public function toMultipart(): array;
}
