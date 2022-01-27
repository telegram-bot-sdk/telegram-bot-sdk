<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering a specific member of a group or supergroup chat.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopechatmember
 *
 * @method $this chatId($intOrString)  Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
 * @method $this userId($int)          Required. Unique identifier of the target user
 */
class BotCommandScopeChatMember extends BotCommandScope
{
    protected string $type = 'chat_member';
}
