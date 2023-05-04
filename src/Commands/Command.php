<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\HasBot;
use Telegram\Bot\Traits\HasUpdate;
use Throwable;

/**
 * Class Command.
 */
abstract class Command implements CommandInterface
{
    use HasBot;
    use HasUpdate;

    /** @var string The Telegram command name. */
    protected string $name;

    /** @var string The Telegram command description. */
    protected string $description;

    /** @var array Holds parsed command arguments */
    protected array $arguments = [];

    /** @var array Arguments that are required but have not been provided by the user */
    protected array $argumentsNotProvided = [];

    protected CommandBus $commandBus;

    /**
     * Get the name used for this command
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name used for this command
     *
     *
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Description.
     *
     * The Telegram command description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     *
     *
     * @return static
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Determine if given argument is provided.
     */
    public function hasArgument(string $argument): bool
    {
        return array_key_exists($argument, $this->arguments);
    }

    /**
     * Get Arguments Description.
     *
     * Get Command Arguments.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set Command Arguments.
     *
     *
     * @return static
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Get arguments that have not been provided.
     */
    public function getArgumentsNotProvided(): array
    {
        return $this->argumentsNotProvided;
    }

    /**
     * Set arguments that have not been provided.
     *
     *
     * @return static
     */
    public function setArgumentsNotProvided(array $arguments): self
    {
        $this->argumentsNotProvided = $arguments;

        return $this;
    }

    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    public function setCommandBus(CommandBus $commandBus): self
    {
        $this->commandBus = $commandBus;

        return $this;
    }

    /**
     * Triggered on failure to find params in command.
     */
    public function failed(array $arguments, Throwable $exception): void
    {
    }

    /**
     * Helper to Trigger other Commands.
     *
     * @param  string|CommandInterface  $command
     * @param  array  $params
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     * @noinspection PhpUnused
     */
    protected function triggerCommand(CommandInterface|string $command, array $params = []): void
    {
        $this->commandBus->execute($command, $this->update, $params, true);
    }
}
