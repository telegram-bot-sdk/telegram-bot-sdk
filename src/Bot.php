<?php

namespace Telegram\Bot;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Addon\AddonManager;
use Telegram\Bot\Commands\Listeners\ProcessCommand;
use Telegram\Bot\Contracts\HttpClientInterface;
use Telegram\Bot\Events\EventFactory;
use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Http\GuzzleHttpClient;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\HasConfig;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class Bot
 *
 * @mixin Api
 */
class Bot
{
    use Macroable {
        __call as macroCall;
    }

    use HasConfig;
    use HasContainer;

    protected Api $api;
    protected EventFactory $eventFactory;
    protected array $listeners;

    /**
     * Bot constructor.
     *
     * @param array $config
     *
     * @throws TelegramSDKException
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->api = new Api($this->config('token'));
        $this->setHttpClientHandler($this->config('global.http.client', GuzzleHttpClient::class));
        $this->api->setBaseApiUrl($this->config('global.http.api_url', 'https://api.telegram.org'));
        $this->api->setHttpClientConfig($this->config('global.http.config', []));
        $this->api->setAsyncRequest($this->config('global.http.async', false));

        $this->eventFactory = new EventFactory();

        if ($this->hasConfig('listen')) {
            $this->eventFactory->setListeners($this->config('listen'));
            $this->onUpdate(ProcessCommand::class);
            $this->eventFactory->registerListeners();
        }

        AddonManager::loadAddons($this);
    }

    /**
     * Get Api Instance.
     *
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * Set Api Instance.
     *
     * @param Api $api
     *
     * @return static
     */
    public function setApi(Api $api): self
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get Event Factory.
     *
     * @return EventFactory
     */
    public function getEventFactory(): EventFactory
    {
        return $this->eventFactory;
    }

    /**
     * Set Event Factory.
     *
     * @param EventFactory $eventFactory
     *
     * @return static
     */
    public function setEventFactory(EventFactory $eventFactory): self
    {
        $this->eventFactory = $eventFactory;

        return $this;
    }

    /**
     * Adds a listener to be notified when an update is received.
     *
     * @param Closure|string $listener
     *
     * @return static
     */
    public function onUpdate($listener): self
    {
        $this->eventFactory->listen(UpdateEvent::NAME, $listener);

        return $this;
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param string|array   $events
     * @param Closure|string $listener
     *
     * @return static
     */
    public function on($events, $listener): self
    {
        $this->eventFactory->listen($events, $listener);

        return $this;
    }

    /**
     * Listen for inbound updates using either webhook or polling method.
     * Dispatches event when an inbound update is received.
     *
     * @param bool  $webhook
     * @param array $params
     *
     * @throws TelegramSDKException
     *
     * @return Update|Update[]
     */
    public function listen(bool $webhook = false, array $params = [])
    {
        return $webhook ? $this->useWebHook() : $this->useGetUpdates($params);
    }

    /**
     * Process the update object for a command from your webhook.
     *
     * @return Update
     */
    protected function useWebHook(): Update
    {
        $update = $this->api->getWebhookUpdate();

        return $this->dispatchUpdateEvent($update);
    }

    /**
     * Process the update object using the getUpdates method.
     *
     * @param array $params
     *
     * @throws TelegramSDKException
     *
     * @return Update[]
     */
    protected function useGetUpdates(array $params = []): array
    {
        $updates = $this->api->getUpdates($params);

        $processedUpdates = [];
        $highestId = -1;
        foreach ($updates as $update) {
            $highestId = $update->update_id;
            $processedUpdates[] = $this->dispatchUpdateEvent($update);
        }

        // An update is considered confirmed as soon as getUpdates is called with an offset higher than it's update_id.
        if ($highestId !== -1) {
            $this->api->confirmUpdate($highestId);
        }

        return $processedUpdates;
    }

    /**
     * Dispatch Update Event.
     *
     * @param Update $update
     *
     * @return Update
     */
    public function dispatchUpdateEvent(Update $update): Update
    {
        $event = new UpdateEvent($this, $update);

        $this->eventFactory->dispatch(UpdateEvent::NAME, $event);
        $this->eventFactory->dispatch($update->objectType(), $event);

        if (null !== $update->getMessage()->objectType()) {
            $this->eventFactory->dispatch($update->objectType() . '.' . $update->getMessage()->objectType(), $event);
        }

        return $event->update;
    }

    /**
     * Set the HTTP Client Handler.
     *
     * @param string|HttpClientInterface $handler
     *
     * @throws TelegramSDKException
     *
     * @return static
     */
    public function setHttpClientHandler($handler): self
    {
        try {
            $client = is_string($handler) ? $this->getContainer()->make($handler) : $handler;

            $this->api->setHttpClientHandler($client);
        } catch (BindingResolutionException $e) {
            throw TelegramSDKException::httpClientNotInstantiable($handler, $e);
        }

        return $this;
    }

    /**
     * Magically pass methods to the api.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->api->{$method}(...$parameters);
    }
}
