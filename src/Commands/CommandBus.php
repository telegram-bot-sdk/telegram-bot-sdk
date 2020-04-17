<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionParameter;
use Telegram\Bot\Answers\AnswerBus;
use Telegram\Bot\Api;
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

        return Parser::between(substr($text, $offset, $length), '/', '@');
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
     * @param CommandInterface|string $name
     * @param Update                  $update
     * @param array                   $entity
     *
     * @throws TelegramSDKException
     * @return mixed
     */
    public function execute($name, Update $update, array $entity)
    {
        $command = $this->commands[$name] ?? $name;

        if ($command === null) {
            return false;
        }

        return $this->callCommand($command, $update, $entity);
    }

    /**
     * @param CommandInterface|string $command
     * @param Update                  $update
     * @param array                   $entity
     *
     * @throws TelegramSDKException|\ReflectionException
     * @return mixed
     */
    protected function callCommand($command, Update $update, array $entity)
    {
        $command = $this->resolveCommand($command);

        $arguments = Parser::parse($command)->setUpdate($update)->setEntity($entity)->parseCommandArguments();

        $command->setTelegram($this->telegram)->setUpdate($update)->setEntity($entity)->setArguments($arguments);

        try {
            return $this->telegram->getContainer()->call([$command, 'handle'], $arguments);
        } catch (\Throwable $e) {
            if (method_exists($command, 'failed')) {
                $params = $this->findArgumentsNotProvided($command, $arguments);

                $command->setArgumentsNotProvided($params)->failed($params, $e);
            }
        }
    }

    /**
     * Resolve given command with IoC container.
     *
     * @param CommandInterface|string|object $command
     *
     * @throws TelegramSDKException
     * @return object
     */
    protected function resolveCommand($command)
    {
        if (is_object($command)) {
            return $this->validateCommandClassInstance($command);
        }

        if (!class_exists($command)) {
            throw TelegramSDKException::commandClassDoesNotExist($command);
        }

        $command = $this->telegram->getContainer()->make($command);

        return $this->validateCommandClassInstance($command);
    }

    /**
     * Find arguments that are required but have not been provided.
     *
     * @param CommandInterface $command
     * @param array            $arguments
     *
     * @throws \ReflectionException
     * @return array
     */
    private function findArgumentsNotProvided(CommandInterface $command, $arguments): array
    {
        $reflection = new ReflectionMethod($command, 'handle');

        return collect($reflection->getParameters())
            ->reject(fn (ReflectionParameter $param) => $param->isOptional())
            ->whereNotIn('name', array_keys($arguments))
            ->pluck('name')
            ->all();
    }

    /**
     * Validate Command Class Instance.
     *
     * @param object $command
     *
     * @throws TelegramSDKException
     * @return CommandInterface
     */
    protected function validateCommandClassInstance(object $command): CommandInterface
    {
        if ($command instanceof CommandInterface) {
            return $command;
        }

        throw TelegramSDKException::commandClassNotValid($command);
    }
}
