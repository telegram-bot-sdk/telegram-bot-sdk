<?php

namespace Telegram\Bot\Objects\Keyboard;

/**
 * Class KeyboardButton.
 *
 * @method setRequestContact($boolean)               (Optional). If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
 * @method setRequestLocation($boolean)              (Optional). If True, the user's current location will be sent when the button is pressed. Available in private chats only.
 * @method setRequestPoll($KeyboardButtonPollType)   (Optional). If specified, the user will be asked to create a poll and send it to the bot when the button is pressed. Available in private chats only
 */
class KeyboardButton extends BaseButton
{
    /**
     * Represents one button of the Reply keyboard.
     *
     * Optional fields `request_contact`, `request_location`, and `request_poll` are mutually exclusive
     *
     * @link https://core.telegram.org/bots/api#keyboardbutton
     *
     * @param $text
     *
     * @return KeyboardButton
     */
    public static function text(string $text): self
    {
        return new static(['text' => $text]);
    }
}
