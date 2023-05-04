<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

abstract class AbstractKeyboard extends AbstractCreateObject
{
    private array $rows;

    /**
     * Create a new row in keyboard to add buttons.
     *
     * @param  array  $buttons
     */
    public function row(...$buttons): self
    {
        $this->rows[] = $buttons;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $type = ($this instanceof InlineKeyboardMarkup) ? 'inline_keyboard' : 'keyboard';

        $this->fields->offsetSet($type, $this->rows);

        return $this->fields->jsonSerialize();
    }
}
