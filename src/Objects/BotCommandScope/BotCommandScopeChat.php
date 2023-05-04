<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering a specific chat.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopechat
 *
 * @method $this chatId(int|string $intOrString)  Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
 */
final class BotCommandScopeChat extends BotCommandScope
{
    protected string $type = 'chat';
}
