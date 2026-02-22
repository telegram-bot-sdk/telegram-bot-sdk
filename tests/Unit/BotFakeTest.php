<?php

use PHPUnit\Framework\AssertionFailedError;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Fakes\ApiFake;
use Telegram\Bot\Testing\Fakes\BotFake;
use Telegram\Bot\Testing\Payloads\TelegramPayload;

class StartCommand extends Command
{
    protected string $name = 'start';

    protected string $description = 'Start command for testing';

    public function handle(): void
    {
        $this->getBot()->sendMessage([
            'chat_id' => $this->getUpdate()->message->chat->id,
            'text' => 'Welcome! Use /help to see available commands.',
        ]);
    }
}

class HelpCommand extends Command
{
    protected string $name = 'help';

    protected string $description = 'Help command for testing';

    public function handle(): void
    {
        $this->getBot()->sendMessage([
            'chat_id' => $this->getUpdate()->message->chat->id,
            'text' => "Available commands:\n/start - Get started\n/help - Show this help",
        ]);
    }
}

class EchoCommand extends Command
{
    protected string $name = 'echo';

    protected string $description = 'Echo back user input';

    public function handle($inputText = '{.+$}'): void
    {
        $message = $this->getUpdate()->message;

        $this->getBot()->sendMessage([
            'chat_id' => $message->chat->id,
            'text' => "You said: {$inputText}",
        ]);
    }
}

class PhotoCommand extends Command
{
    protected string $name = 'photo';

    protected string $description = 'Send a photo';

    public function handle(): void
    {
        $this->getBot()->sendPhoto([
            'chat_id' => $this->getUpdate()->message->chat->id,
            'photo' => 'https://example.com/photo.jpg',
            'caption' => 'Here is your requested photo!',
        ]);
    }
}

describe('BotFake Basic Functionality', function () {
    it('can be instantiated with no responses', function () {
        $bot = new BotFake;

        expect($bot)->toBeInstanceOf(BotFake::class)
            ->and($bot->getName())->toBe('fake');
    });

    it('can be instantiated with responses', function () {
        $responses = [
            ['ok' => true, 'result' => ['message_id' => 123]],
        ];

        $bot = new BotFake($responses);

        expect($bot)->toBeInstanceOf(BotFake::class)
            ->and($bot->getName())->toBe('fake');
    });

    it('can register commands fluently', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('help', HelpCommand::class);

        expect($bot)->toBeInstanceOf(BotFake::class);

        $commands = $bot->getCommandHandler()->getCommands();
        expect($commands)->toHaveKey('start')
            ->and($commands)->toHaveKey('help')
            ->and($commands)->toHaveCount(2);
    });
});

describe('BotFake Command Processing', function () {
    it('processes a simple start command', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->processUpdate(
                TelegramPayload::create()->commandMessage('start')->get()
            );

        $bot->assertMessageSent('Welcome! Use /help to see available commands.');
        $bot->assertSentTimes('sendMessage', 1);
        $bot->assertCommandProcessed('start');
    });

    it('processes commands with arguments', function () {
        $bot = (new BotFake)
            ->registerCommand('echo', EchoCommand::class)
            ->processUpdate(
                TelegramPayload::create()->commandMessage('echo', 'hello world')->get()
            );

        $bot->assertMessageContains('You said: hello world');
        $bot->assertSentTimes('sendMessage', 1);
        $bot->assertCommandProcessed('echo');
    });

    it('processes multiple commands in sequence', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('help', HelpCommand::class);

        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('help')->get());

        $bot->assertMessageSent('Welcome! Use /help to see available commands.');
        $bot->assertMessageContains('Available commands:');
        $bot->assertSentTimes('sendMessage', 2);
    });

    it('handles commands with payloads modified by magic withXYZ methods', function () {
        $chatId = '123456789';
        $userId = '987654321';

        /** @var ResponseObject $update */
        $update = TelegramPayload::create()->commandMessage('start')
            ->withMessage(['chat' => ['id' => $chatId]])
            ->withMessage(['from' => ['id' => $userId]])
            ->get();

        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->processUpdate($update);

        $bot->assertMessageSent('Welcome! Use /help to see available commands.', $chatId);
        // Magic methods should not replace an entire array and only the keys provided in their payload
        expect($update->toArray()['message']['chat'])->toHaveKeys(['first_name', 'type'])
            ->and($update->toArray()['message']['from'])->toHaveKeys(['is_bot', 'username']);
    });
});

describe('BotFake Error Handling', function () {
    it('handles unknown commands gracefully', function () {
        $bot = (new BotFake)
            ->processUpdate(TelegramPayload::create()->commandMessage('unknown')->get());

        $bot->assertNothingSent();
        $bot->assertCommandNotProcessed('unknown');
    });

    it('can process non-command messages', function () {
        $bot = (new BotFake)
            ->processUpdate(TelegramPayload::create()->textMessage('Just a regular message')->get());

        $bot->assertNothingSent();
        $bot->assertNoCommandsProcessed();
    });
});

