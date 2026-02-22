<?php

namespace Telegram\Bot\Testing\Fakes;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert as PHPUnit;
use Telegram\Bot\Api;
use Telegram\Bot\Bot;
use Telegram\Bot\Commands\Contracts\CallableContract;
use Telegram\Bot\Commands\Contracts\CommandContract;
use Telegram\Bot\Http\GuzzleHttpClient;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Requests\TestRequest;

class BotFake extends Bot
{
    /** @var array<string, array> Tracks commands processed by CommandHandler */
    private array $processedCommands = [];

    protected ?Container $container = null;

    private Api $api;

    public function __construct(array $responses = [])
    {
        parent::__construct([
            'bot' => 'fake',
            'token' => 'fake-token-for-testing',
            'global' => [
                'http' => [
                    'client' => GuzzleHttpClient::class,
                    'api_url' => 'https://api.telegram.org',
                    'file_url' => '',
                    'config' => [],
                    'async' => false,
                ],
            ],
            'listen' => [],
        ]);

        $this->setApi(new ApiFake($responses));
    }

    public function setApi(Api $api): self
    {
        $this->api = $api;

        return $this;
    }

    public function getApi(): Api
    {
        return $this->api;
    }

    /**
     * Provides a fluent interface for setting up commands for testing
     *
     *
     * @return $this
     */
    public function registerCommand(string $name, string|callable|CommandContract $handler): self
    {
        $this->getCommandHandler()->command($name, $handler);

        return $this;
    }

    public function command(
        string $command,
        array|string|callable|CommandContract $handler
    ): CommandContract|CallableContract {
        return $this->getCommandHandler()->command($command, $handler);
    }

    public function dispatchUpdateEvent(ResponseObject $response): ResponseObject
    {
        // In a fake, dispatching updates often directly leads to command processing for simplicity
        // or can be used to trigger mock event listeners.
        // For command testing, we can simply pass to command handler.
        return $this->getCommandHandler()->handler($response);
    }

    /**
     * Simulate webhook processing (alias for processCommand for clarity).
     */
    public function processUpdate(ResponseObject $update): static
    {
        $this->getCommandHandler()->processCommand($update);

        return $this;
    }

    public function addResponses(array $responses): void
    {
        $this->getApi()->addResponses($responses);
    }

    // Assertions Begin Here
    public function assertSent(string $method, array|callable|null $constraint = null): void
    {
        $allRequests = $this->getApi()->getRequests();
        $requestsForMethod = $this->sentByMethod($method);
        $sendMethods = array_unique(array_map(fn ($r) => $r->method(), $allRequests));

        // Primary check: Was the method called AT ALL?
        if (empty($requestsForMethod)) {
            $message = 'The expected ['.$method.'] request was not sent.';
            if (! empty($sendMethods)) {
                $message .= "\nMethods sent instead: ".implode(', ', $sendMethods);
            }
            PHPUnit::fail($message);
        }

        // If a constraint is provided, now filter by it.
        if ($constraint !== null) {
            $matchingRequests = $this->sent($method, $constraint);

            if (empty($matchingRequests)) {
                $expectedConstraint = is_array($constraint) ? json_encode($constraint, JSON_PRETTY_PRINT) : 'A custom callable constraint.';

                $message = sprintf(
                    'The [%s] request was sent, but no calls matched the provided constraint.'.
                    "\n\nRequests received for '%s':\n%s".
                    "\n\nExpected constraint:\n%s",
                    $method,
                    $method,
                    $this->formatRequestsForMessage($requestsForMethod),
                    $expectedConstraint
                );
                PHPUnit::fail($message);
            }
        }
    }

    private function formatRequestsForMessage(array $requests): string
    {
        $lines = [];
        foreach ($requests as $index => $request) {
            $params = $request->parameters();
            $paramsStr = json_encode($params, JSON_PRETTY_PRINT);
            $lines[] = '--- Request '.($index + 1)." ---\n{$paramsStr}";
        }

        return implode("\n", $lines);
    }

    public function assertNotSent(string $method, array|callable|null $constraint = null): void
    {
        $matching = $this->sent($method, $constraint);

        if (! empty($matching)) {
            $message = "The unexpected [{$method}] request was sent.";

            if ($constraint) {
                $message .= "\n\nMatching requests for '{$method}':\n".$this->formatRequestsForMessage($matching);
            } else {
                // No constraint: show all calls for this method
                $message .= "\n\nRequests sent for '{$method}':\n".$this->formatRequestsForMessage($matching);
            }

            PHPUnit::fail($message);
        }

        PHPUnit::assertCount(
            0,
            $matching,
            "The unexpected [{$method}] request was sent."
        );
    }

    public function assertSentTimes(string $method, int $times = 1): void
    {
        $count = count($this->sentByMethod($method));
        $allRequests = $this->getApi()->getRequests();
        $sendMethods = array_unique(array_map(fn ($r) => $r->method(), $allRequests));

        $message = sprintf(
            'The expected [%s] method was sent %d times instead of %d times.',
            $method,
            $count,
            $times,
        );

        if ($count !== $times && ! empty($sendMethods)) {
            $message .= "\nMethods sent instead: ".implode(', ', $sendMethods);
        }

        PHPUnit::assertSame($times, $count, $message);
    }

