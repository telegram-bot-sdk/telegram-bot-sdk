<?php

namespace Telegram\Bot\Objects\Payments;

/**
 * @link https://core.telegram.org/bots/api#invoice
 *
 * @property string    $currency                             Three-letter ISO 4217 currency code
 * @property int       $total_amount                         Total price in the smallest units of the currency (integer, not float/double)
 * @property string    $invoice_payload                      Bot specified invoice payload
 * @property string    $shipping_option_id                   (Optional). Identifier of the shipping option chosen by the user.
 * @property OrderInfo $order_info                           (Optional). Order info provided by the user
 * @property string    $telegram_payment_charge_id           Telegram payment identifier.
 * @property string    $provider_payment_charge_id           Provider payment identifier.
 */
class SuccessfulPayment
{
}
