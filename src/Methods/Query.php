<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Query.
 *
 * @mixin Http
 */
trait Query
{
    /**
     * Send answers to callback queries sent from inline keyboards
     *
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @param array{
     * 	callback_query_id: string,
     * 	text: string,
     * 	show_alert: bool,
     * 	url: string,
     * 	cache_time: int,
     * } $params
     */
    public function answerCallbackQuery(array $params): bool
    {
        return $this->post('answerCallbackQuery', $params)->getResult();
    }

    /**
     * Send answers to an inline query.
     *
     * On success, True is returned.
     * No more than 50 results per query are allowed.
     *
     * @link https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param array{
     * 	inline_query_id: string,
     * 	results: array,
     * 	cache_time: int,
     * 	is_personal: bool,
     * 	next_offset: string,
     * 	button: array,
     * } $params
     */
    public function answerInlineQuery(array $params): bool
    {
        return $this->post('answerInlineQuery', $params)->getResult();
    }

    /**
     * Set the result of an interaction with a Web App
     *
     * and send a corresponding message on behalf of the user to the chat from which the query originated. On success, a SentWebAppMessage object is returned.
     *
     * @link https://core.telegram.org/bots/api#answerwebappquery
     *
     * @param array{
     * 	web_app_query_id: string,
     * 	result: array,
     * } $params
     */
    public function answerWebAppQuery(array $params): ResponseObject
    {
        return $this->post('answerWebAppQuery', $params)->getResult();
    }
}
