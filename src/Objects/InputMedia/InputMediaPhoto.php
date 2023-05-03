<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InputMediaPhoto.
 *
 * Represents a photo to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaphoto
 *
 * @method $this media(string|InputFile $inputFileOrString)       Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @method $this caption(string $string)                          (Optional). Caption of the photo to be sent, 0-200 characters
 * @method $this parseMode(string $string)                        (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $messageEntity)  (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this hasSpoiler(bool $bool)                           (Optional). Pass True if the photo needs to be covered with a spoiler animation
 */
class InputMediaPhoto extends InputMedia
{
    protected string $type = 'photo';
}
