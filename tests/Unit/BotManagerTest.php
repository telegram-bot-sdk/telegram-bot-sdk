<?php

use Telegram\Bot\Bot;
use Telegram\Bot\BotManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

it('can create BotManager instance', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    expect($botManager)->toBeInstanceOf(BotManager::class);
});

it('can get all the created bots', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second'  => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    expect($botManager->getBots())->toHaveCount(0);

    $botManager->bot('default');

    expect($botManager->getBots())->toHaveCount(1);

    $botManager->bot('second');

    expect($botManager->getBots())->toHaveCount(2);
});

it('can get the default bot name', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    expect($botManager->getDefaultBotName())->toBe('default');
});

it('can set the default bot name', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second'  => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    $botManager->setDefaultBotName('second');

    expect($botManager->getDefaultBotName())->toBe('second');
});

it('can get a bot instance', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second'  => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    $defaultBot = $botManager->bot('default');
    $secondBot = $botManager->bot('second');

    expect($defaultBot)->toBeInstanceOf(Bot::class)
        ->and($secondBot)->toBeInstanceOf(Bot::class);
});

it('can reconnect to a bot', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second'  => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    $defaultBot = $botManager->bot('default');
    $secondBot = $botManager->bot('second');

    expect($defaultBot)->toBeInstanceOf(Bot::class)
        ->and($secondBot)->toBeInstanceOf(Bot::class);

    $newDefaultBot = $botManager->reconnect('default');
    $newSecondBot = $botManager->reconnect('second');

    expect($newDefaultBot)->toBeInstanceOf(Bot::class)
        ->and($newSecondBot)->toBeInstanceOf(Bot::class)
        ->and($newDefaultBot)->not->toBe($defaultBot)
        ->and($newSecondBot)->not->toBe($secondBot);
});

it('can disconnect from a bot', function () {
    $config = [
        'use' => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second' => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    $botManager->bot('default');
    $botManager->bot('second');

    expect($botManager->getBots())->toHaveCount(2);

    $botManager->disconnect('default');

    expect($botManager->getBots())->toHaveCount(1)
        ->and($botManager->getBots())->not->toHaveKey('default');
});

it('can get the configuration for a bot', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
            'second' => [
                'token' => 'your-second-bot-token',
            ],
        ],
    ];
    $botManager = new BotManager($config);

    $botConfig = $botManager->getBotConfig('second');

    expect($botConfig)->toBeArray()
        ->and($botConfig)->toHaveKey('bot')
        ->and($botConfig)->toHaveKey('global')
        ->and($botConfig)->toHaveKey('token')
        ->and($botConfig['bot'])->toBe('second')
        ->and($botConfig['token'])->toBe('your-second-bot-token');
});

it('can get the configuration for a specific bot', function () {
    $config = [
        'use'  => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
    ];
    $botManager = new BotManager($config);

    $botConfig = $botManager->getBotConfig();

    expect($botConfig)->toBeArray()
        ->and($botConfig)->toHaveKey('bot')
        ->and($botConfig)->toHaveKey('global');
});

it('throws an exception when getting the configuration for a non-configured bot', function () {
    $config = [
        'use' => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
    ];

    $this->expectExceptionMessage("Bot [non-existing-bot] not configured.");

    $botManager = new BotManager($config);
    $botManager->getBotConfig('non-existing-bot');
})->expectException(TelegramSDKException::class);

it('can forward method calls to the default bot', function () {
    $config = [
        'use' => 'default',
        'bots' => [
            'default' => [
                'token' => 'your-bot-token',
            ],
        ],
    ];

    $botManager = new BotManager($config);

    $result = $botManager->getName();

    expect($result)->toBe('default');
});
