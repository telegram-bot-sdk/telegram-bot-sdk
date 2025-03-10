<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\InlineQuery\InlineQueryResult;
use Telegram\Bot\Objects\InlineQuery\InlineQueryResultsButton;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait InlineMode
{
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
     * 	results: InlineQueryResult[],
     * 	cache_time: int,
     * 	is_personal: bool,
     * 	next_offset: string,
     * 	button: InlineQueryResultsButton,
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
     *  @return ResponseObject{inline_message_id: string}
     */
    public function answerWebAppQuery(array $params): ResponseObject
    {
        return $this->post('answerWebAppQuery', $params)->getResult();
    }

    /**
     * Store a message that can be sent by a user of a Mini App.
     *
     * Returns a PreparedInlineMessage object on success.
     *
     * @link <Add the relevant Telegram API documentation link here>
     *
     * @param array{
     * 	user_id: int,
     * 	result: InlineQueryResult,
     * 	allow_user_chats: bool,
     * 	allow_bot_chats: bool,
     * 	allow_group_chats: bool,
     * 	allow_channel_chats: bool,
     * } $params
     * @return ResponseObject{prepared_message_id: string}
     */
    public function savePreparedInlineMessage(array $params): ResponseObject
    {
        return $this->post('savePreparedInlineMessage', $params)->getResult();
    }
}
