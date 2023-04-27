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
     * <code>
     * $params = [
     *       'chat_id'                   => '',  // int|string - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'                => '',  // int        - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'         => '',  // string     - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'text'                      => '',  // string     - Required. New text of the message.
     *       'parse_mode'                => '',  // string     - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
     *       'entities'                  => '',  // array      - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
     *       'disable_web_page_preview'  => '',  // bool       - (Optional). Disables link previews for links in this message
     *       'reply_markup'              => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     */
    public function editMessageText(array $params): ResponseObject|bool
    {
        return $this->post('editMessageText', $params)->getResult();
    }

    /**
     * Edit captions of messages sent by the bot or via the bot (for inline bots).
     * <code>
     * $params = [
     *       'chat_id'            => '',  // int|string - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'         => '',  // int        - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'  => '',  // string     - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'caption'            => '',  // string     - (Optional). New caption of the message
     *       'parse_mode'         => '',  // string     - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     *       'caption_entities'   => '',  // array      - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
     *       'reply_markup'       => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard.
     * ]
     * </code>
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
     * <code>
     * $params = [
     *       'chat_id'            => '',  // int|string - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'         => '',  // int        - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'  => '',  // string     - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'media'              => '',  // InputMedia - Required. A JSON-serialized object for a new media content of the message
     *       'reply_markup'       => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard.
     * ]
     * </code>
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
     * <code>
     * $params = [
     *       'chat_id'            => '',  // int|string - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'         => '',  // int        - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'  => '',  // string     - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'reply_markup'       => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard.
     * ]
     * </code>
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
     * <code>
     * $params = [
     *       'chat_id'       => '',  // int|string - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'    => '',  // int        - Required. Identifier of the original message with the poll
     *       'reply_markup'  => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard.
     * ]
     * </code>
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
     * <code>
     * $params = [
     *       'chat_id'     => '',  // int|string - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'  => '',  // int        - Required. Identifier of the message to delete.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletemessage
     */
    public function deleteMessage(array $params): bool
    {
        return $this->post('deleteMessage', $params)->getResult();
    }
}
