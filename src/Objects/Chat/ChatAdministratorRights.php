<?php

namespace Telegram\Bot\Objects\Chat;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Represents the rights of an administrator in a chat.
 *
 * @link https://core.telegram.org/bots/api#chatadministratorrights
 *
 * @method $this isAnonymous(bool $bool) True, if the user's presence in the chat is hidden
 * @method $this canManageChat(bool $bool) True, if the administrator can access the chat event log, chat statistics, message statistics in channels, see channel members, see anonymous administrators in supergroups and ignore slow mode. Implied by any other administrator privilege
 * @method $this canDeleteMessages(bool $bool) True, if the administrator can delete messages of other users
 * @method $this canManageVideoChats(bool $bool) True, if the administrator can manage video chats
 * @method $this canRestrictMembers(bool $bool) True, if the administrator can restrict, ban or unban chat members
 * @method $this canPromoteMembers(bool $bool)     True, if the administrator can add new administrators with a subset of their own privileges or demote administrators that they have promoted, directly or indirectly (promoted by administrators that were appointed by the user)
 * @method $this canChangeInfo(bool $bool) True, if the user is allowed to change the chat title, photo and other settings
 * @method $this canInviteUsers(bool $bool) True, if the user is allowed to invite new users to the chat
 * @method $this canPostMessages(bool $bool) Optional. True, if the administrator can post in the channel; channels only
 * @method $this canEditMessages(bool $bool) Optional. True, if the administrator can edit messages of other users and can pin messages; channels only
 * @method $this canPinMessages(bool $bool) Optional. True, if the user is allowed to pin messages; groups and supergroups only
 * @method $this canManageTopics(bool $bool) Optional. True, if the user is allowed to create, rename, close, and reopen forum topics; supergroups only
 */
final class ChatAdministratorRights extends AbstractCreateObject {}
