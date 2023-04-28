<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Updates\Message;
use Telegram\Bot\Traits\Http;

/**
 * Trait Payments.
 *
 * @mixin Http
 */
trait Payments
{
    /**
     * Send invoices.
     *
     * @param array{
     * 	chat_id: int,
     * 	title: string,
     * 	description: string,
     * 	payload: string,
     * 	provider_token: string,
     * 	currency: string,
     * 	prices: LabeledPrice[],
     * 	max_tip_amount: int,
     * 	suggested_tip_amounts: int[],
     * 	start_parameter: string,
     * 	provider_data: string,
     * 	photo_url: string,
     * 	photo_size: int,
     * 	photo_width: int,
     * 	photo_height: int,
     * 	need_name: bool,
     * 	need_phone_number: bool,
     * 	need_email: bool,
     * 	need_shipping_address: bool,
     * 	send_phone_number_to_provider: bool,
     * 	send_email_to_provider: bool,
     * 	is_flexible: bool,
     * 	disable_notification: bool,
     * 	protect_content: bool,
     * 	reply_to_message_id: int,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#sendinvoice
     *
     * @throws TelegramSDKException
     */
    public function sendInvoice(array $params): Message
    {
        $response = $this->post('sendInvoice', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Reply to shipping queries.
     *
     * @param array{
     * 	shippingQueryId: string,
     * 	ok: bool,
     * 	shippingOptions: ShippingOption[],
     * 	errorMessage: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#answershippingquery
     *
     * @throws TelegramSDKException
     */
    public function answerShippingQuery(array $params): bool
    {
        return $this->post('answerShippingQuery', $params)->getResult();
    }

    /**
     * Reply to pre-checkout queries.
     *
     * @param array{
     * 	preCheckoutQueryId: string,
     * 	ok: bool,
     * 	errorMessage: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @throws TelegramSDKException
     */
    public function answerPreCheckoutQuery(array $params): bool
    {
        return $this->post('answerPreCheckoutQuery', $params)->getResult();
    }
}
