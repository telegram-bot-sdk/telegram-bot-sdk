<?php

namespace Telegram\Bot;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class BotsManager.
 *
 * @mixin Api
 */
class BotsManager
{
    use HasContainer;

    /** @var array The config instance. */
    protected array $config;

    /** @var Api[] The active bot instances. */
    protected array $bots = [];

    /**
     * TelegramManager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Return all of the created bots.
     *
     * @return Api[]
     */
    public function getBots(): array
    {
        return $this->bots;
    }

    /**
     * Get the default bot name.
     *
     * @return string|null
     */
    public function getDefaultBotName(): ?string
    {
        return $this->getConfig('default');
    }

    /**
     * Set the default bot name.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @return BotsManager
     */
    public function setDefaultBot(string $name): self
    {
        Arr::set($this->config, 'default', $name);

        $this->reconnect($name);

        return $this;
    }

    /**
     * Get a bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @return Api
     */
    public function bot(string $name = null): Api
    {
        $name ??= $this->getDefaultBotName();

        return $this->bots[$name] ??= $this->makeBot($name);
    }

    /**
     * Reconnect to the given bot.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @return Api
     */
    public function reconnect(string $name = null): Api
    {
        $this->disconnect($name);

        return $this->bot($name);
    }

    /**
     * Disconnect from the given bot.
     *
     * @param string $name
     *
     * @return BotsManager
     */
    public function disconnect(string $name = null): self
    {
        $name ??= $this->getDefaultBotName();
        unset($this->bots[$name]);

        return $this;
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @return Api
     */
    protected function makeBot(string $name): Api
    {
        $config = $this->getBotConfig($name);

        $telegram = new Api(
            data_get($config, 'token'),
            $this->getConfig('async_requests', false),
            $this->getConfig('http_client_handler', null)
        );

        $telegram->setContainer($this->getContainer());

        $commands = $this->buildCommandsList(data_get($config, 'commands', []));

        // Register Commands
        $telegram->addCommands($commands);

        return $telegram;
    }

    /**
     * Get the configuration for a bot.
     *
     * @param string|null $name
     *
     * @throws TelegramSDKException
     * @return array
     */
    public function getBotConfig(string $name = null): array
    {
        $name ??= $this->getDefaultBotName();

        $config = Collection::make($this->getConfig('bots'))->get($name, null);

        if (!$config) {
            throw TelegramSDKException::botNotConfigured($name);
        }

        $config['bot'] = $name;

        return $config;
    }

    /**
     * Get the specified configuration value for Telegram.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Builds the list of commands for the given commands array.
     *
     * @param array $commands
     *
     * @throws TelegramSDKException
     * @return array An array of commands which includes global and bot specific commands.
     */
    protected function buildCommandsList(array $commands): array
    {
        $globalCommands = $this->getConfig('commands', []);
        $parsedCommands = $this->parseCommands($commands);

        $uniqueCommands = array_unique(array_merge($globalCommands, $parsedCommands));

        // Any command without a name associated with it will force the unique list to have an index key of 0.
        if (isset($uniqueCommands[0])) {
            throw new TelegramSDKException('A command in your config file did not have a name associated with the class.');
        }

        return $uniqueCommands;
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
        $commandGroups = $this->getConfig('command_groups');
        $sharedCommands = $this->getConfig('shared_commands');

        return Collection::make($commands)
            ->flatMap(function ($command, $name) use ($commandGroups, $sharedCommands) {
                // If the command is a group, we'll parse through the group of commands
                // and resolve the full class name.
                if (isset($commandGroups[$command])) {
                    return $this->parseCommands($commandGroups[$command]);
                }

                // If this command is actually a shared command, we'll extract the full
                // class name out of the command list now.
                if (isset($sharedCommands[$command])) {
                    $name = $command;
                    $command = $sharedCommands[$command];
                }

                return [$name => $command];
            })->all();
    }

    /**
     * Magically pass methods to the default bot.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws TelegramSDKException
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->bot()->{$method}(...$parameters);
    }
}
