<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultDocument.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Unique identifier for this result, 1-64 bytes
 *   'title'                  => '',  //  string                - Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the document to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'document_url'           => '',  //  string                - A valid URL for the file
 *   'mime_type'              => '',  //  string                - Mime type of the content of the file, either “application/pdf” or “application/zip”
 *   'description'            => '',  //  string                - (Optional). Short description of the result
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the file
 *   'thumb_url'              => '',  //  string                - (Optional). URL of the thumbnail (jpeg only) for the file
 *   'thumb_width'            => '',  //  int                   - (Optional). Thumbnail width
 *   'thumb_height'           => '',  //  int                   - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultdocument
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setTitle($string)                  Title for the result
 * @method $this setCaption($string)                (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this setParseMode($string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setDocumentUrl($string)            A valid URL for the file
 * @method $this setMimeType($string)               Mime type of the content of the file, either “application/pdf” or “application/zip”
 * @method $this setDescription($string)            (Optional). Short description of the result
 * @method $this setReplyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    (Optional). Content of the message to be sent instead of the file
 * @method $this setThumbUrl($string)               (Optional). URL of the thumbnail (jpeg only) for the file
 * @method $this setThumbWidth($int)                (Optional). Thumbnail width
 * @method $this setThumbHeight($int)               (Optional). Thumbnail height
 */
class InlineQueryResultDocument extends InlineBaseObject
{
    protected string $type = 'document';
}
