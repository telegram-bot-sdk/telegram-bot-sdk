<?php

namespace Telegram\Bot\Objects;

/**
 * Class Document.
 *
 * @link https://core.telegram.org/bots/api#document
 *
 * @property string    $file_id         Unique file identifier.
 * @property string    $file_unique_id  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property PhotoSize $thumb           (Optional). Document thumbnail as defined by sender.
 * @property string    $file_name       (Optional). Original filename as defined by sender.
 * @property string    $mime_type       (Optional). MIME type of the file as defined by sender.
 * @property int       $file_size       (Optional). File size.
 */
class Document
{
    public function relations(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
