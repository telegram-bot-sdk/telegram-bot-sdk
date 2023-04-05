<?php

namespace Telegram\Bot\Events;

use Closure;
use Illuminate\Events\Dispatcher;

/**
 * Class EventFactory
 * @mixin Dispatcher
 */
class EventFactory
{
    use InteractsWithEvents;
    protected array $subscribers = [];

    /**
     * EventFactory constructor.
     */
    public function __construct(protected array $listens = [])
    {
    }

    /**
     * Get the events and handlers.
     */
    public function listens(): array
    {
        return $this->listens;
    }

    /**
     * Set the events and handlers.
     *
     *
     * @return static
     */
    public function setListeners(array $listeners): self
    {
        $this->listens = $listeners;

        return $this;
    }

    /**
     * Get subscribers.
     */
    public function subscribers(): array
    {
        return $this->subscribers;
    }

    /**
     * Add a subscriber.
     *
     *
     * @return static
     */
    public function setSubscriber(array $subscribe): self
    {
        $this->subscribers[] = $subscribe;

        return $this;
    }

    /**
     * Register listeners for events.
     */
    public function registerListeners(): void
    {
        $events = $this->listens();

        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                $this->listen($event, $listener);
            }
        }

        foreach ($this->subscribers as $subscriber) {
            $this->subscribe($subscriber);
        }
    }

    /**
     * Register an event listener with the dispatcher.
     *
     *
     * @return static
     */
    public function listen(string|array $events, Closure|string $listener): self
    {
        $this->getDispatcher()->listen($events, $listener);

        return $this;
    }

    /**
     * Register an event subscriber with the dispatcher.
     *
     * @param object|string $subscriber
     */
    public function subscribe($subscriber): void
    {
        $this->getDispatcher()->subscribe($subscriber);
    }

    /**
     * Dispatch an event and call the listeners.
     *
     * @param string|object $event
     * @param bool          $halt
     *
     */
    public function dispatch($event, mixed $payload = [], $halt = false): ?array
    {
        return $this->getDispatcher()->dispatch($event, $payload, $halt);
    }

    /**
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        return $this->getDispatcher()->{$method}(...$params);
    }
}
