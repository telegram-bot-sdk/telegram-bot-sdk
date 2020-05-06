<?php

namespace Telegram\Bot\Objects\InputMedia;

/**
 * Class InputMediaVideo.
 *
 * Represents a video to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediavideo
 *
 * @method $this media($string)             Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @method $this thumb($inputFileOrString)  (Optional). Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
 * @method $this caption($string)           (Optional). Caption of the video to be sent, 0-200 characters
 * @method $this parseMode($string)         (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this width($int)                (Optional). Video width
 * @method $this height($int)               (Optional). Video height
 * @method $this duration($int)             (Optional). Video duration
 * @method $this supportsStreaming($bool)   (Optional). Pass True, if the uploaded video is suitable for streaming
 */
class InputMediaVideo extends InputMedia
{
    protected static string $type = 'video';
}
