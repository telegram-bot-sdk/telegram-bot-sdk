<?php

namespace Telegram\Bot\Laravel\Console\Webhook;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Telegram\Bot\Bot;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ConsoleBaseCommand extends Command
{
    protected BotsManager $botsManager;

    public function __construct(BotsManager $botsManager)
    {
        parent::__construct();

        $this->botsManager = $botsManager;
    }

    /**
     * @throws TelegramSDKException
     */
    public function bot(): Bot
    {
        return $this->botsManager->bot($this->argument('bot'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['bot', InputArgument::OPTIONAL, 'The bot name defined in config'],
        ];
    }
}
