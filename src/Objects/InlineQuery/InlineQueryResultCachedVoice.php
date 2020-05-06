<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedVoice.
 *
 * Represents a link to a voice message stored on the Telegram servers. By default, this voice message will be sent
 * by the user. Alternatively, you can use input_message_content to send a message with the specified content instead
 * of the voice message.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 bytes
 *   'voice_file_id'          => '',  //  string                - Required. A valid file identifier for the voice message
 *   'title'                  => '',  //  string                - Required. Voice message title
 *   'caption'                => '',  //  string                - (Optional). Caption, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedvoice
 *
 * @method $this id($string)                     Required. Unique identifier for this result, 1-64 bytes
 * @method $this voiceFileId($string)            Required. A valid file identifier for the voice message
 * @method $this title($string)                  Required. Voice message title
 * @method $this caption($string)                (Optional). Caption, 0-200 characters
 * @method $this parseMode($string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this replyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object)    (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedVoice extends InlineBaseObject
{
    protected string $type = 'voice';
}
