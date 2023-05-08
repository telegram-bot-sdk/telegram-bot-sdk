<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Commands\Events\AttributeCommandFailed;
use Throwable;

final class AttributeCommand extends Command
{
    private $handler;

    protected string $description = '';

    public function handle(): void
    {
        if (! is_callable($this->handler)) {
            return;
        }

        $this->bot->getContainer()->call($this->handler, [
            'bot' => $this->getBot(),
            'update' => $this->getUpdate(),
        ]);
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
                    $this->handler,
                    $exception,
                    $this->getBot(),
                    $this->getUpdate()
                )
            );
    }

    public function setCommandHandler(callable $handler): self
    {
        $this->handler = $handler;

        return $this;
    }
}
