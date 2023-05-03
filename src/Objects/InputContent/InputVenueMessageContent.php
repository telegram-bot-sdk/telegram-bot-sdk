<?php

namespace Telegram\Bot\Objects\InputContent;

/**
 * Represents the content of a venue message to be sent as the result of an inline query.
 *
 * @link https://core.telegram.org/bots/api#inputvenuemessagecontent
 *
 * @method $this latitude(float $latitude)                Required. Latitude of the location in degrees
 * @method $this longitude(float $longitude)              Required. Longitude of the location in degrees
 * @method $this title(string $title)                     Required. Name of the venue
 * @method $this address(string $address)                 Required. Address of the venue
 * @method $this foursquareId(string $foursquareId)       (Optional). Foursquare identifier of the venue, if known
 * @method $this foursquareType(string $foursquareType)   (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @method $this googlePlaceId(string $googlePlaceId)     (Optional). Google Places identifier of the venue
 * @method $this googlePlaceType(string $googlePlaceType) (Optional). Google Places type of the venue.
 */
class InputVenueMessageContent extends InputMessageContent
{
}
