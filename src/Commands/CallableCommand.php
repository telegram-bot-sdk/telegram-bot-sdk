<?php

namespace Telegram\Bot\Commands;

use Closure;
use Telegram\Bot\Commands\Contracts\CallableContract;
use Telegram\Bot\Commands\Events\CallableCommandFailed;
use Throwable;

final class CallableCommand extends Command implements CallableContract
{
    private $handler;

    private $failCallback = null;

    protected string $description = '';

    public function handle(): void
    {
        if (is_array($this->handler) && ! is_callable($this->handler)) {
            $this->handler[0] = $this->bot->getContainer()->make($this->handler[0]);
        }

        $this->bot->getContainer()->call($this->handler, [
            ...$this->getArguments(),
            'bot' => $this->getBot(),
            'update' => $this->getUpdate(),
        ]);
    }

    public function description(string $description): self
    {
        return $this->setDescription($description);
    }

    public function onFailure(string|array|callable $callback): self
    {
        $this->failCallback = (is_array($callback) || is_string($callback))
            ? $callback
            : Closure::bind($callback, $this, self::class);

        return $this;
    }

    /**
     * Triggered on failure.
     */
    public function failed(array $arguments, Throwable $exception): void
    {
        if ($this->failCallback) {
            $this->bot->getContainer()->call($this->failCallback, [
                'bot' => $this->getBot(),
                'update' => $this->getUpdate(),
                'exception' => $exception,
            ]);
        }

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

    public function getCommandHandler(): string|array|callable
    {
        return $this->handler;
    }
}
