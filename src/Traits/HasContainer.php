<?php

namespace Telegram\Bot\Traits;

use Illuminate\Contracts\Container\Container;

/**
 * HasContainer.
 */
trait HasContainer
{
    /** @var Container|null IoC Container */
    protected ?Container $container = null;

    /**
     * Determine if IoC Container is set.
     *
     * @return bool
     */
    public function hasContainer(): bool
    {
        return $this->container !== null;
    }

    /**
     * Get the IoC Container.
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container ?? \Illuminate\Container\Container::getInstance();
    }

    /**
     * Set the IoC Container.
     *
     * @param Container $container instance
     *
     * @return $this
     */
    public function setContainer(Container $container): self
    {
        $this->container = $container;

        return $this;
    }
}
