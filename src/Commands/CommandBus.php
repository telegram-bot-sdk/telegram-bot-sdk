<?php

namespace Telegram\Bot\Commands;

use BadMethodCallException;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Telegram\Bot\Bot;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\MessageEntity;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasBot;

/**
 * Class CommandBus.
 */
class CommandBus
{
    use HasBot;

    /** @var Command[] Holds all commands. */
    protected array $commands = [];

    /**
     * Instantiate Command Bus.
     *
     * @param Bot|null $bot
     */
    public function __construct(Bot $bot = null)
    {
        $this->bot = $bot;
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
        if (blank($text)) {
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
    public function handler(Update $update): Update
    {
        if (Entity::hasCommand($update)) {
            Entity::from($update)->commandEntities()
                ->each(fn (MessageEntity $entity) => $this->process($update, $entity));
        }

        return $update;
    }

    /**
     * Execute a bot command from the update text.
     *
     * @param Update        $update
     * @param MessageEntity $entity
     *
     * @throws TelegramSDKException
     */
    protected function process(Update $update, MessageEntity $entity): void
    {
        $command = $this->parseCommand(
            Entity::from($update)->text(),
            $entity->offset,
            $entity->length
        );

        $this->execute($command, $update, $entity);
    }

    /**
     * Execute the command.
     *
     * @param CommandInterface|string $command
     * @param Update                  $update
     * @param MessageEntity|array     $entity
     * @param bool                    $isTriggered
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     */
    public function execute($command, Update $update, $entity, bool $isTriggered = false): void
    {
        $command = $this->resolveCommand($command);

        $parser = Parser::parse($command)->setUpdate($update);

        if ($isTriggered) {
            $arguments = $entity;
        } else {
            $parser->setEntity($entity);
            $arguments = $parser->arguments();
        }

        $command->setCommandBus($this)->setBot($this->bot)->setUpdate($update)->setArguments($arguments);

        $requiredParamsNotProvided = $parser->requiredParamsNotProvided(array_keys($arguments));

        try {
            if ($requiredParamsNotProvided->isNotEmpty()) {
                throw TelegramCommandException::requiredParamsNotProvided($requiredParamsNotProvided);
            }

            $this->bot->getContainer()->call([$command, 'handle'], $arguments);
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
     *
     * @return CommandInterface
     */
    public function resolveCommand($command): CommandInterface
    {
        if (is_object($command)) {
            return $this->validateCommandClassInstance($command);
        }

        $command = array_change_key_case($this->commands)[strtolower($command)] ?? $command;

        if (!class_exists($command)) {
            throw TelegramCommandException::commandClassDoesNotExist($command);
        }

        try {
            $command = $this->bot->getContainer()->make($command);
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
     *
     * @return CommandInterface
     */
    protected function validateCommandClassInstance(object $command): CommandInterface
    {
        if ($command instanceof CommandInterface) {
            return $command;
        }

        throw TelegramCommandException::commandClassNotValid($command);
    }

    /**
     * Handle calls to missing methods.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$parameters);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
