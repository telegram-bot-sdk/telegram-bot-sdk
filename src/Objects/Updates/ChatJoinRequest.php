<?php

namespace Telegram\Bot\Objects\Updates;

use Telegram\Bot\Objects\AbstractResponseObject;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\ChatInviteLink;
use Telegram\Bot\Objects\User;

/**
 * Class ChatJoinrequest.
 *
 * @link https://core.telegram.org/bots/api#chatjoinrequest
 *
 * @property Chat           $chat                Chat to which the request was sent
 * @property User           $from                User that sent the join request
 * @property int            $date                Date the request was sent in Unix time
 * @property string         $bio                 (Optional). Bio of the user.
 * @property ChatInviteLink $invite_link         (Optional). Chat invite link that was used by the user to send the join request
 */
class ChatJoinRequest extends AbstractResponseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{chat: class-string<\Telegram\Bot\Objects\Chat>, from: class-string<\Telegram\Bot\Objects\User>, invite_link: class-string<\Telegram\Bot\Objects\ChatInviteLink>}
     */
    public function relations(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}
