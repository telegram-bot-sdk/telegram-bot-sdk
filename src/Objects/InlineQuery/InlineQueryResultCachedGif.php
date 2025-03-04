<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultCachedGif.
 *
 * Represents a link to an animated GIF file stored on the Telegram servers. By default, this animated GIF file will
 * be sent by the user with an optional caption. Alternatively, you can use input_message_content to send a message
 * with specified content instead of the animation.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedgif
 *
 * @method $this id(string $string) Required. Unique identifier for this result, 1-64 bytes
 * @method $this gifFileId(string $string) Required. A valid file identifier for the GIF file
 * @method $this title(string $string) (Optional). Title for the result
 * @method $this caption(string $string) (Optional). Caption of the GIF file to be sent, 0-200 characters
 * @method $this parseMode($string) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup) (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the GIF animation
 */
final class InlineQueryResultCachedGif extends InlineQueryResult
{
    protected string $type = 'gif';
}
