<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Payments\OrderInfo;
use Telegram\Bot\Objects\User;

/**
 * Class PreCheckoutQuery
 *
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
class PreCheckoutQuery extends AbstractResponseObject
{
    /**
     * @return array{from: class-string<\Telegram\Bot\Objects\User>, order_info: class-string<\Telegram\Bot\Objects\Payments\OrderInfo>}
     */
    public function relations(): array
    {
        return [
            'from'       => User::class,
            'order_info' => OrderInfo::class,
        ];
    }

    public function objectType(): ?string
    {
        return $this->findType(['shipping_option_id', 'order_info']);
    }
}
