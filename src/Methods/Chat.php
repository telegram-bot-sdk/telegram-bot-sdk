<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Chat.
 *
 * @mixin Http
 */
trait Chat
{
    /**
     * Ban a user in a group, a supergroup or a channel
     *
     * In the case of supergroups, the user will not be able to return to the group on their own using
     * invite links etc., unless unbanned first.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#banchatmember
     *
     * @param array{
     * 	chat_id: int|string,
     * 	user_id: int,
     * 	until_date: int,
     * 	revoke_messages: bool,
     * } $params
     */
    public function banChatMember(array $params): bool
    {
        return $this->get('banChatMember', $params)->getResult();
    }

    /**
     * Unban a previously kicked user in a supergroup.
     *
     * The user will not return to the group automatically, but will be able to join via link, etc.
     *
     * The bot must be an administrator in the group for this to work. By default, this method guarantees that after the call the user is not a member of the chat, but will be able to join it. So if the user is a member of the chat they will also be removed from the chat. If you don't want this, use the parameter only_if_banned. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param array{
     * 	chat_id: int|string,
     * 	user_id: int,
     * 	only_if_banned: bool,
     * } $params
     */
    public function unbanChatMember(array $params): bool
    {
        return $this->get('unbanChatMember', $params)->getResult();
    }

    /**
     * Restrict a user in a supergroup.
     *
     * Pass True for all boolean parameters to lift restrictions from a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array{
     * 	chat_id: int|string,
     * 	user_id: int,
     *  permissions: array{
     *    can_send_messages: bool,
     *    can_send_audios: bool,
     *    can_send_documents: bool,
     *    can_send_photos: bool,
     *    can_send_videos: bool,
     *    can_send_video_notes: bool,
     *    can_send_voice_notes: bool,
     *    can_send_polls: bool,
     *    can_send_other_messages: bool,
     *    can_add_web_page_previews: bool,
     *    can_change_info: bool,
     *    can_invite_users: bool,
     *    can_pin_messages: bool,
     *    can_manage_topics: bool,
     *     },
     *  use_independent_chat_permissions: bool,
     * 	until_date: int,
     * } $params
     */
    public function restrictChatMember(array $params): bool
    {
        return $this->post('restrictChatMember', $params)->getResult();
    }

