<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * @link https://core.telegram.org/bots/api#credentials
 *
 * @property SecureData $secure_data   Credentials for encrypted data
 * @property string     $nonce         Bot-specified nonce
 */
class Credentials
{
    public function relations(): array
    {
        return [
            'secure_data' => SecureData::class,
        ];
    }
}
