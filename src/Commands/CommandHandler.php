<?php

namespace Telegram\Bot\Commands;

use ReflectionClass;
use Telegram\Bot\Bot;
use ReflectionMethod;
use Telegram\Bot\Traits\HasBot;
use Illuminate\Support\Collection;
use Telegram\Bot\Traits\ForwardsCalls;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Commands\Attributes\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;

final class CommandHandler
{
    use ForwardsCalls;
    use HasBot;

    /** @var CommandBus Telegram Command Bus */
    private CommandBus $commandBus;

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
     * Register the commands.
     *
     * @throws TelegramSDKException
     */
    private function registerCommands(): void
    {
        $commands = $this->buildCommandsList();

        // Register Commands
        $this->commandBus->addCommands($commands);
    }

    /**
     * Builds the list of commands.
     *
     * @throws TelegramSDKException
     * @return array An array of commands which includes global, shared and bot specific commands.
     *
     */
    private function buildCommandsList(): array
    {
        $commands = $this->bot->config('commands', []);
        $allCommands = collect($this->bot->config('global.commands', []))->merge($this->parseCommands($commands));

        return $this->validate($allCommands);
    }

    /**
     * Parse an array of commands and build a list.
     */
    private function parseCommands(array $commands): array
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

            // If this is a multi-commands class, we'll parse through the class and
            // build the commands based on attributes.
            if (is_int($name)) {
                return $this->getAttributeCommands($command);
            }

            return [$name => $command];
        })->all();
    }

    private function getAttributeCommands(object|string $class): array
    {
        $commands = [];
        $reflectionClass = new ReflectionClass($class);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(Command::class);
            foreach ($attributes as $attribute) {
                $command = $attribute->newInstance();
                $commandName = $method->getName();
                $commandDescription = $command->description;

                $commands[$commandName] = $this->makeAttributeCommand(
                    $commandName,
                    $commandDescription,
                    $class,
                    $commandName
                );

                foreach ($command->aliases as $commandAlias) {
                    $commands[$commandAlias] = $this->makeAttributeCommand(
                        $commandAlias,
                        $commandDescription,
                        $class,
                        $commandName
                    );
                }
            }
        }

        return $commands;
    }

    private function makeAttributeCommand(
        string $name,
        string $description,
        object|string $class,
        string $method
    ): AttributeCommand {
        return (new AttributeCommand())
            ->setName($name)
            ->setDescription($description)
            ->setAttributeCaller($class, $method);
    }

    /**
     * Validate that all commands are configured correctly in the config file
     *
     *
     * @throws TelegramSDKException
     */
    private function validate(Collection $allCommands): array
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
     * Return Command Bus.
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    /**
     * Set command bus.
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
    public function processCommand(ResponseObject $update): ResponseObject
    {
        return $this->commandBus->handler($update);
    }

    /**
     * Magic method to call command related method directly on the CommandBus
     *
     *
     * @return mixed|void
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->commandBus, $method, $parameters);
    }
}
