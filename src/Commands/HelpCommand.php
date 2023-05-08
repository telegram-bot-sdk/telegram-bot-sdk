<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Helpers\Update;
use Throwable;

/**
 * Class HelpCommand.
 */
final class HelpCommand extends Command
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
        $handler = $this->bot->getCommandHandler();
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

    private function reply(string $text): void
    {
        $chat_id = Update::find($this->getUpdate())->chat()?->offsetGet('id');

        $this->bot->sendMessage(['chat_id' => $chat_id, 'text' => $text]);
    }
}
