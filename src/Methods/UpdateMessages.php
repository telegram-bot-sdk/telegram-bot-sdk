<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\InputMedia\InputMedia;
use Telegram\Bot\Objects\Keyboard\InlineKeyboardMarkup;
use Telegram\Bot\Objects\Message\MessageEntity;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait UpdateMessages
{
    /**
     * Edit text and game messages.
     *
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	text: string,
     * 	parse_mode: string,
     * 	entities: MessageEntity[],
     * 	disable_web_page_preview: bool,
     *  reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function editMessageText(array $params): ResponseObject|bool
    {
        return $this->post('editMessageText', $params)->getResult();
    }

    /**
     * Edit captions of messages sent by the bot or via the bot (for inline bots).
     *
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	caption: string,
     * 	parse_mode: string,
     * 	caption_entities: MessageEntity[],
     *  reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function editMessageCaption(array $params): ResponseObject|bool
    {
        return $this->post('editMessageCaption', $params)->getResult();
    }

    /**
     * Edit animation, audio, document, photo, or video messages
     *
     * If a message is part of a message album, then it can be edited only to an audio for audio albums, only to a document for document albums and to a photo or a video otherwise. When an inline message is edited, a new file can't be uploaded; use a previously uploaded file via its file_id or specify a URL. On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagemedia
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	media: InputMedia,
     *  reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function editMessageMedia(array $params): ResponseObject|bool
    {
        return $this->post('editMessageMedia', $params)->getResult();
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

    /**
     * Edit only the reply markup of messages
     *
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	reply_markup: InlineKeyboardMarkup,
     * } $params
     */
    public function editMessageReplyMarkup(array $params): ResponseObject|bool
    {
        return $this->post('editMessageReplyMarkup', $params)->getResult();
    }

    /**
     * Stop Poll.
     *
     * Stop a poll which was sent by the bot. On success, the stopped Poll with the final results is returned.
     *
     * @link https://core.telegram.org/bots/api#stoppoll
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	reply_markup: InlineKeyboardMarkup,
     * } $params
     * @return ResponseObject{
     *     id: string,
     *     question: string,
     *     options: <array{text: string, voter_count: int}>,
     *     total_voter_count: int,
     *     is_closed: bool,
     *     is_anonymous: bool,
     *     type: string,
     *     allows_multiple_answers: bool,
     *     correct_option_id: int,
     *     explanation: string,
     *     explanation_entities: array,
     *     open_period: int,
     *     close_date: int
     * }
     */
    public function stopPoll(array $params): ResponseObject
    {
        return $this->post('stopPoll', $params)->getResult();
    }

    /**
     * Delete a message, including service messages, with the following limitations:.
     *
     * - A message can only be deleted if it was sent less than 48 hours ago.
     * - Bots can delete outgoing messages in private chats, groups, and supergroups.
     * - Bots can delete incoming messages in private chats.
     * - Bots granted can_post_messages permissions can delete outgoing messages in channels.
     * - If the bot is an administrator of a group, it can delete any message there.
     * - If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.
     *
     * @link https://core.telegram.org/bots/api#deletemessage
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * } $params
     */
    public function deleteMessage(array $params): bool
    {
        return $this->post('deleteMessage', $params)->getResult();
    }
}
