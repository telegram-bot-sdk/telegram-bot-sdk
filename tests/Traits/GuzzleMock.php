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
    protected $history = [];

    /**
     * @param array $responsesToQueue
     *
     * @return GuzzleHttpClient
     */
    public function getClient(array $responsesToQueue = [])
    {
        $client = $this->queuedResponseClient($responsesToQueue);

        return (new GuzzleHttpClient())->setClient($client);
    }

    /**
     * @param array $responsesToQueue
     *
     * @return Client
     */
    protected function queuedResponseClient(array $responsesToQueue)
    {
        $this->history = [];
        $handler = HandlerStack::create(new MockHandler($responsesToQueue));
        $handler->push(Middleware::history($this->history));

        return new Client(['handler' => $handler]);
    }

    /**
     * @param array|bool $data
     * @param int        $status_code
     * @param array      $headers
     *
     * @return Response
     */
    public function createResponse($data = [], $status_code = 200, $headers = [])
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

    public function fakeUpdate(array $data, $status_code = 200, $headers = [])
    {
        return new Response($status_code, $headers, json_encode($data));
    }

    /**
     * @return Collection
     */
    public function getHistory(): Collection
    {
        return collect($this->history);
    }

    protected function makeFakeServerErrorResponse($error_code, $description, $status_code = 200, $headers = [])
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

//    protected function makeFakeExceptionResponse($text, $uri)
//    {
//        return new RequestException($text, new Request('GET', $uri));
//    }
}