    public function assertNothingSent(): void
    {
        $allRequests = $this->getApi()->getRequests();

        if (! empty($allRequests)) {
            $methodNames = array_unique(array_map(fn ($r) => $r->method(), $allRequests));
            $methodsList = implode(', ', $methodNames);

            $message = "Expected no requests to be sent, but the following were sent:\n";
            $message .= "Methods sent: {$methodsList}\n\n";
            $message .= $this->formatRequestsForMessage($allRequests);

            PHPUnit::fail($message);
        }

        PHPUnit::assertEmpty($allRequests, 'Expected no requests to be sent, but some were.');
    }

    public function assertMessageSent(string $text, ?string $chatId = null): void
    {
        $this->assertSent('sendMessage', function (array $params) use ($text, $chatId) {
            $actualText = $params['text'] ?? '';
            $textMatches = ($actualText === $text);
            $chatIdMatches = $chatId ? ((string) ($params['chat_id'] ?? '') === $chatId) : true;

            return $textMatches && $chatIdMatches;
        });
    }

    public function assertMessageContains(string $text, ?string $chatId = null): void
    {
        $this->assertSent('sendMessage', function (array $params) use ($text, $chatId) {
            $actualText = $params['text'] ?? '';
            $textMatches = Str::contains($actualText, $text);
            $chatIdMatches = $chatId ? ((string) ($params['chat_id'] ?? '') === $chatId) : true;

            return $textMatches && $chatIdMatches;
        });
    }

    public function assertMessageSentCount(int $count): void
    {
        PHPUnit::assertSame(
            $count,
            count($this->sentByMethod('sendMessage')), // Directly count all 'sendMessage' calls
            'The sendMessage method was called '.count($this->sentByMethod('sendMessage'))." times instead of {$count} times."
        );
    }

    public function assertCommandProcessed(string $commandName, ?callable $callback = null): void
    {
        $this->assertCommandHandledCondition(
            $commandName,
            $callback,
            true,
            "The expected [{$commandName}] command was not handled."
        );
    }

    public function assertCommandNotProcessed(string $commandName, ?callable $callback = null): void
    {
        $this->assertCommandHandledCondition(
            $commandName,
            $callback,
            false,
            "The unexpected [{$commandName}] command was handled."
        );
    }

    protected function assertCommandHandledCondition(string $commandName, ?callable $callback, bool $shouldBeHandled, string $failMessage): void
    {
        $matchingCommands = array_filter($this->processedCommands,
            function ($commandRecord) use ($commandName, $callback) {
                if ($commandRecord['name'] !== strtolower($commandName)) {
                    return false;
                }
                if ($callback === null) {
                    return true;
                }

                return $callback($commandRecord['arguments']);
            });

        if ($shouldBeHandled) {
            PHPUnit::assertNotSame([], $matchingCommands, $failMessage);
        } else {
            PHPUnit::assertSame([], $matchingCommands, $failMessage);
        }
    }

    public function assertNoCommandsProcessed(): void
    {
        $count = count($this->processedCommands);

        PHPUnit::assertSame(
            0,
            $count,
            "Expected no commands to be handled, but {$count} command(s) were processed."
        );
    }

    private function sent(string $method, array|callable|null $constraint = null): array
    {
        $requestsByMethod = $this->sentByMethod($method); // NEW: Get filtered requests first

        // If no constraint, return all requests for this method
        if ($constraint === null) {
            return $requestsByMethod;
        }

        // Default callback if constraint is an array - this is where the array logic comes in
        $callback = fn (array $params): bool => (new Collection($constraint))->every(function ($value, $key) use (
            $params
        ) {
            // Using array_key_exists for strictness, but allowing null values to match if key exists and is null.
            return array_key_exists($key, $params) && $params[$key] === $value;
        });

        if (is_callable($constraint)) {
            $callback = $constraint;
        }

        return array_filter($requestsByMethod, fn (TestRequest $request) => $callback($request->parameters()));
    }

    /**
     * @return array<array-key, TestRequest>
     */
    private function sentByMethod(string $method): array
    {
        return array_filter($this->getApi()->getRequests(),
            fn (TestRequest $request): bool => $request->method() === $method);
    }

    public function recordCommandHandled(string $commandName, array $arguments = []): void
    {
        $this->processedCommands[] = [
            'name' => strtolower($commandName),
            'arguments' => $arguments,
        ];
    }

    public function getProcessedCommands(string|array|null $commandNames = null): array
    {
        if ($commandNames === null) {
            return $this->processedCommands;
        }

        $filterNames = is_array($commandNames)
            ? array_map('strtolower', $commandNames)
            : [strtolower($commandNames)];

        return array_filter(
            $this->processedCommands,
            fn ($record) => in_array($record['name'], $filterNames, true)
        );
    }

    private function isEmpty(): bool
    {
        return $this->responses === [];
    }

    public function bot(?string $string = null): static
    {
        return $this;
    }

    public function failWhenEmpty(): static
    {
        $this->getApi()->failWhenEmpty();

        return $this;
    }

    public function __call($method, $parameters)
    {
        // If it's one of our assertion methods, let them run.
        if (method_exists($this, $method) && str_starts_with($method, 'assert')) {
            return call_user_func_array([$this, $method], $parameters);
        }

        // Proxy all other calls to ApiFake's fakeCall method to avoid hitting real API methods
        return $this->getApi()->fakeCall($method, $parameters[0] ?? []);
    }
}
