<?php

namespace Telegram\Bot\Objects\Keyboard;

class InlineKeyboardMarkup extends BaseKeyboard
{
    /**
     * Begin to create the inline keyboard..
     *
     * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will display unsupported message.
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
     *
     * @return InlineKeyboardMarkup
     */
    public static function create(): self
    {
        return new static();
    }
}
