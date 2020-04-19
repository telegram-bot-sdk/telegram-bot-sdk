<?php

namespace Telegram\Bot;

use Illuminate\Support\Arr;
use InvalidArgumentException;
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
     * Get the configuration for a bot.
     *
     * @param string|null $name
     *
     * @throws InvalidArgumentException
     * @return array
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
     * @throws TelegramSDKException
     * @return Api
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
     * @throws TelegramSDKException
     * @return Api
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
     * @throws TelegramSDKException
     * @return BotsManager
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
     * Make the bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @return Api
     */
    protected function makeBot($name): Api
    {
        $config = $this->getBotConfig($name);

        $telegram = new Api(
            data_get($config, 'token'),
            $this->getConfig('async_requests', false),
            $this->getConfig('http_client_handler', null)
        );

        $telegram->setContainer($this->container);

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
     * @throws TelegramSDKException
     * @return array An array of commands which includes global and bot specific commands.
     */
    protected function parseBotCommands(array $commands): array
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
     * @throws TelegramSDKException
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->bot()->{$method}(...$parameters);
    }
}
