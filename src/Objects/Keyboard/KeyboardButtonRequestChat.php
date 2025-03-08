<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;
use Telegram\Bot\Objects\Chat\ChatAdministratorRights;

/**
 * Defines the criteria used to request a suitable user. The identifier of the selected user will be shared with the bot when the corresponding button is pressed
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonrequestuser
 *
 * @method $this requestId(string $text) Signed 32-bit identifier of the request, which will be received back in the ChatShared object. Must be unique within the message
 * @method $this chatIsChannel(bool $bool) Pass True to request a channel chat, pass False to request a group or a supergroup chat.
 * @method $this chatIsForum(bool $bool) Optional. Pass True to request a forum supergroup, pass False to request a non-forum chat. If not specified, no additional restrictions are applied.
 * @method $this chatHasUsername(bool $bool) Optional. Pass True to request a supergroup or a channel with a username, pass False to request a chat without a username. If not specified, no additional restrictions are applied.
 * @method $this chatIsCreated(bool $bool) Optional. Pass True to request a chat owned by the user. Otherwise, no additional restrictions are applied.
 * @method $this userAdministratorRights(ChatAdministratorRights $chatAdminRights) Optional. A JSON-serialized object listing the required administrator rights of the user in the chat. The rights must be a superset of bot_administrator_rights. If not specified, no additional restrictions are applied.
 * @method $this botAdministratorRights(ChatAdministratorRights $chatAdminRights) Optional. A JSON-serialized object listing the required administrator rights of the bot in the chat. The rights must be a subset of user_administrator_rights. If not specified, no additional restrictions are applied.
 * @method $this botIsMember(bool $bool) Optional. Pass True to request a chat with the bot as a member. Otherwise, no additional restrictions are applied.
 */
final class KeyboardButtonRequestChat extends AbstractCreateObject {}
