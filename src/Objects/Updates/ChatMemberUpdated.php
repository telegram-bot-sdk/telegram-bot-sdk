<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\ChatInviteLink;
use Telegram\Bot\Objects\ChatMember;
use Telegram\Bot\Objects\User;

/**
 * Class Message.
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 *
 * @property Chat           $chat                Chat the user belongs to
 * @property User           $from                Performer of the action, which resulted in the change
 * @property int            $date                Date the change was done in Unix time
 * @property ChatMember     $old_chat_member     Previous information about the chat member
 * @property ChatMember     $new_chat_member     New information about the chat member
 * @property ChatInviteLink $invite_link         (Optional). Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
 */
class ChatMemberUpdated extends AbstractResponseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{chat: class-string<\Telegram\Bot\Objects\Chat>, from: class-string<\Telegram\Bot\Objects\User>, old_chat_member: class-string<\Telegram\Bot\Objects\ChatMember>, new_chat_member: class-string<\Telegram\Bot\Objects\ChatMember>, invite_link: class-string<\Telegram\Bot\Objects\ChatInviteLink>}
     */
    public function relations(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'old_chat_member' => ChatMember::class,
            'new_chat_member' => ChatMember::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}
