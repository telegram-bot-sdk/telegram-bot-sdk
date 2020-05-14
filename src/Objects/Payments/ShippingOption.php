<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractObject;

/**
 * @link https://core.telegram.org/bots/api#shippingoption
 *
 * @property string         $id        Shipping option identifier.
 * @property string         $title     Option title.
 * @property LabeledPrice[] $prices    List of price portions.
 */
class ShippingOption extends AbstractObject
{
    public function relations(): array
    {
        return [
            'prices' => LabeledPrice::class,
        ];
    }
}
