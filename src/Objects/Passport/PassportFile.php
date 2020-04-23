<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * @link https://core.telegram.org/bots/api#passportfile
 *
 * @property string $file_id               Unique identifier for this file
 * @property string $file_unique_id        Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int    $file_size             File size
 * @property int    $file_date             Unix time when the file was uploaded
 */
class PassportFile
{
}
