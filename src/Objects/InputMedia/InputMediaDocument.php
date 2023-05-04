<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InputMediaDocument.
 *
 * Represents a general file to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediadocument
 *
 * @method $this media(InputFile|string $inputFileOrString)       Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @method $this thumbnail(InputFile|string $inputFileOrString)   (Optional). Thumbnail can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file.
 * @method $this caption(string $string)                          (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this parseMode(string $string)                        (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $messageEntity)  (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this disableContentTypeDetection(bool $bool)          (Optional). Disables automatic server-side content type detection for files uploaded using multipart/form-data. Always true, if the document is sent as part of an album.
 */
final class InputMediaDocument extends InputMedia
{
    protected string $type = 'document';
}
