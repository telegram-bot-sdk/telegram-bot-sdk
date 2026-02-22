<?php

namespace Tests\Unit;

use Faker\Factory as Faker;
use Faker\Generator;
use Telegram\Bot\Testing\Payloads\Provider\TelegramFakerProvider;

/** @return Generator&TelegramFakerProvider */
function getFakerGenerator(?int $seed = null): Generator
{
    $faker = Faker::create();
    if ($seed !== null) {
        $faker->seed($seed);
    }
    $faker->addProvider(new TelegramFakerProvider($faker));

    return $faker;
}

// --- Tests for TelegramFakerProvider ---
describe('TelegramFakerProvider', function () {
    it('generates numeric IDs of correct length', function () {
        $faker = getFakerGenerator(123);
        $id = $faker->id(5);
        expect($id)->toBeInt()
            ->and(strlen((string) $id))->toBe(5);

        $id = $faker->id(14);
        expect(strlen((string) $id))->toBe(14);
    });

    it('generates file IDs with correct length and type', function () {
        $faker = getFakerGenerator(456);
        $fileId = $faker->fileId(30);
        expect($fileId)->toBeString()->toHaveLength(30)
            ->and(preg_match('/^[a-zA-Z0-9]+$/', $fileId))->toBe(1);

        $fileUniqueId = $faker->fileId(16);
        expect($fileUniqueId)->toBeString()->toHaveLength(16);
    });

    it('generates a valid Unix timestamp', function () {
        $faker = getFakerGenerator(789);
        $timestamp = $faker->unixTime();
        expect($timestamp)->toBeInt()
            ->toBeGreaterThan(0)
            ->toBeLessThan(time() + 100);
    });

    it('generates command entities correctly for simple commands', function () {
        $faker = getFakerGenerator(1);
        $entities = $faker->commandEntities('/start');
        expect($entities)->toBeArray()->toHaveCount(1)
            ->and($entities[0])->toMatchArray([
                'offset' => 0,
                'length' => 6,
                'type' => 'bot_command',
            ]);

        $entities = $faker->commandEntities('/help arg1 arg2');
        expect($entities[0])->toMatchArray([
            'offset' => 0,
            'length' => 5,
            'type' => 'bot_command',
        ]);
    });

    it('generates command entities correctly for commands with bot username', function () {
        $faker = getFakerGenerator(2);
        $entities = $faker->commandEntities('/testcommand@mybot');
        expect($entities[0])->toMatchArray([
            'offset' => 0,
            'length' => 18,
            'type' => 'bot_command',
        ]);

        $entities = $faker->commandEntities('/testcommand@mybot with arguments');
        expect($entities[0])->toMatchArray([
            'offset' => 0,
            'length' => 18,
            'type' => 'bot_command',
        ]);
    });

    it('generates empty entities for non-command text', function () {
        $faker = getFakerGenerator();
        $entities = $faker->commandEntities('hello world');
        expect($entities)->toBeArray()->toBeEmpty();
    });

    it('generates valid from user data', function () {
        $faker = getFakerGenerator(555);
        $from = $faker->from();
        expect($from)->toBeArray()
            ->and($from['id'])->toBeInt()
            ->and($from['is_bot'])->toBeFalse()
            ->and($from['first_name'])->toBeString()
            ->and($from['last_name'])->toBeString()
            ->and($from['username'])->toBeString()
            ->and($from['language_code'])->toBeString();
    });

    it('generates valid chat data', function () {
        $faker = getFakerGenerator(666);
        $chat = $faker->chat();
        expect($chat)->toBeArray()
            ->and($chat['id'])->toBeInt()
            ->and($chat['first_name'])->toBeString()
            ->and($chat['last_name'])->toBeString()
            ->and($chat['username'])->toBeString()
            ->and($chat['type'])->toBe('private');
    });

    it('generates valid bot from data', function () {
        $faker = getFakerGenerator(777);
        $botFrom = $faker->botFrom();
        expect($botFrom)->toBeArray()
            ->and($botFrom['id'])->toBeInt()
            ->and($botFrom['is_bot'])->toBeTrue()
            ->and($botFrom['first_name'])->toBeString()
            ->and($botFrom['username'])->toBeString();
    });

    it('generates valid mime types', function () {
        $faker = getFakerGenerator(888);
        $mimeType = $faker->mimeType();
        expect($mimeType)->toBeString()
            ->and($mimeType)->toContain('/'); // MIME types contain a slash
    });
});
