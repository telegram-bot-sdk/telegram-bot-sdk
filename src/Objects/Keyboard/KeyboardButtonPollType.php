<?php

namespace Telegram\Bot\Objects\Keyboard;

class KeyboardButtonPollType
{
    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
     *
     * @return array{type: string}
     */
    public static function quiz(): array
    {
        return ['type' => 'quiz'];
    }

    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
     *
     * @return array{type: string}
     */
    public static function regular(): array
    {
        return ['type' => 'regular'];
    }

    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
     *
     * @return array{type: string}
     */
    public static function any(): array
    {
        return ['type' => ''];
    }
}
