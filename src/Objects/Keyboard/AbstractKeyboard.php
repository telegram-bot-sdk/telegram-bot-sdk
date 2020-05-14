<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

abstract class AbstractKeyboard extends AbstractCreateObject
{
    /**
     * Create a new row in keyboard to add buttons.
     *
     * @param array $buttons
     *
     * @return AbstractKeyboard
     */
    public function row(...$buttons): self
    {
        $type = ($this instanceof InlineKeyboardMarkup) ? 'inline_keyboard' : 'keyboard';

        $this->fields[$type][] = $buttons;

        return $this;
    }
}
