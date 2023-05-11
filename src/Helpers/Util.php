<?php

namespace Telegram\Bot\Helpers;

use Illuminate\Support\Str;

final class Util
{
    public static function secretToken(string $token): string
    {
        return Str::after($token, ':');
    }

    public static function isSecretTokenValid(string $token, string $secretToken): bool
    {
        return hash_equals(self::secretToken($token), $secretToken);
    }
}
