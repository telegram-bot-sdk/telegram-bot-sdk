<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#orderinfo
 *
 * @property string          $name                 (Optional). User name
 * @property string          $phoneNumber          (Optional). User's phone number
 * @property string          $email                (Optional). User email
 * @property ShippingAddress $shippingAddress      (Optional). User shipping address
 */
class OrderInfo extends BaseObject
{
}
