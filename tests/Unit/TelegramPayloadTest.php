<?php

use Illuminate\Support\Collection;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Payloads\TelegramPayload;

describe('TelegramPayload Fluent API and Magic Methods', function () {
    it('supports withXYZ magic methods for payload customization', function () {
        $customChatId = '555666777';
        $customUserId = '111222333';

        $update = TelegramPayload::create()->textMessage('Test message')
            ->withMessage(['chat' => ['id' => $customChatId]])
            ->withMessage(['from' => ['id' => $customUserId]])->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->message->chat->id)->toBe($customChatId)
            ->and($update->message->from->id)->toBe($customUserId)
            ->and($update->message->text)->toBe('Test message');
    });

    it('converts CamelCase to snake_case in magic methods', function () {
        $update = TelegramPayload::create()->textMessage('Test')
            ->withUpdateId(999888777)->get();

        expect($update->update_id)->toBe(999888777);
    });

    it('can chain multiple withXYZ methods', function () {
        $update = TelegramPayload::create()->commandMessage('test')
            ->withUpdateId(123)
            ->withMessage(['date' => 1640995200])
            ->withMessage(['chat' => ['type' => 'group']])->get();

        expect($update->update_id)->toBe(123)
            ->and($update->message->date)->toBe(1640995200)
            ->and($update->message->chat->type)->toBe('group');
    });

    it('throws exception when calling withXYZ before setting payload template', function () {
        TelegramPayload::create()->withUpdateId(123)->get();
    })
        ->throws(RuntimeException::class, 'No base payload template set');
});

describe('TelegramPayload Callback Query Payloads', function () {
    it('generates a callback query', function () {
        $update = TelegramPayload::create()->callbackQuery('test_callback')->get();

        expect($update)->toBeInstanceOf(ResponseObject::class);

        $cq = $update->callback_query;
        expect($cq)->toBeObject()
            ->and($cq->toArray())->toHaveKeys(['id', 'from', 'message', 'chat_instance', 'data'])
            ->and($cq->data)->toBe('test_callback');

        $message = $cq->message;
        expect($message)->toBeObject()
            ->and($message->toArray())->toHaveKey('text')
            ->and(is_string($message->text))->toBeTrue()
            ->and($cq->from->is_bot)->toBeFalse()
            ->and($message->from->is_bot)->toBeTrue();
    });

    it('correctly merges custom data in callback query payload', function () {
        $customData = 'custom_callback_data';
        $customChatId = 987654321;

        $update = TelegramPayload::create()->callbackQuery($customData, [
            'callback_query' => [
                'data' => $customData,
                'message' => [
                    'chat' => ['id' => $customChatId],
                ],
            ],
            'update_id' => 123456789,
        ])->get();

        expect($update->update_id)->toBe(123456789)
            ->and($update->callback_query->data)->toBe($customData)
            ->and($update->callback_query->message->chat->id)->toBe($customChatId);
    });

    it('can generate multiple callback queries consistently using times()', function () {
        $updates = TelegramPayload::create()->callbackQuery('multi_test')->times(3)->asCollection();

        expect($updates)->toBeInstanceOf(Collection::class)
            ->and($updates)->toHaveCount(3);

        $updates->each(function ($update) {
            expect($update)->toBeInstanceOf(ResponseObject::class)
                ->and($update->callback_query->data)->toBe('multi_test');
        });
    });

    it('produces correct JSON and array representations', function () {
        $responseObj = TelegramPayload::create()->callbackQuery('json_test')->get();

        $array = $responseObj->toArray();
        expect($array)->toBeArray()
            ->and($array['callback_query']['data'])->toBe('json_test');

        $json = TelegramPayload::create()->callbackQuery('json_test')->asJson();

        expect($json)->toBeString();

        $decoded = json_decode($json, true);
        expect($decoded['callback_query']['data'])->toBe('json_test');
    });
});

