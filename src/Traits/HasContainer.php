<?php

namespace Telegram\Bot\Traits;

use Illuminate\Contracts\Container\Container;

/**
 * HasContainer.
 */
trait HasContainer
{
    /** @var Container IoC Container */
    protected ?Container $container;

    /**
     * Set the IoC Container.
     *
     * @param $container Container instance
     *
     * @return $this
     */
    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the IoC Container.
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Check if IoC Container has been set.
     *
     * @return bool
     */
    public function hasContainer(): bool
    {
        return $this->container !== null;
    }
}
