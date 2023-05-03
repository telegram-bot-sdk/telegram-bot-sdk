<?php

namespace Telegram\Bot\Helpers;

use JsonException;
use Telegram\Bot\Exceptions\TelegramJsonException;

class Json
{
    public static function decode(string $json, int $options = 0): ?array
    {
        try {
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR | $options);
        } catch (JsonException $e) {
            throw new TelegramJsonException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function encode(mixed $value, int $options = 0): bool|string
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR | $options);
        } catch (JsonException $e) {
            throw new TelegramJsonException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
