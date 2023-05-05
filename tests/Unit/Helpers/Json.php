<?php

use Telegram\Bot\Exceptions\TelegramJsonException;
use Telegram\Bot\Helpers\Json;

it('can decode valid JSON', function () {
    $json = '{"foo":"bar","baz":{"qux":"quux"}}';
    $expected = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];

    expect(Json::decode($json))->toBe($expected);
});

it('throws an exception when decoding invalid JSON', function () {
    $json = '{"foo":"bar","baz":{"qux":"quux"';
    $expectedMessage = 'Syntax error';

    try {
        Json::decode($json);
    } catch (TelegramJsonException $e) {
        expect($e->getMessage())->toContain($expectedMessage)
            ->and($e->getCode())->toBe(JSON_ERROR_SYNTAX);
    }
});

it('can encode a value to JSON', function () {
    $value = ['foo' => 'bar', 'baz' => ['qux' => 'quux']];
    $expected = '{"foo":"bar","baz":{"qux":"quux"}}';

    expect(Json::encode($value))->toBe($expected);
});

it('throws an exception when encoding an invalid value', function () {
    $value = fopen('php://stdin', 'rb');
    $expectedMessage = 'Type is not supported';

    try {
        Json::encode($value);
    } catch (TelegramJsonException $e) {
        expect($e->getMessage())->toContain($expectedMessage)
            ->and($e->getCode())->toBe(JSON_ERROR_UNSUPPORTED_TYPE);
    }
});
