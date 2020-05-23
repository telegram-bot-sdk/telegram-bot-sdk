<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#residentialaddress
 *
 * @property string $street_line_1    First line for the address
 * @property string $street_line_2    (Optional). Second line for the address
 * @property string $city             City
 * @property string $state            (Optional). State
 * @property string $country_code     ISO 3166-1 alpha-2 country code
 * @property string $post_code        Address post code
 */
class ResidentialAddress extends AbstractResponseObject
{
}
