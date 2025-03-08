<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Class KeyboardButton.
 *
 * Represents one button of the reply keyboard.
 * For simple text buttons String can be used instead of this object to specify text of the button.
 *
 * Optional fields request_contact, request_location, and request_poll are mutually exclusive.
 *
 * @link https://core.telegram.org/bots/api#keyboardbutton
 *
 * @method self text(string $text) Required. Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
 * @method self requestUser(array $keyboardButtonRequestUser) (Optional). If specified, pressing the button will open a list of suitable users. Tapping on any user will send their identifier to the bot in a “user_shared” service message. Available in private chats only.
 * @method self requestChat(array $keyboardButtonRequestChat) (Optional). If specified, pressing the button will open a list of suitable chats. Tapping on a chat will send its identifier to the bot in a “chat_shared” service message. Available in private chats only.
 * @method self requestContact(bool $requestContact) (Optional). If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
 * @method self requestLocation(bool $requestLocation) (Optional). If True, the user's current location will be sent when the button is pressed. Available in private chats only.
 * @method self requestPoll(KeyboardButtonPollType $keyboardButtonPollType) (Optional). If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only
 * @method self webApp($webAppInfo) (Optional). If specified, the described Web App will be launched when the button is pressed. The Web App will be able to send a “web_app_data” service message. Available in private chats only.
 */
final class KeyboardButton extends AbstractCreateObject {}
