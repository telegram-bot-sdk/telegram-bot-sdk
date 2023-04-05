<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Telegram\Bot\Bot;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasBot;

class CommandHandler
{
    use HasBot;

    /** @var CommandBus Telegram Command Bus */
    protected CommandBus $commandBus;

    /**
     * CommandHandler constructor.
     *
     *
     * @throws TelegramSDKException
     */
    public function __construct(Bot $bot)
    {
        $this->bot = $bot;

        $this->commandBus = new CommandBus($bot);
        $this->registerCommands();
    }

    /**
     * Return Command Bus.
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    /**
     * Set command bus.
     *
     *
     * @return static
     */
    public function setCommandBus(CommandBus $commandBus): self
    {
        $this->commandBus = $commandBus;

        return $this;
    }

    /**
     * Get all registered commands.
     */
    public function getCommands(): array
    {
        return $this->commandBus->getCommands();
    }

    /**
     * Check update object for a command and process.
     */
    public function processCommand(Update $update): Update
    {
        return $this->commandBus->handler($update);
    }

    /**
     * Register the commands.
     *
     * @throws TelegramSDKException
     */
    protected function registerCommands(): void
    {
        $commands = $this->buildCommandsList();

        // Register Commands
        $this->commandBus->addCommands($commands);
    }

    /**
     * Builds the list of commands.
     *
     * @return array An array of commands which includes global, shared and bot specific commands.
     *
     * @throws TelegramSDKException
     */
    protected function buildCommandsList(): array
    {
        $commands = $this->bot->config('commands', []);
        $allCommands = collect($this->bot->config('global.commands', []))->merge($this->parseCommands($commands));

        return $this->validate($allCommands);
    }

    /**
     * Validate that all commands are configured correctly in the config file
     *
     *
     * @throws TelegramSDKException
     */
    protected function validate(Collection $allCommands): array
    {
        $uniqueCommands = $allCommands->unique();

        // Any command without a name associated with it will force the unique list to have an index key of 0.
        if ($uniqueCommands->has(0)) {
            throw TelegramSDKException::commandNameNotSet($uniqueCommands->get(0));
        }

        // We cannot allow blank command names.
        if ($uniqueCommands->keys()->contains('')) {
            throw TelegramSDKException::commandNameNotSet($uniqueCommands->get(''));
        }

        return $allCommands->all();
    }

    /**
     * Parse an array of commands and build a list.
     */
    protected function parseCommands(array $commands): array
    {
        $groups = $this->bot->config('global.command_groups');
        $repo = $this->bot->config('global.command_repository');

        return collect($commands)->flatMap(function ($command, $name) use ($groups, $repo): array {
            // If the command is a group, we'll parse through the group of commands
            // and resolve the full class name.
            if (isset($groups[$command])) {
                return $this->parseCommands($groups[$command]);
            }

            // If this command is actually a command from command repo, we'll extract the full
            // class name out of the command list now.
            if (isset($repo[$command])) {
                $name = $command;
                $command = $repo[$command];
            }

            return [$name => $command];
        })->all();
    }

    /**
     * Magic method to call command related method directly on the CommandBus
     *
     *
     * @return mixed|void
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->commandBus, $method)) {
            return $this->commandBus->{$method}(...$parameters);
        }
    }
}
