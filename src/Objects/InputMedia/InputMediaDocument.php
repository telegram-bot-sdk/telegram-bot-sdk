<?php

namespace Telegram\Bot\Objects\InputMedia;

/**
 * Class InputMediaDocument.
 *
 * Represents a general file to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediadocument
 *
 * @method $this media($string)             Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @method $this thumb($inputFileOrString)  (Optional). Thumbnail can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file.
 * @method $this caption($string)           (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this parseMode($string)         (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 */
class InputMediaDocument extends InputMedia
{
    protected string $type = 'document';
}
