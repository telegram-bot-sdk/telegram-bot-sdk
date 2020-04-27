<?php

namespace Telegram\Bot;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\HasConfig;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class BotsManager.
 *
 * @mixin Api
 */
class BotsManager
{
    use HasContainer;
    use HasConfig;

    /** @var Bot[] The active bot instances. */
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
     * Return all of the created bots.
     *
     * @return Bot[]
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
     * @return Bot
     */
    public function bot(string $name = null): Bot
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
     * @return Bot
     */
    public function reconnect(string $name = null): Bot
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
        $config['global'] = $this->config();

        // Merge global config with bot config.
        return array_merge([
            'http_client_handler' => $this->config('http_client_handler'),
            'async_requests'      => $this->config('async_requests'),
        ], $config);
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     *
     * @return Bot
     */
    protected function makeBot(string $name): Bot
    {
        $config = $this->getBotConfig($name);

        $bot = new Bot($config);
        $bot->setContainer($this->getContainer());

        return $bot;
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
