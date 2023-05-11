<?php

namespace Telegram\Bot\Testing;

use Exception;
use PHPUnit\Framework\Assert as PHPUnit;
use Telegram\Bot\Testing\Requests\TestRequest;
use Throwable;

class BotFake
{
    /**
     * @var array<array-key, TestRequest>
     */
    private array $requests = [];

    /**
     * @param  array<array-key, string>  $responses
     */
    public function __construct(protected array $responses = [])
    {
    }

    public function addResponses(array $responses): void
    {
        $this->responses = [...$this->responses, ...$responses];
    }

    public function assertSent(string $method, $callback = null): void
    {
        if (is_int($callback)) {
            $this->assertSentTimes($method, $callback);

            return;
        }

        PHPUnit::assertNotSame(
            $this->sent($method, $callback), [], "The expected [{$method}] request was not sent."
        );
    }

    protected function assertSentTimes(string $method, int $times = 1): void
    {
        $count = count($this->sent($method));

        PHPUnit::assertSame(
            $times, $count,
            "The expected [{$method}] method was sent {$count} times instead of {$times} times."
        );
    }

    protected function sent(string $method, callable $callback = null): array
    {
        if (! $this->hasSent($method)) {
            return [];
        }

        $callback = $callback ?: fn (): bool => true;

        return array_filter($this->methodsOf($method), fn (TestRequest $request) => $callback($request->parameters()));
    }

    protected function hasSent(string $method): bool
    {
        return $this->methodsOf($method) !== [];
    }

    public function assertNotSent(string $method, callable $callback = null): void
    {
        PHPUnit::assertCount(
            0, $this->sent($method, $callback),
            "The unexpected [{$method}] request was sent."
        );
    }

    public function assertNothingSent(): void
    {
        $methodNames = implode(
            separator: ', ',
            array: array_map(fn (TestRequest $request): string => $request->method(), $this->requests)
        );

        PHPUnit::assertEmpty($this->requests, 'The following requests were sent unexpectedly: '.$methodNames);
    }

    /**
     * @return array<array-key, TestRequest>
     */
    protected function methodsOf(string $method): array
    {
        return array_filter($this->requests, fn (TestRequest $request): bool => $request->method() === $method);
    }

    public function record(TestRequest $request): mixed
    {
        $this->requests[] = $request;

        $response = array_shift($this->responses);

        if (is_null($response)) {
            throw new Exception('No fake responses left.');
        }

        if ($response instanceof Throwable) {
            throw $response;
        }

        return $response;
    }

    public function __call(string $method, array $parameters)
    {
        return $this->record(new TestRequest($method, ...$parameters));
    }
}
