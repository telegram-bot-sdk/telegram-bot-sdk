<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering all group and supergroup chats.
 *
 * @link https://core.telegram.org/bots/api#BotCommandScopeAllGroupChats
 */
class BotCommandScopeAllGroupChats extends BotCommandScope
{
    protected string $type = 'all_group_chats';
}
