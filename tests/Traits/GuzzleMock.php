<?php

namespace Telegram\Bot\Tests\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Telegram\Bot\Http\GuzzleHttpClient;

trait GuzzleMock
{
    /**
     * This collection contains a history of all requests and responses
     * sent using the client.
     *
     * @var array
     */
    protected array $history = [];

    public function getClient(array $responsesToQueue = []): GuzzleHttpClient
    {
        $client = $this->queuedResponseClient($responsesToQueue);

        return (new GuzzleHttpClient())->setClient($client);
    }

    protected function queuedResponseClient(array $responsesToQueue): Client
    {
        $this->history = [];
        $handler = HandlerStack::create(new MockHandler($responsesToQueue));
        $handler->push(Middleware::history($this->history));

        return new Client(['handler' => $handler]);
    }

    public function createResponse($data = [], $status_code = 200, $headers = []): Response
    {
        return new Response(
            $status_code,
            $headers,
            json_encode([
                            'ok'     => true,
                            'result' => $data,
                        ])
        );
    }

    public function createUpdate(array $data = [], $status_code = 200, $headers = []): Response
    {
        return new Response($status_code, $headers, json_encode($data));
    }

    public function createErrorResponse($error_code, $description, $status_code = 200, $headers = []): Response
    {
        return new Response(
            $status_code,
            $headers,
            json_encode([
                            'ok'          => false,
                            'error_code'  => $error_code,
                            'description' => "$description",
                        ])
        );
    }

    /**
     * @return Collection
     */
    public function getHistory(): Collection
    {
        return collect($this->history);
    }
}