describe('TelegramPayload Basic Payload Generation', function () {
    it('generates a complete command message update payload', function () {
        $update = TelegramPayload::create()->commandMessage('testcommand', 'arg1 value')->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->update_id)->toBeInt()
            ->and($update->message)->toBeObject()
            ->and($update->message->text)->toBe('/testcommand arg1 value')
            ->and($update->message->entities)->toHaveCount(1)
            ->and($update->message->entities[0]->toArray())->toMatchArray([
                'offset' => 0,
                'length' => 12,
                'type' => 'bot_command',
            ])
            ->and($update->message->from)->toBeObject()
            ->and($update->message->chat)->toBeObject()
            ->and($update->message->date)->toBeInt();
    });

    it('generates a complete plain text message update payload', function () {
        $text = 'This is a test message.';
        $update = TelegramPayload::create()->textMessage($text)->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->message->text)->toBe($text)
            ->and($update->message->entities)->toBeEmpty();
    });

    it('generates a complete callback query update payload', function () {
        $data = 'action_item_123';
        $update = TelegramPayload::create()->callbackQuery($data)->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->callback_query)->toBeObject()
            ->and($update->callback_query->data)->toBe($data)
            ->and((string) $update->callback_query->id)->toHaveLength(16)
            ->and($update->callback_query->from)->toBeObject()
            ->and($update->callback_query->message)->toBeObject();
    });

    it('generates a complete photo message update payload', function () {
        $update = TelegramPayload::create()->photoMessage()->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->message)->toBeObject()
            ->and($update->message->photo)->toHaveCount(1)
            ->and($update->message->photo[0])->toBeObject()
            ->and($update->message->photo[0]->file_id)->toBeString()->toHaveLength(36)
            ->and($update->message->photo[0]->file_unique_id)->toBeString()->toHaveLength(16)
            ->and($update->message->photo[0]->width)->toBeInt()
            ->and($update->message->photo[0]->height)->toBeInt()
            ->and($update->message->photo[0]->file_size)->toBeInt();
    });

    it('generates a complete document message update payload', function () {
        $update = TelegramPayload::create()->documentMessage()->get();

        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->message)->toBeObject()
            ->and($update->message->document)->toBeObject()
            ->and($update->message->document->file_id)->toBeString()->toHaveLength(36)
            ->and($update->message->document->file_unique_id)->toBeString()->toHaveLength(16)
            ->and($update->message->document->file_name)->toBeString()
            ->and($update->message->document->mime_type)->toBeString()->toContain('/')
            ->and($update->message->document->file_size)->toBeInt();
    });

    it('merges custom payload data correctly', function () {
        $userId = '987654321';
        $chatId = '1122334455';
        $customText = 'Override this text!';

        $update = TelegramPayload::create()->textMessage('Original text', [
            'message' => [
                'from' => ['id' => $userId],
                'chat' => ['id' => $chatId],
                'text' => $customText,
            ],
            'update_id' => 123456789,
        ])->get();

        expect($update->update_id)->toBe(123456789)
            ->and($update->message->from->id)->toBe($userId)
            ->and($update->message->chat->id)->toBe($chatId)
            ->and($update->message->text)->toBe($customText);
    });
});

