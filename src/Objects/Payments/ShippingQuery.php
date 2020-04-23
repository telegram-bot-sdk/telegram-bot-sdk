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
class ShippingQuery extends BaseObject
{
    public function relations(): array
    {
        return [
            'from'             => User::class,
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
