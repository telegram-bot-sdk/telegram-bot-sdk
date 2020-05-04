<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\BaseObject;
use Telegram\Bot\Objects\Payments\ShippingAddress;
use Telegram\Bot\Objects\User;

/**
 * Class ShippingQuery
 *
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
