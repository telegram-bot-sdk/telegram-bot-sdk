<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
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
     * @param string                  $command Either an object or full path to the command class.
     * @param CommandInterface|string $commandClass
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
     * @param $name
     *
     * @return $this
     */
    public function removeCommand($name): self
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

        $command = substr(
            $text,
            $offset + 1,
            $length - 1
        );

        // When in group - Ex: /command@MyBot
        if (Str::contains($command, '@') && Str::endsWith($command, ['bot', 'Bot'])) {
            $command = explode('@', $command);
            $command = $command[0];
        }

        return $command;
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
            $this->parseCommandsIn($message)->each(fn(array $botCommand) => $this->process($botCommand, $update));
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
            ->filter(fn($entity) => $entity['type'] === 'bot_command');
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
     * @param string $name
     * @param Update $update
     * @param array  $entity
     *
     * @return mixed
     * @throws TelegramSDKException
     */
    public function execute(string $name, Update $update, array $entity)
    {
        $command = $this->commands[$name] ?? collect($this->commands)->filter(
                fn($command) => $command instanceof $name
            )->first();

        if ($command === null) {
            return false;
        }

        return $this->resolveCommand($command)->make($this->telegram, $update, $entity);
    }

    /**
     * @param $command
     *
     * @return object
     * @throws TelegramSDKException
     */
    public function resolveCommand($command)
    {
        $command = $this->makeCommandObj($command);

        if (!($command instanceof CommandInterface)) {
            throw new TelegramSDKException(
                sprintf(
                    'Command class "%s" should be an instance of "Telegram\Bot\Commands\CommandInterface"',
                    get_class($command)
                )
            );
        }

        return $command;
    }

    /**
     * @param $command
     *
     * @return object
     * @throws TelegramSDKException
     */
    protected function makeCommandObj($command)
    {
        if (is_object($command)) {
            return $command;
        }

        if (!class_exists($command)) {
            throw new TelegramSDKException(
                sprintf(
                    'Command class "%s" not found! Please make sure the class exists.',
                    $command
                )
            );
        }

        if ($this->telegram->hasContainer()) {
            return $this->buildDependencyInjectedAnswer($command);
        }

        return new $command();
    }
}
