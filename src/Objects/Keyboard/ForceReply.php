<?php

namespace Telegram\Bot\Objects\Keyboard;

class ForceReply
{
    /**
     * Display a reply interface to the user (act as if the user has selected the bot‘s message and tapped ’Reply').
     *
     * <code>
     * Selective - bool - (Optional). Use this parameter if you want to force reply from specific users only.
     *                    Targets: 1) users that are "@mentioned" in the text of the Message object;
     *                             2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     * </code>
     *
     * @link https://core.telegram.org/bots/api#forcereply
     *
     * @param bool $selective
     *
     * @return array
     */
    public static function selective(bool $selective = false): array
    {
        return ['force_reply' => true, 'selective' => $selective];
    }
}
