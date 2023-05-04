<?php

namespace Telegram\Bot\Objects\MenuButton;

/**
 * Describes that no specific value for the menu button was set.
 *
 * @link https://core.telegram.org/bots/api#menubuttondefault
 */
class MenuButtonDefault extends MenuButton
{
    protected string $type = 'default';
}
