<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedDocument.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Unique identifier for this result, 1-64 bytes
 *   'title'                  => '',  //  string                - Title for the result
 *   'document_file_id'       => '',  //  string                - A valid file identifier for the file
 *   'description'            => '',  //  string                - (Optional). Short description of the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the document to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the file
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcacheddocument
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setTitle($string)                  Title for the result
 * @method $this setDocumentFileId($string)         A valid file identifier for the file
 * @method $this setDescription($string)            (Optional). Short description of the result
 * @method $this setCaption($string)                (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this setParseMode($string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    (Optional). Content of the message to be sent instead of the file
 */
class InlineQueryResultCachedDocument extends InlineBaseObject
{
    protected string $type = 'document';
}
