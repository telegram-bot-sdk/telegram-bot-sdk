<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#shippingoption
 *
 * @property string         $id        Shipping option identifier.
 * @property string         $title     Option title.
 * @property LabeledPrice[] $prices    List of price portions.
 */
class ShippingOption extends BaseObject
{
    public function relations(): array
    {
        return [
            'prices' => LabeledPrice::class,
        ];
    }
}
