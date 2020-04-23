<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatPhoto.
 *
 * @link https://core.telegram.org/bots/api#chatphoto
 *
 * @property string $small_file_id         Unique file identifier of small (160x160) chat photo. This file_id can be used only for photo download. This file_id can be used only for photo download and only for as long as the photo is not changed.
 * @property string $small_file_unique_id  Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property string $big_file_id           Unique file identifier of big (640x640) chat photo. This file_id can be used only for photo download. This file_id can be used only for photo download and only for as long as the photo is not changed.
 * @property string $big_file_unique_id    Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 */
class ChatPhoto
{
}
