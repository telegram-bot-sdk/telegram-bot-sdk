<?php

namespace Telegram\Bot\Objects\Keyboard;

class ReplyKeyboardRemove
{
    /**
     * Hide the current custom keyboard and display the default letter-keyboard.
     *
     * <code>
     * Selective - (Optional). Use this parameter if you want to remove the keyboard for
     *             specific users only. Targets: 1) users that are "@mentioned" in the text
     *             of the Message object; 2) if the bot's message is a reply
     *             (has reply_to_message_id), sender of the original message.
     * </code>
     *
     * @link https://core.telegram.org/bots/api#replykeyboardremove
     *
     * @param bool $selective
     *
     * @return array{remove_keyboard: true, selective: bool}
     */
    public static function selective(bool $selective = false): array
    {
        return ['remove_keyboard' => true, 'selective' => $selective];
    }
}
