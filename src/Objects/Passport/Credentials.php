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
    /**
     * @return array{secure_data: class-string<\Telegram\Bot\Objects\Passport\SecureData>}
     */
    public function relations(): array
    {
        return [
            'secure_data' => SecureData::class,
        ];
    }
}
