<?php

namespace Telegram\Bot\Objects;

/**
 * Class VoiceChatParticipantsInvited.
 *
 * @link https://core.telegram.org/bots/api#voicechatended
 *
 * @property User[] $users    Optional. New members that were invited to the voice chat
 */
class VoiceChatParticipantsInvited extends AbstractResponseObject
{
    /**
     * @return array{users: class-string<\Telegram\Bot\Objects\User>}
     */
    public function relations(): array
    {
        return [
            'users' => User::class,
        ];
    }
}
