<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultGif.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Unique identifier for this result, 1-64 bytes
 *   'gif_url'                => '',  //  string                - A valid URL for the GIF file. File size must not exceed 1MB
 *   'gif_width'              => '',  //  int                   - (Optional). Width of the GIF
 *   'gif_height'             => '',  //  int                   - (Optional). Height of the GIF
 *   'gif_duration'           => '',  //  int                   - (Optional). Duration of the GIF
 *   'thumb_url'              => '',  //  string                - URL of the static thumbnail for the result (jpeg or gif)
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the GIF file to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgif
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setGifUrl($string)                 A valid URL for the GIF file. File size must not exceed 1MB
 * @method $this setGifWidth($int)                  (Optional). Width of the GIF
 * @method $this setGifHeight($int)                 (Optional). Height of the GIF
 * @method $this setGifDuration($int)               (Optional). Duration of the GIF
 * @method $this setThumbUrl($string)               URL of the static thumbnail for the result (jpeg or gif)
 * @method $this setTitle($string)                  (Optional). Title for the result
 * @method $this setCaption($string)                (Optional). Caption of the GIF file to be sent, 0-200 characters
 * @method $this setParseMode($string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultGif extends InlineBaseObject
{
    protected string $type = 'gif';
}
