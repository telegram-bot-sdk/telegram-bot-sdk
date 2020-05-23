<?php

namespace Telegram\Bot\Objects;

/**
 * Class Sticker.
 *
 * @link https://core.telegram.org/bots/api#sticker
 *
 * @property string       $file_id         Unique identifier for this file.
 * @property string       $file_unique_id  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int          $width           Sticker width.
 * @property int          $height          Sticker height.
 * @property bool         $is_animated     True, if the sticker is animated.
 * @property PhotoSize    $thumb           (Optional). Sticker thumbnail in .webp or .jpg format.
 * @property string       $emoji           (Optional). Emoji associated with the sticker
 * @property string       $set_name        (Optional). Name of the sticker set to which the sticker belongs
 * @property MaskPosition $mask_position   (Optional). For mask stickers, the position where the mask should be placed
 * @property int          $file_size       (Optional). File size.
 */
class Sticker extends AbstractResponseObject
{
    public function relations(): array
    {
        return [
            'thumb'         => PhotoSize::class,
            'mask_position' => MaskPosition::class,
        ];
    }
}
