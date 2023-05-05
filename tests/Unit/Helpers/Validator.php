<?php

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\ResponseObject;

it('can determine if a string is a file id', function () {
    $object = new InputFile('https://example.com');
    expect(Validator::isFileId('12345678901234567890'))->toBeTrue()
        ->and(Validator::isFileId('123'))->toBeFalse()
        ->and(Validator::isFileId('1234567890123456789'))->toBeFalse()
        ->and(Validator::isFileId('https://example.com'))->toBeFalse()
        ->and(Validator::isFileId(12345678901234567890))->toBeFalse()
        ->and(Validator::isFileId('1234567890-1234567890'))->toBeTrue()
        ->and(Validator::isFileId('1234567890_1234567890'))->toBeTrue()
        ->and(Validator::isFileId('1234567890-1234567890_1234567890'))->toBeTrue()
        ->and(Validator::isFileId($object))->toBeFalse();
});

it('can determine if a string is a URL', function () {
    expect(Validator::isUrl('https://example.com'))->toBeTrue()
        ->and(Validator::isUrl('http://example.com'))->toBeTrue()
        ->and(Validator::isUrl('ftp://example.com'))->toBeTrue()
        ->and(Validator::isUrl('example.com'))->toBeFalse()
        ->and(Validator::isUrl(''))->toBeFalse();
});

it('can determine if a string is a JSON object', function () {
    expect(Validator::isJson('{"foo": "bar"}'))->toBeTrue()
        ->and(Validator::isJson('{"foo": "bar",}'))->toBeFalse()
        ->and(Validator::isJson('{"foo": "bar", "baz": {"qux": 123}}'))->toBeTrue()
        ->and(Validator::isJson('{"foo": "bar", "baz": {"qux": 123}'))->toBeFalse()
        ->and(Validator::isJson(''))->toBeFalse();
});

it('can determine if an object is an instance of InputFile', function () {
    $inputFile = new InputFile('file contents', 'filename.txt');
    expect(Validator::isInputFile($inputFile))->toBeTrue()
        ->and(Validator::isInputFile('not an input file'))->toBeFalse();
});

it('can determine if an object is Jsonable', function () {
    $jsonable = new class implements \Telegram\Bot\Contracts\Jsonable
    {
        public function __toJson($options = 0): string
        {
            return '{"foo": "bar"}';
        }
    };

    expect(Validator::isJsonable($jsonable))->toBeTrue()
        ->and(Validator::isJsonable('not a jsonable object'))->toBeFalse();
});

it('can determine if an object is Multipartable', function () {
    $multipartable = new class implements \Telegram\Bot\Contracts\Multipartable
    {
        public function __toMultipart(): array
        {
            return ['foo' => 'bar'];
        }
    };

    expect(Validator::isMultipartable($multipartable))->toBeTrue()
        ->and(Validator::isMultipartable('not a multipartable object'))->toBeFalse();
});

it('can determine if an update has a command entity', function () {
    $update = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => '/start',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 6,
                ],
            ],
        ],
    ]);
    expect(Validator::hasCommand($update))->toBeTrue();

    $update = new ResponseObject([
        'update_id' => 123,
        'message' => [
            'message_id' => 456,
            'text' => 'Hello, world!',
        ],
    ]);
    expect(Validator::hasCommand($update))->toBeFalse();
});
