<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering all administrators of a specific group or supergroup chat.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopechatadministrators
 *
 * @method $this chatId(int|string $intOrString)  Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
 */
class BotCommandScopeChatAdministrators extends BotCommandScope
{
    protected string $type = 'chat_administrators';
}
