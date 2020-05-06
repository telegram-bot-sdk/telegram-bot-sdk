<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\BaseCreateObject;

abstract class BaseKeyboard extends BaseCreateObject
{
    protected string $type = 'inline_keyboard';

    /**
     * Create a new row in keyboard to add buttons.
     *
     * @param array $buttons
     *
     * @return BaseKeyboard
     */
    public function row(...$buttons): self
    {
        $this->fields[$this->type][] = $buttons;

        return $this;
    }
}
