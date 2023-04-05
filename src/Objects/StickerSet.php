<?php

namespace Telegram\Bot\Objects;

/**
 * Class StickerSet.
 *
 * @link https://core.telegram.org/bots/api#stickerset
 *
 * @property string    $name            Sticker set name
 * @property string    $title           Sticker set title
 * @property bool      $is_animated     True, if the sticker set contains animated stickers
 * @property bool      $contains_masks  True, if the sticker set contains masks
 * @property Sticker[] $stickers        List of all set stickers
 * @property PhotoSize $thumb           (Optional). Sticker set thumbnail in the .WEBP or .TGS format
 */
class StickerSet extends AbstractResponseObject
{
    /**
     * @return array{stickers: class-string<\Telegram\Bot\Objects\Sticker>, thumb: class-string<\Telegram\Bot\Objects\PhotoSize>}
     */
    public function relations(): array
    {
        return [
            'stickers' => Sticker::class,
            'thumb'    => PhotoSize::class,
        ];
    }
}
