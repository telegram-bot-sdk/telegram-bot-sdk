<?php

namespace Telegram\Bot\Commands;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Telegram\Bot\Answers\AnswerBus;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

/**
 * Class CommandBus.
 */
class CommandBus extends AnswerBus
{
    /**
     * @var Command[] Holds all commands.
     */
    protected array $commands = [];

    /**
     * Instantiate Command Bus.
     *
     * @param Api|null $telegram
     */
    public function __construct(Api $telegram = null)
    {
        $this->telegram = $telegram;
    }

    /**
     * Returns the list of commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Add a list of commands.
     *
     * @param array $commands
     *
     * @return $this
     */
    public function addCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * Add a command to the commands list.
     *
     * @param string                  $command      Command name.
     * @param CommandInterface|string $commandClass Either an object or full path to the command class.
     *
     * @return $this
     */
    public function addCommand(string $command, $commandClass): self
    {
        $this->commands[$command] = $commandClass;

        return $this;
    }

    /**
     * Remove a command from the list.
     *
     * @param string $name Command name.
     *
     * @return $this
     */
    public function removeCommand(string $name): self
    {
        unset($this->commands[$name]);

        return $this;
    }

    /**
     * Removes a list of commands.
     *
     * @param array $names
     *
     * @return $this
     */
    public function removeCommands(array $names): self
    {
        foreach ($names as $name) {
            $this->removeCommand($name);
        }

        return $this;
    }

    /**
     * Parse a Command for a Match.
     *
     * @param $text
     * @param $offset
     * @param $length
     *
     * @return string
     */
    public function parseCommand($text, $offset, $length): string
    {
        if (trim($text) === '') {
            throw new InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        return Parser::between(mb_substr($text, $offset, $length, 'UTF-8'), '/', '@');
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param $update
     *
     * @return Update
     */
    protected function handler(Update $update): Update
    {
        $message = $update->getMessage();

        if ($message->has('entities')) {
            $this->parseCommandsIn($message)->each(fn (array $botCommand) => $this->process($botCommand, $update));
        }

        return $update;
    }

    /**
     * Returns all bot_commands detected in the update.
     *
     * @param $message
     *
     * @return Collection
     */
    protected function parseCommandsIn(Collection $message): Collection
    {
        return collect($message->get('entities'))
            ->filter(fn ($entity) => $entity['type'] === 'bot_command');
    }

    /**
     * Execute a bot command from the update text.
     *
     * @param array  $entity
     * @param Update $update
     *
     * @throws TelegramSDKException
     */
    protected function process($entity, Update $update): void
    {
        $command = $this->parseCommand(
            $update->getMessage()->text,
            $entity['offset'],
            $entity['length']
        );

        $this->execute($command, $update, $entity);
    }

    /**
     * Execute the command.
     *
     * @param CommandInterface|string $command
     * @param Update                  $update
     * @param array                   $entity
     * @param bool                    $isTriggered
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     * @return void
     */
    public function execute($command, Update $update, array $entity, bool $isTriggered = false): void
    {
        $command = $this->resolveCommand($command);

        $parser = Parser::parse($command)->setUpdate($update);

        if ($isTriggered) {
            $arguments = $entity;
        } else {
            $parser->setEntity($entity);
            $arguments = $parser->arguments();
        }

        $command->setTelegram($this->telegram)->setUpdate($update)->setArguments($arguments);

        $requiredParamsNotProvided = $parser->requiredParamsNotProvided(array_keys($arguments));

        try {
            if ($requiredParamsNotProvided->isNotEmpty()) {
                throw TelegramCommandException::requiredParamsNotProvided($requiredParamsNotProvided);
            }

            $this->telegram->getContainer()->call([$command, 'handle'], $arguments);
        } catch (BindingResolutionException|TelegramCommandException $e) {
            if (method_exists($command, 'failed')) {
                $params = $requiredParamsNotProvided->all();

                $command->setArgumentsNotProvided($params)->failed($params, $e);
            }
        }
    }

    /**
     * Resolve given command with IoC container.
     *
     * @param CommandInterface|string|object $command
     *
     * @throws TelegramCommandException
     * @return CommandInterface
     */
    protected function resolveCommand($command): CommandInterface
    {
        if (is_object($command)) {
            return $this->validateCommandClassInstance($command);
        }

        $command = $this->commands[$command] ?? $command;

        if (!class_exists($command)) {
            throw TelegramCommandException::commandClassDoesNotExist($command);
        }

        try {
            $command = $this->telegram->getContainer()->make($command);
        } catch (BindingResolutionException $e) {
            throw TelegramCommandException::commandNotInstantiable($command, $e);
        }

        return $this->validateCommandClassInstance($command);
    }

    /**
     * Validate Command Class Instance.
     *
     * @param object $command
     *
     * @throws TelegramCommandException
     * @return CommandInterface
     */
    protected function validateCommandClassInstance(object $command): CommandInterface
    {
        if ($command instanceof CommandInterface) {
            return $command;
        }

        throw TelegramCommandException::commandClassNotValid($command);
    }
}
