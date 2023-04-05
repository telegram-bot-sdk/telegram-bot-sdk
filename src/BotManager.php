<?php

namespace Telegram\Bot;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\ForwardsCalls;
use Telegram\Bot\Traits\HasConfig;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class BotManager.
 *
 * @mixin Bot
 */
class BotManager
{
    use ForwardsCalls;
    use HasContainer;
    use HasConfig;

    /** @var Bot[] The active bot instances. */
    protected array $bots = [];

    /**
     * Bots Manager constructor.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Return all the created bots.
     *
     * @return Bot[]
     */
    public function getBots(): array
    {
        return $this->bots;
    }

    /**
     * Get the default bot name.
     */
    public function getDefaultBotName(): ?string
    {
        return $this->config('use');
    }

    /**
     * Set the default bot name.
     *
     *
     * @return static
     *
     * @throws TelegramSDKException
     */
    public function setDefaultBotName(string $name): self
    {
        $this->config(['use' => $name]);

        $this->reconnect($name);

        return $this;
    }

    /**
     * Get a bot instance.
     *
     *
     * @throws TelegramSDKException
     */
    public function bot(string $name = null): Bot
    {
        $name ??= $this->getDefaultBotName();

        return $this->bots[$name] ??= $this->makeBot($name);
    }

    /**
     * Reconnect to the given bot.
     *
     *
     * @throws TelegramSDKException
     */
    public function reconnect(string $name = null): Bot
    {
        $this->disconnect($name);

        return $this->bot($name);
    }

    /**
     * Disconnect from the given bot.
     *
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
     *
     * @throws TelegramSDKException
     */
    public function getBotConfig(string $name = null): array
    {
        $name ??= $this->getDefaultBotName();

        $config = $this->config("bots.{$name}");

        if (! $config) {
            throw TelegramSDKException::botNotConfigured($name);
        }

        $config['bot'] = $name;
        $config['global'] = $this->config();

        return $config;
    }

    /**
     * Make the bot instance.
     *
     *
     * @throws TelegramSDKException
     */
    protected function makeBot(string $name): Bot
    {
        return (new Bot($this->getBotConfig($name)))->setContainer($this->getContainer());
    }

    /**
     * Magically pass methods to the default bot.
     *
     *
     * @return mixed
     *
     * @throws TelegramSDKException
     */
    public function __call(string $method, array $parameters)
    {
        return $this->forwardCallTo($this->bot(), $method, $parameters);
    }
}
