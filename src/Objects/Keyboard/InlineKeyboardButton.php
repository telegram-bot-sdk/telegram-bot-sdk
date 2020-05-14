<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Class InlineKeyboardButton.
 *
 * Represents one button of an inline keyboard. You must use exactly one of the optional fields.
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
 *
 * @method $this text(string $text)                                                  Required. Label text on the button
 * @method $this url(string $url)                                                    (Optional). HTTP or tg:// url to be opened when button is pressed
 * @method $this loginUrl(LoginUrl $LoginUrl)                                        (Optional). An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
 * @method $this callbackData(string $callbackData)                                  (Optional). Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
 * @method $this switchInlineQuery(string $switchInlineQuery)                        (Optional). If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot‘s username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
 * @method $this switchInlineQueryCurrentChat(string $switchInlineQueryCurrentChat)  (Optional). If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat’s input field. Can be empty, in which case only the bot's username will be inserted.
 * @method $this callbackGame(string $callbackGame)                                  (Optional). Description of the game that will be launched when the user presses the button. NOTE: This type of button must always be the first button in the first row.
 * @method $this pay(bool $pay)                                                      (Optional). Specify True, to send a Pay button. NOTE: This type of button must always be the first button in the first row.
 */
class InlineKeyboardButton extends AbstractCreateObject
{
}
