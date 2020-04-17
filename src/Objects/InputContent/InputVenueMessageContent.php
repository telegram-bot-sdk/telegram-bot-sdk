<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputVenueMessageContent.
 *
 * <code>
 * [
 *   'latitude'          => '',  //  float   - Latitude of the location in degrees
 *   'longitude'         => '',  //  float   - Longitude of the location in degrees
 *   'title'             => '',  //  string  - Name of the venue
 *   'address'           => '',  //  string  - Address of the venue
 *   'foursquare_id'     => '',  //  string  - (Optional). Foursquare identifier of the venue, if known
 *   'foursquare_type'   => '',  //  string  - (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inputvenuemessagecontent
 *
 * @method $this setLatitude($float)             Latitude of the location in degrees
 * @method $this setLongitude($float)            Longitude of the location in degrees
 * @method $this setTitle($string)               Name of the venue
 * @method $this setAddress($string)             Address of the venue
 * @method $this setFoursquareIdTitle($string)   (Optional). Foursquare identifier of the venue, if known
 * @method $this setFoursquareType($string)      (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 */
class InputVenueMessageContent extends InlineBaseObject
{
}
