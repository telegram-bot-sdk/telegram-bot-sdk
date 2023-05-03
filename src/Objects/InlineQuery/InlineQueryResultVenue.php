<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultVenue.
 *
 * Represents a venue. By default, the venue will be sent by the user. Alternatively, you can use
 * input_message_content to send a message with the specified content instead of the venue.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvenue
 *
 * @method $this id(string $string)                                            Required. Unique identifier for this result, 1-64 Bytes
 * @method $this latitude(float $float)                                        Required. Latitude of the venue location in degrees
 * @method $this longitude(float $float)                                       Required. Longitude of the venue location in degrees
 * @method $this title(string $string)                                         Required. Title of the venue
 * @method $this address(string $string)                                       Required. Address of the venue
 * @method $this foursquareId(string $string)                                  (Optional). Foursquare identifier of the venue if known
 * @method $this foursquareType(string $string)                                (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @method $this googlePlaceId(string $string)                                 (Optional). Google Places identifier of the venue
 * @method $this googlePlaceType(string $string)                               (Optional). Google Places type of the venue.
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup)             (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 * @method $this thumbnailUrl(string $string)                                  (Optional). Url of the thumbnail for the result
 * @method $this thumbnailWidth(int $int)                                      (Optional). Thumbnail width
 * @method $this thumbnailHeight(int $int)                                     (Optional). Thumbnail height
 */
class InlineQueryResultVenue extends InlineQueryResult
{
    protected string $type = 'venue';
}
