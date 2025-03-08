<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultCachedPhoto.
 *
 * Represents a link to a photo stored on the Telegram servers. By default, this photo will be sent by the user with
 * an optional caption. Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the photo.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedphoto
 *
 * @method $this id(string $string) Required. Unique identifier for this result, 1-64 Bytes
 * @method $this photoFileId(string $string) Required. A valid file identifier of the photo
 * @method $this title(string $string) (Optional). Title for the result
 * @method $this description(string $string) (Optional). Short description of the result
 * @method $this caption(string $string) (Optional). Caption of the photo to be sent, 0-200 characters
 * @method $this parseMode(string $string) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities) (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup) (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 */
final class InlineQueryResultCachedPhoto extends InlineQueryResult
{
    protected string $type = 'photo';
}
