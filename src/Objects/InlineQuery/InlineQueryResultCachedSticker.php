<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedSticker.
 *
 * Represents a link to a sticker stored on the Telegram servers. By default, this sticker will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the sticker.
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *   'sticker_file_id'        => '',  //  string                - Required. A valid file identifier of the sticker
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 *
 * @method $this id($string)                  Required. Unique identifier for this result, 1-64 Bytes
 * @method $this stickerFileId($string)       Required. A valid file identifier of the sticker
 * @method $this replyMarkup($object)         (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object) (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedSticker extends AbstractInlineObject
{
    protected string $type = 'sticker';
}
