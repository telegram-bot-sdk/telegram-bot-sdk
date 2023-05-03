<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * This object represents a portion of the price for goods or services.
 *
 * @link https://core.telegram.org/bots/api#labeledprice
 *
 * @method $this label(string $string)            Portion label
 * @method $this amount(int $int)                 Price of the product in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
 */
class LabeledPrice extends AbstractCreateObject
{
}