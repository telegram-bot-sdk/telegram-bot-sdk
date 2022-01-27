<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering a specific chat.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopechat
 *
 * @method $this chatId($intOrString)  Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
 */
class BotCommandScopeChat extends BotCommandScope
{
    protected string $type = 'chat';
}
