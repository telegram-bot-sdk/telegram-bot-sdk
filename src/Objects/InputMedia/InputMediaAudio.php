<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\FileUpload\InputFile;

/**
 * Class InputMediaAudio.
 *
 * Represents an audio file to be treated as music to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaaudio
 *
 * @method $this media($string)             Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More info on Sending Files »
 * @method $this thumb($inputFileOrString)  (Optional). Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>.
 * @method $this caption($string)           (Optional). Caption of the audio to be sent, 0-1024 characters after entities parsing
 * @method $this parseMode($string)         (Optional). Mode for parsing entities in the audio caption
 * @method $this duration($int)             (Optional). Duration of the audio in seconds
 * @method $this performer($string)         (Optional). Performer of the audio
 * @method $this title($string)             (Optional). Title of the audio
 */
class InputMediaAudio extends InputMedia
{
    protected string $type = 'audio';
}
