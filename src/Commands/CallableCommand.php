<?php

namespace Telegram\Bot\Commands;

use Closure;
use Telegram\Bot\Commands\Events\CallableCommandFailed;
use Throwable;

final class CallableCommand extends Command
{
    private $handler;

    protected string $description = '';

    public function handle(): void
    {
        if (is_array($this->handler) && ! is_callable($this->handler)) {
            $this->handler[0] = $this->bot->getContainer()->make($this->handler[0]);
        }

        $this->bot->getContainer()->call($this->handler, [
            'bot' => $this->getBot(),
            'update' => $this->getUpdate(),
        ]);
    }

    public function description(string $description): self
    {
        return $this->setDescription($description);
    }

    /**
     * Triggered on failure.
     */
    public function failed(array $arguments, Throwable $exception): void
    {
        $this->getBot()?->getEventFactory()
            ->dispatch(
                CallableCommandFailed::NAME,
                new CallableCommandFailed(
                    $this->getName(),
                    $this->handler,
                    $exception,
                    $this->getBot(),
                    $this->getUpdate()
                )
            );
    }

    public function setCommandHandler(string|array|callable $handler): self
    {
        $this->handler = (is_array($handler) || is_string($handler))
            ? $handler
            : Closure::bind($handler, $this, self::class);

        return $this;
    }
}
