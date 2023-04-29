<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Trait Forum.
 *
 * @mixin Http
 */
trait Forum
{
    /**
     * Get custom emoji stickers
     *
     * can be used as a forum topic icon by any user. Requires no parameters. Returns an Array of Sticker objects
     *
     * @link https://core.telegram.org/bots/api#getforumtopiciconstickers
     *
     * @return ResponseObject[]
     */
    public function getForumTopicIconStickers(): array
    {
        return $this->get('getForumTopicIconStickers')->getResult();
    }

    /**
     * Create a topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns information about the created topic as a ForumTopic object.
     *
     * @link https://core.telegram.org/bots/api#createforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	name: string,
     * 	icon_color: int,
     * 	icon_custom_emoji_id: string,
     * } $params
     */
    public function createForumTopic(array $params): ResponseObject
    {
        return $this->post('createForumTopic', $params)->getResult();
    }

    /**
     * Edit name and icon of a topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#editforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_thread_id: int,
     *  name: string,
     * 	icon_custom_emoji_id: string,
     * } $params
     */
    public function editForumTopic(array $params): bool
    {
        return $this->post('editForumTopic', $params)->getResult();
    }

    /**
     * Close an open topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#closeforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_thread_id: int,
     * } $params
     */
    public function closeForumTopic(array $params): bool
    {
        return $this->post('closeForumTopic', $params)->getResult();
    }

    /**
     * Reopen a closed topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#reopenforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_thread_id: int,
     * } $params
     */
    public function reopenForumTopic(array $params): bool
    {
        return $this->post('reopenForumTopic', $params)->getResult();
    }

    /**
     * Delete a forum topic along with all its messages in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_delete_messages administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deleteforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_thread_id: int,
     * } $params
     */
    public function deleteForumTopic(array $params): bool
    {
        return $this->post('deleteForumTopic', $params)->getResult();
    }

    /**
     * Clear the list of pinned messages in a forum topic.
     *
     * The bot must be an administrator in the chat for this to work and must have the can_pin_messages administrator right in the supergroup. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinallforumtopicmessages
     *
     * @param array{
     * 	chat_id: int|string,
     * 	message_thread_id: int,
     * } $params
     */
    public function unpinAllForumTopicMessages(array $params): bool
    {
        return $this->post('unpinAllForumTopicMessages', $params)->getResult();
    }

    /**
     * Edit the name of the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#editgeneralforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * 	name: string,
     * } $params
     */
    public function editGeneralForumTopic(array $params): bool
    {
        return $this->post('editGeneralForumTopic', $params)->getResult();
    }

    /**
     * Close an open 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#closegeneralforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * } $params
     */
    public function closeGeneralForumTopic(array $params): bool
    {
        return $this->post('closeGeneralForumTopic', $params)->getResult();
    }

    /**
     * Reopen a closed 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. The topic will be automatically unhidden if it was hidden. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#reopengeneralforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * } $params
     */
    public function reopenGeneralForumTopic(array $params): bool
    {
        return $this->post('reopenGeneralForumTopic', $params)->getResult();
    }

    /**
     * Hide the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. The topic will be automatically closed if it was open. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#hidegeneralforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * } $params
     */
    public function hideGeneralForumTopic(array $params): bool
    {
        return $this->post('hideGeneralForumTopic', $params)->getResult();
    }

    /**
     * Unhide the 'General' topic in a forum supergroup chat
     *
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unhidegeneralforumtopic
     *
     * @param array{
     * 	chat_id: int|string,
     * } $params
     */
    public function unhideGeneralForumTopic(array $params): bool
    {
        return $this->post('unhideGeneralForumTopic', $params)->getResult();
    }
}
