<?php

namespace Telegram\Bot\Objects\Keyboard;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice privacy mode.
 *
 * @link https://core.telegram.org/bots/api#forcereply
 *
 * @method $this inputFieldPlaceholder(string $string) Optional. The placeholder to be shown in the input field when the reply is active; 1-64 characters
 * @method $this selective(bool $bool)                  Optional. Use this parameter if you want to force reply from specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
 */
final class ForceReply extends AbstractCreateObject
{
    public function __construct(array $fields = [])
    {
        $fields['force_reply'] = true;

        parent::__construct($fields);
    }
}
