<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultLocation.
 *
 * <code>
 * [
 *    'id'                    => '',  //  string                - Unique identifier for this result, 1-64 Bytes
 *    'latitude'              => '',  //  float                 - Location latitude in degrees
 *    'longitude'             => '',  //  float                 - Location longitude in degrees
 *    'title'                 => '',  //  string                - Location title
 *    'reply_markup'          => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *    'input_message_content' => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the location
 *    'thumb_url'             => '',  //  string                - (Optional). Url of the thumbnail for the result
 *    'thumb_width'           => '',  //  int                   - (Optional). Thumbnail width
 *    'thumb_height'          => '',  //  int                   - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultlocation
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 Bytes
 * @method $this setLatitude($float)                Location latitude in degrees
 * @method $this setLongitude($float)               Location longitude in degrees
 * @method $this setTitle($string)                  Location title
 * @method $this setReplyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    (Optional). Content of the message to be sent instead of the location
 * @method $this setThumbUrl($string)               (Optional). Url of the thumbnail for the result
 * @method $this setThumbWidth($int)                (Optional). Thumbnail width
 * @method $this setThumbHeight($int)               (Optional). Thumbnail height
 */
class InlineQueryResultLocation extends InlineBaseObject
{
    protected string $type = 'location';
}
