<?php

namespace Telegram\Bot\Objects\BotCommandScope;

/**
 * Represents the scope of bot commands, covering a specific member of a group or supergroup chat.
 *
 * @link https://core.telegram.org/bots/api#botcommandscopechatmember
 *
 * @method $this chatId(int|string $intOrString)  Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
 * @method $this userId(int $int) Required. Unique identifier of the target user
 */
final class BotCommandScopeChatMember extends BotCommandScope
{
    protected string $type = 'chat_member';
}
