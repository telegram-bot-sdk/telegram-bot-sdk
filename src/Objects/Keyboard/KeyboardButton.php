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
 * @method $this text(string $text)                                            Required. Text of the button. If none of the optional fields are used, it will be sent as a message when the button is pressed
 * @method $this requestContact(bool $requestContact)                          (Optional). If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
 * @method $this requestLocation(bool $requestLocation)                        (Optional). If True, the user's current location will be sent when the button is pressed. Available in private chats only.
 * @method $this requestPoll(KeyboardButtonPollType $KeyboardButtonPollType)   (Optional). If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only
 */
class KeyboardButton extends AbstractCreateObject
{
}
