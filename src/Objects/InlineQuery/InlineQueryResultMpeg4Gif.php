<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultMpeg4Gif.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Unique identifier for this result, 1-64 bytes
 *   'mpeg4_url'              => '',  //  string                - A valid URL for the MP4 file. File size must not exceed 1MB
 *   'mpeg4_width'            => '',  //  int                   - (Optional). Video width
 *   'mpeg4_height'           => '',  //  int                   - (Optional). Video height
 *   'mpeg4_duration'         => '',  //  int                   - (Optional). Video duration
 *   'thumb_url'              => '',  //  string                - URL of the static thumbnail (jpeg or gif) for the result
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the MPEG-4 file to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 bytes
 * @method $this setMpeg4Url($string)            A valid URL for the MP4 file. File size must not exceed 1MB
 * @method $this setMpeg4Width($int)             (Optional). Video width
 * @method $this setMpeg4Height($int)            (Optional). Video height
 * @method $this setMpeg4Duration($int)          (Optional). Video duration
 * @method $this setThumbUrl($string)            URL of the static thumbnail (jpeg or gif) for the result
 * @method $this setTitle($string)               (Optional). Title for the result
 * @method $this setCaption($string)             (Optional). Caption of the MPEG-4 file to be sent, 0-200 characters
 * @method $this setParseMode($string)           (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)         (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultMpeg4Gif extends InlineBaseObject
{
    protected string $type = 'mpeg4_gif';
}
