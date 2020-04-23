<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#datacredentials
 *
 * @property string $data_hash     Checksum of encrypted data
 * @property string $secret        Secret of encrypted data
 */
class DataCredentials extends BaseObject
{
}
