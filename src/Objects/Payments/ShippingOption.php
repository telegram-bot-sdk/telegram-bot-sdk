<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#shippingoption
 *
 * @property string         $id        Shipping option identifier.
 * @property string         $title     Option title.
 * @property LabeledPrice[] $prices    List of price portions.
 */
class ShippingOption extends AbstractResponseObject
{
    public function relations(): array
    {
        return [
            'prices' => LabeledPrice::class,
        ];
    }
}
