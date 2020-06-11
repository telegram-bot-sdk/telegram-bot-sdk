<?php

namespace Telegram\Bot;

use Illuminate\Contracts\Container\BindingResolutionException;
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
        return $this->config('use');
    }

    /**
     * Set the default bot name.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     *
     * @return static
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
     * @param string $name
     *
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     *
     * @return Bot
     */
    public function bot(string $name = null): Bot
    {
        $name ??= $this->getDefaultBotName();

        return $this->bots[$name] ??= $this->makeBot($name);
    }

    /**
     * Set a bot instance.
     *
     * @param Bot $bot
     *
     * @return static
     */
    public function setBot(Bot $bot): self
    {
        $name = $bot->getConfig()['bot'];
        $this->bots[$name] = $bot;

        return $this;
    }

    /**
     * Reconnect to the given bot.
     *
     * @param string $name
     *
     * @throws TelegramSDKException
     * @throws BindingResolutionException
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
     * @param string $name
     *
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     * @return Bot
     */
    protected function makeBot(string $name): Bot
    {
        return $this->getContainer()
            ->make(Bot::class, ['config' => $this->getBotConfig($name)])
            ->setContainer($this->getContainer());
    }

    /**
     * Magically pass methods to the default bot.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws TelegramSDKException
     * @throws BindingResolutionException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->bot(), $method, $parameters);
    }
}
