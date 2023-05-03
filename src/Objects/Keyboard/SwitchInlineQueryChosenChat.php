<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Represents an inline button that switches the current user to inline mode in a chosen chat, with an optional default inline query.
 *
 * @link https://core.telegram.org/bots/api#switchinlinequerychosenchat
 *
 * @method $this query(string $text)             Optional. The default inline query to be inserted in the input field. If left empty, only the bot's username will be inserted
 * @method $this allowUserChats(bool $bool)      Optional. True, if private chats with users can be chosen
 * @method $this allowBotChats(bool $bool)       Optional. True, if private chats with bots can be chosen
 * @method $this allowGroupChats(bool $bool)     Optional. True, if group and supergroup chats can be chosen
 * @method $this allowChannelChats(bool $bool)   Optional. True, if channel chats can be chosen
 */
class SwitchInlineQueryChosenChat extends AbstractCreateObject
{
}
