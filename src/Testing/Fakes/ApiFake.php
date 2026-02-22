<?php

namespace Telegram\Bot\Testing\Fakes;

use Exception;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Testing\Requests\TestRequest;
use Throwable;

class ApiFake extends Api
{
    /** @var array<array-key, TestRequest> */
    private array $requests = [];

    private bool $failWhenEmpty = false;

    private array $mockResponses = [];

    public function __construct(private array $responses = [])
    {
        parent::__construct('fake-token-for-testing');

        $this->mockResponses = $responses;
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function addResponses(array $responses): void
    {
        $this->responses = [...$this->responses, ...$responses];
    }

    public function failWhenEmpty(): self
    {
        $this->failWhenEmpty = true;

        return $this;
    }

    public function fakeCall(string $method, array $parameters = []): mixed
    {
        $this->requests[] = new TestRequest($method, $parameters);

        if ($this->failWhenEmpty && empty($this->mockResponses)) {
            throw new Exception('No fake responses left.');
        }

        if (! empty($this->mockResponses)) {
            $response = array_shift($this->mockResponses);
            if ($response instanceof Throwable) {
                throw $response;
            }

            return $response instanceof ResponseObject ? $response : ResponseObject::make($response);
        }

        // Default fake response
        return new ResponseObject(['ok' => true, 'result' => true]);
    }

    public function __call($method, $parameters)
    {
        // Forward all API method calls to the fakeCall method
        return $this->fakeCall($method, $parameters[0] ?? []);
    }
}
