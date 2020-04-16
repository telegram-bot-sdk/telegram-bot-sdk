<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Answers\Answerable;

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

    /** @var array|null Details of the current entity this command is responding to - offset, length, type etc */
    protected ?array $entity;

    /** @var array Arguments that are required but have not been provided by the user */
    protected array $argumentsNotProvided;

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
     * @param array $entity
     *
     * @return $this
     */
    public function setEntity(array $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getEntity(): ?array
    {
        return $this->entity;
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
     * @param string $command
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @return mixed
     */
    protected function triggerCommand(string $command)
    {
        return $this->telegram->getCommandBus()->execute($command, $this->update, $this->entity);
    }
}
