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
use Telegram\Bot\Helpers\Update;
use Telegram\Bot\Http\GuzzleHttpClient;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\ForwardsCalls;
use Telegram\Bot\Traits\HasConfig;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class Bot
 *
 * @mixin Api
 */
final class Bot
{
    use ForwardsCalls;
    use Macroable {
        Macroable::__call as macroCall;
    }
    use HasConfig;
    use HasContainer;

    private readonly string $name;

    private Api $api;

    private EventFactory $eventFactory;

    /**
     * Bot constructor.
     *
     * @throws TelegramSDKException
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
        $this->name = $config['bot'];

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
     * Get name of the bot (specified in a config).
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Api Instance.
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * Set Api Instance.
     */
    public function setApi(Api $api): self
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get Event Factory.
     */
    public function getEventFactory(): EventFactory
    {
        return $this->eventFactory;
    }

    /**
     * Set Event Factory.
     */
    public function setEventFactory(EventFactory $eventFactory): self
    {
        $this->eventFactory = $eventFactory;

        return $this;
    }

    /**
     * Adds a listener to be notified when an update is received.
     */
    public function onUpdate(Closure|string $listener): self
    {
        $this->eventFactory->listen(UpdateEvent::NAME, $listener);

        return $this;
    }

    /**
     * Register an event listener with the dispatcher.
     */
    public function on(string|array $events, Closure|string $listener): self
    {
        $this->eventFactory->listen($events, $listener);

        return $this;
    }

    /**
     * Listen for inbound updates using either webhook or polling method.
     * Dispatches event when an inbound update is received.
     *
     * @return ResponseObject|ResponseObject[]
     */
    public function listen(bool $webhook = false, array $params = []): ResponseObject|array
    {
        return $webhook ? $this->useWebHook() : $this->useGetUpdates($params);
    }

    /**
     * Process the update object for a command from your webhook.
     */
    private function useWebHook(): ResponseObject
    {
        $update = $this->api->getWebhookUpdate();

        return $this->dispatchUpdateEvent($update);
    }

    /**
     * Process the update object using the getUpdates method.
     *
     * @return ResponseObject[]
     */
    private function useGetUpdates(array $params = []): array
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
     */
    public function dispatchUpdateEvent(ResponseObject $response): ResponseObject
    {
        $event = new UpdateEvent($this, $response);

        $update = Update::find($response);

        $this->eventFactory->dispatch(UpdateEvent::NAME, $event);
        $this->eventFactory->dispatch($update->type(), $event);

        if (null !== $update->messageType()) {
            $this->eventFactory->dispatch($update->type().'.'.$update->messageType(), $event);
        }

        return $event->update;
    }

    /**
     * Set the HTTP Client Handler.
     *
     *
     *
     * @throws TelegramSDKException
     */
    public function setHttpClientHandler(string|HttpClientInterface $handler): self
    {
        try {
            $client = is_string($handler) ? $this->getContainer()->make($handler) : $handler;

            $this->api->setHttpClientHandler($client);
        } catch (BindingResolutionException $e) {
            throw TelegramSDKException::httpClientNotInstantiable($handler, $e);
        }

        return $this;
    }

    public function __call($method, $parameters)
    {
        if (self::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardCallTo($this->api, $method, $parameters);
    }
}
