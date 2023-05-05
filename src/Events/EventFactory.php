<?php

namespace Telegram\Bot\Events;

use Closure;
use Illuminate\Events\Dispatcher;

/**
 * Class EventFactory
 *
 * @mixin Dispatcher
 */
final class EventFactory
{
    use InteractsWithEvents;

    private array $subscribers = [];

    public function __construct(protected array $listens = [])
    {
    }

    public function listens(): array
    {
        return $this->listens;
    }

    public function setListeners(array $listeners): self
    {
        $this->listens = $listeners;

        return $this;
    }

    public function subscribers(): array
    {
        return $this->subscribers;
    }

    public function setSubscriber(array $subscribe): self
    {
        $this->subscribers[] = $subscribe;

        return $this;
    }

    public function registerListeners(): void
    {
        $events = $this->listens;

        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                $this->listen($event, $listener);
            }
        }

        foreach ($this->subscribers as $subscriber) {
            $this->subscribe($subscriber);
        }
    }

    public function listen(string|array $events, Closure|string $listener): self
    {
        $this->getDispatcher()->listen($events, $listener);

        return $this;
    }

    public function subscribe(object|string $subscriber): void
    {
        $this->getDispatcher()->subscribe($subscriber);
    }

    public function dispatch(object|string $event, mixed $payload = [], bool $halt = false): ?array
    {
        return $this->getDispatcher()->dispatch($event, $payload, $halt);
    }

    public function __call($method, $params)
    {
        return $this->getDispatcher()->{$method}(...$params);
    }
}
