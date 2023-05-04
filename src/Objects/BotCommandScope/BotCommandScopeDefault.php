<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the default scope of bot commands. Default commands are used if no commands with a narrower scope are specified for the user.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopedefault
 */
final class BotCommandScopeDefault extends BotCommandScope
{
    protected string $type = 'default';
}
