<?php

namespace Telegram\Bot;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class BotsManager.
 *
 * @mixin Api
 */
class BotsManager
{
    /** @var array The config instance. */
    protected array $config;

    /** @var Container The container instance. */
    protected Container $container;

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
     * Set the IoC Container.
     *
     * @param $container Container instance
     *
     * @return BotsManager
     */
    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the configuration for a bot.
     *
     * @param string|null $name
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function getBotConfig($name = null): array
    {
        $name ??= $this->getDefaultBotName();

        $bots = collect($this->getConfig('bots'));

        if (!$config = $bots->get($name, null)) {
            throw new InvalidArgumentException("Bot [$name] not configured.");
        }

        $config['bot'] = $name;

        return $config;
    }

    /**
     * Get a bot instance.
     *
     * @param string $name
     *
     * @return Api
     * @throws TelegramSDKException
     */
    public function bot($name = null): Api
    {
        $name ??= $this->getDefaultBotName();

        return $this->bots[$name] ??= $this->makeBot($name);
    }

    /**
     * Reconnect to the given bot.
     *
     * @param string $name
     *
     * @return Api
     * @throws TelegramSDKException
     */
    public function reconnect($name = null): Api
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
    public function disconnect($name = null): self
    {
        $name ??= $this->getDefaultBotName();
        unset($this->bots[$name]);

        return $this;
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
     * @return BotsManager
     * @throws TelegramSDKException
     */
    public function setDefaultBot($name): self
    {
        Arr::set($this->config, 'default', $name);

        $this->reconnect($name);

        return $this;
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
     * De-duplicate an array.
     *
     * @param array $array
     *
     * @return array
     */
    protected function deduplicateArray(array $array): array
    {
        return array_unique($array);
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @return Api
     * @throws TelegramSDKException
     */
    protected function makeBot($name): Api
    {
        $config = $this->getBotConfig($name);

        $telegram = new Api(
            data_get($config, 'token'),
            $this->getConfig('async_requests', false),
            $this->getConfig('http_client_handler', null)
        );

        // Check if DI needs to be enabled for Commands
        if (isset($this->container) && $this->getConfig('resolve_command_dependencies', false)) {
            $telegram->setContainer($this->container);
        }

        $commands = $this->parseBotCommands(data_get($config, 'commands', []));

        // Register Commands
        $telegram->addCommands($commands);

        return $telegram;
    }

    /**
     * Builds the list of commands for the given commands array.
     *
     * @param array $commands
     *
     * @return array An array of commands which includes global and bot specific commands.
     */
    public function parseBotCommands(array $commands): array
    {
        $globalCommands = $this->getConfig('commands', []);
        $parsedCommands = $this->parseCommands($commands);

        return $this->deduplicateArray(array_merge($globalCommands, $parsedCommands));
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

        return collect($commands)
            ->flatMap(
                function ($command, $name) use ($commandGroups, $sharedCommands) {
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
                }
            )->all();
    }

    /**
     * Magically pass methods to the default bot.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     * @throws TelegramSDKException
     */
    public function __call($method, $parameters)
    {
        return $this->bot()->{$method}(...$parameters);
    }
}
