<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#filecredentials
 *
 * @property string $file_hash     Checksum of encrypted file
 * @property string $secret        Secret of encrypted file
 */
class FileCredentials extends AbstractResponseObject
{
}
