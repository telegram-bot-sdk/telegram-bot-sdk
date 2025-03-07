<?php

namespace Telegram\Bot\Objects\Stickers;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object describes a sticker to be added to a sticker set.
 *
 * @link https://core.telegram.org/bots/api#inputsticker
 *
 * @method $this sticker(InputFile|string $inputFileOrString) The added sticker. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, upload a new one using multipart/form-data, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. Animated and video stickers can't be uploaded via HTTP URL
 * @method $this emojiList(string[] $emojiString) List of 1-20 emoji associated with the sticker
 * @method $this maskPosition(MaskPosition $mask) Optional. Position where the mask should be placed on faces. For “mask” stickers only.
 * @method $this keywords(string[] $strings) Optional. List of 0-20 search keywords for the sticker with total length of up to 64 characters. For “regular” and “custom_emoji” stickers only.
 */
final class InputSticker extends AbstractCreateObject {}
