<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultLocation.
 *
 * Represents a location on a map. By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the location.
 *
 * <code>
 * [
 *    'id'                    => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *    'latitude'              => '',  //  float                 - Required. Location latitude in degrees
 *    'longitude'             => '',  //  float                 - Required. Location longitude in degrees
 *    'title'                 => '',  //  string                - Required. Location title
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
 * @method $this id($string)                     Required. Unique identifier for this result, 1-64 Bytes
 * @method $this latitude($float)                Required. Location latitude in degrees
 * @method $this longitude($float)               Required. Location longitude in degrees
 * @method $this title($string)                  Required. Location title
 * @method $this replyMarkup($object)            (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent($object)    (Optional). Content of the message to be sent instead of the location
 * @method $this thumbUrl($string)               (Optional). Url of the thumbnail for the result
 * @method $this thumbWidth($int)                (Optional). Thumbnail width
 * @method $this thumbHeight($int)               (Optional). Thumbnail height
 */
class InlineQueryResultLocation extends InlineBaseObject
{
    protected static string $type = 'location';
}
