<?php

use Telegram\Bot\Helpers\Update;
use Telegram\Bot\Objects\ResponseObject;

it('can find the update type', function () {
    $response = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => 'Hello, world!',
        ],
    ]);
    $update = Update::find($response);

    expect($update->type())->toBe('message');
});

it('can get the message from the update', function () {
    $response = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => 'Hello, world!',
        ],
    ]);
    $update = Update::find($response);

    expect($update->message())->toBeInstanceOf(ResponseObject::class)
        ->and($update->message()->offsetGet('message_id'))->toBe(456)
        ->and($update->message()->offsetGet('text'))->toBe('Hello, world!');
});

it('can get the chat from the update', function () {
    $response = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => 'Hello, world!',
            'chat' => [
                'id' => 789,
                'type' => 'private',
            ],
        ],
    ]);
    $update = Update::find($response);

    expect($update->chat())->toBeInstanceOf(ResponseObject::class)
        ->and($update->chat()->offsetGet('id'))->toBe(789)
        ->and($update->chat()->offsetGet('type'))->toBe('private');
});

it('can get the message type from the update', function () {
    $response = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => 'Hello, world!',
        ],
    ]);
    $update = Update::find($response);

    expect($update->messageType())->toBe('text');
});
