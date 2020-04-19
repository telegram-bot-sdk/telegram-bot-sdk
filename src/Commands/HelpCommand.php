<?php

namespace Telegram\Bot\Commands;

use Illuminate\Contracts\Container\BindingResolutionException;
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
     * @throws BindingResolutionException
     * @throws TelegramSDKException
     */
    public function handle()
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            /* @var Command $handler */
            $handler = $this->getTelegram()->getCommandBus()->resolveCommand($handler);
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('text'));
    }

    public function failed(array $arguments, Throwable $exception)
    {
        $this->replyWithMessage(['text' => "Sorry. Currently it is not possible to list all the commands."]);
    }
}
