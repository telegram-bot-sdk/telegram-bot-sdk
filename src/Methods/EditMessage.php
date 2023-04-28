<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class EditMessage.
 *
 * @mixin Http
 */
trait EditMessage
{
    /**
     * Edit text messages sent by the bot or via the bot (for inline bots).
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	text: string,
     * 	parse_mode: string,
     * 	entities: array,
     * 	disable_web_page_preview: bool,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     */
    public function editMessageText(array $params): ResponseObject|bool
    {
        return $this->post('editMessageText', $params)->getResult();
    }

    /**
     * Edit captions of messages sent by the bot or via the bot (for inline bots).
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	caption: string,
     * 	parse_mode: string,
     * 	caption_entities: array,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#editmessagecaption
     */
    public function editMessageCaption(array $params): ResponseObject|bool
    {
        return $this->post('editMessageCaption', $params)->getResult();
    }

    /**
     * Edit audio, document, photo, or video messages sent by the bot or via the bot.
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	media: InputMedia,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#editmessagemedia
     */
    public function editMessageMedia(array $params): ResponseObject|bool
    {
        return $this->post('editMessageMedia', $params)->getResult();
    }

    /**
     * Edit only the reply markup of messages sent by the bot or via the bot (for inline bots).
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	inline_message_id: string,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
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
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * 	reply_markup: string,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#stoppoll
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
     * @param array{
     * 	chat_id: int|string,
     * 	message_id: int,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#deletemessage
     */
    public function deleteMessage(array $params): bool
    {
        return $this->post('deleteMessage', $params)->getResult();
    }
}
