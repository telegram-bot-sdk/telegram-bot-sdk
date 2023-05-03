<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InputMediaAudio.
 *
 * Represents an audio file to be treated as music to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaaudio
 *
 * @method $this media(InputFile|string $inputFileOrString)      Required. File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name. More info on Sending Files »
 * @method $this thumbnail(InputFile|string $inputFileOrString)  (Optional). Thumbnail can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Thumbnails can't be reused and can be only uploaded as a new file.
 * @method $this caption(string $string)                         (Optional). Caption of the audio to be sent, 0-1024 characters after entities parsing
 * @method $this parseMode(string $string)                       (Optional). Mode for parsing entities in the audio caption
 * @method $this captionEntities(MessageEntity[] $messageEntity) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this duration(int $int)                              (Optional). Duration of the audio in seconds
 * @method $this performer(int $string)                          (Optional). Performer of the audio
 * @method $this title(string $string)                           (Optional). Title of the audio
 */
final class InputMediaAudio extends InputMedia
{
    protected string $type = 'audio';
}
