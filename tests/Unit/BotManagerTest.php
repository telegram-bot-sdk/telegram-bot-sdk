<?php

use Telegram\Bot\Bot;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

it('returns the correct default bot name', function () {
    $config = ['use' => 'test_bot'];
    $manager = new BotManager($config);

    expect($manager->getDefaultBotName())->toBe('test_bot');
});

it('can set a default bot name', function () {
    $config = [
        'use' => 'test_bot',
        'bots' => [
            'new_bot' => [
                'token' => 123,
            ],
        ],
    ];
    $manager = new BotManager($config);
    $manager->setDefaultBotName('new_bot');

    expect($manager->getDefaultBotName())->toBe('new_bot');
});

it('throws an exception if a bot does not have any config settings', function () {
    $config = [
        'use' => 'test_bot',
        'bots' => [],
    ];
    $manager = new BotManager($config);
    $manager->setDefaultBotName('new_bot');
})
    ->expectException(TelegramSDKException::class);

it('allows a bot to reconnect', function () {
    $config = [
        'use' => 'test_bot',
        'bots' => [
            'test_bot' => [
                'token' => 123,
            ],
        ],
    ];

    $manager = new BotManager($config);
    $bot = $manager->reconnect('test_bot');

    expect($bot)->toBeInstanceOf(Bot::class)
        ->and($bot->getName())->toBe('test_bot');

    expect($manager->getDefaultBotName())->toBe('test_bot');
});

it('can disconnect a bot', function () {
    $config = [
        'use' => 'test_bot',
        'bots' => [
            'test_bot' => [
                'token' => 123,
            ],
        ],
    ];

    $manager = new BotManager($config);
    $manager->reconnect('test_bot');
    expect($manager->getBots())->toHaveKey('test_bot');

    $manager->disconnect('test_bot');
    expect($manager->getBots())->not()->toHaveKey('test_bot');
});

it('can get a bot config', function () {
    $config = [
        'use' => 'test_bot',
        'bots' => [
            'test_bot' => [
                'token' => 123,
            ],
        ],
    ];

    $manager = new BotManager($config);
    expect($manager->getBotConfig())->toMatchArray(
        [
            'token' => 123,
            'bot' => 'test_bot',
            'global' => [
                'use' => 'test_bot',
                'bots' => [
                    'test_bot' => ['token' => 123],
                ],
            ],
        ]);
});
