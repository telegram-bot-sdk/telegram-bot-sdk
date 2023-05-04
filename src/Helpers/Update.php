<?php

namespace Telegram\Bot\Helpers;

use Telegram\Bot\Objects\ResponseObject;

final class Update
{
    private ?string $updateType = null;

    public function __construct(private readonly ResponseObject $response)
    {
    }

    public static function find(ResponseObject $response): Update
    {
        return new self($response);
    }

    public function type(): ?string
    {
        return $this->updateType ??= $this->response
            ->collect()
            ->except('update_id')
            ->keys()
            ->first();
    }

    public function message(): ResponseObject
    {
        return $this->response->offsetGet($this->type()) ?? new ResponseObject();
    }

    public function chat(): ?ResponseObject
    {
        return $this->message()->offsetGet('chat');
    }

    public function messageType(): ?string
    {
        return $this->message()->findType([
            'is_topic_message',
            'is_automatic_forward',
            'reply_to_message',
            'via_bot',
            'text',
            'animation',
            'audio',
            'document',
            'photo',
            'sticker',
            'video',
            'video_note',
            'voice',
            'caption',
            'contact',
            'dice',
            'game',
            'poll',
            'venue',
            'location',
            'new_chat_members',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'message_auto_delete_timer_changed',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
            'invoice',
            'successful_payment',
            'user_shared',
            'chat_shared',
            'connected_website',
            'write_access_allowed',
            'passport_data',
            'proximity_alert_triggered',
            'forum_topic_created',
            'forum_topic_edited',
            'forum_topic_closed',
            'forum_topic_reopened',
            'general_forum_topic_hidden',
            'general_forum_topic_unhidden',
            'video_chat_scheduled',
            'video_chat_started',
            'video_chat_ended',
            'video_chat_participants_invited',
            'web_app_data',
        ]);
    }
}
