<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Defines the criteria used to request a suitable user. The identifier of the selected user will be shared with the bot when the corresponding button is pressed
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonrequestuser
 *
 * @method self requestId(string $text) Signed 32-bit identifier of the request, which will be received back in the UserShared object. Must be unique within the message
 * @method self userIsBot(bool $bool) Optional. Pass True to request a bot, pass False to request a regular user. If not specified, no additional restrictions are applied.
 * @method self userIsPremium(bool $bool) Optional. Pass True to request a premium user, pass False to request a non-premium user. If not specified, no additional restrictions are applied.
 */
final class KeyboardButtonRequestUser extends AbstractCreateObject {}