describe('TelegramPayload Multiple Payloads & Output Formats', function () {
    it('can generate multiple payloads using times()', function () {
        $updates = TelegramPayload::create()->times(3)->textMessage('Hello')->asCollection();

        expect($updates)->toBeInstanceOf(Collection::class)->toHaveCount(3);

        $updates->each(function ($update) {
            expect($update)->toBeInstanceOf(ResponseObject::class)
                ->and($update->message->text)->toBe('Hello');
        });
    });

    it('handles different payload generation and conversion types', function () {
        // Test raw array
        $payload = TelegramPayload::create()->textMessage('raw')->toArray();
        expect($payload)->toBeArray()
            ->and($payload['message']['text'])->toBe('raw');

        // Test result format
        $result = TelegramPayload::create()->textMessage('result')->asResult();
        expect($result)->toBeArray()
            ->and($result['ok'])->toBeTrue()
            ->and($result['result']['message']['text'])->toBe('result');

        // Test ResponseObject (DEFAULT BEHAVIOUR)
        $responseObject = TelegramPayload::create()->textMessage('response object')->get();
        expect($responseObject)->toBeInstanceOf(ResponseObject::class)
            ->and($responseObject->message->text)->toBe('response object');

        // Test JSON string
        $json = TelegramPayload::create()->textMessage('json')->asJson();
        expect($json)->toBeString();
        $decodedJson = json_decode($json, true);
        expect($decodedJson['message']['text'])->toBe('json');
    });

    it('handles times() with different output formats consistently', function () {
        // Multiple items as array
        $arrays = TelegramPayload::create()
            ->times(2)
            ->textMessage('Hello')
            ->withMessage(['from' => ['first_name' => 'demo']])
            ->toArray();

        expect($arrays)->toBeArray()->toHaveCount(2)
            ->and($arrays[0]['message']['text'])->toBe('Hello')
            ->and($arrays[0]['message']['from']['first_name'])->toBe('demo')
            ->and($arrays[1]['message']['text'])->toBe('Hello')
            ->and($arrays[1]['message']['from']['first_name'])->toBe('demo');

        // Multiple items as ResponseObject array
        $responseObjects = TelegramPayload::create()->times(2)->textMessage('Hello')->get();
        expect($responseObjects)->toBeArray()->toHaveCount(2)
            ->and($responseObjects[0])->toBeInstanceOf(ResponseObject::class)
            ->and($responseObjects[1])->toBeInstanceOf(ResponseObject::class)
            ->and($responseObjects[0]->message->text)->toBe('Hello')
            ->and($responseObjects[1]->message->text)->toBe('Hello');

        // Single item as ResponseObject
        $singleResponse = TelegramPayload::create()->times(1)->textMessage('Hello')->get();
        expect($singleResponse)->toBeInstanceOf(ResponseObject::class)
            ->and($singleResponse->message->text)->toBe('Hello');
    });
});

describe('TelegramPayload State Management and Seeding', function () {
    it('resets count and template after generation', function () {
        // Generate first payload with times(3)
        $firstBatch = TelegramPayload::create()->times(3)->textMessage('First')->asCollection();
        expect($firstBatch)->toHaveCount(3);

        // Generate second payload without times() - should default to 1
        $secondBatch = TelegramPayload::create()->textMessage('Second')->asCollection();
        expect($secondBatch)->toHaveCount(1)
            ->and($secondBatch->first()->message->text)->toBe('Second');
    });

    it('can use seed for reproducible results', function () {
        $first = TelegramPayload::create()->textMessage('test')->seed(999)->get();
        $second = TelegramPayload::create()->textMessage('test')->seed(999)->get();

        expect($first->update_id)->toBe($second->update_id)
            ->and($first->message->from->id)->toBe($second->message->from->id)
            ->and($first->message->chat->id)->toBe($second->message->chat->id);
    });

    it('generates different results without seed', function () {
        $first = TelegramPayload::create()->textMessage('test')->get();
        $second = TelegramPayload::create()->textMessage('test')->get();

        expect($first->update_id)->not->toBe($second->update_id);
    });
});

describe('TelegramPayload Direct Payload Methods', function () {
    it('can call payload methods directly', function () {
        $user = TelegramPayload::create()->user()->get();
        expect($user)->toBeInstanceOf(ResponseObject::class)
            ->and($user->id)->toBeInt()
            ->and($user->first_name)->toBeString();

        $message = TelegramPayload::create()->message()->get();
        expect($message)->toBeInstanceOf(ResponseObject::class)
            ->and($message->message_id)->toBeInt()
            ->and($message->text)->toBeString()
            ->and($message->from)->toBeObject()
            ->and($message->chat)->toBeObject();
    });

    it('can overwrite payload methods directly', function () {
        $user = TelegramPayload::create()->user()->withFirstName('John')->get();
        expect($user)->toBeInstanceOf(ResponseObject::class)
            ->and($user->id)->toBeInt()
            ->and($user->first_name)->toBe('John');

        $message = TelegramPayload::create()->message()->withText('Spectacular')->get();
        expect($message)->toBeInstanceOf(ResponseObject::class)
            ->and($message->message_id)->toBeInt()
            ->and($message->text)->tobe('Spectacular')
            ->and($message->from)->toBeObject()
            ->and($message->chat)->toBeObject();
    });
});
