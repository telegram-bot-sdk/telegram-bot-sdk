<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait Payments
{
    /**
     * Send invoices.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendinvoice
     *
     * @param array{
     * 	chat_id: int,
     *  message_thread_id: int,
     * 	title: string,
     * 	description: string,
     * 	payload: string,
     * 	provider_token: string,
     * 	currency: string,
     * 	prices: array<array{label: string, amount: int}>,
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
     *  allow_sending_without_reply: bool,
     * 	reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function sendInvoice(array $params): ResponseObject
    {
        return $this->post('sendInvoice', $params)->getResult();
    }

    /**
     * Create a link for an invoice
     *
     * Returns the created invoice link as String on success
     *
     * @link https://core.telegram.org/bots/api#createinvoicelink
     *
     * @param array{
     * 	title: string,
     * 	description: string,
     * 	payload: string,
     * 	provider_token: string,
     * 	currency: string,
     * 	prices: array<array{label: string, amount: int}>,
     * 	max_tip_amount: int,
     * 	suggested_tip_amounts: int[],
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
     * } $params
     */
    public function createInvoiceLink(array $params): string
    {
        return $this->post('createInvoiceLink', $params)->getResult();
    }

    /**
     * Reply to shipping queries.
     *
     * If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API will send an Update with a shipping_query field to the bot.
     *
     * On success, True is returned.
     *
     * @link https://core.telegram.org/bots/api#answershippingquery
     *
     * @param array{
     * 	shippingQueryId: string,
     * 	ok: bool,
     * 	shippingOptions: array<array{id: string, title:string, prices: array}>,
     * 	errorMessage: string,
     * } $params
     */
    public function answerShippingQuery(array $params): bool
    {
        return $this->post('answerShippingQuery', $params)->getResult();
    }

    /**
     * Reply to pre-checkout queries.
     *
     * Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation in the form of an Update with the field pre_checkout_query. Use this method to respond to such pre-checkout queries. On success, True is returned. Note: The Bot API must receive an answer within 10 seconds after the pre-checkout query was sent.
     *
     * @link https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @param array{
     * 	preCheckoutQueryId: string,
     * 	ok: bool,
     * 	errorMessage: string,
     * } $params
     */
    public function answerPreCheckoutQuery(array $params): bool
    {
        return $this->post('answerPreCheckoutQuery', $params)->getResult();
    }
}
