<?php

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Payloads\TelegramPayload;

it('can perform getMe and sendMessage with mocked HTTP responses', function () {
    // Manually prepare responses
    $responses = [
        [
            'ok' => true,
            'result' => [
                'id' => 123456789,
                'is_bot' => true,
                'first_name' => 'TestBot',
                'username' => 'test_bot',
            ],
        ],
        [
            'ok' => true,
            'result' => [
                'message_id' => 42,
                'chat' => ['id' => 1234],
                'text' => 'Hello, world!',
            ],
        ],
    ];

    $botManager = mockBotManagerWithResponses($responses);
    $bot = $botManager->bot();

    // First call
    $user = $bot->getMe();

    expect($user)->toBeInstanceOf(ResponseObject::class)
        ->and($user->id)->toBe(123456789)
        ->and($user->is_bot)->toBeTrue();

    // Second call
    $message = $bot->sendMessage([
        'chat_id' => 1234,
        'text' => 'Hello, world!',
    ]);

    expect($message)->toBeInstanceOf(ResponseObject::class)
        ->and($message->message_id)->toBe(42)
        ->and($message->text)->toBe('Hello, world!');
});

it('can call getMe and receive a valid user object', function () {
    // Use factory to create a response
    $fakeResponse = TelegramPayload::create()
        ->user()
        ->withId(123456789)
        ->withFirstName('TestBot')
        ->withUsername('testingbot')
        ->withIsBot(true)
        ->asResult();

    $bot = mockBotManagerWithResponses($fakeResponse);

    $response = $bot->getMe();

    expect($response)->toBeInstanceOf(ResponseObject::class)
        ->and($response->id)->toBe(123456789)
        ->and($response->is_bot)->toBeTrue()
        ->and($response->first_name)->toBe('TestBot')
        ->and($response->username)->toBe('testingbot');
});

// --- Test sendMessage method ---
it('can send a message using sendMessage method', function () {
    $fakeResponse = TelegramPayload::create()
        ->message()
        ->withText('Hello, world')
        ->withMessageId(1)
        ->asResult();

    $bot = mockBotManagerWithResponses($fakeResponse);

    $response = $bot->sendMessage(['chat_id' => 123, 'text' => 'Hello, world']);

    expect($response)->toBeInstanceOf(ResponseObject::class)
        ->and($response->message_id)->toBe(1)
        ->and($response->text)->toBe('Hello, world');
});

// --- Test sending a message without required chat_id (expect error or exception) ---
it('throws exception when required parameters missing in sendMessage', function () {
    $bot = mockBotManagerWithResponses(['ok' => false, 'description' => 'Bad Request: chat_id is required']);

    $this->expectException(Exception::class);

    $bot->sendMessage(['text' => 'Missing chat_id']);
});

// --- Test editing a message text ---
it('can edit message text with editMessageText', function () {
    // Also able to stub out only exact fields to be tested
    $responseData = ['ok' => true, 'result' => ['message_id' => 1, 'text' => 'Edited message']];
    $bot = mockBotManagerWithResponses($responseData);

    $response = $bot->editMessageText(['chat_id' => 123, 'message_id' => 1, 'text' => 'Edited message']);

    expect($response)->toBeInstanceOf(ResponseObject::class)
        ->and($response->message_id)->toBe(1)
        ->and($response->text)->toBe('Edited message');
});

// --- Test answerCallbackQuery ---
it('can answer callback query', function () {
    // If the telegram method returns a bool, we can also just use a bool for the response. This will be converted to
    // {"ok":true,"result":true}
    $responseData = true;
    $bot = mockBotManagerWithResponses($responseData);

    $response = $bot->answerCallbackQuery(['callback_query_id' => 'test123', 'text' => 'Callback answered']);

    expect($response)->toBeTrue();
});

// --- Test getUpdates retrieving multiple updates ---
it('can get updates with getUpdates', function () {
    $fakeUpdates = [
        ['update_id' => 1, 'message' => ['message_id' => 1, 'text' => 'Hello']],
        ['update_id' => 2, 'message' => ['message_id' => 2, 'text' => 'World']],
    ];
    $bot = mockBotManagerWithResponses(['ok' => true, 'result' => $fakeUpdates]);

    $updates = $bot->getUpdates();

    expect($updates)->toBeArray()->toHaveCount(2);

    foreach ($updates as $update) {
        expect($update)->toBeInstanceOf(ResponseObject::class)
            ->and($update->message)->toBeObject()
            ->and($update->message->message_id)->toBeInt()
            ->and($update->message->text)->toBeString();
    }
});

// --- Test sending photo ---
it('can send a photo message', function () {
    $responseData = ['ok' => true, 'result' => ['message_id' => 3, 'photo' => [['file_id' => 'abc123'], ['file_id' => 'abc345']]]];
    $bot = mockBotManagerWithResponses($responseData);

    $response = $bot->sendPhoto(['chat_id' => 123, 'photo' => InputFile::contents('binarydata', 'photo.jpg')]);

    expect($response)->toBeInstanceOf(ResponseObject::class)
        ->and($response->message_id)->toBe(3)
        ->and($response->photo)->toBeInstanceOf(ResponseObject::class)
        ->and($response->photo)->toHaveCount(2);
});

// --- Test error handling for unknown method call ---
it('throws exception or handles unknown method calls gracefully', function () {
    $bot = mockBotManagerWithResponses([]);

    $bot->unknownMethod();
})
    ->throws(BadMethodCallException::class);
