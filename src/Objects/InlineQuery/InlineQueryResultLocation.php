<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\InputContent\InputMessageContent;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;

/**
 * Class InlineQueryResultLocation.
 *
 * Represents a location on a map. By default, the location will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the location.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultlocation
 *
 * @method $this id(string $string) Required. Unique identifier for this result, 1-64 Bytes
 * @method $this latitude(float $float) Required. Location latitude in degrees
 * @method $this longitude(float $float) Required. Location longitude in degrees
 * @method $this title(string $string) Required. Location title
 * @method $this horizontalAccuracy(float $float) (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
 * @method $this livePeriod(int $int) (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 * @method $this heading(int $int) (Optional). For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
 * @method $this proximityAlertRadius(int $int) (Optional). For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
 * @method $this replyMarkup(InlineKeyboardMarkup $keyboardMarkup) (Optional). Inline keyboard attached to the message
 * @method $this inputMessageContent(InputMessageContent $inputMessageContent) (Optional). Content of the message to be sent instead of the photo
 * @method $this thumbnailUrl(string $string) (Optional). Url of the thumbnail for the result
 * @method $this thumbnailWidth(int $int) (Optional). Thumbnail width
 * @method $this thumbnailHeight(int $int) (Optional). Thumbnail height
 */
final class InlineQueryResultLocation extends InlineQueryResult
{
    protected string $type = 'location';
}
