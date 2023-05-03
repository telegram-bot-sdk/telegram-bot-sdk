<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultMpeg4Gif.
 *
 * Represents a link to a video animation (H.264/MPEG-4 AVC video without sound). By default, this animated MPEG-4
 * file will be sent by the user with optional caption. Alternatively, you can use input_message_content to send a
 * message with the specified content instead of the animation.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 bytes
 * @method $this mpeg4Url(string $string)                                      Required. A valid URL for the MP4 file. File size must not exceed 1MB
 * @method $this mpeg4Width(int $int)                                          (Optional). Video width
 * @method $this mpeg4Height(int $int)                                         (Optional). Video height
 * @method $this mpeg4Duration(int $int)                                       (Optional). Video duration
 * @method $this thumbnailUrl(string $string)                                  Required. URL of the static (JPEG or GIF) or animated (MPEG4) thumbnail for the result
 * @method $this thumbnailMimeType(string $string)                             (Optional). MIME type of the thumbnail, must be one of “image/jpeg”, “image/gif”, or “video/mp4”. Defaults to “image/jpeg”
 * @method $this title(string $string)                                         (Optional). Title for the result
 * @method $this caption(string $string)                                       (Optional). Caption of the MPEG-4 file to be sent, 0-200 characters
 * @method $this parseMode(string $string)                                     (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities)             (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the video animation
 */
final class InlineQueryResultMpeg4Gif extends InlineQueryResult
{
    protected string $type = 'mpeg4_gif';
}
