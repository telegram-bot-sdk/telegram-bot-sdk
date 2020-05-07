<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputLocationMessageContent.
 *
 * Represents the content of a location message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'latitude'      => '',  //  float  - Required. Latitude of the location in degrees
 *   'longitude'     => '',  //  float  - Required. Longitude of the location in degrees
 *   'live_period'   => '',  //  int    - (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 * ]
 *
 * @link https://core.telegram.org/bots/api#inputlocationmessagecontent
 *
 * @method $this latitude($float)    Required. Latitude of the location in degrees
 * @method $this longitude($float)   Required. Longitude of the location in degrees
 * @method $this livePeriod($int)    (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 */
class InputLocationMessageContent extends InlineBaseObject
{
}
