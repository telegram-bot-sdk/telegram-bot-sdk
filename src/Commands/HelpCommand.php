<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;

/**
 * Class HelpCommand.
 */
class HelpCommand extends Command
{
    /** @var string Command Description */
    protected string $description = 'Help command, Get a list of commands';

    /**
     * Handle command.
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     */
    public function handle(): void
    {
        $handler = new CommandHandler($this->bot);
        $commands = $handler->getCommands();

        $text = '';
        foreach ($commands as $name => $command) {
            /* @var Command $command */
            $command = $handler->getCommandBus()->resolveCommand($command);
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $command->getDescription());
        }

        $this->reply($text);
    }

    public function failed(array $arguments, Throwable $exception): void
    {
        $this->reply('Sorry. Currently it is not possible to list all the commands.');
    }

    /**
     * Reply helper.
     *
     *
     * @throws TelegramSDKException
     */
    protected function reply(string $text): void
    {
        $chat_id = $this->getUpdate()->getMessage()->chat->id;

        $this->bot->sendMessage(['chat_id' => $chat_id, 'text' => $text]);
    }
}
