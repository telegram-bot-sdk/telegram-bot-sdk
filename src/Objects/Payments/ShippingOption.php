<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object represents one shipping option.
 *
 * @link https://core.telegram.org/bots/api#shippingoption
 *
 * @method $this id(string $string)                      Shipping option identifier
 * @method $this title(string $string)                   Option title
 * @method $this prices(LabeledPrice[] $labeledPrices)   List of price portions
 */
class ShippingOption extends AbstractCreateObject
{
}
