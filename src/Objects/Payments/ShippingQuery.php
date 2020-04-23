<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\User;

/**
 * @link https://core.telegram.org/bots/api#shippingquery
 *
 * @property string          $id                    Unique query identifier
 * @property User            $from                  User who sent the query.
 * @property string          $invoice_payload       Bot specified invoice payload
 * @property ShippingAddress $shipping_address      User specified shipping address
 */
class ShippingQuery
{
}
