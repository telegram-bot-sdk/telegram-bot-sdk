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

    public function user(): array
    {
        return [
            'id'                          => 'randomNumber:9',
            'is_bot'                      => true,
            'first_name'                  => 'firstName',
            'username'                    => 'userName',
            'can_join_groups'             => true,
            'can_read_all_group_messages' => false,
            'supports_inline_queries'     => false,
        ];
    }

    public function update(): array
    {
        return [
            'update_id' => 'randomNumber:9',
            'message' => [
                'message_id' => 'randomNumber:9',
                'from' => [
                    'id' => 'randomNumber:9',
                    'is_bot' => false,
                    'first_name' => 'firstName',
                    'last_name' => 'lastName',
                    'username' => 'userName',
                    'language_code' => 'languageCode',
                ],
                'chat' => [
                    'id' => 'randomNumber:9',
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

    public function message(): array
    {
        return [
            'message_id' => 'randomNumber:5',
            'from'       => [
                'id'         => 'randomNumber:9',
                'is_bot'     => true,
                'first_name' => 'firstName',
                'username'   => 'userName',
            ],
            'chat'       => [
                'id'         => 'randomNumber:9',
                'first_name' => 'firstName',
                'username'   => 'userName',
                'type'       => 'private',
            ],
            'date'       => 'unixTime',
            'text'       => 'sentence',
        ];
    }
}
