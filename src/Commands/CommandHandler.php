<?php

namespace Telegram\Bot\Commands;

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
     * @param Bot $bot
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
     *
     * @return CommandBus
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    /**
     * Set command bus.
     *
     * @param CommandBus $commandBus
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
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commandBus->getCommands();
    }

    /**
     * Check update object for a command and process.
     *
     * @param Update $update
     *
     * @return Update
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
     * @throws TelegramSDKException
     *
     * @return array An array of commands which includes global, shared and bot specific commands.
     */
    protected function buildCommandsList(): array
    {
        $commands = $this->bot->config('commands', []);
        $unique = collect($this->bot->config('global.commands', []))->merge($this->parseCommands($commands))->unique();

        // Any command without a name associated with it will force the unique list to have an index key of 0.
        if ($unique->has(0)) {
            throw TelegramSDKException::commandNameNotSet($unique->get(0));
        }

        return $unique->all();
    }

    /**
     * Parse an array of commands and build a list.
     *
     * @param array $commands
     *
     * @return array
     */
    protected function parseCommands(array $commands): array
    {
        $groups = $this->bot->config('global.command_groups');
        $repo = $this->bot->config('global.command_repository');

        return collect($commands)->flatMap(function ($command, $name) use ($groups, $repo) {
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
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->commandBus, $method)) {
            return $this->commandBus->{$method}(...$parameters);
        }
    }
}
