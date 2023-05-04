<?php

namespace Telegram\Bot\Commands;

use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Telegram\Bot\Bot;
use Telegram\Bot\Events\CommandNotFoundEvent;
use Telegram\Bot\Exceptions\TelegramCommandException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\HasBot;

class CommandBus
{
    use HasBot;

    /** @var string|CommandInterface[] Holds all commands. */
    protected array $commands = [];

    /**
     * Instantiate Command Bus.
     */
    public function __construct(Bot $bot = null)
    {
        $this->bot = $bot;
    }

    /**
     * Returns the list of commands.
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Add a list of commands.
     *
     * @param  string|CommandInterface[]  $commands
     * @return $this
     */
    public function addCommands(string|array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * Add a command to the commands list.
     *
     * @param  string  $command      Command name.
     * @param  string|CommandInterface  $commandClass Either an object or full path to the command class.
     * @return $this
     */
    public function addCommand(string $command, string|CommandInterface $commandClass): self
    {
        $this->commands[$command] = $commandClass;

        return $this;
    }

    /**
     * Remove a command from the list.
     *
     * @param  string  $name Command name.
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
     */
    public function parseCommand(string $text, int $offset, int $length): string
    {
        if (blank($text)) {
            throw new InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        return Parser::between(mb_substr($text, $offset, $length, 'UTF-8'), '/', '@');
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     */
    public function handler(ResponseObject $update): ResponseObject
    {
        if (Validator::hasCommand($update)) {
            Entity::from($update)
                ->commandEntities()
                ->each(fn ($entity) => $this->process($update, $entity));
        }

        return $update;
    }

    /**
     * Execute a bot command from the update text.
     *
     * @throws TelegramSDKException
     */
    protected function process(ResponseObject $update, $entity): void
    {
        $command = $this->parseCommand(
            Entity::from($update)->text(),
            $entity['offset'],
            $entity['length']
        );

        $this->execute($command, $update, $entity);
    }

    /**
     * Execute the command.
     *
     * @throws TelegramCommandException
     * @throws TelegramSDKException
     */
    public function execute(CommandInterface|string $commandName, ResponseObject $update, array $entity, bool $isTriggered = false): void
    {
        $command = $this->resolveCommand($commandName, $update);

        $parser = Parser::parse($command)->setUpdate($update);

        if ($isTriggered) {
            $arguments = $entity;
        } else {
            $parser->setEntity($entity);
            $arguments = $parser->arguments();
        }

        $command
            ->setCommandBus($this)
            ->setBot($this->bot)
            ->setUpdate($update)
            ->setName($commandName)
            ->setArguments($arguments);

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
     * @throws TelegramCommandException
     */
    public function resolveCommand(CommandInterface|string $command, ?ResponseObject $update = null): CommandInterface
    {
        if (is_object($command)) {
            return $this->validateCommandClassInstance($command);
        }

        $command = array_change_key_case($this->commands)[strtolower($command)] ?? $command;

        if (! class_exists($command)) {
            $this->dispatchCommandNotFoundEvent($command, $update);

            if (array_key_exists('help', $this->commands)) {
                $command = $this->commands['help'];
            } else {
                throw TelegramCommandException::commandClassDoesNotExist($command);
            }
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
     *
     * @throws TelegramCommandException
     */
    protected function validateCommandClassInstance(object $command): CommandInterface
    {
        if ($command instanceof CommandInterface) {
            return $command;
        }

        throw TelegramCommandException::commandClassNotValid($command);
    }

    private function dispatchCommandNotFoundEvent(string $command, ?ResponseObject $update): void
    {
        $this->getBot()?->getEventFactory()
            ->dispatch(
                CommandNotFoundEvent::NAME,
                new CommandNotFoundEvent($command, $this->getBot(), $update)
            );
    }
}
