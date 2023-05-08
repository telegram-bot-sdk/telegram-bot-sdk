<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Commands\Events\AttributeCommandFailed;
use Throwable;

final class AttributeCommand extends Command
{
    protected object|string $class;

    protected string $description = '';

    protected string $method;

    public function handle(): void
    {
        if (! is_object($this->class)) {
            return;
        }

        if(! method_exists($this->class, $this->method)) {
            return;
        }

        $this->class->{$this->method}($this->getBot(), $this->getUpdate());
    }

    /**
     * Triggered on failure.
     */
    public function failed(array $arguments, Throwable $exception): void
    {
        $this->getBot()?->getEventFactory()
            ->dispatch(
                AttributeCommandFailed::NAME,
                new AttributeCommandFailed(
                    $this->getName(),
                    $this->class,
                    $this->method,
                    $exception,
                    $this->getBot(),
                    $this->getUpdate()
                )
            );
    }

    public function setAttributeCaller(object|string $class, string $method): self
    {
        $this->class = is_object($class) ? $class : new $class();
        $this->method = $method;

        return $this;
    }
}
