<?php

namespace Telegram\Bot\Testing\Responses;

/**
 * Response Objects Payload Definitions for Tests Data.
 */
final class Payload
{
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return array{id: string, is_bot: true, first_name: string, username: string, can_join_groups: true, can_read_all_group_messages: false, supports_inline_queries: false}
     */
    public function user(): array
    {
        return [
            'id' => 'id',
            'is_bot' => true,
            'first_name' => 'firstName',
            'username' => 'userName',
            'can_join_groups' => true,
            'can_read_all_group_messages' => false,
            'supports_inline_queries' => false,
        ];
    }

    /**
     * @return array{update_id: string, message: array{message_id: string, from: array{id: string, is_bot: false, first_name: string, last_name: string, username: string, language_code: string}, chat: array{id: string, first_name: string, last_name: string, username: string, type: string}, date: string, text: string}}
     */
    public function update(): array
    {
        return [
            'update_id' => 'id',
            'message' => [
                'message_id' => 'id',
                'from' => [
                    'id' => 'id',
                    'is_bot' => false,
                    'first_name' => 'firstName',
                    'last_name' => 'lastName',
                    'username' => 'userName',
                    'language_code' => 'languageCode',
                ],
                'chat' => [
                    'id' => 'id',
                    'first_name' => 'firstName',
                    'last_name' => 'lastName',
                    'username' => 'userName',
                    'type' => 'private',
                ],
                'date' => 'unixTime',
                'text' => 'sentence',
            ],
        ];
    }

    /**
     * @return array{message_id: string, from: array{id: string, is_bot: true, first_name: string, username: string}, chat: array{id: string, first_name: string, username: string, type: string}, date: string, text: string}
     */
    public function message(): array
    {
        return [
            'message_id' => 'randomNumber:5',
            'from' => [
                'id' => 'id',
                'is_bot' => true,
                'first_name' => 'botName',
                'username' => 'botUserName',
            ],
            'chat' => [
                'id' => 'id',
                'first_name' => 'firstName',
                'username' => 'userName',
                'type' => 'private',
            ],
            'date' => 'unixTime',
            'text' => 'sentence',
        ];
    }
}
