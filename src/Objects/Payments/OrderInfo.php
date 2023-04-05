<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#orderinfo
 *
 * @property string          $name                  (Optional). User name
 * @property string          $phone_number          (Optional). User's phone number
 * @property string          $email                 (Optional). User email
 * @property ShippingAddress $shipping_address      (Optional). User shipping address
 */
class OrderInfo extends AbstractResponseObject
{
    /**
     * @return array{shipping_address: class-string<\Telegram\Bot\Objects\Payments\ShippingAddress>}
     */
    public function relations(): array
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
