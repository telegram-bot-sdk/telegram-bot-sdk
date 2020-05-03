<?php

namespace Telegram\Bot\Objects\Keyboard;

class KeyboardButtonPollType
{
    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/apikeyboardbuttonpolltype
     *
     * @return array
     */
    public static function setAsQuiz()
    {
        return ['type' => 'quiz'];
    }

    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/apikeyboardbuttonpolltype
     *
     * @return array
     */
    public static function setAsRegular()
    {
        return ['type' => 'regular'];
    }

    /**
     * Represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
     *
     * @link https://core.telegram.org/bots/apikeyboardbuttonpolltype
     *
     * @return array
     */
    public static function setAsAny()
    {
        return ['type' => ''];
    }
}
