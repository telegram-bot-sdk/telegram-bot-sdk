<?php

namespace Telegram\Bot\Objects;

/**
 * Class File.
 *
 * @link https://core.telegram.org/bots/api#file
 *
 * @property string $file_id         Unique identifier for this file.
 * @property string $file_unique_id  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int    $file_size       (Optional). File size, if known.
 * @property string $file_path       (Optional). File path. Use 'https://api.telegram.org/file/bot<token>/<file_path>' to get the file.
 */
class File extends AbstractObject
{
}
