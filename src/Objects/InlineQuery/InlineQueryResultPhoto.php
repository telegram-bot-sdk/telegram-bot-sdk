<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultPhoto.
 *
 * Represents a link to a photo. By default, this photo will be sent by the user with optional caption. Alternatively,
 * you can use input_message_content to send a message with the specified content instead of the photo.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *   'photo_url'              => '',  //  string                - Required. A valid URL of the photo. Photo must be in jpeg format. Photo size must not exceed 5MB
 *   'thumb_url'              => '',  //  string                - Required. URL of the thumbnail for the photo
 *   'photo_width'            => '',  //  int                   - (Optional). Width of the photo
 *   'photo_height'           => '',  //  int                   - (Optional). Height of the photo
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'description'            => '',  //  string                - (Optional). Short description of the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the photo to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultphoto
 *
 * @method $this id($string)                  Required. Unique identifier for this result, 1-64 Bytes
 * @method $this photoUrl($string)            Required. A valid URL of the photo. Photo must be in jpeg format. Photo size must not exceed 5MB
 * @method $this thumbUrl($string)            Required. URL of the thumbnail for the photo
 * @method $this photoWidth($int)             (Optional). Width of the photo
 * @method $this photoHeight($int)            (Optional). Height of the photo
 * @method $this title($string)               (Optional). Title for the result
 * @method $this description($string)         (Optional). Short description of the result
 * @method $this caption($string)             (Optional). Caption of the photo to be sent, 0-200 characters
 * @method $this parseMode($string)           (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this replyMarkup($object)         (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object) (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultPhoto extends InlineBaseObject
{
    protected string $type = 'photo';
}
