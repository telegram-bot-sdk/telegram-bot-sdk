<?php

namespace Telegram\Bot\Events;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Events\Dispatcher;
use Telegram\Bot\Traits\HasContainer;

/**
 * InteractsWithEvents.
 */
trait InteractsWithEvents
{
    use HasContainer;

    /** @var DispatcherContract|null Events Dispatcher */
    protected ?DispatcherContract $dispatcher = null;

    /**
     * Determine if Events Dispatcher is set.
     */
    public function hasDispatcher(): bool
    {
        return $this->dispatcher !== null;
    }

    /**
     * Get the Events Dispatcher.
     */
    public function getDispatcher(): DispatcherContract
    {
        return $this->dispatcher ??= new Dispatcher($this->getContainer());
    }

    /**
     * Set the Events Dispatcher.
     *
     * @param  DispatcherContract  $dispatcher instance
     * @return $this
     */
    public function setDispatcher(DispatcherContract $dispatcher): self
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }
}
