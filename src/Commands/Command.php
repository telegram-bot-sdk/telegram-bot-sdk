<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Command.
 */
abstract class Command implements CommandInterface
{
    use Answerable;

    /** @var string The Telegram command description. */
    protected string $description;

    /** @var array Holds parsed command arguments */
    protected array $arguments = [];

    /** @var array Arguments that are required but have not been provided by the user */
    protected array $argumentsNotProvided = [];

    /**
     * Get Command Description.
     *
     * The Telegram command description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     *
     * @param $description
     *
     * @return Command
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Arguments Description.
     *
     * Get Command Arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set Command Arguments.
     *
     * @param array $arguments
     *
     * @return Command
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Set arguments that have not been provided.
     *
     * @param array $arguments
     *
     * @return $this
     */
    public function setArgumentsNotProvided(array $arguments): self
    {
        $this->argumentsNotProvided = $arguments;

        return $this;
    }

    /**
     * Get arguments that have not been provided.
     *
     * @return array
     */
    public function getArgumentsNotProvided(): array
    {
        return $this->argumentsNotProvided;
    }

    /**
     * Determine if given argument is provided.
     *
     * @param string $argument
     *
     * @return bool
     */
    public function hasArgument(string $argument): bool
    {
        return array_key_exists($argument, $this->arguments);
    }

    /**
     * Helper to Trigger other Commands.
     *
     * @param CommandInterface|string $command
     * @param array                   $params
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     * @return void
     */
    protected function triggerCommand($command, array $params = []): void
    {
        $this->telegram->getCommandBus()->execute($command, $this->update, $params, true);
    }
}
