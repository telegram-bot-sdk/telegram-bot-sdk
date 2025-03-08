<?php

namespace Telegram\Bot\Testing;

use Exception;
use PHPUnit\Framework\Assert as PHPUnit;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Requests\TestRequest;
use Throwable;

final class BotFake
{
    /**
     * @var array<array-key, TestRequest>
     */
    private array $requests = [];

    private bool $failWhenEmpty = false;

    /**
     * @param  array<array-key, string>  $responses
     */
    public function __construct(protected array $responses = []) {}

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
            $this->sent($method, $callback),
            [],
            "The expected [{$method}] request was not sent."
        );
    }

    private function assertSentTimes(string $method, int $times = 1): void
    {
        $count = count($this->sent($method));

        PHPUnit::assertSame(
            $times,
            $count,
            "The expected [{$method}] method was sent {$count} times instead of {$times} times."
        );
    }

    private function sent(string $method, ?callable $callback = null): array
    {
        if (! $this->hasSent($method)) {
            return [];
        }

        $callback = $callback ?: fn (): bool => true;

        return array_filter($this->methodsOf($method), fn (TestRequest $request) => $callback($request->parameters()));
    }

    private function hasSent(string $method): bool
    {
        return $this->methodsOf($method) !== [];
    }

    public function assertNotSent(string $method, ?callable $callback = null): void
    {
        PHPUnit::assertCount(
            0,
            $this->sent($method, $callback),
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
    private function methodsOf(string $method): array
    {
        return array_filter($this->requests, fn (TestRequest $request): bool => $request->method() === $method);
    }

    public function record(TestRequest $request): mixed
    {
        $this->requests[] = $request;

        if ($this->failWhenEmpty && $this->isEmpty()) {
            throw new Exception('No fake responses left.');
        }

        if (! $this->failWhenEmpty && $this->isEmpty()) {
            return new ResponseObject([
                'ok' => true,
                'result' => true,
            ]);
        }

        $response = array_shift($this->responses);

        if ($response instanceof Throwable) {
            throw $response;
        }

        return $response instanceof ResponseObject ? $response : ResponseObject::make($response);
    }

    public function __call(string $method, array $parameters)
    {
        return $this->record(new TestRequest($method, ...$parameters));
    }

    public function bot(?string $string = null): static
    {
        return $this;
    }

    private function isEmpty(): bool
    {
        return $this->responses === [];
    }

    public function failWhenEmpty(): static
    {
        $this->failWhenEmpty = true;

        return $this;
    }
}
