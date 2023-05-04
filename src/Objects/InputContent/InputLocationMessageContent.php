<?php

namespace Telegram\Bot\Objects\InputContent;

/**
 * Represents the content of a location message to be sent as the result of an inline query.
 *
 * @link https://core.telegram.org/bots/api#inputlocationmessagecontent
 *
 * @method $this latitude(float $latitude)          Required. Latitude of the location in degrees
 * @method $this longitude(float $longitude)        Required. Longitude of the location in degrees
 * @method $this horizontalAccuracy(float $float)   (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
 * @method $this livePeriod(int $int)               (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 * @method $this heading(int $int)                  (Optional). For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
 * @method $this proximityAlertRadius(int $int)     (Optional). For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
 */
final class InputLocationMessageContent extends InputMessageContent
{
}
