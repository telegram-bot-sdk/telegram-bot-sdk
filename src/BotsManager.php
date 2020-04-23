<?php

namespace Telegram\Bot;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Http\GuzzleHttpClient;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class BotsManager.
 *
 * @mixin Api
 */
class BotsManager
{
    use HasContainer;

    /** @var array Config */
    protected array $config;

    /** @var Api[] The active bot instances. */
    protected array $bots = [];

    /**
     * Bots Manager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get or set configuration value for the Api.
     *
     * @param array|string|null $key
     * @param mixed             $default
     *
     * @return mixed
     */
    public function config($key = null, $default = null)
    {
        if (null === $key) {
            return $this->config;
        }

        if (is_array($key)) {
            foreach ($key as $name => $value) {
                Arr::set($this->config, $name, $value);
            }

            return true;
        }

        return Arr::get($this->config, $key, $default);
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
        return $this->config('default');
    }

    /**
     * Set the default bot name.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     *
     * @return static
     */
    public function setDefaultBotName(string $name): self
    {
        $this->config(['default' => $name]);

        $this->reconnect($name);

        return $this;
    }

    /**
     * Get a bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     *
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
     *
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
     * @return static
     */
    public function disconnect(string $name = null): self
    {
        $name ??= $this->getDefaultBotName();
        unset($this->bots[$name]);

        return $this;
    }

    /**
     * Get the configuration for a bot.
     *
     * @param string|null $name
     *
     * @throws TelegramSDKException
     *
     * @return array
     */
    public function getBotConfig(string $name = null): array
    {
        $name ??= $this->getDefaultBotName();

        $config = $this->config("bots.{$name}");

        if (!$config) {
            throw TelegramSDKException::botNotConfigured($name);
        }

        $config['bot'] = $name;

        return $config;
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     *
     * @return Api
     */
    protected function makeBot(string $name): Api
    {
        $config = $this->getBotConfig($name);

        $api = new Api(Arr::get($config, 'token'));
        $api->setContainer($this->getContainer())->setAsyncRequest($this->config('async_requests', false));

        $this->setHttpClientHandler($api);
        $this->registerCommands($config, $api);

        return $api;
    }

    /**
     * Set the HTTP Client Handler.
     *
     * @param Api $api
     *
     * @throws TelegramSDKException
     */
    protected function setHttpClientHandler(Api $api): void
    {
        $handler = $this->config('http_client_handler', GuzzleHttpClient::class);

        try {
            $client = is_string($handler) ? $this->getContainer()->make($handler) : $handler;

            $api->setHttpClientHandler($client);
        } catch (BindingResolutionException $e) {
            throw TelegramSDKException::httpClientNotInstantiable($handler, $e);
        }
    }

    /**
     * Register the commands.
     *
     * @param array $config
     * @param Api   $api
     *
     * @throws TelegramSDKException
     */
    protected function registerCommands(array $config, Api $api): void
    {
        $commands = $this->buildCommandsList(Arr::get($config, 'commands', []));

        // Register Commands
        $api->addCommands($commands);
    }

    /**
     * Builds the list of commands for the given commands array.
     *
     * @param array $commands
     *
     * @throws TelegramSDKException
     *
     * @return array An array of commands which includes global, shared and bot specific commands.
     */
    protected function buildCommandsList(array $commands): array
    {
        $unique = collect($this->config('commands', []))->merge($this->parseCommands($commands))->unique();

        // Any command without a name associated with it will force the unique list to have an index key of 0.
        if ($unique->has(0)) {
            throw TelegramSDKException::commandNameNotSet($unique->get(0));
        }

        return $unique->all();
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
        $groups = $this->config('command_groups');
        $shared = $this->config('shared_commands');

        return collect($commands)->flatMap(function ($command, $name) use ($groups, $shared) {
            // If the command is a group, we'll parse through the group of commands
            // and resolve the full class name.
            if (isset($groups[$command])) {
                return $this->parseCommands($groups[$command]);
            }

            // If this command is actually a shared command, we'll extract the full
            // class name out of the command list now.
            if (isset($shared[$command])) {
                $name = $command;
                $command = $shared[$command];
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
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->bot()->{$method}(...$parameters);
    }
}
