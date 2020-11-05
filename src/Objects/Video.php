<?php

namespace Telegram\Bot\Objects;

/**
 * Class Video.
 *
 * @link https://core.telegram.org/bots/api#video
 *
 * @property string    $file_id         Unique identifier for this file.
 * @property string    $file_unique_id  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int       $width           Video width as defined by sender.
 * @property int       $height          Video height as defined by sender.
 * @property int       $duration        Duration of the video in seconds as defined by sender.
 * @property PhotoSize $thumb           (Optional). Video thumbnail.
 * @property string    $file_name       (Optional). Original filename as defined by sender
 * @property string    $mime_type       (Optional). Mime type of a file as defined by sender.
 * @property int       $file_size       (Optional). File size.
 */
class Video extends AbstractResponseObject
{
    public function relations(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
