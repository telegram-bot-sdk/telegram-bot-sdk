<?php

namespace Telegram\Bot\Objects\Keyboard;

/**
 * Class Button.
 *
 * @method setUrl($string)                           (Optional). HTTP or tg:// url to be opened when button is pressed
 * @method setLoginUrl($LoginUrl)                    (Optional). An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
 * @method setCallbackData($string)                  (Optional). Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
 * @method setSwitchInlineQuery($string)             (Optional). If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot‘s username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
 * @method setSwitchInlineQueryCurrentChat($string)  (Optional). If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat’s input field. Can be empty, in which case only the bot's username will be inserted.
 * @method setCallbackGame($string)                  (Optional). Description of the game that will be launched when the user presses the button. NOTE: This type of button must always be the first button in the first row.
 * @method setPay($bool)                             (Optional). Specify True, to send a Pay button. NOTE: This type of button must always be the first button in the first row.
 */
class InlineKeyboardButton extends BaseButton
{
    /**
     * Represents one button of an inline keyboard. You must use exactly one of the optional fields.
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
     *
     * @param $text
     *
     * @return InlineKeyboardButton
     */
    public static function text(string $text): self
    {
        return new static(['text' => $text]);
    }
}
