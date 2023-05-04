<?php

namespace Telegram\Bot\Objects\Stickers;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object describes the position on faces where a mask should be placed by default.
 *
 * @link https://core.telegram.org/bots/api#maskposition
 *
 * @method $this point(string $string)   The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”.
 * @method $this x_shift(float $float)   Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing -1.0 will place mask just to the left of the default mask position.
 * @method $this y_shift(float $float)   Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will place the mask just below the default mask position.
 * @method $this scale(float $float)     Mask scaling coefficient. For example, 2.0 means double size.
 */
final class MaskPosition extends AbstractCreateObject
{
}
