<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Keyboard\ForceReply;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardMarkup;
use Telegram\Bot\Objects\Keyboard\ReplyKeyboardRemove;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Objects\Updates\Message as MessageObject;
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
     * Edit live location messages sent by the bot or via the bot.
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	latitude: float,
     * 	longitude: float,
     * 	heading: int,
     * 	proximity_alert_radius: int,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @throws TelegramSDKException
     */
    public function editMessageLiveLocation(array $params): MessageObject|bool
    {
        $response = $this->post('editMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Stop updating a live location message sent by the bot or via the bot.
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @throws TelegramSDKException
     */
    public function stopMessageLiveLocation(array $params): MessageObject|bool
    {
        $response = $this->post('stopMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }
}
