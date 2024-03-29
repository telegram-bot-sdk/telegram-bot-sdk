<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard. By default, custom keyboards are displayed until a new keyboard is sent by a bot. An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see ReplyKeyboardMarkup).
 *
 * @link https://core.telegram.org/bots/api#replykeyboardremove
 *
 * @method void selective(bool $bool)     Optional. Use this parameter if you want to remove the keyboard for specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
 */
final class ReplyKeyboardRemove extends AbstractCreateObject
{
    public function __construct(array $fields = [])
    {
        $fields['remove_keyboard'] = true;

        parent::__construct($fields);
    }
}
