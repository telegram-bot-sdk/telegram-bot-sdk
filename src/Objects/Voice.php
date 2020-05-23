<?php

namespace Telegram\Bot\Objects;

/**
 * Class Voice.
 *
 * @link https://core.telegram.org/bots/api#voice
 *
 * @property string $file_id         Unique identifier for this file.
 * @property string $file_unique_id  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int    $duration        Duration of the audio in seconds as defined by sender.
 * @property string $mime_type       (Optional). MIME type of the file as defined by sender.
 * @property int    $file_size       (Optional). File size.
 */
class Voice extends AbstractResponseObject
{
}
