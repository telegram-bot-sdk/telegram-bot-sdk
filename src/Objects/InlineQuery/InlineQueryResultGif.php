<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultGif.
 *
 * Represents a link to an animated GIF file. By default, this animated GIF file will be sent by the user with
 * optional caption. Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the animation.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgif
 *
 * @method $this id(string $string) Required. Unique identifier for this result, 1-64 bytes
 * @method $this gifUrl(string $string) Required. A valid URL for the GIF file. File size must not exceed 1MB
 * @method $this gifWidth(int $int) (Optional). Width of the GIF
 * @method $this gifHeight(int $int) (Optional). Height of the GIF
 * @method $this gifDuration(int $int) (Optional). Duration of the GIF
 * @method $this thumbnailUrl(string $string)                                  Required. URL of the static (JPEG or GIF) or animated (MPEG4) thumbnail for the result
 * @method $this thumbnail_mime_type(string $string) (Optional). MIME type of the thumbnail, must be one of “image/jpeg”, “image/gif”, or “video/mp4”. Defaults to “image/jpeg”
 * @method $this title(string $string) (Optional). Title for the result
 * @method $this caption(string $string) (Optional). Caption of the GIF file to be sent, 0-200 characters
 * @method $this parseMode(string $string) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup) (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the GIF animation
 */
final class InlineQueryResultGif extends InlineQueryResult
{
    protected string $type = 'gif';
}
