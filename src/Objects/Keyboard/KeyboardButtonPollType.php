<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Represents type of poll, which is allowed to be created and sent when the corresponding button is pressed.
 *
 * @link https://core.telegram.org/bots/api#keyboardbuttonpolltype
 *
 * @method void type(string $pollType) Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
 */
final class KeyboardButtonPollType extends AbstractCreateObject
{
    /**
     * Shortcut to set KeyboardButtonPollType to Quiz
     */
    public function quiz(): void
    {
        $this->fields->offsetSet('type', 'quiz');
    }

    /**
     * Shortcut to set KeyboardButtonPollType to Regular
     */
    public function regular(): void
    {
        $this->fields->offsetSet('type', 'regular');
    }
}
