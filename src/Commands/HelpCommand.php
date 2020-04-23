<?php

namespace Telegram\Bot\Commands;

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
     * @throws TelegramSDKException
     */
    public function handle(): void
    {
        $commands = $this->api->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            /* @var Command $handler */
            $handler = $this->getApi()->getCommandBus()->resolveCommand($handler);
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('text'));
    }

    public function failed(array $arguments, Throwable $exception): void
    {
        $this->replyWithMessage(['text' => 'Sorry. Currently it is not possible to list all the commands.']);
    }
}
