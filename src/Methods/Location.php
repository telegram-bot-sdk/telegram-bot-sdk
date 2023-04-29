<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Keyboard\ForceReply;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardRemove;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Location.
 *
 * @mixin Http
 */
trait Location
{
    /**
     * Send point on the map.
     *
     * On success, the sent Message is returned.
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param array{
     * 	chat_id: int|string,
     *  message_thread_id: int,
     * 	latitude: float,
     * 	longitude: float,
     *  horizontal_accuracy: float,
     * 	live_period: int,
     * 	heading: int,
     * 	proximity_alert_radius: int,
     * 	disable_notification: bool,
     * 	protect_content: bool,
     * 	reply_to_message_id: int,
     * 	allow_sending_without_reply: bool,
     *  reply_markup: InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply,
     * } $params
     */
    public function sendLocation(array $params): ResponseObject
    {
        return $this->post('sendLocation', $params)->getResult();
    }

    /**
     * Edit live location messages
     *
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to stopMessageLiveLocation. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	latitude: float,
     * 	longitude: float,
     * 	heading: int,
     * 	proximity_alert_radius: int,
     * 	reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function editMessageLiveLocation(array $params): ResponseObject|bool
    {
        return $this->post('editMessageLiveLocation', $params)->getResult();
    }

    /**
     * Stop updating a live location message before live_period expires
     *
     * On success, if the message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function stopMessageLiveLocation(array $params): ResponseObject|bool
    {
        return $this->post('stopMessageLiveLocation', $params)->getResult();
    }
}
