<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultVideo.
 *
 * Represents a link to a page containing an embedded video player or a video file. By default,
 * this video file will be sent by the user with an optional caption. Alternatively, you can
 * use input_message_content to send a message with the specified content instead of the video.
 *
 * If an InlineQueryResultVideo message contains an embedded video (e.g., YouTube), you must
 * replace its content using input_message_content.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvideo
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 bytes
 * @method $this videoUrl(string $string)                                      Required. A valid URL for the embedded video player or video file
 * @method $this mimeType(string $string)                                      Required. Mime type of the content of video url, “text/html” or “video/mp4”
 * @method $this thumbnailUrl(string $string)                                  Required. URL of the thumbnail (jpeg only) for the video
 * @method $this title(string $string)                                         Required. Title for the result
 * @method $this caption(string $string)                                       (Optional). Caption of the video to be sent, 0-200 characters
 * @method $this parseMode(string $string)                                     (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities)             (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this videoWidth(int $int)                                          (Optional). Video width
 * @method $this videoHeight(int $int)                                         (Optional). Video height
 * @method $this videoDuration(int $int)                                       (Optional). Video duration in seconds
 * @method $this description(string $string)                                   (Optional). Short description of the result
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the video. This field is required if InlineQueryResultVideo is used to send an HTML-page as a result (e.g., a YouTube video).
 */
final class InlineQueryResultVideo extends InlineQueryResult
{
    protected string $type = 'video';
}