    /**
     * Promote or demote a user in a supergroup or a channel.
     *
     * Pass False for all boolean parameters to demote a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array{
     * 	chat_id: int|string,
     * 	user_id: int,
     * 	is_anonymous: bool,
     * 	can_manage_chat: bool,
     * 	can_post_messages: bool,
     * 	can_edit_messages: bool,
     * 	can_delete_messages: bool,
     * 	can_manage_voice_chats: bool,
     * 	can_restrict_members: bool,
     * 	can_promote_members: bool,
     *  can_change_info: bool,
     * 	can_invite_users: bool,
     * 	can_pin_messages: bool,
     *  can_manage_topics: bool,
     * } $params
     */
    public function promoteChatMember(array $params): bool
    {
        return $this->post('promoteChatMember', $params)->getResult();
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param array{
     * 	chat_id: int|string,
     * 	user_id: int,
     * 	custom_title: string,
     * } $params
     */
    public function setChatAdministratorCustomTitle(array $params): bool
    {
        return $this->post('setChatAdministratorCustomTitle', $params)->getResult();
    }

    /**
     * Ban a channel chat in a supergroup or a channel. Until the chat is unbanned, the owner of the banned chat
     * won't be able to send messages on behalf of any of their channels.
     *
     * The bot must be an administrator in the supergroup or channel for this to work and must have the appropriate administrator rights.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#banchatsenderchat
     *
     * @param array{
     * 	chat_id: int|string,
     * 	sender_chat_id: int,
     * } $params
     */
    public function banChatSenderChat(array $params): bool
    {
        return $this->post('banChatSenderChat', $params)->getResult();
    }

    /**
     * Unban a previously banned channel chat in a supergroup or channel.
     *
     * The bot must be an administrator for this to work
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unbanchatsenderchat
     *
     * @param array{
     * 	chat_id: int|string,
     * 	sender_chat_id: int,
     * } $params
     */
    public function unbanChatSenderChat(array $params): bool
    {
        return $this->post('unbanChatSenderChat', $params)->getResult();
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and
     * must have the can_restrict_members admin rights.
     *
     * @link https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param array{
     * 	chat_id: int|string,
     * 	permissions: array{
     *    can_send_messages: bool,
     *    can_send_audios: bool,
     *    can_send_documents: bool,
     *    can_send_photos: bool,
     *    can_send_videos: bool,
     *    can_send_video_notes: bool,
     *    can_send_voice_notes: bool,
     *    can_send_polls: bool,
     *    can_send_other_messages: bool,
     *    can_add_web_page_previews: bool,
     *    can_change_info: bool,
     *    can_invite_users: bool,
     *    can_pin_messages: bool,
     *    can_manage_topics: bool,
     *     },
     *   use_independent_chat_permissions: bool,
     * } $params
     */
    public function setChatPermissions(array $params): bool
    {
        return $this->post('setChatPermissions', $params)->getResult();
    }

    /**
     * Generate a new primary invite link for a chat
     *
     * Any previously generated primary link is revoked. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns the new invite link as String on success.
     *
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function exportChatInviteLink(array $params): string
    {
        return $this->post('exportChatInviteLink', $params)->getResult();
    }

    /**
     * Create an additional invite link for a chat
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. The link can be revoked using the method revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
     *
     * @link https://core.telegram.org/bots/api#createchatinvitelink
     *
     * @param array{
     * 	chat_id: string|int,
     * 	name: string,
     * 	expire_date: int,
     * 	member_limit: int,
     * 	creates_join_request: bool,
     * } $params
     */
    public function createChatInviteLink(array $params): ResponseObject
    {
        return $this->post('createChatInviteLink', $params)->getResult();
    }

    /**
     * Edit a non-primary invite link created by the bot.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns the edited invite link as a ChatInviteLink object.
     *
     * @link https://core.telegram.org/bots/api#editchatinvitelink
     *
     * @param array{
     * 	chat_id: string|int,
     * 	invite_link: string,
     * 	name: string,
     * 	expire_date: int,
     * 	member_limit: int,
     * 	creates_join_request: bool,
     * } $params
     */
    public function editChatInviteLink(array $params): ResponseObject
    {
        return $this->post('editChatInviteLink', $params)->getResult();
    }

    /**
     * Revoke an invite link created by the bot.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * @link https://core.telegram.org/bots/api#revokechatinvitelink
     *
     * @param array{
     * 	chat_id: string|int,
     * 	invite_link: string,
     * } $params
     */
    public function revokeChatInviteLink(array $params): ResponseObject
    {
        return $this->post('revokeChatInviteLink', $params)->getResult();
    }

    /**
     * Approve a chat join request
     *
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#approvechatjoinrequest
     *
     * @param array{
     * 	chat_id: string|int,
     * 	user_id: int,
     * } $params
     */
    public function approveChatJoinRequest(array $params): bool
    {
        return $this->post('approveChatJoinRequest', $params)->getResult();
    }

    /**
     * Decline a chat join request
     *
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#declinechatjoinrequest
     *
     * @param array{
     * 	chat_id: string|int,
     * 	user_id: int,
     * } $params
     */
    public function declineChatJoinRequest(array $params): bool
    {
        return $this->post('declineChatJoinRequest', $params)->getResult();
    }

    /**
     * Set a new profile photo for the chat.
     *
     * Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatphoto
     *
     * @param array{
     * 	chat_id: string|int,
     * 	photo: InputFile,
     * } $params
     */
    public function setChatPhoto(array $params): bool
    {
        return $this->uploadFile('setChatPhoto', $params)->getResult();
    }

    /**
     * Delete a chat photo.
     *
     * Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function deleteChatPhoto(array $params): bool
    {
        return $this->post('deleteChatPhoto', $params)->getResult();
    }

    /**
     * Set the title of a chat.
     *
     * Titles can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchattitle
     *
     * @param array{
     * 	chat_id: string|int,
     * 	title: string,
     * } $params
     */
    public function setChatTitle(array $params): bool
    {
        return $this->post('setChatTitle', $params)->getResult();
    }

    /**
     * Set the description of a supergroup or a channel.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @param array{
     * 	chat_id: string|int,
     * 	description: string,
     * } $params
     */
    public function setChatDescription(array $params): bool
    {
        return $this->post('setChatDescription', $params)->getResult();
    }

    /**
     * Pin a message in a group, a supergroup, or a channel.
     *
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param array{
     * 	chat_id: string|int,
     * 	message_id: int,
     * 	disable_notification: bool,
     * } $params
     */
    public function pinChatMessage(array $params): bool
    {
        return $this->post('pinChatMessage', $params)->getResult();
    }

    /**
     * Unpin a message in a group, a supergroup, or a channel.
     *
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param array{
     * 	chat_id: string|int,
     * 	message_id: int,
     * } $params
     */
    public function unpinChatMessage(array $params): bool
    {
        return $this->post('unpinChatMessage', $params)->getResult();
    }

    /**
     * Unpin/clear the list of pinned messages in a chat.
     *
     * f the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#unpinallchatmessages
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function unpinAllChatMessages(array $params): bool
    {
        return $this->post('unpinAllChatMessages', $params)->getResult();
    }

    /**
     * To leave a group, supergroup or channel.
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#leavechat
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function leaveChat(array $params): bool
    {
        return $this->get('leaveChat', $params)->getResult();
    }

    /**
     * Get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel, etc.).
     *
     * @link https://core.telegram.org/bots/api#getchat
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function getChat(array $params): ResponseObject
    {
        return $this->get('getChat', $params)->getResult();
    }

    /**
     * Get a list of administrators in a chat.
     *
     * @link https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     * @return ResponseObject[]
     */
    public function getChatAdministrators(array $params): array
    {
        return $this->get('getChatAdministrators', $params)->getResult();
    }

    /**
     * Get the number of members in a chat.
     *
     * @link https://core.telegram.org/bots/api#getchatmembercount
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function getChatMemberCount(array $params): int
    {
        return $this->get('getChatMemberCount', $params)->getResult();
    }

    /**
     * Get information about a member of a chat.
     *
     * The method is only guaranteed to work for other users if the bot is an administrator in the chat. Returns a ChatMember object on success.
     *
     * @link https://core.telegram.org/bots/api#getchatmember
     *
     * @param array{
     * 	chat_id: string|int,
     * 	user_id: int,
     * } $params
     */
    public function getChatMember(array $params)
    {
        return $this->get('getChatMember', $params)->getResult();
    }

    /**
     * Set a new group sticker set for a supergroup.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param array{
     * 	chat_id: string|int,
     * 	sticker_set_name: string,
     * } $params
     */
    public function setChatStickerSet(array $params): bool
    {
        return $this->post('setChatStickerSet', $params)->getResult();
    }

    /**
     * Delete a group sticker set from a supergroup.
     *
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success
     *
     * @link https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param array{
     * 	chat_id: string|int,
     * } $params
     */
    public function deleteChatStickerSet(array $params): bool
    {
        return $this->post('deleteChatStickerSet', $params)->getResult();
    }

    /**
     * Change the bot's menu button in a private chat
     *
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setchatmenubutton
     *
     * @param array{
     * 	chat_id: int,
     *  menu_button: array
     * } $params
     */
    public function setChatMenuButton(array $params): bool
    {
        return $this->post('setChatMenuButton', $params)->getResult();
    }

    /**
     * Get the current value of the bot's menu button in a private chat, or the default menu button
     *
     * Returns MenuButton on success.
     *
     * @link https://core.telegram.org/bots/api#getchatmenubutton
     *
     * @param array{
     * 	chat_id: int,
     * } $params
     */
    public function getChatMenuButton(array $params): bool
    {
        return $this->post('getChatMenuButton', $params)->getResult();
    }
}
