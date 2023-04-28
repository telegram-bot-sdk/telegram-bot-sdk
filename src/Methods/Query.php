<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\Http;

/**
 * Class Query.
 *
 * @mixin Http
 */
trait Query
{
    // TODO
    // Check these methods. They should possibly return the result of the query,
    // not just a hard coded bool value.
    /**
     * Send answers to callback queries sent from inline keyboards.
     *
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     *
     * @param array{
     * 	callback_query_id: string,
     * 	text: string,
     * 	show_alert: bool,
     * 	url: string,
     * 	cache_time: int,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @throws TelegramSDKException
     */
    public function answerCallbackQuery(array $params): bool
    {
        $this->post('answerCallbackQuery', $params);

        return true;
    }

    /**
     * Send answers to an inline query.
     *
     * No more than 50 results per query are allowed.
     *
     * @param array{
     * 	inline_query_id: string,
     * 	results: array,
     * 	cache_time: int,
     * 	is_personal: bool,
     * 	next_offset: string,
     * 	switch_pm_text: string,
     * 	switch_pm_parameter: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @throws TelegramSDKException
     */
    public function answerInlineQuery(array $params): bool
    {
        $this->post('answerInlineQuery', $params);

        return true;
    }
}