describe('BotFake API Assertions', function () {
    it('can assert different types of API calls', function () {
        $bot = (new BotFake)
            ->registerCommand('photo', PhotoCommand::class)
            ->processUpdate(TelegramPayload::create()->commandMessage('photo')->get());

        $bot->assertSent('sendPhoto');
        $bot->assertSent('sendPhoto', function (array $params) {
            return $params['photo'] === 'https://example.com/photo.jpg'
                && str_contains($params['caption'], 'Here is your requested photo!');
        });
    });

    it('can assert using simple array constraints', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->processUpdate(
                TelegramPayload::create()->commandMessage('start')
                    ->withMessage(['chat' => ['id' => '987654321']])
                    ->get()
            );

        $bot->assertSent('sendMessage', [
            'chat_id' => '987654321',
            'text' => 'Welcome! Use /help to see available commands.',
        ]);
    });

    it('can assert methods were not sent', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->processUpdate(TelegramPayload::create()->commandMessage('start')->get());

        $bot->assertSent('sendMessage');
        $bot->assertNotSent('sendPhoto');
        $bot->assertNotSent('sendDocument');
    });

    it('can assert nothing was sent', function () {
        $bot = new BotFake;

        $bot->assertNothingSent();
    });

    it('can assert message count', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('help', HelpCommand::class);

        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('help')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());

        $bot->assertMessageSentCount(3);
        $bot->assertSentTimes('sendMessage', 3);
    });

    it('fails when failWhenEmpty set and no responses left', function () {
        $apiFake = new ApiFake([]);
        $apiFake->failWhenEmpty();

        $apiFake->fakeCall('sendMessage', []);
    })
        ->throws(Exception::class, 'No fake responses left');

    it('records multiple API calls in order', function () {
        $bot = new BotFake;

        $bot->sendMessage(['text' => 'msg1']);
        $bot->sendPhoto(['photo' => 'url1']);
        $bot->answerCallbackQuery(['callback_query_id' => 'abc']);

        $requests = $bot->getApi()->getRequests();
        $this->assertCount(3, $requests);
        $this->assertEquals('sendMessage', $requests[0]->method());
        $this->assertEquals('sendPhoto', $requests[1]->method());
        $this->assertEquals('answerCallbackQuery', $requests[2]->method());
    });

    it('assertSent fails gracefully on wrong constraints', function () {
        $bot = new BotFake;
        $bot->sendMessage(['text' => 'hello']);

        $this->expectException(AssertionFailedError::class);

        $bot->assertSent('sendPhoto');
    });
});

describe('BotFake Complex Scenarios', function () {
    it('records answerCallbackQuery call correctly', function () {
        $bot = new BotFake;

        $bot->answerCallbackQuery([
            'callback_query_id' => 'fake_callback_id',
            'text' => 'Button clicked!',
        ]);

        $bot->assertSent('answerCallbackQuery', ['text' => 'Button clicked!']);
    });

    it('can chain multiple operations fluently', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('help', HelpCommand::class)
            ->registerCommand('echo', EchoCommand::class)
            ->processUpdate(TelegramPayload::create()->commandMessage('start')->get())
            ->processUpdate(TelegramPayload::create()->commandMessage('help')->get())
            ->processUpdate(TelegramPayload::create()->commandMessage('echo', 'test')->get());

        $bot->assertSentTimes('sendMessage', 3);
        $bot->assertMessageContains('Welcome!');
        $bot->assertMessageContains('Available commands:');
        $bot->assertMessageContains('You said: test');
    });

    it('handles custom payload merging with new magic methods', function () {
        $customUserId = '999888777';
        $customChatId = '111222333';

        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->processUpdate(
                TelegramPayload::create()->commandMessage('start')
                    ->withMessage([
                        'from' => ['id' => $customUserId, 'first_name' => 'TestUser'],
                        'chat' => ['id' => $customChatId, 'type' => 'private'],
                    ])
                    ->get()
            );

        $bot->assertMessageSent('Welcome! Use /help to see available commands.', $customChatId);
    });

    it('demonstrates the improved fluent API', function () {
        $bot = (new BotFake)
            ->registerCommand('echo', EchoCommand::class);

        $bot->processUpdate(TelegramPayload::create()->commandMessage('echo', 'new way')->get());

        $bot->assertMessageContains('You said: new way');
    });

    it('works with invokable syntax in real scenarios', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class);

        $updateFactory = TelegramPayload::create()->commandMessage('start'); // Note no terminal method at end.
        $bot->processUpdate($updateFactory());

        $bot->assertMessageSent('Welcome! Use /help to see available commands.');
    });
});

describe('BotFake Command Recording', function () {
    it('records processed commands in processedCommands array', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('echo', EchoCommand::class);

        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('echo', 'hello world')->get());

        // Assert commands are recorded as handled internally
        $bot->assertCommandProcessed('start');
        $bot->assertCommandProcessed('echo', function ($args) {
            return isset($args['inputText']) && str_contains($args['inputText'], 'hello world');
        });
    });

    it('fails assertCommandProcessed assertion when command was not processed', function () {
        $bot = new BotFake;

        $bot->registerCommand('start', StartCommand::class);
        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());

        $this->expectException(AssertionFailedError::class);

        // 'echo' command never processed, should fail
        $bot->assertCommandProcessed('echo');
        $bot->assertNoCommandsProcessed();
    });

    it('records multiple processed commands and allows count assertions', function () {
        $bot = (new BotFake)
            ->registerCommand('start', StartCommand::class)
            ->registerCommand('help', HelpCommand::class);

        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('help')->get());
        $bot->processUpdate(TelegramPayload::create()->commandMessage('start')->get());

        $bot->assertCommandProcessed('start');
        $bot->assertCommandProcessed('help');

        // Check that start command was handled twice
        $startCommands = $bot->getProcessedCommands('start');
        $this->assertCount(2, $startCommands);
    });
});
