<?php

namespace Telegram\Bot\Objects\Payments;

/**
 * @link https://core.telegram.org/bots/api#orderinfo
 *
 * @property string          $name                  (Optional). User name
 * @property string          $phone_number          (Optional). User's phone number
 * @property string          $email                 (Optional). User email
 * @property ShippingAddress $shipping_address      (Optional). User shipping address
 */
class OrderInfo
{
    public function relations(): array
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
