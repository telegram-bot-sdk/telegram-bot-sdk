<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultCachedSticker.
 *
 * Represents a link to a sticker stored on the Telegram servers. By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 *
 * @method $this id(string $string)                                             Required. Unique identifier for this result, 1-64 Bytes
 * @method $this stickerFileId(string $string)                                  Required. A valid file identifier of the sticker
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the sticker
 */
class InlineQueryResultCachedSticker extends InlineQueryResult
{
    protected string $type = 'sticker';
}
