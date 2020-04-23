<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\User;

/**
 * @link https://core.telegram.org/bots/api#precheckoutquery
 *
 * @property string    $id                       Unique query identifier
 * @property User      $from                     User who sent the query.
 * @property string    $currency                 Three-letter ISO 4217 currency code
 * @property int       $total_amount             Total price in the smallest units of the currency (integer, not float/double)
 * @property string    $invoice_payload          Bot specified invoice payload
 * @property string    $shipping_option_id       (Optional). Identifier of the shipping option chosen by the user
 * @property OrderInfo $order_info               (Optional). Order info provided by the user
 */
class PreCheckoutQuery extends BaseObject
{
    public function relations(): array
    {
        return [
            'from'       => User::class,
            'order_info' => OrderInfo::class,
        ];
    }
}
