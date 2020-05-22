<?php

namespace Telegram\Bot\Tests\Integration\Commands;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Bot;
use Telegram\Bot\Commands\CommandHandler;
use Telegram\Bot\Exceptions\TelegramSDKException;

class CommandHandlerTest extends TestCase
{
    protected CommandHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test noidea
     * @throws TelegramSDKException
     */
    public function noidea()
    {
        $handler = new CommandHandler(new Bot($this->config()));

        $handler->getCommands();
    }


    protected function config()
    {
        return [
            'use'                 => 'sdk',
            'bots'                => [
                'sdk' => [
                    'username' => 'sdktesting_bot',
                    'token'    => '123',
                    'commands' => [
                        'getdata' => \App\Telegram\Commands\GetData::class,
                        'image'   => \App\Telegram\Commands\Image::class,
                        'six'     => \App\Telegram\Commands\ExampleSix::class,
                        'commmon',
                    ],
                ],
            ],
            'async_requests'      => env('TELEGRAM_ASYNC_REQUESTS', false),
            'http_client_handler' => \Telegram\Bot\Http\GuzzleHttpClient::class,
            'commands'            => [
                'help' => Telegram\Bot\Commands\HelpCommand::class,
            ],
            'command_groups'      => [
                'commmon'      => [
                    'exampletwo'   => \App\Telegram\Commands\ExampleTwo::class,
                    'examplethree' => \App\Telegram\Commands\ExampleThree::class,
                    'examplefour'  => \App\Telegram\Commands\ExampleFour::class,
                ],
//                 Group Type: 2
                'subscription' => [
                    'start', // Shared Command Name.
                    'stop', // Shared Command Name.
                ],
//                 Group Type: 3
                'auth'         => [
                    'login' => Acme\Project\Commands\LoginCommand::class,
                    'some'  => Acme\Project\Commands\SomeCommand::class,
                ],
//                 Group Type: 4
                'myBot'        => [
                    'admin', // Command Group Name.
                    'subscription', // Command Group Name.
                    'status', // Shared Command Name.
                    'heartbeat' => Acme\Project\Commands\Heartbeat::class, // Full Path to Command Class.
                ],
            ],
            'command_repository'  => [
                // 'start' => Acme\Project\Commands\StartCommand::class,
                // 'stop' => Acme\Project\Commands\StopCommand::class,
                // 'status' => Acme\Project\Commands\StatusCommand::class,
            ],
        ];
    }
}
