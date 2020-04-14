<?php

namespace Telegram\Bot\Commands;

/**
 * Class HelpCommand.
 */
class HelpCommand extends Command
{
    /** @var string Command Description */
    protected string $description = 'Help command, Get a list of commands';

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            /* @var Command $handler */
            $handler = $this->getCommandBus()->resolveCommand($handler);
            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('text'));
    }
}
