<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#credentials
 *
 * @property SecureData $secure_data   Credentials for encrypted data
 * @property string     $nonce         Bot-specified nonce
 */
class Credentials extends AbstractResponseObject
{
    public function relations(): array
    {
        return [
            'secure_data' => SecureData::class,
        ];
    }
}
