<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;

/**
 * Class InlineQueryResultDocument.
 *
 * Represents a link to a file. By default, this file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the file.
 * Currently, only .PDF and .ZIP files can be sent using this method.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultdocument
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 bytes
 * @method $this title(string $string)                                         Required. Title for the result
 * @method $this caption(string $string)                                       (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this parseMode(string $string)                                     (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this captionEntities(MessageEntity[] $captionEntities)             (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this documentUrl(string $string)                                   Required. A valid URL for the file
 * @method $this mimeType(string $string)                                      Required. Mime type of the content of the file, either “application/pdf” or “application/zip”
 * @method $this description(string $string)                                   (Optional). Short description of the result
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 * @method $this thumbnailUrl(string $string)                                  (Optional). URL of the thumbnail (jpeg only) for the file
 * @method $this thumbnailWidth(int $int)                                      (Optional). Thumbnail width
 * @method $this thumbnailHeight(int $int)                                     (Optional). Thumbnail height
 */
final class InlineQueryResultDocument extends InlineQueryResult
{
    protected string $type = 'document';
}
