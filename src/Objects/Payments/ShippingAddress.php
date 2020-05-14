<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractObject;

/**
 * @link https://core.telegram.org/bots/api#shippingaddress
 *
 * @property string $country_code                    ISO 3166-1 alpha-2 country code
 * @property string $state                           State, if applicable
 * @property string $city                            City
 * @property string $street_line_1                   First line for the address.
 * @property string $street_line_2                   Second line for the address.
 * @property string $post_code                       Address post code
 */
class ShippingAddress extends AbstractObject
{
}
