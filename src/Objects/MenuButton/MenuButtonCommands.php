<?php

namespace Telegram\Bot\Objects\MenuButton;

/**
 * Represents a menu button, which opens the bot's list of commands.
 *
 * @link https://core.telegram.org/bots/api#menubuttoncommands
 */
final class MenuButtonCommands extends MenuButton
{
    protected string $type = 'commands';
}
