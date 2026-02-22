<?php

namespace Telegram\Bot\Testing\Payloads;

/**
 * Response Objects Payload Definitions for Tests Data.
 * These define the *structure* of the Telegram API objects,
 * using string placeholders that TelegramUpdate will populate with Faker data.
 */
final class PayloadDefinitions
{
    public static function create(): self
    {
        return new self;
    }

    /**
     * @return array{update_id: string, message: array{message_id: string, from: array{id: string, is_bot: false, first_name: string, last_name: string, username: string, language_code: string}, chat: array{id: string, first_name: string, last_name: string, username: string, type: string}, date: string, text: string}}
     */
    public function update(): array
    {
        return [
            'update_id' => 'id',
            // message etc. will be merged in by PayloadFactory helpers.
        ];
    }

    /**
     * @return array{id: string, is_bot: true, first_name: string, username: string, can_join_groups: true, can_read_all_group_messages: false, supports_inline_queries: false}
     */
    public function user(): array
    {
        return [
            'id' => 'id',
            'is_bot' => false,
            'first_name' => 'firstName',
            'username' => 'userName',
            'can_join_groups' => true,
            'can_read_all_group_messages' => false,
            'supports_inline_queries' => false,
        ];
    }

    /**
     * @return array{message_id: string, from: array{id: string, is_bot: true, first_name: string, username: string}, chat: array{id: string, first_name: string, username: string, type: string}, date: string, text: string}
     */
    public function message(): array
    {
        return [
            'message_id' => 'id:7',
            'from' => 'botFrom',
            'chat' => 'chat',
            'date' => 'unixTime',
            'text' => 'sentence',
            'entities' => [], // Default to empty, commandMessage will override
        ];
    }

    /**
     * @return array{id: string, from: array{id: string, is_bot: true, first_name: string, username: string}, message: array{message_id: string, from: array{id: string, is_bot: true, first_name: string, username: string}, chat: array{id: string, first_name: string, username: string, type: string}, date: string, text: string}, chat_instance: string, data: string}
     */
    public function callbackQuery(): array
    {
        return [
            'id' => 'id:16',
            'from' => 'from',
            'message' => 'message',
            'chat_instance' => 'id',
            'data' => 'word',
        ];
    }

    /**
     * @return array{file_id: string, file_unique_id: string, width: int, height: int, file_size: int, thumb?: array}
     */
    public function photo(): array
    {
        return [
            'file_id' => 'fileId:36', // Placeholder for random string file ID
            'file_unique_id' => 'fileId:16', // Placeholder for unique file ID
            'width' => 'numberBetween:100:1000',
            'height' => 'numberBetween:100:1000',
            'file_size' => 'numberBetween:10000:5000000',
        ];
    }

    /**
     * @return array{file_id: string, file_unique_id: string, thumb?: array, file_name?: string, mime_type?: string, file_size?: int}
     */
    public function document(): array
    {
        return [
            'file_id' => 'fileId:36',
            'file_unique_id' => 'fileId:16',
            'file_name' => 'word:document',
            'mime_type' => 'mimeType', // Need a Faker provider for mime types if not standard
            'file_size' => 'numberBetween:10000:10000000',
        ];
    }
}
