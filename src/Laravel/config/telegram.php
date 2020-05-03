<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Bot Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the bots below you wish to use as
    | your default bot for regular use. Of course, you may use many
    | bots at once using the manager class.
    |
    */

    'use' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Your Telegram Bots
    |--------------------------------------------------------------------------
    |
    | You may use multiple bots at once using the manager class. Each bot
    | that you own should be configured here.
    |
    | Here are each of the telegram bots config parameters.
    |
    | Supported Params:
    |
    | - name: The *personal* name you would like to refer to your bot as.
    |
    |       - username: Your Telegram Bot's Username.
    |                   Example: (string) 'BotFather'.
    |
    |       - token:    Your Telegram Bot's Access Token.
                        Refer for more details: https://core.telegram.org/bots#botfather
    |                   Example: (string) '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11'.
    |
    |       - commands: (Optional) Commands to register for this bot,
    |                   Supported Values: "Command Group Name", "Command Repository Name", "Command => Full Path to Class".
    |                   Default: Registers Global Commands.
    |                   Example: (array) [
    |                       'admin', // Command Group Name.
    |                       'status', // Command Repository Name.
    |                       'hello' => Acme\Project\Commands\HelloCommand::class,
    |                       'bye'   => Acme\Project\Commands\ByeCommand::class,
    |                   ]
    */

    'bots' => [
        'default' => [
            'username' => 'TelegramBot',
            'token'    => env('TELEGRAM_BOT_TOKEN', 'YOUR-BOT-TOKEN'),

            'commands' => [
//                'start' => Acme\Bots\TelegramBot\Commands\Start::class,
            ],

            'listen' => [
                'update.received'             => [],

                // (Optional).
                // If you would like to process specific types of updates you may
                // define the processing class for each type here.
                'update.message'              => [],
                'update.edited_message'       => [],
                'update.channel_post'         => [],
                'update.edited_channel_post'  => [],
                'update.inline_query'         => [],
                'update.chosen_inline_result' => [],
                'update.callback_query'       => [],
                'update.shipping_query'       => [],
                'update.pre_checkout_query'   => [],
                'update.poll'                 => [],
                'update.poll_answer'          => [],
            ],
        ],

        'second' => [
            'username' => 'MySecondBot',
            'token'    => '123456:abc',

            // Custom config used with the "telegram:webhook-setup" artisan command.
            'webhook'  => [
                'url'             => null,
                'certificate'     => null,
                'max_connections' => 40,
                'allowed_updates' => [],
            ],

            'commands' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook [Optional]
    |--------------------------------------------------------------------------
    |
    | Domain: If you want to set a custom domain for your webhook.
    | Path: Path is used to construct a webhook route. Default: /telegram
    | Controller: Responsible to listen to updates and acknowledge to Telegram.
    |
    | Example path: telegram
    | Webhook path: /telegram/{token}/{bot}
    |
    */

    'webhook' => [
        'domain'     => env('TELEGRAM_WEBHOOK_DOMAIN', null),
        'path'       => env('TELEGRAM_WEBHOOK_PATH', 'telegram'),
        'controller' => \Telegram\Bot\Laravel\Http\Controllers\WebhookController::class,
    ],


    /*
    |--------------------------------------------------------------------------
    | Asynchronous Requests [Optional]
    |--------------------------------------------------------------------------
    |
    | When set to True, All the requests would be made non-blocking (Async).
    |
    | Default: false
    | Possible Values: (Boolean) "true" OR "false"
    |
    */

    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Handler [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use a custom HTTP Client Handler.
    | Should be an instance of \Telegram\Bot\Http\HttpClientInterface
    |
    | Default: GuzzlePHP
    |
    */

    'http_client_handler' => \Telegram\Bot\Http\GuzzleHttpClient::class,

    /*
    |--------------------------------------------------------------------------
    | Register Global Commands [Optional]
    |--------------------------------------------------------------------------
    |
    | If you'd like to use the SDK's built in command handler system,
    | You can register all the global commands here.
    |
    | Global commands will apply to all the bots in system and are always active.
    |
    | The command class should extend the \Telegram\Bot\Commands\Command class.
    |
    | Default: The SDK registers, a help command which when a user sends /help
    | will respond with a list of available commands and description.
    |
    */

    'commands' => [
        'help' => Telegram\Bot\Commands\HelpCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Command Groups [Optional]
    |--------------------------------------------------------------------------
    |
    | You can organize a set of commands into groups which can later,
    | be re-used across all your bots.
    |
    | You can create [4] types of groups!
    |
    | 1. Group using full path to command classes.
    |
    | 2. Group using command repository: Provide the key name of the command from the command repository
    | and the system will automatically resolve to the appropriate command.
    |
    | 3. Group using other groups of commands: You can create a group which uses other
    | groups of commands to bundle them into one group.
    |
    | 4. You can create a group with a combination of 1, 2 and 3 all together in one group.
    |
    | Examples shown below are by the group type for you to understand each of them.
    */

    'command_groups' => [
        /* // Group Type: 1
           'commmon' => [
                'ping' => Acme\Project\Commands\PingCommand::class,
                'task' => Acme\Project\Commands\TaskCommand::class,
           ],
        */

        /* // Group Type: 2
           'subscription' => [
                'start', // Shared Command Name.
                'stop', // Shared Command Name.
           ],
        */

        /* // Group Type: 3
            'auth' => [
                'login' => Acme\Project\Commands\LoginCommand::class,
                'some' => Acme\Project\Commands\SomeCommand::class,
            ],

            'stats' => [
                'user_stats' => Acme\Project\Commands\UserStatsCommand::class,
                'subscriber_stats' => Acme\Project\Commands\SubscriberStatsCommand::class,
                'reports' => Acme\Project\Commands\ReportsCommand::class,
            ],

            'admin' => [
                'auth', // Command Group Name.
                'stats' // Command Group Name.
            ],
        */

        /* // Group Type: 4
           'myBot' => [
                'admin', // Command Group Name.
                'subscription', // Command Group Name.
                'status', // Shared Command Name.
                'heartbeat' => Acme\Project\Commands\Heartbeat::class, // Full Path to Command Class.
           ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Command Repository [Optional]
    |--------------------------------------------------------------------------
    |
    | Command Repository lets you register commands that can be shared between,
    | one or more bots across the project.
    |
    | This will help you prevent from having to register same set of commands,
    | for each bot over and over again and make it easier to maintain them.
    |
    | Command Repository are not active by default, You need to use the key name to register them,
    | individually in a group of commands or in bot commands.
    |
    | Think of this as a central storage, to register, reuse and maintain them across all bots.
    |
    */

    'command_repository' => [
        // 'start' => Acme\Project\Commands\StartCommand::class,
        // 'stop' => Acme\Project\Commands\StopCommand::class,
        // 'status' => Acme\Project\Commands\StatusCommand::class,
    ],
];
